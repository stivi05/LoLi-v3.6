<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && get_user_class() >= UC_MODERATOR){
$delete = intval($_GET['delete']);if (is_valid_id($delete)){mysql_query("DELETE FROM loginattempts WHERE id=$delete") or sqlerr(__FILE__, __LINE__);}
$ban = intval($_GET['ban']);if (is_valid_id($ban)){mysql_query("UPDATE loginattempts SET banned = 'yes' WHERE id=$ban") or sqlerr(__FILE__, __LINE__);}
$unban = intval($_GET['unban']);if (is_valid_id($unban)){mysql_query("UPDATE loginattempts SET banned = 'no' WHERE id=$unban") or sqlerr(__FILE__, __LINE__);}
stdhead ("Попытки входа на сайт с баном по IP");if (get_user_class() >= UC_ADMINISTRATOR){$clenchat = ":: <a class=altlink href='clear_maxlogin.php?action=clear'><b>Oчистить таблицу</b></a> ";}
begin_frame(".:: Попытки входа на сайт с баном по IP $clenchat::.");
print("<table border=1 cellspacing=0 cellpadding=5 width=100%>"); 
$res = mysql_query("SELECT * FROM  loginattempts ORDER BY added DESC") or sqlerr(__FILE__,__LINE__);if (mysql_num_rows($res) == 0){
print("<tr><td colspan=2><center><b>Нет записей на попытки входа</b></center></td></tr>");}else{   
print("<tr><td class='colhead' align='center'>№</td><td class='colhead' align='center'>IP и Логин (если нашелся для этого IP)</td>
<td class='colhead' align='center'>Время последнего входа</td><td class='colhead' align='center'>Попыток входа</td><td class='colhead' align='center'>Статус</td></tr>"); 
while ($arr = mysql_fetch_assoc($res)){ 
$r2 = mysql_query("SELECT id,username FROM users WHERE ip=".sqlesc($arr[ip])) or sqlerr(__FILE__,__LINE__);$a2 = mysql_fetch_assoc($r2);     
print("<tr><td align='center'>$arr[id]</td>
<td align='center'>$arr[ip]".($a2[id] ? "<a href=users_$a2[id]>" : "")." ".($a2[username] ? "($a2[username])</a>" : "")."</td><td align='center'>$arr[added]</td>
<td align='center'>$arr[attempts]</td><td align='center'>".($arr[banned] == "yes" ? "<font color=red><b><u>Забанен</u></b></font>&nbsp;&nbsp;||&nbsp;&nbsp;
<a href=maxlogin.php?unban=$arr[id]><font color=green><b>Снять БАН</b></font></a>" : "<font color=green><b><u>Не забанен</u></b></font>&nbsp;
&nbsp;||&nbsp;&nbsp;<a href=maxlogin.php?ban=$arr[id]><font color=red><b>Забанить</b></font></a>")."&nbsp;&nbsp;||&nbsp;&nbsp;
<a OnClick=\"return confirm('Вы точно хотите удалить эту запись?');\" href=maxlogin.php?delete=$arr[id]><b>Удалить</b></a></td></tr>"); 
}}print("</table>");end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>