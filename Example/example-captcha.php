<html>
  <meta http-equiv="Content-Type" content="text/html;charset=utf8" />
  <body>
    <form action="http://tdcaptcha.com/Controllers/ValidatorCodeAction.php" method="post">
<?php
require_once('tdcaptchalib.php');

//又拍网（www.yupoo.com）
$publickey = 'b7c06906733d7a4912d6d0d2faef5e50';

//花瓣网（huaban.com）
$publickey = 'd800ae51a8af9790a5e9da430f@2b89';

tdcaptcha_get_html($publickey);
?>
    <br/>
    <input type="submit" value="马上注册" />
    </form>
  </body>
</html>
