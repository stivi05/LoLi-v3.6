<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && get_user_class() >= UC_MODERATOR){
stdhead("Повторяющиеся IP пользователей");begin_frame("Повторяющиеся IP пользователей");
$res = sql_query("SELECT count(*) AS dupl, ip FROM users GROUP BY ip ORDER BY dupl DESC") or sqlerr(__FILE__, __LINE__);
print("<table style='background:none;width:100%;border:0;'><tr><td class='zaliwka' style='font-weight:bold;color:#FFFFFF;width:90px;' align='center'>Пользователь</td>
<td class='zaliwka' style='font-weight:bold;color:#FFFFFF;width:70px;' align='center'>Email</td>
<td class='zaliwka' style='font-weight:bold;color:#FFFFFF;width:70px;' align='center'>Регистрация</td>
<td class='zaliwka' style='font-weight:bold;color:#FFFFFF;width:75px;' align='center'>Посл.&nbsp;Активность</td>
<td class='zaliwka' style='font-weight:bold;color:#FFFFFF;width:70px;' align='center'>Скачал</td>
<td class='zaliwka' style='font-weight:bold;color:#FFFFFF;width:70px;' align='center'>Раздал</td>
<td class='zaliwka' style='font-weight:bold;color:#FFFFFF;width:45px;' align='center'>Рейтинг</td>
<td class='zaliwka' style='font-weight:bold;color:#FFFFFF;width:125px;' align='center'>IP</td>
<td class='zaliwka' style='font-weight:bold;color:#FFFFFF;width:40px;' align='center'>Пир</td></tr>");
while($ras = mysql_fetch_assoc($res)){if($ras["dupl"] <= 1)break;
$ros = sql_query("SELECT id, username, class, email, added, last_access, downloaded, uploaded, warned, donor, enabled, (seeder + leecher) AS peer_count 
FROM users WHERE ip='".$ras['ip']."' ORDER BY id DESC") or sqlerr(__FILE__, __LINE__);while($arr = mysql_fetch_assoc($ros)){
if($arr['added'] == '0000-00-00 00:00:00')$arr['added'] = 'никогда';if($arr['last_access'] == '0000-00-00 00:00:00')$arr['last_access'] = 'никогда';
if($arr["downloaded"] != 0)$ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3);else $ratio = "inf.";
$ratio = "<font color=".get_ratio_color($ratio).">$ratio</font>";$uploaded = mksize($arr["uploaded"]);$downloaded = mksize($arr["downloaded"]);
$added = substr($arr['added'], 0, 10);$last_access = substr($arr['last_access'], 0, 10);
print("<tr><td align='center'><b><a href='user_".$arr['id']."'>".get_user_class_color($arr['class'], $arr['username'])."</b></a>".get_user_icons($arr)."</td>
<td align='center'>$arr[email]</td><td align='center'>$added</td><td align='center'>$last_access</td><td align='center'>$downloaded</td><td align='center'>$uploaded</td>
<td align='center'>$ratio</td><td align='center'><span style='font-weight:bold;'>".$ras['ip']."</span></td><td align='center'>
".($arr['peer_count'] > 0 ? "<span style='color:red;font-weight:bold;'>Да</span>" : "<span style='color:green;font-weight:bold;'>Нет</span>")."</td></tr>");
}}print("</table>");end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>