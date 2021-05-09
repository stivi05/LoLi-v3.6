<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
function bark($msg){?><html><head><meta http-equiv='refresh' content='8;url=browse'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">
<?=stderr2("Error", $msg);?></body></html><?}if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
$id = (int)$_POST['id'];if(empty($id))bark("Торрент не выбран !");$type = $_POST['type'];$page = $_POST['page'];
if(!isset($id) && !isset($type) && !isset($page)) bark($tracker_lang['torrent_not_selected']);if($type == 'add'){
$res = sql_query("SELECT name FROM torrents WHERE id = ".$id."") or sqlerr(__FILE__, __LINE__);$arr = mysql_fetch_array($res);
if((get_row_count("bookmarks", "WHERE userid = ".sqlesc($CURUSER['id'])." AND torrentid = ".sqlesc($id)."")) > 0) bark("Уже в закладках");
sql_query("INSERT INTO bookmarks (userid, torrentid) VALUES (".sqlesc($CURUSER['id']).", ".sqlesc($id).")") or sqlerr(__FILE__,__LINE__);
if($page == "details") echo '<img src="pic/delbook.png" style="border:none;margin-top:-3px;" title="Убрать из избранного" onclick="bookmark('.$id.', \'del\' , \'details\');">';
elseif($page == "browse") echo '<img src="pic/delbook.png" style="border:0;background:none;margin-top:7px;margin-right:10px;" title="Убрать из избранного" onclick="bookmark('.$id.', \'del\' , \'browse\');">';die();}
if($type == 'del'){
$res = sql_query("SELECT name FROM torrents WHERE id = ".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);$arr = mysql_fetch_array($res);
if((get_row_count("bookmarks", "WHERE userid = ".sqlesc($CURUSER['id'])." AND torrentid = ".$id."")) < 0) bark("Нету в закладках");
sql_query("DELETE FROM bookmarks WHERE torrentid='".sqlesc($id)."' AND userid='".sqlesc($CURUSER['id'])."' ") or sqlerr(__FILE__,__LINE__);
if($page == "details") echo '<img src="pic/addbook.png" style="border:none;margin-top:-3px;" title="Добавить в избранное" onclick="bookmark('.$id.', \'add\' , \'details\');">';
elseif($page == "browse") echo '<img src="pic/addbook.png" style="border:0;background:none;margin-top:7px;margin-right:10px;" title="Добавить в избранное" onclick="bookmark('.$id.', \'add\' , \'browse\');">';		
die();}}else{stderr2("Error", "<center><b>Торрент не выбран !<b></center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");}}else{?>
<html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>