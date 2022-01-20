<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && get_user_class() >= UC_MODERATOR){
stdhead("Предупрежденные пользователи");$warned = number_format(get_row_count("users", "WHERE warned='yes'"));
begin_frame(".:: Предупрежденные пользователи: ($warned) ::.", true);
$res = mysql_query("SELECT * FROM users WHERE warned=1 AND enabled='yes' ORDER BY (users.uploaded/users.downloaded)") or sqlerr(__FILE__, __LINE__);$num = mysql_num_rows($res);
print("<table border='1' width='100%' cellspacing='0' cellpadding='2'><form action='nowarn.php' method='post'><tr align='center'><td class='zaliwka' width='90'>Пользователь</td>
<td class='zaliwka' width='70'>Зарегистрирован</td><td class='zaliwka' width='75'>Последний&nbsp;раз&nbsp;был&nbsp;на&nbsp;трекере</td>
<td class='zaliwka' width='75'>Класс</td><td class='zaliwka' width='70'>Закачал</td><td class='zaliwka' width='70'>Раздал</td><td class='zaliwka' width='45'>Рейтинг</td>
<td class='zaliwka' width='125'>Окончание</td><td class='zaliwka' width='65'>Убрать</td><td class='zaliwka' width='65'>Отключить</td></tr>");
for ($i = 1; $i <= $num; $i++){$arr = mysql_fetch_assoc($res);
if ($arr['added'] == '0000-00-00 00:00:00'){$arr['added'] = '-';}if ($arr['last_access'] == '0000-00-00 00:00:00'){$arr['last_access'] = '-';}
if($arr["downloaded"] != 0){$ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3);}else{$ratio="---";}
$ratio = "<font color=".get_ratio_color($ratio).">$ratio</font>";$uploaded = mksize($arr["uploaded"]);$downloaded = mksize($arr["downloaded"]);
$added = substr($arr['added'],0,10);$last_access = substr($arr['last_access'],0,10);$class=get_user_class_name($arr["class"]);
print("<tr><td align='center'><a href='user_$arr[id]'><b>$arr[username]</b></a>".($arr["donor"] =="yes" ? "<img src='pic/star.gif' border='0' alt='Donor'>" : "")."</td>
<td align='center'>$added</td><td align='center'>$last_access</td><td align='center'>$class</td><td align='center'>$downloaded</td>
<td align='center'>$uploaded</td><td align=center>$ratio</td><td align='center'>$arr[warneduntil]</td><td bgcolor='#008000' align='center'>
<input type='checkbox' name='usernw[]' value='$arr[id]'></td><td bgcolor='#FF000' align='center'><input type='checkbox' name='desact[]' value='$arr[id]'></td></tr>");}
if(get_user_class() >= UC_ADMINISTRATOR){print("<tr><td colspan='10' align='right'><input type='submit' class='btn' name='submit' value='Применить'></td></tr>");}
print("<input type='hidden' name='nowarned' value='nowarned'></form></table><p>$pagemenu<br>$browsemenu</p>");
end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>