<?php require_once("include/bittorrent.php");dbconn(false);gzip();if ($CURUSER && get_user_class() >= UC_SYSOP){$remove = $_GET['remove'] + 0; 
if($remove){sql_query("DELETE FROM bannedemails WHERE id = '$remove'") or sqlerr(__FILE__, __LINE__);
write_log("Емайл $remove был убран пользавателям $CURUSER[username]");} 
if($_SERVER["REQUEST_METHOD"] == "POST"){$email = trim($_POST["email"]);$comment = trim($_POST["comment"]);
if(!$email || !$comment) stderr2("Error", "Missing form data."); 
sql_query("INSERT INTO bannedemails (added, addedby, comment, email) VALUES(".sqlesc(get_date_time()).", ".sqlesc($CURUSER['id']).", ".sqlesc($comment).", ".sqlesc($email).")") or sqlerr(__FILE__, __LINE__);
header("Location: $_SERVER[REQUEST_URI]");die;} 
$res = sql_query("SELECT id, added, addedby, comment, email FROM bannedemails ORDER BY added DESC") or sqlerr(__FILE__, __LINE__); 
stdhead("Разрешенные Емайлы");begin_frame(".:: Разрешенные Емайлы ::.");if(mysql_num_rows($res) == 0){print("<p align='center'><b>Пусто</b></p>");}else{ 
print("<table border='0' width='100%' cellspacing='0' cellpadding='5'><tr><td class='zaliwka' style='color:#FFFFFF;text-align:center;'>Дата</td>
<td class='zaliwka' style='color:#FFFFFF;text-align:center;'>Email</td><td class='zaliwka' style='color:#FFFFFF;text-align:center;'>Кем</td>
<td class='zaliwka' style='color:#FFFFFF;text-align:center;'>Коментарий</td><td class='zaliwka' style='color:#FFFFFF;text-align:center;'>Убрать Емайл</td></tr>"); 
while($arr = mysql_fetch_assoc($res)){$r2 = mysql_query("SELECT username, class FROM users WHERE id = ".$arr['addedby']) or sqlerr(__FILE__, __LINE__);$a2 = mysql_fetch_assoc($r2); 
print("<tr><td align='center'>".$arr['added']."</td><td align='center'>".$arr['email']."</td><td align='center'>
<a href='user_".$arr['addedby']."'>".get_user_class_color($a2['class'], $a2['username'])."</a></td><td align='center'>".$arr['comment']."</td><td align='center'>
<a title='Убрать Емайл' href='bannedemails.php?remove=".$arr['id']."'><font color='red'><b>Убрать Емайл</b></font></a></td></tr>");}print("</table>");}
print("<br><table border='0' width='100%' cellspacing='0' cellpadding='5'><h2>Добавить Разрешенный Емайл  :: Изпользуйте *@email.com чтобы разрешить весь домен</h2>
<form method='post' action='bannedemails.php'><tr><td style='border:0;'><center><b>Email:</b>&nbsp;&nbsp;<input type='text' name='email' size='40'>&nbsp;&nbsp;&nbsp;&nbsp;
<b>Коментарий:</b>&nbsp;&nbsp;<input type='text' name='comment' size='40'>&nbsp;&nbsp;<input type='submit' value='Разрешить' class='btn'></center></td></tr></form></table>"); 
end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>