<?php
// ------------------------------------------------------------
// editprofile.php - Profiler editor, top-level file.
// ------------------------------------------------------------
include 'api.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
</head>

<?php
include 'common.php';

$user_entity = load_user_entity();
make_navigation_bar($user_entity, "editprofile");

$capture_session = capture_session();
if (isset($capture_session)) {
  print '<div id="page"><div class="content">';
  make_edit_profile_frame($capture_session['access_token']);
  print '</div></div>';
}

else {
  echo "You must login to access this page<br>\n";
}
?>

<script type='text/javascript'>
    var CAPTURE = {};
    CAPTURE.closeProfileEditor = function() {

        <?php if ($options['do_capture_profile_sync']) { ?>

            // if you ARE syncing data, then you need to call the profile_sync function:
            window.location.href = 'profile_edit_finished.php';

        <?php } else { ?>

            // if NOT syncing data from Capture to your user table, you can just refresh the page:
            window.location = ".";

        <?php } ?>

    };
</script>

</body>
</html>

<?php

// ------------------------------------------------------------
// utility functions

function make_edit_profile_frame($access_token)
{
  global $options;
  $app_addr = $options['captureui_addr'];

  $args = array( 'token'       => $access_token,
                 'callback'    => 'CAPTURE.closeProfileEditor',
                 'xd_receiver' => $options['my_addr'] . "/xdcomm.html");

  echo "<iframe class='profile' frameborder='0' scrolling='yes' src='$app_addr/oauth/profile?" . http_build_query($args) . "'></iframe><br>\n\n";
}

?>
