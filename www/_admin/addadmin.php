<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); //引入公共文件，其中实现了SQL注入漏洞检查的代码

session_start();
if(isset($_SESSION['uid'])) {
    //trim()函数可以截去头尾的空白字符
    @$username = trim($_POST['username']);
    @$pwd = $_POST['pwd'];
    @$repeat_pwd = $_POST['repeat_pwd'];
    @$name = trim($_POST['name']);;

    if(!empty($username)) { //用户填写了数据才执行数据库操作
        //数据验证，empty()函数判断变量内容是否为空
        if(empty($username) || empty($name) || empty($pwd) || $repeat_pwd != $pwd) {
            echo '数据输入不完整';
            exit;
        }
        if(strlen($pwd) < 6 || strlen($pwd) > 30) {
            echo '密码必须在6到30个字符之间';
            exit;
        }
    }
    if(!empty($username)) { //用户填写了数据才执行数据库操作
        //查询数据库，看填写的用户名是否已经存在
        $sql = "SELECT * FROM db_admin WHERE f_username='$username' LIMIT 1";

        $rs = mysql_query($sql);
        //$rs->num_rows判断上面的执行结果是否会有记录，有记录说明用户名存在
        if(mysql_affected_rows() > 0) {
            echo "<font color='red' size='5'>该用户名已被注册，请换一个重试</font>";
        }else {
            //将用户信息插入数据库的db_admin表
            $pwd = md5($pwd); //将明文密码使用md5算法加密
            $sql = "INSERT INTO db_admin(f_username, f_password, f_name) VALUES('$username', '$pwd', '$name')";
            $rs = mysql_query($sql);
            if(!$rs) {
                mysql_close(); //关闭数据库连接
                echo '数据记录插入失败';
                exit;
            }
            echo "<script type='text/javascript'>";
            echo "alert('添加成功');";
            echo "window.location.href='usermanagament.php';";
            echo "</script>";
        }
        //关闭数据库连接
        mysql_close();
    }
}else {
    echo "<script type='text/javascript'>";
    echo "alert('请登录后再访问');";
    echo "window.location.href='login.php';";
    echo "</script>";
}
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <title>Add admin</title>
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
    //验证表单有效性的函数
    //当函数返回true时，说明验证成功，表单数据正常提交
    //当函数返回false时，说明验证失败，表单数据被终止提交
function doCheck() {
    var username = document.frmRegister.username.value;
    var pwd = document.frmRegister.pwd.value;
    var repeat_pwd = document.frmRegister.repeat_pwd.value;
    var name = document.frmRegister.name.value;

    if(username == '') {
        alert('请输入用户名'); return false;
    }
    if(pwd == '') {
        alert('请输入密码'); return false;
    }
    if(name == '') {
        alert('请输入姓名'); return false;
    }
    if(repeat_pwd != pwd) {
        alert('重复密码与密码不一致'); return false;
    }
    if(pwd.length < 6 || pwd.length > 30) {
        alert('密码必须在6到30个字符之间'); return false;
    }

    return true;
}
-->
</script>
    </head>
    <body>
        <form name='frmRegister' method='post' action='addadmin.php' onsubmit='return doCheck()'>
            <table width='350' border='0' align='center' cellpadding='8'>
                <tr><td colspan='2' align='center'>添加管理员</td></tr>
                <tr>
                    <td>用户名：</td>
                    <td><input name='username' type='text' id='username' class='textinput' /></td>
                </tr>
                <tr>
                    <td>密码：</td>
                    <td><input name='pwd' type='password' id='pwd' class='textinput' /></td>
                </tr>
                <tr>
                    <td>重复密码：</td>
                    <td><input name='repeat_pwd' type='password' class='textinput' id='repeat_pwd' /></td>
                </tr>
                <tr>
                    <td>姓名：</td>
                    <td><input name='name' type='text' class='textinput' id='name' /></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'>
                        <input type='submit' name='Submit' class='btn' value='提交' />
                        <input type='reset' name='reset' class='btn' value='重置' />
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
