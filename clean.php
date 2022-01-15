<?php require_once("include/bittorrent.php");dbconn(false, true);gzip();if($CURUSER && get_user_class() >= UC_MODERATOR){	
sql_query('TRUNCATE TABLE shoutbox') or sqlerr(__FILE__, __LINE__);
function clean(){stdmsg('Очистка прошла успешно.','Таблица чата была успешно очищена.');}clean();}else{?>
<html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>