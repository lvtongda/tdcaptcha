<?php
header("Content-Type:text/html; charset=utf-8");
require_once('../config/config_global.php');

$inputcode = $_POST['tdcaptcha_challenge_field'];
$pubkey = $_POST['pubkey']; 

$sql = "SELECT captcha FROM db_tdcaptcha WHERE publickey='$pubkey'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) {
    $code = $row['captcha']; 
}

function verify($inputcode, $code) {
    if ($inputcode === $code) {
        return 'yes';
    }else {
        return 'no';
    }
}
$verify = verify($inputcode, $code);

$sql = "UPDATE db_tdcaptcha SET verify='$verify' WHERE publickey='$pubkey'";
mysql_query($sql);

$privkey = $_GET['privkey'];
if($privkey) {
    $sql = "SELECT verify FROM db_tdcaptcha WHERE privatekey='$privkey'";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)) {
        $verify = $row['verify'];
    }
    echo $verify;
}
