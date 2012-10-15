<?php
require_once('../config/config_global.php');

$pubkey = $_POST['pubkey'];

$sql = "SELECT verify FROM db_tdcaptcha WHERE publickey='$pubkey'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) {
    $verify = $row['verify'];
}
echo $verify;
