<?php if (!defined('BLOCK_FILE')){Header("Location: ../index.php");exit;}global $CURUSER, $use_sessions;  
$a = mysql_fetch_array(sql_query("SELECT id, username FROM users WHERE status='confirmed' ORDER BY id DESC LIMIT 1"));  
if($CURUSER) $latestuser = "<a href=user_".$a["id"]." class='online'>".$a["username"]."</a>";else $latestuser = $a['username'];  
$title_who = array();$dt = sqlesc(time() - 300);if($use_sessions){
$result = mysql_query("SELECT s.uid, s.username, s.class FROM sessions AS s WHERE s.time > $dt GROUP BY s.username ORDER BY s.class DESC");}else{ 
$result = mysql_query("SELECT u.id, u.username, u.class FROM users AS u WHERE u.last_access > ".sqlesc(get_date_time(time() - 300))." GROUP BY u.username ORDER BY u.class DESC");}
while(list($uid, $uname, $class) = mysql_fetch_row($result)){if(!empty($uname)){  
$title_who[] = "<a href='user_".$uid."' class='online'>".get_user_class_color($class, $uname)."</a>";}  
if($class == UC_VLADELEC){$staff++;}elseif(empty($uname)){$guests++;}elseif($class == UC_USER){$users++;}elseif($class == UC_ADMINISTRATOR){$admin++;  
}elseif($class == UC_MODERATOR){$moder++;}elseif($class == UC_VIP){$vip++;}elseif($class == UC_720p){$pu++;}elseif($class == UC_UPLOADER){$upload++;}$total++;  
if(empty($uname)) continue;else $who_online .= $title_who;}  
if($staff == "") $staff = 0;if($admin == "") $admin = 0;if($moder == "") $moder = 0;if($vip == "") $vip = 0;if($upload == "") $upload = 0;
if($guests == "") $guests = 0;if($users == "") $users = 0;if($total == "") $total = 0;  
$content .= "<script src='js/show_hide.js'></script><table border='0' width='100%'><tr valign='middle'><td align='left' class='embedded'>
<b>Последний пользователь: </b> $latestuser<hr></td></tr></table>";if(count($title_who)){  
$content .= "<table border='0' width='100%'><tr valign='middle'><td align='left' class='embedded'>
<span style='cursor: pointer;' onclick='javascript: show_hide('s".$array["id"]."')'>
<img border='0' src='pic/plus.gif' id='pics".$array["id"]."' title='Скрыть'/><b>Кто онлайн: </b></td></span></tr><tr><td class='embedded'>
<span id='ss".$array["id"]."' style='display: none;'>".@implode(", ", $title_who)."</span><hr></td></tr></table>";}else{  
$content .= "<table border='0' width='100%'><tr valign='middle'><td align='left' class='embedded'><b>Кто онлайн: </b>Нет пользователей за последние 10 минут.<hr></td></tr></table>";}  
$content .= "<table border='0' width='100%'><tr valign='middle'><td colspan='2' align='left' class='embedded'><b>В сети: </b></td></tr>
<tr><td class='embedded'><img src='pic/info/sysop.gif'/></td><td width='90%' class='embedded'><font color='#0F6CEE'>Директоров:</font> $staff</td></tr>
<tr><td class='embedded'><img src='pic/info/admin.gif'/></td><td width='90%' class='embedded'><font color='green'>Администраторов:</font> $admin</td>
</tr><tr><td class='embedded'><img src='pic/info/moder.gif'/></td><td width='90%' class='embedded'><font color='red'>Модераторов:</font> $moder</td>
</tr><tr><td class='embedded'><img src='pic/info/vip.gif'/></td><td width='90%' class='embedded'><font color='#9C2FE0'>Vip'ов:</font> $vip</td></tr>
<tr><td class='embedded'><img src='pic/info/uploader.png'/></td><td width='90%' class='embedded'><font color='orange'>Аплоадеров:</font> $upload</td></tr>
<tr><td class='embedded'><img src='pic/info/uploader.gif'/></td><td width='90%' class='embedded'><font color='#FF00FF'>Опытных Пользователей: $pu</td></tr>
<tr><td class='embedded'><img src='pic/info/member.gif'/></td><td width='90%' class='embedded'><font color='#306A82'>Пользователей: $users</td></tr>
<tr><td class='embedded'><img src='pic/info/guest.gif'/></td><td width='90%' class='embedded'>Гостей: $guests</td></tr>
<tr><td class='embedded'><img src='pic/info/group.gif'/></td><td width='90%' class='embedded'>Всего: $total</td></tr></table>";?>