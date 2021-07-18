<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){global $DEFAULTBASEURL;$action = $_GET["action"];
if($action == "add"){if($_SERVER["REQUEST_METHOD"] == "POST"){
$torrentid = intval($_POST["tid"]);if(!is_valid_id($torrentid)) stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
$res = sql_query("SELECT name FROM torrents WHERE id = $torrentid") or sqlerr(__FILE__,__LINE__);
$arr = mysql_fetch_array($res);if(!$arr) stderr2($tracker_lang['error'], $tracker_lang['no_torrent_with_such_id']);
$name = $arr[0];$text = trim(format_comment($_POST["text"]));$text1 = trim($_POST["text"]);
if(!$text) stderr2($tracker_lang['error'], $tracker_lang['comment_cant_be_empty']);
sql_query("INSERT INTO comments (user, torrent, added, text, text_html, ori_text_html, ip) VALUES (".$CURUSER["id"].",$torrentid, 
'".get_date_time()."', ".sqlesc($text1).", ".sqlesc($text).", ".sqlesc($text).", ".sqlesc(getip()).")");
$newid = mysql_insert_id();sql_query("UPDATE torrents SET comments = comments + 1 WHERE id = $torrentid");
/////////////////СЛЕЖЕНИЕ ЗА КОММЕНТАМИ///////////////// 
$res3 = sql_query("SELECT user, torrent FROM comments WHERE torrent = $torrentid GROUP BY user") or sqlerr(__FILE__,__LINE__);
$subject = "Новый комментарий";
$resd = sql_query("SELECT class, avatar, username FROM users WHERE id=2");$userd = mysql_fetch_assoc($resd);
$sender_class = $userd['class'];$sender_username = $userd['username'];$sender_avatar = $userd['avatar'];
while($arr3 = mysql_fetch_array($res3)){
$msg = "Для торрента [url=$DEFAULTBASEURL/details_$torrentid&viewcomm=$newid#comm$newid]".$name."[/url] добавился новый комментарий.";
if ($CURUSER[id] != $arr3['user']){
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, added, msg, subject) VALUES 
(2, $sender_class, ".sqlesc($sender_username).", ".sqlesc($sender_avatar).", $arr3[user], '".get_date_time()."', ".sqlesc($msg).", ".sqlesc($subject).")");}}
/////////////////СЛЕЖЕНИЕ ЗА КОММЕНТАМИ/////////////////
header("Refresh: 0; url=details_$torrentid&viewcomm=$newid#comm$newid");die;}$torrentid = intval($_GET["tid"]);
if(!is_valid_id($torrentid)) stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
$res = sql_query("SELECT name FROM torrents WHERE id = $torrentid") or sqlerr(__FILE__,__LINE__);
$arr = mysql_fetch_array($res);if(!$arr) stderr2($tracker_lang['error'], $tracker_lang['no_torrent_with_such_id']);
stdhead("Добавление комментария к .:: ".$arr["name"]." ::.");begin_frame("Добавление комментария к .:: ".$arr["name"]." ::.");
print("<table style='background:none;border:none;' class='main' width='100%' cellspacing='0' cellpadding='3'>
<form name='comment' method='post' action='comment.php?action=add'>");
print("<input type='hidden' name='tid' value=\"$torrentid\">");?><tr><td style='background:none;border:none;'>
<?textbbcode("comment","text","");?></td></tr><tr><td style='background:none;border:none;'>
<table width='100%' style='background:none;border:none;' cellpadding='5' cellspacing='0' align='center'>
<img class='editorbutton' OnClick=\"AddSmile(' :ah:')\" title='ah' height='40' border='0' src='pic/smilies/ah.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :angry2:')\" title='angry2' height='40' border='0' src='pic/smilies/angry2.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :bah:')\" title='bah' height='40' border='0' src='pic/smilies/bah.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :bye:')\" title='bye' height='40' border='0' src='pic/smilies/bye.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cool2:')\" title='cool' height='40' border='0' src='pic/smilies/cool.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry:')\" title='cry1' height='40' border='0' src='pic/smilies/cry1.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry2:')\" title='cry2' height='40' border='0' src='pic/smilies/cry2.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry3:')\" title='cry3' height='40' border='0' src='pic/smilies/cry3.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :good:')\" title='good' height='40' border='0' src='pic/smilies/good.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :haha:')\" title='haha' height='40' border='0' src='pic/smilies/haha.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :happy:')\" title='happy' height='40' border='0' src='pic/smilies/happy.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hehe:')\" title='hehe' height='40' border='0' src='pic/smilies/hehe.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hi2:')\" title='hi' height='40' border='0' src='pic/smilies/hi.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hm:')\" title='hmm' height='40' border='0' src='pic/smilies/hmm.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :huh2:')\" title='huh' height='40' border='0' src='pic/smilies/huh.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :dead:')\" title='imdead' height='40' border='0' src='pic/smilies/imdead.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :khekhe:')\" title='khekhe' height='40' border='0' src='pic/smilies/khekhe.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :roar:')\" title='roar' height='40' border='0' src='pic/smilies/roar.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :stfu:')\" title='stfu' height='40' border='0' src='pic/smilies/stfu.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :tired:')\" title='tired1' height='40' border='0' src='pic/smilies/tired1.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :uhuh:')\" title='uhuh' height='40' border='0' src='pic/smilies/uhuh.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :wat:')\" title='wat1' height='40' border='0' src='pic/smilies/wat1.gif'/></table><br></td></tr><?
print("<tr><td style='background:none;border:none;' align='center' colspan='2'><input type='submit' class='btn' value='Добавить'></td></tr></form></table>");
$res = sql_query("SELECT comments.id, comments.text_html, comments.ip, comments.added, users.username, users.title, users.class, users.id as user, users.avatar, 
users.donor, users.enabled, users.warned, users.parked FROM comments LEFT JOIN users ON comments.user = users.id WHERE torrent = $torrentid ORDER BY comments.id DESC LIMIT 5");
$allrows = array();while ($row = mysql_fetch_array($res)) $allrows[] = $row;
if (count($allrows)){print("<h2>Последние комментарии, в обратном порядке</h2>");commenttable($allrows);}
end_frame();stdfoot();die;}
////////////////
elseif($action == "quote"){$commentid = intval($_GET["cid"]);
if (!is_valid_id($commentid)) stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
$res = sql_query("SELECT c.*, t.name, t.id AS tid, u.username FROM comments AS c LEFT JOIN torrents AS t ON c.torrent = t.id JOIN users AS u ON c.user = u.id 
WHERE c.id=$commentid") or sqlerr(__FILE__,__LINE__);
$arr = mysql_fetch_array($res);if(!$arr) stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
stdhead("Добавление комментария к ".$arr["name"]);begin_frame(".:: Добавление комментария к :: ".$arr["name"]." ::.");
$text = "[quote=$arr[username]]\n".$arr["text"]."\n[/quote]";
print("<form method='post' name='comment' action='addcom'>
<input type='hidden' name='tid' value=\"$arr[tid]\"><table style='background:none;border:none;' cellspacing='1' width='100%'><tr>
<td style='background:none;border:none;' align='center'>");
textbbcode("comment","text",htmlspecialchars_uni($text));
print("</td></tr><tr><td style='background:none;border:none;'>
<table width='100%' style='background:none;border:none;' cellpadding='5' cellspacing='0' align='center'>
<img class='editorbutton' OnClick=\"AddSmile(' :ah:')\" title='ah' height='40' border='0' src='pic/smilies/ah.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :angry2:')\" title='angry2' height='40' border='0' src='pic/smilies/angry2.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :bah:')\" title='bah' height='40' border='0' src='pic/smilies/bah.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :bye:')\" title='bye' height='40' border='0' src='pic/smilies/bye.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cool2:')\" title='cool' height='40' border='0' src='pic/smilies/cool.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry:')\" title='cry1' height='40' border='0' src='pic/smilies/cry1.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry2:')\" title='cry2' height='40' border='0' src='pic/smilies/cry2.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry3:')\" title='cry3' height='40' border='0' src='pic/smilies/cry3.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :good:')\" title='good' height='40' border='0' src='pic/smilies/good.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :haha:')\" title='haha' height='40' border='0' src='pic/smilies/haha.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :happy:')\" title='happy' height='40' border='0' src='pic/smilies/happy.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hehe:')\" title='hehe' height='40' border='0' src='pic/smilies/hehe.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hi2:')\" title='hi' height='40' border='0' src='pic/smilies/hi.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hm:')\" title='hmm' height='40' border='0' src='pic/smilies/hmm.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :huh2:')\" title='huh' height='40' border='0' src='pic/smilies/huh.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :dead:')\" title='imdead' height='40' border='0' src='pic/smilies/imdead.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :khekhe:')\" title='khekhe' height='40' border='0' src='pic/smilies/khekhe.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :roar:')\" title='roar' height='40' border='0' src='pic/smilies/roar.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :stfu:')\" title='stfu' height='40' border='0' src='pic/smilies/stfu.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :tired:')\" title='tired1' height='40' border='0' src='pic/smilies/tired1.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :uhuh:')\" title='uhuh' height='40' border='0' src='pic/smilies/uhuh.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :wat:')\" title='wat1' height='40' border='0' src='pic/smilies/wat1.gif'/></table><br></td></tr>
<tr><td style='background:none;border:none;' align='center' colspan='2'><input type='submit' value='Добавить' class='btn'></td></tr></form></table>");
end_frame ();stdfoot();}
/////////////////////////////
elseif ($action == "edit"){$commentid = intval($_GET["cid"]);
if (!is_valid_id($commentid)) stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
$res = sql_query("SELECT c.*, t.name, t.id AS tid FROM comments AS c LEFT JOIN torrents AS t ON c.torrent = t.id WHERE c.id=$commentid") or sqlerr(__FILE__,__LINE__);
$arr = mysql_fetch_array($res);if(!$arr) stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
if($arr["user"] != $CURUSER["id"] && get_user_class() < UC_MODERATOR) stderr2($tracker_lang['error'], $tracker_lang['access_denied']);
if($_SERVER["REQUEST_METHOD"] == "POST"){
$text = format_comment($_POST["text"]);$text1 = $_POST["text"];$returnto = $_POST["returnto"];
if($text == "") stderr2($tracker_lang['error'], $tracker_lang['comment_cant_be_empty']);
if($text1 == "") stderr2($tracker_lang['error'], $tracker_lang['comment_cant_be_empty']);
$orig_text = $text;$text = sqlesc($text);$text1 = sqlesc($text1);$editedat = sqlesc(get_date_time());
sql_query("UPDATE comments SET text=$text1, text_html=$text, editedat=$editedat, editedby=$CURUSER[id] WHERE id=$commentid") or sqlerr(__FILE__, __LINE__);
if ($returnto) header("Location: $returnto");else header("Location: $DEFAULTBASEURL/");die;}
stdhead("Редактирование комментария к .:: ".$arr["name"]." ::.");begin_frame(".:: Редактирование комментария к :: ".$arr["name"]." ::.");
print("<table style='background:none;border:none;' class='main' width='100%' cellspacing='0' cellpadding='3'>
<form method='post' name='comment' action=\"editcom_$commentid\">
<input type='hidden' name='returnto' value=\"details_{$arr["tid"]}&viewcomm=$commentid#comm$commentid\"/>
<input type='hidden' name='cid' value=\"$commentid\" />");
?><tr><td style='background:none;border:none;'>
<?textbbcode("comment","text",htmlspecialchars_uni($arr["text"]));?></td></tr>
<tr><td style='background:none;border:none;'>
<table width='100%' style='background:none;border:none;' cellpadding='5' cellspacing='0' align='center'>
<img class='editorbutton' OnClick=\"AddSmile(' :ah:')\" title='ah' height='40' border='0' src='pic/smilies/ah.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :angry2:')\" title='angry2' height='40' border='0' src='pic/smilies/angry2.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :bah:')\" title='bah' height='40' border='0' src='pic/smilies/bah.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :bye:')\" title='bye' height='40' border='0' src='pic/smilies/bye.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cool2:')\" title='cool' height='40' border='0' src='pic/smilies/cool.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry:')\" title='cry1' height='40' border='0' src='pic/smilies/cry1.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry2:')\" title='cry2' height='40' border='0' src='pic/smilies/cry2.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :cry3:')\" title='cry3' height='40' border='0' src='pic/smilies/cry3.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :good:')\" title='good' height='40' border='0' src='pic/smilies/good.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :haha:')\" title='haha' height='40' border='0' src='pic/smilies/haha.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :happy:')\" title='happy' height='40' border='0' src='pic/smilies/happy.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hehe:')\" title='hehe' height='40' border='0' src='pic/smilies/hehe.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hi2:')\" title='hi' height='40' border='0' src='pic/smilies/hi.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :hm:')\" title='hmm' height='40' border='0' src='pic/smilies/hmm.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :huh2:')\" title='huh' height='40' border='0' src='pic/smilies/huh.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :dead:')\" title='imdead' height='40' border='0' src='pic/smilies/imdead.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :khekhe:')\" title='khekhe' height='40' border='0' src='pic/smilies/khekhe.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :roar:')\" title='roar' height='40' border='0' src='pic/smilies/roar.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :stfu:')\" title='stfu' height='40' border='0' src='pic/smilies/stfu.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :tired:')\" title='tired1' height='40' border='0' src='pic/smilies/tired1.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :uhuh:')\" title='uhuh' height='40' border='0' src='pic/smilies/uhuh.gif'/>
<img class='editorbutton' OnClick=\"AddSmile(' :wat:')\" title='wat1' height='40' border='0' src='pic/smilies/wat1.gif'/></table></td></tr>
<tr><td style='background:none;border:none;'><center><?
print("<input type='submit' class='btn' value='Отредактировать'/></center></td></tr></form></table>");end_frame();stdfoot();die;}
////////////////////
elseif($action == "delete"){if (get_user_class() < UC_MODERATOR) stderr2($tracker_lang['error'], $tracker_lang['access_denied']);
$commentid = intval($_GET["cid"]);if(!is_valid_id($commentid)) stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
$res = sql_query("SELECT torrent FROM comments WHERE id=$commentid") or sqlerr(__FILE__,__LINE__);$arr = mysql_fetch_array($res);
if($arr) $torrentid = $arr["torrent"];sql_query("DELETE FROM comments WHERE id=$commentid") or sqlerr(__FILE__,__LINE__);
if($torrentid && mysql_affected_rows() > 0) sql_query("UPDATE torrents SET comments = comments - 1 WHERE id = $torrentid");	
list($commentid) = mysql_fetch_row(sql_query("SELECT id FROM comments WHERE torrent = $torrentid ORDER BY added DESC LIMIT 1"));
$returnto = "details_$torrentid&viewcomm=$commentid#comm$commentid";
if($returnto) header("Location: $returnto");else header("Location: $DEFAULTBASEURL/");die;}
//////////////////////
elseif ($action == "vieworiginal"){
if (get_user_class() < UC_MODERATOR) stderr2($tracker_lang['error'], $tracker_lang['access_denied']);$commentid = intval($_GET["cid"]);
if(!is_valid_id($commentid)) stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
$res = sql_query("SELECT c.*, t.name, t.id AS tid FROM comments AS c LEFT JOIN torrents AS t ON c.torrent = t.id WHERE c.id=$commentid") or sqlerr(__FILE__,__LINE__);
$arr = mysql_fetch_array($res);if(!$arr) stderr2($tracker_lang['error'], "Неверный идентификатор $commentid.");
stdhead("Просмотр оригинала комментария №$commentid к .:: ".$arr["name"]." ::.");
begin_frame(".:: Просмотр оригинала комментария №$commentid к :: ".$arr["name"]." ::.");
print("<table style='background:none;border:none;' width='100%' border='0' cellspacing='0' cellpadding='0'><tr>
<td style='background:none;border:none;' class='comment'>".$arr["ori_text_html"]."</td></tr></table>");
$returnto = "details_{$arr["tid"]}&viewcomm=$commentid#comm$commentid";if($returnto) print("<p><font size='small'><a href='$returnto'>Назад</a></font></p>\n");
end_frame();stdfoot();die;}
//////////////////
else stderr2($tracker_lang['error'], "Unknown action");die;}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>