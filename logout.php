<?php
// ------------------------------------------------------------
// logout.php
// ------------------------------------------------------------
include 'api.php';

error_log("logout.php in client 1");

clear_capture_session();
setcookie('app', "", -1);
header("Location: .");

?>
