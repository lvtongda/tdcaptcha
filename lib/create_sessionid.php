<?php
define('HASH_SALT', 'CVoTNBqnv7uL7yRkgYga');

$callback = isset($_GET['callback']) ? $_GET['callback'] : false;
if (!$callback) {
    echo 'alert("Callback parameter is missing");';
}
else {
    header('Content-Type: application/x-javascript');
    $sessionid = json_encode(md5(uniqid(true, time() . HASH_SALT)));
    echo "{$callback}({$sessionid});";
}
