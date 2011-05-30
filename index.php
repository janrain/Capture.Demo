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



</body>
</html>
