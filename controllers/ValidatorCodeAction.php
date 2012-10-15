<?php
header("Content-Type:text/html; charset=utf-8");
require_once('../config/config_global.php');

$inputcode = $_POST['tdcaptcha_challenge_field'];
$pubkey = $_POST['pubkey']; 
setcookie('pubkey', $pubkey);
$pbkey = $_COOKIE['pubkey'];
echo $pbkey;
$sql = "SELECT captcha FROM db_tdcaptcha WHERE publickey='$pubkey'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) {
    $code = $row['captcha']; 
}

function verify($inputcode, $code) {
    if ($inputcode === $code) {
        return 1;
    }else {
        return 0;
    }
}
$verify = verify($inputcode, $code);

$sql = "UPDATE db_tdcaptcha SET verify='$verify' WHERE publickey='$pubkey'";
mysql_query($sql);

if($_GET['verify']) {
    $sql = "SELECT verify FROM db_tdcaptcha WHERE publickey='$pubkey'";
    echo $sql;
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)) {
        $verify = $row['verify'];
    }
    echo $verify;
}
