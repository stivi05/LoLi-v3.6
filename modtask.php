<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && get_user_class() >= UC_MODERATOR){
global $CURUSER, $tracker_lang, $avatar_max_width, $avatar_max_height;$cache = new Memcache();$cache->connect('127.0.0.1', 11211);
function puke($text = "You have forgotten here someting?"){stderr2($tracker_lang['error'], $text);}
function barf($text = "Пользователь удален"){stderr2($tracker_lang['success'], $text);}
function bark($msg){stderr2("<center><b>Произошла ошибка</b></center>", $msg);}
$action = $_POST["action"];if($action == "edituser"){
$userid = $_POST["userid"];$title = unesc($_POST["title"]);$username0 = $_POST["username"];$year = $_POST["year"];$month = $_POST["month"];$day = $_POST["day"];
if($year == '0000' || $month == '00' || $day == '00') stderr2("Error", "<center>It looks like you entered an incorrect date of birth</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
$birthday0 = date("$year.$month.$day");$updateset[] = "birthday = '$birthday0'";
$avatarname = $_POST["avatar"];$resetb = $_POST["resetb"];$birthday = ($resetb=='yes'?", birthday = '0000-00-00'":"");$enabled = $_POST["enabled"];
$warned = $_POST["warned"];$schoutboxpos = $_POST["schoutboxpos"];$comentoff = $_POST["comentoff"];
$warnlength = intval($_POST["warnlength"]);$dislength = intval($_POST["dislength"]);$warnpm = $_POST["warnpm"];$donor = $_POST["donor"];
$uploadtoadd = $_POST["amountup"];$downloadtoadd = $_POST["amountdown"];$formatup = $_POST["formatup"];$formatdown = $_POST["formatdown"];$mpup = $_POST["upchange"];
$mpdown = $_POST["downchange"];$upbontoadd = $_POST["bonup"];$downbontoadd = $_POST["bondown"];$seederr = htmlspecialchars_uni($_POST["seeder"]);$leecherr = htmlspecialchars_uni($_POST["leecher"]);	
$bonup = $_POST["upbonus"];$bondown = $_POST["downbonus"];$invup = $_POST["upbonus"];$invdown = $_POST["downbonus"];$upinvtoadd = $_POST["invup"];$downinvtoadd = $_POST["invdown"];
$support = $_POST["support"];$supportfor = htmlspecialchars_uni($_POST["supportfor"]);$modcomm = htmlspecialchars_uni($_POST["modcomm"]);$podpis = htmlspecialchars_uni($_POST["podpis"]);
$emails = trim(strtolower($_POST["emails"]));$country = $_POST["country"];
if(!validemail($emails)) bark("<center>Это не Email. Исправьте на верный!</center>");list(, $domain) = explode('@', $emails);
if(!mail_possible($emails)) bark("<center>Почты не может быть в таком домене - (".htmlspecialchars_uni($domain).") . Исправьте!</center>");
$deluser = $_POST["deluser"];$theme = $_POST["theme"];$class = intval($_POST["class"]);	
if(!is_valid_id($userid))stderr2($tracker_lang['error'], "Неверный идентификатор пользователя.");
if(!is_valid_user_class($class))stderr2($tracker_lang['error'], "Неверный идентификатор класса.");
$res = mysql_query("SELECT warned, enabled, username, schoutboxpos, comentoff, info, class, modcomment, avatar, uploaded, downloaded, bonus, invites, seeder, leecher FROM users WHERE id = $userid") or sqlerr(__FILE__, __LINE__);$arr = mysql_fetch_assoc($res) or puke("Ошибка MySQL: ".mysql_error()); 
///////////////////////////////// 
function uploadavatar(){$userid = $_POST["userid"];$maxavatarsize = 524288; //0.5MB
$allowed_types = array( 
  "image/gif" => "gif", 
  "image/pjpeg" => "jpg", 
  "image/jpeg" => "jpg", 
  "image/jpg" => "jpg", 
  "image/png" => "png" 
);
if(!($_FILES['avatar']['name'] == "")){$uploaddir = "pic/avatar/";$ifile = $_FILES['avatar']['tmp_name']; 
$ifilename = "avatar_".$userid.substr($_FILES['avatar']['name'], strlen($_FILES['avatar']['name'])-4, 4); 
if(!array_key_exists($_FILES['avatar']['type'], $allowed_types)) bark("Неверный тип файла для аватара!"); 
if(!preg_match('/^(.+)\.(jpg|jpeg|png|gif)$/si', $_FILES['avatar']['name'])) bark("Неверное имя файла (не картинка).");list($width, $height) = getimagesize($ifile); 
if($width > $avatar_max_width || $height > $avatar_max_height) bark(sprintf($tracker_lang['avatar_is_too_big'], $avatar_max_width, $avatar_max_height)); 
if($_FILES['avatar']['size'] > $maxavatarsize) bark("Аватар весит больше 0.5MB");if($avatarname != "" && $arr["avatar"] != ""){unlink($arr["avatar"]);}
$copy = copy($ifile, $uploaddir.$ifilename);if(!$copy) bark("Аватар не загружена");return $uploaddir.$ifilename;}}
if($avatarname == "update"){$updateset[] = "avatar = ".sqlesc(uploadavatar());}if($avatarname == "delete"){if($arr["avatar"]){unlink($arr["avatar"]);$updateset[] = "avatar = ''";}}
//////////////////////
$curenabled = $arr["enabled"];$curschoutboxpos = $arr["schoutboxpos"];$curcomentoff = $arr["comentoff"];
$curclass = $arr["class"];$curwarned = $arr["warned"];
if(get_user_class() == UC_VLADELEC)$modcomment = $_POST["modcomment"];else $modcomment = $arr["modcomment"];
if($curclass > get_user_class() || $class > get_user_class())puke("Так нельзя делать!");
if(is_theme($theme)) $updateset[] = "theme = ".sqlesc($theme);
////////////////////////////
$res = mysql_query("SELECT username FROM users WHERE id = $userid") or sqlerr(__FILE__, __LINE__); $user = mysql_fetch_array($res);$username = $user["username"];
/////////////////
if($uploadtoadd > 0){if($mpup == "plus")$newupload = $arr["uploaded"] + ($formatup == mb ? ($uploadtoadd * 1048576) : ($uploadtoadd * 1073741824));
else $newupload = $arr["uploaded"] - ($formatup == mb ? ($uploadtoadd * 1048576) : ($uploadtoadd * 1073741824));
if ($newupload < 0)stderr2($tracker_lang['error'], "Вы хотите отнять у пользователя отданого больше чем у него есть!");$updateset[] = "uploaded = $newupload";
$modcomment = date("Y-m-d") . " - Пользователь $CURUSER[username] ".($mpup == "plus" ? "добавил " : "отнял ").$uploadtoadd.($formatup == mb ? " MB" : " GB")." к раздаче.\n". $modcomment;}
if($downloadtoadd > 0){if($mpdown == "plus")$newdownload = $arr["downloaded"] + ($formatdown == mb ? ($downloadtoadd * 1048576) : ($downloadtoadd * 1073741824));
else $newdownload = $arr["downloaded"] - ($formatdown == mb ? ($downloadtoadd * 1048576) : ($downloadtoadd * 1073741824));
if($newdownload < 0)stderr2($tracker_lang['error'], "Вы хотите отнять у пользователя скачаного больше чем у него есть!");$updateset[] = "downloaded = $newdownload";
$modcomment = date("Y-m-d") . " - Пользователь $CURUSER[username] ".($mpdown == "plus" ? "добавил " : "отнял ").$downloadtoadd.($formatdown == mb ? " MB" : " GB")." к скачаному.\n". $modcomment;}
/////////////
if($upbontoadd > 0){$newbonus = $arr["bonus"] - $upbontoadd;if($newbonus < 0)stderr2($tracker_lang['error'], "Вы хотите отнять у пользователя Бонусов больше чем у него есть!");
$updateset[] = "bonus = $newbonus";$modcomment = date("Y-m-d") . " - Пользователь $CURUSER[username] ".($bonup == "plus" ? "добавил " : "отнял ").$upbontoadd." к бонусам.\n". $modcomment;}
if($downbontoadd > 0){$newbonus = $arr["bonus"] + $downbontoadd;$updateset[] = "bonus = $newbonus";
$modcomment = date("Y-m-d") . " - Пользователь $CURUSER[username] ".($bondown == "plus" ? "добавил " : "отнял ").$downbontoadd." к бонусам.\n". $modcomment;}
/////////////////
if($upinvtoadd > 0){$newinv = $arr["invites"] - $upinvtoadd;if($newinv < 0)stderr2($tracker_lang['error'], "Вы хотите отнять у пользователя Бонусов больше чем у него есть!");
$updateset[] = "invites = $newinv";
$modcomment = date("Y-m-d") . " - Пользователь $CURUSER[username] ".($invup == "plus" ? "добавил " : "отнял ").$upinvtoadd." к бонусам.\n". $modcomment;}
if($downinvtoadd > 0){$newinv = $arr["invites"] + $downinvtoadd;$updateset[] = "invites = $newinv";
$modcomment = date("Y-m-d") . " - Пользователь $CURUSER[username] ".($invdown == "plus" ? "добавил " : "отнял ").$downinvtoadd." к бонусам.\n". $modcomment;}
//////////////////////////////////////
$cache->delete('user_cache_'.$userid);$sender_class = $user['class'];$sender_username = $user['username'];$sender_avatar = $user['avatar'];
/////////////////
if($curclass != $class){$userid = $_POST["userid"];
$what = ($class > $curclass ? "повышены" : "понижены");$msg = "Вы были $what до класса \"" . get_user_class_name($class) . "\" пользователем $CURUSER[username].";$subject = "Вы были $what";
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $userid, '".get_date_time()."', ".sqlesc($msg).", ".sqlesc($subject).")");
$updateset[] = "class = $class";$what = ($class > $curclass ? "Повышен" : "Понижен");
$modcomment = date("Y-m-d") . " - $what до класса \"" . get_user_class_name($class) . "\" пользователем $CURUSER[username].\n". $modcomment;}
/////
if($warned && $curwarned != $warned){$userid = $_POST["userid"];$updateset[] = "warned = " . sqlesc($warned);$updateset[] = "warneduntil = '0000-00-00 00:00:00'";
$subject = "Ваше предупреждение снято";if($warned == 'no'){$modcomment = date("Y-m-d") . " - Предупреждение снял пользователь ".$CURUSER['username'].".\n". $modcomment;
$msg = "Ваше предупреждение снял пользователь ".$CURUSER['username'].".";}
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $userid, '".get_date_time()."', ".sqlesc($msg).", ".sqlesc($subject).")");
}elseif($warnlength){$userid = $_POST["userid"];if (strlen($warnpm) == 0)stderr2($tracker_lang['error'], "Вы должны указать причину по которой ставите предупреждение!");
if($warnlength == 255){$modcomment = date("Y-m-d") . " - Предупрежден пользователем " . $CURUSER['username'] . ".\nПричина: $warnpm\n" . $modcomment;
$msg = "Вы получили [url=rules]предупреждение[/url] на неограниченый срок от $CURUSER[username]" . ($warnpm ? "\n\nПричина: $warnpm" : "");$updateset[] = "warneduntil = '0000-00-00 00:00:00'";
}else{$warneduntil = get_date_time(gmtime() + $warnlength * 604800);$dur = $warnlength . " недел" . ($warnlength > 1 ? "и" : "ю");
$msg = "Вы получили [url=rules]предупреждение[/url] на $dur от пользователя " . $CURUSER['username'] . ($warnpm ? "\n\nПричина: $warnpm" : "");
$modcomment = date("Y-m-d") . " - Предупрежден на $dur пользователем " . $CURUSER['username'] .	".\nПричина: $warnpm\n" . $modcomment;$updateset[] = "warneduntil = '$warneduntil'";}
$subject = "Вы получили предупреждение";
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $userid, '".get_date_time()."', ".sqlesc($msg).", ".sqlesc($subject).")");
$updateset[] = "warned = 'yes'";}
///////////////////////////////////////
if($schoutboxpos != $curschoutboxpos){if($schoutboxpos == 'yes'){$subject = "Бан в Чате был снят";
$modcomment = gmdate("Y-m-d") . " - Бан в Чате был снят пользователем ".$CURUSER['username'].".\n".$modcomment; 
$msg = sqlesc("Вы были разбенены в Чате пользователем [b]".$CURUSER['username']."[/b]. Вы снова можете общаться с пользователями."); 
bot_msg(format_comment("[b][color=#8B0000]".$username."[/color][/b] разбанен в чате пользователем [b][color=blue]".$CURUSER['username']."[/color][/b]"));
write_log("<font color=red>Пользователь <b>$username</b> был разбанен в Чате пользователем <b><a href='user_".$CURUSER['id']."'>$CURUSER[username]</a></b>.</font>"); 
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $userid, '".get_date_time()."', ".sqlesc($msg).", ".sqlesc($subject).")");
}else{$subject = "Бан в Чате";$modcomment = gmdate("Y-m-d") . " - Бан в Чате от пользователя ".$CURUSER['username'].".\n".$modcomment; 
$msg = sqlesc("Вы были забанены в Чате пользователем [b]".$CURUSER['username']."[/b], теперь Вы не сможете общяться с пользователями."); 
bot_msg(format_comment("[b][color=#8B0000]".$username."[/color][/b] забанен в чате пользователем [b][color=blue]".$CURUSER['username']."[/color][/b]"));
write_log("<font color=orange><b>Пользователь <u>$username</u> был забанен в Чате пользователем <a href='user_".$CURUSER['id']."'>$CURUSER[username]</a>.</font></b>"); 
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $userid, '".get_date_time()."', $msg, ".sqlesc($subject).")");}}
//////////////////////////////////////
if ($comentoff != $curcomentoff){if($comentoff == 'yes'){$subject = "Бан Комментариев был снят";
$modcomment = gmdate("Y-m-d") . " - Бан Комментариев был снят пользователем ".$CURUSER['username'].".\n".$modcomment; 
$msg = sqlesc("Вам вернул возможность оставлять комментарии пользователь [b]".$CURUSER['username']."[/b]. Вы снова можете оставлять комментарии."); 
write_log("<font color=red>Пользователю <b>$username</b> разрешено оставлять комментарии пользователем <b><a href=user_".$CURUSER[id].">$CURUSER[username]</a></b>.</font>"); 
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $userid, '".get_date_time()."', $msg, ".sqlesc($subject).")");
}else{$subject = "Бан Комментариев";$modcomment = gmdate("Y-m-d") . " - Бан Комментариев от пользователя ".$CURUSER['username'].".\n".$modcomment; 
$msg = sqlesc("Вы были лишены возможности оставлять комментарии пользователем [b]".$CURUSER['username']."[/b], теперь Вы не сможете оставлять комментарии."); 
write_log("<font color=orange><b>Пользователю <u>$username</u> запрещено оставлять комментарии пользователем <a href=user_".$CURUSER[id].">$CURUSER[username]</a>.</font></b>"); 
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $userid, '".get_date_time()."', $msg, ".sqlesc($subject).")");}}	
////////////////////////////////////////////////
if($enabled != $curenabled && (!empty($enabled) || $dislength != 0)){$modifier = (int) $CURUSER['id'];if($enabled == 'yes'){
$nowdate = sqlesc(get_date_time());if (!isset($_POST["enareason"]) || empty($_POST["enareason"]))puke("Введите причину почему вы включаете пользователя!");
$enareason = htmlspecialchars_uni($_POST["enareason"]);$modcomment = date("Y-m-d") . " - Включен пользователем " . $CURUSER['username'] . ".\nПричина: $enareason\n" . $modcomment;
sql_query('DELETE FROM users_ban WHERE userid = '.$userid) or sqlerr(__FILE__,__LINE__);$updateset[] = "enabled = 'yes'";
}else{if(!isset($_POST["disreason"]) || empty($_POST["disreason"]))puke("Введите причину почему вы отключаете пользователя!");$disreason = htmlspecialchars_uni($_POST["disreason"]);
if($dislength == 0)stderr2($tracker_lang['error'], "Вы должны выбрать продолжительность бана пользователя");
if($dislength == 255){$modcomment = date("Y-m-d") . " - Отключен пожизненно пользователем ".$CURUSER['username'].".\nПричина: $disreason\n" . $modcomment;$disuntil = "'0000-00-00 00:00:00'";
write_log("<a href=\"user_$user[id]\">$username</a> был забанен пожизненно пользователем ".$CURUSER['username'].". Причина: $disreason","FF9900","bans");
}else{$date = sqlesc(get_date_time());$dateline = sqlesc(time());$disuntil = get_date_time(gmtime() + $dislength * 604800);$dur = $dislength . " недел" . ($dislength > 1 ? "и" : "ю");
if (!isset($_POST["disreason"]) || empty($_POST["disreason"]))puke("Введите причину почему вы отключаете пользователя!");$disreason = htmlspecialchars_uni($_POST["disreason"]);
$modcomment = date("Y-m-d") . " - Отключен пользователем ".$CURUSER['username']. ($disuntil != '0000-00-00 00:00:00' ? ' на ' . $dur : '') . ".\nПричина: $disreason\n" . $modcomment;
write_log("<a href=\"user_$user[id]\">$username</a> Отключен пользователем ".$CURUSER['username']." на $dur. Причина: $disreason","FF9900","bans");}
sql_query('INSERT INTO users_ban (userid, disuntil, disby, reason) VALUES ('.implode(', ', array_map('sqlesc', array($userid, $disuntil, $modifier, $disreason))).')') or sqlerr(__FILE__,__LINE__);
$updateset[] = "enabled = 'no'";}}
$updateset[] = "schoutboxpos = " . sqlesc($schoutboxpos);
$updateset[] = "comentoff = " . sqlesc($comentoff);
$updateset[] = "donor = " . sqlesc($donor);
$updateset[] = "supportfor = " . sqlesc($supportfor);
$updateset[] = "support = " . sqlesc($support);
$updateset[] = "title = " . sqlesc($title);
$updateset[] = "username = " . sqlesc($username0);
$updateset[] = "info = " . sqlesc($podpis);	
$updateset[] = "seeder = " . sqlesc($seederr);
$updateset[] = "leecher = " . sqlesc($leecherr);	
$updateset[] = "email = " . sqlesc($emails);
if(is_valid_id($country)) $updateset[] = "country = $country";
if(!empty($modcomm))$modcomment = date("Y-m-d") . " - Заметка от $CURUSER[username]: $modcomm\n" . $modcomment;
$updateset[] = "modcomment = " . sqlesc($modcomment);
if($_POST['resetkey']){$passkey = md5($CURUSER['username'].get_date_time().$CURUSER['passhash']);$updateset[] = "passkey = " . sqlesc($passkey);}
sql_query("UPDATE users SET ".implode(", ", $updateset) . " $birthday WHERE id = $userid") or sqlerr(__FILE__, __LINE__);$cache->delete('user_cache_'.$userid);
//////////////////////////////////
if(!empty($_POST["deluser"])){$res=@mysql_query("SELECT * FROM users WHERE id = $userid") or sqlerr(__FILE__, __LINE__);$user = mysql_fetch_array($res);
$username = $user["username"];$email=$user["email"];$avatar = $user['avatar']; if($avatar) unlink($user['avatar']);
mysql_query("DELETE FROM users WHERE id = $userid") or sqlerr(__FILE__, __LINE__);
mysql_query("UPDATE messages SET receiver = 2 WHERE receiver = $userid") or sqlerr(__FILE__,__LINE__);
mysql_query("DELETE FROM friends WHERE userid = $userid") or sqlerr(__FILE__,__LINE__);
mysql_query("DELETE FROM snatched WHERE userid = $userid") or sqlerr(__FILE__,__LINE__);
mysql_query("DELETE FROM friends WHERE friendid = $userid") or sqlerr(__FILE__,__LINE__);
mysql_query("DELETE FROM blocks WHERE userid = $userid") or sqlerr(__FILE__,__LINE__);
mysql_query("DELETE FROM blocks WHERE blockid = $userid") or sqlerr(__FILE__,__LINE__);
mysql_query("DELETE FROM bookmarks WHERE userid = $userid") or sqlerr(__FILE__,__LINE__);
mysql_query("DELETE FROM invites WHERE inviter = $userid") or sqlerr(__FILE__,__LINE__);
mysql_query("DELETE FROM peers WHERE userid = $userid") or sqlerr(__FILE__,__LINE__);
mysql_query("DELETE FROM checkcomm WHERE userid = $userid") or sqlerr(__FILE__,__LINE__);
mysql_query("DELETE FROM reqcomments WHERE user = $userid") or sqlerr(__FILE__,__LINE__); 
mysql_query("DELETE FROM requests WHERE userid = $userid") or sqlerr(__FILE__,__LINE__); 
mysql_query("DELETE FROM addedrequests WHERE userid = $userid") or sqlerr(__FILE__,__LINE__);
mysql_query("DELETE FROM sessions WHERE uid = $userid") or sqlerr(__FILE__,__LINE__);
$cache->delete('user_cache_'.$userid);
$deluserid=$CURUSER["username"];write_log("Пользователь $username был удален пользователем $deluserid");barf();print("<html><head><meta http-equiv=refresh content='4;url=$DEFAULTBASEURL'></head></html>");
}else{$returnto = htmlentities($_POST["returnto"]);header("Location: $returnto");}
}elseif($action == "confirmuser"){$userid = $_POST["userid"];$confirm = $_POST["confirm"];if(!is_valid_id($userid))stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
$updateset[] = "status = " . sqlesc($confirm);
$updateset[] = "last_login = ".sqlesc(get_date_time());
$updateset[] = "last_access = ".sqlesc(get_date_time());
mysql_query("UPDATE users SET ".implode(", ", $updateset)." WHERE id = $userid") or sqlerr(__FILE__, __LINE__);
$cache->delete('user_cache_'.$userid);
$returnto = htmlentities($_POST["returnto"]);
header("Location: $DEFAULTBASEURL/$returnto");}puke();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>