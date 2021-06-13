<?php if(!defined('IN_TRACKER'))  die('Hacking attempt!');
function torrenttable($res, $variant = "index"){global $tracker_lang, $CURUSER;
if (($CURUSER["class"] < UC_VIP) && $CURUSER){$gigs = $CURUSER["uploaded"] / (1024*1024*1024);
$ratio = (($CURUSER["downloaded"] > 0) ? ($CURUSER["uploaded"] / $CURUSER["downloaded"]) : 0);
if($ratio < 0.5 || $gigs < 5) $wait = 0;elseif($ratio < 0.65 || $gigs < 6.5) $wait = 0;elseif($ratio < 0.8 || $gigs < 8) $wait = 0;
elseif($ratio < 0.95 || $gigs < 9.5) $wait = 0;else $wait = 0;}$count_get = 0;
foreach ($_GET as $get_name => $get_value) {
$get_name = mysql_real_escape_string(strip_tags(str_replace(array("\"","'"),array("",""),$get_name)));
$get_value = mysql_real_escape_string(strip_tags(str_replace(array("\"","'"),array("",""),$get_value)));
if($get_name != "sort" && $get_name != "type"){
if($count_get > 0)$oldlink = $oldlink . "&" . $get_name . "=" . $get_value;else $oldlink = $oldlink . $get_name . "=" . $get_value;$count_get++;}}
if($count_get > 0)$oldlink = $oldlink . "&";
if($_GET['sort'] == "1"){if($_GET['type'] == "desc"){$link1 = "asc";}else{$link1 = "desc";}}
if($_GET['sort'] == "3"){if($_GET['type'] == "desc"){$link3 = "asc";}else{$link3 = "desc";}}
if($_GET['sort'] == "4"){if($_GET['type'] == "desc"){$link4 = "asc";}else{$link4 = "desc";}}
if($_GET['sort'] == "5"){if($_GET['type'] == "desc"){$link5 = "asc";}else{$link5 = "desc";}}
if($_GET['sort'] == "7"){if($_GET['type'] == "desc"){$link7 = "asc";}else{$link7 = "desc";}}
if($_GET['sort'] == "8"){if ($_GET['type'] == "desc"){$link8 = "asc";}else{$link8 = "desc";}}
if($_GET['sort'] == "9"){if($_GET['type'] == "desc"){$link9 = "asc";}else{$link9 = "desc";}}
if($link1 == ""){$link1 = "asc";} // for torrent name
if($link3 == ""){$link3 = "desc";}
if($link4 == ""){$link4 = "desc";}
if($link5 == ""){$link5 = "desc";}
if($link7 == ""){$link7 = "desc";}
if($link8 == ""){$link8 = "desc";}
if($link9 == ""){$link9 = "desc";}
if($variant == "index"){$script = "browse.php";}elseif($variant == "mytorrents"){$script = "mytorrents.php";}elseif($variant == "bookmarks"){$script = "bookmarks.php";}?>
<tr><td align="center" width="50px"><b>Категория</b></td><td align="center" width="50px"><b>Тип</b></td><td align="left">
<a href="<?php print $script; ?>?<?php print $oldlink; ?>sort=1&type=<?php print $link1; ?>" class="altlink_white"><?php echo $tracker_lang['name'];?></a> / 
<a href="<?php print $script; ?>?<?php print $oldlink; ?>sort=4&type=<?php print $link4; ?>" class="altlink_white"><?php echo $tracker_lang['added'];?></a></td>
<?php if($wait)print("<td align=\"center\">".$tracker_lang['wait']."</td>\n");
if($variant == "mytorrents")print("<td align=\"center\">".$tracker_lang['visible']."</td>\n");?>
<td align="center"><a href="<?php print $script; ?>?<?php print $oldlink; ?>sort=3&type=<?php print $link3; ?>" class="altlink_white"><?php echo $tracker_lang['comments'];?></a></td>
<td align="center"><a href="<?php print $script; ?>?<?php print $oldlink; ?>sort=5&type=<?php print $link5; ?>" class="altlink_white"><?php echo $tracker_lang['size'];?></a></td>
<td align="center"><a href="<?php print $script; ?>?<?php print $oldlink; ?>sort=7&type=<?php print $link7; ?>" class="altlink_white"><?php echo $tracker_lang['seeds'];?></a>|<a href="<?php print $script; ?>?<?php print $oldlink; ?>sort=8&type=<?php print $link8; ?>" class="altlink_white"><?php echo $tracker_lang['leechers'];?></a></td><?php
if ($variant == "index" || $variant == "bookmarks")
	print("<td align=\"center\"><a href=\"{$script}?{$oldlink}sort=9&type={$link9}\" class=\"altlink_white\">".$tracker_lang['uploadeder']."</a></td>\n");

if ($variant == "bookmarks")print("<td align=\"center\">".$tracker_lang['delete']."</td>\n");
print("</tr><tbody id=\"highlighted\">");
if ((get_user_class() >= UC_MODERATOR) && $variant == "index")print("<form method=\"post\" action=\"deltorrent.php?mode=delete\">");

if ($variant == "bookmarks")print ("<form method=\"post\" action=\"takedelbookmark.php\">");
while($row = mysql_fetch_assoc($res)){$day_added = $row['added'];$day_show = strtotime($day_added);$thisdate = date('Y-m-d',$day_show);
if($thisdate==$prevdate){$cleandate = '';}else{$day_added = '  '.date('l d M', strtotime($row['added']));
$cleandate = "<tr><td class=\"zaliwka\" style='color:#FFFFFF;font-size:14px;font-family:cursive;margin-left:20px;text-align:left;border:0;border-radius:5px;' colspan='15'>&nbsp;&nbsp;Релизы за $day_added</td></tr>";}
$prevdate = $thisdate;
$man = array(
    'Jan' => 'Января',
    'Feb' => 'Февраля',
    'Mar' => 'Марта',
    'Apr' => 'Апреля',
    'May' => 'Мая',
    'Jun' => 'Июня',
    'Jul' => 'Июля',
    'Aug' => 'Августа',
    'Sep' => 'Сентября',
    'Oct' => 'Октября',
    'Nov' => 'Ноября',
    'Dec' => 'Декабря'
);
foreach($man as $eng => $rus){$cleandate = str_replace($eng, $rus,$cleandate);}
$dag = array(
    'Mon' => 'Понедельник',
    'Tues' => 'Вторник',
    'Wednes' => 'Среда',
    'Thurs' => 'Четверг',
    'Fri' => 'Пятница',
    'Satur' => 'Суббота',
    'Sun' => 'Воскресенье'
);
foreach($dag as $eng => $rus){$cleandate = str_replace($eng.'day', $rus.'',$cleandate);}
if(!$_GET['sort'] && !$_GET['d']){echo $cleandate;}
$id = $row["id"];
print("<tr>");
print("<td align=\"center\" style=\"padding: 0px\">");
if($row["cat_name"] != ''){print("<a href=\"browse.php?janr=" . $row["category"] . "\">");
if($row["cat_pic"] != ""){print("<img border=\"0\" src=\"pic/cats/" . $row["cat_pic"] . "\" alt=\"" . $row["cat_name"] . "\" />");}else{print($row["cat_name"]);}
print("</a>");}else print("-");
print("</td>");
print("<td align=\"center\" style=\"padding: 0px\">");
if($row["incat_name"] != ''){print("<a href=\"browse.php?tip=".$row["incategory"]."\">");
if($row["incat_pic"] != ""){print("<img border=\"0\" src=\"pic/cats/".$row["incat_pic"]."\" alt=\"".$row["incat_name"]."\" />");}else{print($row["incat_name"]);}
print("</a>");}else print("-");
print("</td>");

$dispname = $row["name"];
switch ($row['free']) {
case 'bril': $freepic = "&nbsp;<a href=\"Brilliant\" alt=\"Brilliant\" title=\"Brilliant\"><img src=\"pic/bril.gif\" title=\"Brilliant\" alt=\"Brilliant\"></a>";break;
case 'yes': $freepic = "&nbsp;<a href=\"Gold\" alt=\"".$tracker_lang['golden']."\" title=\"".$tracker_lang['golden']."\"><img src=\"pic/golden.gif\" title=\"".$tracker_lang['golden']."\" alt=\"".$tracker_lang['golden']."\"></a>";break;
case 'silver': $freepic = "&nbsp;<a href=\"Silver\" alt=\"".$tracker_lang['silver']."\" title=\"".$tracker_lang['silver']."\"><img src=\"pic/silvers.gif\" title=\"".$tracker_lang['silver']."\" alt=\"".$tracker_lang['silver']."\"></a>";break;
case 'no': $freepic = '';}
$thisisfree = $freepic;

print("<td align=\"left\">".($row["not_sticky"] == "no" ? "<font size='3' title='Важный'>📌</font> " : "")."");
/////////////////////// 
if($row["suid"]){?>&nbsp;
<a href="download.php?id=<?=$row['id']?>"><img src="pic/trans.gif" title="Вы уже брали этот торрент. Нажмите, чтобы загрузить файл .torrent еще раз."/></a>&nbsp;<?} 
////////////////////////////
print("<a href=\"details.php?");
if ($variant == "mytorrents")
			print("returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;");
		print("id=$id");
if ($variant == "index" || $variant == "bookmarks")
print("&amp;hit=1");         
print("\">");      
switch ($row['free']) {
case 'bril': $disname = "<font color=\"blue\" title=\"Бриллиантовая раздача! Это значит, что кол-во розданного на этой раздаче удваивается!\">$dispname</font>";break;
case 'yes': $disname = "<font color=\"#d08700\" title=\"Золотая раздача! Это значит, что кол-во скачанного на этой раздаче не идет в общую статистику!\">$dispname</font>";break;   
case 'silver': $disname = "<font color=\"#778899\" title=\"Серебрянная раздача! Это значит, что половина скачанного на этой раздаче не идет в общую статистику!\">$dispname</font>";break;   
case 'no': $disname = "$dispname";}
$disnames = $disname;
print("<b>$disnames</b></a> $thisisfree");

if($CURUSER["id"] == $row["owner"] || get_user_class() >= UC_MODERATOR){
print("<a target=_blank href='edit.php?id=$row[id]'><img border='0' src='pic/pen.gif' alt='".$tracker_lang['edit']."' title='".$tracker_lang['edit']."'/></a>");}

$elapseds = floor((gmtime() - strtotime($row["added"])) / 86400);
if ($elapseds < 3 && $variant == "index"){print ("&nbsp;&nbsp;<img border=\"0\" src=\"pic/new.gif\" alt=\"Новинка\" title=\"Новинка\">");}else{}

if(!empty($row["description"])){print("<br />");
$slova = $row["description"];$arr = explode(', ', $slova);
foreach ($arr as $word){$word = trim($word);$words = str_replace("+", "%2B", $word);
print("<a style=\"font-weight:normal;color:#696969;\" href=\"browse.php?jsearch=".unesc($words)."\" title='".$words."'>".$word.", </a>");}}
else{print("<br />Не прописано");}
            print("<br />");
			print("<i>".$row["added"]."</i>");		
			////////////////////
if($variant != "bookmarks"){?><span><center><?
if($row["userid"]) echo '<div id="bookmark.php?torrent='.$row['id'].'"><img src="pic/delbook.png"  border="0" title="Убрать из избранного" onclick="bookmark('.$row['id'].', \'del\' , \'browse\');" /></div>';
else echo '<div id="bookmark.php?torrent='.$row['id'].'"><img src="pic/addbook.png"  border="0" title="Добавить в избранное" onclick="bookmark('.$row['id'].', \'add\' , \'browse\');"  /></div>';
?></center></span><?}if($variant == "bookmarks"){?><span><center><?
if($row["userid"]) echo '<div id="bookmark.php?torrent='.$row['id'].'"><img src="pic/delbook.png"  border="0" title="Убрать из избранного" onclick="bookmark('.$row['id'].', \'del\' , \'browse\');"  /></div>';
else echo '<div id="bookmark.php?torrent='.$row['id'].'"><img src="pic/addbook.png"  border="0" title="Добавить в избранное" onclick="bookmark('.$row['id'].', \'add\' , \'browse\');" /></div>';
?></center></span><?}
								if ($wait)
								{
								  $elapsed = floor((gmtime() - strtotime($row["added"])) / 3600);
				if ($elapsed < $wait)
				{
				  $color = dechex(floor(127*($wait - $elapsed)/48 + 128)*65536);
				  print("<td align=\"center\"><nobr><a href=\"faq.php#dl8\"><font color=\"$color\">" . number_format($wait - $elapsed) . " h</font></a></nobr></td>\n");
				}
				else
				  print("<td align=\"center\"><nobr>".$tracker_lang['no']."</nobr></td>\n");
		}
	print("</td>\n");

		if ($variant == "mytorrents") {
			print("<td align=\"right\">");
			if ($row["visible"] == "no")
				print("<font color=\"red\"><b>".$tracker_lang['no']."</b></font>");
			else
				print("<font color=\"green\">".$tracker_lang['yes']."</font>");
			print("</td>\n");
		}
		if (!$row["comments"])
			print("<td align=\"right\">" . $row["comments"] . "</td>\n");
		else {
			if ($variant == "index")
				print("<td align=\"right\"><b><a href=\"details.php?id=$id&amp;hit=1&amp;tocomm=1\">" . $row["comments"] . "</a></b></td>\n");
			else
				print("<td align=\"right\"><b><a href=\"details.php?id=$id&amp;page=0#startcomments\">" . $row["comments"] . "</a></b></td>\n");
		}
		print("<td align=\"center\">" . str_replace(" ", "<br />", mksize($row["size"])) . "</td>\n");
		print("<td align=\"center\">");
if($row["seeders"] > 0){print("<b><a href=\"details.php?id=$id\"><font color='green'>".$row["seeders"]."</font></a></b>");}else{print("0");}
print(" | ");
if($row["leechers"] > 0){print("<b><a href=\"details.php?id=$id\"><font color='red'>".$row["leechers"]."</font></a></b>");}else{print("0");}
if ($row['multitracker'] == 'yes'){print("<hr><b>MULTI</b><br>");
if($row["remote_seeders"] > 0){print("<b><a href=\"details.php?id=$id\"><font color='green'>".$row["remote_seeders"]."</font></a></b>");}else{print("0");}
print(" | ");
if($row["remote_leechers"] > 0){print("<b><a href=\"details.php?id=$id\"><font color='red'>".$row["remote_leechers"]."</font></a></b>");}else{print("0");}}
print("</td>");

		if ($variant == "index" || $variant == "bookmarks")
			print("<td align=\"center\">" . (isset($row["username"]) ? ("<a href=\"userdetails.php?id=" . $row["owner"] . "\"><b>" . get_user_class_color($row["class"], htmlspecialchars_uni($row["username"])) . "</b></a>") : "<i>(unknown)</i>") . "</td>\n");

		if ($variant == "bookmarks")
			print ("<td align=\"center\"><input type=\"checkbox\" name=\"delbookmark[]\" value=\"" . $row[bookmarkid] . "\" /></td>");

		if ((get_user_class() >= UC_MODERATOR) && $variant == "index")
			print("<td align=\"center\"><input type=\"checkbox\" name=\"delete[]\" value=\"" . $id . "\" /></td>\n");

	print("</tr>\n");

	}

	print("</tbody>");

	if ($variant == "index" && $CURUSER)
		print("<tr><td colspan=\"12\" align=\"center\"></td></tr>");

	if ($variant == "index") {
		if (get_user_class() >= UC_MODERATOR) {
			print("<tr><td align=\"right\" colspan=\"12\"><input type=\"submit\" value=\"Удалить\"></td></tr>\n");
		}
	}

	if ($variant == "bookmarks")
		print("<tr><td colspan=\"12\" align=\"right\"><input type=\"submit\" value=\"".$tracker_lang['delete']."\"></td></tr>\n");

	if ($variant == "index" || $variant == "bookmarks") {
		if (get_user_class() >= UC_MODERATOR) {
			print("</form>\n");
		}
	}
return $rows;}?>