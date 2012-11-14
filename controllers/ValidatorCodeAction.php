<?php
header("Content-Type:text/html; charset=utf-8");
require_once('../config/config_global.php');

@$pubkey = mysql_escape_string($_GET['pubkey']);

if($pubkey) {
    $sql = "SELECT publickey FROM db_client WHERE publickey='$pubkey' LIMIT 1";
    mysql_query($sql);

    if(mysql_affected_rows() < 1) {
        echo "no"; 
    }
}

$inputcode = mysql_escape_string($_POST['tdcaptcha_challenge_field']);
$clientsonid = mysql_escape_string(json_decode($_POST['tdcaptcha_response_field']));
$privkey = mysql_escape_string($_POST['privkey']);

if($privkey) {
    $sql = "SELECT captcha FROM db_captcha WHERE privatekey='$privkey' AND clientsonid='$clientsonid' LIMIT 1";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)) {
        $code = $row['captcha'];
    }

    if($code == null) {
        echo "Please refresh code!";
    }else {
        $sql = "SELECT privatekey FROM db_client WHERE privatekey='$privkey' LIMIT 1";
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
