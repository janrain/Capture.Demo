<?php
include_once('config.php');

global $options;

if (isset($options['sso_server'])){
?>

<script src="<?php echo $options['sso_server']; ?>/sso.js" type="text/javascript"></script>
<script type="text/javascript">
JANRAIN.SSO.CAPTURE.check_login({
    <?php
    echo "sso_server: '". $options['sso_server']. "',\n";
    echo "client_id: '" . $options['client_id'] . "',\n";
    echo "redirect_uri: '" . $options['my_addr'] . "/oauth_redirect.php?from_sso=1',\n";
    echo "logout_uri: '" . $options['my_addr'] .  "/logout.php',\n";
    echo "xd_receiver: '" . $options['my_addr'] .  "/xdcomm.html'\n";
    ?>
});
</script>

<script type="text/javascript">
function sso_logout() {
  JANRAIN.SSO.CAPTURE.logout({
      <?php
      echo "sso_server: '" . $options['sso_server'] . "',\n";
      echo "logout_uri: '" . $options['my_addr'] . "/logout.php'\n";
      ?>
  });
};
</script>

<?php
}
?>
