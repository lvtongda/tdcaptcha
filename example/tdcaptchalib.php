<?php
// This is a PHP library that handles calling tdCAPTCHA.

# The tdCAPTCHA server URL's
define("TDCAPTCHA_API_SERVER", "http://captcha.orzz.in/tdcaptcha/models");
define("TDCAPTCHA_VERIFY_SERVER", "http://captcha.orzz.in/tdcaptcha/controllers");
define("TDCAPTCHA_KEY_SERVER", "http://captcha.orzz.in/tdcaptcha/views");

# Submits an HTTP POST to a tdCAPTCHA server
function _tdcaptcha_http_post($url, $privkey, $challenge, $response) {
    $post_data = array(
        'privkey' => $privkey,
        'tdcaptcha_challenge_field' => $challenge,
        'tdcaptcha_response_field' => $response,
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

# The HTML to be embedded in the user's form.
function tdcaptcha_get_html($pubkey, $privkey) {/*{{{*/
    $server = TDCAPTCHA_KEY_SERVER;

    if($pubkey == null || $pubkey == '') {
        die ("To use tdCAPTCHA you must get an API key from <a href='".$server."/getkeyindex.php'>$server/getkeyindex.php</a>");    
    }

    if($privkey == null || $privkey == '') {
        die ("To use tdCAPTCHA you must get an API key from <a href='".$server."/getkeyindex.php'>$server/getkeyindex.php</a>");    
    }
    
    $server = TDCAPTCHA_VERIFY_SERVER;

    $exit = file_get_contents("$server/ValidatorCodeAction.php?pubkey=$pubkey");
    if($exit == 'no') {
        die("The publickey you used is not exists! Please check it.");
    }


    $server = TDCAPTCHA_API_SERVER;
    $servert = TDCAPTCHA_VERIFY_SERVER;

    return '<img id="tdcaptcha_response_field" src="'.$server.'/ValidatorCode.php?privkey='.$privkey.'" height="30" width="160" style="cursor:pointer" onclick="reloadcode()"><br />
        <input type="hidden" id="sessionid" value="manual_challenge" name="tdcaptcha_response_field">
        <input type="text" value="" name="tdcaptcha_challenge_field">

        <script type="text/javascript">
        function showcode(sid) {
            document.getElementById("sessionid").value= sid;
        }
        </script>
        <script type="text/javascript" src="'.$servert.'/SessionidCreateAction.php?jsonp=showcode()"></script>
        <script type="text/javascript">
        function reloadcode() {
            document.getElementById("tdcaptcha_response_field").src="'.$server.'/ValidatorCode.php?privkey='.$privkey.'&"+Math.random();
        }
        </script>
        ';    
}/*}}}*/

# A TdCaptchaResponse is returned from tdcaptcha_check_answer()
class TdCaptchaResponse {
    var $is_valid;
    var $error;
}

# Calls an HTTP POST function to verify if the user's guess was correct
function tdcaptcha_check_answer($privkey, $challenge, $response) {
    if($challenge == null || strlen($challenge) == 0 || $response == null || strlen($response) == 0) {
        $tdcaptcha_response = new TdCaptchaResponse();
        $tdcaptcha_response->is_valid = false;
        $tdcaptcha_response->error = 'incorrect-captcha-sol';
        return $tdcaptcha_response;
    } 

    $server = TDCAPTCHA_VERIFY_SERVER;
    $answers = _tdcaptcha_http_post($server.'/ValidatorCodeAction.php', $privkey, $challenge, $response);
    $tdcaptcha_response = new TdCaptchaResponse();
    if($answers == 'true') {
        $tdcaptcha_response->is_valid = true;
    }else {
        $tdcaptcha_response->is_valid = false;
        $tdcaptcha_response->error = $answers;
    }

    return $tdcaptcha_response;
}

