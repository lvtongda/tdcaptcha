<?php
// This is a PHP library that handles calling tdCAPTCHA.

# The HTML to be embedded in the user's form.
function tdcaptcha_get_html($pubkey) {
    if($pubkey == null || $pubkey == '') {
        die ("To use tdCAPTCHA you must get an API key.");    
    }

    return '<img id="tdcaptcha_challenge_field" src="http://192.168.0.207/tdcaptcha/models/ValidatorCode.php" height="30" width="160" style="cursor:pointer" onclick="reloadcode()"><br />
        <input type="hidden" value="" name="tdcaptcha_challenge_field">
        <input type="text" value="" name="tdcaptcha_response_field">

        <script type="text/javascript">
        function reloadcode() {
            document.getElementById("tdcaptcha_challenge_field").src="http://192.168.0.207/tdcaptcha/models/ValidatorCode.php?"+Math.random();
        }
        </script>
        ';    
}
