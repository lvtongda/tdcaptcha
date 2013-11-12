<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); // Prevent SQL injection 

@$username = trim($_POST['username']);
@$pwd = md5($_POST['pwd']);

$errmsg = '';
if (!empty($username)) { 
    if (empty($username)) {
        $errmsg = 'Incomplete data input';
    }

    if (empty($errmsg)) { 
            $sql = "SELECT * FROM db_admin WHERE username = '$username' AND password = '$pwd' LIMIT 1";
            mysql_query($sql);
            if (mysql_affected_rows() > 0) {
                session_start();
                $_SESSION['uid'] = $username;

                $errmsg = 'Successful landing';

                $ip = $_SERVER['REMOTE_ADDR'];
                $sql = "UPDATE db_admin SET logintimes = logintimes + 1, lasttime = now(), loginip = '$ip' WHERE username = '$username'";
                mysql_query($sql);
                header("Location: user_manage.php");
                exit;
            }
            else {
                $errmsg = 'User name or password is incorrect, login failed';
            }

            mysql_close();
        }
    }
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <title>User Login</title>
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
<script type="text/javascript">
<!--
function doCheck() {
    if (document.frmLogin.username.value=='') {
        alert('Please enter your user name');
        return false;
    }
    if (document.frmLogin.pwd.value=='') {
        alert('Please enter your password');
        return false;
    }
}
-->
</script>
    </head>
    <body>
        <form name="frmLogin" method="post" action="login.php" onSubmit="return doCheck()">
            <table border="0" cellpadding="8" width="350" align="center">
                <tr><td colspan="2" align="center">Log in</td></tr>
                <tr><td colspan="2" align="center" style="color: red"><?php echo $errmsg;?></td></tr>
                <tr><td>Username:</td>
                    <td style="color: red"><input name="username" type="text" id="username" class="textinput"><?php echo $username;?></td></tr>
                <tr><td>Password:</td>
                    <td><input name="pwd" type="password" id="password" class="textinput"></td></tr>
                <tr><td colspan="2" align="center">
                    <input type="submit" class="btn" value="login">&nbsp;&nbsp;
                    <input type="reset" class="btn" value="reset">
                </td></tr>
            </table>
        </form>
    </body>
</html>
