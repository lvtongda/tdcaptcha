<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); // Prevent SQL injection 

ignore_user_abort(); // Running in the background
set_time_limit(0); 
$interval = 300; // Once every 5 minutes

do {
    $time = time() - 300;

    $sql = "DELETE FROM db_captcha WHERE end_time < '$time' ORDER BY id LIMIT 100";
    $rs = mysql_query($sql);
    if (!$rs) {
        mysql_close(); 
        echo 'Failed to delete expired verification code';
        exit;
    }
    $sum = mysql_affected_rows();

    if ($sum == 0) {
        echo 'Verification code expired successfully removed'.date('Y-m-d H:m:s',time());
        sleep($interval);
    }
} while (true);
