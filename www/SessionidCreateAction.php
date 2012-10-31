<?php
$callback = isset($_GET['callback']) ? $_GET['callback'] : false;
if (!$callback) {
    echo 'alert("缺少回调参数");';
}
else {
    session_start();
    header('Content-Type: application/x-javascript');
    $sessionid = json_encode(md5(session_id()+'shijieheping'));
    echo "{$callback}({$sessionid});";
}
