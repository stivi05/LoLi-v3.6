<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}else{
function bark($msg){?><html><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"><?=stderr("Error", $msg);?></body></html><?}
if($_SERVER["REQUEST_METHOD"] == "POST"){
$email = strip_tags($_POST["email"]);$email = htmlspecialchars_uni($email);$email = mysql_real_escape_string($email);$email = trim($email);
if(empty($email)){bark("<center>You must enter your email address.</center>");}
$res = mysql_query("SELECT * FROM users WHERE email = ".sqlesc($email)." LIMIT 1") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res) or bark("<center>Email address is not found in the database.</center>");$sec = mksecret();
mysql_query("UPDATE users SET editsecret = ".sqlesc($sec)." WHERE id = ".$arr["id"]) or sqlerr(__FILE__, __LINE__);
if (!mysql_affected_rows())	bark("<center>Database Error. Contact the administrator regarding this error.</center>");
$email = $arr['email'];$hash = md5($sec . $email . $arr["passhash"] . $sec);
$body = <<<EOD
You, or someone else, requested a new password for the account associated with this address ($email).
The request was sent by a person with an IP address {$_SERVER["REMOTE_ADDR"]}.
If it was not you, ignore this message. Please do not reply.
If you agree to this request, click on the following link:
$DEFAULTBASEURL/recover.php?id={$arr["id"]}&secret=$hash

Once you do this, your password will be reset and a new password will be sent to you on E-Mail.

Please note! If you use this link again, you will be banned and you will be thrown out of the site with an account ban and IP !!!
Учтите! Если вы после подтверждения аккаунта еще раз воспользуетесь этой ссылкой, то попадете в бан и вас выкинет с сайта с баном аккаунта и по IP!!!
-- 
$SITENAME
EOD;
if($email){sent_mail($arr["email"],$SITENAME,$SITEEMAIL,"Confirm password recovery on $SITENAME",$body);
stderr($tracker_lang['success'], "<html lang='ru'><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'><center>
<hr>A confirmation letter was sent.<br>In a few minutes (usually immediately)<br>you will receive a letter<br>with further instructions.<hr>Please look for a letter in SPAM,<br>unfortunately our letters<br>
often end up there.</center></body></html>");unlink("include/cache/".$arr["id"]."_user.cache");}else{
stderr('Error', "<html lang='ru'><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'><center>
Can not send E-mail.<br>Please inform the administration<br>about the error.</center></body></html>");
}}elseif($_GET){$id = (isset($_GET["id"]) ? intval($_GET["id"]):0);$md5 = strval($_GET["secret"]);
if(!is_valid_id($id) || empty($id) || empty($md5)){print("<html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");}
$ip = getip();$ag = getenv("HTTP_USER_AGENT");$host = getenv("REQUEST_URI");$date = date("d.m.y");$time = date("H:i:s");
$comments = "Hakker? Don't break us!";$comment = trim($comments);$comment = sqlesc(htmlspecialchars_uni($comment));$added = sqlesc(get_date_time());$first = sqlesc(getip());
$res = mysql_query("SELECT username, email, passhash, editsecret FROM users WHERE id = $id");$arr = mysql_fetch_array($res);
if(!$arr){mysql_query("INSERT INTO bans (added, addedby, first, comment, haker) VALUES($added, 2, $first, $comment, 'yes')");foreach(glob("include/cache/bans.cache") as $del_bans) unlink($del_bans);
write_log("Попытка подбора восстановления Пароля! Данные Хаккера: $ip , $ag<br>Код подбора: $host<br>$date в $time.","5DDB6E","bans");
stderr('Error', "<html lang='ru'><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'><center>
Hacker? Well, congratulations!<br><br>You are banned! Farewell!</center></body></html>");}else{
if(!$arr["editsecret"]){mysql_query("INSERT INTO bans (added, addedby, first, comment, haker) VALUES($added, 2, $first, $comment, 'yes')");foreach(glob("include/cache/bans.cache") as $del_bans) unlink($del_bans);
write_log("Попытка подбора восстановления Пароля! Данные Хаккера: $ip , $ag<br>Код подбора: $host<br>$date в $time.","5DDB6E","bans");
stderr('Error', "<html lang='ru'><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'><center>
Hacker? Well, congratulations!<br><br>You are banned! Farewell!</center></body></html>");}else{
$email = $arr["email"];$sec = $arr["editsecret"];$hashs = md5($sec . $email . $arr["passhash"] . $sec);if(preg_match('/^ *$/s', $sec))httperr();
if($md5 != $hashs){mysql_query("INSERT INTO bans (added, addedby, first, comment, haker) VALUES($added, 2, $first, $comment, 'yes')");foreach(glob("include/cache/bans.cache") as $del_bans) unlink($del_bans);
write_log("Попытка подбора восстановления Пароля! Данные Хаккера: $ip , $ag<br>Код подбора: $host<br>$date в $time.","5DDB6E","bans");
stderr('Error', "<html lang='ru'><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'><center>
Hacker? Well, congratulations!<br><br>You are banned! Farewell!</center></body></html>");}else{
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789><^*-|_";$newpassword = "";
for($i = 0; $i < 10; $i++)$newpassword .= $chars[mt_rand(0, strlen($chars) - 1)];$sec = mksecret();$newpasshash = md5($sec . $newpassword . $sec);
mysql_query("UPDATE users SET secret = ".sqlesc($sec).", editsecret = '', passhash= ".sqlesc($newpasshash)." WHERE id = $id AND editsecret = ".sqlesc($arr["editsecret"]));
if (!mysql_affected_rows())stderr('Error', "<html lang='ru'><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'><center>
Unable to update user data. Please contact the administrator regarding this error.</center></body></html>");
$body = <<<EOD
At your request for password recovery, we have generated a new password for you.
Here's your new data for this account:
    User: {$arr["username"]}
    Password: $newpassword
You can enter the site here: $DEFAULTBASEURL/
--
$SITENAME
EOD;
if($email){sent_mail($email,$SITENAME,$SITEEMAIL,"Account data for $SITENAME",$body);
stderr($tracker_lang['success'], "<html lang='ru'><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'><center>
<hr>New account information sent to E-Mail:<br><b>$email</b><br>After a few minutes (usually immediately)<br>you get your new data.<hr>Please look for a letter in SPAM,<br>unfortunately our letters<br>
often end up there.</center></body></html>");unlink("include/cache/".$id."_user.cache");}else{
stderr('Error', "<html lang='ru'><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'><center>
Can not send E-mail.<br>Please inform the administration<br>about the error.</center></body></html>");}}}}}elseif(!$_GET){?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}}?>