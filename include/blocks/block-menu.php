<?php if(!defined('BLOCK_FILE')){Header("Location: ../index.php");exit;}global $tracker_lang;$blocktitle = ".:: Навигация ::.";
$content = "<a class='menu' href='zakaz.php'>&nbsp;&nbsp;»&nbsp;Стол Заказов</a>
<a class='menu' href='comments'>&nbsp;&nbsp;»&nbsp;Комментарии</a>
<a class='menu' href='topten'>&nbsp;&nbsp;»&nbsp;ТОП Сайта</a>
<a class='menu' href='formats'>&nbsp;&nbsp;»&nbsp;".$tracker_lang['formats']."</a>
<a class='menu' href='video'>&nbsp;&nbsp;»&nbsp;Качество Видео</a><a class='menu' href='tags'>&nbsp;&nbsp;»&nbsp;Теги</a>
<a class='menu' href='testport'>&nbsp;&nbsp;»&nbsp;Проверка порта</a>";?>