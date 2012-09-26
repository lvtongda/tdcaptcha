<?php
$con = mysql_connect("localhost", "root", "zxfltt");
if(!$con) {
    die('Could not connect:'.mysql_error());
}

mysql_select_db("db_tdcaptcha", $con);
mysql_query("set names utf8");
