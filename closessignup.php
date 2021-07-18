<?php require_once("include/bittorrent.php");dbconn(false);gzip();if($CURUSER && get_user_class() >= UC_SYSOP){
global $CacheBlock, $rootpath;$_signupsch = "signup.cache";
$signup = (int)$_GET['signup'];stdhead("Регистрация на сайте");begin_frame(".:: Регистрация пользователей на сайте ::.");
if ($signup != ""){if ($signup == 1){mysql_query("UPDATE config SET value = '1' WHERE name = 'signup'");
$signups_cache = $rootpath."include/cache/signup.cache";if(file_exists($signups_cache)){unlink($rootpath."include/cache/signup.cache");}
$res = sql_query("SELECT * FROM config WHERE name = 'signup'");$row = mysql_fetch_array($res);$CacheBlock->Write($_signupsch, $row);
write_log("Registrations open by $CURUSER[username]");}
if ($signup == 2){mysql_query("UPDATE config SET value = '0' WHERE name = 'signup'");
$signups_cache = $rootpath."include/cache/signup.cache";if(file_exists($signups_cache)){unlink($rootpath."include/cache/signup.cache");}
$res = sql_query("SELECT * FROM config WHERE name = 'signup'");$row = mysql_fetch_array($res);$CacheBlock->Write($_signupsch, $row);
write_log("Registration closed by $CURUSER[username]");}}
$signups_cache = $rootpath."include/cache/signup.cache";if(!file_exists($signups_cache)){
$res = sql_query("SELECT * FROM config WHERE name = 'signup'");$row = mysql_fetch_array($res);$CacheBlock->Write($_signupsch, $row);}
else $signups = $CacheBlock->Read($_signupsch);if($signups['vibor'] == 0){
print("<tr><td class='embedded' style='background-color: #FF0000;padding-bottom: 5px'  colspan='4' width='100%'><center>
<font color=#FFD700>Регистрация <b>ЗАКРЫТА</b></font><center></td></tr><tr><td align=\"center\">
<a href='?signup=1'><input type='button' class='button4' value='Нажмите здесь, чтобы ОТКРЫТЬ регистрацию!'></a></td></tr>");
end_frame();stdfoot();}else{print("<tr><td class='embedded' style='background-color: #FFD700;padding-bottom: 5px' colspan='4' align='center' width='100%'>
<center><font color=#FF0000>Регистрация <b>ОТКРЫТА</b></font></center></td></tr><tr><td align=\"center\">
<a href='?signup=2'><input type='button' class='button4' value='Нажмите здесь, чтобы ЗАКРЫТЬ регистрацию!'></a></td></tr>");
end_frame();stdfoot();}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>