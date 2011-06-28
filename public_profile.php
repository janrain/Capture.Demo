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
  <title>Public Profile</title>
</head>

<?php
include 'common.php';
$user_entity = load_user_entity();
make_navigation_bar($user_entity, "public_profile");
$capture_session = capture_session();

$user_id = $user_entity['result']['id'];
if (isset($capture_session)) {
  print '<div id="page"><div class="content">';
  make_public_profile_frame($capture_session['access_token'], $user_id);
  print '</div></div>';
}

else {
  echo "You must login to access this page<br>\n";
}
?>

<script type='text/javascript'>
  var CAPTURE = {};
  CAPTURE.resize = function(json) {
    var o = JSON.parse(json);
    $("iframe").height(o.h).width(o.w);
    if (typeof console !== 'undefined') {
      console.log("resize", o);
    }
  };
</script>

</body>
</html>

<?php

// ------------------------------------------------------------
// utility functions

function make_public_profile_frame($access_token, $user_id)
{
  global $options;
  $app_addr = $options['captureui_addr'];

  $args = array('id' => $user_id);
  echo "<iframe class='profile' frameborder='0' scrolling='yes' src='$app_addr/oauth/public_profile?" . http_build_query($args) . "'></iframe><br>\n\n";
}

?>
