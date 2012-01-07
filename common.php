<?php
// ------------------------------------------------------------
// common.php.
// Common file that should be sourced by each top-level file
// (e.g. index.php, rawprofile.php, editprofile.php, etc.).
// Also, 'api.php' should be included before this file.
// ------------------------------------------------------------
?>


<!----------------------------------
These are the includes described in
Chapter 3 of the Integration Guide:
----------------------------------->

<!-- Fancybox requires jQuery. -->
<script src="<?php echo ($options['use_ssl'] ? "https://" : "http://"); ?>ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>

<!-- Here's fancybox (javascript and CSS).  Feel free to just copy the whole fancybox directory from this app into one you are building, at
least just to get started. -->
<script src="fancybox/jquery.fancybox-1.3.3.pack.js"></script>
<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.3.css" />

<!-- We'll need to do some JSON parsing. -->
<script src="json2.js"></script>

<!-- This javascript needs to be served from your site; it is the receiving end of the cross-domain communication calls. -->
<script src="./Capture.js"></script>



<!----------------------------------
These are some additional includes
that the guide doesn't currently go
into:
----------------------------------->

<script src="http://cdn.echoenabled.com/clientapps/v2/backplane.js"></script>
<script src="<?php echo ($options['captureui_addr']); ?>/cdn/javascripts/capture_client.js"></script>
<link rel="stylesheet" href="style.css">


<?php
// navigation.php renders the top navigation bar.
include 'navigation.php';
?>
