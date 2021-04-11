<? if (!defined('BLOCK_FILE')){header("Location: ../index.php");exit;}global $CacheBlock, $serverloadBlock_Refresh;
$blocktitle = ".:: Загрузка сервера ::.";$_cache = 'Blocks_serverload.cache'; 
if (!$CacheBlock->Check($_cache, $serverloadBlock_Refresh?0:36000)){ //10 chasov 
function get_server_load_b(){global $phpver;
if(strtolower(substr(PHP_OS, 0, 3)) === 'win'){return 0;}elseif(@file_exists("/proc/loadavg")){
$load = @file_get_contents("/proc/loadavg");$serverload = explode(" ", $load);$serverload[0] = round($serverload[0], 4);
if(!$serverload){$load = @exec("uptime");$load = @split("load averages?: ", $load);$serverload = explode(",", $load[1]);}}else{
$load = @exec("uptime");$load = @split("load averages?: ", $load);$serverload = explode(",", $load[1]);}
$returnload = trim($serverload[0]);return $returnload;}$now = time();$dttime = get_date_time();
$res = sql_query("SELECT arg, value_i, value_u FROM avps") or sqlerr(__FILE__,__LINE__);while($row = mysql_fetch_array($res)){
$arra[$row["arg"]]["value_u"]=$row["value_u"];$arra[$row["arg"]]["value_i"]=$row["value_i"];}
$peers = get_row_count("peers");if($arra["load_peers"]["value_i"] <= $peers){
mysql_query("UPDATE avps SET value_u = ".sqlesc($now).", value_i = ".sqlesc($peers).", value_s = ".sqlesc($dttime)." WHERE arg='load_peers'") or sqlerr(__FILE__,__LINE__);
if (mysql_modified_rows()==0)
mysql_query("INSERT INTO avps (arg, value_u, value_i, value_s) VALUES ('load_peers', ".sqlesc($now).", ".sqlesc($peers).",".sqlesc($dttime).")");
$toppeer = "<b>Max</b>: <b>".$peers."</b> в ".get_date_time($now)."";$arra["load_peers"]["value_i"] = $toppeer;}
elseif(!empty($arra["load_peers"]["value_i"])){
$toppeer = "Max: <b>".$arra["load_peers"]["value_i"]."</b> в ".get_date_time($arra["load_peers"]["value_u"])."";}
$connected = mysql_num_rows(sql_query("SELECT userid FROM peers WHERE userid>0 GROUP by userid"));
if($arra["load_connected"]["value_i"] <= $connected){
mysql_query("UPDATE avps SET value_u = ".sqlesc($now).", value_i = ".sqlesc($connected).", value_s = ".sqlesc($dttime)." WHERE arg='load_connected'") or sqlerr(__FILE__,__LINE__);
if(mysql_modified_rows()==0)
mysql_query("INSERT INTO avps (arg, value_u, value_i, value_s) VALUES ('load_connected', ".sqlesc($now).", ".sqlesc($connected).",".sqlesc($dttime).")");
$topconnected = "Max: <b>".$connected."</b> в ".get_date_time($now);}elseif(!empty($arra["load_connected"]["value_i"])){
$topconnected = "Max: <b>".$arra["load_connected"]["value_i"]."</b> в ".get_date_time($arra["load_connected"]["value_u"]);}
$connected_guest = mysql_num_rows(sql_query("SELECT userid FROM peers WHERE userid='0'"));
if($arra["load_guest"]["value_i"] < $connected_guest){
mysql_query("UPDATE avps SET value_u = ".sqlesc($now).", value_i = ".sqlesc($connected_guest).", value_s='$dttime' WHERE arg='load_guest'") or sqlerr(__FILE__,__LINE__);
if(mysql_modified_rows()==0)
mysql_query("INSERT INTO avps (arg, value_u,value_i,value_s) VALUES ('load_guest', ".sqlesc($now).", ".sqlesc($connected_guest).", ".sqlesc($dttime).")");
$topload_guest = "Max: <b>".$connected_guest."</b> в ".get_date_time($now);}elseif(!empty($arra["load_guest"]["value_i"])){
$topload_guest = "Max: <b>".$arra["load_guest"]["value_i"]."</b> в ".get_date_time($arra["load_guest"]["value_u"])."";}
$avgload = get_server_load_b();if(strtolower(substr(PHP_OS, 0, 3)) != 'win')$percent = $avgload;else $percent = $avgload;
if($percent <= 10) $pic = "loadbarbg.gif";elseif ($percent <= 50) $pic = "loadbargreen.gif";elseif ($percent <= 70) $pic = "loadbaryellow.gif";
else $pic = "loadbarred.gif";$width = $percent * 4;
$content.= "<table class=\"main\" border=\"0\" width=\"100%\"><tr>";
if(!empty($percent)){
$content.= "<td class=\"a\" align=\"center\" colspan=\"2\"><table border=\"0\" width=\"402\"><tr><td style=\"padding: 0px; background-repeat: repeat-x\">
<img height=\"15\" width=\"".$width."\" src=\"pic/".$pic."\" title=\"Нагрузка: ".$percent."%, Средняя (LA): ".$avgload."\"></td></tr></table>";
$content.= "<tr><td class=\"b\" align=\"center\" colspan=\"2\"><b>Нагрузка</b>: ".$percent."%, <b>Средняя</b> (LA): ".$avgload."</tr></td></td>";}
if(!empty($peers)){$fix_bug = ($arra["load_peers"]["value_i"]/100);if($fix_bug > 1){$fix_peers = ($peers*100);}else{$fix_peers = $peers;}
$fix_peers_value = ($arra["load_peers"]["value_i"]);$fix_peers = $fix_peers_value;
if($fix_peers <= 10)$pic_ = "loadbarbg.gif";elseif($fix_peers <= 50)$pic_ = "loadbargreen.gif";
elseif($fix_peers <= 70)$pic_ = "loadbaryellow.gif";else $pic_ = "loadbarred.gif";$width_ = $fix_peers * 4;	
$content.= "<td class=\"a\" align=\"center\" colspan=\"2\"><table border=\"0\" width=\"400\"><tr>
<td style=\"padding: 0px; background-repeat: repeat-x\" title=\"Нагрузка сервера по количеству соединений относительно предельных (max зафиксированных) подключений.\">
<img height=\"15\" width=\"".$width_."\" src=\"pic/".$pic_."\"></td></tr></table></td>";}
$maxpeernow = ($connected+$connected_guest);
$content.= "<tr><td class=\"b\" align=\"center\">Общее количество подключений</td><td class=\"a\" align=\"center\">";
$content.= (!empty($peers) ? "<b>".$peers."</b>":"<i>не зафиксировано</i>")." ".(!empty($maxpeernow) ? "(".$maxpeernow." сидов)":"")."<br>".$toppeer;
$content.= "</td></tr><tr><td class=\"a\" align=\"center\">Всего подключено уникальных пользователей</td><td class=\"b\" align=\"center\">";
$content.= (!empty($connected) ? "<b>".$connected."</b>":"<i>не зафиксировано</i>")." <br>".$topconnected."</td></tr>";
$session_all = get_row_count("sessions", "WHERE time >= ".sqlesc(get_date_time(gmtime() - 600)));
$session_now = get_row_count("sessions", "WHERE time >= ".sqlesc(get_date_time(gmtime() - 300)));
if(!empty($session_now)){$fix_bug = ($session_all/100);if($fix_bug > 1){$fix_sessions = ($session_now*100);}else{$fix_sessions = $session_now;}
$fix_sessions = $fix_sessions/$session_all;if($fix_sessions <= 10)$pic_2 = "loadbarbg.gif";elseif($fix_sessions <= 50)$pic_2 = "loadbargreen.gif";
elseif($fix_sessions <= 70)$pic_2 = "loadbaryellow.gif";else $pic_2 = "loadbarred.gif";$width_2 = $fix_sessions * 4;	
$content.= "<td class=\"a\" align=\"center\" colspan=\"2\"><table border=\"0\" width=\"400\"><tr>
<td style=\"padding: 0px; background-repeat: repeat-x\" title=\"Плотность Использования сессий в течении 5 мин по отношению к 10 мин.\">
<img height=\"15\" width=\"".$width_2."\" src=\"pic/".$pic_2."\"></td></tr></table></td>";}
$content.= "</tr></table>";$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>