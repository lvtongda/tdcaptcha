<?php
header("Content-Type:text/html; charset=utf-8");
require_once('../../conf/config.php');

$weburl = $_POST['weburl'];
$publickey = md5($_POST['weburl'].'publictdcaptcha');
$privatekey = md5($_POST['weburl'].'privatetdcaptcha');

$sql_search = "SELECT weburl FROM db_client WHERE weburl='$weburl'";
$result = mysql_query($sql_search);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(mysql_num_rows($result)) {
        exit('Domain name already exists!');
    }else {
        $sql = "INSERT INTO db_client(weburl, publickey, privatekey) VALUES('$weburl', '$publickey', '$privatekey')";
        if(mysql_query($sql)) {
            echo '<span style="color: red">Please remember the following information!</span><br />';
            echo 'Domain Name: '.$weburl.'<br />';
            echo 'Public Key: '.$publickey.'<br />';
            echo 'Private Key: '.$privatekey.'<br />';
        }else {
            echo 'Try again!';
        }
    }

    mysql_close($con);
}
