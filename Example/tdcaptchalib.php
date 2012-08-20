<?php
define("TDCAPTCHA_API_SERVER","http://tdcaptcha.com");
function tdcaptcha_get_html($pubkey){
    if($pubkey == null || $pubkey == ''){
        die('To use tdCAPTCHA you must get an API key.');
    }
    $server = TDCAPTCHA_API_SERVER;
    echo file_get_contents("$server/Views/captchaindex.php");
}
?>
