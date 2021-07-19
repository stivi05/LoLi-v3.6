<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){$id = intval($_GET["id"]);
if(!is_valid_id($id))stderr2("<center>Error!</center>", "<center>Нет такого пользователя.</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
$cache = new Memcache();$cache->connect('127.0.0.1', 11211); // IP вашего сервера и порт Мемкеша
$row = array();if(!$row = $cache->get('user_cache_'.$id)){$res = mysql_query('SELECT * FROM users WHERE id = '.sqlesc($id)) or err('There is no user with this ID');
$row = mysql_fetch_array($res);$cache->set('user_cache_'.$id, $row, MEMCACHE_COMPRESSED, 1800);}
if($row["id"] != $id) stderr2("<center>Error!</center>", "<center>Нет пользователя с таким ID $id.</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
if($id == "1" && get_user_class() < UC_SYSOP && $id != $CURUSER["id"]){stdhead("Просмотр профиля");begin_frame(".:: Просмотр профиля ::.");?>
<table width="100%"><br><center><font color="red"><b>Вам запрещено просматривать этот профиль.</b></font></center><br></table>
<? end_frame();stdfoot();}else{	
if($CURUSER["id"] == $id){$edites = "<a href='usercp'><img title='Edit profile' style='border:0;float:left;margin-left:40px;' src='pic/button_edit.gif'></a>";}
stdhead("Просмотр профиля ".$row["username"]);begin_frame($edites.".:: Просмотр профиля ".$row["username"]." ::.");
?><script src="js/jquerytab.js"></script><script src="js/js_global.js"></script><link rel="stylesheet" href="css/faq.css">
<script>$(function(){$("#tabs").tabs({remote: true})});</script><?if(get_user_class() >= UC_MODERATOR){?><table border="0" cellspacing="0" cellpadding="0" width="100%">
<? print("<tr><td class=\"a\" align=\"center\"><a href=\"#\" onclick=\"location.href='pass_users.php?to=pre&from=".$id."'; return false;\"><b><< Предыдущий Пользователь</b></a>
</td><td class=\"b\" align=\"center\"><a href=\"#\" onclick=\"location.href='pass_users.php?to=next&from=".$id."'; return false;\"><b>Следующий Пользователь >></b></a></td></tr>");?>
</table><?}?><table border="0" cellspacing="0" cellpadding="0" width="100%"><div id="tabs"><ul><li><a href="user_details.php?id=<?=$id?>&info=info">Профиль</a></li>
<? if(get_user_class() >= UC_MODERATOR){?><li><a href="user_details.php?id=<?=$id?>&info=edit">Редактирование Пользователя</a></li><?}?></ul></div>
</table><?end_frame();stdfoot();}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>