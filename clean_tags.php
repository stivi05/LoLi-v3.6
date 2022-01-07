<?php require_once("include/bittorrent.php");dbconn(true);gzip();if ($CURUSER && get_user_class() >= UC_ADMINISTRATOR){
$action = ($_POST['action'] ? $_POST['action'] : ($_GET['action'] ? $_GET['action'] : 'start')); 
if($action == 'clean_tags'){sql_query('TRUNCATE TABLE tags') or sqlerr(__FILE__, __LINE__);sql_query('TRUNCATE TABLE browse') or sqlerr(__FILE__, __LINE__);
sql_query('INSERT INTO tags (id, name, keywords, description, not_sticky, image1, free, multitracker, seeders, added) SELECT id, name, keywords, description, 
not_sticky, image1, free, multitracker, seeders, added FROM torrents') or sqlerr(__FILE__, __LINE__);
sql_query('INSERT INTO browse (id, name, description, category, incategory, voice, size, added, comments, leechers, remote_leechers, seeders, remote_seeders, 
owner, free, not_sticky, multitracker, dostup, updatess) SELECT id, name, description, category, incategory, size, added, comments, leechers, 
remote_leechers, seeders, remote_seeders, owner, free, not_sticky, multitracker, dostup, updatess FROM torrents') or sqlerr(__FILE__, __LINE__);
header("Refresh: 3; url=browse");
stderr2('<center><b>Таблицы тегов и торрентов были успешно очищены и обновлены.</b></center>','<center><b>Таблица Тегов и Торрентов были успешно очищены и обновлены. Сейчас вы будете возвращены в Browse.</b></center>'); 
}elseif($action == 'start'){ 
stderr2('<center><b>Обновить таблицы</b></center>','<center>Нажмите <a href="'.$_SERVER['SCRIPT_NAME'].'?action=clean_tags">сюда</a> что-бы очистить и обновить таблицы Тегов и Торрентов.</center>',false); 
}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
