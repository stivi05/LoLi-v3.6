<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
stdhead("Мои релизы");begin_frame(".:: Мои релизы ::.");
$res = sql_query("SELECT COUNT(id) FROM torrents WHERE owner = ".$CURUSER["id"]);$row = mysql_fetch_array($res);$count = $row[0];if(!$count){
stdmsg("<center>".$tracker_lang['error']."</center>", "<center>Вы не загружали торренты на этот трекер.</center><html><head><meta http-equiv=refresh content='4;url=/'></head></html>");
}else{?><script src="js/bookmarks.js"></script><script src="js/jquery.js"></script><table class="embedded" cellspacing="0" cellpadding="3" width="100%"><?
list($pagertop, $pagerbottom, $limit) = pager(20, $count, "mytorrents.php?");
$res = sql_query("SELECT torrents.incategory, torrents.owner, torrents.leechers, torrents.remote_leechers, torrents.seeders, torrents.remote_seeders, 
torrents.multitracker, torrents.not_sticky, torrents.id, torrents.name, torrents.added, torrents.size, torrents.free, torrents.description, c.name AS cat_name, c.image AS cat_pic, 
i.name AS incat_name, i.image AS incat_pic, torrents.category FROM torrents LEFT JOIN categories AS c ON torrents.category = c.id LEFT JOIN incategories AS i ON torrents.incategory = i.id 
WHERE owner = ".$CURUSER["id"]." ORDER BY id DESC $limit");
print("<tr><td class=\"index\" colspan=\"12\"><center>".$pagertop."</center></td></tr>");torrenttable($res, "mytorrents");
print("<tr><td class=\"index\" colspan=\"12\"><center>".$pagerbottom."</center></td></tr></table>");}
end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>