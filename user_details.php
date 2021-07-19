<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
function perday ($added='',$value='',$mksize=true){
$daysreg = (time() - sql_timestamp_to_unix_timestamp($added)) / (24*3600);
if ($value <= 0) return '0.00 KB';
$parday = $value / $daysreg;
$parday = round($parday, 2);
if($parday > $value) $parday = $value;
return ($mksize ? mksize($parday) : $parday);}    
function maketable($res){global $tracker_lang, $CURUSER;
//////////// раздает и качает начало /////////////////////
$ret = "<table class=main border=1 width=100% cellspacing=0 cellpadding=5><tr>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:70px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">Жанр</td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:70px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">Тип</td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">".$tracker_lang['name']."</td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/filesize.png\" alt=\"".$tracker_lang['size']."\" title=\"".$tracker_lang['size']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowup1.gif\" alt=\"".$tracker_lang['details_seeding']."\" title=\"".$tracker_lang['details_seeding']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowdown1.gif\" alt=\"".$tracker_lang['details_leeching']."\" title=\"".$tracker_lang['details_leeching']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowup.gif\" alt=\"".$tracker_lang['uploaded']."\" title=\"".$tracker_lang['uploaded']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowdown.gif\" alt=\"".$tracker_lang['downloaded']."\" title=\"".$tracker_lang['downloaded']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/multitracker.png\" alt=\"".$tracker_lang['ratio']."\" title=\"".$tracker_lang['ratio']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:120px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">".$tracker_lang['connected']."<hr>day:hour:min:sec</td></tr>";
while ($arr = mysql_fetch_assoc($res)){
if ($arr["downloaded"] > 0){$ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3, '.', '');$ratio = "<font color=".get_ratio_color($ratio).">$ratio</font>";}elseif($arr["uploaded"] > 0) $ratio = "Inf."; else $ratio = "Inf.";
//////////////////
$secs = 7*86400; //// 7 day /////
if($arr["seedtime"] > 0){$hours_seed = "<b><font color='green'>".mkprettytime($arr['seedtime'])."</font></b>";
}else{$hours_seed = "<img border=\"0\" src=\"pic/nol.png\" alt=\"Ничего не сидировал\" title=\"Ничего не сидировал\">";}
//////// если просидировал больше 7 дней начало //////////
if($arr["seedtime"] >= $secs){
switch ($arr['free']){case 'bril': 
$ttname = "<font color=\"blue\" title=\"Бриллиантовая раздача! Это значит, что кол-во розданного на этой раздаче удваивается!\">".$arr["torrentname"]."</font>";
break;
case 'yes': 
$ttname = "<font color=\"#d08700\" title=\"Золотая раздача! Это значит, что кол-во скачанного на этой раздаче не идет в общую статистику!\">".$arr["torrentname"]."</font>";
break;
case 'silver': 
$ttname = "<font color=\"#778899\" title=\"Серебрянная раздача! Это значит, что половина скачанного на этой раздаче не идет в общую статистику!\">".$arr["torrentname"]."</font>";
break;
case 'no': $ttname = $arr["torrentname"];}$tnames = $ttname;
//////// если просидировал больше 7 дней конец //////////
}elseif($arr["seedtime"] < $secs){
////////////скидки для раздачи - бриллиант, золото, серебро, обычная - начало/////////////
switch ($arr['free']){case 'bril': 
$ttname = "<font color=\"blue\" title=\"Бриллиантовая раздача! Это значит, что кол-во розданного на этой раздаче удваивается!\">".$arr["torrentname"]."</font>";break;
case 'yes': 
$ttname = "<font color=\"#d08700\" title=\"Золотая раздача! Это значит, что кол-во скачанного на этой раздаче не идет в общую статистику!\">".$arr["torrentname"]."</font>";break;
case 'silver': 
$ttname = "<font color=\"#778899\" title=\"Серебрянная раздача! Это значит, что половина скачанного на этой раздаче не идет в общую статистику!\">".$arr["torrentname"]."</font>";break;
case 'no': $ttname = $arr["torrentname"];}$tnames = $ttname;}
/////////////////////
$catid = $arr["catid"];
$addeds = $arr["added"];
$incatid = $arr["incatid"];
$catimage = htmlspecialchars($arr["catimage"]);
$incatimage = htmlspecialchars($arr["incatimage"]);
$catname = htmlspecialchars($arr["catname"]);
$incatname = htmlspecialchars($arr["incatname"]);	
$size = str_replace(" ", "<br>", mksize($arr["size"]));
$uploaded = mksize($arr["uploaded"]);
$downloaded = mksize($arr["downloaded"]);
$seeders = number_format($arr["seeders"]);
$leechers = number_format($arr["leechers"]);
///////////////////////	
$tog = sql_query("SELECT COUNT(*) FROM snatched WHERE userid='".$CURUSER["id"]."' AND torrent='".$arr["torrent"]."'");$tokg = mysql_fetch_array($tog);
if(!$tokg['0']){$torg = "";}else{$torg = "&nbsp;<a href=\"download_$arr[torrent]\"><img class=\"main-completed\" src=\"pic/trans.gif\" 
title=\"Вы уже брали этот торрент. Нажмите, чтобы загрузить файл .torrent еще раз.\"/></a>&nbsp;";}
///////////////////////////////////
$ret .= "<tr><td style='padding:0px' width=\"70px\"><center><a href=\"janr_$catid\"><img src=\"pic/cats/$catimage\" title=\"$catname\" border=\"0\"></a></center></td>
<td style='padding:0px' width=\"70px\"><center><a href=\"tip_$incatid\" title=\"$incatname\"><img src=\"pic/cats/$incatimage\" title=\"$incatname\" border=\"0\"></a></center></td>
<td><table border=\"0\" width=\"100%\" style='background:none;'><tbody><tr><td class=\"null\" style='background:none;'>$torg
<a href=\"details_$arr[id]\"><b>$tnames</b></a></td></tr></tbody></table><br>
<div id=\"cleft\"><font size=\"1\" color=\"grey\"><b>Релиз залит:</b>&nbsp;<i>".nicetime($addeds, true)."</i></font></div></td>
<td><center>$size</center></td><td><center>$seeders</center></td><td><center>$leechers</center></td>
<td><center>$uploaded</center></td><td><center>$downloaded</center></td><td><center>$ratio</center></td>
<td align=\"center\" width=\"120px\">$hours_seed</td></tr>";
}$ret .= "</table>";return $ret;}
//////////// раздает и качает конец /////////////////////
//////////////////////////////////////////////////////////////////
$id = intval($_GET["id"]);
if ($_GET["info"] == "info"){
////////////////
$cache = new Memcache();$cache->connect('127.0.0.1', 11211); // IP вашего сервера и порт Мемкеша
$row = array();if(!$row = $cache->get('user_cache_'.$id)){
$res = mysql_query('SELECT * FROM users WHERE id = '.sqlesc($id)) or err('There is no user with this ID');
$row = mysql_fetch_array($res);$cache->set('user_cache_'.$id, $row, MEMCACHE_COMPRESSED, 1800);}$user = $row;
///////////
if($user["id"] != $id) stderr2("<center>Error!</center>", "<center>Нет пользователя с таким ID: <b>$id</b>.</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
if($user["status"] == "pending") stderr2("<center>Error!</center>", "<center>Пользователь с ID: <b>$id</b> еще не активировал свой аккаунт.</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
////////////////////////////////////////////////////////
///////////// залитые торренты начало /////////////
$r = sql_query("SELECT torrents.id, torrents.name, torrents.added, (torrents.leechers+torrents.remote_leechers) AS leechers, 
(torrents.seeders+torrents.remote_seeders) AS seeders, torrents.category, torrents.incategory, torrents.free, torrents.size, categories.name AS catname, 
incategories.name AS incatname, categories.image AS catimage, incategories.image AS incatimage, categories.id AS catid, incategories.id AS incatid 
FROM torrents LEFT JOIN categories ON torrents.category = categories.id LEFT JOIN incategories ON torrents.incategory = incategories.id 
WHERE owner=$id ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($r) > 0){
$torrents = "<table class=main border=1 width=100% cellspacing=0 cellpadding=5><tr>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:70px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">Жанр</td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:70px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">Тип</td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">".$tracker_lang['name']."</td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/filesize.png\" alt=\"".$tracker_lang['size']."\" title=\"".$tracker_lang['size']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowup1.gif\" alt=\"".$tracker_lang['details_seeding']."\" title=\"".$tracker_lang['details_seeding']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:70px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowdown1.gif\" alt=\"".$tracker_lang['details_leeching']."\" title=\"".$tracker_lang['details_leeching']."\"></td></tr>";
while($a = mysql_fetch_assoc($r)){  
switch($a['free']){
case 'bril': $disnamez = "<font color=\"blue\" title=\"Бриллиантовая раздача! Это значит, что кол-во отданного удваивается, а скачанное не учитывается!\">".$a["name"]."</font>";break;   
case 'yes': $disnamez = "<font color=\"#d08700\" title=\"Золотая раздача! Это значит, что кол-во скачаного на этой раздаче не идет в общую статистику!\">".$a["name"]."</font>";break;   
case 'silver': $disnamez = "<font color=\"#778899\" title=\"Серебрянная раздача! Это значит, что половина скачаного на этой раздаче не идет в общую статистику!\">".$a["name"]."</font>";break;   
case 'no': $disnamez = "".$a["name"]."";}$disnamesz = $disnamez;$sizessz = str_replace(" ", "<br>", mksize($a["size"]));
///////////////////////	
$toa = sql_query("SELECT COUNT(*) FROM snatched WHERE userid='".$CURUSER['id']."' AND torrent='".$a['id']."'");$toka = mysql_fetch_array($toa);
if(!$toka['0']){$torkaz = "";}else{$torkaz = "&nbsp;<a href=\"download_$a[id]\"><img class=\"main-completed\" src=\"pic/trans.gif\" title=\"Вы уже брали этот торрент. Нажмите, чтобы загрузить файл .torrent еще раз.\"/></a>&nbsp;";}
////////////////////////////
$addedsz = $a["added"];
$cat = "<a href=\"janr_$a[catid]\"><img src=\"pic/cats/$a[catimage]\" title=\"$a[catname]\" border=\"0\"></a>";
$incat = "<a href=\"tip_$a[incatid]\"><img src=\"pic/cats/$a[incatimage]\" title=\"$a[incatname]\" border=\"0\"></a>";
$torrents .= "<tr><td style='padding:0px' width=\"70px\"><center>$cat</center></td><td style='padding:0px' width=\"70px\"><center>$incat</center></td>
<td><table border=\"0\" width=\"100%\" style='background:none;'><tbody><tr><td class=\"null\" style='background:none;'>$torkaz
<a href=\"details_".$a["id"]."\"><b>$disnamesz</b></a></td></tr></tbody></table><br>
<div id=\"cleft\"><font size=\"1\" color=\"grey\"><b>Релиз залит:</b>&nbsp;<i>".nicetime($addedsz, true)."</i></font></div></td>
<td><center>$sizessz</center></td><td><center>$a[seeders]</center></td><td><center>$a[leechers]</center></td></tr>"; }
$torrents .= "</table>";}
///////////// залитые торренты конец /////////////
///////////////////////////////////////////////////////
$it = sql_query("SELECT u.id, u.username, u.class, i.id AS invitedid, i.username AS invitedname, i.class AS invitedclass FROM users AS u 
LEFT JOIN users AS i ON i.id = u.invitedby WHERE u.invitedroot = $id OR u.invitedby = $id ORDER BY u.invitedby");
if(mysql_num_rows($it) >= 1){$invitetree = "<table class=\"main\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\"><br>";while ($inviter = mysql_fetch_array($it)) $invitetree .= "<a href=\"userdetails.php?id=$inviter[id]\">".get_user_class_color($inviter["class"], $inviter["username"])."</a>, ";$invitetree .= "</table>";}
if($user["ip"] && (get_user_class() >= UC_MODERATOR || $user["id"] == $CURUSER["id"])){$ip = $user["ip"];$addr = "<br><br><img src=\"pic/ip.png\" title=\"IP\">&nbsp;<b>IP:</b>&nbsp;$ip";}   
////////////////////////////////////////////////////
//////////// скачал начало /////////////////////
$rr = sql_query("SELECT snatched.torrent AS id, snatched.seed_time AS seedtime, snatched.uploaded, snatched.seeder, 
UNIX_TIMESTAMP() - UNIX_TIMESTAMP(snatched.last_action) AS last_action, snatched.downloaded, 
categories.name AS catname, incategories.name AS incatname, categories.image AS catimage, incategories.image AS incatimage, 
categories.id AS catid, incategories.id AS incatid, torrents.name, torrents.size, torrents.added, torrents.free, 
(torrents.leechers+torrents.remote_leechers) AS leechers, (torrents.seeders+torrents.remote_seeders) AS seeders FROM snatched 
JOIN torrents ON torrents.id = snatched.torrent JOIN categories ON torrents.category = categories.id 
JOIN incategories ON torrents.incategory = incategories.id WHERE snatched.finished='yes' AND userid = $id ORDER BY added DESC") or sqlerr(__FILE__,__LINE__);
if(mysql_num_rows($rr) > 0){
$completed = "<table class=\"main\" border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"5\"><tr>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:70px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">Жанр</td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:70px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">Тип</td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">Название</td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/filesize.png\" alt=\"".$tracker_lang['size']."\" title=\"".$tracker_lang['size']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowup1.gif\" alt=\"".$tracker_lang['details_seeding']."\" title=\"".$tracker_lang['details_seeding']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowdown1.gif\" alt=\"".$tracker_lang['details_leeching']."\" title=\"".$tracker_lang['details_leeching']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowup.gif\" alt=\"Раздал\" title=\"Раздал\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowdown.gif\" alt=\"Скачал\" title=\"Скачал\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/multitracker.png\" alt=\"Рейтинг\" title=\"Рейтинг\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/up.png\" alt=\"Сидирует\" title=\"Сидирует\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:120px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">".$tracker_lang['connected']."<hr>day:hour:min:sec</td></tr>";
while ($aa = mysql_fetch_array($rr)){
if($aa["downloaded"] > 0){$ratiosc = number_format($aa["uploaded"] / $aa["downloaded"], 3, '.', '');
$ratiosc = "<font color=\"".get_ratio_color($ratiosc)."\">$ratiosc</font>";}elseif($aa["uploaded"] > 0) $ratiosc = "Inf.";else $ratiosc = "Inf.";
//////////////////
$secs = 7*86400; //// 7 day /////
if($aa["seedtime"] > 0){$hours_seedsc = "<b><font color='green'>".mkprettytime($aa['seedtime'])."</font></b>";
}else{$hours_seedsc = "<img border=\"0\" src=\"pic/nol.png\" alt=\"Ничего не сидировал\" title=\"Ничего не сидировал\">";}
//////// если просидировал больше 7 дней начало //////////
if($aa["seedtime"] >= $secs){
switch ($aa['free']){case 'bril': $ttnamesc = "<font color=\"blue\" title=\"Бриллиантовая раздача! Это значит, что кол-во розданного на этой раздаче удваивается!\">".$aa["name"]."</font>";
break;
case 'yes': $ttnamesc = "<font color=\"#d08700\" title=\"Золотая раздача! Это значит, что кол-во скачанного на этой раздаче не идет в общую статистику!\">".$aa["name"]."</font>";
break;
case 'silver': $ttnamesc = "<font color=\"#778899\" title=\"Серебрянная раздача! Это значит, что половина скачанного на этой раздаче не идет в общую статистику!\">".$aa["name"]."</font>";
break;
case 'no': $ttnamesc = $aa["name"];}$tnamessc = $ttnamesc;
//////// если просидировал больше 7 дней конец //////////
}elseif($aa["seedtime"] < $secs){
////////////скидки для раздачи - бриллиант, золото, серебро, обычная - начало/////////////
switch ($aa['free']){case 'bril': 
$ttnamesc = "<font color=\"blue\" title=\"Бриллиантовая раздача! Это значит, что кол-во розданного на этой раздаче удваивается!\">".$aa["name"]."</font>";break;
case 'yes': 
$ttnamesc = "<font color=\"#d08700\" title=\"Золотая раздача! Это значит, что кол-во скачанного на этой раздаче не идет в общую статистику!\">".$aa["name"]."</font>";break;
case 'silver': 
$ttnamesc = "<font color=\"#778899\" title=\"Серебрянная раздача! Это значит, что половина скачанного на этой раздаче не идет в общую статистику!\">".$aa["name"]."</font>";break;
case 'no': $ttnamesc = $aa["name"];}$tnamessc = $ttnamesc;}
/////////////////////
$uploadedsc = mksize($aa["uploaded"]);
$downloadedsc = mksize($aa["downloaded"]);
$sizezzsc = mksize($aa["size"]);
$addedsssc = $aa["added"];
if($aa["seeder"] == 'yes') $seedersc = "<img border=\"0\" src=\"pic/da.png\" alt=\"Сидирует\" title=\"Сидирует\">"; 
else $seedersc = "<img border=\"0\" src=\"pic/net.png\" alt=\"Подключения нет\" title=\"Подключения нет\">";
$cat = "<a href=\"janr_$aa[catid]\"><img src=\"pic/cats/$aa[catimage]\" title=\"$aa[catname]\" border=\"0\"></a>";
$incat = "<a href=\"tip_$aa[incatid]\"><img src=\"pic/cats/$aa[incatimage]\" title=\"$aa[incatname]\" border=\"0\"></a>";
///////////////////////	
$toaasc = sql_query("SELECT COUNT(*) FROM snatched WHERE userid='".$CURUSER['id']."' AND torrent='".$aa['id']."'");$tokaasc = mysql_fetch_array($toaasc);
if(!$tokaasc['0']){$torkaasc = "";}else{$torkaasc = "&nbsp;<a href=\"download_$aa[id]\"><img class=\"main-completed\" src=\"pic/trans.gif\" title=\"Вы уже брали этот торрент. Нажмите, чтобы загрузить файл .torrent еще раз.\"></a>&nbsp;";}
////////////////////////////
$completed .= "<tr><td style=\"padding: 0px\" width=\"70px\"><center>$cat</center></td><td style=\"padding: 0px\" width=\"70px\"><center>$incat</center></td>
<td><table border=\"0\" width=\"100%\" style='background:none;'><tbody><tr><td class=\"null\" style='background:none;'>$torkaasc
<a href=\"details_".$aa["id"]."\"><b>$tnamessc</b></a></td></tr></tbody></table><br>
<div id=\"cleft\"><font size=\"1\" color=\"grey\"><b>Релиз залит:</b>&nbsp;<i>".nicetime($addedsssc, true)."</i></font></div></td>
<td><center>$sizezzsc</center></td><td><center>$aa[seeders]</center></td><td><center>$aa[leechers]</center></td>
<td><center>$uploadedsc</center></td><td><center>$downloadedsc</center></td><td><center>$ratiosc</center></td>
<td><center>$seedersc</center></td><td align=\"center\" width=\"120px\">$hours_seedsc</td></tr>";
}$completed .= "</table>";}
//////////// скачал конец /////////////////////
////////////////////////////////////////////////////
//////////// HE скачал 100% начало /////////////////////
$rrd = sql_query("SELECT snatched.torrent AS id, snatched.seed_time AS seedtime, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(snatched.last_action) AS last_action,
snatched.mulct AS ls, snatched.uploaded, snatched.seeder, snatched.downloaded, categories.name AS catname, 
incategories.name AS incatname, categories.image AS catimage, incategories.image AS incatimage, 
categories.id AS catid, incategories.id AS incatid, torrents.name, torrents.size, torrents.added, torrents.free, 
(torrents.leechers+torrents.remote_leechers) AS leechers, (torrents.seeders+torrents.remote_seeders) AS seeders 
FROM snatched JOIN torrents ON torrents.id = snatched.torrent JOIN categories ON torrents.category = categories.id 
JOIN incategories ON torrents.incategory = incategories.id WHERE snatched.finished='no' AND downloaded > 0
AND userid = $id ORDER BY added DESC") or sqlerr(__FILE__,__LINE__);
if(mysql_num_rows($rrd) > 0){
$completedd = "<table class=\"main\" border=\"1\" width=100% cellspacing=\"0\" cellpadding=\"5\"><tr>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:70px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">Жанр</td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:70px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">Тип</td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">Название</td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/filesize.png\" alt=\"".$tracker_lang['size']."\" title=\"".$tracker_lang['size']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowup1.gif\" alt=\"".$tracker_lang['details_seeding']."\" title=\"".$tracker_lang['details_seeding']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowdown1.gif\" alt=\"".$tracker_lang['details_leeching']."\" title=\"".$tracker_lang['details_leeching']."\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowup.gif\" alt=\"Раздал\" title=\"Раздал\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/arrowdown.gif\" alt=\"Скачал\" title=\"Скачал\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/multitracker.png\" alt=\"Рейтинг\" title=\"Рейтинг\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\"><img border=\"0\" src=\"pic/up.png\" alt=\"Сидирует\" title=\"Сидирует\"></td>
<td class=\"zaliwka\" style=\"color:#FFFFFF;colspan:14;width:120px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:1;\">
".$tracker_lang['connected']."<hr>day:hour:min:sec</td></tr>";
while ($aad = mysql_fetch_array($rrd)){
if($aad["downloaded"] > 0){$rationes = number_format($aad["uploaded"] / $aad["downloaded"], 3, '.', '');
$rationes = "<font color=\"".get_ratio_color($rationes)."\">$rationes</font>";}elseif($aad["uploaded"] > 0) $rationes = "Inf.";else $rationes = "Inf.";
//////////////////
$secs = 7*86400; //// 7 day /////
if($aad["seedtime"] > 0){$hours_seednes = "<b><font color='green'>".mkprettytime($aad['seedtime'])."</font></b>";
}else{$hours_seednes = "<img border=\"0\" src=\"pic/nol.png\" alt=\"Ничего не сидировал\" title=\"Ничего не сидировал\">";}
//////// если просидировал больше 7 дней начало //////////
if($aad["seedtime"] >= $secs){
switch ($aad['free']){case 'bril': $ttnamenes = "<font color=\"blue\" title=\"Бриллиантовая раздача! Это значит, что кол-во розданного на этой раздаче удваивается!\">".$aad["name"]."</font>";break;
case 'yes': $ttnamenes = "<font color=\"#d08700\" title=\"Золотая раздача! Это значит, что кол-во скачанного на этой раздаче не идет в общую статистику!\">".$aad["name"]."</font>";
break;
case 'silver': $ttnamenes = "<font color=\"#778899\" title=\"Серебрянная раздача! Это значит, что половина скачанного на этой раздаче не идет в общую статистику!\">".$aad["name"]."</font>";break;
case 'no': $ttnamenes = $aad["name"];}$tnamesnes = $ttnamenes;
//////// если просидировал больше 7 дней конец //////////
}elseif($aad["seedtime"] < $secs){
////////////скидки для раздачи - бриллиант, золото, серебро, обычная - начало/////////////
switch ($aad['free']){case 'bril': 
$ttnamenes = "<font color=\"blue\" title=\"Бриллиантовая раздача! Это значит, что кол-во розданного на этой раздаче удваивается!\">".$aad["name"]."</font>";break;
case 'yes': 
$ttnamenes = "<font color=\"#d08700\" title=\"Золотая раздача! Это значит, что кол-во скачанного на этой раздаче не идет в общую статистику!\">".$aad["name"]."</font>";break;
case 'silver': 
$ttnamenes = "<font color=\"#778899\" title=\"Серебрянная раздача! Это значит, что половина скачанного на этой раздаче не идет в общую статистику!\">".$aad["name"]."</font>";break;
case 'no': $ttnamenes = $aad["name"];}$tnamesnes = $ttnamenes;}
/////////////////////
$uploadednes = mksize($aad["uploaded"]);
$downloadednes = mksize($aad["downloaded"]);
$sizezznes = mksize($aad["size"]);
if($aad["seeder"] == 'yes') $seedernes = "<img border=\"0\" src=\"pic/da.png\" alt=\"Сидирует\" title=\"Сидирует\">"; 
else $seedernes = "<img border=\"0\" src=\"pic/net.png\" alt=\"Подключения нет\" title=\"Подключения нет\">";
$cat = "<a href=\"janr_$aad[catid]\"><img src=\"pic/cats/$aad[catimage]\" title=\"$aad[catname]\" border=\"0\"></a>";
$incat = "<a href=\"tip_$aad[incatid]\"><img src=\"pic/cats/$aad[incatimage]\" title=\"$aad[incatname]\" border=\"0\"></a>";
///////////////////////	
$toaanes = sql_query("SELECT COUNT(*) FROM snatched WHERE userid='".$CURUSER['id']."' AND torrent='".$aad['id']."'");$tokaanes = mysql_fetch_array($toaanes);
if(!$tokaanes['0']){$torkaanes = "";}else{$torkaanes = "&nbsp;<a href=\"download_$aad[id]\"><img class=\"main-completed\" src=\"pic/trans.gif\" title=\"Вы уже брали этот торрент. Нажмите, чтобы загрузить файл .torrent еще раз.\"></a>&nbsp;";}
////////////////////////////
$addedssnes = $aad["added"];
$completedd .= "<tr><td style=\"padding:0px\" width=\"70px\"><center>$cat</center></td>
<td style=\"padding:0px\" width=\"70px\"><center>$incat</center></td>
<td><table border=\"0\" width=\"100%\" style='background:none;'><tbody><tr><td class=\"null\" style='background:none;'>$torkaanes
<a href=\"details_".$aad["id"]."\"><b>$tnamesnes</b></a></td></tr></tbody></table><br>
<div id=\"cleft\"><font size=\"1\" color=\"grey\"><b>Релиз залит:</b>&nbsp;<i>".nicetime($addedssnes, true)."</i></font></div></td>
<td><center>$sizezznes</center></td><td><center>$aad[seeders]</center></td><td><center>$aad[leechers]</center></td>
<td><center>$uploadednes</center></td><td><center>$downloadednes</center></td><td><center>$rationes</center></td>
<td><center>$seedernes</center></td><td align=\"center\" width=\"120px\">$hours_seednes</td></tr>";
}$completedd .= "</table>";}
//////////// HE скачал 100% конец /////////////////////
if ($user[added] == "0000-00-00 00:00:00") $joindate = 'N/A';else $joindate = "$user[added] (".get_elapsed_time(sql_timestamp_to_unix_timestamp($user["added"]))." ".$tracker_lang['ago'].")";
$lastseen = $user["last_access"];if($lastseen == "0000-00-00 00:00:00") $lastseen = $tracker_lang['never'];else{$lastseen .= " (".get_elapsed_time(sql_timestamp_to_unix_timestamp($lastseen))." ".$tracker_lang['ago'].")";}
$res = sql_query("SELECT name, flagpic FROM countries WHERE id = ".$user['country']." LIMIT 1") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res) == 1){$arr = mysql_fetch_assoc($res);$country = "<b>".$arr['name']."</b>&nbsp;&nbsp;<img src=\"pic/flag/$arr[flagpic]\" title=\"$arr[name]\">";}
if($user["donor"] == "yes") $donor = "&nbsp;&nbsp;<img src='pic/starbig.gif' alt='Donor' title='Donor'>";
if($user["warned"] == "yes"){
////////////////////БАН ДО - начало//////////////////////////////
$warneduser1 = $user["warneduntil"];
$warneduser = mkprettytime(strtotime($warneduser1) - gmtime());
if($warneduser == 0){$warnedusers = '<b><font color="red">Юзер ЗАБАНЕН НАВСЕГДА</font></b>';    
}else{$warnedusers = "<b><font color='red'>предупреждение</font></b> закончится через:&nbsp;<b><font color='darkred'>$warnedusers</font></b>";}
////////////////////БАН ДО - конец//////////////////////////////	
$warned = "<img src='pic/predupred.png' title='Warned' alt='Warned'><br><br>$warnedusers<br><br>";}
if($user["gender"] == "1") $gender = "<img src=\"pic/male.gif\" alt=\"Парень\" title=\"Парень\">";
elseif($user["gender"] == "2") $gender = "<img src=\"pic/female.gif\" alt=\"Девушка\" title=\"Девушка\">";
elseif($user["gender"] == "3") $gender = "<img src=\"pic/gender1.png\" alt=\"Не определился\" title=\"Не определился\">";
///////////////////
$res = sql_query("SELECT snatched.torrent AS id, snatched.seed_time AS seedtime, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(snatched.last_action) AS last_action, 
snatched.uploaded, snatched.seeder, snatched.downloaded, categories.name AS catname, incategories.name AS incatname, 
categories.image AS catimage, incategories.image AS incatimage, categories.id AS catid, peers.torrent, incategories.id AS incatid, 
torrents.name AS torrentname, torrents.size, torrents.added, torrents.free, (torrents.leechers+torrents.remote_leechers) AS leechers, 
(torrents.seeders+torrents.remote_seeders) AS seeders FROM snatched JOIN peers ON peers.torrent = snatched.torrent 
JOIN torrents ON torrents.id = snatched.torrent JOIN categories ON torrents.category = categories.id 
JOIN incategories ON torrents.incategory = incategories.id WHERE snatched.seeder = 'no' AND snatched.userid = $id 
AND peers.userid = $id ORDER BY added DESC") or sqlerr(__FILE__,__LINE__);
//////////////////////
if (mysql_num_rows($res) > 0) $leeching = maketable($res);
/////////////////////
$res = sql_query("SELECT snatched.torrent AS id, snatched.seed_time AS seedtime, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(snatched.last_action) AS last_action, 
snatched.uploaded, snatched.seeder, snatched.downloaded, categories.name AS catname, incategories.name AS incatname, 
categories.image AS catimage, incategories.image AS incatimage, categories.id AS catid, incategories.id AS incatid, torrents.name AS torrentname, 
torrents.size, torrents.added, torrents.free, (torrents.leechers+torrents.remote_leechers) AS leechers, 
(torrents.seeders+torrents.remote_seeders) AS seeders FROM snatched JOIN torrents ON torrents.id = snatched.torrent 
JOIN categories ON torrents.category = categories.id JOIN incategories ON torrents.incategory = incategories.id WHERE snatched.seeder='yes' 
AND snatched.userid = $id ORDER BY added DESC") or sqlerr(__FILE__,__LINE__);
//////////////////////
if (mysql_num_rows($res) > 0) $seeding = maketable($res);
///////////////// BIRTHDAY MOD /////////////////////
if($user[birthday] != "0000-00-00"){
$current = date("Y-m-d", time() + $CURUSER['tzoffset'] * 60);
list($year2, $month2, $day2) = explode('-', $current);
$birthday = $user["birthday"];
$birthday = date("Y-m-d", strtotime($birthday));
list($year1, $month1, $day1) = explode('-', $birthday);
if($month2 < $month1){$age = $year2 - $year1 - 1;}
if($month2 == $month1){if($day2 < $day1){$age = $year2 - $year1 - 1;}else{$age = $year2 - $year1;}}
if($month2 > $month1){$age = $year2 - $year1;}
////////зодиак///////
$month_of_birth = substr($user["birthday"], 5, 2);$day_of_birth = substr($user["birthday"], 8, 2);
for($i = 0; $i < count($zodiac); $i++){if(($month_of_birth == substr($zodiac[$i][2], 3, 2))){
if($day_of_birth >= substr($zodiac[$i][2], 0, 2)){$zodiac_img = $zodiac[$i][1];$zodiac_name = $zodiac[$i][0];
}else{if($i == 11){$zodiac_img = $zodiac[0][1];$zodiac_name = $zodiac[0][0];
}else{$zodiac_img = $zodiac[$i+1][1];$zodiac_name = $zodiac[$i+1][0];}}}}}
///////////////// BIRTHDAY MOD /////////////////////
?><table style='background:none;' width="100%" border="0" cellspacing='0' cellpadding='5'><center><tr><td valign="top" width="300px" style="border:0;" align="center"><? 
if($user['enabled'] == 'no'){list($disuntil) = mysql_fetch_row(sql_query('SELECT disuntil FROM users_ban WHERE userid = '.$user['id']));if($disuntil != '0000-00-00 00:00:00'){print("<img src=\"pic/disabledss.png\" title=\"Этот аккаунт отключен\">");}else{print("<img src=\"pic/baned.png\" title=\"Этот аккаунт забанен\">");}}?>
<?=$warned;?><?if($user["avatar"] !=""){?><img src="<?=$user["avatar"]?>"><?}else{?><img src="pic/noavatar.gif"><?}?><br><br>
<? if ($user["gender"] == "1"){ ?><img src="pic/userboy.png" alt="Парень" title="Парень">&nbsp;&nbsp;<?}
elseif ($user["gender"] == "2"){?><img src="pic/usergirl.png" alt="Девушка" title="Девушка">&nbsp;&nbsp;<?}
elseif ($user["gender"] == "3"){?><img src="pic/transgender.png" alt="Не определился" title="Не определился">&nbsp;&nbsp;<?}?>
<font size="4"><b><?=get_user_class_color($user['class'], $user[username])?></b></font><br><br>
<b><?=get_user_class_color($user["class"], get_user_class_name($user["class"]))?>
<?if ($user["title"] != ""){?> / <span style="color: purple;"><?=$user["title"]?></span><?}?></b><br><br>
<img src="<?=get_user_class_image($user["class"])?>" title="<?=get_user_class_name($user["class"])?>"><?=$donor;?><br><br><?=$gender?>
<img src="pic/zodiac/<?=$zodiac_img;?>" alt="<?=$zodiac_name;?>" title="<?=$zodiac_name;?>"><br>
<?if ($CURUSER["id"] != $user["id"]) if (get_user_class() >= UC_MODERATOR) $showpmbutton = 1;elseif ($user["acceptpms"] == "yes"){
$r = sql_query("SELECT id FROM blocks WHERE userid = $user[id] AND blockid = $CURUSER[id]") or sqlerr(__FILE__,__LINE__);
$showpmbutton = (mysql_num_rows($r) == 1 ? 0 : 1);}
elseif ($user["acceptpms"] == "friends"){
$r = sql_query("SELECT id FROM friends WHERE userid = $user[id] AND friendid = $CURUSER[id]") or sqlerr(__FILE__,__LINE__);
$showpmbutton = (mysql_num_rows($r) == 1 ? 1 : 0);}
if ($showpmbutton) print("<br><br><img src=\"pic/pn_inbox.gif\" border=\"0\">&nbsp;&nbsp;<a href=\"#\" onclick=\"javascript:window.open('sendpm_".$user["id"]."', 'Послать ЛС', 'width=650, height=465');return false;\" title=\"Отправить ЛС\"><font size=3 color=darkred><b>Послать ЛС</b></font></a><br>");?>
</td><td valign="top" style="border:0;" align="left">
<img src="pic/donload.png" title="Раздал(a)">&nbsp;&nbsp;<b>Раздал(a):</b> <?=mksize($user["uploaded"])?>&nbsp;(<?=perday($user['added'],$user["uploaded"])?>&nbsp;<?=$tracker_lang['perday']?>)<br><br>
<img src="pic/upload.png" title="Скачал(a)">&nbsp;&nbsp;<b>Скачал(a):</b> <?=mksize($user["downloaded"])?>&nbsp;(<?=perday($user['added'],$user["downloaded"])?>&nbsp;<?=$tracker_lang['perday']?>)<br><br>
<img src="pic/trafik.png" title="Всего трафика">&nbsp;&nbsp;<b>Всего трафика:</b> <?=mksize($user["downloaded"] + $user["uploaded"])?><br><br>
<? if($user["downloaded"] > 0){$sr = $user["uploaded"] / $user["downloaded"];
if ($sr >= 4) $s = "w00t";else if ($sr >= 2) $s = "grin";else if ($sr >= 1) $s = "smile1";else if ($sr >= 0.5) $s = "noexpression";else if ($sr >= 0.25) $s = "sad";else $s = "cry";
$sr = floor($sr * 1000) / 1000;$sr = "<font color=\"" . get_ratio_color($sr) . "\">" . number_format($sr, 3, '.', '') . "</font>&nbsp;&nbsp;<img src=\"pic/smilies1/$s.gif\">";}else{$sr = "<font color=blue><b>inf.</b></font>";}?>
<img src="pic/reyting.png" title="Рейтинг">&nbsp;&nbsp;<b>Рейтинг:</b> <?=$sr?><br><br>
<img src="pic/bonus.png" title="Бонус">&nbsp;&nbsp;<b>Бонус:</b> <?=$user["bonus"]?><br><br>
<img src="pic/coments.png" title="Комментариев Релизов">&nbsp;&nbsp;<b>Комментариев Релизов:</b>
<? if($user["comreliz"] && (($user["id"] == $CURUSER["id"]) || get_user_class() >= UC_1080p)){?>
<a href="usercom_<?=$id?>"><?=$user["comreliz"];?></a><?}else{?><?=$user["comreliz"];?><?}?><br><br>
<img src="pic/chats.png" title="Комментариев на Форуме">&nbsp;&nbsp;<b>Комментариев на Форуме:</b>
<? if($user["comforum"] && (($user["id"] == $CURUSER["id"]) || get_user_class() >= UC_1080p)){?>
<a href="fcom_<?=$id?>"><?=$user["comforum"];?></a><?}else{?><?=$user["comforum"];?><?}?><br><br>
<img src="pic/forumicons/forum_new.gif" title="Тем на Форуме">&nbsp;&nbsp;<b>Тем на Форуме:</b>
<? if($user["topicforum"] && (($user["id"] == $CURUSER["id"]) || get_user_class() >= UC_1080p)){?>
<a href="forumsearch.php?id=<?=$id?>"><?=$user["topicforum"];?></a><?}else{?><?=$user["topicforum"];?><?}?>
<br><br><img src="pic/shtraf_sm.png" title="Штраф">&nbsp;&nbsp;<b>Штраф:</b>&nbsp;&nbsp;<font color='red'><b><?=$user["premiya"];?></b></font>
<br><br><img src="pic/like.png" border="0">&nbsp;<b>Поблагодарили юзера:</b> <?=$user['simpaty'];?> раз
<?if ($user["website"]){?><br><br><img src="pic/sayt.png" title="Сайт">&nbsp;&nbsp;<b>Сайт:</b>&nbsp;&nbsp;<a href="<?=$user['website']?>" target="_blank"><b><?=$user['website']?></b></a><?}?>
<?if($addr)?><?=$addr?><?if(get_user_class() >= UC_MODERATOR){if ($user["name"] != ""){?><br><br><img src="pic/class_success.gif" title="Откуда Юзер">&nbsp;&nbsp;<b>Откуда Юзер:</b>&nbsp;<?=$user["name"]?><?}}$dt = gmtime() - 300;$dt = sqlesc(get_date_time($dt));
print("<br><br>&nbsp;&nbsp;&nbsp;".("'".$user['last_access']."'">$dt?"<img src=pic/button_online.gif border=0 title=\"Юзер Он-лайн\">&nbsp;&nbsp;<b>Юзер Он-лайн</b>":"<img src=pic/button_offline.gif border=0  title=\"Юзера сейчас нет на сайте\">&nbsp;&nbsp;<b>Юзера сейчас нет на сайте</b>" )."");?>
<br><br><? $spy_res = sql_query("SELECT sessions.uid, sessions.username, sessions.class FROM sessions 
WHERE url='/user_details.php?id=".$id."&info=info' ORDER BY class ASC") or sqlerr(__FILE__, __LINE__);
$views = array();while(list($user_id, $user_name, $user_class) = mysql_fetch_array($spy_res)){
$views[] = '<a target=_blank href=userdetails.php?id='.$user_id.'>'.get_user_class_color($user_class, $user_name).'</a>';}
$num = sizeof($views);$result = ($num ? implode(', ' , $views) : 'Ни кто');?>Онлайн тут (<?=$num;?>): <?=$result;?>
</td><td valign="top" style="border:0;" align="left"><img src="pic/strana.png" alt="Страна" title="Страна">&nbsp;&nbsp;<?=$country?><br><br>
<img src="pic/registr.png" title="Зарегистрирован">&nbsp;&nbsp;<b>Зарегистрирован:</b> <?=$joindate?><br><br>
<img src="pic/lastlogin.png" title="Последнее посещение">&nbsp;&nbsp;<b>Последнее посещение:</b> <?=$lastseen?><br><br>
<img src="pic/parking.jpg" title="Аккаунт припаркован?">&nbsp;&nbsp;<b>Аккаунт припаркован:</b> <?if($user['parked'] == 'no'){?>Нет<?}else{?>Да<?}?><br><br>
<?if($user['invayt']=='no' || $user["id"] == $CURUSER["id"] || (get_user_class() >= UC_MODERATOR)){?>
<?if($user["invitedby"] != 0){
$inviter = mysql_fetch_assoc(sql_query("SELECT username FROM users WHERE id = ".sqlesc($user["invitedby"])));?>
<img src="pic/priglasil.png" title="Пригласил">&nbsp;&nbsp;<b>Пригласил:</b> <b><a href="userdetails.php?id=<?=$user['invitedby']?>"><?=$inviter['username']?></a></b><br><br><?}}?>
<?$birthday = date("d.m.Y", strtotime($birthday));?>
<img src="pic/denrojd.png" title="Дата Рождения">&nbsp;&nbsp;<b>Дата Рождения:</b> <?=$birthday?><br><br>
<img src="pic/vozvrast.png" title="Возраст">&nbsp;&nbsp;<b>Возраст:</b> <?=$age?> лет</a><br><br>
<?if($user["telgr"] || $user["skype"]){?><img src="pic/svyaz.png" title="Связь">&nbsp;&nbsp;<b>Связь:</b><?if($user["telgr"]) print("&nbsp;&nbsp;<a href='https://t.me/$user[telgr]' target='_blank'><img src=\"pic/tlgr.png\" alt=\"Telegram\" border=\"0\" title=\"Telegram\" />&nbsp;$user[telgr]</a>");if ($user["skype"]) print("&nbsp;&nbsp;<img src=\"pic/contact/skype.gif\" alt=\"skype\" border=\"0\" title=\"skype\" /> $user[skype]");?></b><br><br><?}?>
<?if(get_user_class() >= UC_MODERATOR || $user["id"] == $CURUSER["id"]){?><img src="pic/email.png" title="Email">&nbsp;&nbsp;<b>Email:</b> <b><a href="mailto:$user[email]"><?=$user['email']?></a></b><br><br><?}?>
<?if (get_user_class() >= UC_MODERATOR || $user["id"] == $CURUSER["id"]){?><img src="pic/invayt.png" title="Приглашений">&nbsp;&nbsp;<b>Приглашений:</b> <a href="invite.php?id=<?=$id?>"><?=$user["invites"]?></a><br><br><?}?>
<img src="pic/golden.gif" title="Donations">&nbsp;&nbsp;<a href="donate.php"><b>Donations:</b></a> &euro;<b><?=$user["donated"]?></b><br><br><?
if($CURUSER["id"] <> $user["id"]){
$r = sql_query("SELECT id FROM friends WHERE userid=$CURUSER[id] AND friendid = ".$user['id']) or sqlerr(__FILE__, __LINE__);$friend = mysql_num_rows($r);
$r = sql_query("SELECT id FROM blocks WHERE userid=$CURUSER[id] AND blockid = ".$user['id']) or sqlerr(__FILE__, __LINE__);$block = mysql_num_rows($r);
if ($friend) print("<a href=\"friends.php?action=delete&type=friend&targetid=".$user['id']."\"><input type=\"button\" class=\"button4\" value=\"Убрать из друзей\"></a><br>");
elseif($block) print("<a href=\"friends.php?action=delete&type=block&targetid=".$user['id']."\"><input type=\"button\" class=\"button4\" value=\"Убрать из блокированых\"></a><br>");else{
print("<a href=\"friends.php?action=add&type=friend&targetid=".$user['id']."\"><input type=\"button\" class=\"button4\" value=\"Добавить в друзья\"></a>&nbsp;&nbsp;&nbsp;");
print("<a href=\"friends.php?action=add&type=block&targetid=".$user['id']."\"><input type=\"button\" class=\"button4\" value=\"Добавить в блокированные\"></a><br><br><br>");
}}?></td></tr></center></table><table style='background:none;' width="100%" border="0" cellspacing='0' cellpadding='5'><center>
<?if ($user["info"]){print("<tr><td width=\"100%\" style='border:0;' align=\"center\">".$user["info"]."</td></tr>");}?>
<script src="js/show_hide.js"></script><?
if ($torrents && ($user['hider']=='no' || $user["id"] == $CURUSER["id"] || (get_user_class() >= UC_MODERATOR))){
$torrents1 = get_row_count('torrents', 'WHERE owner ='.$user["id"]);
print("<tr><td width=\"100%\" style='border:0;' align=\"center\"><b>Залитые&nbsp;торренты:</b>&nbsp;<b><font color=green size=2>$torrents1</font></b>&nbsp;(список)&nbsp;<a href=\"javascript: show_hide('s1')\"><img border=\"0\" src=\"pic/plus.gif\" id=\"pics1\" title=\"Показать\"></a><br><br><div id=\"ss1\" style=\"display: none;\">$torrents</div></td></tr>");}
if ($seeding){
print("<tr><td width=\"100%\" style='border:0;' align=\"center\"><b>Сейчас&nbsp;раздает:</b>&nbsp;<b><font color=green size=2>".$user["seeder"]."</font></b>&nbsp;(список)&nbsp;<a href=\"javascript: show_hide('s2')\"><img border=\"0\" src=\"pic/plus.gif\" id=\"pics2\" title=\"Показать\"></a><br><br><div id=\"ss2\" style=\"display: none;\">$seeding</div></td></tr>");}
if ($leeching){
print("<tr><td width=\"100%\" style='border:0;' align=\"center\"><b>Сейчас&nbsp;качает:</b>&nbsp;<b><font color=green size=2>".$user["leecher"]."</font></b>&nbsp;(список)&nbsp;<a href=\"javascript: show_hide('s3')\"><img border=\"0\" src=\"pic/plus.gif\" id=\"pics3\" title=\"Показать\"></a><br><br><div id=\"ss3\" style=\"display: none;\">$leeching</div></td></tr>");}
if ($completed){
$completed1 = get_row_count('snatched', 'WHERE finished = "yes" AND userid ='.$user["id"]);
print("<tr><td width=\"100%\" style='border:0;' align=\"center\"><b>Скачаные&nbsp;торренты:</b>&nbsp;<b><font color=green size=2>$completed1</font></b>&nbsp;(список)&nbsp;<a href=\"javascript: show_hide('s4')\"><img border=\"0\" src=\"pic/plus.gif\" id=\"pics4\"></a><br><br><div id=\"ss4\" style=\"display: none;\">$completed</div></td></tr>");}
if($completedd){
$completed2 = get_row_count('snatched', 'WHERE finished = "no" AND downloaded > 0 AND userid ='.$user["id"]);
print("<tr><td width=\"100%\" style='border:0;' align=\"center\"><b>HE&nbsp;Скачаные&nbsp;100%&nbsp;торренты:</b>&nbsp;<b><font color=green size=2>$completed2</font></b>&nbsp;(список)&nbsp;<a href=\"javascript: show_hide('s6')\"><img border=\"0\" src=\"pic/plus.gif\" id=\"pics6\"></a><br><br><div id=\"ss6\" style=\"display: none;\">$completedd</div></td></tr>");}
if($invitetree && ($user["id"] == $CURUSER["id"] || (get_user_class() >= UC_MODERATOR))){
$invitetree1 = get_row_count('users', 'WHERE invitedby = '.$user["id"]);	
print("<tr><td width=\"100%\" style='border:0;' align=\"center\"><b>Приглашенные:</b>&nbsp;<b><font color=green size=2>$invitetree1</font></b>&nbsp;(список)&nbsp;<a href=\"javascript: show_hide('s5')\"><img border=\"0\" src=\"pic/plus.gif\" id=\"pics5\"></a><br><br><div id=\"ss5\" style=\"display: none;\">$invitetree</div></td></tr>");}
print("</center></table>
<table style='background:none;' width='100%' border='0' cellspacing='0' cellpadding='5'><center>");?>
<div align="center" style='background:none;'>
<STYLE>.smilies{display:inline-block;width:98px;height:98px;background:#ecf3fd;border:1px solid #b8d6fb;margin:2px;-moz-border-radius:3px;-khtml-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;cursor:pointer}.smilies:hover{background:#c2dcfc;border:1px solid #7da2ce}.smilies div{height:98px}.smilies img{max-height:90px;max-width:90px;margin-top:5px;-moz-box-shadow:1px 1px 3px 1px #96a6b9;-khtml-box-shadow:1px 1px 3px 1px #96a6b9;-webkit-box-shadow:1px 1px 3px 1px #96a6b9;box-shadow:1px 1px 3px 1px #96a6b9}.podarki{background:#ecf3fd;border:1px solid #b8d6fb;margin:3px;-moz-border-radius:3px;-khtml-border-radius:3px;-webkit-border-radius:3px;border-radius:3px}.podarki:hover{background:#c2dcfc;border:1px solid #7da2ce}.bro input{height:25px;width:100%}</STYLE>
<?$respod = sql_query("SELECT podarok.podarokid, (SELECT podarki.pic FROM podarki WHERE podarki.id=podarok.podarokid) AS picp FROM podarok WHERE userid = ".$user["id"]) or sqlerr (__FILE__, __LINE__);
while($arrpod = mysql_fetch_assoc($respod)){print("<div class=\"smilies\"><img src=\"{$arrpod['picp']}\"></div>");}?> 
</div><br><table style='background:none;border:0;' width='100%' border='0' cellspacing='0' cellpadding='5'><center><tr><td style='background:none;border:0;' align="center">
<a href="podarok.php?id=<?=$id?>" title="Подарить подарок"><input type="button" value="Подарить подарок"></a>&nbsp;&nbsp;
&nbsp;<a href="podarok.php?userid=<?=$id?>" title="Все подарки"><input type="button" value="Все подарки"></a></td></tr></center></table></center></table><?}
///////////////////////////
if ($_GET["info"] == "edit"){
////////////////////////
$cache = new Memcache();$cache->connect('127.0.0.1', 11211); // IP вашего сервера и порт Мемкеша
$row = array();if(!$row = $cache->get('user_cache_'.$id)){
$res = mysql_query('SELECT * FROM users WHERE id = '.sqlesc($id)) or err('There is no user with this ID');
$row = mysql_fetch_array($res);$cache->set('user_cache_'.$id, $row, MEMCACHE_COMPRESSED, 1800);}$user = $row;
if($user["id"] != $id) stderr2("<center>Error!</center>", "<center>Нет пользователя с таким ID $id.</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
$enabled = $user["enabled"] == 'yes';
if (get_user_class() >= UC_MODERATOR){
print("<center><form width=\"100%\" method=\"post\" enctype=\"multipart/form-data\" action=\"modtask.php\">");
print("<input type=\"hidden\" name=\"action\" value=\"edituser\">");
print("<input type=\"hidden\" name=\"userid\" value='".$user["id"]."'>");
print("<input type=\"hidden\" name=\"returnto\" value='userdetails.php?id=".$user["id"]."'>");
print("<table width=\"100%\" style='border:0;' cellspacing=\"0\" cellpadding=\"5\">");
$avatar = htmlspecialchars($user["avatar"]);?>
<tr><td width="50%" style="border:0;" align="left">
<b>Логин Юзера:</b>&nbsp;&nbsp;<input type="text" size="40" name="username" value="<?=htmlspecialchars_uni($user[username])?>"><br><br>
<img src="pic/email.png" title="Email">&nbsp;&nbsp;<b>Email Юзера:</b>&nbsp;&nbsp;<input type="text" size="40" name="emails" value="<?=htmlspecialchars_uni($user[email])?>"><br><br>
<img src="pic/zagolov.png" title="Заголовок">&nbsp;&nbsp;<input type="text" size="40" name="title" value="<?=htmlspecialchars_uni($user[title])?>"><br><br>
<img src="pic/avatar.png" title="Аватар">&nbsp;&nbsp;<b>Аватар:</b>&nbsp;&nbsp;
<input type="radio" name="avatar" value='keep' checked>Оставить аватар&nbsp;&nbsp;<input type="radio" name="avatar" value='delete'>
Удалить аватар&nbsp;&nbsp;<input type="radio" name="avatar" value='update'>Обновить аватар<br>
<input type="file" name="avatar" size="60"><br><?=sprintf($tracker_lang['max_avatar_size'], $avatar_max_width, $avatar_max_height)?><br><br>
<? if(get_user_class() == UC_MODERATOR){
print("<img src=\"pic/class.png\" title=\"Класс\">&nbsp;&nbsp;<b>Класс:</b>&nbsp;&nbsp;<input type=\"hidden\" name=\"class\" value=\"$user[class]\"><br><br>");
}else{print("<img src=\"pic/class.png\" title=\"Класс\">&nbsp;&nbsp;<b>Класс:</b>&nbsp;&nbsp;<select name=\"class\">");
$maxclass = get_user_class();
for ($i = 0; $i <= $maxclass; ++$i) print("<option value=\"$i\"".($user["class"] == $i ? " selected" : "").">$prefix".get_user_class_name($i)."");
print("</select><br><br>");}
if($CURUSER["class"] < UC_ADMINISTRATOR){?><img src="pic/donat.png" title="Донор">&nbsp;&nbsp;<b>Донор:</b>&nbsp;&nbsp;<input type="hidden" name="donor" value="<?=$user[donor]?>">
<br><br><?}else{?><b>Тема оформления:</b>&nbsp;&nbsp;<?=$themes = theme_selector($user["theme"]);?><br><br><?
print("<img src=\"pic/donat.png\" title=\"Донор\">&nbsp;&nbsp;<b>Донор:</b>&nbsp;&nbsp;<input type=\"radio\" name=\"donor\" value=\"yes\"".($user["donor"] == "yes" ? " checked" : "").">Да <input type=\"radio\" name=\"donor\" value=\"no\"".($user["donor"] == "no" ? " checked" : "").">Нет<br><br>");}	
?><b>Подпись Юзера:</b>&nbsp;&nbsp;<textarea cols="60" rows="3" name="podpis"><?=htmlspecialchars_uni($user[info])?></textarea><br><br><?
$modcomment = htmlspecialchars($user["modcomment"]);$supportfor = htmlspecialchars($user["supportfor"]);
print("<img src=\"pic/suport.png\" title=\"Поддержка\">&nbsp;&nbsp;<b>Поддержка:</b>&nbsp;&nbsp;<input type=radio name=support value=yes".($user["support"] == "yes" ? " checked" : "").">Да <input type=radio name=support value=no".($user["support"] == "no" ? " checked" : "").">Нет<br><br>");
print("<img src=\"pic/suport.png\" title=\"Поддержка для\">&nbsp;&nbsp;<b>Поддержка для:</b>&nbsp;&nbsp;<textarea cols=60 rows=3 name=supportfor>$supportfor</textarea><br><br>");
print("<img src=\"pic/istory.png\" title=\"История пользователя\">&nbsp;&nbsp;<b>История пользователя:</b>&nbsp;&nbsp;<textarea cols=60 rows=6".(get_user_class() < UC_SYSOP ? " readonly" : " name=modcomment").">$modcomment</textarea><br><br>");
print("<img src=\"pic/zametka.png\" title=\"Добавить заметку\">&nbsp;&nbsp;<b>Добавить заметку:</b>&nbsp;&nbsp;<textarea cols=60 rows=3 name=modcomm></textarea><br><br>");
?></td><td width="50%" style="border:0;" align="left">
<script>function togglepic(e,c,i){var u=document.getElementById(c),l=document.getElementById(i);u.src==e+"/pic/plus.gif"?(u.src=e+"/pic/minus.gif",l.value="minus"):(u.src=e+"/pic/plus.gif",l.value="plus")}</script><?
$ct_r = sql_query("SELECT id,name FROM countries ORDER BY name") or die;while ($ct_a = mysql_fetch_array($ct_r))
$countries.= "<option value=$ct_a[id]".($user["country"] == $ct_a['id'] ? " selected" : "").">$ct_a[name]</option>";
print("<img src=\"pic/strana.png\" alt=\"Страна\" title=\"Страна\">&nbsp;&nbsp;<select name=country>$countries</select><br><br>");
print("<img src=\"pic/denrojd.png\" title=\"Сбросить день рождения\">&nbsp;&nbsp;<b>Сбросить день рождения:</b>&nbsp;&nbsp;
<input type=\"radio\" name=\"resetb\" value=\"yes\">Да<input type=\"radio\" name=\"resetb\" value=\"no\" checked>Нет<br>");
//////////////////////////////////
$birthday = $user['birthday'];$birthday = date('Y-m-d', strtotime($birthday));
list($year1, $month1, $day1) = explode('-', $birthday);
$year .= "<select name=year><option value=$year1>$year1</option>";$i = "1950";
while($i <= (date('Y',time()))){$year .= "<option value=" .$i. ">".$i."</option>";$i++;}
$year .= "</select>";
$birthmonths = array(
        "01" => $tracker_lang['my_months_january'],
        "02" => $tracker_lang['my_months_february'],
        "03" => $tracker_lang['my_months_march'],
        "04" => $tracker_lang['my_months_april'],
        "05" => $tracker_lang['my_months_may'],
        "06" => $tracker_lang['my_months_june'],
        "07" => $tracker_lang['my_months_jule'],
        "08" => $tracker_lang['my_months_august'],
        "09" => $tracker_lang['my_months_september'],
        "10" => $tracker_lang['my_months_october'],
        "11" => $tracker_lang['my_months_november'],
        "12" => $tracker_lang['my_months_december'], );
        $month = "<select name=\"month\"><option value=$month1>$month1</option>";
foreach ($birthmonths as $month_no => $show_month){$month .= "<option value=$month_no>$show_month</option>";}
$month .= "</select>";
$day .= "<select name=day><option value=$day1>$day1</option>";$i = 1;
while ($i <= 31){if($i < 10){$day .= "<option value=0".$i. ">0".$i."</option>";}else{$day .= "<option value=".$i.">".$i."</option>";}$i++;}
$day .="</select>";
print("<br><b>year - month - day</b><br>".$year . $month . $day."<br><br>");
//////////////////////////////////////////
print("<img src=\"pic/donload.png\" title=\"Изменить раздачу\">&nbsp;&nbsp;<b>Изменить раздачу:</b>&nbsp;&nbsp;<img src=\"pic/plus.gif\" id=\"uppic\" onClick=\"togglepic('$DEFAULTBASEURL','uppic','upchange')\" style=\"cursor: pointer;\">&nbsp;<input type=\"text\" name=\"amountup\" size=\"10\" />&nbsp;<select name=\"formatup\"><option value=\"mb\">MB</option><option value=\"gb\">GB</option></select><br><br>");
print("<img src=\"pic/upload.png\" title=\"Изменить скачку\">&nbsp;&nbsp;<b>Изменить скачку:</b>&nbsp;&nbsp;<img src=\"pic/plus.gif\" id=\"downpic\" onClick=\"togglepic('$DEFAULTBASEURL','downpic','downchange')\" style=\"cursor: pointer;\">&nbsp;<input type=\"text\" name=\"amountdown\" size=\"10\" />&nbsp;<select name=\"formatdown\"><option value=\"mb\">MB</option><option value=\"gb\">GB</option></select><br><br>");
print("<img src=\"pic/bonus.png\" title=\"Снять Бонусы\">&nbsp;&nbsp;<b>Снять Бонусы:</b>&nbsp;&nbsp;<img src=\"pic/minus.gif\">&nbsp;<input type=\"text\" name=\"bonup\" size=\"10\" /><br><br>");
print("<img src=\"pic/bonus.png\" title=\"Добавить Бонусы\">&nbsp;&nbsp;<b>Добавить Бонусы:</b>&nbsp;&nbsp;<img src=\"pic/plus.gif\">&nbsp;<input type=\"text\" name=\"bondown\" size=\"10\" /><br><br>");
print("<img src=\"pic/invayt.png\" title=\"Снять Приглашения\">&nbsp;&nbsp;<b>Снять Приглашения:</b>&nbsp;&nbsp;<img src=\"pic/minus.gif\">&nbsp;<input type=\"text\" name=\"invup\" size=\"10\" /><br><br>");
print("<img src=\"pic/invayt.png\" title=\"Добавить Приглашения\">&nbsp;&nbsp;<b>Добавить Приглашения:</b>&nbsp;&nbsp;<img src=\"pic/plus.gif\">&nbsp;<input type=\"text\" name=\"invdown\" size=\"10\" /><br><br>");
print("<img src=\"pic/arrowup.png\" title=\"Раздает сейчас торрентов\">&nbsp;&nbsp;<b>Раздает сейчас торрентов:</b>&nbsp;&nbsp;<input type=\"text\" size=\"10\" name=\"seeder\" value=".htmlspecialchars_uni($user['seeder'])."><br><br>");
print("<img src=\"pic/arrowdown.png\" title=\"Качает сейчас торрентов\">&nbsp;&nbsp;<b>Качает сейчас торрентов:</b>&nbsp;&nbsp;<input type=\"text\" size=\"10\" name=\"leecher\" value=".htmlspecialchars_uni($user['leecher'])."><br><br>");
print("<img src=\"pic/paskey.png\" title=\"Сбросить passkey\">&nbsp;&nbsp;<b>Сбросить passkey:</b>&nbsp;&nbsp;<input name=\"resetkey\" value=\"1\" type=\"checkbox\"><br><br>");
print("<img src=\"pic/chats.png\" title=\"Использовать Чат\">&nbsp;&nbsp;<b>Использовать Чат:</b>&nbsp;&nbsp;<input type=radio name=schoutboxpos value=yes" .($user["schoutboxpos"]=="yes" ? " checked" : "") . ">Да <input type=radio name=schoutboxpos value=no" .($user["schoutboxpos"]=="no" ? " checked" : "") . ">Нет<br><br>");
print("<img src=\"pic/coments.png\" title=\"Комментарии разрешены\">&nbsp;&nbsp;<b>Комментарии разрешены:</b>&nbsp;&nbsp;<input type=radio name=comentoff value=yes" .($user["comentoff"]=="yes" ? " checked" : "") . ">Да <input type=radio name=comentoff value=no" .($user["comentoff"]=="no" ? " checked" : "") . ">Нет<br><br>");
$warned = $user["warned"] == "yes";
print("<img src=\"pic/predupred.png\" title=\"Предупреждение\">&nbsp;&nbsp;".($warned? "<input name=\"warned\" value=\"yes\" type=\"radio\" checked>Да<input name=\"warned\" value=\"no\" type=\"radio\">Нет" : "<b>Нет</b>")."&nbsp;&nbsp;");
if($warned){$warneduntil = $user['warneduntil'];
if ($warneduntil == '0000-00-00 00:00:00') print("<b>На неограниченый срок</b><br><br>");else{print("<b>До $warneduntil</b>");print(" (".mkprettytime(strtotime($warneduntil) - gmtime())." осталось)<br><br>");}}else{
print("&nbsp;&nbsp;Предупредить на <select name=\"warnlength\"><option value=\"0\">------</option><option value=\"1\">1 неделю</option><option value=\"2\">2 недели</option><option value=\"4\">4 недели</option><option value=\"8\">8 недель</option><option value=\"255\">Неограничено</option></select><br><b>Комментарий в ЛС:</b>&nbsp;&nbsp;<input type=\"text\" size=\"40\" name=\"warnpm\"><br><br>");}	
print("<img src=\"pic/vikluch.png\" title=\"Включен\">&nbsp;&nbsp;".($enabled ? "<font color=\"green\"><b>Пользователь включен</b></font>" : "<font color=\"red\"><b>Пользователь отключен</b></font>")."&nbsp;&nbsp;");
$disabler = <<<DIS
<select name="dislength"><option value="0">------</option><option value="1">1 неделю</option><option value="2">2 недели</option><option value="4">4 недели</option><option value="8">8 недель</option><option value="255">Неограничено</option></select>
DIS;
if ($enabled) print("&nbsp;&nbsp;Отключить на:&nbsp;&nbsp;$disabler<br><b>Причина отключения:</b>&nbsp;<input type=\"text\" name=\"disreason\" size=\"60\" /><br><br>");
else print("&nbsp;&nbsp;<b>Включить?</b>&nbsp;&nbsp;<input name=\"enabled\" value=\"yes\" type=\"radio\">Да <input name=\"enabled\" value=\"no\" type=\"radio\" checked>Нет<br><b>Причина включения:</b>&nbsp;&nbsp;<input type=\"text\" name=\"enareason\" size=\"60\" /><br><br>");
if ($CURUSER["class"] < UC_ADMINISTRATOR){print("<input type=\"hidden\" name=\"deluser\">");
}else{print("<img src=\"pic/deluser.png\" title=\"Удалить юзера\">&nbsp;&nbsp;<b>Удалить юзера</b>&nbsp;&nbsp;<input type=\"checkbox\" name=\"deluser\"><br><br>");}
?></td></tr><?print("<tr><td style='border:0;' colspan='3' align='center'><input type=\"submit\" class=\"btn\" value=\"ОК\"></td></tr></table>
<input type=\"hidden\" id=\"upchange\" name=\"upchange\" value=\"plus\"><input type=\"hidden\" id=\"downchange\" name=\"downchange\" value=\"plus\"></form></center>");}}
}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>