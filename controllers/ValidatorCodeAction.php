<?php
session_start();
$code = $_SESSION['code'];
$icode = $_POST['icode'];
echo $code.'<br />';
echo $icode;
