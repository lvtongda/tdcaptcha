<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); // Prevent SQL injection

session_start();
if(isset($_SESSION['uid'])) {
    @$clientid = trim($_GET['clientid']);
    @$web = trim($_GET['web']);
    @$pubkey = trim($_GET['pubkey']);
    @$prikey = trim($_GET['prikey']);
    @$weburl = trim($_POST['weburl']);
    @$publickey = trim($_POST['publickey']);
    @$privatekey = trim($_POST['privatekey']);

    if(!empty($weburl)) { 
        if(empty($weburl) || empty($publickey) || empty($privatekey) || empty($clientid)) {
            echo 'Incomplete data input';
            exit;
        }
    }
    if(!empty($weburl)) { 
        $sql = "UPDATE db_client SET weburl='$weburl', publickey='$publickey', privatekey='$privatekey' WHERE id='$clientid'";

        $rs = mysql_query($sql);
        if(!$rs) {
            mysql_close(); 
            echo 'Failed to modify data records';
            exit;
        }
        
        header('Location: user_manage.php');
        exit;
    }
    mysql_close();
}else {
    echo "<script type='text/javascript'>";
    echo "alert('Please login to access');";
    echo "window.location.href='login.php';";
    echo "</script>";
}
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <title>Modify clientinfo</title>
<style type='text/css'>
<!--
table {
    border-color: #6BBEEA; 
}
.textinput {
    width: 200px;
}
.btn {
    width: 80px;
}
table {
    border: 3px double;
    background-color: #eeeeee;
}
-->
</style>
<script style='text/javascript'>
<!--
function doCheck() {
    var weburl = document.frmModify.weburl.value;
    var publickey = document.frmModify.publickey.value;
    var privatekey = document.frmModify.privatekey.value;

    if (weburl == '') {
        alert('Please enter the domain name'); return false;
    }
    if (publickey == '') {
        alert('Please enter the Public Key'); return false;
    }
    if (privatekey == '') {
        alert('Please enter private Key'); return false;
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
        <form name="frmModify" method="post" action="modify_client.php?clientid=<?php echo $clientid;?>" onsubmit="return doCheck()">
            <table width="350" border="0" align="center" cellpadding="8">
                <tr><td colspan="2" align="center">Modify user information</td></tr>
                <tr><td colspan="2" align="center" style="color: red">Please carefully modified</td></tr>
                <tr>
                    <td>ID: </td>
                    <td><?php echo $clientid;?></td>
                </tr>
                <tr width="40%">
                    <td>Domain name:</td>
                    <td><input name="weburl" type="text" id="weburl" class="textinput" value="<?php echo $web;?>" /></td>
                </tr>
                <tr>
                    <td>Public key:</td>
                    <td><input name="publickey" type="text" id="publickey" class="textinput" value="<?php echo $pubkey;?>" /></td>
                </tr>
                <tr>
                    <td>Private key:</td>
                    <td><input name="privatekey" type="text" id="privatekey" class="textinput" value="<?php echo $prikey;?>" /></td>
                </tr>
                <tr>
                    <td><input name="clientid" type="hidden" value="<?php echo $clientid;?>" /></td>
                </tr>
                <tr><td colspan="2" align="center">
                    <input type="submit" class="btn" value="Modify" />
                    <input type="button" class="btn" value="Cancel" onclick="msg()" />
                </td></tr>
            </table>
        </form>
    </body>
</html>


