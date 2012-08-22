<?php
define("TDCAPTCHA_API_SERVER","http://192.168.0.207");
function tdcaptcha_get_html($pubkey){
    $db = mysql_connect("192.168.0.207","root","");
    mysql_select_db("db_captcha",$db);
    mysql_query("set names utf8");
    $sql1 = "select * from db_client_key where pubkey='$pubkey'";
    $result = mysql_query($sql1,$db);
    if(mysql_num_rows($result)>0){
        if($pubkey == null || $pubkey == ''){
            die('To use tdCAPTCHA you must get an API key.');
        }
        $server = TDCAPTCHA_API_SERVER;
        echo file_get_contents("$server/Views/captchaindex.php");
    }else{
        $sql = "insert into db_client_key(pubkey) values('$pubkey')";
        mysql_query($sql,$db);
        mysql_close($db);
        if($pubkey == null || $pubkey == ''){
            die('To use tdCAPTCHA you must get an API key.');
        }
        $server = TDCAPTCHA_API_SERVER;
        echo file_get_contents("$server/Views/captchaindex.php");
    }
}
?>
