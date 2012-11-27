<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); //引入公共文件，其中实现了SQL注入漏洞检查的代码

session_start();
if(isset($_SESSION['uid'])) {
    //trim()函数可以截去头尾的空白字符
    @$weburl = trim($_POST['weburl']);
    @$publickey = md5(trim($_POST['weburl']).'publictdcaptcha');
    @$privatekey = md5(trim($_POST['weburl']).'privatetdcaptcha');

    if(!empty($weburl)) { //用户填写了数据才执行数据库操作
        //数据验证，empty()函数判断变量内容是否为空
        if(empty($weburl) || empty($publickey) || empty($privatekey)) {
            echo '数据输入不完整';
            exit;
        }
    }
    if(!empty($weburl)) { //用户填写了数据才执行数据库操作
        $sql = "SELECT weburl FROM db_client WHERE weburl='$weburl'";
        mysql_query($sql);
        if(mysql_affected_rows() > 0) {
            echo '域名已存在';
            exit;    
        }
        //修改相应记录的用户信息
        $sql = "INSERT INTO db_client(weburl, publickey, privatekey) VALUES('$weburl', '$publickey', '$privatekey')";

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
    //验证表单有效性的函数
    //当函数返回true时，说明验证成功，表单数据正常提交
    //当函数返回false时，说明验证失败，表单数据被终止提交
function doCheck() {
    var weburl = document.frmAdd.weburl.value;
    var publickey = document.frmAdd.publickey.value;
    var privatekey = document.frmAdd.privatekey.value;

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
        <form name='frmAdd' method='post' action='addclient.php' onsubmit='return doCheck()'>
            <table width='350' border='0' align='center' cellpadding='8'>
                <tr><td colspan='2' align='center'>添加用户</td></tr>
                <tr width='40%'>
                    <td>域名：</td>
                    <td>http://&nbsp;<input name='weburl' type='text' id='weburl' class='textinput' value='' /></td>
                </tr>
                <tr><td colspan='2' align='center'>
                    <input type='submit' class='btn' value='增加' />
                    <input type='button' class='btn' value='取消' onclick='msg()' />
                </td></tr>
            </table>
        </form>
    </body>
</html>


