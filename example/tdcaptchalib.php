<?php
// This is a PHP library that handles calling tdCAPTCHA.

# The tdCAPTCHA server URL's
define("TDCAPTCHA_API_SERVER", "http://192.168.0.207/tdcaptcha/models");
define("TDCAPTCHA_VERIFY_SERVER", "http://192.168.0.207/tdcaptcha/controllers");
define("TDCAPTCHA_KEY_SERVER", "http://192.168.0.207/tdcaptcha/views");

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
}

# The HTML to be embedded in the user's form.
function tdcaptcha_get_html($pubkey) {
    $server = TDCAPTCHA_KEY_SERVER;

    if($pubkey == null || $pubkey == '') {
        die ("To use tdCAPTCHA you must get an API key from <a href='".$server."/getkeyindex.php'>$server/getkeyindex.php</a>");    
    }

    $server = TDCAPTCHA_VERIFY_SERVER;

    $exit = file_get_contents("$server/ValidatorCodeAction.php?pubkey=$pubkey");
    if($exit < 1) {
        die("The publickey you used is not exists!");
    }

    $server = TDCAPTCHA_API_SERVER;

    return '<img id="tdcaptcha_response_field" src="'.$server.'/ValidatorCode.php?pubkey='.$pubkey.'" height="30" width="160" style="cursor:pointer" onclick="reloadcode()"><br />
        <input type="hidden" value="manual_challenge" name="tdcaptcha_response_field">
        <input type="text" value="" name="tdcaptcha_challenge_field">

        <script type="text/javascript">
        function reloadcode() {
            document.getElementById("tdcaptcha_response_field").src="'.$server.'/ValidatorCode.php?pubkey='.$pubkey.'&"+Math.random();
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
    $server = TDCAPTCHA_KEY_SERVER;
    
    if($privkey == null || $privkey == '') {
        die ("To use tdCAPTCHA you must get an API key from <a href='".$server."/getkeyindex.php'>$server/getkeyindex.php</a>");    
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

    $server = TDCAPTCHA_VERIFY_SERVER;

    _tdcaptcha_http_post("$server/ValidatorCodeAction.php", $pubkey);
    $answers = file_get_contents("$server/ValidatorCodeAction.php?privkey=$privkey");
    if($answers < 1) {
        die("The privatekey you used is not exists!");
    }

    $tdcaptcha_response = new TdCaptchaResponse();
    
    if($answers == '1yes') {
        $tdcaptcha_response->is_valid = true;
    }else if($answers == '1no') {
        $tdcaptcha_response->is_valid = false;
        $tdcaptcha_response->error = $_POST['tdcaptcha_challenge_field'];
    }
    return $tdcaptcha_response;
}

