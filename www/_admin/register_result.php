<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); // Prevent SQL injection

$username = trim($_GET['uid']);
if (empty($username)) {
    echo 'URL parameter error';
    exit;
}

$sql = "SELECT username, name FROM db_admin WHERE username='$username' LIMIT 1";
$rs = mysql_query($sql);
if (!$rs) {
    mysql_close(); 
    echo 'Query fails';
    exit;
}
$user = mysql_fetch_assoc($rs);
mysql_close();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Registered Result</title>
<style type="text/css">
<!--
table {
    border-color: #c0e0c0; 
    border-style: inset;
    border-width: 4px;
}

td {
    font-size: 14pt;
}

td.hint {
    color: red;
    font-size: 20pt;
    text-align: center;
}

td.caption {
    background-color: skyblue;
    font-size: 16pt;
}

td.label {
    font-weight: bold;
}
-->
</style>
    </head>
    <body>
        <center>
<?php
if (!empty($user)) { ?>
    <table border="0" cellpadding="5" cellspacing="5">
        <tr><td colspan="2" class="hint">Congratulations successful registration</td></tr>
        <tr><td colspan="2" class="caption">Registration information is as follows:</td></tr>
        <tr><td class="label">Username:</td>
            <td><?php echo $user['username'];?></td></tr>
            <tr><td class='label'>Name:</td>
            <td><?php echo $user['name'];?></td></tr>
    </table>
<?php
}
?>
        </center>
    </body>
</html>

