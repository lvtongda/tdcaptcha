<?php
header("Content-Type:text/html; charset=utf-8");
require_once('../config/config_global.php');

$weburl = $_POST['weburl'];
$ip = $_SERVER['REMOTE_ADDR'];
$publickey = md5($_POST['weburl'].'publictdcaptcha');
$privatekey = md5($_POST['weburl'].'privatetdcaptcha');

$sql_search = "SELECT weburl FROM db_tdcaptcha WHERE weburl='$weburl'";
$result = mysql_query($sql_search);

if(mysql_num_rows($result)) {
    exit('Domain name already exists!');
}else {
    $sql = "INSERT INTO db_tdcaptcha(weburl, ipaddress, publickey, privatekey) VALUES('$weburl', '$ip', '$publickey', '$privatekey')";
    if(mysql_query($sql)) {
        echo 'Domain Name: '.$weburl.'<br />';
        echo 'Public Key: '.$publickey.'<br />';
        echo 'Private Key: '.$privatekey.'<br />';
    }else {
        echo 'Try again!';
    }
}

mysql_close($con);


