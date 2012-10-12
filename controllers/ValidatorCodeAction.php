<?php
header("Content-Type:text/html; charset=utf-8");
require_once('../config/config_global.php');
$inputcode = urlencode($_POST['tdcaptcha_response_field']);
$pubkey = urlencode($_POST['pubkey']);

echo $inputcode;
echo $pubkey;
