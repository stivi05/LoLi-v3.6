<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){parked();$id = (isset($_GET["id"]) ? intval($_GET["id"]):0);
if(!is_valid_id($id) || empty($id))stderr2("Ошибка", "<center>Релиза с таким ID не существует или ID указан не верно!</center><html><head><meta http-equiv=refresh content='3;url=/'></head></html>");
$res = sql_query("SELECT t.*, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(t.last_action) AS lastseed, c.name AS cat_name, u.username, bookmarks.id AS bid, bookmarks.userid, 
bookmarks.torrentid FROM torrents AS t LEFT JOIN users AS u ON t.owner = u.id LEFT JOIN bookmarks ON t.id = bookmarks.torrentid AND bookmarks.userid='".$CURUSER['id']."' 
LEFT JOIN categories AS c ON t.category = c.id WHERE t.id = $id") or sqlerr(__FILE__, __LINE__);$row = mysql_fetch_array($res);
if(!$row['id'])stderr2("Ошибка", "<center>Релиза с таким ID не существует!</center><html><head><meta http-equiv=refresh content='3;url=/'></head></html>");
////////////////Авто-обновление Мультитрекера (BETA)///////////////////
if(strtotime($row['last_mt_update']) < (TIMENOW - 3600) && $row['multitracker'] == 'yes'){
header("Location: $DEFAULTBASEURL/update_multi.php?id=$id");}
////////////////Авто-обновление Мультитрекера (BETA)///////////////////
$keywords = $row['keywords'];$description = $row['description'];
if(isset($_GET["hit"])){mysql_query("UPDATE torrents SET views = views + 1 WHERE id = $id");
if(isset($_GET["tocomm"]))header("Location: $DEFAULTBASEURL/details_$id&page=0#startcomments");
elseif(isset($_GET["filelist"]))header("Location: $DEFAULTBASEURL/details_$id&filelist=1#filelist");
elseif(isset($_GET["toseeders"]))header("Location: $DEFAULTBASEURL/details_$id&dllist=1#seeders");
elseif(isset($_GET["todlers"]))header("Location: $DEFAULTBASEURL/details_$id&dllist=1#leechers");else header("Location: $DEFAULTBASEURL/details_$id");exit();}
///////////////////////////////////////////////////////////////////////////
if(!isset($_GET["page"])){stdhead($row["name"]);?><script src="js/bookmarks.js"></script><?$bookmarks .= '<span class="bmark">';
if($row['bid']){$bookmarks .= "<div id='bookmark_".$row['id']."'><img align='absbottom' src=\"pic/delbook.png\" border='0' alt='Уже в избранном. Удалить?' title='Уже в избранном. Удалить?' onclick=\"bookmark('$row[id]', 'del', 'details');\"/></div>";
}else{$bookmarks .= "<div id='bookmark_".$row['id']."'><img align='absbottom' src='pic/addbook.png' border='0' alt='Добавить в избранное?' title='Добавить в избранное?' onclick=\"bookmark('$row[id]', 'add', 'details');\"/></div>";}$bookmarks .= '</span>';
//////////////
if($row['multitracker'] == 'yes'){$announces_a = $announces_urls = array();
$announces_r = sql_query('SELECT url, seeders, leechers, last_update, state, error FROM torrents_scrape WHERE tid = '.$id);
while($announce = mysql_fetch_array($announces_r)){$announces_a[] = $announce;$announces_urls[] = $announce['url'];}unset($announce);}$s = "";
if(isset($_GET["returnto"])){$addthis = "&amp;returnto=".urlencode($_GET["returnto"]);$keepget .= $addthis;}$right_links = array();
$right_links[] = "<a class='but' href='download.php?id=".$id."'><b><img align='absbottom' src='pic/download0.png' alt='{$tracker_lang['download']}' title='{$tracker_lang['download']}'/></b></a>";
if ($row['multitracker'] == 'yes'){
$right_links[] = "&nbsp;&nbsp;<a href=\"".magnet(true, $row['info_hash'], $row['filename'], $row['size'], $announces_urls)."\"><img align='absbottom' src='pic/magnet.png' alt='{$tracker_lang['magnet']}' title='{$tracker_lang['magnet']}'/></a>";}
if(count($right_links)){$s .= '<span style="float: right;">'.implode('&nbsp;', $right_links).'</span>';}$s .= "";
?><table style='background:none;margin-top:7px;cellspacing:0;cellpadding:0;width:100%;float:center;'><tr>
<td style='border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td class='zaliwka' style='colspan:14;height:25px;;border:0;border-radius:5px;'>
<table style='background:none;width:100%;float:center;border:0;'><tr><?if($CURUSER["id"] == $row["owner"] || get_user_class() >= UC_MODERATOR){
print("<td style='background:none;border:0;width:50px;margin-left:30px;text-align:center;float:center;'>
<span class='badge-extra text-bold' align='absbottom'><a href='edit_$row[id]'>Редактировать</a></span></td>");}?>
<td style='background:none;font-family:tahoma;width:100%;font-size:14px;font-weight:bold;color:#FFFFFF;margin-left:10px;letter-spacing:0;text-align:center;float:left;border:0;'>
.:: <?=htmlspecialchars_uni($row["name"])?> ::.</td><td style='background:none;border:none;width:25px;'><?=$bookmarks;?></td>
<td style='background:none;border:none;width:50px;'><?=$s;?></td><td style='background:none;border:none;width:15px;margin-right:10px;'></td></tr>
</table></td></tr><tr><td align='left' style='background:none;width:100%;float:center;border:0;'>
<script src="js/highslide/highslide-full.js"></script><link rel="stylesheet" type="text/css" href="js/highslide/highslide.css">
<script>hs.graphicsDir = 'js/highslide/graphics/';hs.align = 'center';hs.transitions = ["fade"];hs.outlineType = 'rounded-white';hs.showCredits = false;hs.easing = 'linearTween';hs.fadeInOut = true;hs.wrapperClassName = 'controls-in-heading';hs.outlineWhileAnimating = true;hs.dimmingOpacity = 0.75;hs.numberPosition = "heading";hs.lang.number = "Изображение %1 из %2";if (hs.addSlideshow) hs.addSlideshow({interval: 5000, repeat: false, useControls: true, fixedControls: false, overlayOptions:{opacity: 1, position:'top right',}});
</script><script src="js/faq/jquery.js"></script><script src="js/faq/js_global.js"></script><link rel="stylesheet" type="text/css" href="css/faq.css"><?
////////////////////////////
print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">\n");
///////////////////////////
function hex_esc($matches){return sprintf("%02x", ord($matches[0]));}
$dt = sqlesc(time() - 200);$url="details_".$id; // впишите вашу страницу, куда вы хотите поместить этот скрипт
$res_s = mysql_query("SELECT DISTINCT uid, username, class FROM sessions WHERE uid<>-1 and time > $dt and url LIKE '%$url%' ORDER BY time DESC") or sqlerr(__FILE__,__LINE__);
$lastid=0;
while ($ar_r = mysql_fetch_assoc($res_s)){
$username = $ar_r['username'];$id_use = $ar_r['uid'];
if ($title_who_s)$title_who_s.=", ";
$title_who_s.= "<a href=\"user_$id_use\">".get_user_class_color($ar_r["class"], $ar_r["username"])."</a>";$lastid++;}
if ($lastid<>0){
tr('Сейчас на этой странице ('.$lastid.')', $title_who_s, 1);}
/////////////////////
	tr($tracker_lang['info_hash'], $row["info_hash"]);

	$descrs = "<div style='border:0;width:350px;float:right;'>
<a href=\"torrents/images/$row[image1]\" class=\"highslide\" onClick=\"return hs.expand(this)\">
<img border='0' align='right' width='300px' align='right' src='torrents/images/".$row['image1']."' /></a></div><br>".format_comment($row['descr']);
///////////////////////////////////
tr($tracker_lang['description'], $descrs, 1, 1);


	if ($row["visible"] == "no")
		tr($tracker_lang['visible'], "<b>{$tracker_lang['no']}</b> ({$tracker_lang['dead']})", 1);
	if ($moderator)
		tr($tracker_lang['banned'], ($row["banned"] == 'no' ? $tracker_lang['no'] : $tracker_lang['yes']) );

	if (isset($row["cat_name"]))
		tr($tracker_lang['type'], $row["cat_name"]);
	else
		tr($tracker_lang['type'], "({$tracker_lang['no_choose']})");

	tr($tracker_lang['seeder'], "{$tracker_lang['seeder_last_seen']} " . mkprettytime($row['lastseed']) . " {$tracker_lang['ago']}");
	tr($tracker_lang['size'], mksize($row['size']) . " (" . number_format($row['size']) . " {$tracker_lang['bytes']})");
	tr($tracker_lang['added'], $row["added"]);
	tr($tracker_lang['views'], $row["views"]);
	tr($tracker_lang['hits'], $row["hits"]);
	tr($tracker_lang['snatched'], $row["times_completed"] . " ".$tracker_lang['times']);
	

	$keepget = "";
	$uprow = (isset($row["username"]) ? ("<a href=user_{$row["owner"]}>" . htmlspecialchars_uni($row["username"]) . "</a>") : "<i>{$tracker_lang['details_anonymous']}</i>");

tr($tracker_lang['uploaded'], $uprow, 1);
///////////////////////
$FileList="<div id=\"GetFileList\"><a href=\"#\">Показать все</a></div><div></div>
<script>jQuery('#GetFileList > a').click(function(){var FilesContainer = $(this).parent().next();var obj = $(this);
if (!FilesContainer.html().length){obj.text('Loading...');jQuery.get('filelist.php',{'id':".$id."},function (responce){FilesContainer.html(responce);
obj.text('Свернуть все');},'html');}else{obj.text('Показать все');FilesContainer.html('');}return false;});</script>";
tr($tracker_lang['file_list'],$FileList, 1);
///////////////////////
if (!isset($_GET["dllist"])) {
	tr($tracker_lang['downloading']."<br /><a href=\"details_$id&amp;dllist=1$keepget#seeders\" class=\"sublink\">[{$tracker_lang['open_list']}]</a>", $row["seeders"] . " {$tracker_lang['seeders_l']}, {$row["leechers"]} {$tracker_lang['leechers_l']} = " . ($row["seeders"] + $row["leechers"]) . " ".$tracker_lang['peers_l'], 1);
} else {
	$downloaders = array();
	$seeders = array();
$subres = sql_query("SELECT peers.*, UNIX_TIMESTAMP(peers.started) AS st, UNIX_TIMESTAMP(peers.last_action) AS la, UNIX_TIMESTAMP(peers.prev_action) AS pa,
users.username, users.class FROM peers INNER JOIN users ON peers.userid = users.id WHERE peers.torrent = $id") or sqlerr(__FILE__, __LINE__);
	while ($subrow = mysql_fetch_array($subres)) {
		if ($subrow["seeder"] == "yes")
			$seeders[] = $subrow;
		else
			$downloaders[] = $subrow;
	}

	function leech_sort($a, $b) {
		if (isset($_GET["usort"]))
			return seed_sort($a, $b);
		$x = $a["to_go"];
		$y = $b["to_go"];
		if ($x == $y)
			return 0;
		if ($x < $y)
			return -1;
		return 1;
	}

	function seed_sort($a, $b) {
		$x = $a["uploaded"];
		$y = $b["uploaded"];
		if ($x == $y)
			return 0;
		if ($x < $y)
			return 1;
		return -1;
	}

	usort($seeders, "seed_sort");
	usort($downloaders, "leech_sort");

	tr("<a name=\"seeders\">{$tracker_lang['details_seeding']}</a><br /><a href=\"details_$id$keepget\" class=\"sublink\">[{$tracker_lang['close_list']}]</a>", dltable($tracker_lang['details_seeding'], $seeders, $row), 1);
	tr("<a name=\"leechers\">{$tracker_lang['details_leeching']}</a><br /><a href=\"details_$id$keepget\" class=\"sublink\">[{$tracker_lang['close_list']}]</a>", dltable($tracker_lang['details_leeching'], $downloaders, $row), 1);
}
///////////////
if($row["multitracker"] == 'yes'){if(count($announces_a)){foreach ($announces_a as $announce) {
if ($announce['state'] == 'ok')$anns[] = '<li><b>'.$announce['url'].'</b> - раздающие: <b>'.$announce['seeders'].'</b>, качающие: <b>'.$announce['leechers'].'</b>';
else $anns[] = '<li><font color="red"><b>'.$announce['url'].'</b></font> - не работает, ошибка: '.$announce['error'].'</b>';}
$update_link .= '<br>'.$tracker_lang['details_update_last_mt_update'].' <b>'.get_et(strtotime($row['last_mt_update'])).'</b> '.$tracker_lang['ago'];
tr($tracker_lang['details_multitracker'], '<details class="desc"><summary data-open="Свернуть" data-close="multitracker"></summary><div class="spoiler">
<ul style="margin: 0;">'.implode($anns).'</ul>'.$update_link.'</div></details>', 1);
}else{tr($tracker_lang['details_multitracker'], 'WTF? Multitracker = YES, but no announces', 1);}}
////////////////////
if ($row["times_completed"] > 0) {
$res = sql_query("SELECT users.id, users.username, users.title, users.uploaded, users.downloaded, users.donor, users.enabled, users.warned, users.last_access, 
users.class, snatched.startdat, snatched.last_action, snatched.completedat, snatched.seeder, snatched.userid, snatched.uploaded AS sn_up, snatched.downloaded AS sn_dn 
FROM snatched INNER JOIN users ON snatched.userid = users.id WHERE snatched.finished='yes' AND snatched.torrent =".sqlesc($id)." ORDER BY users.class 
DESC $limit") or sqlerr(__FILE__,__LINE__);
	$snatched_full = "<table width=\"100%\" class=\"main\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">\n";
	$snatched_full .= "<tr><td class=colhead>Юзер</td><td class=colhead>Раздал</td><td class=colhead>Скачал</td><td class=colhead>Рейтинг</td><td class=colhead align=center>Начал / Закончил</td><td class=colhead align=center>Действие</td><td class=colhead align=center>Сидирует</td><td class=colhead align=center>ЛС</td></tr>";

	while ($arr = mysql_fetch_assoc($res)) {
		if ($arr["downloaded"] > 0) {
$ratio = number_format($arr["uploaded"] / $arr["downloaded"], 2);
		}
		else if ($arr["uploaded"] > 0)
		$ratio = "Inf.";
		else
		$ratio = "---";
		$uploaded = mksize($arr["uploaded"]);
		$downloaded = mksize($arr["downloaded"]);
		if ($arr["sn_dn"] > 0) {
				$ratio2 = number_format($arr["sn_up"] / $arr["sn_dn"], 2);
				$ratio2 = "<font color=" . get_ratio_color($ratio2) . ">$ratio2</font>";
		}
		else
			if ($arr["sn_up"] > 0)
				$ratio2 = "Inf.";
			else
				$ratio2 = "---";
		$uploaded2 = mksize($arr["sn_up"]);
		$downloaded2 = mksize($arr["sn_dn"]);
		$snatched_small[] = "<a href=user_$arr[userid]>".get_user_class_color($arr["class"], $arr["username"])." (<font color=" . get_ratio_color($ratio) . ">$ratio</font>)</a>";
		$snatched_full .= "<tr$highlight><td><a href=user_$arr[userid]>".get_user_class_color($arr["class"], $arr["username"])."</a>".get_user_icons($arr)."</td><td><nobr>$uploaded&nbsp;Общего<br>$uploaded2&nbsp;Торрент</nobr></td><td><nobr>$downloaded&nbsp;Общего<br>$downloaded2&nbsp;Торрент</nobr></td><td><nobr>$ratio&nbsp;Общего<br>$ratio2&nbsp;Торрент</nobr></td><td align=center><nobr>{$arr["startdat"]}<br />{$arr["completedat"]}</nobr></td><td align=center><nobr>{$arr["last_action"]}</nobr></td><td align=center>" . ($arr["seeder"] == "yes" ? "<b><font color=\"green\">Да</font>" : "<font color=\"red\">Нет</font></b>") .
			"</td><td align=center><a href=\"message.php?action=sendmessage&amp;receiver={$arr['userid']}\"><img src=\"$pic_base_url/button_pm.gif\" border=\"0\"></a></td></tr>\n";
}
$snatched_full .= "</table>\n";
	?><script src="js/show_hide.js"></script><?
	if ($row["seeders"] == 0 || ($row["leechers"] / $row["seeders"] >= 2))
		$reseed_button = "<form action=\"takereseed.php\"><input type=\"hidden\" name=\"torrent\" value=\"$id\" /><input type=\"submit\" value=\"Позвать скачавших\" /></form>";
	
	if($CURUSER["id"] == $row["owner"] || get_user_class() >= UC_MODERATOR){
tr("ЛС&nbsp;скачавшим", "<form method='POST' action='massseedmess.php'><input type='hidden' name='id' value='".$id."'>
<input type='submit' value='Написать скачавшим релиз'></form>", 1);}
	
	if (!$_GET["snatched"]==1)
		tr("Скачавшие<br /><a href=\"details_$id&amp;snatched=1#snatched\" class=\"sublink\">[{$tracker_lang['open_list']}]</a>", '<a href="javascript: show_hide(\'s1\')"><img border="0" src="pic/plus.gif" id="pics1"><div id="ss1" style="display: none;">'.@implode(", ", $snatched_small).$reseed_button.'</div>', 1);
	
	else
		tr("Скачавшие<br /><a href=\"details_$id\" class=\"sublink\" name=\"snatched\">[{$tracker_lang['close_list']}]</a>", $snatched_full,1);
}

tr($tracker_lang['torrent_info'], "<a href=\"torrent_info.php?id={$id}\">{$tracker_lang['show_data']}</a>", 1);


$torrentid = (int) $_GET["id"];
$thanked_sql = sql_query("SELECT thanks.userid, users.username, users.class FROM thanks INNER JOIN users ON thanks.userid = users.id WHERE thanks.torrentid = $torrentid");
$count = mysql_num_rows($thanked_sql);

if ($count == 0) {
	$thanksby = $tracker_lang['none_yet'];
} else {
	$thanksby = array();
	while ($thanked_row = mysql_fetch_assoc($thanked_sql)) {
		if ($thanked_row["userid"] == $CURUSER["id"])
			$can_not_thanks = true;
		$userid = $thanked_row["userid"];
		$username = $thanked_row["username"];
		$class = $thanked_row["class"];
		$thanksby[] = "<a href=\"user_{$userid}\">".get_user_class_color($class, $username)."</a>";
	}
	if ($thanksby)
		$thanksby = implode(', ', $thanksby);
}
if ($row["owner"] == $CURUSER["id"] || !$CURUSER)
	$can_not_thanks = true;
$thanksby = "<div id=\"ajax\"><form action=\"thanks.php\" method=\"post\">
<input type=\"submit\" name=\"submit\" onclick=\"send(); return false;\" value=\"{$tracker_lang['thanks']}\"".($can_not_thanks == true ? " disabled" : "").">
<input type=\"hidden\" name=\"torrentid\" value=\"{$torrentid}\">{$thanksby}
</form></div>";
?>
<script>
function send() {
	var ajax = new tbdev_ajax('thanks.php');
	ajax.onShow ('');
	var varsString = "";
	ajax.setVar("torrentid", <?=$torrentid;?>);
	ajax.setVar("ajax", "yes");
	ajax.method = 'POST';
	ajax.element = 'ajax';
	ajax.sendAJAX(varsString);
}

function update_multi() {
	var ajax = new tbdev_ajax('update_multi.php');
	ajax.onShow ('');
	var varsString = "";
	ajax.setVar("id", <?=$torrentid;?>);
	ajax.setVar("ajax", "yes");
	ajax.method = 'GET';
	ajax.element = 'update_multi';
	ajax.sendAJAX(varsString);
}
</script>
<div id="loading-layer" style="display:none;font-family: Verdana;font-size: 11px;width:200px;height:50px;background:#FFF;padding:10px;text-align:center;border:1px solid #000">
<div style="font-weight:bold" id="loading-layer-text"><?=$tracker_lang['ajax_loading'];?></div><br /><img src="<?=$pic_base_url;?>/loading.gif" border="0" /></div>
<? tr($tracker_lang['said_thanks'], $thanksby, 1);print("</table></p>\n");
$name = str_replace("'", "%", $row["name"]);$exp = "("; #по какому знаку делить название
$explName = explode($exp, $name);$sqls = mysql_query("SELECT name, id FROM torrents WHERE name LIKE '".$explName[0]."%' AND id <>'".$row["id"]."' LIMIT 10");$num_p=0;$ono="";
while($t = mysql_fetch_array($sqls)){if(!empty($ono))$ono.="";
$ono.="<a href=\"details_".$t['id']."\" alt=\"".$t['name']."\"><b><font color=#006699>".htmlspecialchars_uni($t['name'])."</font></b></a><hr width='80%'>";++$num_p;}?><center><?
////////////////////////////////
if(!empty($row["description"])){$names = str_replace("'", "%", $row["description"]);$exps = ",";$explNames = explode($exps, $names);
$sqlss = sql_query("SELECT name, id, image1 FROM torrents WHERE description LIKE '".$explNames[0]."%' AND id <>'".$row["id"]."' ORDER BY times_completed DESC, added DESC LIMIT 10");
$num_ps=0;$onos="";while($ts = mysql_fetch_array($sqlss)){if (!empty($onos)) $onos.="";
$onos.="<a href=\"details_".$ts['id']."\">
<img height='80' src=\"thumbnail.php?{$ts['image1']}\" border=\"0\" alt=\"".$ts['name']."\" title='".$ts['name']."'></a>&nbsp;&nbsp;&nbsp;";
++$num_ps;}
if($num_ps>0){print("<font size=2 color=#999966><u><b>Рекомендуемые релизы:</b></u></font><br><br>");print($onos);print("<hr width='80%'><br>");
}}else{print("<hr width='80%'><br>");}
if(!empty($row["keywords"])){print("<table style='background:none;width:80%;border:0;'>");$slova = $row["keywords"];$arr = explode(', ', $slova);foreach ($arr as $word){$word = trim($word);$words = str_replace("+", "%2B", $word);
print("<span class='badge-extra text-bold'><a style='font-weight:normal;color:#696969;' href='browse?dsearch=".unesc($words)."' title='".$words."'>".$words."</a></span> ");}
print ("</table>");}else{print("<table style='background:none;' width='70%' border='0'><span class='badge-extra text-bold'>Не прописано</span></table>");}
/////////////////////////////
if($num_p>0){print("<br><hr width='80%'><font size=2 color=#999966><u><b>Все похожие релизы на нашем сайте:</b></u></font><br><br>");print($ono);print("<br>");}?></center></td></tr></table></td></tr></table><?
}else{stdhead($tracker_lang['comments_for']." ".$row["name"]."");
print("<br><table style='background:none;' width='60%' border='0'><td style='border-radius:10px;' class='b'><center>
<font style='font-family:tahoma;font-size:22px;font-weight:10;'><h1>".$tracker_lang['comments_for']." <a href=details_$id>".$row["name"]."</a></h1></font></center></td></table>");}
$count = $row['comments'];$limited = 10;if($count == 0){if($CURUSER["comentoff"] == 'no'){
print("<br><table style='background:none;' width='60%' border='0'><td style='border-radius:10px;' class='b'><center>
<font style='font-family:tahoma;font-size:22px;font-weight:10;color:red;'><b>Вам запрещено оставлять комментарии!</b></font></center></td></table>");
}else{?><table style="margin-top:7px;background:none;cellspacing:0;cellpadding:0;width:100%;height:200;float:center;border:0;"><tr>
<td style="border-radius:15px;border:0;" class='a'><table style='background:none;width:100%;float:center;border:0;'>
<tr><td class="zaliwka" style="color:#FFFFFF;font-size:16px;text-align:center;border:0;border-radius:5px;font-family:cursive;font-weight:bold;margin-top:5px;'">
.:: <?=$tracker_lang['comments_add'];?> ::.</td></tr><tr><td style='background:none;width:100%;float:center;border:0;'>
<form name="comment" id='comment' method="post" action="comment.php?action=add"><br><center><?print(textbbcode("comment","text","")."<br>
<table width='100%' style='background:none;border:none;' cellpadding='5' cellspacing='0'>
<img class='editorbutton' OnClick=\"AddSmile(' :ah:')\" title='ah' height='40' border='0' src='pic/smilies/ah.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :angry2:')\" title='angry2' height='40' border='0' src='pic/smilies/angry2.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :bah:')\" title='bah' height='40' border='0' src='pic/smilies/bah.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :bye:')\" title='bye' height='40' border='0' src='pic/smilies/bye.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cool2:')\" title='cool' height='40' border='0' src='pic/smilies/cool.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry:')\" title='cry1' height='40' border='0' src='pic/smilies/cry1.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry2:')\" title='cry2' height='40' border='0' src='pic/smilies/cry2.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry3:')\" title='cry3' height='40' border='0' src='pic/smilies/cry3.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :good:')\" title='good' height='40' border='0' src='pic/smilies/good.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :haha:')\" title='haha' height='40' border='0' src='pic/smilies/haha.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :happy:')\" title='happy' height='40' border='0' src='pic/smilies/happy.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hehe:')\" title='hehe' height='40' border='0' src='pic/smilies/hehe.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hi2:')\" title='hi' height='40' border='0' src='pic/smilies/hi.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hm:')\" title='hmm' height='40' border='0' src='pic/smilies/hmm.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :huh2:')\" title='huh' height='40' border='0' src='pic/smilies/huh.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :dead:')\" title='imdead' height='40' border='0' src='pic/smilies/imdead.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :khekhe:')\" title='khekhe' height='40' border='0' src='pic/smilies/khekhe.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :roar:')\" title='roar' height='40' border='0' src='pic/smilies/roar.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :stfu:')\" title='stfu' height='40' border='0' src='pic/smilies/stfu.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :tired:')\" title='tired1' height='40' border='0' src='pic/smilies/tired1.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :uhuh:')\" title='uhuh' height='40' border='0' src='pic/smilies/uhuh.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :wat:')\" title='wat1' height='40' border='0' src='pic/smilies/wat1.gif'/></table><br>
<table width='100%' style='background:none;border:none;'><center>
<input type='hidden' name='tid' value='$id'/><input type='submit' class='btn' value='Разместить комментарий'/></center></table><br></form></td></tr></table></td></tr></table>");
}}else{list($pagerbottom, $limit) = pager3($limited, $count, "details_$id&", array('lastpagedefault' => 1));
$subres = sql_query("SELECT c.*, u.avatar, u.warned, u.username, u.class, u.donor, u.last_access, e.username AS editedbyname FROM comments AS c LEFT JOIN users AS u ON c.user = u.id 
LEFT JOIN users AS e ON c.editedby = e.id WHERE torrent = $id ORDER BY c.id $limit") or sqlerr(__FILE__, __LINE__);
$allrows = array();while ($subrow = mysql_fetch_array($subres)) $allrows[] = $subrow;
print("<table width='100%' style='background:none;cellspacin:0;cellpadding:5;'><tr><td>".commenttable($allrows)."</td></tr>");
if($count > 10){print("<tr><td style='background:none;'><center>".$pagerbottom."</center><br></td></tr>");}print("</table>");
if ($CURUSER["comentoff"] == 'no'){print("<table style='background:none;' width='60%' border='0'><td style='border-radius:10px;' class='b'><center>
<font style='font-family:tahoma;font-size:22px;font-weight:10;color:red;'><b>Вам запрещено оставлять комментарии!</b></font></td></table>");}else{?>
<br><table style='background:none;border:0;cellspacing:0;cellpadding:0;width:98%;height:200;float:center;'><tr>
<td style="border-radius:15px;border:0;" class='a'><table style='background:none;width:100%;float:center;border:0;'>
<tr><td class="zaliwka" style="color:#FFFFFF;font-size:16px;text-align:center;border:0;border-radius:5px;font-family:cursive;font-weight:bold;margin-top:5px;'">
.:: <?=$tracker_lang['comments_add'];?> ::.</td></tr><tr><td style='background:none;width:100%;float:center;border:0;'>
<form name="comment" id='comment' method="post" action="comment.php?action=add"><br><center><?
print(textbbcode("comment","text","")."<br>
<table width='100%' style='background:none;border:none;' cellpadding='5' cellspacing='0'>
<img class='editorbutton' OnClick=\"AddSmile(' :ah:')\" title='ah' height='40' border='0' src='pic/smilies/ah.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :angry2:')\" title='angry2' height='40' border='0' src='pic/smilies/angry2.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :bah:')\" title='bah' height='40' border='0' src='pic/smilies/bah.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :bye:')\" title='bye' height='40' border='0' src='pic/smilies/bye.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cool2:')\" title='cool' height='40' border='0' src='pic/smilies/cool.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry:')\" title='cry1' height='40' border='0' src='pic/smilies/cry1.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry2:')\" title='cry2' height='40' border='0' src='pic/smilies/cry2.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry3:')\" title='cry3' height='40' border='0' src='pic/smilies/cry3.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :good:')\" title='good' height='40' border='0' src='pic/smilies/good.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :haha:')\" title='haha' height='40' border='0' src='pic/smilies/haha.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :happy:')\" title='happy' height='40' border='0' src='pic/smilies/happy.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hehe:')\" title='hehe' height='40' border='0' src='pic/smilies/hehe.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hi2:')\" title='hi' height='40' border='0' src='pic/smilies/hi.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hm:')\" title='hmm' height='40' border='0' src='pic/smilies/hmm.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :huh2:')\" title='huh' height='40' border='0' src='pic/smilies/huh.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :dead:')\" title='imdead' height='40' border='0' src='pic/smilies/imdead.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :khekhe:')\" title='khekhe' height='40' border='0' src='pic/smilies/khekhe.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :roar:')\" title='roar' height='40' border='0' src='pic/smilies/roar.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :stfu:')\" title='stfu' height='40' border='0' src='pic/smilies/stfu.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :tired:')\" title='tired1' height='40' border='0' src='pic/smilies/tired1.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :uhuh:')\" title='uhuh' height='40' border='0' src='pic/smilies/uhuh.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :wat:')\" title='wat1' height='40' border='0' src='pic/smilies/wat1.gif'/></table><br>
<table width='100%' style='background:none;border:none;'><center><input type='hidden' name='tid' value='$id'/>
<input type='submit' class='btn' value='Разместить комментарий'/></center></table><br></form></td></tr></table></td></tr></table>");}}
stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>