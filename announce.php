<?php define ('IN_ANNOUNCE', true);require_once('./include/core_announce.php');gzip();
foreach (array('passkey','info_hash','peer_id','event','ip','localip') as $x){if(isset($_GET[$x])) $GLOBALS[$x] = ''.$_GET[$x];}
foreach (array('port','downloaded','uploaded','left') as $x) $GLOBALS[$x] = intval($_GET[$x]);
if (get_magic_quotes_gpc()){$info_hash = stripslashes($info_hash);$peer_id = stripslashes($peer_id);}
foreach (array('passkey','info_hash','peer_id','port','downloaded','uploaded','left') as $x) if(!isset($x)) err('Missing key: '.$x);
foreach (array('info_hash','peer_id') as $x) if (strlen($GLOBALS[$x]) != 20) err('Invalid '.$x.' ('.strlen($GLOBALS[$x]).' - '.urlencode($GLOBALS[$x]).')');
if(strlen($passkey) != 32) err('Invalid passkey('.strlen($passkey).' - '.$passkey.')');$ip = getip();$rsize = 50;
foreach(array('num want', 'numwant', 'num_want') as $k){if (isset($_GET[$k])){$rsize = (int) $_GET[$k];break;}}
$agent = $_SERVER['HTTP_USER_AGENT'];if(!$port || $port > 0xffff) err("Invalid port");if(!isset($event)) $event = '';$seeder = ($left == 0) ? 'yes' : 'no';
if($agent == 'Deluge 1.3.15') err ("Out of date or BANNED  client version. You need to change your client with one in the ACCEPTED  list.");
if(substr($peer_id, 0, 6) == "exbc\08") err("BitComet 0.56 is Banned, Upgrade.");
if(substr($peer_id, 0, 4) == "FUTB") err("FUTB? Fuck You Too.");
if(substr($peer_id, 1, 2) == 'BC' && substr($peer_id, 5, 2) != 70 && substr($peer_id, 5, 2) != 63 && substr($peer_id, 5, 2) != 77 && substr($peer_id, 5, 2) >= 59/* && substr($peer_id, 5, 2) <= 88*/) err("BitComet ".substr($peer_id, 5, 2)." is banned. Use only 0.70 or switch to uTorrent 1.8.2.");
if(substr($peer_id, 1, 2) == 'UT' && substr($peer_id, 3, 3) < 182) err("uTorrent ".substr($peer_id, 3, 3)." is banned. Downgrade to µTorrent 2.0.4 stable (not 21515), 2.2.1 stable, 3.0 stable, 3.1.2 stable, 3.1.3 stable, 3.3 stable, 3.4.0 – 3.5.5 or higher.");
if(substr($peer_id, 1, 2) == 'UT' && substr($peer_id, 3, 3) > 182 && substr($peer_id, 3, 3) < 204) err("uTorrent ".substr($peer_id, 3, 3)." is banned. Downgrade to µTorrent 2.0.4 stable (not 21515), 2.2.1 stable, 3.0 stable, 3.1.2 stable, 3.1.3 stable, 3.3 stable, 3.4.0 – 3.5.5 or higher.");
if(substr($peer_id, 1, 2) == 'UT' && substr($peer_id, 3, 3) > 204 && substr($peer_id, 3, 3) < 221) err("uTorrent ".substr($peer_id, 3, 3)." is banned. Downgrade to µTorrent 2.0.4 stable (not 21515), 2.2.1 stable, 3.0 stable, 3.1.2 stable, 3.1.3 stable, 3.3 stable, 3.4.0 – 3.5.5 or higher.");
if(substr($peer_id, 1, 2) == 'UT' && substr($peer_id, 3, 3) > 221 && substr($peer_id, 3, 3) < 300) err("uTorrent ".substr($peer_id, 3, 3)." is banned. Downgrade to µTorrent 2.0.4 stable (not 21515), 2.2.1 stable, 3.0 stable, 3.1.2 stable, 3.1.3 stable, 3.3 stable, 3.4.0 – 3.5.5 or higher.");
if(substr($peer_id, 1, 2) == 'UT' && substr($peer_id, 3, 3) > 300 && substr($peer_id, 3, 3) < 312) err("uTorrent ".substr($peer_id, 3, 3)." is banned. Downgrade to µTorrent 2.0.4 stable (not 21515), 2.2.1 stable, 3.0 stable, 3.1.2 stable, 3.1.3 stable, 3.3 stable, 3.4.0 – 3.5.5 or higher.");
if(substr($peer_id, 1, 2) == 'UT' && substr($peer_id, 3, 3) > 312 && substr($peer_id, 3, 3) < 313) err("uTorrent ".substr($peer_id, 3, 3)." is banned. Downgrade to µTorrent 2.0.4 stable (not 21515), 2.2.1 stable, 3.0 stable, 3.1.2 stable, 3.1.3 stable, 3.3 stable, 3.4.0 – 3.5.5 or higher.");
if(substr($peer_id, 1, 2) == 'UT' && substr($peer_id, 3, 3) > 313 && substr($peer_id, 3, 3) < 330) err("uTorrent ".substr($peer_id, 3, 3)." is banned. Downgrade to µTorrent 2.0.4 stable (not 21515), 2.2.1 stable, 3.0 stable, 3.1.2 stable, 3.1.3 stable, 3.3 stable, 3.4.0 – 3.5.5 or higher.");
if(substr($peer_id, 1, 2) == 'UT' && substr($peer_id, 3, 3) > 330 && substr($peer_id, 3, 3) < 340) err("uTorrent ".substr($peer_id, 3, 3)." is banned. Downgrade to µTorrent 2.0.4 stable (not 21515), 2.2.1 stable, 3.0 stable, 3.1.2 stable, 3.1.3 stable, 3.3 stable, 3.4.0 – 3.5.5 or higher.");
if(substr($peer_id, 1, 2) == 'UT' && substr($peer_id, 3, 3) > 355) err("uTorrent ".substr($peer_id, 3, 3)." is banned. Downgrade to µTorrent 2.0.4 stable (not 21515), 2.2.1 stable, 3.0 stable, 3.1.2 stable, 3.1.3 stable, 3.3 stable, 3.4.0 – 3.5.5 or higher.");
if(substr($peer_id, 0, 2) == "DE") err("BANNED  client. You need to change your client with one in the ACCEPTED list.");
if(substr($peer_id, 0, 6) == "DE054") err ("Out of date or BANNED  client version. You need to change your client with one in the ACCEPTED  list."); // == Deluge == //
if(substr($peer_id, 0, 6) == "DE057") err ("Out of date or BANNED  client version. You need to change your client with one in the ACCEPTED  list.");
if(substr($peer_id, 0, 7) == "DE0580") err ("Out of date or BANNED  client version. You need to change your client with one in the ACCEPTED  list.");
if(substr($peer_id, 0, 7) == "DE0581") err ("Out of date or BANNED  client version. You need to change your client with one in the ACCEPTED  list.");
if(substr($peer_id, 0, 7) == "DE0586") err ("Out of date or BANNED  client version. You need to change your client with one in the ACCEPTED  list.");
if(substr($peer_id, 0, 7) == "DE0587") err ("Out of date or BANNED  client version. You need to change your client with one in the ACCEPTED  list.");
if(substr($peer_id, 0, 7) == "DE1200") err ("Out of date or BANNED  client version. You need to change your client with one in the ACCEPTED  list.");
if(substr($peer_id, 0, 7) == "DE13F0") err ("Out of date or BANNED  client version. You need to change your client with one in the ACCEPTED  list."); // == Deluge == //
if(substr($peer_id, 0, 3) == "-TS") err("TorrentStorm is Banned.");
if(substr($peer_id, 0, 5) == "Mbrst") err("Burst! is Banned.");
if(substr($peer_id, 0, 3) == "-BB") err("BitBuddy is Banned.");
if(substr($peer_id, 0, 3) == "-SZ") err("Shareaza is Banned.");
if(substr($peer_id, 0, 5) == "turbo") err("TurboBT is banned.");
if(substr($peer_id, 0, 4) == "T03A") err("Please Update your BitTornado.");
if(substr($peer_id, 0, 4) == "T03B") err("Please Update your BitTornado.");
if(substr($peer_id, 0, 3 ) == "FRS") err("Rufus is Banned.");
if(substr($peer_id, 0, 2 ) == "eX") err("eXeem is Banned.");
if(substr($peer_id, 0, 8 ) == "-TR0005-") err("Transmission/0.5 is Banned.");
if(substr($peer_id, 0, 8 ) == "-TR0006-") err("Transmission/0.6 is Banned.");
if(substr($peer_id, 0, 8 ) == "-XX0025-") err("Transmission/0.6 is Banned.");
if(substr($peer_id, 0, 1 ) == ",") err ("RAZA is banned.");
if(substr($peer_id, 0, 3 ) == "-AG") err("This is a banned client. We recommend uTorrent or Azureus.");
if(substr($peer_id, 0, 3 ) == "R34") err("BTuga/Revolution-3.4 is not an acceptalbe client. Please read the FAQ on recommended clients.");
if(substr($peer_id, 0, 4) == "exbc") err("This version of BitComet is banned! You can thank DHT for this ban!");
if(substr($peer_id, 0, 3) == '-FG') err("FlashGet is banned!");
////////////////////////////////////
dbconn();$cache = new Memcache();$cache->connect('127.0.0.1', 11211); // IP вашего сервера и порт Мемкеша
$user = array();if(!$user = $cache->get('user_passkey_'.$passkey)){
$res = mysql_query('SELECT id, enabled, parked, class, passkey_ip, warned FROM users WHERE passkey = '.sqlesc($passkey).' ORDER BY last_access DESC LIMIT 1') or err('USER Stats error (select)');
$user = mysql_fetch_array($res);$cache->set('user_passkey_'.$passkey, $user, MEMCACHE_COMPRESSED, 1800);}
if(!$user) err('Unknown passkey. Please redownload the torrent from '.$BASEURL.' - READ THE FAQ!');
if($user['enabled'] == 'no') err('This account is disabled.');if($user['announce'] == 'no') err('You have disabled downloading and uploading torrents!');
if($user['warned'] == 'yes') err('You cant download anything because you profile was warned. Any questions ask Admins or Directors.');
if($user['parked'] == 'yes') err('Error, your account is parked!');if($user['passkey_ip'] != '' && getip() != $user['passkey_ip']) err('Unauthorized IP for this passkey!');
$userid = $user['id'];$hash = bin2hex($info_hash);$torrent = array();if(!$torrent = $cache->get('torrent_infohash_'.$hash)){
$res = mysql_query('SELECT id, visible, banned, free, seeders AS seederrs, leechers AS leecherrs, seeders + leechers AS numpeers, UNIX_TIMESTAMP(added) AS ts FROM torrents 
WHERE IF(info_hash = '.sqlesc($hash).', info_hash = '.sqlesc($hash).', info_hashs = '.sqlesc($hash).')') or err('Torrents error 1 (select)');
$torrent = mysql_fetch_array($res);$cache->set('torrent_infohash_'.$hash, $torrent, MEMCACHE_COMPRESSED, 300);}
//////////////////////////////
if(!$torrent) err('Torrent not registered with this tracker.');if($torrent["banned"] == "yes") err('Torrent banned with this tracker.');$torrentid = $torrent['id'];
$fields = 'seeder, peer_id, ip, port, uploaded, downloaded, userid, last_action, UNIX_TIMESTAMP(NOW()) AS nowts, UNIX_TIMESTAMP(prev_action) AS prevts';
$numpeers = $torrent['numpeers'];$limit = '';if($numpeers > $rsize) $limit = 'ORDER BY RAND() LIMIT '.$rsize;
$res = mysql_query('SELECT '.$fields.' FROM peers WHERE torrent = '.sqlesc($torrentid).' '.$limit) or err('Peers error 1 (select)');
$resp = 'd'.benc_str('interval').'i'.$announce_interval.'e'.benc_str('peers').(($compact = ($_GET['compact'] == 1)) ? '' : 'l');
$no_peer_id = ($_GET['no_peer_id'] == 1);unset($self);
while($row = mysql_fetch_array($res)){if($row['peer_id'] == $peer_id){$userid = $row['userid'];$self = $row;continue;}
if($compact){$peer_ip = explode('.', $row["ip"]);$plist .= pack("C*", $peer_ip[0], $peer_ip[1], $peer_ip[2], $peer_ip[3]).pack("n*", (int) $row["port"]);}else{
$resp .= 'd'.benc_str('ip').benc_str($row['ip']).(!$no_peer_id ? benc_str("peer id").benc_str($row["peer_id"]) : '').benc_str('port').'i'.$row['port'].'e'.'e';}}
$resp .= ($compact ? benc_str($plist) : '').(substr($peer_id, 0, 4) == '-BC0' ? "e7:privatei1ee" : "ee");
$selfwhere = 'torrent = '.sqlesc($torrentid).' AND peer_id = '.sqlesc($peer_id);
if(!isset($self)){$res = mysql_query('SELECT '.$fields.' FROM peers WHERE '.$selfwhere) or err('Peers error 2 (select)');
$row = mysql_fetch_array($res);if($row){$userid = $row['userid'];$self = $row;}}
$announce_wait = 10;$dt = sqlesc(date('Y-m-d H:i:s', time()));$updateset = array();$snatch_updateset = array();
if(isset($self) && ($self['prevts'] > ($self['nowts'] - $announce_wait ))) err('There is a minimum announce time of '.$announce_wait.' seconds');
if(!isset($self)){
/////запрет качать определенному классу больше торрентов чем указанно - НАЧАЛО////////
$user_seed = mysql_query("SELECT id FROM peers WHERE userid=".$userid." AND seeder = 'no'") or err("Tracker error. Error 911. Report to Sysop");
$total_torrents=mysql_num_rows($user_seed);if($seeder=="no"){if($user['class'] == 0 && $total_torrents >= 1) err('You can download maximum 1 torrents');
if($user['class'] == 1 && $total_torrents >= 5) err('You can download maximum 5 torrents');
if($user['class'] == 2 && $total_torrents >= 15) err('You can download maximum 15 torrents');
if($user['class'] == 3 && $total_torrents >= 25) err('You can download maximum 25 torrents');
if($user['class'] == 4 && $total_torrents >= 50) err('You can download maximum 50 torrents');
if($user['class'] == 5 && $total_torrents >= 100) err('You can download maximum 100 torrents');}
/////запрет качать определенному классу больше торрентов чем указанно - КОНЕЦ//////// 
if(portblacklisted($port)) err('Port '.$port.' is blacklisted.');
else{$sockres = check_port($ip, $port, 5);if(!$sockres){$connectable = 'no';
if($nc == 'yes') err('Your client is not connectable! Check your Port-configuration or search on forums.');}else{$connectable = 'yes';@fclose($sockres);}}
$res = mysql_query('SELECT torrent, userid FROM snatched WHERE torrent = '.sqlesc($torrentid).' AND userid = '.sqlesc($userid)) or err(mysql_error());
$check = mysql_fetch_array($res);if(!$check){
////// включил в раздачу торрент-клиент, если такого торрента юзер не брал, то вписываем на него ////////////
mysql_query("INSERT LOW_PRIORITY INTO snatched (torrent, userid, port, startdat, started, seeder, last_action) 
VALUES (".sqlesc($torrentid).", ".sqlesc($userid).", ".sqlesc($port).", ".sqlesc(get_date_time()).", ".sqlesc(get_date_time()).", 
".sqlesc($seeder).", ".sqlesc(get_date_time()).")");if($seeder=="yes"){
$usr_seeder = mysql_query("SELECT id FROM peers WHERE userid=".sqlesc($userid)." AND seeder = 'yes'") or err("Tracker error. Error 911. Report to Sysop");
$usr_torrents=mysql_num_rows($usr_seeder);$usr_torr = $usr_torrents + 1;
mysql_query('UPDATE LOW_PRIORITY users SET seeder = '.sqlesc($usr_torr).' WHERE id = '.sqlesc($userid)) or err('Users error 01 (update)');
mysql_query('UPDATE LOW_PRIORITY tags SET seeders = seeders + 1 WHERE id = '.sqlesc($torrentid)) or err('Tags error 01 (update)');
}else{
$usr_leecher = mysql_query("SELECT id FROM peers WHERE userid=".sqlesc($userid)." AND seeder = 'no'") or err("Tracker error. Error 911. Report to Sysop");
$usr_torrentsl=mysql_num_rows($usr_leecher);$usr_torrl = $usr_torrentsl + 1;
mysql_query('UPDATE LOW_PRIORITY users SET leecher = '.sqlesc($usr_torrl).' WHERE id = '.sqlesc($userid)) or err('Users error 02 (update)');
}}else{
////// включил в раздачу торрент-клиент, если такой торрент юзер уже брал, то обновляем данные с времени включения ////////////
mysql_query("UPDATE LOW_PRIORITY snatched SET port = ".sqlesc($port).", started = ".sqlesc(get_date_time()).", seeder = ".sqlesc($seeder).", 
last_action = ".sqlesc(get_date_time())." WHERE torrent = ".sqlesc($torrentid)." AND userid = ".sqlesc($userid)) or err('Snatched error 01 (update)');
if($seeder=="yes"){
$usrs_seeder = mysql_query("SELECT id FROM peers WHERE userid=".sqlesc($userid)." AND seeder = 'yes'") or err("Tracker error. Error 911. Report to Sysop");
$usrs_torrents=mysql_num_rows($usrs_seeder);$usrs_torr = $usrs_torrents + 1;
mysql_query('UPDATE LOW_PRIORITY users SET seeder = '.sqlesc($usrs_torr).' WHERE id = '.sqlesc($userid)) or err('Users error 03 (update)');}else{
$usrs_leecher = mysql_query("SELECT id FROM peers WHERE userid=".sqlesc($userid)." AND seeder = 'no'") or err("Tracker error. Error 911. Report to Sysop");
$usrs_torrentsl=mysql_num_rows($usrs_leecher);$usrs_torrl = $usrs_torrentsl + 1;
mysql_query('UPDATE LOW_PRIORITY users SET leecher = '.sqlesc($usrs_torrl).' WHERE id = '.sqlesc($userid)) or err('Users error 04 (update)');}}
////// включил в раздачу торрент-клиент, если такого торрента юзер не брал, то вписываем на него в пиры ////////////
$ret = mysql_query("INSERT LOW_PRIORITY INTO peers (connectable, torrent, peer_id, ip, port, uploaded, downloaded, to_go, started, last_action, seeder, 
userid, agent, uploadoffset, downloadoffset, passkey) VALUES (".sqlesc($connectable).", ".sqlesc($torrentid).", ".sqlesc($peer_id).", ".sqlesc($ip).", 
".sqlesc($port).", ".sqlesc($uploaded).", ".sqlesc($downloaded).", ".sqlesc($left).", ".sqlesc(get_date_time()).", ".sqlesc(get_date_time()).", 
".sqlesc($seeder).", ".sqlesc($userid).", ".sqlesc($agent).", ".sqlesc($uploaded).", ".sqlesc($downloaded).", ".sqlesc($passkey).")") or err('Peers error 4 (insert)');
//////////////////////////////////////////////////////////////
if($ret){if($seeder == 'yes'){$updateset[] = 'seeders = seeders + 1';$snatch_updateset[] = "seeder = 'yes'";$snatch_updateset[] = "last_action = ".sqlesc(get_date_time());
}else{$updateset[] = 'leechers = leechers + 1';$snatch_updateset[] = "seeder = 'no'";}}}else{
/////////////////////
$chiters = mysql_query("SELECT id FROM peers WHERE torrent=".sqlesc($torrentid)) or err("Tracker error. Chiters. Report to Sysop");if(mysql_num_rows($chiters) > 1){
///////////////////////////////////////////////////
$reds = mysql_query("SELECT value FROM freeleech WHERE name = 'freeleech'") or die(mysql_error());$rowd = mysql_fetch_array($reds);
$upthis = max(0, $uploaded - $self['uploaded']);$downthis = max(0, $downloaded - $self['downloaded']);$upthisf = round($upthis * 2);
switch($torrent['free']){case 'bril': $upthist = round($upthis * 2);$downthist = 0;break;
case 'yes': $upthist = max(0, $uploaded - $self['uploaded']);$downthist = 0;break;
case 'silver': $upthist = max(0, $uploaded - $self['uploaded']);$downthist = round($downthis / 2);break;
case 'no': $upthist = max(0, $uploaded - $self['uploaded']);$downthist = max(0, $downloaded - $self['downloaded']);break;}
if($torrent['leecherrs'] > 0 AND $torrent['seederrs'] > 0 && $torrent['seederrs'] < 4){$upthisr = round($upthist * 2);}else{$upthisr = $upthist;}$downthisr = $downthist;
/////////////////////////////
if($upthis > 0 || $downthis >= 0){
if($torrent['leecherrs'] > 0 AND $torrent['seederrs'] > 0 && $torrent['seederrs'] < 4){$upthisfs = round($upthisf * 2);$upthiss = round($upthis * 2);}else{$upthisfs = $upthisf;$upthiss = $upthis;}	
if($rowd['value'] == 'brill'){mysql_query('UPDATE LOW_PRIORITY users SET uploaded = uploaded + '.$upthisfs.' WHERE id='.sqlesc($userid)) or err('Users error 2 (update)');}
elseif($rowd['value'] == 'gold'){mysql_query('UPDATE LOW_PRIORITY users SET uploaded = uploaded + '.$upthiss.' WHERE id='.sqlesc($userid)) or err('Users error 2 (update)');}
elseif($rowd['value'] == 'no'){
////////// IF user VIP to ne uchitivaem skachku ON /////////////////	
if($user['class'] == 7){sql_query('UPDATE LOW_PRIORITY users SET uploaded = uploaded + '.$upthisr.' WHERE id='.sqlesc($userid)) or err('Users error 2 (update)');}else{
sql_query('UPDATE LOW_PRIORITY users SET uploaded = uploaded + '.$upthisr.', downloaded = downloaded + '.$downthisr.' WHERE id='.sqlesc($userid)) or err('Users error 2 (update)');}
////////// IF user VIP to ne uchitivaem skachku OFF /////////////////
}}$downloaded2 = max(0, $downloaded - $self['downloaded']);$uploaded2 = max(0, $upthisr - $self['uploaded']);if($downloaded2 > 0 || $uploaded2 > 0){
$snatch_updateset[] = "uploaded = uploaded + ".$uploaded2;$snatch_updateset[] = "downloaded = downloaded + ".$downloaded2;$snatch_updateset[] = "to_go = ".sqlesc($left);}}
/////////////////////
$snatch_updateset[] = "port = ".sqlesc($port);$snatch_updateset[] = "last_action = ".sqlesc(get_date_time());
/////////////////////////////////////
if(mysql_num_rows($chiters) > 1){
mysql_query("UPDATE LOW_PRIORITY peers SET uploaded = ".sqlesc($uploaded).", downloaded = ".sqlesc($downloaded).", uploadoffset = ".sqlesc($uploaded2).", 
downloadoffset = ".sqlesc($downloaded2).", to_go = ".sqlesc($left).", last_action = ".sqlesc(get_date_time()).", prev_action = ".sqlesc($self['last_action']).", 
seeder = ".sqlesc($seeder)." ".($seeder == "yes" && $self["seeder"] <> $seeder ? ", finishedat = ".sqlesc(get_date_time()): "").", 
agent = ".sqlesc($agent)." WHERE ".$selfwhere) or err('Peers error 3 (update)');}elseif(mysql_num_rows($chiters) == 1){
mysql_query("UPDATE LOW_PRIORITY peers SET last_action = ".sqlesc(get_date_time()).", prev_action = ".sqlesc($self['last_action']).", 
seeder = ".sqlesc($seeder)." ".($seeder == "yes" && $self["seeder"] <> $seeder ? ", finishedat = ".sqlesc(get_date_time()): "").", 
agent = ".sqlesc($agent)." WHERE ".$selfwhere) or err('Peers error 3 (update)');}
/////////////////
if(mysql_affected_rows() && $self['seeder'] != $seeder){
if($seeder == 'yes'){$updateset[] = 'seeders = seeders + 1';$updateset[] = 'leechers = IF(leechers > 0, leechers - 1, 0)';
}else{$updateset[] = 'leechers = leechers + 1';$updateset[] = 'seeders = IF(seeders > 0, seeders - 1, 0)';}}
///////////////////
if($event == 'stopped'){if(mysql_affected_rows()){if($self['seeder'] == 'yes'){
$user_seeder = mysql_query("SELECT id FROM peers WHERE userid=".sqlesc($userid)." AND seeder = 'yes'") or err("Tracker error. Error 911. Report to Sysop");
$user_torrents=mysql_num_rows($user_seeder);if($user_torrents >=1){$user_torr = $user_torrents - 1;}
mysql_query('UPDATE LOW_PRIORITY users SET seeder = '.sqlesc($user_torr).' WHERE id = '.sqlesc($userid)) or err('Users error 05 (update)');
$updateset[] = 'seeders = IF(seeders > 0, seeders - 1, 0)';$updatetags[] = 'seeders = IF(seeders > 0, seeders - 1, 0)';
}else{
$user_leecher = mysql_query("SELECT id FROM peers WHERE userid=".sqlesc($userid)." AND seeder = 'no'") or err("Tracker error. Error 911. Report to Sysop");
$user_torrentsl=mysql_num_rows($user_leecher);if($user_torrentsl >=1){$user_torrl = $user_torrentsl - 1;}	
mysql_query('UPDATE LOW_PRIORITY users SET leecher = '.sqlesc($user_torrl).' WHERE id = '.sqlesc($userid)) or err('Users error 06 (update)');
$updateset[] = 'leechers = IF(leechers > 0, leechers - 1, 0)';}}
//////////// форс-мажор или просто выключили раздачу, но время сидирования до выключения учитываем //////////////////
$seedys = mysql_query('SELECT UNIX_TIMESTAMP() - UNIX_TIMESTAMP(snatched.last_action) AS last_action, 
UNIX_TIMESTAMP(snatched.started) AS st FROM snatched WHERE torrent = '.sqlesc($torrentid).' AND userid = '.sqlesc($userid)) or err(mysql_error());
$seedy = mysql_fetch_array($seedys);if($seedy['st'] > 0){$hours_seed = $seedy['last_action'];}else{$hours_seed = "0";}
////////////////////////////////////////////////
if(mysql_num_rows($chiters) > 1){
mysql_query('UPDATE LOW_PRIORITY snatched SET seeder = "no", seed_time = seed_time + '.sqlesc($hours_seed).', connectable = "no", last_action = NOW(),
started = NOW(), uploaded = uploaded + '.sqlesc($uploaded2).', downloaded = downloaded + '.sqlesc($downloaded2).', 
to_go = '.sqlesc($left).' WHERE torrent = '.sqlesc($torrentid).' AND userid = '.sqlesc($userid)) or err('Snatched error 1 (stopped seed)');
}elseif(mysql_num_rows($chiters) == 1){
mysql_query('UPDATE LOW_PRIORITY snatched SET seeder = "no", seed_time = seed_time + '.sqlesc($hours_seed).', connectable = "no", last_action = NOW(),
started = NOW() WHERE torrent = '.sqlesc($torrentid).' AND userid = '.sqlesc($userid)) or err('Snatched error 1.2 (stopped chiters seed)');}
mysql_query('DELETE FROM peers WHERE '.$selfwhere);}}
if($event == 'completed'){$snatch_updateset[] = "finished = 'yes'";$snatch_updateset[] = "completedat = ".sqlesc(get_date_time());$snatch_updateset[] = "seeder = 'yes'";
$updateset[] = 'times_completed = times_completed + 1';$users_updateset[] = 'leecher = IF(leecher > 0, leecher - 1, 0)';$users_updateset[] = 'seeder = seeder + 1';
$updatetags[] = 'seeders = seeders + 1';}
if($seeder == 'yes'){if($torrent['banned'] != 'yes' && $torrent['visible'] != 'yes') $updateset[] = "visible = 'yes'";$updateset[] = 'last_action = '.sqlesc(get_date_time());}
/////////////////////////////////////////////////////////////////
if(count($updateset)) mysql_query('UPDATE LOW_PRIORITY torrents SET '.join(", ", $updateset).' WHERE id = '.sqlesc($torrentid)) or err('Torrents error 2 (update)');
if(count($updatetags)) mysql_query('UPDATE LOW_PRIORITY tags SET '.join(", ", $updatetags).' WHERE id = '.sqlesc($torrentid)) or err('Tags error update');
if(count($users_updateset)) mysql_query('UPDATE LOW_PRIORITY users SET '.join(", ", $users_updateset).' WHERE id = '.sqlesc($userid)) or err('Users error 07 (update)');
if(count($snatch_updateset)){
///////////// обновление времени сидирования если юзер сидирует релиз /////////////////
$seedys = mysql_query('SELECT UNIX_TIMESTAMP() - UNIX_TIMESTAMP(snatched.last_action) AS last_action,
UNIX_TIMESTAMP(snatched.started) AS st FROM snatched WHERE torrent = '.sqlesc($torrentid).' AND userid = '.sqlesc($userid)) or err(mysql_error());
$seedy = mysql_fetch_array($seedys);if($seedy['st'] > 0){$hours_seed = $seedy['last_action'];}else{$hours_seed = "0";}
//////////////////////////////////////
mysql_query('UPDATE LOW_PRIORITY snatched SET seed_time = seed_time + '.sqlesc($hours_seed).', started = NOW(), '.join(", ", $snatch_updateset).' 
WHERE torrent = '.sqlesc($torrentid).' AND userid = '.sqlesc($userid)) or err('Snatched error 2 (update seed_time)');}benc_resp_raw($resp);?>
