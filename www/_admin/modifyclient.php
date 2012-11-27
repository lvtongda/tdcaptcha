<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); //引入公共文件，其中实现了SQL注入漏洞检查的代码

session_start();
if(isset($_SESSION['uid'])) {
    //trim()函数可以截去头尾的空白字符
    @$clientid = trim($_GET['clientid']);
    @$web = trim($_GET['web']);
    @$pubkey = trim($_GET['pubkey']);
    @$prikey = trim($_GET['prikey']);
    @$weburl = trim($_POST['weburl']);
    @$publickey = trim($_POST['publickey']);
    @$privatekey = trim($_POST['privatekey']);

    if(!empty($weburl)) { //用户填写了数据才执行数据库操作
        //数据验证，empty()函数判断变量内容是否为空
        if(empty($weburl) || empty($publickey) || empty($privatekey) || empty($clientid)) {
            echo '数据输入不完整';
            exit;
        }
    }
    if(!empty($weburl)) { //用户填写了数据才执行数据库操作
        //修改相应记录的用户信息
        $sql = "UPDATE db_client SET weburl='$weburl', publickey='$publickey', privatekey='$privatekey' WHERE id='$clientid'";

        $rs = mysql_query($sql);
        if(!$rs) {
            mysql_close(); //关闭数据库连接
            echo '数据记录修改失败';
            exit;
        }
        
        header('Location: usermanagament.php');
        exit;
    }
    //关闭数据库连接
    mysql_close();
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
    //验证表单有效性的函数
    //当函数返回true时，说明验证成功，表单数据正常提交
    //当函数返回false时，说明验证失败，表单数据被终止提交
function doCheck() {
    var weburl = document.frmModify.weburl.value;
    var publickey = document.frmModify.publickey.value;
    var privatekey = document.frmModify.privatekey.value;

    if(weburl == '') {
        alert('请输入域名'); return false;
    }
    if(publickey == '') {
        alert('请输入公钥'); return false;
    }
    if(privatekey == '') {
        alert('请输入私钥'); return false;
    }

    return true;
}

function msg() {
    window.location.href='usermanagament.php';
}
-->
</script>
    </head>
    <body>
        <form name='frmModify' method='post' action='modifyclient.php?clientid=<?=$clientid;?>' onsubmit='return doCheck()'>
            <table width='350' border='0' align='center' cellpadding='8'>
                <tr><td colspan='2' align='center'>修改用户信息</td></tr>
                <tr><td colspan='2' align='center' style='color: red'>请谨慎修改</td></tr>
                <tr>
                    <td>ID: </td>
                    <td><?=$clientid;?></td>
                </tr>
                <tr width='40%'>
                    <td>域名：</td>
                    <td><input name='weburl' type='text' id='weburl' class='textinput' value='<?=$web;?>' /></td>
                </tr>
                <tr>
                    <td>公钥：</td>
                    <td><input name='publickey' type='text' id='publickey' class='textinput' value='<?=$pubkey;?>' /></td>
                </tr>
                <tr>
                    <td>私钥：</td>
                    <td><input name='privatekey' type='text' id='privatekey' class='textinput' value='<?=$prikey;?>' /></td>
                </tr>
                <tr>
                    <td><input name='clientid' type='hidden' value='<?=$clientid;?>' /></td>
                </tr>
                <tr><td colspan="2" align="center">
                    <input type='submit' class='btn' value='修改' />
                    <input type='button' class='btn' value='取消' onclick='msg()' />
                </td></tr>
            </table>
        </form>
    </body>
</html>


