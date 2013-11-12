<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); // Prevent SQL injection

session_start();
if (isset($_SESSION['uid'])) {
    @$weburl = trim($_POST['weburl']);
    @$publickey = md5(trim($_POST['weburl']).'publictdcaptcha');
    @$privatekey = md5(trim($_POST['weburl']).'privatetdcaptcha');

    if (!empty($weburl)) {
        if (empty($weburl) || empty($publickey) || empty($privatekey)) {
            echo 'Incomplete data input';
            exit;
        }
    }
    if (!empty($weburl)) { 
        $sql = "SELECT weburl FROM db_client WHERE weburl='$weburl' LIMIT 1";
        mysql_query($sql);
        if (mysql_affected_rows() > 0) {
            echo 'Domain name already exists';
            exit;    
        }
        $sql = "INSERT INTO db_client(weburl, publickey, privatekey) VALUES('$weburl', '$publickey', '$privatekey')";

        $rs = mysql_query($sql);
        if (!$rs) {
            mysql_close(); 
            echo 'Data record insert fails';
            exit;
        }
        echo "<script type='text/javascript'>";
        echo "alert('Successfully added');";
        echo "window.location.href='user_manage.php';";
        echo "</script>";
    }

    mysql_close();
}
else {
    echo "<script type='text/javascript'>";
    echo "alert('Please login to access');";
    echo "window.location.href='login.php';";
    echo "</script>";
}
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <title>Add client</title>
<style type='text/css'>
<!--
.textinput {
    width: 200px;
}
.btn {
    width: 80px;
}
table {
    border: 3px double;
    background-color: #FEFFFC;
}
-->
</style>
<script style='text/javascript'>
<!--
function doCheck() {
    var weburl = document.frmAdd.weburl.value;
    var publickey = document.frmAdd.publickey.value;
    var privatekey = document.frmAdd.privatekey.value;

    if(weburl == '') {
        alert('Please enter the domain name'); return false;
    }
    if(publickey == '') {
        alert('Please enter the Public Key'); return false;
    }
    if(privatekey == '') {
        alert('Please enter private key'); return false;
    }

    return true;
}

function msg() {
    window.location.href='user_manage.php';
}
-->
</script>
    </head>
    <body>
        <form name='frmAdd' method='post' action='add_client.php' onsubmit='return doCheck()'>
            <table width='350' border='0' align='center' cellpadding='8'>
                <tr><td colspan='2' align='center'>Add User</td></tr>
                <tr width='40%'>
                    <td>Domain name：</td>
                    <td>http://&nbsp;<input name='weburl' type='text' id='weburl' class='textinput' value='' /></td>
                </tr>
                <tr><td colspan='2' align='center'>
                    <input type='submit' class='btn' value='Add' />
                    <input type='button' class='btn' value='Cancel' onclick='msg()' />
                </td></tr>
            </table>
        </form>
    </body>
</html>


