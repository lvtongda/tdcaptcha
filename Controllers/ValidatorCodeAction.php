<?php
include("../Models/session_mysql.php");
$code = $_SESSION['code'];
$scode = $_POST['scode'];
if($code == $scode){
    echo "The captcha is right.";
}else{
    echo "The captcha is false.";
}
