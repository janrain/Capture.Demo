<?php
// ------------------------------------------------------------
// rawprofile.php.
// This is a top-level page for displaying the user's raw profile
// ------------------------------------------------------------
include 'api.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Janrain Capture Demo</title>
</head>

<body>

<?php
include 'common.php';

$user_entity = load_user_entity();
make_navigation_bar($user_entity, "rawprofile");

$capture_session = capture_session();
if (isset($capture_session)) {
   if (isset($user_entity['stat']) && $user_entity['stat'] == 'ok')
     $user_entity = $user_entity['result'];

   $user_entity = json_encode($user_entity);

?>

<div id="page"><div class="content">
</div></div>
</body>
</html>

<script type="text/javascript" src="prettyprint.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var raw = <?php print $user_entity ?>;
        var pretty = prettyPrint(raw);
        $(".content").append(pretty);
    });
</script>
<?

}

else {
  echo "You must login to access this page<br>\n";
}
