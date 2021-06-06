<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){global $CacheBlockus;
if(empty($_GET["lang"])) stderr("Ошибка", "<center>ID указан не верно.</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
setcookie("lang", $_GET["lang"], 0x7fffffff, "/");mysql_query("UPDATE users SET language = ".sqlesc($_GET["lang"])." WHERE id = ".$CURUSER['id']);
$_cacheu = "user_".$CURUSER['id'].".cache";$res = sql_query("SELECT * FROM users WHERE id = ".$CURUSER['id']);$row = mysql_fetch_array($res);$CacheBlockus->Writeus($_cacheu, $row);
header("Location: $DEFAULTBASEURL/".urlencode($_GET["returnto"]));}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>