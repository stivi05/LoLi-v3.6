<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
if(empty($_GET["lang"])) stderr2("Ошибка", "<center>ID указан не верно.</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
setcookie("lang", $_GET["lang"], 0x7fffffff, "/");mysql_query("UPDATE users SET language = ".sqlesc($_GET["lang"])." WHERE id = ".$CURUSER['id']);
$cache = new Memcache();$cache->connect('127.0.0.1', 11211);$cache->delete('user_cache_'.$CURUSER['id']);
header("Location: $DEFAULTBASEURL/".urlencode($_GET["returnto"]));}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
