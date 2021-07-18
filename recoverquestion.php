<?php require_once("include/bittorrent.php");dbconn(true);gzip();
if(isset($CURUSER)){if(isset($_POST['question']) && isset($_POST['answer'])){
$question=strip_tags($_POST['question']);$answer=strip_tags($_POST['answer']);
$query = "UPDATE users SET question='".$question."', answer='".$answer."' WHERE id=".$CURUSER['id'];
$sql = mysql_query($query)or die("s".mysql_error());header("Location: rqst?succeeded");}
stdhead("Установить вопрос и ответ.");begin_frame("Установить вопрос и ответ.");
$question = $CURUSER['question'];$answer = $CURUSER['answer'];if(isset($_GET['succeeded'])){
echo "<h3>Данные изменены!</h3><br><a href=\"rqst\"><input type='submit' value=\"Вернуться назад\" style='height:20px;width:150px'></a><br><br>";}else{
?><form action="rqst" method='post'><br><b>В случае утери Вашего пароля - Вы можете автоматически получить новый, ответив на Ваш секретный вопрос.<br>
Если вопрос Вами не указан - восстановление будет возможно только через администратора/модератора ресурса.<br>
<br>Настоятельно рекомендуется каждому установить себе подобный вопрос. Восстановление пароля происходит по этому же адресу.<br>
<br><h3><font color='red'>ВНИМАНИЕ! ОТВЕТ НА ВОПРОС НЕ ДОЛЖЕН ЗНАТЬ НИКТО, КРОМЕ ВАС!<br>И не должен состоять из Русских букв!</font></h3></b><br>
<center><u><b>Ваш вопрос:</b></u> <font color='red'><b><?=$question;?></b></font>, а ответ на него <font color='green'><b><?=$answer;?></b></font></center><br>
<table><tr><td align="center" style="border:0;"><b>Question (Вопрос):</b>&nbsp;<input type='text' name='question' size='80' placeholder="Изменить Вопрос?"></td></tr>
<tr><td align="center" style="border:0;"><b>Answer (Ответ):</b>&nbsp;<input type='text' name='answer' maxlength='25' placeholder="Изменить Ответ?">&nbsp;&nbsp;
<input type='submit' value="Создать"></td></tr></table></form><?}end_frame();stdfoot();exit;}else{failedloginschecks();?>
<html lang="ru"><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"><?
stdhead("Restore password!");$do = strip_tags($_GET['do']);switch($do){ 
case "": ?><td align="center" style="display:yes;position:fixed;margin-top:0px;" width="50%" border="0px">
<div style="display:yes;position:fixed;margin-top:200px;margin-left:470px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr>
<td align="center"><div style="padding:5px"><center><font color=#A52A2A><b>Restore password!</b></font></center></div></td></tr>
<tr><td align="left" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:left;">
<div style="padding-left:2px" align="center"><center><p>You <b><?=remainings();?></b> login attempts</p><br><form action="rqst?do=question" method='post'>
<center><table><tr><td style="border:0;"><b>Username:</b>&nbsp;<input type='text' name='username' maxlength='25'>&nbsp;&nbsp;
<input type='submit' value="Send"></td></tr></table></center></form></center><br><a href="/">
<input type='submit' value="Home" style='height:20px;width:100px'></a></div></td></tr></table></div></td><?break; 
//////////////////////
case "question": 
$username = strip_tags($_POST['username']);
$query = "SELECT id FROM users WHERE username='".$username."'";$sql = mysql_query($query)or die("saddd".mysql_error());
if(mysql_num_rows($sql)!==1)failedloginss();
$res = mysql_fetch_assoc($sql);$id = $res['id'];
$queryd = mysql_query("SELECT * FROM loginattempts WHERE userid=$id AND banned = 'yes'") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($queryd) > 0){$ip = sqlesc(getip());
mysql_query("UPDATE loginattempts SET ip = $ip WHERE userid = $id") or sqlerr(__FILE__, __LINE__);
stderr("You again?","<center>Access to password recovery for this user by question-answer is closed. You either forgot the answer, or a hacker. In any case, your IP is banned repeatedly.</center><html><head><meta http-equiv='refresh' content='4;url=/'></head><body style=\"background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;\"></body></html>");
}$query = "SELECT question FROM users WHERE id=".$id;$sql = mysql_query($query)or die("sss".mysql_error());$res = mysql_fetch_assoc($sql);
$question = strip_tags($res['question']);if($question==""){
$ip = sqlesc(getip());$added = sqlesc(get_date_time()); 
$a = (@mysql_fetch_row(@sql_query("select count(*) from loginattempts WHERE ip = $ip"))) or sqlerr(__FILE__, __LINE__); 
if($a[0] == 0) mysql_query("INSERT INTO loginattempts (ip, added, attemptss, userid) VALUES ($ip, $added, 1, $id)") or sqlerr(__FILE__, __LINE__); 
else mysql_query("UPDATE loginattempts SET attemptss = attemptss + 1, userid = $id WHERE ip = $ip") or sqlerr(__FILE__, __LINE__);
stderr("Restore failed!","<center><b>Error</b>: User has no security question!<br>Forgot your password? <b><a href='/'>Restore</a></b> it!</center><html><head><meta http-equiv='refresh' content='4;url=/'></head><body style=\"background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;\"></body></html>");}
//////////////////////////////
?><td align="center" style="display:yes;position:fixed;margin-top:0px;" width="50%" border="0px">
<div style="display:yes;position:fixed;margin-top:200px;margin-left:470px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" style="border:0;" width="400px" height="200px"><tr>
<td align="center"><div style="padding:5px"><center><font color='#A52A2A'><b>Restore password!</b></font></center></div></td></tr>
<tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:left;">
<div style="padding-left:2px" align="center"><center><p>You <b><?=remainings();?></b> login attempts</p><br>
<form action="rqst?do=answer" method='post'><table><tr>
<td align="center" style="border:0;"><b>Question:</b>&nbsp;<font color=#A52A2A><b><?=$question?></b></font>&nbsp;?<hr></td></tr>
<tr><td align="center" style="border:0;"><b>Answer:</b>&nbsp;<input type='text' name='answer' maxlength='25'>&nbsp;&nbsp;<input type='submit' value="Send">
<input type='hidden' name='id' value="<?=$id?>"></td></tr></table></form></center><br><a href="/">
<input type='submit' value="Home" style='height:20px;width:100px'></a></div></td></tr></table></div></td><?break; 
///////////////////////////
case "answer": 
$id = num($_POST['id']);
$answer = strip_tags($_POST['answer']);
$query = "SELECT answer, username FROM users WHERE id=".$id;
$sql = mysql_query($query)or die("sss".mysql_error());
$res = mysql_fetch_assoc($sql);
$realanswer = strip_tags($res['answer']);
if($answer!==$realanswer){
$ip = sqlesc(getip());$added = sqlesc(get_date_time()); 
$names = $res["username"];
$msgs = "Только что была произведена неудачная попытка востановления пароля по секретному вопросу-ответу (использованный ответ: [color=dark][b]".$answer."[/b][/color]) для Вашего логина с [b]IP:[/b] [color=red][b]".$ip."[/b][/color], если это не Вы, рекомендуем немедленно сменить Вопрос-Ответ на сложный много символьный, а данный [b]IP:[/b] ([color=red][b]".$ip."[/b][/color]) передать Администрации сайта !";
$msga = unesc(format_comment($msgs));
send_pm(2, $id, get_date_time(), "Попытка ВЗЛОМА вашего Аккаунта !", $msga);
$subj = "Попытка взлома!";$msgd = "Загляните в лог сайта: [url=log.php?type=login]Login[/url]. Была попытка подбора секретного вопроса-ответа."; 
$subj = sqlesc($subj);$msgf = sqlesc(unesc(format_comment($msgd))); 
mysql_query("INSERT INTO messages (sender, receiver, added, msg, subject) SELECT 2, id, NOW(), $msgf, $subj FROM users WHERE class >=".UC_ADMINISTRATOR) or sqlerr(__FILE__,__LINE__);
write_log("Неудачная попытка востановления пароля по секретному вопросу-ответу для юзера <font color=red><b>$names</b></font> с Ответом 
<font color=blue><b>".$answer."</b></font> с IP: <font color=dark><b><a href=usersearch.php?ip=".$ip.">".$ip."</a></b></font>", "5DDB6E", "login");
$a = (@mysql_fetch_row(@sql_query("select count(*) from loginattempts WHERE ip=$ip"))) or sqlerr(__FILE__, __LINE__); 
if($a[0] == 0) mysql_query("INSERT INTO loginattempts (ip, added, attemptss, userid) VALUES ($ip, $added, 1, $id)") or sqlerr(__FILE__, __LINE__); 
else mysql_query("UPDATE loginattempts SET attemptss = attemptss + 1, userid = $id WHERE ip = $ip") or sqlerr(__FILE__, __LINE__);
stderr("Restore failed!","<center><b>Error</b>: Sorry your answer is incorrect!<br>Forgot your password? <b><a href='/'>Restore</a></b> it!</center><html><head><meta http-equiv='refresh' content='4;url=/'></head><body style=\"background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;\"></body></html>");
}$newpass = makenewpassword($id);?>
<td align="center" style="display:yes;position:fixed;margin-top:0px;" width="50%" border="0px">
<div style="display:yes;position:fixed;margin-top:200px;margin-left:470px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr>
<td align="center"><div style="padding:5px"><center><font color=#A52A2A><b>Restore password!</b></font></center></div></td></tr>
<tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:center;"><p>You <b><?=remainings();?></b> login attempts</p><br>
<div style="padding-left:2px" align="center"><center><b>Your new password:</b>&nbsp;<input type='text' value="<?=$newpass?>"></center><br><a href="/">
<input type='submit' value="Home" style='height:20px;width:100px'></a></div></td></tr></table></div></td><?break;}stdfoot();exit;}
function makenewpassword($id){
  $res = sql_query("SELECT * FROM users WHERE id=$id LIMIT 1") or sqlerr(__FILE__, __LINE__);
  $arr = mysql_fetch_assoc($res) or stderr($tracker_lang['error'], "ID адрес не найден в базе данных.\n");
    $sec = hash_pad($arr["editsecret"]);
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789><^*-|_";
  $newpassword = "";
  for ($i = 0; $i < 10; $i++)
    $newpassword .= $chars[mt_rand(0, strlen($chars) - 1)];
     $sec = mksecret();
  $newpasshash = md5($sec . $newpassword . $sec);
    sql_query("UPDATE users SET secret=" . sqlesc($sec) . ", editsecret='', passhash=" . sqlesc($newpasshash) . " WHERE id=$id AND editsecret=" . sqlesc($arr["editsecret"]));
    if (!mysql_affected_rows())
        stderr($tracker_lang['error'], "Невозможно обновить данные пользователя. Пожалуста свяжитесь с администратором относительно этой ошибки.");
return $newpassword;}?> 