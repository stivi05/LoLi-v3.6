<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){global $rootpath;
if($_SERVER["REQUEST_METHOD"] == "POST"){if(empty($_POST["bonus_id"])){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>Вы не выбрали тип бонуса!</center><html><head><meta http-equiv=refresh content='4;url=mybonus.php'></head></html>");die();}
$id = (int) $_POST["bonus_id"];if(!is_valid_id($id)){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>".$tracker_lang['access_denied']."</center><html><head><meta http-equiv=refresh content='4;url=/'></head></html>");die();}
$ref = sql_query("SELECT username, class, downloaded FROM users WHERE id = ".$CURUSER['id']) or sqlerr(__FILE__,__LINE__);
$rer = mysql_fetch_array($ref);$names = $rer["username"];$class = $rer["class"];$downloaded = $rer["downloaded"];
$res = sql_query("SELECT * FROM bonus WHERE id = $id") or sqlerr(__FILE__,__LINE__);$arr = mysql_fetch_array($res);$points = $arr["points"];$type = $arr["type"];
if($CURUSER["bonus"] < $points){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>У вас недостаточно бонусов!</center><html><head><meta http-equiv=refresh content='4;url=user_".$CURUSER['id']."'></head></html>");
die();}
switch($type){case "traffic": $traffic = $arr["quanity"];
if(!mysql_query("UPDATE users SET bonus = bonus - $points, uploaded = uploaded + $traffic WHERE id = ".sqlesc($CURUSER["id"]))){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>Не могу обновить бонус!</center><html><head><meta http-equiv=refresh content='4;url=mybonus.php'></head></html>");die();}
stdmsg("<center>".$tracker_lang['success']."</center>", "<center>Бонус обменян на траффик!</center><html><head><meta http-equiv=refresh content='4;url=user_".$CURUSER['id']."'></head></html>");
$flist = $rootpath."include/user_cache/user_".$CURUSER["id"].".cache";if(file_exists($flist)){unlink($flist);}break;
case "traffics": if($downloaded <= 10737418240){
stdmsg($tracker_lang['error'], "Меньше 10GB Downloaded сбрасывать запрещено!<html><head><meta http-equiv=refresh content='4;url=user_".$CURUSER['id']."'></head></html>", 'error');die();}
$traffics = $arr["quanity"];if(!mysql_query("UPDATE users SET bonus = bonus - $points, downloaded = downloaded - $traffics WHERE id = ".sqlesc($CURUSER["id"]))){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>Не могу обновить бонус!</center><html><head><meta http-equiv=refresh content='4;url=mybonus.php'></head></html>");die();}
stdmsg("<center>".$tracker_lang['success']."</center>", "<center>Бонус обменян на траффик!</center><html><head><meta http-equiv=refresh content='4;url=user_".$CURUSER['id']."'></head></html>");
$flist = $rootpath."include/user_cache/user_".$CURUSER["id"].".cache";if(file_exists($flist)){unlink($flist);}break;
case "trafficp": $trafficp = $arr["quanity"];
if(!mysql_query("UPDATE users SET bonus = bonus - $points, downloaded = downloaded + $trafficp WHERE id = ".sqlesc($CURUSER["id"]))){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>Не могу обновить бонус!</center><html><head><meta http-equiv=refresh content='4;url=mybonus.php'></head></html>");die();}
stdmsg("<center>".$tracker_lang['success']."</center>", "<center>Бонус обменян на траффик!</center><html><head><meta http-equiv=refresh content='4;url=user_".$CURUSER['id']."'></head></html>");
$flist = $rootpath."include/user_cache/user_".$CURUSER["id"].".cache";if(file_exists($flist)){unlink($flist);}break;
case "vip": if(get_user_class() >= UC_VIP){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>Вам что бонусы некуда девать!?</center><html><head><meta http-equiv=refresh content='4;url=mybonus.php'></head></html>", 'error');
die();}
$days = $arr["quanity"];$vipuntil = get_date_time(TIMENOW + $days * 86400);
if(!mysql_query("UPDATE users SET bonus = bonus - $points, class = ".UC_VIP.", oldclass = ".$CURUSER["class"].", vipuntil = ".sqlesc($vipuntil)." WHERE id = ".sqlesc($CURUSER["id"]))){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>Не могу обновить бонус!</center><html><head><meta http-equiv=refresh content='4;url=mybonus.php'></head></html>", 'error');die();}
stdmsg($tracker_lang['success'], "Бонус обменян на статус VIP.<br />Действие вашего статуса заканчивается: $vipuntil");
$flist = $rootpath."include/user_cache/user_".$CURUSER["id"].".cache";if(file_exists($flist)){unlink($flist);}break;
case "upl": if(get_user_class() >= UC_UPLOADER){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>Вам что бонусы некуда девать!?</center><html><head><meta http-equiv=refresh content='4;url=mybonus.php'></head></html>", 'error');
die();}
$days = $arr["quanity"];$upluntil = get_date_time(TIMENOW + $days * 86400);
if(!mysql_query("UPDATE users SET bonus = bonus - $points, class = ".UC_UPLOADER.", oldclass = ".$CURUSER["class"].", upluntil = ".sqlesc($upluntil)." WHERE id = ".sqlesc($CURUSER["id"]))){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>Не могу обновить бонус!</center><html><head><meta http-equiv=refresh content='4;url=mybonus.php'></head></html>", 'error');die();}
stdmsg($tracker_lang['success'], "Бонус обменян на статус UPLOADER.<br />Действие вашего статуса заканчивается: $upluntil");
$flist = $rootpath."include/user_cache/user_".$CURUSER["id"].".cache";if(file_exists($flist)){unlink($flist);}break;
case "adm": if(get_user_class() >= UC_ADMINISTRATOR){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>Вам что бонусы некуда девать!?</center><html><head><meta http-equiv=refresh content='4;url=mybonus.php'></head></html>", 'error');
die();}
$days = $arr["quanity"];$admuntil = get_date_time(TIMENOW + $days * 86400);
if(!mysql_query("UPDATE users SET bonus = bonus - $points, class = ".UC_ADMINISTRATOR.", oldclass = ".$CURUSER["class"].", admuntil = ".sqlesc($admuntil)." WHERE id = ".sqlesc($CURUSER["id"]))){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>Не могу обновить бонус!</center><html><head><meta http-equiv=refresh content='4;url=mybonus.php'></head></html>", 'error');die();}
stdmsg($tracker_lang['success'], "Бонус обменян на статус UC_ADMINISTRATOR.<br />Действие вашего статуса заканчивается: $admuntil");
$flist = $rootpath."include/user_cache/user_".$CURUSER["id"].".cache";if(file_exists($flist)){unlink($flist);}break;
default: stdmsg("<center>".$tracker_lang['error']."</center>", "<center>Unknown bonus type!</center><html><head><meta http-equiv=refresh content='4;url=mybonus.php'></head></html>");
}}else{stdhead($tracker_lang['my_bonus']);
begin_frame(".:: ".$tracker_lang['my_bonus']." :: <font color=\"darkgreen\" size=4>На вашем счету <font color=red><b>".$CURUSER['bonus']."</b></font>&nbsp;бонусов</font> ::.");?><script src="js/ajax.js"></script><script>
function send(){for(var e=document.mybonus,n="",a=0;a<e.elements.length;a++){var t=e.elements[a];if("radio"==t.type&&1==t.checked){n=t.value;break}}var o=new tbdev_ajax;o.onShow("");o.requestFile="mybonus.php",o.setVar("bonus_id",n),o.method="POST",o.element="ajax",o.sendAJAX("")}
</script>
<div id="loading-layer" style="display:none;font-family: Verdana;font-size: 11px;width:200px;height:50px;background:#FFF;padding:10px;text-align:center;border:1px solid #000">
<div style="font-weight:bold" id="loading-layer-text"><?=$tracker_lang['ajax_loading'];?></div><br /><img src="pic/loading.gif" border="0" /></div><div id="ajax">
<?print("<table width=100% cellspacing=\"1\" cellpadding=4 class=\"coltable\">");$my_points = $CURUSER["bonus"];
$res = sql_query("SELECT * FROM bonus");while($arr = mysql_fetch_assoc($res)){$id = $arr["id"];$bonus = $arr["name"];
$points = $arr["points"];$descr = $arr["description"];$color = 'green';if($CURUSER['bonus'] < $points) $color = 'red';
$output .= "<tr><td><center><b>$bonus</b> ($descr)</center></td><td><center><b>$points</b> (у Вас <font color=green><b>$my_points</b></font>)</center></td>
<td><center><input type=\"radio\" name=\"bonus_id\" value=\"$id\"".($color == 'red' ? ' disabled' : '')." /></center></td></tr>\n";}
$points_per_hour = 0.1; // За торренты до 500Mb 
$points_per_hour2 = 0.5; // За торренты от 500Mb и менее 1Gb 
$points_per_hour3 = 1.0; // За торренты более 1Gb // 1 гигабайт=1024 мегабайт =1 048 576 килобайт=1073741824 байт
$points_per_hour4 = 2.0; // За торренты более 10Gb
$points_per_hour5 = 6.0; // За торренты более 50Gb
$points_per_hour6 = 10.0; // За торренты более 100Gb
$points_per_hour7 = 20.0; // За торренты более 200Gb
$points_per_hour8 = 30.0; // За торренты более 300Gb
$points_per_hour9 = 40.0; // За торренты более 400Gb
$bonus_print = "0"; 
$res = sql_query ( "SELECT COUNT( peers.id ) AS cont, torrents.size FROM peers LEFT JOIN torrents ON peers.torrent = torrents.id WHERE peers.seeder = 'yes' 
AND peers.userid = '".$CURUSER ["id"]."'");while($row = mysql_fetch_assoc($res )){ 
$cont = ($row["cont"] * $points_per_hour);$cont2 = ($row["cont"] * $points_per_hour2);$cont3 = ($row["cont"] * $points_per_hour3);$cont4 = ($row["cont"] * $points_per_hour4);
$cont5 = ($row["cont"] * $points_per_hour5);$cont6 = ($row["cont"] * $points_per_hour6);$cont7 = ($row["cont"] * $points_per_hour7);$cont8 = ($row["cont"] * $points_per_hour8);
$cont9 = ($row["cont"] * $points_per_hour9);if($row["size"] < 524288000) $bonus_print += round($cont, 2); 
elseif($row["size"] > 524288000 && $row["size"] < 1073741824) $bonus_print += round($cont2, 2);
elseif($row["size"] > 1073741824 && $row["size"] < 10737418240) $bonus_print += round($cont3, 2);
elseif($row["size"] > 10737418240 && $row["size"] < 53687091200) $bonus_print += round($cont4, 2);
elseif($row["size"] > 53687091200 && $row["size"] < 107374182400) $bonus_print += round($cont5, 2);
elseif($row["size"] > 107374182400 && $row["size"] < 214748364800) $bonus_print += round($cont6, 2);
elseif($row["size"] > 214748364800 && $row["size"] < 322122547200) $bonus_print += round($cont7, 2);	
elseif($row["size"] > 322122547200 && $row["size"] < 429496729600) $bonus_print += round( $cont8, 2);else $bonus_print += round($cont9, 2);}?> 
<tr><td class="colhead" colspan="9"><center>За каждый час сидирования, Вы получаете .:: <font color="#FF9900"><b><?=$bonus_print?></b></font> ::. бонус(ов)</center></td></tr>
<tr><td class="colhead"><center>Тип бонуса</center></td><td class="colhead"><center>Цена</center></td><td class="colhead"><center>Обменять</center></td></tr>
<form action="mybonus.php" name="mybonus" method="post"><?=$output;?><tr><td colspan="3" align="center"><input type="submit" onClick="send(); return false;" value="Обменять" /></td></tr></form>
<? print("<tr><td class=colhead colspan=20><center>Вы так-же можете <b>Подарить</b> свои ''кровные бонусы'', одному из пользователей. За перевод с вас снимут 10%. Если согласны, нажмите 
<a href=\"seedbonus\" alt=\"Подарить Бонусы\" title=\"Подарить Бонусы\"><b>СЮДА</b></a> для перехода на страницу перевода бонусов.</center></td></tr></table></div>");
end_frame();stdfoot();}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
