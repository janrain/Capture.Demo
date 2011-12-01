<?php
include 'api.php';

$capture_session = capture_session();

if (time() >= $capture_session['expiration_time']) {
  refresh_access_token($capture_session['refresh_token']);
}

global $options;
$app_addr = $options['captureui_addr'];

$url = $app_addr
        . '/oauth/profile?flags=stay_in_window&access_token='
        . $capture_session['access_token']
        . '&client_id=' . $options['client_id']
        . '&callback=CAPTURE.closeProfileEditor'
        . '&xd_receiver=' . $options['my_addr'] . "/xdcomm.html";

header("Location: " . $url, true, 302);
exit;

