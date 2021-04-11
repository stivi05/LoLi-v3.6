<?php if(!defined('BLOCK_FILE')){Header("Location: ../index.php");exit;}global $CURUSER,$tracker_lang;$blocktitle = ".:: Личное Меню ::.";
$content = "<a class='menu' href='usercp'>&nbsp;&nbsp;»&nbsp;<b>Личный Кабинет</b></a>
<a class='menu' href='user_".$CURUSER["id"]."'>&nbsp;&nbsp;»&nbsp;".$tracker_lang['profile']."</a>
<a class='menu' href='bookmarks'>&nbsp;&nbsp;»&nbsp;".$tracker_lang['bookmarks']."</a>
<a class='menu' href='mybonus'>&nbsp;&nbsp;»&nbsp;".$tracker_lang['my_bonus']."</a>
<a class='menu' href='bonuscode'>&nbsp;&nbsp;»&nbsp;Бонусы от System</a>
<a class='menu' href='uploader'>&nbsp;&nbsp;»&nbsp;Заявка на Аплоадер</a>
<a class='menu' href='invite'>&nbsp;&nbsp;»&nbsp;".$tracker_lang['invite']."</a>
<a class='menu' href='users'>&nbsp;&nbsp;»&nbsp;".$tracker_lang['users']."</a>
<a class='menu' href='friends'>&nbsp;&nbsp;»&nbsp;".$tracker_lang['personal_lists']."</a>
<a class='menu' href='subnet'>&nbsp;&nbsp;»&nbsp;Сетевые Соседи</a>
<a class='menu' href='myrelease'>&nbsp;&nbsp;»&nbsp;".$tracker_lang['my_torrents']."</a>
<a class='menu' href='logout'>&nbsp;&nbsp;»&nbsp;".$tracker_lang['logout']."!</a>";?>