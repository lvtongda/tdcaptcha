# 验证码服务 tdCAPTCHA
一个服务器端的验证码服务，可部署为自己名下网站提供服务，也可对外服务。
### 目录结构
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
`conf`里是配置文件，`deploy`里是数据库部署文件，`example`里是验证码的使用例子，`lib`里是业务逻辑文件，`www/_admin`里是验证码管理系统文件，`content`里是生成验证码使用的字体。
### 部署说明
将`conf`、`lib`、`www`、`deploy`部署于服务器。
### 使用说明
首先，必须要有API密钥，可通过从刚刚部署的验证码服务获得。

在网站的使用：   
下载`example`目录，例子：

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
`$publickey`是从验证码服务获得的公钥，`$privatekey`是从验证码服务获得的密钥。