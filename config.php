<?php

// ------------------------------------------------------------
// config.php.
// loads options from config.ini.
// included by common.php.
// ------------------------------------------------------------

$default_options = array( 'debug'          => false,
                          'captureui_addr' => 'demo.janraincapture.com',
                          'capture_addr'   => 'demo.janraincapture.com',
                          'my_addr'        => '',
                          'use_ssl'        => true
                          );

$options = parse_ini_file("config.ini");

if (empty($options)) {
  echo "<br>*ERROR* Failed to parse config.ini.  Did you forget to create it?<br>\n";
  die();
} else if (!isset($options['client_id']) || !isset($options['client_secret']) ||
           $options['client_id'][0] == '<' || $options['client_secret'] == '<') {
  echo "<br>*ERROR* Please set client_id and client_secret in config.ini<br>\n";
  die();
}

$options = array_merge($default_options, $options);

// If my_addr is not specified, then infer it from the URL.
if ($options['my_addr'] == '')
  $options['my_addr'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") .
                        $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

// For captureui_addr and capture_addr, if no scheme is specified,
// then add https:// to the front of the variable.
if (substr($options['captureui_addr'], 0, 4) != "http")
  $options['captureui_addr'] = ($options['use_ssl'] ? "https://" : "http://") .
                               $options['captureui_addr'];

if (substr($options['capture_addr'], 0, 4) != "http")
  $options['capture_addr'] = ($options['use_ssl'] ? "https://" : "http://") .
                             $options['capture_addr'];

function debug_out($str)
{
  global $options;
  if ($options['debug'])
    echo $str;
}

function debug_raw_data($data)
{
  global $options;
  if ($options['debug']) {
    echo "<pre>"; print_r($data); echo "</pre>";
  }
}

// ------------------------------------------------------------
?>
