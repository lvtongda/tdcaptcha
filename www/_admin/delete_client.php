<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); // Prevent SQL injection 

session_start();
if (isset($_SESSION['uid'])) {
    @$clientid = trim($_GET['clientid']);
    if (empty($clientid)) {
        echo 'URL parameter error';
        exit;
    }

    $sql = "DELETE FROM db_client WHERE id='$clientid'";
    $rs = mysql_query($sql);
    if (!$rs) {
        mysql_close(); 
        echo 'Delete failed';
        exit;
    }
    header('Location: user_manage.php');
    exit;
}else {
    echo "<script type='text/javascript'>";
    echo "alert('Please login to access');";
    echo "window.location.href='login.php';";
    echo "</script>";
}
