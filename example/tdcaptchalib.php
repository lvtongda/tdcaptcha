<?php
// This is a PHP library that handles calling tdCAPTCHA.
session_start();

# The tdCAPTCHA server URL's
define("TDCAPTCHA_API_SERVER", "http://192.168.0.207/tdcaptcha");
define("TDCAPTCHA_VERIFY_SERVER", "http://192.168.0.207/tdcaptcha");

# Submits an HTTP POST to a tdCAPTCHA server
function _tdcaptcha_http_post($url, $pubkey) {
    $post_data = 'tdcaptcha_challenge_field='.urlencode($_POST['tdcaptcha_challenge_field']).'&pubkey='.urlencode($pubkey);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_exec($ch);
    curl_close($ch);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    echo $result;
}

# The HTML to be embedded in the user's form.
function tdcaptcha_get_html($pubkey) {
    if($pubkey == null || $pubkey == '') {
        die ("To use tdCAPTCHA you must get an API key.");    
    }

    $server = TDCAPTCHA_API_SERVER;

    return '<img id="tdcaptcha_response_field" src="'.$server.'/models/ValidatorCode.php?pubkey='.$pubkey.'" height="30" width="160" style="cursor:pointer" onclick="reloadcode()"><br />
        <input type="hidden" value="manual_challenge" name="tdcaptcha_response_field">
        <input type="text" value="" name="tdcaptcha_challenge_field">

        <script type="text/javascript">
        function reloadcode() {
            document.getElementById("tdcaptcha_response_field").src="'.$server.'/models/ValidatorCode.php?pubkey='.$pubkey.'&"+Math.random();
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
function tdcaptcha_check_answer($privkey, $remoteip, $challenge, $response, $pubkey) {
    if($privkey == null || $privkey == '') {
        die("To use tdCAPTCHA you must get an API key.");
    }

    if($remoteip == null || $remoteip == '') {
        die("For security reasons, you must pass the remote ip to tdCAPTCHA");
    }

    //discard spam submissions
    if($challenge == null || strlen($challenge) == 0 || $response == null || strlen($response) == 0) {
        $tdcaptcha_response = new TdCaptchaResponse();
        $tdcaptcha_response->is_valid = false;
        $tdcaptcha_response->error = 'incorrect-captcha-sol';
        return $tdcaptcha_response;
    } 

    $response = _tdcaptcha_http_post("http://192.168.0.207/tdcaptcha/controllers/ValidatorCodeAction.php", $pubkey);
    $tdcaptcha_response = new TdCaptchaResponse();

}

