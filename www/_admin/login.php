<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); // 引入公共文件，其中实现了SQL注入漏洞检查的代码

@$username = trim($_POST['username']);
// 取得客户端提交的密码并用md5()函数进行加密转换以便后面的验证
@$pwd = md5($_POST['pwd']);

// 设置一个错误消息变量，以便判断是否有错误发生
// 以及在客户端显示错误消息。其初值为空
$errmsg = '';
if(!empty($username)) { // 用户填写了数据才执行数据库操作
    // 数据验证，empty()函数判断变量内容是否为空
    if(empty($username)) {
        $errmsg = '数据输入不完整';
    }

    if(empty($errmsg)) { // $errmsg为空说明前面的验证通过
            // 查询数据库，看用户名和密码是否正确
            $sql = "SELECT * FROM db_admin WHERE f_username = '$username' AND f_password = '$pwd' LIMIT 1";
            mysql_query($sql);
            // mysql_affected_rows判断上面的执行结果是否含有记录，有记录说明登陆成功
            if(mysql_affected_rows() > 0) {
                // 使用session保存当前用户
                session_start();
                $_SESSION['uid'] = $username;

                // 在实际应用中可以使用前面提到的重定向功能转到主页
                $errmsg = '登陆成功';

                // 更新用户登录信息
                $ip = $_SERVER['REMOTE_ADDR']; // 获取客户端的IP
                $sql = "UPDATE db_admin SET f_logintimes = f_logintimes + 1, f_lasttime = now(), f_loginip = '$ip' WHERE f_username = '$username'";
                mysql_query($sql);
                header("Location: usermanagament.php");
                exit;
            }else {
                $errmsg = '用户名或密码不正确，登陆失败';
            }

            // 关闭数据库连接
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
<script type='text/javascript'>
<!--
function doCheck() {
    if(document.frmLogin.username.value=='') {
        alert('请输入你的用户名');
        return false;
    }
    if(document.frmLogin.pwd.value=='') {
        alert('请输入你的密码');
        return false;
    }
}
-->
</script>
    </head>
    <body>
        <form name='frmLogin' method='post' action='login.php' onSubmit='return doCheck()'>
            <table border='0' cellpadding='8' width='350' align='center'>
                <tr><td colspan='2' align='center'>验证码用户管理系统登陆</td></tr>
                <tr><td colspan='2' align='center' style='color: red'><?php echo $errmsg;?></td></tr>
                <tr><td>用户名：</td>
                    <td style='color: red'><input name='username' type='text' id='username' class='textinput'><?php echo $username;?></td></tr>
                <tr><td>密码：</td>
                    <td><input name='pwd' type='password' id='password' class='textinput'></td></tr>
                <tr><td colspan='2' align='center'>
                    <input type='submit' class='btn' value='登录'>&nbsp;&nbsp;
                    <input type='reset' class='btn' value='重置'>
                </td></tr>
            </table>
        </form>
    </body>
</html>
