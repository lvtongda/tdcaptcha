<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); //引入公共文件，其中实现了SQL注入漏洞检查的代码

$stid = isset($_GET['stid'])?$_GET['stid']:0;
$time = time() - 300;
$sql = "SELECT max(id) FROM db_captcha WHERE end_time < '$time' ORDER BY id LIMIT 100";
//echo $sql;
$rs = mysql_query($sql);
$row = mysql_fetch_assoc($rs);
$endid = $row['max(id)'];
//echo $row['max(id)'];
$sql = "DELETE FROM db_captcha WHERE end_time < '$time' ORDER BY id LIMIT 100";
mysql_query($sql);
$sum = mysql_affected_rows();

if($sum > 0) {
    $stid = $endid;
    $url = "clearoverduecaptcha.php?stid=$stid";
    echo "<script type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

