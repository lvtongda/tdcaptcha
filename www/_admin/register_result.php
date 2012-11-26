<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); //引入公共文件，其中实现了SQL注入漏洞检查的代码

//获取用户名
$username = trim($_GET['uid']);
if(empty($username)) {
    echo 'URL参数错误！';
    exit;
}

//构造SQL语句查询db_admin表，以获取用户信息
$sql = "SELECT * FROM db_admin WHERE f_username='$username'";
$rs = mysql_query($sql);
if(!$rs) {
    mysql_close(); //关闭数据库连接
    echo '查询失败！';
    exit;
}
//从结果记录集中获取记录放入$user数组
$user = mysql_fetch_assoc($rs);
//关闭数据库连接
mysql_close();
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <title>Registered Result</title>
<style type='text/css'>
<!--
/*表边框为内凹型*/
table {
    border-color: #c0e0c0; 
    border-style: inset;
    border-width: 4px;
}

td {
    font-size: 14pt;
}

/*居中*/
td.hint {
    color: red;
    font-size: 20pt;
    text-align: center;
}

/*背景为天蓝色*/
td.caption {
    background-color: skyblue;
    font-size: 16pt;
}

/*粗体*/
td.label {
    font-weight: bold;
}
-->
</style>
    </head>
    <body>
        <center>
<?php
if(!empty($user)) { ?>
    <table border='0' cellpadding='5' cellspacing='5'>
        <tr><td colspan='2' class='hint'>恭喜您注册成功！</td></tr>
        <tr><td colspan='2' class='caption'>您的注册信息如下：</td></tr>
        <tr><td class='label'>用户名：</td>
            <td><?echo $user['f_username'];?></td></tr>
            <tr><td class='label'>姓名：</td>
            <td><?echo $user['f_name'];?></td></tr>
    </table>
<?php
}
?>
        </center>
    </body>
</html>
