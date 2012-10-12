<?php
header("Content-Type:text/html; charset=utf-8");
require_once('../config/config_global.php');

$inputcode = urlencode($_POST['tdcaptcha_challenge_field']);
$pubkey = urlencode($_POST['pubkey']);

$sql = "SELECT captcha FROM db_tdcaptcha WHERE publickey='$pubkey'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) {
    $code = $row['captcha']; 
}

function verify($inputcode, $code) {
    if ($inputcode == $code) {
        return 'ddddd';
    }else {
        return false;
    }
}

verify($inputcode, $code);

