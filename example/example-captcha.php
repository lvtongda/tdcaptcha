<html>
    <body>
        <form action="http://192.168.0.207/tdcaptcha/controllers/ValidatorCodeAction.php" method="post">
<?php

require_once('tdcaptchalib.php');

// Get a key
$publickey = "026025a0bf4f95530552c6233d98c7cf";
$privatekey = "702104ada24631a3eb913197a527c760";

# Get a tdCAPTCHA response
echo tdcaptcha_get_html($publickey);

?>
        <br />
        <input type="submit" value="submit" />
        </form>
    </body>
</html>
