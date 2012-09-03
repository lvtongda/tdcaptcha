<?php
$con = mysql_connect("127.0.0.1","root","zxfltt");
mysql_select_db("db_captcha",$con);
mysql_query("set names utf8");

$sql1 = "select pubkey from db_client_key";
$result1 = mysql_query($sql1,$con);
$row1 = mysql_fetch_assoc($result1);

$sql2 = "select pubkey from db_client";
$result2 = mysql_query($sql2,$con);
$row2 = mysql_fetch_assoc($result2);

if($row1['pubkey'] = $row2['pubkey']){
    echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />';
    echo '<img src="http://192.168.0.207/Models/ValidatorCode.php" id="code" /><br />';
    echo '<input type="text" value="" name="scode"><br />';
    echo '看不清，<a href="javascript:reloadcode();">换一组</a>';
    echo '<script type=text/javascript>
        function reloadcode(){
            document.getElementById("code").src="http://192.168.0.207/Models/ValidatorCode.php?"+Math.random();
        }   
        </script>';
}else{
    die("To use an right API key.");
}
?>
