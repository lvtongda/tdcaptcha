<html>
    <body>
        <form action="" method="post">
<?php

require_once('tdcaptchalib.php');
# Get a key
$publickey = '';
$privatekey = '';

# the response from tdCAPTCHA
$resp = null;
$error = null;

# was there a tdCAPTCHA response?
if (@$_POST['tdcaptcha_response_field']) {
    $resp = tdcaptcha_check_answer($privatekey,
        $_POST['tdcaptcha_challenge_field'],
        $_POST['tdcaptcha_response_field']);

    if ($resp->is_valid) {
        echo "You got it!";
    }
    else {
        # set the error code so that we can display it 
        $error = $resp->error;
        echo $error;
    }
    exit;
}

# Get a tdCAPTCHA response
echo tdcaptcha_get_html($publickey, $privatekey);

?>
        <br />
        <input type="submit" value="submit" />
        </form>
    </body>
</html>
