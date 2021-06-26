<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){stdhead($tracker_lang['bookmarks']." релизов");?>
<table style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'><tr>
<td style='border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:25px;font-weight:bold;font-family:cursive;font-size:14px;text-align:center;border:0;border-radius:5px;'>
::: <?=$tracker_lang['bookmarks'];?> релизов ::.</td></tr></table></td></tr></table><?                                                                              
$ress = sql_query("SELECT COUNT(id) FROM bookmarks WHERE userid = ".sqlesc($CURUSER["id"]));$row = mysql_fetch_array($ress);$count = $row[0];
if(!$count){print("<table style='margin-top:7px;background:none;' width='280px' border='0'><td style='border-radius:10px;' class='b'><center>
<font style='font-family:tahoma;font-size:22px;font-weight:10;color:red;'><b>".$tracker_lang['you_have_no_bookmarks']."!</b></font></td></table>
<html><head><meta http-equiv=refresh content='5;url=/'></head></html>");}else{?><script src="js/bookmarks.js"></script><?
$perpage = 25;list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, "bookmarks.php?");
$res = sql_query("SELECT b.id AS bookmarkid, t.*, c.name AS cat_name, c.image AS cat_pic, i.name AS incat_name, i.image AS incat_pic, b.userid, snatched.userid AS suid, u.username, u.class FROM bookmarks b LEFT JOIN categories AS c ON t.category = c.id LEFT JOIN incategories AS i ON t.incategory = i.id LEFT JOIN torrents t ON b.torrentid = t.id 
LEFT JOIN users AS u ON t.owner = u.id LEFT JOIN snatched ON snatched.userid = ".sqlesc($CURUSER["id"])." AND snatched.torrent = b.torrentid WHERE 
b.userid = ".sqlesc($CURUSER["id"])." ORDER BY b.torrentid DESC $limit") or sqlerr(__FILE__, __LINE__);
if($count > 10){print("<table id='pager' style='margin-top:7px;background:none;border:0;' class='embedded' cellspacing='0' cellpadding='0' width='100%'>
<tr><td style='border:0;' class='index' colspan='12'><center>".$pagertop."</center></td></tr></table>");}?>
<table style="background:none;width:100%;float:center;border:0;"><?torrenttable($res, "bookmarks"); 
print("</table><table id='pager' style='margin-top:7px;background:none;border:0;' class='embedded' cellspacing='0' cellpadding='0' width='100%'>
<tr><td style='border:0;' class='index' colspan='12'><center>".$pagerbottom."</center></td></tr></table>");}
stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
