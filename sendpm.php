<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
// Define constants
define('PM_DELETED',0); // Message was deleted
define('PM_INBOX',1); // Message located in Inbox for reciever
define('PM_SENTBOX',-1); // GET value for sent box
// Determine action
$action = (string) $_GET['action'];if(!$action){$action = (string) $_POST['action'];if(!$action){$action = 'viewmailbox';}}
if($action == "sendmessage"){?>
<html lang="ru"><head><title>Отправить PM</title><link rel="stylesheet" href="themes/HDclub/HDClub.css"></head><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"><?
$receiver = $_GET["receiver"];if(!is_valid_id($receiver))stderr2($tracker_lang['error'], "Неверное ID получателя<script>setTimeout(function(){window.close()}, 3000);</script>");
$replyto = $_GET["replyto"];if ($replyto && !is_valid_id($replyto))stderr2($tracker_lang['error'], "Неверное ID сообщения<script>setTimeout(function(){window.close()}, 5000);</script>");
$auto = $_GET["auto"];$std = $_GET["std"];
if(($auto || $std) && get_user_class() < UC_MODERATOR)stderr2($tracker_lang['error'], "Досступ запрещен.<script>setTimeout(function(){window.close()}, 3000);</script>");
$res = sql_query("SELECT * FROM users WHERE id=$receiver") or die(mysql_error());$user = mysql_fetch_assoc($res);
if(!$user)stderr2($tracker_lang['error'], "Пользователя с таким ID не существует.<script>setTimeout(function(){window.close()}, 3000);</script>");
if($auto)$body = $pm_std_reply[$auto];if($std)$body = $pm_template[$std][1];
if($replyto){$res = sql_query("SELECT * FROM messages WHERE id=$replyto") or sqlerr(__FILE__, __LINE__);$msga = mysql_fetch_assoc($res);
if($msga["receiver"] != $CURUSER["id"])stderr2($tracker_lang['error'], "Вы пытаетесь ответить не на свое сообщение!<script>setTimeout(function(){window.close()}, 3000);</script>");
$res = sql_query("SELECT username FROM users WHERE id=" . $msga["sender"]) or sqlerr(__FILE__, __LINE__);$usra = mysql_fetch_assoc($res);
$body .= "[quote=$usra[username]]\n".htmlspecialchars_uni($msga['msg'])."[/quote]\n\n";$subject = "Re: ".htmlspecialchars_uni($msga['subject']);}?>
<table style='background-color:none;width:99%;' border='0' cellspacing='0' cellpadding='0'><tr><td style='border:none;text-align:left;'><form name='message' method='post' action='spm#'><input type='hidden' name='action' value='takemessage'>
<table cellspacing='0' cellpadding='5'><tr><td style="background:#4ca1e4;color:#FFFFFF;colspan:16;font-size:14px;text-align:center;font-weight:bold;border:0;border-radius:5px;">Сообщение для <a href='user_<?=$receiver?>'><?=$user['username']?></a></td></tr>
<TR><TD colspan="2"><B>Тема:&nbsp;&nbsp;</B><INPUT name="subject" type="text" size="60" value="<?=$subject?>" maxlength="255"></TD></TR>
<tr><td<?=$replyto?" colspan=2":""?>><?textbbcode2("message","msg","$body");?></td></tr><tr><?if($replyto){?><td align='center'>
<input type='checkbox' name='delete' value='yes' <?=$CURUSER['deletepms'] == 'yes'?"checked":""?>>Удалить сообщение после ответа<input type='hidden' name='origmsg' value='<?=$replyto?>'>
</td><?}?><td align='center'><input type='checkbox' name='save' value='yes' <?=$CURUSER['savepms'] == 'yes'?"checked":""?>>Сохранить сообщение в отправленных</td></tr>
<tr><td<?=$replyto?" colspan=2":""?> align='center'><input type='submit' value="Послать!"><?="<a href=\"javascript:window.close();\">";?>
<input type='button' value="Закрыть"></a></td></tr></table><input type='hidden' name='receiver' value='<?=$receiver?>'></form></div></td></tr></table></body></html><?}
if($action == 'takemessage'){
$receiver = $_POST["receiver"];$resd = sql_query("SELECT class, avatar, username FROM users WHERE id=$receiver");$userd = mysql_fetch_assoc($resd);
$receiver_class = $userd['class'];$receiver_avatar = $userd['avatar'];$receiver_username = $userd['username'];
$origmsg = $_POST["origmsg"];$save = $_POST["save"];$returnto = $_POST["returnto"];
if(!is_valid_id($receiver) || ($origmsg && !is_valid_id($origmsg))){?>
<html lang="ru"><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">
<div style="display:yes;position:fixed;margin-top:60px;margin-left:110px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr><td align="center"><div style="padding:5px"><center><font color=#A52A2A><b>Error!</b></font></center></div></td></tr>  
<tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:center;"><div style="padding-left:2px" align="center"><center>
Неверный ID</center></div></td></tr></table></div><script>setTimeout(function(){window.close()}, 3000);</script></body></html><?die;}
$msg = trim($_POST["msg"]);
if(!$msg){?><html lang="ru"><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">
<div style="display:yes;position:fixed;margin-top:60px;margin-left:110px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr><td align="center"><div style="padding:5px"><center><font color=#A52A2A><b>Error!</b></font></center></div></td></tr>  
<tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:center;"><div style="padding-left:2px" align="center"><center>Пожалуйста введите сообщение!</center></div></td></tr></table></div>
<script>setTimeout(function(){window.close()}, 3000);</script></body></html><?die;}
$subject = trim($_POST['subject']);
if(!$subject){?><html lang="ru"><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">
<div style="display:yes;position:fixed;margin-top:60px;margin-left:110px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr><td align="center"><div style="padding:5px"><center><font color=#A52A2A><b>Error!</b></font></center></div></td></tr>  
<tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:center;"><div style="padding-left:2px" align="center"><center>
Пожалуйста введите тему сообщения!</center></div></td></tr></table></div><script>setTimeout(function(){window.close()}, 3000);</script></body></html><?die;}
$save = ($save == 'yes') ? "yes" : "no";
$res = sql_query("SELECT acceptpms, parked FROM users WHERE id=$receiver") or sqlerr(__FILE__, __LINE__);$user = mysql_fetch_assoc($res);
if(!$user){?>
<html lang="ru"><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">
<div style="display:yes;position:fixed;margin-top:60px;margin-left:110px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr><td align="center"><div style="padding:5px"><center><font color=#A52A2A><b>Error!</b></font></center></div></td></tr>  
<tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:center;"><div style="padding-left:2px" align="center"><center>
Нет пользователя с таким ID <?=$receiver?>.</center></div></td></tr></table></div><script>setTimeout(function(){window.close()}, 3000);</script></body></html><?die;}
if($user["parked"] == "yes"){?>
<html lang="ru"><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">
<div style="display:yes;position:fixed;margin-top:60px;margin-left:110px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr><td align="center"><div style="padding:5px"><center><font color=#A52A2A><b>Error!</b></font></center></div></td></tr>  
<tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:center;"><div style="padding-left:2px" align="center"><center>
Этот аккаунт припаркован.</center></div></td></tr></table></div><script>setTimeout(function(){window.close()}, 3000);</script></body></html><?die;}
if(get_user_class() < UC_MODERATOR){if($user["acceptpms"] == "yes"){$res2 = sql_query("SELECT * FROM blocks WHERE userid=$receiver AND blockid=".$CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res2) == 1)sttderr("Отклонено", "Этот пользователь добавил вас в черный список.");}elseif ($user["acceptpms"] == "friends"){
$res2 = sql_query("SELECT * FROM friends WHERE userid=$receiver AND friendid=".$CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res2) != 1){?>
<html lang="ru"><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">
<div style="display:yes;position:fixed;margin-top:60px;margin-left:110px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr><td align="center"><div style="padding:5px"><center><font color=#A52A2A><b>Отклонено</b></font></center></div></td></tr>  
<tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:center;"><div style="padding-left:2px" align="center"><center>
Этот пользователь принимает сообщение только из списка своих друзей</center></div></td></tr></table></div><script>setTimeout(function(){window.close()}, 3000);</script></body></html><?die;}}
elseif ($user["acceptpms"] == "no"){?>
<html lang="ru"><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">
<div style="display:yes;position:fixed;margin-top:60px;margin-left:110px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr><td align="center"><div style="padding:5px"><center><font color=#A52A2A><b>Отклонено</b></font></center></div></td></tr>  
<tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:center;"><div style="padding-left:2px" align="center"><center>
Этот пользователь не принимает сообщения.</center></div></td></tr></table></div><script>setTimeout(function(){window.close()}, 3000);</script></body></html><?die;}}
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, receiver_class, receiver_username, receiver_avatar, added, msg, subject, saved) 
VALUES (".$CURUSER["id"].", ".$CURUSER["class"].", ".sqlesc($CURUSER["username"]).", ".sqlesc($CURUSER["avatar"]).", $receiver, $receiver_class, ".sqlesc($receiver_username).", 
".sqlesc($receiver_avatar).", '".get_date_time()."', ".sqlesc($msg).", ".sqlesc($subject).", ".sqlesc($save).")") or sqlerr(__FILE__, __LINE__);
//////////////////////
sql_query("UPDATE users SET newmess = newmess + 1 WHERE id=$receiver") or sqlerr(__FILE__, __LINE__);global $CacheBlockus;$_cacheu = "user_".$receiver.".cache";
$resus = sql_query("SELECT * FROM users WHERE id = ".$receiver);$rowus = mysql_fetch_array($resus);$CacheBlockus->Writeus($_cacheu, $rowus);
//////////////////////////////
$delete = $_POST["delete"];
if($origmsg){if($delete == "yes"){$res = sql_query("SELECT * FROM messages WHERE id=$origmsg") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res) == 1){$arr = mysql_fetch_assoc($res);
if($arr["receiver"] != $CURUSER["id"]){?>
<html lang="ru"><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">
<div style="display:yes;position:fixed;margin-top:60px;margin-left:110px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr><td align="center"><div style="padding:5px"><center><font color=#A52A2A><b>Error!</b></font></center></div></td></tr>  
<tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:center;"><div style="padding-left:2px" align="center"><center>
Вы пытаетесь удалить не свое сообщение!</center></div></td></tr></table></div><script>setTimeout(function(){window.close()}, 3000);</script></body></html><?die;}
if($arr["saved"] == "no")sql_query("DELETE FROM messages WHERE id=$origmsg") or sqlerr(__FILE__, __LINE__);
elseif ($arr["saved"] == "yes")sql_query("UPDATE messages SET saved = 'yes' WHERE id=$origmsg") or sqlerr(__FILE__, __LINE__);}}
if(!$returnto)$returnto = "$DEFAULTBASEURL/spm";}if($returnto){header("Location: $returnto");die;}else{?>
<html lang="ru"><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">
<div style="display:yes;position:fixed;margin-top:60px;margin-left:110px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr>
<td align="center"><div style="padding:5px"><center><font color=#A52A2A><b><?=$tracker_lang['success']?></b></font></center></div></td></tr>  
<tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:center;"><div style="padding-left:2px" align="center"><center>
Сообщение было успешно отправлено!</center></div></td></tr></table></div><script>setTimeout(function(){window.close()}, 3000);</script></body></html><?die;}}
}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>