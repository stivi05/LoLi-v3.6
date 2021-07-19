<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){$from = 0+$_GET["from"]; 
if(!$from || $_GET["to"] <> "next" && $_GET["to"] <> "pre") stderr2("<center>Ошибка</center>","<center>Как вы сюда попали? <a href=\"javascript:history.go(-1)\">Назад</a></center>"); 
$pass = ($_GET["to"] == "next" ? "> ".$from." ORDER BY id ASC" : "< ".$from." ORDER BY id DESC");$err = ($_GET["to"] == "next" ? "<center>Вы уже были на последнем Пользователе. 
<a href=\"javascript:history.go(-1)\">Назад</a>" : "Вы были на первом Пользователе. <a href=\"javascript:history.go(-1)\">Назад</a></center>"); 
$to = mysql_query("SELECT id FROM users WHERE id ".$pass." LIMIT 1");$to = mysql_fetch_assoc($to);$to = $to["id"];if(!$to) stderr2("<center>Ошибка!</center>", $err);
header("Location: $DEFAULTBASEURL/userdetails.php?id=".$to);}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>