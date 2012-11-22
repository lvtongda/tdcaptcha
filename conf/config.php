<?php

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'db_captcha');
define('DB_USER', 'root');
define('DB_PASSWORD', 'yupoo123456');

$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if(!$con) {
    die('Could not connect:'.mysql_error());
}

mysql_select_db(DB_NAME, $con);
mysql_query("set names utf8");
