<?php
$con = mysql_connect("localhost", "username", "pwd");
if(!$con) {
    die('Could not connect:'.mysql_error());
}

mysql_select_db("dbname", $con);
mysql_query("set names utf8");

