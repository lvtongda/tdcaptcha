<?php
session_start();
$code = $_SESSION['ccode'];
$icode = $_POST['icode'];
echo $code.'<br />';
echo $icode;
