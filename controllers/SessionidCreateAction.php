<?php
session_start();
$sessionid = json_encode(md5(session_id()+'shijieheping'));
echo "showcode('$sessionid');";
