<html>
    <head>
        <title>The test of tdCAPTCHA!</title>
    </head>
    <body>
        <form action="http://192.168.0.207/tdcaptcha/controllers/ValidatorCodeAction.php" method="post">
            <table>
                <tr>
                    <td>captcha:</td>
                    <td><img id="code" src="http://192.168.0.207/tdcaptcha/models/ValidatorCode.php" height="30" width="160" style="cursor:pointer" onclick="reloadcode()"></td>
                </tr>
                <tr>
                    <td>input:</td>
                    <td><input type="text" value="" name="icode"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="submit"></td>
                    </tr>
            </table>
        </form>
    </body>
</html>

<script type="text/javascript">
function reloadcode(){
    document.getElementById("code").src="http://192.168.0.207/tdcaptcha/models/ValidatorCode.php?"+Math.random();
}
</script>
