<?php
# This is a PHP library that handles calling tdCAPTCHA.

# The tdCAPTCHA server URL's
define("TDCAPTCHA_VERIFY_SERVER", "http://lvtongda.com/tdcaptcha/lib");
define("TDCAPTCHA_KEY_SERVER", "http://lvtongda.com/tdcaptcha/www");

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
function tdcaptcha_get_html($pubkey, $privkey) {
    $server = TDCAPTCHA_KEY_SERVER;

    if ($pubkey == null || $pubkey == '') {
        die ("To use tdCAPTCHA you must get an API key from <a href='".$server."/index.php'>$server/index.php</a>");    
    }

    if ($privkey == null || $privkey == '') {
        die ("To use tdCAPTCHA you must get an API key from <a href='".$server."/index.php'>$server/index.php</a>");    
    }
    
    $server = TDCAPTCHA_VERIFY_SERVER;

    $exit = file_get_contents("$server/compare.php?pubkey=$pubkey");
    if ($exit == 'no') {
        die("The publickey you used is not exists! Please check it.");
    }

    return '<img id="tdcaptcha_image" src="'.$server.'/validator_code.php?pubkey='.$pubkey.'" height="30" width="160" style="cursor:pointer" onclick="reloadcode()"><br />
        <input type="hidden" id="tdcaptcha_challenge_field" value="" name="tdcaptcha_challenge_field">
        <input type="text" value="" name="tdcaptcha_response_field">

        <script type="text/javascript">
            function showcode(sid) {
                document.getElementById("tdcaptcha_challenge_field").value= sid;
            }
            function reloadcode() {
                sid = document.getElementById("tdcaptcha_challenge_field").value;
                document.getElementById("tdcaptcha_image").src="'.$server.'/validator_code.php?pubkey='.$pubkey.'&clientsonid="+sid+"&"+Math.random();
            }
        </script>
        <script type="text/javascript" src="'.$server.'/create_sessionid.php?callback=showcode"></script>
        ';    
}

# A TdCaptchaResponse is returned from tdcaptcha_check_answer()
class TdCaptchaResponse {
    var $is_valid;
    var $error;
}

# Calls an HTTP POST function to verify if the user's guess was correct
function tdcaptcha_check_answer($privkey, $challenge, $response) {
    if ($challenge == null || strlen($challenge) == 0 || $response == null || strlen($response) == 0) {
        $tdcaptcha_response = new TdCaptchaResponse();
        $tdcaptcha_response->is_valid = false;
        $tdcaptcha_response->error = 'incorrect-captcha-sol';
        return $tdcaptcha_response;
    } 

    $server = TDCAPTCHA_VERIFY_SERVER;
    $answers = _tdcaptcha_http_post($server.'/compare.php', $privkey, $challenge, $response);
    $tdcaptcha_response = new TdCaptchaResponse();
    if ($answers == 'true') {
        $tdcaptcha_response->is_valid = true;
    }
    else {
        $tdcaptcha_response->is_valid = false;
        $tdcaptcha_response->error = $answers;
    }

    return $tdcaptcha_response;
}

