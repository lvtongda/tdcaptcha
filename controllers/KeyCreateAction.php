<?php
header("Content-Type:text/html; charset=utf-8");
require_once('../Config/config_global.php');
$weburl = $_POST['weburl'];
$publickey = md5($_POST['weburl'].'publictdcaptcha');
$privatekey = md5($_POST['weburl'].'privatetdcaptcha');
/*echo $weburl.'<br />';
echo $publickey.'<br />';
echo $privatekey;*/
$sql_search = "SELECT weburl FROM db_client WHERE weburl='$weburl'";
$result = mysql_query($sql_search);
if(mysql_num_rows($result)) {
    exit('域名已被占用！');
}else {
    $sql = "INSERT INTO db_client(weburl, publickey, privatekey) VALUES('$weburl', '$publickey', '$privatekey')";
    if(mysql_query($sql)) {
        echo 'Domain Name: '.$weburl.'<br />';
        echo 'Public Key: '.$publickey.'<br />';
        echo 'Private Key: '.$privatekey.'<br />';
    }else {
        echo 'Try again!';
    }
}
mysql_close($con);


