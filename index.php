<?php
// ------------------------------------------------------------
// index.php - This is the top-level page for the Capture Demo.
// ------------------------------------------------------------
include 'api.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Janrain Capture Demo</title>
  <?php include 'sso.php'; ?>
</head>

<body>

<?php
include 'common.php';
$user_entity = load_user_entity();
make_navigation_bar($user_entity, "home");
include 'home.php';

?>

<script type='text/javascript'>
  var CAPTUREUI = {};
  //Callback fired after recover_password form is submitted
  // if recover_password_callback param passed in with capture signin link (see make_signin_link())
  CAPTUREUI.recoverPasswordCallback = function() {
    $.fancybox.close();
    $('#message').show();
    $('#message').text("We've sent an email with instructions for creating a new password. Your existing password has not been changed.");
  };


  //For custom redirect url for email verification.
  // 'settings/set_default' api call for setting the verify_email_redirect key with this url and params (<domain>/index.php?email_verified=true)
  CAPTUREUI.emailVerifiedCallback = function() {
    $.urlParam = function(name){
      var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
      if (results !== null) {
        return results[1];
      } else {
        return 0;
      }
    }
    if ($.urlParam('email_verified') == 'true') {
      $('#message').show();
      $('#message').text("Thank you. Your email has been verified.");
    }
  }();
</script>


</body>
</html>
