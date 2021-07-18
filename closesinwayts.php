<?php require_once("include/bittorrent.php");dbconn(false);gzip();if ($CURUSER && get_user_class() >= UC_SYSOP){
global $CacheBlock, $rootpath;$_inwaytsch = "inwayts.cache";
$inwayts = (int)$_GET['inwayts'];stdhead("Регистрация по инвайтам на сайте");begin_frame(".:: Регистрация по инвайтам на сайте ::.");
if ($inwayts != ""){if($inwayts == 1){sql_query("UPDATE inwayts SET vibor = '1' WHERE name = 'inwayts'");
$inwayts_cache = $rootpath."include/cache/inwayts.cache";if(file_exists($inwayts_cache)){unlink($rootpath."include/cache/inwayts.cache");}
$res = sql_query("SELECT * FROM inwayts WHERE name = 'inwayts'");$row = mysql_fetch_array($res);$CacheBlock->Write($_inwaytsch, $row);
write_log("Registrations po inwayts open by $CURUSER[username]");}
if($inwayts == 2){sql_query("UPDATE inwayts SET vibor = '0' WHERE name = 'inwayts'");
$inwayts_cache = $rootpath."include/cache/inwayts.cache";if(file_exists($inwayts_cache)){unlink($rootpath."include/cache/inwayts.cache");}
$res = sql_query("SELECT * FROM inwayts WHERE name = 'inwayts'");$row = mysql_fetch_array($res);$CacheBlock->Write($_inwaytsch, $row);
write_log("Registration po inwayts closed by $CURUSER[username]");}}
$inwayts_cache = $rootpath."include/cache/inwayts.cache";if(!file_exists($inwayts_cache)){
$res = sql_query("SELECT * FROM inwayts WHERE name = 'inwayts'");$row = mysql_fetch_array($res);$CacheBlock->Write($_inwaytsch, $row);}
else $inwayts = $CacheBlock->Read($_inwaytsch);if($inwayts['vibor'] == 0){
print("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\"><center><tr>
<td class=embedded style='background-color: #FF0000;padding-bottom: 5px'  colspan=4 align=center width=100% >
<center><font color=#FFD700>Регистрация по <b>ИНВАЙТАМ</b></font></center></td></tr><tr><td align=\"center\">
<a href=?inwayts=1><input type=button class=button4 value='Нажмите здесь, чтобы регистрация была БЕЗ Инвайтов!'></a></td></tr><center></table>");
end_frame();stdfoot();}else{
print("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\"><center><tr>
<td class=embedded style='background-color: #FFD700;padding-bottom: 5px'  colspan=4 align=center width=100% >
<center><font color=#FF0000>Регистрация <b>БЕЗ ИНВАЙТОВ</b></font></center></td></tr><tr><td align=\"center\">
<a href=?inwayts=2><input type=button class=button4 value='Нажмите здесь, чтобы регистрация была ПО Инвайтам!'></a></td></tr><center></table>");
end_frame();stdfoot();}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>