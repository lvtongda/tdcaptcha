<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); // Prevent SQL injection
@$username = trim($_POST['username']);
@$pwd = $_POST['pwd'];
@$repeat_pwd = $_POST['repeat_pwd'];
@$name = trim($_POST['name']);;
@$email = trim($_POST['email']);

if (!empty($username)) { 
    if (empty($username) || empty($name) || empty($pwd) || $repeat_pwd != $pwd) {
        echo 'Incomplete data input';
        exit;
    }
    if (strlen($pwd) < 6 || strlen($pwd) > 30) {
        echo 'Password must be between 6-30 characters';
        exit;
    }
}
if (!empty($username)) { 
    $sql = "SELECT username FROM db_admin WHERE username='$username' LIMIT 1";
    $rs = mysql_query($sql);
    if ($rs && mysql_affected_rows() > 0) {
        echo "<font color='red' size='5'>This username is already registered, please try again for one</font>";
    }
    else {
        $pwd = md5($pwd); 
        $sql = "INSERT INTO db_admin(username, password, name) VALUES('$username', '$pwd', '$name')";
        $rs = mysql_query($sql);
        if (!$rs) {
            mysql_close(); 
            echo 'Data record insert fails';
            exit;
        }
        header("Location: register_result.php?uid=$username");
    }

    mysql_close();
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Registering from</title>
<style type="text/css">
<!--
.textinput {
    width: 160px;
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
<script style="text/javascript">
<!--
function doCheck() {
    var username = document.frmRegister.username.value;
    var pwd = document.frmRegister.pwd.value;
    var repeat_pwd = document.frmRegister.repeat_pwd.value;
    var name = document.frmRegister.name.value;
    var email = document.frmRegister.name.value;

    if (username == '') {
        alert('Please enter your user name'); return false;
    }
    if (pwd == '') {
        alert('Please enter a password'); return false;
    }
    if (name == '') {
        alert('Please enter a name'); return false;
    }
    if (repeat_pwd != pwd) {
        alert('Inconsistent password'); return false;
    }
    if (pwd.length < 6 || pwd.length > 30) {
        alert('Password must be between 6-30 characters'); return false;
    }

    return true;
}
-->
</script>
    </head>
    <body>
        <form name="frmRegister" method="post" action="register.php" onsubmit="return doCheck()">
            <table width="350" border="0" align="center" cellpadding="8">
                <tr><td colspan="2" align="center">Registration Administrator</td></tr>
                <tr>
                    <td>Username:</td>
                    <td><input name="username" type="text" id="username" class="textinput" /></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input name="pwd" type="password" id="pwd" class="textinput" /></td>
                </tr>
                <tr>
                    <td>Repassword:</td>
                    <td><input name="repeat_pwd" type="password" class="textinput" id="repeat_pwd" /></td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td><input name="name" type="text" class="textinput" id="name" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="Submit" class="btn" value="submit" />
                        <input type="reset" name="reset" class="btn" value="reset" />
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>

