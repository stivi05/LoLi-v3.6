<? if(!defined('IN_TRACKER')) die('Hacking attempt!');
function docleanup(){global $autoclean_interval, $points_per_cleanup, $tracker_lang, $maxusers, $CacheBlock;
////////////////////
$cache = new Memcache();$cache->connect('127.0.0.1', 11211); // IP вашего сервера и порт Мемкеша
$user = $cache->get('user_cache_2');$sender_class = $user['class'];$sender_username = $user['username'];$sender_avatar = $user['avatar']; // данные БОТА вашего с ID = 2
/////////////////////
@set_time_limit(0);@ignore_user_abort(1);$deadtime = deadtime();
sql_query("DELETE FROM peers WHERE last_action < FROM_UNIXTIME($deadtime)") or sqlerr(__FILE__,__LINE__);
sql_query("UPDATE snatched SET seeder = 'no' WHERE seeder = 'yes' AND last_action < FROM_UNIXTIME($deadtime)");$torrents = array();
$res = sql_query("SELECT torrent, seeder, COUNT(*) AS c FROM peers GROUP BY torrent, seeder") or sqlerr(__FILE__,__LINE__);
while ($row = mysql_fetch_assoc($res)){if ($row["seeder"] == "yes")$key = "seeders";else $key = "leechers";$torrents[$row["torrent"]][$key] = $row["c"];}
$res = sql_query("SELECT torrent, COUNT(*) AS c FROM comments GROUP BY torrent") or sqlerr(__FILE__,__LINE__);
while ($row = mysql_fetch_assoc($res)){$torrents[$row["torrent"]]["comments"] = $row["c"];}$fields = explode(":", "comments:leechers:seeders");
$res = sql_query("SELECT id, seeders, leechers, comments FROM torrents") or sqlerr(__FILE__,__LINE__);while ($row = mysql_fetch_assoc($res)){$id = $row["id"];$torr = $torrents[$id];
foreach ($fields as $field){if(!isset($torr[$field]))$torr[$field] = 0;}$update = array();foreach ($fields as $field){if($torr[$field] != $row[$field])$update[] = "$field = " . $torr[$field];}
if(count($update)){
sql_query("UPDATE torrents SET ".implode(", ", $update)." WHERE id = $id") or sqlerr(__FILE__,__LINE__);
sql_query("UPDATE browse SET ".implode(", ", $update)." WHERE id = $id") or sqlerr(__FILE__,__LINE__);}}
///////////////////
//sql_query("UPDATE users SET comentoff = 'yes', schoutboxpos = 'yes'") or sqlerr(__FILE__,__LINE__);
////////// Снятие "Торрент обновлен спустя 4 дня НАЧАЛО //////////////
$dtrr = sqlesc(get_date_time(gmtime() - 4*86400));$updatetorr = sql_query("SELECT id FROM torrents WHERE updatess = 'yes' AND added < $dtrr") or sqlerr(__FILE__,__LINE__);
if(mysql_num_rows($updatetorr) > 0){while($updatetorrs = mysql_fetch_array($updatetorr)){
sql_query("UPDATE torrents SET updatess = 'no' WHERE id = ".sqlesc($updatetorrs["id"])) or sqlerr(__FILE__,__LINE__);}}
////////// Снятие "Торрент обновлен спустя 4 дня КОНЕЦ //////////////
$maximers = sqlesc(get_date_time(gmtime() - 1800));$timerts = sql_query("SELECT id FROM sessions WHERE time < $maximers") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($timerts) > 0){while($timertsa = mysql_fetch_array($timerts)){
sql_query("DELETE FROM sessions WHERE id = ".sqlesc($timertsa["id"])) or sqlerr(__FILE__,__LINE__);
}write_log("Таблица сессий очищена системой.", "5DDB6E", "tracker");}
//////// Авто-бан всех двоных аккаунтов НАЧАЛО /////////////
$resd = sql_query("SELECT count(*) AS dupl, ip FROM users WHERE ip <> '' GROUP BY ip ORDER BY dupl DESC") or sqlerr(__FILE__, __LINE__);
while($rasd = mysql_fetch_assoc($resd)){if($rasd["dupl"] <= 1)break;
$rosd = sql_query("SELECT id, username, enabled FROM users WHERE id <> '1' AND id <> '2' AND id <> '3' AND id <> '7' AND ip='".$rasd['ip']."' ORDER BY id DESC") or sqlerr(__FILE__, __LINE__);
while($arr = mysql_fetch_assoc($rosd)){if($arr['enabled'] == 'yes'){
sql_query("UPDATE users SET enabled = 'yes' WHERE id = ".$arr['id']) or sqlerr(__FILE__, __LINE__);
sql_query("INSERT INTO bans (added, addedby, first, comment, haker) VALUES(NOW(), 2, ".sqlesc($rasd['ip']).", ".sqlesc('Дубль-аккаунты запрещены! Авто-бан с отключением всех двойных аккаунтов!').", 'no')") or sqlerr(__FILE__, __LINE__);
$subject = "АВТО-Бан Дабл-акаунта";$msg = "Юзер ".$arr["username"]." попал в Авто-Бан, так как поиск нашел двойные аккаунты с этого IP: ".$rasd["ip"];
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", 1, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");$cache->delete('user_cache_'.$arr['id']);
write_log("Юзер ".$arr["username"]." попал в Авто-Бан, так как поиск нашел двойные аккаунты с этого IP: ".$rasd["ip"]."", "5DDB6E", "bans");}}}
//////// Авто-бан всех двоных аккаунтов КОНЕЦ /////////////
/////// Авто-очистка в скрепке Анонсов - Ошибка (НЕ рабочих) НАЧАЛО /////////
$tscrape = sql_query("SELECT tid FROM torrents_scrape WHERE state = 'error'") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($tscrape) > 0){sql_query("DELETE FROM torrents_scrape WHERE state = 'error'") or sqlerr(__FILE__,__LINE__);}
/////// Авто-очистка в скрепке Анонсов - Ошибка (НЕ рабочих) КОНЕЦ /////////
//удаление неактивных учетных записей пользователей 45 дней после регистрации
$limitli = 11*1024*1024*1024;$secsn = 92*86400;$dt1 = sqlesc(get_date_time(gmtime() - $secsn));$maxclassn = UC_1080i;
$ress1 = sql_query("SELECT id, avatar FROM users WHERE class <= $maxclassn AND downloaded < $limitli AND added < $dt1") or sqlerr(__FILE__,__LINE__);
if(mysql_num_rows($ress1) > 0){while ($arr1 = mysql_fetch_assoc($ress1)){
$ids = $arr1["id"];$avatar = $arr1['avatar'];if($avatar) unlink($arr1['avatar']);
sql_query("DELETE FROM users WHERE id = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM snatched WHERE userid = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM friends WHERE userid = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM friends WHERE friendid = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM blocks WHERE userid = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM blocks WHERE blockid = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM bookmarks WHERE userid = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM invites WHERE inviter = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM peers WHERE userid = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM checkcomm WHERE userid = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM reqcomments WHERE user = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__); 
sql_query("DELETE FROM requests WHERE userid = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__); 
sql_query("DELETE FROM addedrequests WHERE userid = ".sqlesc($arr1["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Пользователь id=".$ids." удален с сайта системой, так как он ничего не скачал за 45 дней после регистрации.", "5DDB6E", "tracker");}}
//delete inactive user accounts 45 дней после регистрации
//delete inactive user accounts
$secsi = 92*86400;$dti = sqlesc(get_date_time(gmtime() - $secsi));$maxclassi = UC_1080i;
$resi = sql_query("SELECT id, avatar FROM users WHERE parked='no' AND status='confirmed' AND class <= $maxclassi AND last_access < $dti AND last_access <> '0000-00-00 00:00:00'") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($resi) > 0){
while ($arri = mysql_fetch_assoc($resi)){$idr = $arri["id"];$avatar = $arri['avatar'];if($avatar) unlink($arri['avatar']);
sql_query("DELETE FROM users WHERE id = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM snatched WHERE userid = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("UPDATE messages SET receiver = 2 WHERE receiver = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM friends WHERE userid = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM friends WHERE friendid = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM blocks WHERE userid = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM blocks WHERE blockid = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM bookmarks WHERE userid = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM invites WHERE inviter = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM peers WHERE userid = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM checkcomm WHERE userid = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM reqcomments WHERE user = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__); 
sql_query("DELETE FROM requests WHERE userid = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__); 
sql_query("DELETE FROM addedrequests WHERE userid = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Пользователь id=".$idr." удален с сайта системой, так как аккаунт не паркованный и не заходил на сайт в течении 92 дней.", "5DDB6E", "tracker");}}
//delete parked user accounts
$secs = 300*86400;$dt = sqlesc(get_date_time(gmtime() - $secs));$maxclass = UC_1080i;
$res = sql_query("SELECT id, avatar FROM users WHERE parked='yes' AND status='confirmed' AND class <= $maxclass AND last_access > $dt");
if(mysql_num_rows($res) > 0){
while ($arr = mysql_fetch_array($res)){$ide = $arr["id"];$avatar = $arr['avatar'];if($avatar) unlink($arr['avatar']);
sql_query("DELETE FROM users WHERE id = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM snatched WHERE userid = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("UPDATE messages SET receiver = 2 WHERE receiver = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM friends WHERE userid = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM friends WHERE friendid = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM blocks WHERE userid = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM blocks WHERE blockid = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM bookmarks WHERE userid = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM invites WHERE inviter = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM peers WHERE userid = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM checkcomm WHERE userid = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__);
sql_query("DELETE FROM reqcomments WHERE user = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__); 
sql_query("DELETE FROM requests WHERE userid = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__); 
sql_query("DELETE FROM addedrequests WHERE userid = ".sqlesc($arr["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Пользователь id=".$ide." удален с сайта системой, так как не заходил на сайт в течении 300 дней (аккаунт паркованый).", "5DDB6E", "tracker");}}
//Удаляем все не сохраненные прочтенные системные сообщения старше 3 дней
$secs_system = 3*86400;$dt_system = sqlesc(get_date_time(gmtime() - $secs_system));
$resy = sql_query("SELECT id FROM messages WHERE sender = '0' AND sender = '2' AND saved = 'no' AND unread = 'no' AND added < $dt_system") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($resy) > 0){while ($ary = mysql_fetch_array($resy)){sql_query("DELETE FROM messages WHERE id = ".sqlesc($ary["id"]));
write_log("Удалены все не сохраненные, прочтенные системные сообщения старше 3 дней", "5DDB6E", "tracker");}}
//Удаляем все не сохраненные системные сообщения старше 7 дней
$secs_sysunread = 7*86400;$dt_sysunread = sqlesc(get_date_time(gmtime() - $secs_sysunread));
$resz = sql_query("SELECT id FROM messages WHERE sender = '0' AND sender = '2' AND saved = 'no' AND added < $dt_sysunread") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($resz) > 0){while ($arz = mysql_fetch_array($resz)){sql_query("DELETE FROM messages WHERE id = ".sqlesc($arz["id"]));
write_log("Удалены все прочтенные системные сообщения старше 3 дней", "5DDB6E", "tracker");}}
//Удаляем ВСЕ прочтенные сообщения старше 3 дней
$secs_all_read = 3*86400;$dt_all_read = sqlesc(get_date_time(gmtime() - $secs_all_read));
$reg = sql_query("SELECT id FROM messages WHERE unread = 'no' AND saved = 'no' AND added < $dt_all_read") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($reg) > 0){while ($arg = mysql_fetch_array($reg)){sql_query("DELETE FROM messages WHERE id = ".sqlesc($arg["id"]));
write_log("Удалены все прочтенные сообщения старше 3 дней", "5DDB6E", "tracker");}}
//Удаляем ВСЕ не сохраненные сообщения старше 7 дней
$secs_all_mess = 7*86400;$dt_all_mess = sqlesc(get_date_time(gmtime() - $secs_all_mess));
$rea = sql_query("SELECT id FROM messages WHERE saved = 'no' AND added < $dt_all_mess") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($rea) > 0){while ($ara = mysql_fetch_array($rea)){sql_query("DELETE FROM messages WHERE id = ".sqlesc($ara["id"]));
write_log("Удалены ВСЕ не сохраненные сообщения старше 7 дней", "5DDB6E", "tracker");}}
//Удаляем ВСЕ сообщения старше 90 дней
$secs_all_messl = 90*86400;$dt_all_messl = sqlesc(get_date_time(gmtime() - $secs_all_messl));
$rel = sql_query("SELECT id FROM messages WHERE added < $dt_all_messl") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($rel) > 0){while ($arl = mysql_fetch_array($rel)){sql_query("DELETE FROM messages WHERE id = ".sqlesc($arl["id"]));
write_log("Удалены ВСЕ сообщения старше 90 дней", "5DDB6E", "tracker");}}
////////удаляем юзверов если аккаунт не активирован больше 3 дней начало////////
$secs_pending = 3*86400;$dt_pending = sqlesc(get_date_time(gmtime() - $secs_pending));
$reu = sql_query("SELECT id FROM users WHERE status = 'pending' AND last_access < $dt_pending") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($reu) > 0){while ($aru = mysql_fetch_array($reu)){sql_query("DELETE FROM users WHERE id = ".sqlesc($aru["aru"]));
write_log("Удалены ВСЕ аккаунты не активированные после регистрации после 3 дней", "5DDB6E", "tracker");}}
////////удаляем юзверов если аккаунт не активирован больше 3 дней конец////////
//Update seed bonus ot Dj Luna
$points_per_hour = 0.1; // За торренты до 500Mb 
$points_per_hour2 = 0.5; // За торренты от 500Mb и менее 1Gb 
$points_per_hour3 = 1.0; // За торренты более 1Gb // 1 гигабайт=1024 мегабайт =1 048 576 килобайт=1073741824 байт
$points_per_hour4 = 2.0; // За торренты более 10Gb
$points_per_hour5 = 6.0; // За торренты более 50Gb
$points_per_hour6 = 10.0; // За торренты более 100Gb
$points_per_hour7 = 20.0; // За торренты более 200Gb
$points_per_hour8 = 30.0; // За торренты более 300Gb
$points_per_hour9 = 40.0; // За торренты более 400Gb
/////////////////
$points_per_hour10 = 0.2; // За торренты до 500Mb 
$points_per_hour11 = 1.0; // За торренты от 500Mb и менее 1Gb 
$points_per_hour12 = 2.0; // За торренты более 1Gb // 1 гигабайт=1024 мегабайт =1 048 576 килобайт=1073741824 байт
$points_per_hour13 = 4.0; // За торренты более 10Gb
$points_per_hour14 = 12.0; // За торренты более 50Gb
$points_per_hour15 = 20.0; // За торренты более 100Gb
$points_per_hour16 = 40.0; // За торренты более 200Gb
$points_per_hour17 = 60.0; // За торренты более 300Gb
$points_per_hour18 = 80.0; // За торренты более 400Gb
$points_per_cleanup = $points_per_hour*($autoclean_interval/3600); 
$points_per_cleanup2 = $points_per_hour2*($autoclean_interval/3600); 
$points_per_cleanup3 = $points_per_hour3*($autoclean_interval/3600);
$points_per_cleanup4 = $points_per_hour4*($autoclean_interval/3600);
$points_per_cleanup5 = $points_per_hour5*($autoclean_interval/3600);
$points_per_cleanup6 = $points_per_hour6*($autoclean_interval/3600);
$points_per_cleanup7 = $points_per_hour7*($autoclean_interval/3600);
$points_per_cleanup8 = $points_per_hour8*($autoclean_interval/3600);
$points_per_cleanup9 = $points_per_hour9*($autoclean_interval/3600);
$points_per_cleanup10 = $points_per_hour10*($autoclean_interval/3600); 
$points_per_cleanup11 = $points_per_hour11*($autoclean_interval/3600); 
$points_per_cleanup12 = $points_per_hour12*($autoclean_interval/3600);
$points_per_cleanup13 = $points_per_hour13*($autoclean_interval/3600);
$points_per_cleanup14 = $points_per_hour14*($autoclean_interval/3600);
$points_per_cleanup15 = $points_per_hour15*($autoclean_interval/3600);
$points_per_cleanup16 = $points_per_hour16*($autoclean_interval/3600);
$points_per_cleanup17 = $points_per_hour17*($autoclean_interval/3600);
$points_per_cleanup18 = $points_per_hour18*($autoclean_interval/3600);
$update_users = array(); 
$res = sql_query("SELECT snatched.userid, snatched.seed_time, torrents.size, torrents.seeders FROM snatched 
LEFT JOIN torrents ON snatched.torrent = torrents.id WHERE snatched.seeder = 'yes'"); 
while ($row = mysql_fetch_assoc($res)){$stbonus = $row["seed_time"];$stseeders = $row["seeders"];$secbonus = 7*86400; //// 7 day /////
//////// удвоение бонусов если просидировал больше 7 дней начало //////////
if($stbonus > $secbonus || $stseeders < 3){
if( $row ["size"] < 524288000 )  // За торренты до 500Mb 
$update_users[$row["userid"]] += $points_per_cleanup10; 
elseif ( $row ["size"] > 524288000 && $row ["size"] < 1073741824 )  // За торренты от 500Mb и менее 1Gb
$update_users[$row["userid"]] += $points_per_cleanup11; 
elseif ( $row ["size"] > 1073741824 && $row ["size"] < 10737418240 ) // За торренты более 1Gb
$update_users[$row["userid"]] += $points_per_cleanup12;
elseif ( $row ["size"] > 10737418240 && $row ["size"] < 53687091200 ) // За торренты более 10Gb
$update_users[$row["userid"]] += $points_per_cleanup13;
elseif ( $row ["size"] > 53687091200 && $row ["size"] < 107374182400 ) // За торренты более 50Gb
$update_users[$row["userid"]] += $points_per_cleanup14;
elseif ( $row ["size"] > 107374182400 && $row ["size"] < 214748364800 ) // За торренты более 100Gb
$update_users[$row["userid"]] += $points_per_cleanup15;
elseif ( $row ["size"] > 214748364800 && $row ["size"] < 322122547200 ) // За торренты более 200Gb
$update_users[$row["userid"]] += $points_per_cleanup16;		
elseif ( $row ["size"] > 322122547200 && $row ["size"] < 429496729600 ) // За торренты более 300Gb
$update_users[$row["userid"]] += $points_per_cleanup17;
else $update_users[$row["userid"]] += $points_per_cleanup18;}elseif($stbonus < $secbonus){ // За торренты более 400Gb
//////// удвоение бонусов если просидировал больше 7 дней конец //////////
//////// если просидировал меньше 7 дней начало //////////
if( $row ["size"] < 524288000 )  // За торренты до 500Mb 
$update_users[$row["userid"]] += $points_per_cleanup; 
elseif ( $row ["size"] > 524288000 && $row ["size"] < 1073741824 )  // За торренты от 500Mb и менее 1Gb
$update_users[$row["userid"]] += $points_per_cleanup2; 
elseif ( $row ["size"] > 1073741824 && $row ["size"] < 10737418240 ) // За торренты более 1Gb
$update_users[$row["userid"]] += $points_per_cleanup3;
elseif ( $row ["size"] > 10737418240 && $row ["size"] < 53687091200 ) // За торренты более 10Gb
$update_users[$row["userid"]] += $points_per_cleanup4;
elseif ( $row ["size"] > 53687091200 && $row ["size"] < 107374182400 ) // За торренты более 50Gb
$update_users[$row["userid"]] += $points_per_cleanup5;
elseif ( $row ["size"] > 107374182400 && $row ["size"] < 214748364800 ) // За торренты более 100Gb
$update_users[$row["userid"]] += $points_per_cleanup6;
elseif ( $row ["size"] > 214748364800 && $row ["size"] < 322122547200 ) // За торренты более 200Gb
$update_users[$row["userid"]] += $points_per_cleanup7;		
elseif ( $row ["size"] > 322122547200 && $row ["size"] < 429496729600 ) // За торренты более 300Gb
$update_users[$row["userid"]] += $points_per_cleanup8;
else $update_users[$row["userid"]] += $points_per_cleanup9;}} // За торренты более 400Gb
//////// если просидировал меньше 7 дней конец //////////
foreach($update_users as $add=>$sum){sql_query("UPDATE users SET bonus = bonus + ".round($sum, 2 )." WHERE id = ".sqlesc($add));
write_log("".round($sum, 2 )." бонусов за сидирование начислены юзеру id=".sqlesc($add), "5DDB6E", "bonus");}
//remove expired warnings////////////////////////////////////////
$now = sqlesc(get_date_time());
$resw = sql_query("SELECT id FROM users WHERE warned='yes' AND warneduntil < NOW() AND warneduntil <> '0000-00-00 00:00:00'") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($resw) > 0){while ($arrw = mysql_fetch_array($resw)){$idw = $arrw["id"];
$modcomment = sqlesc(date("Y-m-d") . " - Предупреждение снято системой по таймауту.\n");$subject = "Предупреждение снято системой по таймауту";
$msg = "Ваше предупреждение снято по таймауту. Постарайтесь больше не получать предупреждений и сделовать правилам.\n";
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idw, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET warned='no', warneduntil = '0000-00-00 00:00:00', modcomment = CONCAT($modcomment, modcomment) 
WHERE id = ".sqlesc($arrw["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Для юзера id=".$idw." предупреждение снято по таймауту.", "5DDB6E", "bans");}}
/////////////////////////////////////////////////////////////////
//remove expired bans///////////////////////
$resb = sql_query("SELECT userid FROM users_ban WHERE disuntil < NOW() AND disuntil != '0000-00-00 00:00:00'") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($resb) > 0){while ($arrb = mysql_fetch_array($resb)){$idb = $arrb["userid"];
$modcomment = sqlesc(date("Y-m-d") . " - Включен системой по истечению бана.\n");
sql_query("UPDATE users SET enabled = 'yes', modcomment = CONCAT($modcomment, modcomment) WHERE id = ".sqlesc($arrb["userid"])) or sqlerr(__FILE__,__LINE__);	
sql_query("DELETE FROM users_ban WHERE userid = ".sqlesc($arrb["userid"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзер id=".$idb." - Включен системой по истечению бана.", "5DDB6E", "bans");}}
/////////////////////////////////////////////////////////////////	
//remove vip statuses
$nowv = sqlesc(get_date_time());
$resv = sql_query("SELECT id FROM users WHERE vipuntil < $nowv AND vipuntil <> '0000-00-00 00:00:00'") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($resv) > 0){while($arrv = mysql_fetch_array($resv)){$idv = $arrv["id"];
$modcomment = sqlesc(date("Y-m-d") . " - Статус VIP истек по дате.\n");
$msg = "Действие вашего статуса VIP истекло. Ваш статус автоматически изменен на прежний (до установки VIP).\n";$subject = "Ваш статус VIP истек";
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idv, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = oldclass, oldclass = 0, vipuntil = '0000-00-00 00:00:00', modcomment = CONCAT($modcomment, modcomment) 
WHERE id = ".sqlesc($arrv["id"])) or sqlerr(__FILE__,__LINE__);
write_log("У юзера id=".$idv." истек статус VIP, статус автоматически изменен на прежний (до установки VIP).", "5DDB6E", "tracker");}}
//////////////////////////////////////////	
//remove upl statuses//////////////
$nowu = sqlesc(get_date_time());$resu = sql_query("SELECT id FROM users WHERE upluntil < $nowu AND upluntil <> '0000-00-00 00:00:00'") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($resu) > 0){while ($arru = mysql_fetch_array($resu)){$idu = $arru["id"];$modcomment = sqlesc(date("Y-m-d") . " - Статус UPLOADER истек по дате.\n");
$msg = "Действие вашего статуса UPLOADER истекло. Ваш статус автоматически изменен на прежний (до установки UPLOADER).\n";$subject = "Ваш статус UPLOADER истек";
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idu, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = oldclass, oldclass = 0, upluntil = '0000-00-00 00:00:00', modcomment = CONCAT($modcomment, modcomment) 
WHERE id = ".sqlesc($arru["id"])) or sqlerr(__FILE__,__LINE__);
write_log("У юзера id=".$idu." истек статус UPLOADER, статус автоматически изменен на прежний (до установки UPLOADER).", "5DDB6E", "tracker");}}
//remove adm statuses////////////////
$nowa = sqlesc(get_date_time());$resa = sql_query("SELECT id FROM users WHERE admuntil < $nowa AND admuntil <> '0000-00-00 00:00:00'") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($resa) > 0){while ($arra = mysql_fetch_array($resa)){$ida = $arra["id"];$modcomment = sqlesc(date("Y-m-d") . " - Статус ADMINISTRATOR истек по дате.\n");
$msg = "Действие вашего статуса ADMINISTRATOR истекло. Ваш статус автоматически изменен на прежний (до установки ADMINISTRATOR).\n";$subject = "Ваш статус ADMINISTRATOR истек";
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $ida, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = oldclass, oldclass = 0, admuntil = '0000-00-00 00:00:00', modcomment = CONCAT($modcomment, modcomment) 
WHERE id = ".sqlesc($arra["id"])) or sqlerr(__FILE__,__LINE__);
write_log("У юзера id=".$idu." истек статус ADMINISTRATOR, статус автоматически изменен на прежний (до установки ADMINISTRATOR).", "5DDB6E", "tracker");}}
/////////// Повышение c LICHER до 720p ////////////////////
$limit7 = 512*1024*1024*1024;$minratio7 = 0.31;$maxdt7 = sqlesc(get_date_time(gmtime() - 86400*28));
$reslc = sql_query("SELECT id FROM users WHERE class = ".UC_USER." AND downloaded >= $limit7 AND uploaded / downloaded >= $minratio7 AND added < $maxdt7") or sqlerr(__FILE__,__LINE__);
if(mysql_num_rows($reslc) > 0){while ($arrlc = mysql_fetch_array($reslc)){$idu = $arrlc["id"];
$msg = "Наши поздравления, вы были авто-повышены до ранга [b]720p[/b].";$subject = "Вы были повышены";
$modcomment = sqlesc(date("Y-m-d") . " - Повышен до уровня \"".$tracker_lang["class_720p"]."\" системой.\n");
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idu, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = ".UC_720p.", modcomment = CONCAT($modcomment, modcomment) WHERE id = ".sqlesc($arrlc["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзер id=".$idu." Повышен до уровня 720p системой.", "5DDB6E", "tracker");}}
/////////// Повышение c LICHER до 720p ////////////////////
/////////// Понижение c 720p до LICHER ////////////////////
$minratiol = 0.25;$limitl = 512*1024*1024*1024;
$ressm = sql_query("SELECT id FROM users WHERE class = ".UC_720p." AND downloaded < $limitl AND uploaded / downloaded < $minratiol") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($ressm) > 0){while ($arrsm = mysql_fetch_array($ressm)){$idsm = $arrsm["id"];
$msg = "Вы были авто-понижены с ранга [b]720p[/b] до ранга [b]Личер[/b] потому-что ваш рейтинг упал ниже [b]{$minratiol}[/b] или Скачано меньше [b]500GB[/b].";
$subject = "Вы были понижены";$modcomment = sqlesc(date("Y-m-d") . " - Понижен до уровня \"".$tracker_lang["class_user"]."\" системой.\n");
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idsm, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = ".UC_USER.", modcomment = CONCAT($modcomment, modcomment) WHERE id = ".sqlesc($arrsm["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзер id=".$idsm." понижен до уровня 720p системой.", "5DDB6E", "tracker");}}
/////////// Понижение c 720p до LICHER ////////////////////
/////////// Повышение до 1080i класса ////////////////////
$limiti = 1024*1024*1024*1024;$minratioi = 2.05;$bonusi = 500000;$maxdti = sqlesc(get_date_time(gmtime() - 86400*175));
$resi = sql_query("SELECT id FROM users WHERE class = ".UC_720p." AND downloaded >= $limiti AND uploaded / downloaded >= $minratioi 
AND bonus >= $bonusi AND added < $maxdti") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($resi) > 0){while ($arri = mysql_fetch_array($resi)){$idi = $arri["id"];
$msg = "Наши поздравления, вы были авто-повышены до ранга [b]1080i[/b].";$subject = "Вы были повышены";
$modcomment = sqlesc(date("Y-m-d")." - Повышен до уровня \"".$tracker_lang["class_1080i"]."\" системой.\n");
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idi, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = ".UC_1080i.", comentoff = 'yes', schoutboxpos = 'yes', modcomment = CONCAT($modcomment, modcomment) 
WHERE id = ".sqlesc($arri["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзер id=".$idi." повышен до уровня 1080i системой.", "5DDB6E", "tracker");}}
/////////// Понижение до 720р класса ////////////////////
$minratioi7 = 1.95;$limiti7 = 1024*1024*1024*1024;
$respi = sql_query("SELECT id FROM users WHERE class = ".UC_1080i." AND downloaded < $limiti7 AND uploaded / downloaded < $minratioi7") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($respi) > 0){while($arrpi = mysql_fetch_array($respi)){$idpi = $arrpi["id"];
$msg = "Вы были авто-понижены с ранга [b]1080i[/b] до ранга [b]720p[/b] потому-что ваш рейтинг упал ниже [b]{$minratioi7}[/b] или Скачано меньше [b]1ТВ[/b].";
$subject = "Вы были понижены";$modcomment = sqlesc(date("Y-m-d") . " - Понижен до уровня \"".$tracker_lang["class_720p"]."\" системой.\n");
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idpi, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = ".UC_720p.", comentoff = 'no', schoutboxpos = 'no', modcomment = CONCAT($modcomment, modcomment) 
WHERE id = ".sqlesc($arrpi["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзер id=".$idpi." понижен до уровня 720p системой.", "5DDB6E", "tracker");}}
/////////// Повышение до 1080р класса ////////////////////
$limitp = 5*1024*1024*1024*1024;$minratiop = 3.05;$bonusp = 1000000;$maxdtp = sqlesc(get_date_time(gmtime() - 86400*210));
$rest = sql_query("SELECT id FROM users WHERE class = ".UC_1080i." AND downloaded >= $limitp AND uploaded / downloaded >= $minratiop AND bonus >= $bonusp AND added < $maxdtp") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($rest) > 0){while ($arrt = mysql_fetch_array($rest)){$idt = $arrt["id"];
$msg = "Наши поздравления, вы были авто-повышены до ранга [b]1080p[/b].";$subject = "Вы были повышены";
$modcomment = sqlesc(date("Y-m-d") . " - Повышен до уровня \"".$tracker_lang["class_1080p"]."\" системой.\n");
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idt, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = ".UC_1080p.", modcomment = CONCAT($modcomment, modcomment) WHERE id = ".sqlesc($arrt["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзер id=".$idt." повышен до уровня 1080p системой.", "5DDB6E", "tracker");}}
/////////// Понижение до 1080i класса ////////////////////
$minratiopi = 2.95;$limitpi = 5*1024*1024*1024*1024;
$rew = sql_query("SELECT id FROM users WHERE class = ".UC_1080p." AND downloaded < $limitpi AND uploaded / downloaded < $minratiopi") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($rew) > 0){while ($arw = mysql_fetch_array($rew)){$idw = $arw["id"];
$msg = "Вы были авто-понижены с ранга [b]1080p[/b] до ранга [b]1080i[/b] потому-что ваш рейтинг упал ниже [b]{$minratiopi}[/b] или Скачано меньше [b]5ТВ[/b].";
$subject = "Вы были понижены";$modcomment = sqlesc(date("Y-m-d") . " - Понижен до уровня \"".$tracker_lang["class_1080i"]."\" системой.\n");
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idw, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = ".UC_1080i.", modcomment = CONCAT($modcomment, modcomment) WHERE id = ".sqlesc($arw["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзер id=".$idw." понижен до уровня 1080i системой.", "5DDB6E", "tracker");}}
/////////// Повышение до UHD класса ////////////////////
$limitu = 10*1024*1024*1024*1024;$minratiou = 4.05;$bonusu = 10000000;$maxdtu = sqlesc(get_date_time(gmtime() - 86400*280));
$reh = sql_query("SELECT id FROM users WHERE class = ".UC_1080p." AND downloaded >= $limitu 
AND uploaded / downloaded >= $minratiou AND bonus >= $bonusu AND added < $maxdtu") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($reh) > 0){while ($arh = mysql_fetch_array($reh)){$idh = $arh["id"];
$msg = "Наши поздравления, вы были авто-повышены до ранга [b]UHD[/b].";$subject = "Вы были повышены";
$modcomment = sqlesc(date("Y-m-d") . " - Повышен до уровня \"".$tracker_lang["class_uhd"]."\" системой.\n");
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idh, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = ".UC_UHD.", modcomment = CONCAT($modcomment, modcomment) WHERE id = ".sqlesc($arh["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзер id=".$idh." повышен до уровня UHD системой.", "5DDB6E", "tracker");}}
/////////// Понижение до 1080p класса ////////////////////
$minratioup = 3.95;$limitup = 10*1024*1024*1024*1024;
$rex = sql_query("SELECT id FROM users WHERE class = ".UC_UHD." AND downloaded < $limitup AND uploaded / downloaded < $minratioup") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($rex) > 0){while ($arx = mysql_fetch_array($rex)){$idx = $arx["id"];
$msg = "Вы были авто-понижены с ранга [b]UHD[/b] до ранга [b]1080p[/b] потому-что ваш рейтинг упал ниже [b]{$minratioup}[/b] или Скачано меньше [b]10TB[/b].";
$subject = "Вы были понижены";$modcomment = sqlesc(date("Y-m-d") . " - Понижен до уровня \"".$tracker_lang["class_1080p"]."\" системой.\n");
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idx, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = ".UC_1080p.", modcomment = CONCAT($modcomment, modcomment) WHERE id = ".sqlesc($arx["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзер id=".$idx." понижен до уровня 1080p системой.", "5DDB6E", "tracker");}}
/////////// Повышение до VIPS класса ////////////////////
$limitv = 25*1024*1024*1024*1024;$minratiov = 5.00;$bonusv = 100000000;$maxdtv = sqlesc(get_date_time(gmtime() - 86400*365));
$rek = sql_query("SELECT id FROM users WHERE class = ".UC_UHD." AND downloaded >= $limitv AND uploaded / downloaded >= $minratiov 
AND bonus >= $bonusv AND added < $maxdtv") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($rek) > 0){while ($ark = mysql_fetch_array($rek)){$idk = $ark["id"];
$msg = "Наши поздравления, вы были авто-повышены до ранга [b]Ветеран[/b].";$subject = "Вы были повышены";
$modcomment = sqlesc(date("Y-m-d") . " - Повышен до уровня \"".$tracker_lang["class_vips"]."\" системой.\n");
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idk, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = ".UC_VIPS.", modcomment = CONCAT($modcomment, modcomment) WHERE id = ".sqlesc($ark["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзер id=".$idk." повышен до уровня Ветеран системой.", "5DDB6E", "tracker");}}
/////////// Понижение до UHD класса ////////////////////
$minratiovu = 4.95;$limitvu = 25*1024*1024*1024*1024;
$reu = sql_query("SELECT id FROM users WHERE class = ".UC_VIPS." AND downloaded < $limitvu AND uploaded / downloaded < $minratiovu") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($reu) > 0){while ($au = mysql_fetch_array($reu)){$iu = $au["id"];
$msg = "Вы были авто-понижены с ранга [b]Ветеран[/b] до ранга [b]UHD[/b] потому-что ваш рейтинг упал ниже [b]{$minratiovu}[/b] или Скачано меньше [b]25TB[/b].";
$subject = "Вы были понижены";$modcomment = sqlesc(date("Y-m-d") . " - Понижен до уровня \"".$tracker_lang["class_uhd"]."\" системой.\n");
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $iu, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET class = ".UC_UHD.", modcomment = CONCAT($modcomment, modcomment) WHERE id = ".sqlesc($au["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзер id=".$iu." понижен до уровня UHD системой.", "5DDB6E", "tracker");}}
/////////// Понижение до UHD класса ////////////////////
/////////// Начисление бонусов для VIP начало ///////////////
$minbonus = 100000;$revi = sql_query("SELECT id FROM users WHERE class = ".UC_VIP." AND bonus < $minbonus") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($revi) > 0){while ($avi = mysql_fetch_array($revi)){$ivi = $avi["id"];$bonuss = 500000;
$msg = "Вам были начислены дополнительные 0,5 млн. бонусов согласно статусу VIP, поскольку ваших личных бонусов стало ниже 100 000.";$subject = "Дополнительные бонусы для VIP";
$modcomment = sqlesc(date("Y-m-d")." - Начислены дополнительные пол миллиона бонусов согласно статусу VIP системой.");
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $ivi, NOW(), ".sqlesc($msg).", ".sqlesc($subject).")");
sql_query("UPDATE users SET bonus = bonus + $bonuss, modcomment = CONCAT($modcomment, modcomment) WHERE id = ".sqlesc($avi["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзеру id=".$ivi." - Начислены дополнительные пол миллиона бонусов согласно статусу VIP системой.", "5DDB6E", "tracker");}}
/////////// Начисление бонусов для VIP конец ///////////////
/////////// Инвайты для 1080р класса один раз на 30 дней НАЧАЛО ////////////////////
$secinv = 30*86400;$dtinv = sqlesc(get_date_time(gmtime() - $secinv));
$restinv = sql_query("SELECT id FROM users WHERE invtime < $dtinv AND class >= 3 AND invites < 3") or sqlerr(__FILE__,__LINE__);
if(mysql_num_rows($restinv) > 0){while($arrtinv = mysql_fetch_array($restinv)){$idinv = $arrtinv["id"];	
$msg = sqlesc("Согласно вашему классу юзера, вам обновлены инвайты-пришлашения до 3-х, так как их у вас не было или стало меньше трех (3).");$subject = sqlesc("Вам обновлены инвайты-приглашения");
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $idinv, NOW(), $msg, $subject)");
sql_query("UPDATE users SET invites = 3, invtime = NOW() WHERE id = ".sqlesc($arrtinv["id"])) or sqlerr(__FILE__,__LINE__);}}
/////////// Инвайты для 1080р класса один раз на 30 дней КОНЕЦ ////////////////////
/ //Удалять не активные попытки входа 
$secs = 1*86400;$dt = sqlesc(get_date_time(gmtime() - $secs));
$reni = sql_query("SELECT id, ip FROM loginattempts WHERE banned = 'yes' AND added < $dt") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($reni) > 0){while ($ani = mysql_fetch_array($reni)){$ini = $ani["ip"];
sql_query("DELETE FROM loginattempts WHERE id = ".sqlesc($ani["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Удалены не активные попытки входа в систему с IP: ".$ini."", "5DDB6E", "bansv");}}
//Удалять попытки входа старше 5 дней
$secs = 1*432000;$dt = sqlesc(get_date_time(gmtime() - $secs));
$reni = sql_query("SELECT id, ip FROM loginattempts WHERE added < $dt") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($reni) > 0){while ($ani = mysql_fetch_array($reni)){$ini = $ani["ip"];
sql_query("DELETE FROM loginattempts WHERE id = ".sqlesc($ani["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Удалены попытки входа в систему старше 5 дней с IP: ".$ini."", "5DDB6E", "bansv");}}
//////////////////////////////////////////////////////////////////
$res = sql_query("SELECT shoutbox2.* FROM shoutbox2") or sqlerr(__FILE__,__LINE__);
if(mysql_num_rows($res) > 200){sql_query('TRUNCATE TABLE shoutbox2') or sqlerr(__FILE__, __LINE__);}
$res = sql_query("SELECT shoutbox.* FROM shoutbox") or sqlerr(__FILE__,__LINE__);
if(mysql_num_rows($res) > 200){sql_query('TRUNCATE TABLE shoutbox') or sqlerr(__FILE__, __LINE__);
$bot_text = "ВЫ плАхие! Заслали мой цят, пйишлось его чисить!  :'-(";bot_msg(format_comment($bot_text));}
$secs = 1 * 3600;$dt = time() - $secs;sql_query("DELETE FROM sessions WHERE time < $dt") or sqlerr(__FILE__,__LINE__);
/////////////Ponijenie Aploader esli za 14 dney ne zalil////////////////////////
$rgf = sql_query("SELECT id FROM users WHERE class = ".UC_UPLOADER." AND id > 2 
AND last_upload < FROM_UNIXTIME(unix_timestamp() - 14*86400)") or sqlerr(__FILE__,__LINE__);
if(mysql_num_rows($rgf) > 0){while($agf = mysql_fetch_array($rgf)){$idf = $agf["id"];	
sql_query("UPDATE users SET class = ".UC_720p." WHERE id = ".sqlesc($agf["id"])) or sqlerr(__FILE__,__LINE__);
write_log("Юзер id=".$idf." понижен до уровня 720p системой.", "5DDB6E", "bans");}}
/////////////Ponijenie Aploader esli za 14 dney ne zalil////////////////////////
$seclogs = 5*86400;$seclogsf = sqlesc(get_date_time(gmtime() - $seclogs));
$rslog = sql_query("SELECT id FROM sitelog WHERE added < $seclogsf") or sqlerr(__FILE__,__LINE__);if (mysql_num_rows($rslog) > 0){
while ($arslog = mysql_fetch_array($rslog)){$idsrew = $arslog["id"];sql_query("DELETE FROM sitelog WHERE id = $idsrew") or sqlerr();}}
//////////////// online-users NACHALO /////////////////////////
$onliners = sql_query("SELECT UNIX_TIMESTAMP() - UNIX_TIMESTAMP(time) AS timer FROM online WHERE id = 1") or sqlerr(__FILE__, __LINE__);
$onliner = mysql_fetch_array($onliners);$ontime = $onliner['timer'];
if($ontime){$secwerd = 60 * 30;if($ontime > $secwerd){
$awaw = mysql_fetch_array(mysql_query("SELECT id, username, avatar, class FROM users WHERE status='confirmed' ORDER BY id DESC LIMIT 1"));
if (!$awaw["avatar"]){
$avatar = "<center><a href='user_".$awaw["id"]."' class=\"online\" title=".$awaw["username"]."><img src=\"pic/noavatar.gif\" style=\"width:46px; height:46px; border:3px double #ccc;\" title=".$awaw["username"]."/><br><small>".get_user_class_color($awaw['class'], $awaw['username'])."</small></a></center>";
}else{$avatar = "<center><a href='user_".$awaw["id"]."' class=\"online\" title=".$awaw["username"]."><img src=\"".$awaw["avatar"]."\" style=\"width:46px; height:46px; border:3px double #ccc;\" title=".$awaw["username"]."/><br><small>".get_user_class_color($awaw['class'], $awaw['username'])."</small></a></center>";}
$latestuser = $avatar;$title_who = array();$secsnw = 60 * 30;$dt = sqlesc(get_date_time(gmtime() - $secsnw));
$resultw = sql_query("SELECT s.uid, s.username, s.class, s.avatar FROM sessions AS s WHERE s.time >= $dt GROUP BY s.username ORDER BY s.class DESC");
while (list($uid, $uname, $class, $avatar) = mysql_fetch_row($resultw)){
if(!empty($uname)){$resww1 = mysql_query("SELECT COUNT(*) ip FROM sessions WHERE class = '-1'");
$roww1 = mysql_fetch_array($resww1);$counts = $roww1[0];
$title_who[] = "<a href=\"user_".$uid."\" class=\"online\"><img src=\"$avatar\" width=\"20px\" title=\"$uname\"/> <b>".get_user_class_color($class, $uname)."</b></a>";}
if($class == UC_VLADELEC){$admin++;}elseif($class == UC_SYSOP){$admin++;}elseif($class == UC_ADMINISTRATOR){$admin++;}
elseif($class == UC_MODERATOR){$admin++;}elseif($class == UC_VIP){$users++;}elseif($class == UC_UPLOADER){$users++;}
elseif($class == UC_VIPS){$users++;}elseif($class == UC_UHD){$users++;}elseif($class == UC_1080p){$users++;}elseif($class == UC_1080i){$users++;}
elseif($class == UC_720p){$users++;}elseif($class == UC_USER){$users++;}elseif(empty($uname)){}$total++;if(empty($uname)) continue;
else $who_online .= $title_who;}if($admin == "") $admin = 0;if($users == "") $users = 0;if($total == "") $total = 0;$totals = $total + $counts;
$onlinesw .= "<table border=\"0\" width=\"100%\"><tr valign=\"middle\"><td align=\"center\" class=\"embedded\"><center><u><b>Последний пользователь</b></u><br>$latestuser</center></td></tr></table><hr>";
if(count($title_who)){$onlinesw .= "<table border=\"0\" width=\"100%\"><tr valign=\"middle\"><td align=\"center\" class=\"embedded\">
<center><u><b>Кто онлайн:</b></u></center></td></tr><tr><td class=\"embedded\" align=\"left\">".@implode("<br>", $title_who)."<hr></td></tr></table>\n";
}else{$onlinesw .= "<table border=\"0\" width=\"100%\"><tr valign=\"middle\"><td align=\"center\" class=\"embedded\">
<center><u><b>Кто онлайн:</b></u><br>Нет пользователей за последние 10 минут.</center><hr></td></tr></table>\n";} 
$onlinesw .= "<table border=\"0\" width=\"100%\"><tr valign=\"middle\"><td colspan=\"2\" class=\"embedded\">
<center><b><u>В сети</u></b></center></td></tr><tr><td class=\"embedded\">&nbsp;<img src=\"pic/info/admin.gif\"/></td>
<td width=\"90%\" class=\"embedded\"><font color=\"red\">Администрация:</font>&nbsp;$admin</td></tr><tr>
<td class=\"embedded\">&nbsp;<img src=\"pic/info/guest.gif\"/></td><td width=\"90%\" class=\"embedded\">
<font color=\"blue\">Пользователи:</font>&nbsp;$users</td></tr><tr><td class=\"embedded\">&nbsp;<img src=\"pic/info/minimoder.gif\"/></td>
<td width=\"90%\" class=\"embedded\"><font color=\"gray\">Гостей:</font>&nbsp;$counts</td></tr><tr>
<td class=\"embedded\">&nbsp;<img src=\"pic/info/group.gif\"/></td><td width=\"90%\" class=\"embedded\">Всего:&nbsp;$totals</td></tr></table>";
$dt = strtotime("now") - ((date("G")*60*60)+(date("i")*60));
$reswww = mysql_query("SELECT id, gender, username, class, avatar, donor, warned FROM  users  WHERE UNIX_TIMESTAMP(last_access) >= $dt ORDER BY class DESC") or sqlerr(__FILE__, __LINE__);
while ($arrqw = mysql_fetch_assoc($reswww)){if($todayactive) $todayactive .= ", ";
$todayactive .= "<a href='user_".$arrqw["id"]."'>".get_user_class_color($arrqw["class"], $arrqw["username"])."</a>";
$donator = $arrqw["donor"] == "yes";if($donator){$todayactive .= "<img src=\"pic/star.gif\"/>";}$warned = $arrqw["warned"] == "yes";
if($warned){$todayactive .= " <b>(<font color=red title=Предупрежден>П</font>)</b>";}$usersactivetoday++;}
$onlinesw .= "<center><hr><script src=\"js/show_hide.js\"></script>
<table cellspacing=\"0\" cellpadding=\"5\" border=\"0\" width=\"100%\"><tr></td></table>
<table cellspacing=\"0\" cellpadding=\"5\" border=\"0\" width=\"100%\"><tr valign=\"middle\">
<td align=\"left\" class=\"embedded\"><b><font color=red>".$usersactivetoday."</font>&nbsp;
<span style=\"cursor: pointer;\" onclick=\"javascript: show_hide('s"."123123"."')\"><b>посетило сегодня &nabla; </b></td></span></tr>
<tr><td class=\"embedded\"><span id=\"ss"."123123"."\" style=\"display: none;\">".$todayactive."</span></td></tr>
<tr><td class=\"embedded\"><font size=\"1\" color=\"grey\"><b>Блок обновлен:</b>&nbsp;<i>".nicetime(get_date_time(), true)."</i></font></td></tr></table>";
$onlines = $onlinesw;$onliness = "Online_block";$_cacheonline = 'onlineblock.cache';$CacheBlock->Write($_cacheonline, $onlines);
sql_query("UPDATE online SET textt = ".sqlesc($onlines).", time = NOW() WHERE id=1") or sqlerr();
}}else{
$awaw = mysql_fetch_array(mysql_query("SELECT id, username, avatar, class FROM users WHERE status='confirmed' ORDER BY id DESC LIMIT 1"));if (!$awaw["avatar"]){
$avatar = "<center><a href='user_".$awaw["id"]."' class=\"online\" title=".$awaw["username"]."><img src=\"pic/noavatar.gif\" style=\"width:46px; height:46px; border:3px double #ccc;\" title=".$awaw["username"]."/><br><small>".get_user_class_color($awaw['class'], $awaw['username'])."</small></a></center>";
}else{$avatar = "<center><a href='user_".$awaw["id"]."' class=\"online\" title=".$awaw["username"]."><img src=\"".$awaw["avatar"]."\" style=\"width:46px; height:46px; border:3px double #ccc;\" title=".$awaw["username"]."/><br><small>".get_user_class_color($awaw['class'], $awaw['username'])."</small></a></center>";}
$latestuser = $avatar;$title_who = array();$secsnw = 60 * 30;$dt = sqlesc(get_date_time(gmtime() - $secsnw));
$resultw = sql_query("SELECT s.uid, s.username, s.class, s.avatar FROM sessions AS s WHERE s.time >= $dt GROUP BY s.username ORDER BY s.class DESC");
while (list($uid, $uname, $class, $avatar) = mysql_fetch_row($resultw)){if(!empty($uname)){
$resww1 = mysql_query("SELECT COUNT(*) ip FROM sessions WHERE class = '-1'");$roww1 = mysql_fetch_array($resww1);$counts = $roww1[0];
$title_who[] = "<a href=\"user_".$uid."\" class=\"online\"><img src=\"$avatar\" width=\"20px\" title=\"$uname\"/> <b>".get_user_class_color($class, $uname)."</b></a>";}
if($class == UC_VLADELEC){$admin++;}elseif($class == UC_SYSOP){$admin++;}elseif($class == UC_ADMINISTRATOR){$admin++;}elseif($class == UC_MODERATOR){$admin++;}
elseif($class == UC_VIP){$users++;}elseif($class == UC_UPLOADER){$users++;}elseif($class == UC_VIPS){$users++;}elseif($class == UC_UHD){$users++;}
elseif($class == UC_1080p){$users++;}elseif($class == UC_1080i){$users++;}elseif($class == UC_720p){$users++;}elseif($class == UC_USER){$users++;}
elseif(empty($uname)){}$total++;if(empty($uname)) continue;else $who_online .= $title_who;}if($admin == "") $admin = 0;if($users == "") $users = 0;
if($total == "") $total = 0;$totals = $total + $counts;
$onlinesw .= "<table border=\"0\" width=\"100%\"><tr valign=\"middle\"><td align=\"center\" class=\"embedded\"><center><u><b>Последний пользователь</b></u><br>$latestuser</center></td></tr></table><hr>";
if(count($title_who)){$onlinesw .= "<table border=\"0\" width=\"100%\"><tr valign=\"middle\"><td align=\"center\" class=\"embedded\">
<center><u><b>Кто онлайн:</b></u></center></td></tr><tr><td class=\"embedded\" align=\"left\">".@implode("<br>", $title_who)."<hr></td></tr></table>\n";
}else{$onlinesw .= "<table border=\"0\" width=\"100%\"><tr valign=\"middle\"><td align=\"center\" class=\"embedded\">
<center><u><b>Кто онлайн:</b></u><br>Нет пользователей за последние 10 минут.</center><hr></td></tr></table>\n";} 
$onlinesw .= "<table border=\"0\" width=\"100%\"><tr valign=\"middle\"><td colspan=\"2\" class=\"embedded\">
<center><b><u>В сети</u></b></center></td></tr><tr><td class=\"embedded\">&nbsp;<img src=\"pic/info/admin.gif\"/></td>
<td width=\"90%\" class=\"embedded\"><font color=\"red\">Администрация:</font>&nbsp;$admin</td></tr><tr>
<td class=\"embedded\">&nbsp;<img src=\"pic/info/guest.gif\"/></td><td width=\"90%\" class=\"embedded\">
<font color=\"blue\">Пользователи:</font>&nbsp;$users</td></tr><tr><td class=\"embedded\">&nbsp;<img src=\"pic/info/minimoder.gif\"/></td>
<td width=\"90%\" class=\"embedded\"><font color=\"gray\">Гостей:</font>&nbsp;$counts</td></tr><tr>
<td class=\"embedded\">&nbsp;<img src=\"pic/info/group.gif\"/></td><td width=\"90%\" class=\"embedded\">Всего:&nbsp;$totals</td></tr></table>";
$dt = strtotime("now") - ((date("G")*60*60)+(date("i")*60));
$reswww = mysql_query("SELECT id, gender, username, class, avatar, donor, warned FROM  users  WHERE UNIX_TIMESTAMP(last_access) >= $dt ORDER BY class DESC") or sqlerr(__FILE__, __LINE__);
while ($arrqw = mysql_fetch_assoc($reswww)){if($todayactive) $todayactive .= ", ";
$todayactive .= "<a href='user_".$arrqw["id"]."'>".get_user_class_color($arrqw["class"], $arrqw["username"])."</a>";
$donator = $arrqw["donor"] == "yes";if($donator){$todayactive .= "<img src=\"pic/star.gif\"/>";}$warned = $arrqw["warned"] == "yes";
if($warned){$todayactive .= " <b>(<font color=red title=Предупрежден>П</font>)</b>";}$usersactivetoday++;}
$onlinesw .= "<center><hr><script src=\"js/show_hide.js\"></script>
<table cellspacing=\"0\" cellpadding=\"5\" border=\"0\" width=\"100%\"><tr></td></table>
<table cellspacing=\"0\" cellpadding=\"5\" border=\"0\" width=\"100%\"><tr valign=\"middle\">
<td align=\"left\" class=\"embedded\"><b><font color=red>".$usersactivetoday."</font>&nbsp;
<span style=\"cursor: pointer;\" onclick=\"javascript: show_hide('s"."123123"."')\"><b>посетило сегодня &nabla; </b></td></span></tr>
<tr><td class=\"embedded\"><span id=\"ss"."123123"."\" style=\"display: none;\">".$todayactive."</span></td></tr>
<tr><td class=\"embedded\"><font size=\"1\" color=\"grey\"><b>Блок обновлен:</b>&nbsp;<i>".nicetime(get_date_time(), true)."</i></font></td></tr></table>";
$onlines = $onlinesw;$onliness = "Online_block";$_cacheonline = 'onlineblock.cache';$CacheBlock->Write($_cacheonline, $onlines);
sql_query("INSERT online SET textt = ".sqlesc($onlines).", time = NOW()");}
//////////////// online-users KONEC//////////////////////////////////////
//////////////// stats NACHALO /////////////////////////
$statreffu = sql_query("SELECT UNIX_TIMESTAMP() - UNIX_TIMESTAMP(time) AS timer FROM stats WHERE id = 1") or sqlerr(__FILE__, __LINE__);
$statreff = mysql_fetch_array($statreffu);$statreffur = $statreff['timer'];
if($statreffur){$statref = 60 * 60;if($statreffur > $statref){
$res1 = sql_query("SELECT COUNT(*) FROM users WHERE gender='3'");$row1 = mysql_fetch_array($res1);$na = $row1[0];	
$res2 = sql_query("SELECT COUNT(*) FROM users WHERE warned='yes'");$row2 = mysql_fetch_array($res2);$warned_users = $row2[0];
$res3 = sql_query("SELECT COUNT(*) FROM users WHERE enabled='no'");$row3 = mysql_fetch_array($res3);$disabled = $row3[0];
$res4 = sql_query("SELECT COUNT(*) FROM users WHERE gender='1'");$row4 = mysql_fetch_array($res4);$male = $row4[0];
$res5 = sql_query("SELECT COUNT(*) FROM users WHERE gender='2'");$row5 = mysql_fetch_array($res5);$female = $row5[0];
$res6 = sql_query("SELECT COUNT(*) FROM users WHERE class='7'");$row6 = mysql_fetch_array($res6);$vip = $row6[0];
$res7 = sql_query("SELECT COUNT(*) FROM users WHERE class='6'");$row7 = mysql_fetch_array($res7);$uploader = $row7[0];
$res8 = sql_query("SELECT COUNT(*) FROM users WHERE status='pending'");$row8 = mysql_fetch_array($res8);$unverified = $row8[0];
$res9 = sql_query("SELECT COUNT(*) FROM torrents");$row9 = mysql_fetch_array($res9);$torrents = $row9[0];
$res10 = sql_query("SELECT COUNT(*) FROM torrents WHERE seeders='0'");$row10 = mysql_fetch_array($res10);$dead = $row10[0];
$res12 = sql_query("SELECT COUNT(*) FROM peers WHERE connectable='yes'");$row12 = mysql_fetch_array($res12);$connectable = $row12[0];
$res13 = sql_query("SELECT COUNT(*) FROM peers WHERE connectable='no'");$row13 = mysql_fetch_array($res13);$notconnectable = $row13[0];
$res14 = sql_query("SELECT COUNT(*) FROM peers FORCE INDEX(torrent_seeder) WHERE seeder='yes'");
$row14 = mysql_fetch_array($res14);$seeders = $row14[0];
$res15 = sql_query("SELECT COUNT(*) FROM peers FORCE INDEX(torrent_seeder) WHERE seeder='no'");
$row15 = mysql_fetch_array($res15);$leechers = $row15[0];$registered = $female + $male + $na;
$query_string = "SELECT invites FROM users";$sql = sql_query($query_string) or die(mysql_error());$num = 0;
while ($us = mysql_fetch_array($sql)){$num++;$invites += $us["invites"];
if ($num == mysql_num_rows($sql)){$nums = number_format(get_row_count("users", "WHERE DATEDIFF(added, NOW()) = -1")); 
if($connectable == 0)$nat = 0;else $nat = number_format($notconnectable / $connectable * 100);
list($external_seeders, $external_leechers) = array_map('number_format', mysql_fetch_row(sql_query('SELECT SUM(seeders), SUM(leechers) FROM torrents_scrape')));
$upsta = 0;if ($external_leechers == 0) $external_ratio = 0;else $external_ratio = $external_seeders / $external_leechers * 100;}}
$query_string2 = "SELECT downloaded, uploaded FROM snatched";$sql2 = sql_query($query_string2) or die(mysql_error());
while ($us2 = mysql_fetch_array($sql2)){$downloaded += $us2["downloaded"];$uploaded += $us2["uploaded"];}
$dow = sql_query("SELECT size FROM torrents") or sqlerr(__FILE__,__LINE__);
while ($down = mysql_fetch_array($dow)){$upsta = $upsta + $down["size"];}$upstat = mksize($upsta);
if ($leechers == 0) $ratio = 0;else $ratio = round($seeders / $leechers * 100);$peers = $seeders + $leechers;
$statsref .= "<table width='100%' border='0' cellspacing='0' cellpadding='10'><tbody><tr><td width='50%' align='center' style=\"border: none;\">
<table class=\"main2\" border='1' cellspacing='0' cellpadding='5'><tbody><tr><td colspan=2>
<table width='100%' border='1' cellspacing='0' cellpadding='5'><tbody><tr>
<td style=\"text-align:right; font-weight:bold; vertical-align:top;\"><a href=\"users\" title=\"Всего Пользователей\">
Всего Пользователей</a></td><td align='right'>$registered</td></tr><tr>
<td style=\"text-align:right; font-weight:bold; vertical-align:top;\"><a href=\"boys\" title=\"Парней\">Парней</a></td>
<td align='right'><img class='boy' align='absbottom' src='pic/trans.gif' title='Парней'/>$male</td></tr><tr>
<td style=\"text-align:right; font-weight:bold; vertical-align:top;\"><a href=\"girls\" title=\"Девушек\">Девушек</a></td>
<td align=right><img class='girl' align='absbottom' src='pic/trans.gif' title='Девушек'/>$female</td></tr><tr>
<td style=\"text-align:right; font-weight:bold; vertical-align:top;\"><a href=\"transgender.php\" title=\"Трансиков\">Трансиков</a></td>
<td align='right'><img class='transgender' align='absbottom' src='pic/trans.gif' title='Трансиков'/>$na</td></tr></tbody></table></td></tr>";
$statsref .= "<tr><td colspan='2'><table width='100%' border='1' cellspacing='0' cellpadding='5'><tbody><tr>
<td style=\"text-align:right; font-weight:bold; vertical-align:top;\">Мест на трекере</td>
<td align='right'>$maxusers</td></tr><tr><td style=\"text-align:right; font-weight:bold; vertical-align:top;\">
Мест по приглашениям</td><td align='right'>$invites</td></tr><tr>
<td style=\"text-align:right; font-weight:bold; vertical-align:top;\">Зарегистрировалось вчера</td><td align='right'>$nums</td>
</tr></tbody></table></td></tr>";
$statsref .= "<tr><td>Неподтвержденных</td><td align='right'>$unverified</td></tr><tr>
<td>Предупреждённых&nbsp;<img class='predupr' align='absbottom' src='pic/trans.gif' title='Предупреждённых'/></td><td align='right'>$warned_users</td></tr>
<tr><td>Отключенных&nbsp;<img class='zamok' align='absbottom' src='pic/trans.gif' title='Отключенных'/></td><td align='right'>$disabled</td>
</tr><tr><td><font color='orange'>Аплоадеров</font></td><td align='right'>$uploader</td></tr><tr>
<td><font color='#9C2FE0'>VIP</font></td><td align='right'>$vip</td></tr></tbody></table></td>";
$statsref .= "<td width='50%' align='center' style=\"border: none;\"><table class='main2' border='1' cellspacing='0' cellpadding='5'><tbody><tr>
<td colspan='2'><table width='100%' border='1' cellspacing='0' cellpadding='5'><tbody><tr>
<td style=\"text-align: right; font-weight: bold; vertical-align: top;\"><a href=\"browse\" title=\"Всего Релизов\">Релизов</a></td>
<td align='right'>$torrents</td></tr><tr><td class=rowhead2 style=\"text-align: right; font-weight: bold; vertical-align: top;\">
Размер коллекции</td><td class=rowhead2 align=right>$upstat</td></tr><tr>
<td style=\"text-align: right; font-weight: bold; vertical-align: top;\"><a href=\"dead\" title=\"Мертвых Релизов\">Мертвых Релизов</a></td>
<td align='right'>$dead</td></tr></tbody></table></td></tr>";
$statsref .= "<tr><td>Активных подключений</td><td align='right'><nobr>$peers</nobr></td></tr><tr>
<td>Раздающих&nbsp;&nbsp;<img class='seder' align='absbottom' src='pic/trans.gif' title='Раздающих'/></td><td align='right'><nobr>$seeders</nobr></td>
</tr><tr><td>Качающих&nbsp;&nbsp;<img class='lecher' align='absbottom' src='pic/trans.gif' title='Качающих'/></td>
<td align='right'><nobr>$leechers</nobr></td></tr><tr><td>Внешних Раздающих&nbsp;&nbsp;
<img class='seder' align='absbottom' src='pic/trans.gif' title='Внешних Раздающих'/></td><td align='right'><nobr>$external_seeders</nobr></td></tr><tr>
<td>Внешних Качающих&nbsp;&nbsp;<img class='lecher' align='absbottom' src='pic/trans.gif' title='Внешних Качающих'/></td><td align='right'>
<nobr>$external_$leechers</nobr></td></tr><tr><td>Раздающих/Качающих (%)</td><td align='right'>$ratio</td></tr>
<tr><td>Внешних Раздающих/Качающих (%)</td><td align='right'>$external_ratio</td></tr><tr><td>
Всего роздано</td><td align='right'>".mksize($uploaded)."</td></tr><tr><td>Всего скачано</td>
<td align='right'>".mksize($downloaded)."</td></tr><tr><td>Коэффициент NAT (%)</td>
<td align='right'>$nat %</td></tr></tbody></table></td></tr>
<tr><td class=\"embedded\"><font size=\"1\" color=\"grey\"><b>Блок обновлен:</b>&nbsp;<i>".nicetime(get_date_time(), true)."</i></font>
</td></tr></tbody></table>";$statsred = $statsref;$statsreds = "Stats_block";
$_cachestats = 'statsblock.cache';$CacheBlock->Write($_cachestats, $statsred);
sql_query("UPDATE stats SET textt = ".sqlesc($statsred).", time = NOW() WHERE id=1") or sqlerr();
}}else{
$res1 = sql_query("SELECT COUNT(*) FROM users WHERE gender='3'");$row1 = mysql_fetch_array($res1);$na = $row1[0];	
$res2 = sql_query("SELECT COUNT(*) FROM users WHERE warned='yes'");$row2 = mysql_fetch_array($res2);$warned_users = $row2[0];
$res3 = sql_query("SELECT COUNT(*) FROM users WHERE enabled='no'");$row3 = mysql_fetch_array($res3);$disabled = $row3[0];
$res4 = sql_query("SELECT COUNT(*) FROM users WHERE gender='1'");$row4 = mysql_fetch_array($res4);$male = $row4[0];
$res5 = sql_query("SELECT COUNT(*) FROM users WHERE gender='2'");$row5 = mysql_fetch_array($res5);$female = $row5[0];
$res6 = sql_query("SELECT COUNT(*) FROM users WHERE class='7'");$row6 = mysql_fetch_array($res6);$vip = $row6[0];
$res7 = sql_query("SELECT COUNT(*) FROM users WHERE class='6'");$row7 = mysql_fetch_array($res7);$uploader = $row7[0];
$res8 = sql_query("SELECT COUNT(*) FROM users WHERE status='pending'");$row8 = mysql_fetch_array($res8);$unverified = $row8[0];
$res9 = sql_query("SELECT COUNT(*) FROM torrents");$row9 = mysql_fetch_array($res9);$torrents = $row9[0];
$res10 = sql_query("SELECT COUNT(*) FROM torrents WHERE seeders='0'");$row10 = mysql_fetch_array($res10);$dead = $row10[0];
$res12 = sql_query("SELECT COUNT(*) FROM peers WHERE connectable='yes'");$row12 = mysql_fetch_array($res12);$connectable = $row12[0];
$res13 = sql_query("SELECT COUNT(*) FROM peers WHERE connectable='no'");$row13 = mysql_fetch_array($res13);$notconnectable = $row13[0];
$res14 = sql_query("SELECT COUNT(*) FROM peers FORCE INDEX(torrent_seeder) WHERE seeder='yes'");
$row14 = mysql_fetch_array($res14);$seeders = $row14[0];
$res15 = sql_query("SELECT COUNT(*) FROM peers FORCE INDEX(torrent_seeder) WHERE seeder='no'");
$row15 = mysql_fetch_array($res15);$leechers = $row15[0];$registered = $female + $male + $na;
$query_string = "SELECT invites FROM users";$sql = sql_query($query_string) or die(mysql_error());$num = 0;
while ($us = mysql_fetch_array($sql)){$num++;$invites += $us["invites"];
if ($num == mysql_num_rows($sql)){$nums = number_format(get_row_count("users", "WHERE DATEDIFF(added, NOW()) = -1")); 
if($connectable == 0)$nat = 0;else $nat = number_format($notconnectable / $connectable * 100);
list($external_seeders, $external_leechers) = array_map('number_format', mysql_fetch_row(sql_query('SELECT SUM(seeders), SUM(leechers) FROM torrents_scrape')));
$upsta = 0;if ($external_leechers == 0) $external_ratio = 0;else $external_ratio = $external_seeders / $external_leechers * 100; }}
$query_string2 = "SELECT downloaded, uploaded FROM snatched";$sql2 = sql_query($query_string2) or die(mysql_error());
while ($us2 = mysql_fetch_array($sql2)){$downloaded += $us2["downloaded"];$uploaded += $us2["uploaded"];}
$dow = sql_query("SELECT size FROM torrents") or sqlerr(__FILE__,__LINE__);
while ($down = mysql_fetch_array($dow)){$upsta = $upsta + $down["size"];}
$upstat = mksize($upsta);if ($leechers == 0)$ratio = 0;else $ratio = round($seeders / $leechers * 100);$peers = $seeders + $leechers;
$statsref .= "<table width='100%' border='0' cellspacing='0' cellpadding='10'><tbody><tr><td width='50%' align='center' style=\"border: none;\">
<table class=\"main2\" border='1' cellspacing='0' cellpadding='5'><tbody><tr><td colspan='2'>
<table width='100%' border='1' cellspacing='0' cellpadding='5'><tbody><tr>
<td style=\"text-align:right; font-weight:bold; vertical-align:top;\"><a href=\"users\" title=\"Всего Пользователей\">
Всего Пользователей</a></td><td align='right'>$registered</td></tr><tr>
<td style=\"text-align:right; font-weight:bold; vertical-align:top;\"><a href=\"boys\" title=\"Парней\">Парней</a></td>
<td align='right'><img class='boy' align='absbottom' src='pic/trans.gif' title='Парней'/>$male</td></tr><tr>
<td style=\"text-align:right; font-weight:bold; vertical-align:top;\"><a href=\"girls\" title=\"Девушек\">Девушек</a></td>
<td align=right><img class='girl' align='absbottom' src='pic/trans.gif' title='Девушек'/>$female</td></tr><tr>
<td style=\"text-align:right; font-weight:bold; vertical-align:top;\"><a href=\"transgender.php\" title=\"Трансиков\">Трансиков</a></td>
<td align='right'><img class='transgender' align='absbottom' src='pic/trans.gif' title='Трансиков'/>$na</td></tr></tbody></table></td></tr>";
$statsref .= "<tr><td colspan='2'><table width=100% border='1' cellspacing='0' cellpadding='5'><tbody><tr>
<td style=\"text-align:right; font-weight:bold; vertical-align:top;\">Мест на трекере</td>
<td align='right'>$maxusers</td></tr><tr><td style=\"text-align:right; font-weight:bold; vertical-align:top;\">
Мест по приглашениям</td><td align='right'>$invites</td></tr><tr>
<td style=\"text-align:right; font-weight:bold; vertical-align:top;\">Зарегистрировалось вчера</td><td align='right'>$nums</td>
</tr></tbody></table></td></tr>";
$statsref .= "<tr><td>Неподтвержденных</td><td align='right'>$unverified</td></tr><tr>
<td>Предупреждённых&nbsp;<img class='predupr' align='absbottom' src='pic/trans.gif' title='Предупреждённых'/></td><td align='right'>$warned_users</td></tr>
<tr><td>Отключенных&nbsp;<img class='zamok' align='absbottom' src='pic/trans.gif' title='Отключенных'/></td><td align='right'>$disabled</td>
</tr><tr><td><font color='orange'>Аплоадеров</font></td><td align='right'>$uploader</td></tr><tr>
<td><font color='#9C2FE0'>VIP</font></td><td align='right'>$vip</td></tr></tbody></table></td>";
$statsref .= "<td width='50%' align='center' style=\"border: none;\"><table class='main2' border='1' cellspacing='0' cellpadding='5'><tbody><tr>
<td colspan='2'><table width='100%' border=1 cellspacing=0 cellpadding='5'><tbody><tr>
<td style=\"text-align: right; font-weight: bold; vertical-align: top;\"><a href=\"browse\" title=\"Всего Релизов\">Релизов</a></td>
<td align=right>$torrents</td></tr><tr><td style=\"text-align: right; font-weight: bold; vertical-align: top;\">
Размер коллекции</td><td align='right'>$upstat</td></tr><tr>
<td style=\"text-align: right; font-weight: bold; vertical-align: top;\"><a href=\"dead\" title=\"Мертвых Релизов\">Мертвых Релизов</a></td>
<td align='right'>$dead</td></tr></tbody></table></td></tr>";
$statsref .= "<tr><td>Активных подключений</td><td align='right'><nobr>$peers</nobr></td></tr><tr>
<td>Раздающих&nbsp;&nbsp;<img class='seder' align='absbottom' src='pic/trans.gif' title='Раздающих'/></td><td align='right'><nobr>$seeders</nobr></td>
</tr><tr><td>Качающих&nbsp;&nbsp;<img class='lecher' align='absbottom' src='pic/trans.gif' title='Качающих'/></td>
<td align='right'><nobr>$leechers</nobr></td></tr><tr><td>Внешних Раздающих&nbsp;&nbsp;
<img class='seder' align='absbottom' src='pic/trans.gif' title='Внешних Раздающих'/></td><td align='right'><nobr>$external_seeders</nobr></td></tr><tr>
<td>Внешних Качающих&nbsp;&nbsp;<img class='lecher' align='absbottom' src='pic/trans.gif' title='Внешних Качающих'/></td><td align='right'>
<nobr>$external_$leechers</nobr></td></tr><tr><td>Раздающих/Качающих (%)</td><td align='right'>$ratio</td></tr>
<tr><td>Внешних Раздающих/Качающих (%)</td><td align='right'>$external_ratio</td></tr><tr><td>
Всего роздано</td><td align='right'>".mksize($uploaded)."</td></tr><tr><td>Всего скачано</td>
<td align='right'>".mksize($downloaded)."</td></tr><tr><td>Коэффициент NAT (%)</td>
<td align='right'>$nat %</td></tr></tbody></table></td></tr>
<tr><td class=\"embedded\"><font size=\"1\" color=\"grey\"><b>Блок обновлен:</b>&nbsp;<i>".nicetime(get_date_time(), true)."</i></font>
</td></tr></tbody></table>";$statsred = $statsref;$statsreds = "Stats_block";
$_cachestats = 'statsblock.cache';$CacheBlock->Write($_cachestats, $statsred);
sql_query("INSERT stats SET textt = ".sqlesc($statsred).", time = NOW()");}
//////////////// stats KONEC//////////////////////////////////////
sql_query("OPTIMIZE TABLE `online`, `sessions`, `shoutbox`, `shoutbox2`, `sitelog`, `peers`, `torrents`, `users`; ");}?>