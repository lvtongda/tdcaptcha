<?php
// This is a PHP library that handles calling tdCAPTCHA.

# The tdCAPTCHA server URL's
define("TDCAPTCHA_API_SERVER", "http://192.168.0.207/tdcaptcha");
define("TDCAPTCHA_VERIFY_SERVER", "http://192.168.0.207/tdcaptcha");

# Submits an HTTP POST to a tdCAPTCHA server
function _tdcaptcha_http_post($url, $curlPost) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);

    $response = curl_exec($ch);
    return $response;
    curl_close($ch);
}

# The HTML to be embedded in the user's form.
function tdcaptcha_get_html($pubkey) {
    if($pubkey == null || $pubkey == '') {
        die ("To use tdCAPTCHA you must get an API key.");    
    }

    $server = TDCAPTCHA_VERIFY_SERVER;

    return '<img id="tdcaptcha_challenge_field" src="'.$server.'/models/ValidatorCode.php" height="30" width="160" style="cursor:pointer" onclick="reloadcode()"><br />
        <input type="hidden" value="" name="tdcaptcha_challenge_field">
        <input type="text" value="" name="tdcaptcha_response_field">

        <script type="text/javascript">
        function reloadcode() {
            document.getElementById("tdcaptcha_challenge_field").src="'.$server.'/models/ValidatorCode.php?"+Math.random();
        }
        </script>
        ';    
}

# A TdCaptchaResponse is returned from tdcaptcha_check_answer()
class TdCaptchaResponse {
    var $is_valid;
    var $error;
}

# Calls an HTTP POST function to verify if the user's guess was correct
function tdcaptcha_check_answer() {
    if($privkey == null || $privkey == '') {
        die("To use tdCAPTCHA you must get an API key.");
    }

    $response = _tdcaptcha_http_post()
}

