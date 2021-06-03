<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){if(empty($_GET['q'])){header("Refresh: 0; url=/");}else{
if(strlen($_GET['q']) > 3){$q = str_replace(" ",".",sqlesc("%".$_GET['q']."%"));$q2 = str_replace("."," ",sqlesc("%".$_GET['q']."%"));
$result = mysql_query("SELECT id, username, class FROM users WHERE username LIKE {$q} OR username LIKE {$q2} ORDER BY id DESC LIMIT 0,10;");
if(mysql_num_rows($result) > 0){for ($i = 0; $i < mysql_num_rows($result); $i++){$id = mysql_result($result,$i,"id");$class = mysql_result($result,$i,"class");
$username = mysql_result($result,$i,"username");$username = trim(str_replace("\t","",$username));print "<a href='user_$id'>".get_user_class_color($class,$username)."</a>";
if($i != mysql_num_rows($result)-1){print "\r\n";}}}else{print "<font color='red'>Нет такого юзера</font>";}}}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>