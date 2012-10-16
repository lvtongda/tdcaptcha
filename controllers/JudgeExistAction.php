<?php
require_once('../config/config_global.php');

$pubkey = $_GET['pubkey'];
$privkey = $_GET['privkey'];

if($pubkey) {
    $sql = "SELECT count(*) FROM db_tdcaptcha WHERE publickey='$pubkey'";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)) {
        $count = $row['count(*)'];
    }
    echo $count;
}

if($privkey) {
    $sql = "SELECT count(*) FROM db_tdcaptcha WHERE privatekey='$privkey'";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)) {
        $count = $row['count(*)'];
    }
    echo $count;
}
