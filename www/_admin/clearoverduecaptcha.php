<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); //引入公共文件，其中实现了SQL注入漏洞检查的代码

ignore_user_abort(); //关闭浏览器后，php脚本也可以继续执行
$interval = 300; //每隔5分钟执行一次

do{
    $time = time() - 300;

    $sql = "DELETE FROM db_captcha WHERE end_time < '$time' ORDER BY id LIMIT 100";
    $rs = mysql_query($sql);
    if(!$rs) {
        mysql_close(); //关闭数据库连接
        echo '删除过期验证码失败';
        exit;
    }
    $sum = mysql_affected_rows();

    if($sum == 0) {
        echo '成功删除过期验证码'.date('Y-m-d H:m:s',time());
        sleep($interval);
    }
}while(true);
