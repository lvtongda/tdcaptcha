<?php
$con = mysql_connect('severname', 'username', 'password');
if (!$con) {
    die('Could not connect: ' . mysql_error());    
}

mysql_select_db('db_tdcaptcha', $con);
