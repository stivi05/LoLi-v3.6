<?php require_once("include/bittorrent.php");dbconn(true);gzip();$passkey = (string) $_GET["passkey"];if(!$passkey){
if($CURUSER){stderr2("Error", "<center>A <b>passkey</b> где?!</center><html><head><meta http-equiv=refresh content='8;url=/'></head>");
}else{stderrs("Error", "<center>A <b>passkey</b> где?!</center><html><head><meta http-equiv=refresh content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");
}}elseif($passkey){$user = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM users WHERE passkey = ".sqlesc($passkey)));if($user[0] != 1){
if($CURUSER){stderr2("Error", "<center><b>passkey</b> не верный!</center><html><head><meta http-equiv=refresh content='8;url=/'></head>");
}else{stderrs("Error", "<center><b>passkey</b> не верный!</center><html><head><meta http-equiv=refresh content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");
}}else{$feed = $_GET["feed"];$res = mysql_query("SELECT id, name FROM categories");while($cat = mysql_fetch_assoc($res))$category[$cat['id']] = $cat['name'];
$resi = mysql_query("SELECT id, name FROM incategories");while($incat = mysql_fetch_assoc($resi))$incategory[$incat['id']] = $incat['name'];
$DESCR = "RSS Feeds";if($_GET['cat'])$cats = explode(",", $_GET["cat"]);if($cats)$where = "WHERE category IN (".implode(", ", array_map("sqlesc", $cats)).") AND";
header("Content-Type: application/xml");
$zapros = mysql_query("SELECT added FROM `torrents` ORDER BY `added` DESC LIMIT 1");while($arr = mysql_fetch_array($zapros))$added = $arr['added'];
print("<?xml version=\"1.0\" encoding=\"utf-8\"?><rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\"><channel><atom:link href=\"".$DEFAULTBASEURL."/rss.php\" rel=\"self\" type=\"application/rss+xml\" /><title>".$SITENAME."</title><link>".$DEFAULTBASEURL."</link><description>".$DESCR."</description><image><url>".$DEFAULTBASEURL."/pic/rssfeeds.png</url><link>".$DEFAULTBASEURL."</link><title>RSS-канал</title></image><lastBuildDate>".gmdate("D, d M Y H:i:s", strtotime($added))." GMT</lastBuildDate>");
$res = mysql_query("SELECT id,name,descr,filename,size,category,incategory,added,images_sm FROM torrents $where ORDER BY added DESC LIMIT 15") or sqlerr(__FILE__, __LINE__);
while($row = mysql_fetch_row($res)){list($id,$name,$descr,$filename,$size,$cat,$incat,$added,$images_sm) = $row;
if($feed == "dl")$link = $DEFAULTBASEURL."/download_$id".($passkey ? "&amp;passkey=$passkey" : "")."&amp;name=$filename";else $link = $DEFAULTBASEURL."/details_$id&amp;hit=1";
echo("<item><title>".$name."</title><link>".$link."</link><description><![CDATA[ <img border='none' src='$DEFAULTBASEURL/torrents/images_sm/$images_sm'/>
<br>".format_comment($descr)."<hr width='250' align='left'><font size='1' color='grey'><b>Релиз залит:</b>&nbsp;<i>".nicetime($added, true)."</i> -||- <b>Жанр:</b> 
".$category[$cat]."  -||- <b>Качество:</b> ".$incategory[$incat]." -||- <b>Размер:</b> ".mksize($size)."</font><hr width ='500' align='left'>]]></description><pubDate>
".gmdate("D, d M Y H:i:s", strtotime($added))." GMT</pubDate><guid>".$link."</guid></item>");}echo("</channel></rss>");}}?>