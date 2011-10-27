<?php

// ------------------------------------------------------------
// api.php
// Provides functions to interface with the Capture and CaptureUI servers.
// Requires the configuration settings provided by config.php, so config.php
// must be loaded before calling the functions in this file.
//
// The functions in this file manipulate a PHP session variable called
// capture_session, which is an array with the following fields:
//  - access_token    - the OAuth access token
//  - expiration_time - when the token expires (same format as time())
//  - refresh_token   - refresh token used to obtain another access_token when
//                      the current access_token expires.
//
// The functions new_access_token and refresh_access_token connect to the
// app service over SSL, obtain a new access token, and update the
// capture session variable.
//
// The functions load_user_entity and get_entity are used to retrieve a JSON
// array for a user entity from the server. load_user_entity calls get_entity.
// ------------------------------------------------------------

include_once('config.php');

// Anyone that uses this file will be manipulating the session variable
// 'capture_session', so just start the session now.
if (!session_start()){
   exit('Could not start session - are php sessions enabled?');
}

function capture_session_name()
{
  if (isset($_COOKIE['app']))
    return ('capture_session_' . $_COOKIE['app']);
  else
    return NULL;
}

function capture_session()
{
  $name = capture_session_name();
  if (isset($_SESSION[$name]))
    return ($_SESSION[$name]);
 else
    return NULL;
}

function save_capture_session($capture_session)
{
  $_SESSION[capture_session_name()] = $capture_session;
}

function clear_capture_session()
{
  unset($_SESSION[capture_session_name()]);
}

// ----------
// Call a Capture API command over SSL, taking in an optional array of POST
// arguments and an optional OAuth access token.  Returns the resulting JSON
// data as a PHP array.

// TODO support sending GET arguments.

function capture_api_call($command, $arg_array = NULL, $access_token = NULL)
{
    global $options;
    $url = $options['capture_addr'] . "/$command";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSLVERSION, 3);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    if (isset($access_token))
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: OAuth $access_token"));
    if (isset($arg_array)) {
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($arg_array));
    }
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);

    $result = curl_exec($curl);
    if ($result == false) {
        echo('Curl error: ' . curl_error($curl) . '<br />');
        echo('HTTP code: ' . curl_errno($curl));
        curl_close($curl);
        die();
    }

    $json_data = json_decode($result, true);
    curl_close($curl);

    // from Documentation:
    // print ("<br><br>result from api call " . $command . ":<br>");
    // print_r($json_data);
    // print ("<br><br>");

    return $json_data;

}

// ----------
// Fetch the entity for an access token by calling out to the capture server
// over SSL.  Returns a PHP array of the JSON data returned by the server.

function get_entity($access_token)
{
  global $options;
  if(isset($options['application_id']))  {
    $args = array('application_id' => $options['application_id']);
  } else {
    $args = NULL;
  }
  return capture_api_call("entity", $args, $access_token);
}

// ----------
// Load a user entity associated with the current capture session.
// the capture session is stored in $_SESSION['capture_session'].
// the capture session must have three fields:
//    expiration_time, access_token, and refresh_token
// returns the JSON data for the user entity as an array,
// or NULL if there is no capture session (i.e. the user is not logged in).
//
// If the access token must be refreshed, then $_SESSION['capture_session'] will be updated.
function load_user_entity($can_refresh = true)
{
  $capture_session = capture_session();
  if (!isset($capture_session))
    return NULL;

  global $options;

  $user_entity = NULL;

  // TODO might want to do a sanity check on capture_session,
  //      in case it is set but corrupted.

  // --------------------
  // There are two ways we check if the access token has expired:
  //  - First, check if we know it has expired based on the expiration time.
  //  - Second, try to use it, and check for error 414,
  //    a unique error code that means the token has expired.

  $need_to_refresh = false;

  // Check if we need to refresh the access token
  if (!isset($capture_session['access_token'])){
    exit("No access token found in session: " .
         print_r($capture_session, true));
  }
  if (time() >= $capture_session['expiration_time'])
    $need_to_refresh = true;
  else
  {
    $user_entity = get_entity($capture_session['access_token']);
    if (isset($user_entity['code']) && $user_entity['code'] == '414')
      $need_to_refresh = true;
  }

  // If necessary, refresh the access token and try to fetch the entity again.
  if ($need_to_refresh) {
    debug_out("*** Access token expired: " . $capture_session['access_token'] . "<br>");
    if ($can_refresh) {
      debug_out("*** Refreshing using refresh token: " . $capture_session['refresh_token'] . "<br>\n");
      refresh_access_token($capture_session['refresh_token']);
      return load_user_entity(false);
    } else {
      debug_out("*** Not refreshing access token<br>\n");
    }
  }

  if (isset($user_entity['code'])){
    debug_out("*** Unknown error: " . $user_entity['code'] . "<br>\n\n");
  }
  return $user_entity;
}

// ----------
// Given the JSON data for a capture session, update the PHP session variable
// 'capture_session' and return boolean to indicate success.  The input must be an array with
// 'access_token', 'expires_in', and 'refresh_token' fields.  The capture_session
// is identical to the input, except that the relative 'expires_in' field
// is replaced with an absolute 'expiration_time' field.

function update_capture_session($json_data)
{
  global $options;
  if (isset($json_data['stat']) && $json_data['stat'] == 'error')
  {
    debug_out("*** update_capture_session: input has an error<br>\n");
    debug_raw_data($json_data);
    return false;
  }

  else
  {
    $capture_session =
      array ('expiration_time' => time() + $json_data['expires_in'],
             'access_token'    => $json_data['access_token'],
             'refresh_token'   => $json_data['refresh_token']);

    save_capture_session($capture_session);

    return true;
  }
}

// ----------
// Given a refresh token, get a new access token and update the capture session
// in the PHP session variable 'capture_session'.  Also returns a PHP array of
// the capture session.
// Uses the global variables defined at the top of this file.

// This is used by load_user_entity.

function refresh_access_token($refresh_token)
{
  global $options;

  $command   = "oauth/token";
  $arg_array = $post_array = array('refresh_token' => $refresh_token,
                                   'grant_type'    => 'refresh_token',
                                   'client_id'     => $options['client_id'],
                                   'client_secret' => $options['client_secret']);

  if(isset($options['application_id'])) {
    $arg_array['application_id'] = $options['application_id'];
  }
  $json_data = capture_api_call($command, $arg_array);

  update_capture_session($json_data);
}

// ----------
// Given an auth code, get a new access token and update the capture session
// in the PHP session variable 'capture_session'.  Also returns a PHP array of
// the capture session.
// Uses the global variables defined at the top of this file.

// This is used by oauth_redirect.php.

function new_access_token($auth_code, $redirect_uri)
{
  global $options;
  $command   = "oauth/token";
  $arg_array = array('code'          => $auth_code,
                     'redirect_uri'  => $redirect_uri,
                     'grant_type'    => 'authorization_code',
                     'client_id'     => $options['client_id'],
                     'client_secret' => $options['client_secret']);

  if(isset($options['application_id'])) {
    $arg_array['application_id'] = $options['application_id'];
  }

  $json_data = capture_api_call($command, $arg_array);

  update_capture_session($json_data);
  return $json_data;
}

// ------------------------------------------------------------

function capture_profile_sync() {

    $profile = load_user_entity();
    if (!$profile) {
    	print ('Could not retrieve profile data. Please try again.');
        return;
    }

    // update_user is call you would implement, to transfer data from
    // $profile into the matching row in your database.
    if (update_user($profile)) {

        $_SESSION['user_friendly_message'] = "Your profile was successfully updated.";
        header('Location: index.php');
        exit;

    }
    else {

        // just a sample - you would handle this according to your own practices.
    	print ("Unable to update local user record");

    }
}


// update_user is call you would implement, to transfer data from
// $profile into the matching row in your database.
function update_user($profile) {

    // just for our example, always return true
    return true;

}


?>
