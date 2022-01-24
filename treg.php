<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}else{
if($_SERVER["REQUEST_METHOD"] == "POST"){?>
<html lang="ru"><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"><?
/////// Выкидывает если есть такой IP-аккаунт (НАЧАЛО) ////////////
$userip=getip();$newres = mysql_query("SELECT username FROM users WHERE ip = '$userip'");$newcount = mysql_num_rows($newres);if($newcount){$accountname = "";
while ($newrow = mysql_fetch_assoc($newres)){$accountname .= $newrow["username"].", ";}if($accountname){$accountname = substr($accountname, 0, -2);}
stderr("<center>Double registration Impossible!</center>", "<center><font color=black>Sorry, but your IP-address is already registered on the tracker.<br><br>Your login: ".$accountname."</font></center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");}
/////// Выкидывает если есть такой IP-аккаунт (КОНЕЦ) ////////////	
$users = get_row_count("users");
if($users >= $maxusers) stderr("Error", "<center>".sprintf($tracker_lang['signup_users_limit'], number_format($maxusers))."</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
if(!mkglobal("wantusername:wantpassword:passagain:email")) stderr("Error", "<center>".$tracker_lang['dad']."</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
if($users > 0){global $CacheBlock;$_cache2 = 'inwayts.cache';$inwayts = $CacheBlock->Read($_cache2);if($inwayts['vibor'] == 0){$inviter = $invitedroot = 0;
if(empty($_POST["invite"])) stderr("Error", "<center>To register, you need to enter an invitation code!</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
if(strlen($_POST["invite"]) != 32) stderr("Error", "<center>You entered an invalid invitation code</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
list($inviter) = mysql_fetch_row(mysql_query("SELECT inviter FROM invites WHERE invite = ".sqlesc($_POST["invite"], true)));
if(!$inviter) stderr("Error", "<center>The invitation code you entered is not working</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
list($invitedroot) = mysql_fetch_row(mysql_query("SELECT invitedroot FROM users WHERE id = $inviter"));}}
function bark($msg){?><html><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"><?=stderr("Error", $msg);?></body></html><?}
function validusername($username){if($username == "") return false;
$allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789><^*-|_абвгдеёжзиклмнопрстуфхшщэюяьъАБВГДЕЁЖЗИКЛМНОПРСТУФХШЩЭЮЯЬЪ";
for ($i = 0; $i < strlen($username); ++$i) if(strpos($allowedchars, $username[$i]) === false) return false;return true;}
function validpassword($password){if($password == "") return false;
$allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789><^*-|_";
for ($i = 0; $i < strlen($password); ++$i)
if(strpos($allowedchars, $password[$i]) === false) return false;return true;}
$email = trim(strtolower($email));$uploaded = '107374182400';$downloaded = '10737418240';
if(!$users){$class = '11';$comentoff = 'yes';$schoutboxpos = 'yes';}else{$class = '1';$comentoff = 'no';$schoutboxpos = 'no';}
$bonus = '1000';$hides = 'yes';$hider = 'yes';$hiders = 'yes';$invayted = 'yes';$invayt = 'yes';$bonusss = 'yes';
if(empty($wantusername) || empty($wantpassword) || empty($email)) bark("<center>All fields are required.</center>");
if(strlen($wantusername) > 12) bark("<center>Sorry, the username is too long (maximum 12 characters)</center>");
if(!validusername($wantusername)) bark("<center><b>Invalid username!</b> Allowed characters are: <td class=\"code\">abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789><^*-|_абвгдеёжзиклмнопрстуфхшщэюяьъАБВГДЕЁЖЗИКЛМНОПРСТУФХШЩЭЮЯЬЪ</td></center>");	
if(!validpassword($wantpassword)) bark("<center><b>Invalid password!</b> Allowed characters are: <td class=\"code\">abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789><^*-|_</td></center>");	
if($wantpassword != $passagain) bark("<center>Passwords do not match! It looks like you were mistaken. Try again.</center>");
if(strlen($wantpassword) < 6) bark("<center>Sorry, the password is too short (minimum 6 characters)</center>");
if(strlen($wantpassword) > 40) bark("<center>Sorry, your password is too long (40 characters maximum)</center>");
if($wantpassword == $wantusername) bark("<center>Sorry, the password should not be the same as the user name.</center>");
if(!validemail($email)) bark("<center>It's not like a real email address.</center>");
list(, $domain) = explode('@', $email);
if(!mail_possible($email)) bark("<center>Mail in such a domain can not be (".htmlspecialchars_uni($domain).")</center>");
if($check_for_working_mta){if(function_exists('getmxrr')){getmxrr($domain, $mxs);foreach ($mxs as $mx){if(check_port($mx, 587, 1, true)){$is_good_smtp = true;break;}}
if(!$is_good_smtp) bark("<center>On your e-mail service is not running a mail server (MTA).</center>");}}
$a = get_row_count('users', 'WHERE email = '.sqlesc($email));
if($a != 0) bark("<center>E-mail address ".htmlspecialchars_uni($email)." already registered in the system.</center>");
check_banned_emails($email);$ip = getip();
if(isset($_COOKIE[COOKIE_UID]) && is_numeric($_COOKIE[COOKIE_UID]) && $users){
$cid = intval($_COOKIE[COOKIE_UID]);$c = mysql_query("SELECT enabled FROM users WHERE id = $cid ORDER BY id DESC LIMIT 1");$co = mysql_fetch_row($c);
if($co[0] == 'no'){mysql_query("UPDATE users SET ip = '$ip', last_access = NOW() WHERE id = $cid");bark("<center>Your IP is banned on this tracker. Registration is not possible.</center>");}else bark("<center>Registration is not possible!</center>");}else{
$b = (mysql_fetch_row(mysql_query("SELECT enabled, id FROM users WHERE ip = '$ip' ORDER BY last_access DESC LIMIT 1")));
if($b[0] == 'no'){$banned_id = $b[1];setcookie(COOKIE_UID, $banned_id, "0x7fffffff", "/");bark("<center>Your IP is banned on this tracker. Registration is not possible.</center>");}}
$secret = mksecret();$wantpasshash = md5($secret . $wantpassword . $secret);$editsecret = (!$users ? "" : mksecret());
if (!$users) $status = 'confirmed';else $status = 'pending';
if($inwayts == 0 && $users > 0){
$ret = mysql_query("INSERT INTO users (username, passhash, secret, editsecret, email, uploaded, downloaded, class, bonus, status, hides, hider, hiders, invayted, invayt, bonusss, comentoff, 
schoutboxpos, added, language, invitedby, invitedroot, theme) VALUES (" . implode(",", array_map("sqlesc", array($wantusername, $wantpasshash, $secret, $editsecret, $email, $uploaded, $downloaded, 
$class, $bonus, $status, $hides, $hider, $hiders, $invayted, $invayt, $bonusss, $comentoff, $schoutboxpos))).", '".get_date_time()."', '$default_language', '$inviter', '$invitedroot', '".select_theme()."')");
}else{$ret = mysql_query("INSERT INTO users (username, passhash, secret, editsecret, email, uploaded, downloaded, class, bonus, status, hides, hider, hiders, bonusss, comentoff, schoutboxpos, 
added, language, theme) VALUES (" . implode(",", array_map("sqlesc", array($wantusername, $wantpasshash, $secret, $editsecret, $email, $uploaded, $downloaded, $class, $bonus, $status, $hides, 
$hider, $hiders, $bonusss, $comentoff, $schoutboxpos))) . ", '".get_date_time()."', '$default_language', '".select_theme()."')");
}if(!$ret){if(mysql_errno() == 1062) bark("User $wantusername already registered!");
bark("<center>Unknown error. Answer from the server mySQL: ".htmlspecialchars_uni(mysql_error())."</center>");}
$id = mysql_insert_id();if($inwayts == 0){mysql_query("DELETE FROM invites WHERE invite = ".sqlesc($_POST["invite"]));}
write_log("Зарегистрирован новый пользователь $wantusername", "FFFFFF", "tracker");
$psecret = md5($editsecret);$language = "russian";
$body = <<<EOD
You registered for $SITENAME and indicated this address as reverse ($email).

If it was not you, please ignore this letter. The person who entered your E-Mail address has an IP address {$_SERVER["REMOTE_ADDR"]}. Please do not answer.

To confirm your registration, you need to go to the following link:

$DEFAULTBASEURL/confirm.php?id=$id&secret=$psecret

After you do this, you will be able to use your account. If you do not, 
Your new account will be deleted in a couple of days. We strongly recommend that you read the rules and FAQ before you start using $SITENAME.

Please note! If, after confirming your account, you use this link again, you will be banned and you will be thrown out of the site with an account ban and by IP !!!
Учтите! Если вы после подтверждения аккаунта еще раз воспользуетесь этой ссылкой, то попадете в бан и вас выкинет с сайта с баном аккаунта и по IP!!!
EOD;
if($use_email_act == 1){if($users){sent_mail($email, $SITENAME, $SITEEMAIL, "Confirmation of registration for $SITENAME", $body);
?><html lang="ru"><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">
<div style="display:yes;position:fixed;margin-top:200px;margin-left:450px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">  
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr><td align="right" height="5%"><div style="padding:5px"><br></div></td></tr>  
<td style="padding-left:4px"><hr></td><tr><td align="left" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:left;"><div style="padding-left:2px" align="center"><center><?
if(!validemail($email))stderr("<center>".$tracker_lang['error']."</center>", "<center>Это не похоже на реальный email адрес.</center>");
stdmsg("<center>".$tracker_lang['signup_successful']."</center>",($use_email_act ? sprintf($tracker_lang['confirmation_mail_sent'], htmlspecialchars_uni($email)) : sprintf($tracker_lang['thanks_for_registering'], $SITENAME)));?></center></div></td></tr></table></div></body></html><?}else{
logincookie($id, $wantpasshash, $language);$added = sqlesc(get_date_time());$subject = sqlesc("Your account Vladelec has been activated!");
$msg = sqlesc("Your account Vladelec has been activated! However, it appears that you could not be logged in automatically. A possible reason is that you disabled cookies in your browser. You have to enable cookies to use your account.");mysql_query("INSERT INTO messages (sender, receiver, msg, subject, added) VALUES (2, 1, $msg, $subject, $added)");header("Refresh: 0; url=/");}}else{
if($users){logincookie($id, $wantpasshash, $language);mysql_query('UPDATE users SET status = "confirmed" WHERE id = '.$id) or sqlerr(__FILE__, __LINE__);$added = sqlesc(get_date_time());
$msg = sqlesc("Ваш аккаунт теперь активирован! Прежде чем начать использовать $SITENAME мы рекомендуем вам прочитать [url=rules][b]правила[/b][/url] и [url=faq][b]ЧаВо[/b][/url].");
$subject = sqlesc("Your account has been activated!");mysql_query("INSERT INTO messages (sender, receiver, msg, subject, added) VALUES (2, $id, $msg, $subject, $added)");header("Refresh: 0; url=/");}else{
logincookie($id, $wantpasshash, $language);$added = sqlesc(get_date_time());$subject = sqlesc("Your account Vladelec has been activated!");
$msg = sqlesc("Your account Vladelec has been activated! However, it appears that you could not be logged in automatically. A possible reason is that you disabled cookies in your browser. You have to enable cookies to use your account."); 
mysql_query("INSERT INTO messages (sender, receiver, msg, subject, added) VALUES (2, 1, $msg, $subject, $added)");header("Refresh: 0; url=/");}}?></body></html><?}
else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}}?>
