<?php
// ------------------------------------------------------------
// logout.php
// ------------------------------------------------------------
include 'api.php';

clear_capture_session();
setcookie('app', "", -1);
header("Location: .");

?>
