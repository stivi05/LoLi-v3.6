<?php require_once("include/bittorrent.php");dbconn(false);gzip();parked();
$cats = get_list('categories');$incats = get_list('incategories');$searchstr = '';$tsearchstr = '';$jsearchstr = '';$dsearchstr = '';$letter = '';
if(isset($_GET['search']))$searchstr = unesc(trim($_GET["search"]));$cleansearchstr = htmlspecialchars_uni($searchstr);if(empty($cleansearchstr))unset($cleansearchstr);
if(isset($_GET['tsearch']))$tsearchstr = unesc(trim($_GET["tsearch"]));$cleansearchstr2 = htmlspecialchars_uni($tsearchstr);if(empty($cleansearchstr2))unset($cleansearchstr2);
if(isset($_GET['dsearch']))$dsearchstr = unesc(trim($_GET["dsearch"]));$descrsearchstr = htmlspecialchars_uni($dsearchstr);if(empty($descrsearchstr))unset($descrsearchstr);
if(isset($_GET['jsearch']))$jsearchstr = unesc(trim($_GET["jsearch"]));$jescrsearchstr = htmlspecialchars_uni($jsearchstr);if(empty($jescrsearchstr))unset($jescrsearchstr);
if(isset($_GET['letter']))$letter = unesc(trim($_GET["letter"]));$letter = htmlspecialchars_uni($letter);if(empty($letter))unset($letter);
if(isset($_GET['sort']) && isset($_GET['type'])){$column = '';$ascdesc = '';switch($_GET['sort']){
case '1': $column = "name"; break;case '4': $column = "added";break;case '5': $column = "size";break;
case '7': $column = "seeders";break;case '8': $column = "leechers";break;
case '10': if(get_user_class() >= UC_MODERATOR) $column = "moderatedby";break;default: $column = "id";break;}
switch($_GET['type']){case 'asc': $ascdesc = "ASC";$linkascdesc = "asc";break;case 'desc': $ascdesc = "DESC";$linkascdesc = "desc";break;
default: $ascdesc = "DESC";$linkascdesc = "desc";break;}
$orderby = "ORDER BY t.".$column." ".$ascdesc;$pagerlink = "sort=".intval($_GET['sort'])."&type=".$linkascdesc."&";}else{
$orderby = "ORDER BY t.added DESC";$pagerlink = "";}
$addparam = "";$wherea = array();$wherecatina = array();$whereincatina = array();$incldead = 0;
if(isset($_GET['incldead'])){
if(!empty($_GET['jsearch']) || !empty($_GET['dsearch']) || !empty($_GET['search']) || !empty($_GET['tsearch']) || !empty($_GET['letter'])){
if($_GET["incldead"] == 1){$addparam .= "incldead=1&amp;";$wherea[] = "tg.free = 'no'";}elseif($_GET["incldead"] == 2){$addparam .= "incldead=2&amp;";
$wherea[] = "tg.free = 'silver'";}elseif($_GET["incldead"] == 3){$addparam .= "incldead=3&amp;";$wherea[] = "tg.free = 'yes'";}elseif($_GET["incldead"] == 4){
$addparam .= "incldead=4&amp;";$wherea[] = "tg.free = 'bril'";}elseif($_GET["incldead"] == 5){$addparam .= "incldead=5&amp;";$wherea[] = "tg.seeders = 0";}
elseif($_GET["incldead"] == 6){$addparam .= "incldead=6&amp;";$wherea[] = "tg.multitracker = 'yes'";}}else{
if($_GET["incldead"] == 1){$addparam .= "incldead=1&amp;";$wherea[] = "t.free = 'no'";}elseif($_GET["incldead"] == 2){$addparam .= "incldead=2&amp;";$wherea[] = "t.free = 'silver'";
}elseif($_GET["incldead"] == 3){$addparam .= "incldead=3&amp;";$wherea[] = "t.free = 'yes'";}elseif($_GET["incldead"] == 4){$addparam .= "incldead=4&amp;";
$wherea[] = "t.free = 'bril'";}elseif($_GET["incldead"] == 5){$addparam .= "incldead=5&amp;";$wherea[] = "t.seeders = 0";}elseif($_GET["incldead"] == 6){
$addparam .= "incldead=6&amp;";$wherea[] = "t.multitracker = 'yes'";}}$incldead = (int)$_GET['incldead'];}
if(isset($_GET['janr']))$category = (int)$_GET["janr"];else $category = 0;
if(isset($_GET['tip']))$incategory = (int)$_GET["tip"];else $incategory = 0;if(isset($_GET['all']))$all = $_GET["all"];else $all = false;
if(!$all){if($category){if(!is_valid_id($category))stderr($tracker_lang['error'], "Invalid category ID.");$wherecatina[] = $category;$addparam .= "janr=$category&amp;";}else{$all = True;
foreach ($cats as $cat){$all &= isset($_GET["c{$cat['id']}"]);if(isset($_GET["c{$cat['id']}"])){$wherecatina[] = $cat['id'];$addparam .= "c{$cat['id']}=1&amp;";}}}
if($incategory){if(!is_valid_id($incategory))stderr($tracker_lang['error'], "Invalid incategory ID.");$whereincatina[] = $incategory;$addparam .= "tip=$incategory&amp;";}else{$all = True;
foreach ($incats as $incat){$all &= isset($_GET["i{$incat['id']}"]);if(isset($_GET["i{$incat['id']}"])){$whereincatina[] = $incat['id'];$addparam .= "i{$incat['id']}=1&amp;";}}}}
if($all){$wherecatina = array();$whereincatina = array();$addparam = "";}
if(count($wherecatina) > 1)$wherecatin = implode(",", $wherecatina);elseif(count($wherecatina) == 1)$wherea[] = "category = $wherecatina[0]";
if(count($whereincatina) > 1)$whereincatin = implode(",", $whereincatina);elseif(count($whereincatina) == 1)$wherea[] = "incategory = $whereincatina[0]";$wherebase = $wherea;
if(isset($cleansearchstr)){$wherea[] = "tg.name LIKE '%".sqlwildcardesc($searchstr)."%'";$addparam .= "search=".urlencode($searchstr)."&amp;";}
if(isset($cleansearchstr2)){$name = str_replace("'", "%", sqlwildcardesc($tsearchstr));$exp = "(";$explName = explode($exp, $name);
$wherea[] = "tg.name LIKE '".$explName[0]."%'";$addparam .= "tsearch=".urlencode($tsearchstr)."&amp;";}
if(isset($descrsearchstr)){$wherea[] = "tg.keywords LIKE '%".sqlwildcardesc($dsearchstr)."%'";$addparam .= "dsearch=".urlencode($dsearchstr)."&amp;";}
if(isset($jescrsearchstr)){$wherea[] = "tg.description LIKE '%".sqlwildcardesc($jsearchstr)."%'";$addparam .= "jsearch=".urlencode($jsearchstr)."&amp;";}
if(isset($letter)){$wherea[] = "tg.name LIKE '$letter%'";$addparam = "letter=".urlencode($letter)."&amp;";}$where = implode(" AND ", $wherea);
if(isset($wherecatin) && !empty($wherecatin))$where .= ($where ? " AND " : "") . "t.category IN (".$wherecatin.")";
if(isset($whereincatin) && !empty($whereincatin))$where .= ($where ? " AND " : "") . "t.incategory IN (".$whereincatin.")";if($where != "")$where = "WHERE $where";
if(!empty($_GET['jsearch']) || !empty($_GET['dsearch']) || !empty($_GET['search']) || !empty($_GET['tsearch']) || !empty($_GET['letter'])){
$res = mysql_query("SELECT COUNT(*) FROM tags AS tg $where") or die(mysql_error());$row = mysql_fetch_array($res);$count = $row[0];$num_torrents = $count;}else{
$res = mysql_query("SELECT COUNT(*) FROM torrents AS t $where") or die(mysql_error());$row = mysql_fetch_array($res);$count = $row[0];$num_torrents = $count;}
if(!$count && isset($cleansearchstr)){$wherea = $wherebase;$searcha = explode(" ", $cleansearchstr);$sc = 0;
foreach($searcha as $searchss){if(strlen($searchss) <= 1)continue;$sc++;if($sc > 5)break;$ssa = array();$ssa[] = "tg.name LIKE '%".sqlwildcardesc($searchss)."%'";}
if($sc){$where = implode(" AND ", $wherea);if($where != "")$where = "WHERE $where";$count = $row[0];}}
if(!$count && isset($cleansearchstr2)){$wherea = $wherebase;$tsearcha = explode(" (", $cleansearchstr2);$sc = 0;
foreach($tsearcha as $tsearchss){if(strlen($tsearchss) <= 1)continue;$sc++;if($sc > 5)break;$ssa = array();$ssa[] = "tg.name LIKE '%".sqlwildcardesc($tsearchss)."%'";}
if($sc){$where = implode(" AND ", $wherea);if($where != "")$where = "WHERE $where";$count = $row[0];}}
if(!$count && isset($descrsearchstr)){$wherea = $wherebase;$dsearcha = explode(" ", $descrsearchstr);$dsc = 0;
foreach($dsearcha as $dsearchss){if(strlen($dsearchss) <= 1)continue;$dsc++;
if($dsc > 5)break;$ssa = array();$ssa[] = "tg.keywords LIKE '%".sqlwildcardesc($dsearchss)."%'";}
if($dsc){$where = implode(" AND ", $wherea);if($where != "")$where = "WHERE $where";$count = $row[0];}}
if(!$count && isset($letter)){$wherea = $wherebase;$letter = explode(" ", $letter);$lsc = 0;
foreach ($letter as $letter){if(strlen($letter) <= 1)continue;$lsc++;if($lsc > 5)break;$ssa = array();$ssa[] = "tg.name LIKE '$letter%'";}
if($lsc){$where = implode(" AND ", $wherea);if($where != "")$where = "WHERE $where";$count = $row[0];}} 
$userid = $CURUSER['id'];$torrentsperpage = $CURUSER["torrentsperpage"];if(!$torrentsperpage)$torrentsperpage = 25;
if($count){if($addparam != ""){if($pagerlink != ""){if($addparam{strlen($addparam)-1} != ";"){
$addparam = $addparam."&".$pagerlink;}else{$addparam = $addparam . $pagerlink;}}}else{$addparam = $pagerlink;}
////////////////////////////////////////////////	
list($pagertop, $pagerbottom, $limit) = pager2($torrentsperpage, $count, "browse_GIT.php?".$addparam);
////////////////
if(!empty($_GET['jsearch']) || !empty($_GET['dsearch']) || !empty($_GET['search']) || !empty($_GET['tsearch']) || !empty($_GET['letter'])){
$query = "SELECT tg.id, t.*, c.name AS cat_name, c.image AS cat_pic, i.name AS incat_name, i.image AS incat_pic, u.username, u.class, bookmarks.userid, 
snatched.userid AS suid FROM tags tg LEFT JOIN torrents t ON t.id = tg.id LEFT JOIN categories AS c ON t.category = c.id 
LEFT JOIN incategories AS i ON t.incategory = i.id LEFT JOIN users AS u ON t.owner = u.id 
LEFT JOIN bookmarks ON bookmarks.userid = $userid AND bookmarks.torrentid = tg.id LEFT JOIN snatched ON snatched.userid = $userid AND snatched.torrent = tg.id 
 $where $orderby $limit";    
}else{$query = "SELECT t.*, c.name AS cat_name, c.image AS cat_pic, i.name AS incat_name, i.image AS incat_pic, u.username, u.class, bookmarks.userid, 
snatched.userid AS suid FROM torrents AS t LEFT JOIN categories AS c ON t.category = c.id LEFT JOIN incategories AS i ON t.incategory = i.id LEFT JOIN users AS u ON t.owner = u.id
LEFT JOIN bookmarks ON bookmarks.userid = $userid AND bookmarks.torrentid = t.id LEFT JOIN snatched ON snatched.userid = $userid AND snatched.torrent = t.id $where $orderby $limit";}
////////////
$res = sql_query($query) or die(mysql_error());}else unset($res);
//////////////////////
if(isset($cleansearchstr)){stdhead($tracker_lang['search_results_for']." \"$cleansearchstr\"");}elseif(isset($cleansearchstr2)){
stdhead($tracker_lang['search_results_for']." \"$cleansearchstr2\"");}elseif(isset($descrsearchstr)){stdhead($tracker_lang['search_results_for']." \"$descrsearchstr\"");
}else{stdhead($tracker_lang['browse']);}?><table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:30px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
.:: Релизы ::.</td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;">
<table style="background:none;border:0;" class="embedded" align="center"><script src="js/bookmarks.js"></script><form method="get" action="browse.php">
<tr><td valign="top" style="background:none;border:0;" class="bottom">
<table valign="top" class="embedded" cellspacing="0" style='border:0;background:none;' cellpadding="5" width="100%"><tr>
<td style="background:none;border:0;" valign="top" class="bottom"><table class="bottom" style="background:none;border:0;" width="250px" align="center">
<tr><td valign="top" class="zaliwka" style="font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:center;border:0;border-radius:5px;"><center>.:: Genre ::.</center></td></tr>
</table><table class="bottom" style="background:none;border:0;" align="center"><tr><? $i = 0;foreach ($cats as $cat){$catsperrow = 2;//=> kolichestvo kolonok (ne strok!!!)//
print(($i && $i % $catsperrow == 0) ? "</tr><tr>" : "");print("<td class=\"bottom\" style=\"padding-bottom:2px;padding-left:7px\">
<input name='c".$cat['id']."' type=\"checkbox\" ".(in_array($cat['id'],$wherecatina) ? "checked='checked' " : "")." value='1' />
<a class='catlink' href='browse.php?janr=$cat[id]'>".htmlspecialchars_uni($cat[name])."</a></td>");
$i++;}$alllink = "<div align=\"left\">(<a href=\"browse.php?all=1\"><b>".$tracker_lang['show_all']."</b></a>)</div>";
$ncats = count($cats);$nrows = ceil($ncats / $catsperrow);$lastrowcols = $ncats % $catsperrow;
if($lastrowcols != 0){if($catsperrow - $lastrowcols != 1){print("<td class=\"bottom\" rowspan=\"".($catsperrow - $lastrowcols - 1)."\">&nbsp;</td>");}}?></tr></table>
</td><td valign="top" style="background:none;border:0;" class="bottom"><table valign="top" style="background:none;border:0;" class="bottom" width="550px" align="center">
<tr><td valign="top" class="zaliwka" style="font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:center;border:0;border-radius:5px;"><center>.:: Quality ::.</center></td></tr>
</table><table class="bottom" style="background:none;border:0;" align="center"><tr><? $j = 0;foreach ($incats as $incat){$incatsperrow = 4;//=> kolichestvo kolonok (ne strok!!!)//
print(($j && $j % $incatsperrow == 0) ? "</tr><tr>" : "");print("<td class=\"bottom\" style=\"padding-bottom:2px;padding-left:7px\">
<input name='i".$incat['id']."' type=\"checkbox\" ".(in_array($incat['id'],$whereincatina) ? "checked='checked' " : "")." value='1' />
<a class='catlink' href='browse.php?tip=$incat[id]'>".htmlspecialchars_uni($incat[name])."</a></td>");
$j++;}$alllink = "<div align=\"left\">(<a href=\"browse.php?all=1\"><b>".$tracker_lang['show_all']."</b></a>)</div>";
$nincats = count($incats);$ninrows = ceil($nincats / $incatsperrow);$lastrowcolsin = $nincats % $incatsperrow;
if($lastrowcolsin != 0){if($incatsperrow - $lastrowcolsin != 1){print("<td class=\"bottom\" rowspan=\"".($incatsperrow - $lastrowcolsin - 1)."\">&nbsp;</td>");}}?></tr></table></td>
</tr></table></td></tr>
<tr><td class="bottom"><table class="embedded" cellspacing="0" style='border:0;background:none;' cellpadding="5" width="100%"><tr>
<td valign="top" class="bottom"><table valign="top" style="background:none;border:0;" class="bottom" width="700px" align="center">
<tr><td valign="top" class="zaliwka" style="font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:left;border:0;border-radius:5px;"><center>.:: SEARCH ::.</center></td></tr>
</table><table class="embedded" style="background:none;border:0;" align="center"><tr><td style="text-align:center;border:0;border-radius:5px;"><script src="js/suggest.js"></script>
<input id="suggestinput" name="search" type="text" size="60" value="<?=htmlspecialchars_uni($searchstr)?>" placeholder="Search in 'Title'"/>&nbsp;<b>in</b>&nbsp;
<select name="incldead"><option value="0">All Releases</option>
<option value="6"<? print($incldead == 6 ? " selected" : "no"); ?>>Simple Releases</option>
<option value="5"<? print($incldead == 5 ? " selected" : "silver"); ?>>Silver Releases</option>
<option value="3"<? print($incldead == 3 ? " selected" : "yes"); ?>>Gold Releases</option>
<option value="7"<? print($incldead == 7 ? " selected" : "bril"); ?>>Diamond Releases</option>
<option value="4"<? print($incldead == 4 ? " selected" : "yes"); ?>>No Seeders</option>
<option value="8"<? print($incldead == 8 ? " selected" : "yes"); ?>>Multitracker</option></select>
<input class="btn" type="submit" value="<?=$tracker_lang['search'];?>!"><div id="suggest"></div><br/>
<input type="text" name="tsearch" size="50" value="<?=htmlspecialchars_uni($tsearchstr)?>" placeholder="Search by the first word in 'Title'"/>&nbsp;&nbsp;<b>or</b>&nbsp;&nbsp;
<input type="text" name="dsearch" size="50" value="<?=htmlspecialchars_uni($dsearchstr)?>" placeholder="Search in 'Description'"/><br/><br/><div style="font-size: 10pt;"><noindex>
<? if(isset($letter))$addparam = str_replace("letter=".$letter,'',$addparam); 
for($i = 1; $i < 10; ++$i){if($i == $letter)print("<b>$i</b>\n");elseif($i!=10)print("<a href=\"letter_$i\"><b>$i</b></a>\n");} 
for($i = 65; $i < 91; ++$i){$l = chr($i);if($l == $letter)print("<b>$l</b>");else print("<a href=\"letter_$l\"><b>$l</b></a>\n");}print("<br/>");?><a href="letter_А"><b>А</b></a>&nbsp;<a href="letter_Б"><b>Б</b></a>&nbsp;<a href="letter_В"><b>В</b></a>&nbsp;<a href="letter_Г"><b>Г</b></a>&nbsp;<a href="letter_Д"><b>Д</b></a>&nbsp;<a href="letter_Е"><b>Е</b></a>&nbsp;<a href="letter_Ж"><b>Ж</b></a>&nbsp;<a href="letter_З"><b>З</b></a>&nbsp;<a href="letter_И"><b>И</b></a>&nbsp;<a href="letter_Й"><b>Й</b></a>&nbsp;<a href="letter_К"><b>К</b></a>&nbsp;<a href="letter_Л"><b>Л</b></a>&nbsp;<a href="letter_М"><b>М</b></a>&nbsp;<a href="letter_Н"><b>Н</b></a>&nbsp;<a href="letter_О"><b>О</b></a>&nbsp;<a href="letter_П"><b>П</b></a>&nbsp;<a href="letter_Р"><b>Р</b></a>&nbsp;<a href="letter_С"><b>С</b></a>&nbsp;<a href="letter_Т"><b>Т</b></a>&nbsp;<a href="letter_У"><b>У</b></a>&nbsp;<a href="letter_Ф"><b>Ф</b></a>&nbsp;<a href="letter_Х"><b>Х</b></a>&nbsp;<a href="letter_Ц"><b>Ц</b></a>&nbsp;<a href="letter_Ч"><b>Ч</b></a>&nbsp;<a href="letter_Ш"><b>Ш</b></a>&nbsp;<a href="letter_Щ"><b>Щ</b></a>&nbsp;<a href="letter_Ы"><b>Ы</b></a>&nbsp;<a href="letter_Э"><b>Э</b></a>&nbsp;<a href="letter_Ю"><b>Ю</b></a>&nbsp;<a href="letter_Я"><b>Я</b></a></noindex></div></td></tr></table></td></tr></table></td></tr>
<?if(isset($cleansearchstr)){print("<tr><td style='background:none;border:0;text-align:center;font-weight:bold;' class=\"index\" colspan=\"12\"><hr>".$tracker_lang['search_results_for'].": '<font color=red>".htmlspecialchars_uni($searchstr)."</font>'</td></tr>");
}elseif(isset($cleansearchstr2)){print("<tr><td style='background:none;border:0;text-align:center;font-weight:bold;' class=\"index\" colspan=\"12\"><hr>".$tracker_lang['search_results_for'].": \"<font color=red>".htmlspecialchars_uni($tsearchstr)."</font>\"</td></tr>");
}elseif(isset($jescrsearchstr)){print("<tr><td style='background:none;border:0;text-align:center;font-weight:bold;' class=\"index\" colspan=\"12\"><hr>".$tracker_lang['search_results_for'].": \"<font color=red>".htmlspecialchars_uni($jsearchstr)."</font>\"</td></tr>");
}elseif(isset($descrsearchstr)){print("<tr><td style='background:none;border:0;text-align:center;font-weight:bold;' class=\"index\" colspan=\"12\"><hr>".$tracker_lang['search_results_for'].": \"<font color=red>".htmlspecialchars_uni($dsearchstr)."</font>\"</td></tr>");}
print("</form></table></td></tr></table></td></tr></table>");
if($num_torrents){print("<table id=\"pager\" style='background:none;border:0;margin-top:7px;' class=\"embedded\" cellspacing=\"0\" cellpadding=\"5\" width=\"100%\">
<tr><td style='border:0;' class=\"index\" colspan=\"12\"><center>".$pagertop."</center></td></tr><tr>");?>
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="colspan:12;border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;">
<tr><td align="center" colspan="12" style="background:none;width:100%;float:center;border:0;"><?torrenttable($res, "index");
print("</td></tr></table></td></tr></table><tr><td class=\"index\" style='border:0;' colspan=\"12\"><center>".$pagerbottom."</center></td></tr></table>");}else{
if(isset($cleansearchstr)){print("<table style='background:none;cellspacing:0;cellpadding:0;width:300px;float:center;margin-top:7px;'><tr>
<td style='border-radius:15px;border:none;' class='a'><table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:40px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;'>
".$tracker_lang['nothing_found']."</td></tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table><br>");
}elseif(isset($cleansearchstr2)){print("<table style='margin-top:7px;background:none;cellspacing:0;cellpadding:0;width:300px;float:center;'><tr>
<td style='border-radius:15px;border:none;' class='a'><table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:40px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;'>
".$tracker_lang['nothing_found']."</td></tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table><br>");
}elseif(isset($jescrsearchstr)){print("<table style='margin-top:7px;background:none;cellspacing:0;cellpadding:0;width:300px;float:center;'><tr>
<td style='border-radius:15px;border:none;' class='a'><table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:40px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;'>
".$tracker_lang['nothing_found']."</td></tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table><br>");
}elseif(isset($descrsearchstr)){print("<table style='margin-top:7px;background:none;cellspacing:0;cellpadding:0;width:300px;float:center;'><tr>
<td style='border-radius:15px;border:none;' class='a'><table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:40px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;'>
".$tracker_lang['nothing_found']."</td></tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table><br>");}
else{print("<table style='margin-top:7px;background:none;cellspacing:0;cellpadding:0;width:300px;float:center;'><tr>
<td style='border-radius:15px;border:none;' class='a'><table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:40px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;'>
".$tracker_lang['nothing_found']."</td></tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table><br>");}}
echo '</table>';stdfoot();?>
