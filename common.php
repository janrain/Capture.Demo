<?php
// ------------------------------------------------------------
// common.php.
// Common file that should be sourced by each top-level file
// (e.g. index.php, rawprofile.php, editprofile.php, etc.).
// Also, 'api.php' should be included before this file.
// ------------------------------------------------------------
?>

<script src="<?php echo ($options['use_ssl'] ? "https://" : "http://"); ?>ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="fancybox/jquery.fancybox-1.3.3.pack.js"></script>
<script src="json2.js"></script>
<script src="./Capture.js"></script>
<script src="http://cdn.echoenabled.com/clientapps/v2/backplane.js"></script>
<script src="<?php echo ($options['captureui_addr']); ?>/cdn/javascripts/capture_client.js"></script>
<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.3.css" />
<link rel="stylesheet" href="style.css">

<?php
include 'navigation.php';

// ------------------------------------------------------------
?>
