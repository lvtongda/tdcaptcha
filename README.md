---
layout: post
title: zinaer-captcha - A CAPTCHA service
date: 2012-08-22
tag:
- CAPTCHA
projects: true
author: xiao
comments: true
---

[zinaer-captcha](https://github.com/lvtongda/zinaer-captcha) is a server-side CAPTCHA service, can be deployed to provide service.

## Directory tree

```
├── conf
│   └── config_sample.php
├── deploy
│   └── db_schema
│       └── db_tdcaptcha.sql
├── example
│   ├── captcha.php
│   └── tdcaptchalib.php
├── lib
│   ├── compare.php
│   ├── create_sessionid.php
│   └── validator_code.php
├── README.txt
└── www
    ├── _admin
    │   ├── add_admin.php
    │   ├── add_client.php
    │   ├── common.php
    │   ├── delete_client.php
    │   ├── login.php
    │   ├── modify_client.php
    │   ├── purge_validator_code.php
    │   ├── register.php
    │   ├── register_result.php
    │   └── user_manage.php
    ├── content
    │   └── scraps.ttf
    └── index.php
```

## Deploy

Copy `conf`、`lib`、`www`、`deploy` to your server(LNMP).

## Use

Obtain the key from the service you just deployed.

Used in the website

```
<html>
    <body>
        <form action="" method="post">
<?php

require_once('tdcaptchalib.php');
// Get a key
$publickey = ''; 
$privatekey = ''; 

// the response from tdCAPTCHA
$resp = null;
$error = null;

// was there a tdCAPTCHA response?
if (@$_POST['tdcaptcha_response_field']) {
    $resp = tdcaptcha_check_answer($privatekey,
        $_POST['tdcaptcha_challenge_field'],
        $_POST['tdcaptcha_response_field']);

    if($resp->is_valid) {
        echo "You got it!";
    }   
    else {
        // set the error code so that we can display it 
        $error = $resp->error;
        echo $error;
    }   
    exit;
}

// Get a tdCAPTCHA response
echo tdcaptcha_get_html($publickey, $privatekey);

?>
        <br />
        <input type="submit" value="submit" />
        </form>
    </body>
</html>
```

`$publickey` is the public key，`$privatekey` is the private key.
