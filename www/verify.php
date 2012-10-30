<?php
header("Content-Type:text/html; charset=utf-8");
require_once('../conf/config.php');

$pubkey = isset($_GET['pubkey']) ? mysql_escape_string($_GET['pubkey']) : false;

if($pubkey) {
    $sql = "SELECT publickey FROM db_client WHERE publickey='$pubkey' limit 1";
    mysql_query($sql);

    if(mysql_affected_rows() < 1) {
        echo "no"; 
    }
}

$inputcode = $_POST['tdcaptcha_challenge_field'];
$pubkeytw = $_POST['pubkey'];
$privkey = $_POST['privkey'];
$clientsonid = md5($_POST['s']+'shijieheping'+$pubkeytw);

if($pubkeytw) {
    $sql = "SELECT captcha FROM db_captcha WHERE publickey='$pubkeytw' AND clientsonid='$clientsonid'";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)) {
        $code = $row['captcha'];
    }

    if($code == null) {
        echo "Please refresh code!";
    }else {
        $sql = "SELECT privatekey FROM db_client WHERE privatekey='$privkey'";
        mysql_query($sql);
        if(mysql_affected_rows() < 1) {
            echo "The privatekey you used is not exists! Please check it.";
        }else {
            if($code == $inputcode) {
                echo "true";
            }else {
                echo 'The error code: '.$inputcode;
            }   
        } 
    }
}
