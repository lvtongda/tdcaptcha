<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); //引入公共文件，其中实现了SQL注入漏洞检查的代码

session_start();
if(isset($_SESSION['uid'])) {
    //获取ID
    @$clientid = trim($_GET['clientid']);
    if(empty($clientid)) {
        echo 'URL参数错误';
        exit;
    }

    //构造SQL语句，删除相应记录
    $sql = "DELETE FROM db_client WHERE id='$clientid'";
    $rs = mysql_query($sql);
    if(!$rs) {
        mysql_close(); //关闭数据库连接
        echo '删除失败';
        exit;
    }
    header('Location: user_manage.php');
    exit;
}else {
    echo "<script type='text/javascript'>";
    echo "alert('请登录后再访问');";
    echo "window.location.href='login.php';";
    echo "</script>";
}
