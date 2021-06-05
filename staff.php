<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){stdhead("Команда");?>
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:30px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
.:: Команда ::.</td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;">
<font color='RED'><b>Вопросы, на которые есть ответы в правилах или FAQ, будут оставлены без внимания.</b></font><hr width='600px'>
<b>01.</b>&nbsp;Не просить звания <b><font color='red'>Модератор</font></b>, <b><font color='#339900'>Администратор</font></b>.&nbsp;
Мы сами решаем кому давать повышение.<br>
<b>02.</b>&nbsp;Хотите создавать раздачи на нашем сайте и носить звание&nbsp;<b><font color='#FF9900'>Аплоадер</font></b>,&nbsp;подавайте заявку на&nbsp;
<a href='uploader'><font color='#FF9900'><b>Релизер</b></font></a>.<br>Если вы умеете, а главное хотите создавать раздачи, мы вам не откажем.</td></tr></table></td></tr></table>
<table style="margin-top:5px;background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><?
global $CacheBlock, $staffBlock_Refresh, $staffsBlock_Refresh;$_cache = 'staff.cache';$_cacher = 'staffs.cache';
if(!$CacheBlock->Check($_cache, $staffBlock_Refresh?0:3600)){$dt = gmtime() - 300;$dt = sqlesc(get_date_time($dt));
$res = sql_query("SELECT users.id, users.avatar, users.country, users.gender, users.username, users.class, users.last_access, c.name, c.flagpic FROM users 
LEFT JOIN countries AS c ON c.id = users.country WHERE users.class>=".UC_UPLOADER." AND users.status='confirmed' ORDER BY users.username" ) or sqlerr(__FILE__, __LINE__);
while($arr = mysql_fetch_assoc($res)){
if($arr['country'] > 0){$country = "<img src='pic/flag/".$arr['flagpic']."' alt='".$arr['name']."' title='".$arr['name']."'/>";}else{$country = "<Не указанно";}
if(!$arr['avatar']){$avatar=("<a href='userdetails.php?id=".$arr['id']."'><img style='border-radius:5px;border:0;height:50px;' title='".$arr['username']."' src='pic/default_avatar.gif'/></a>");}
else{$avatar=("<a href='userdetails.php?id=".$arr['id']."'><img style='border-radius:5px;border:0;height:50px;' src='".$arr['avatar']."' title='".$arr['username']."'/></a>");}
if($arr['gender'] == '1'){$gender = "<img src='pic/male1.gif' alt='Парень' style='margin-left:4pt;'/>";}
elseif($arr['gender'] == '2'){$gender = "<img src='pic/female1.gif' alt='Девушка' style='margin-left:4pt;'/>";}
elseif($arr['gender'] == '3'){$gender = "<img src='pic/transgenders.gif' alt='Не определился' style='margin-left:4pt;'/>";}
$staff_table[$arr['class']] = $staff_table[$arr['class']]."<td style='padding:5px;width:240px;height:75px;background:none;'><table style='background:none;'border='0' cellspacing='0'><tr>
<td style='border-radius:10px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:2px solid #E0FFFF;display:block;padding:10px;width:240px;height:75px;' class='a'>
<table style='background:none;align:center;border:0;' width='240px'><tr><td class='embedded' width='60px' style='background:none;align:center;border:0;'><center>$avatar</center></td>
<td class='embedded' valign='top' align='center' style='background:none;border:0;'><center>
<a class='altlink' href='userdetails.php?id=".$arr['id']."'><b>".get_user_class_color($arr['class'],$arr['username'])."</b></a>".($arr["donated"] > 0 ? "
<img src='pic/star.gif' border='0' alt='Donor'/>" : "")."&nbsp;&nbsp;$gender<hr width='140px'>
".("'".$arr['last_access']."'">$dt?"<img src='pic/button_online.gif' border='0' alt='online'/>":"<img src='pic/button_offline.gif' border='0' alt='offline'/>" )."&nbsp;&nbsp;
<a href='#' onclick=\"javascript:window.open('sendpm.php?action=sendmessage&receiver=".$arr['id']."', 'Отправить PM', 'width=650px, height=465px');return false;\" title='Отправить ЛС'><img src='pic/pn_inbox.gif' border='0' title='PM'/></a>
&nbsp;&nbsp;$country</center></td></tr></table><hr width='200px'><table style='background:none;border:0;' width='240px'><center>
<b>Последний визит:</b>&nbsp;<font color='blue'><b>".get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["last_access"]))." ".$tracker_lang['ago']."</b></font></center></table>
</td></tr></table></td>";
++$col[$arr['class']];if($col[$arr['class']]<=4) $staff_table[$arr['class']]=$staff_table[$arr['class']]."";
else{$staff_table[$arr['class']]=$staff_table[$arr['class']]."</tr><tr>";$col[$arr['class']]=0;}}
$content.= "<tr><td style='border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td class='zaliwka' style='colspan:14;height:20px;;border:0;border-radius:5px;'>
<table style='background:none;width:100%;float:center;border:0;'><tr>
<td style='background:none;font-family:tahoma;width:100%;font-size:14px;font-weight:bold;color:#FFFFFF;margin-left:10px;letter-spacing:0;text-align:center;float:center;border:0;'>
.:: Администрация ::.</td></tr></table></td></tr><tr><td align='left' style='background:none;width:100%;float:center;border:0;'></td></tr></table>
</td></tr></table><table style='background:none;margin-top:3px;cellspacing:0;cellpadding:0;width:100%;float:center;'><tr>".$staff_table[UC_SYSOP]."</tr>";
if($staff_table[UC_ADMINISTRATOR]){$content.= "<tr>".$staff_table[UC_ADMINISTRATOR]."</tr>";}
if($staff_table[UC_MODERATOR]){$content.= "<tr>".$staff_table[UC_MODERATOR]."</tr>";}
$content.= "</table><table style='background:none;margin-top:3px;cellspacing:0;cellpadding:0;width:100%;float:center;'>
<tr><td style='border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td class='zaliwka' style='colspan:14;height:20px;;border:0;border-radius:5px;'>
<table style='background:none;width:100%;float:center;border:0;'><tr>
<td style='background:none;font-family:tahoma;width:100%;font-size:14px;font-weight:bold;color:#FFFFFF;margin-left:10px;letter-spacing:0;text-align:center;float:center;border:0;'>
.:: Аплоадеры ::.</td></tr></table></td></tr><tr><td align='left' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr>
</table><table style='background:none;margin-top:3px;cellspacing:0;cellpadding:0;width:100%;float:center;'><tr>".$staff_table[UC_UPLOADER]."</tr>";
$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);print ($content."</table>");?>
<table style="margin-top:5px;background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style='border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td class='zaliwka' style='colspan:14;height:20px;;border:0;border-radius:5px;'>
<table style='background:none;width:100%;float:center;border:0;'><tr>
<td style='background:none;font-family:tahoma;width:100%;font-size:14px;font-weight:bold;color:#FFFFFF;margin-left:10px;letter-spacing:0;text-align:center;float:center;border:0;'>
.:: Первая линия поддержки ::.</td></tr></table></td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;">
<font color='RED'><b>Общие вопросы лучше задавать этим пользователям. Учтите что они добровольцы, тратящие свое время и силы на помощь вам. Относитесь к ним подобающе.
</b></font></td></tr></table></td></tr></table><table style="margin-top:5px;background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><?
if(!$CacheBlock->Check($_cacher, $staffsBlock_Refresh?0:3600)){
$resd = sql_query("SELECT users.id, users.username, users.gender, users.class, users.avatar, users.country, users.last_access, users.supportfor, c.name, c.flagpic 
FROM users LEFT JOIN countries AS c ON c.id = users.country WHERE users.support='yes' AND users.status='confirmed' ORDER BY users.username LIMIT 10") or sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($resd)){
if($arr['country'] > 0){$country = "<img src='pic/flag/".$arr['flagpic']."' alt='".$arr['name']."' title='".$arr['name']."'/>";}else{$country = "<Не указанно";}
if(!$arr['avatar']){$avatar=("<a href='userdetails.php?id=".$arr['id']."'><img style='border-radius:5px;border:0;height:50px;' title='".$arr['username']."' src='pic/default_avatar.gif'/></a>");}
else{$avatar=("<a href='userdetails.php?id=".$arr['id']."'><img style='border-radius:5px;border:0;height:50px;' src='".$arr['avatar']."' title='".$arr['username']."'/></a>");}
if($arr['gender'] == '1'){$gender = "<img src='pic/male1.gif' alt='Парень' style='margin-left:4pt;'/>";}
elseif($arr['gender'] == '2'){$gender = "<img src='pic/female1.gif' alt='Девушка' style='margin-left:4pt;'/>";}
elseif($arr['gender'] == '3'){$gender = "<img src='pic/transgenders.gif' alt='Не определился' style='margin-left:4pt;'/>";}
$firstline .= "<td style='padding:5px;width:300px;height:100px;background:none;'><table style='background:none;'border='0' cellspacing='0'><tr>
<td style='border-radius:10px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:2px solid #E0FFFF;display:block;padding:10px;width:300px;height:100px;' class='a'>
<table style='background:none;align:center;border:0;' width='300px'><tr><td class='embedded' height='55px' style='background:none;align:center;border:0;'><center>$avatar
</center></td><td class='embedded' valign='top' align='center' style='background:none;border:0;'><center>
<a class='altlink' href='userdetails.php?id=".$arr['id']."'><b>".get_user_class_color($arr['class'],$arr['username'])."</b></a>".($arr["donated"] > 0 ? "
<img src='pic/star.gif' border='0' alt='Donor'/>" : "")."&nbsp;&nbsp;$gender<hr width='180px'>
".("'".$arr['last_access']."'">$dt?"<img src='pic/button_online.gif' border='0' alt='online'/>":"<img src='pic/button_offline.gif' border='0' alt='offline'/>" )."&nbsp;&nbsp;
<a href='#' onclick=\"javascript:window.open('sendpm.php?action=sendmessage&receiver=".$arr['id']."', 'Отправить PM', 'width=650px, height=465px');return false;\" title='Отправить ЛС'><img src='pic/pn_inbox.gif' border='0' title='PM'/></a>
&nbsp;&nbsp;$country</center></td></tr></table><hr width='260px'><table style=\"background:none;border:0;\" width='290px'><center>
<b>Последний визит:</b>&nbsp;<font color='blue'><b>".get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["last_access"]))." ".$tracker_lang['ago']."</b></font>
<hr width='260px'><font color='darkgreen'><b>".$arr['supportfor']."</b></font></center></table></td></tr></table></td>";}
$CacheBlock->Write($_cacher, $firstline);}else $firstline = $CacheBlock->Read($_cacher);echo "<tr>".$firstline."</tr></table>";
if(get_user_class() >= UC_MODERATOR){?><table style="margin-top:5px;background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:30px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
.:: Панель Модератора<font color='#FF0000'> - Видно только Модераторам</font> ::.</td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;">
<table width='100%' cellspacing='10' align='center'><tr>
<td class='embedded'><center><form method='get' action='staffmess.php'><input type='submit' value="Масовое ПМ" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='unco.php'><input type='submit' value="Неподтв. юзеры" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='top.php'><input type='submit' value="Top 10" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='findnotconnectable.php'><input type='submit' value="Юзеры за NAT" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='log.php'><input type='submit' value="Лог сайта" style='height:20px;width:100px'></form></center></td></tr><tr>
<td class='embedded'><center><form method='get' action='last_users.php'><input type='submit' value="Новички" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='baned_users.php'><input type='submit' value="Отключеные" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='small_raiting.php'><input type='submit' value="Малый Рейтинг" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='testip.php'><input type='submit' value="Проверка IP" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='uploaders.php'><input type='submit' value="Аплоадеры" style='height:20px;width:100px'></form></center></td></tr><tr>
<td class='embedded'><center><form method='get' action='users.php'><input type='submit' value="Список юзеров" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='tags.php'><input type='submit' value="Теги" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='smilies.php'><input type='submit' value="Смайлы" style='height:20px;width:100px'></form></center></td></tr></table><br>
<table width='100%' cellspacing='3'><tr><td class='embedded'><center><form method='get' action="users.php">Поиск:&nbsp;&nbsp;<input type='text' size='30' name='search'>&nbsp;&nbsp;
<select name='class'><option value='-'>(Выберите)</option><option value='0'>Пользователь</option><option value='1'>Опытный пользователь</option><option value='2'>VIP</option>
<option value='3'>Аплоадер</option><option value='4'>Модератор</option><option value=''>Администратор</option></select>&nbsp;&nbsp;<input type='submit' value='Искать'></form>
</center></td></tr><tr><td class='embedded'><center><a href="usersearch.php">Административный поиск</a></center></td></tr></table></td></tr></table></td></tr></table><?}
stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
