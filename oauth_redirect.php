<?php
include 'api.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<body>

<?php

if (isset($_GET['code']))
{
  $auth_code     = $_GET["code"];
  $redirect_uri = $options['my_addr'] . "/oauth_redirect";

  debug_out("*** Auth code: $auth_code <br>\n");

  // note: new_access_token is defined in common.php
  new_access_token($auth_code, $redirect_uri);

}
?>

<script type='text/javascript'>
  if (window.top == window.self)
    window.location = "."; // hard-code this location for now...
  else
    window.parent.location.reload();
</script>

</body>
</html>

