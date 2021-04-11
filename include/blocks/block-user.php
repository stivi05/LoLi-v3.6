<?php if(!defined('BLOCK_FILE')) {Header("Location: ../index.php");exit;}global $CURUSER,$tracker_lang;
$blocktitle = $tracker_lang['welcome_back'].($CURUSER ? "<a href='user_".$CURUSER["id"]."'>".get_user_class_color($CURUSER ["class"], $CURUSER ["username"])."</a>
&nbsp;".$usrclass."&nbsp;" : "Гость").$medaldon.$warn;
if($CURUSER['donor'] == "yes") $medaldon = "<img src='pic/star.gif' alt='Спонсор' title='Спонсор'>";
if($CURUSER['warned'] == "yes")$warn = "<img src='pic/warned.gif' alt='Предупреждён' title='Предупреждён'>";
$content .= "<center><a href='usercp'><img src='".($CURUSER["avatar"] ? $CURUSER["avatar"] : "pic/noavatar5.gif")."' 
width='100' alt='".$tracker_lang['avatar']."' title='".$tracker_lang['avatar']."' border='0'/></a></center><br><center>
<img src='pic/disabled.gif' border='0' />&nbsp;[<a href='logout'>".$tracker_lang['logout']."</a>]</center>";
if($CURUSER['override_class'] != 255)
$usrclass = "&nbsp;<img src='pic/warning.gif' title='".get_user_class_name($CURUSER['class'])."' alt='".get_user_class_name($CURUSER['class'])."'>&nbsp;";
elseif(get_user_class() >= UC_MODERATOR) $usrclass = "&nbsp;<a href='sclass'>
<img src='pic/warning.gif' title='".get_user_class_name($CURUSER['class'])."' alt='".get_user_class_name($CURUSER['class'])."' border='0'></a>&nbsp;";?> 