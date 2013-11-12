<style type='text/css'>
<!--
table {
    border-color: #6BBEEA;
}

td {
    font-size: 14pt;
}

td {
    text-align: center;
}
td.hint {
    font-size: 16pt;
    background-color: #B0E6FE;
}

a {
    text-decoration: none;
}
a:hover {
    color: red;
}

div {
    font-size: 14pt;
}
.button {
    
}
-->
</style>
<script type='text/javascript'>
function deleteclient() {
    return confirm('OK to delete it ?');
}
</script>
<?php
header('Content-Type:text/html; charset=utf-8');
require_once('../../conf/config.php');
require_once('common.php'); // Prevent SQL injection

session_start();
if (isset($_SESSION['uid'])) {
    echo "<a href='add_client.php'><input type='button' value='Add User' /></a>";
    echo "<a href='add_admin.php'><input type='button' value='Add an administrator' /></a>";
    $pagesize = 10;
    $sql = 'SELECT count(*) FROM db_client';
    $rs = mysql_query($sql);
    $myrow = mysql_fetch_array($rs);
    $numrows = $myrow[0];
    $pages = intval($numrows / $pagesize);
    if($numrows % $pagesize) {
        $pages++;
    }
    if(isset($_GET['page'])) {
        $page = intval($_GET['page']);
    }else {
        $page = 1;
    }
    $offset = $pagesize * ($page -1);
    $sql = "SELECT * FROM db_client ORDER BY id LIMIT $offset, $pagesize";
    $rs = mysql_query($sql);
    if($myrow = mysql_fetch_array($rs)) {
        $i = 0;

        echo "<table border='1' cellpadding='0' cellspacing='0' style='width: 100%'>
            <tr><td colspan='6' class='hint'>User Information</td></tr>
            <tr>
                <td>ID</td>
                <td>Domain name</td>
                <td>Public key</td>
                <td>Private key</td>
                <td>Edit</td>
                <td>Delete</td>
            </tr>";
        do {
            $i++;

           echo "<tr>
                <td>".$myrow['id']."</td>
                <td>".$myrow['weburl']."</td>
                <td>".$myrow['publickey']."</td>
                <td>".$myrow['privatekey']."</td>
                <td><a href='modify_client.php?clientid=".$myrow['id']."&&web=".$myrow['weburl']."&&pubkey=".$myrow['publickey']."&&prikey=".$myrow['privatekey']."'>Edit</a></td>
                <td><a href='delete_client.php?clientid=".$myrow['id']."' onclick='return deleteclient();'>Delete</a></td>
            </tr>";
        }
        while($myrow = mysql_fetch_array($rs));
            echo "</table>";
    }
    echo "<br />
        <div align='center'>Total ".$pages." pages(".$page."/".$pages.")&nbsp;";
    for($i = 1;$i <= $pages;$i++) {
        if($i % 15 == 0) {
            echo "<br />";
        }
        echo "<a href='user_manage.php?page=".$i."'>[".$i."]&nbsp;&nbsp;</a>";
    }
        echo "</div>
        </body>
    </html>";
}else {
    header('location: login.php');
    exit;
}
