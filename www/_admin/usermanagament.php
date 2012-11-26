<html>
    <head>
        <title>User managament</title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
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
-->
</style>
<script type='text/javascript'>
<!--
function deleteclient() {
    confirm('确定要删除吗？');
}
-->
</script>
    </head>
    <body>
<?php
require_once('../../conf/config.php');
require_once('common.php'); //引入公共文件，其中实现了SQL注入漏洞检查的代码

//设置每一页显示的记录数
$pagesize = 10;
//取得总记录数$rs，计算总页使用
$sql = 'SELECT count(*) FROM db_client';
$rs = mysql_query($sql);
$myrow = mysql_fetch_array($rs);
$numrows = $myrow[0];
//计算总页数
$pages = intval($numrows / $pagesize);
if($numrows % $pagesize) {
    $pages++;
}
//设置页数
if(isset($_GET['page'])) {
    $page = intval($_GET['page']);
}else {
    //设置为第一页
    $page = 1;
}
//计算记录偏移量
$offset = $pagesize * ($page -1);
//读取指定记录数
$sql = "SELECT * FROM db_client ORDER BY id LIMIT $offset, $pagesize";
$rs = mysql_query($sql);
if($myrow = mysql_fetch_array($rs)) {
    $i = 0;
?>
    <table border='1' cellpadding='0' cellspacing='0' style='width: 100%'>
        <h3><a href='addclient.php'>添加用户</a></h3>
        <tr><td colspan='6' class='hint'>用户信息</td></tr>
        <tr>
            <td>ID</td>
            <td>域名</td>
            <td>公钥</td>
            <td>私钥</td>
            <td>编辑</td>
            <td>删除</td>
        </tr>
<?php
    do {
        $i++;
?>
        <tr>
            <td><?=$myrow['id'];?></td>
            <td><?=$myrow['weburl'];?></td>
            <td><?=$myrow['publickey'];?></td>
            <td><?=$myrow['privatekey']?></td>
            <td><a href='modifyclient.php?clientid=<?=$myrow['id']?>&&web=<?=$myrow['weburl'];?>&&pubkey=<?=$myrow['publickey'];?>&&prikey=<?=$myrow['privatekey'];?>'>编辑</a></td>
            <td onclick='deleteclient()'><a href='deleteclient.php?clientid=<?=$myrow['id']?>'>删除</a></td>
        </tr>
<?php
    }
    while($myrow = mysql_fetch_array($rs));
        echo "</table>";
}
echo "<br />";
echo "<div align='center'>共有".$pages."页(".$page."/".$pages.")&nbsp;";
for($i = 1;$i <= $pages;$i++) {
    if($i % 15 == 0) {
        echo "<br />";
    }
    echo "<a href='usermanagament.php?page=".$i."'>[".$i."]&nbsp;&nbsp;</a>";
}
    echo "</div>";
?>
    </body>
</html>
