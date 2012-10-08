<?php
session_start();
$code = $_SESSION['tdcaptcha_challenge_field'];
$icode = $_POST['tdcaptcha_response_field'];
echo $code.'<br />';
echo $icode;

