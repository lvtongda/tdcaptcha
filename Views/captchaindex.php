<?php
if($pubkey = 'b7c06906733d7a4912d6d0d2faef5e50' || $pubkey = 'd800ae51a8af9790a5e9da430f@2b89' || $pubkey = 'ff3e266ba02dac2d2595cb3e0227516d'){
        echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />';
        echo '<img src="http://tdcaptcha.com/Models/ValidatorCode.php" id="code" /><br />';
        echo '<input type="text" value="" name="scode"><br />';
        echo '<span>看不清，<a href=javascript:document.getElementById("code").src="http://tdcaptcha.com/Models/ValidatorCode.php?t="+Math.random();"">换一组</a></span>';   
    }else{
        die("To use an right API key.");
    }
?>
