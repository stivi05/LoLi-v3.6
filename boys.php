<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
$res1 = sql_query("SELECT COUNT(id) FROM users WHERE gender = '1'");$row1 = mysql_fetch_array($res1);$count = $row1[0];$limit = 10; //Лимит на одной странице
list($pagertop, $pagerbottom, $limit) = pager($limit, $count, "boys.php?", array('nopage' => true));
stdhead("Парни нашего трекера");?><table style='background:none;margin-top:0;cellspacing:0;margin-top:7px;cellpadding:0;width:100%;float:center;'><tr>
<td style='border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:30px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;'>
.:: Парни нашего трекера <img src='pic/male0.gif'> :: посмотреть <a class='but' href='girls.php'>Девушки нашего трекера</a> :: или вы хотите посмотреть <a class='but' href='transgender.php'>Трансиков нашего трекера?</a> ::.</td></tr></table></td></tr></table><?
$dt = gmtime() - 300;$dt = sqlesc(get_date_time($dt));
$query_string = "SELECT id, username, avatar, added, country, downloaded, uploaded, class, birthday, last_access FROM users WHERE gender = '1' $limit";
$ress = sql_query($query_string) or die(mysql_error());$num = mysql_num_rows($ress);if($num > 0){?>
<table style="margin-top:7px;background:none;cellspacing:0;cellpadding:0;width:100%;float:center;align:center;border:0;">
<tr><td align='center' style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'><?=$pagertop?></td></tr></table>
<table style="margin-top:7px;background:none;cellspacing:0;cellpadding:0;width:100%;float:center;align:center;border:0;"><?
$nc=1;for($i = 0; $i < $num; ++$i){while($arr = mysql_fetch_assoc($ress)){if($nc == 1){print("<tr>");}
if($arr['country'] > 0){$country = "<img src=\"pic/flag/$arr[flagpic]\" alt=\"$arr[name]\" title=\"$arr[name]\">";}else{$country = "<Не указанно";}
$birthday = date("Y", strtotime($arr["birthday"]));$age = date("Y")-$birthday;if($arr['added'] == '0000-00-00 00:00:00')$arr['added'] = '-';
if($arr['last_access'] == '0000-00-00 00:00:00')$arr['last_access'] = '-';if($arr["downloaded"] > 0){$ratio = number_format($arr["uploaded"] / $arr["downloaded"], 2);
if(($arr["uploaded"] / $arr["downloaded"]) > 100)$ratio = "100+";$ratio = "<font color=\"".get_ratio_color($ratio)."\">$ratio</font>";}
elseif($arr["uploaded"] > 0) $ratio = "Inf.";else $ratio = "Inf.";$gender = "<img src=\"pic/male1.gif\" alt=\"Парень\" style=\"margin-left: 4pt\">";
if(!$arr[avatar]){$avatar=("<a href=user_$arr[id]><img border='0' height='80' title=$arr[username] src='pic/default_avatar.gif'></a>");
}else{$avatar=("<a href=user_$arr[id]><img height='80' src=$arr[avatar] title=$arr[username]></a>");}
print("<td style='padding:10px;width:240px;background:none;'><table style='background:none;'border='0' cellspacing='0'><tr>
<td style='padding:10px;width:240px;border-radius:10px;border:0;' class='a'><table style='background:none;align:center;border:0;' width='240px'>
<tr><td class='embedded' width='90' style='background:none;align:center;border:0;'><center>$avatar</center></td>
<td class='embedded' valign='top' align='center' style='background:none;border:0;'><center>
<a class='altlink' href='user_".$arr['id']."'><b>".get_user_class_color($arr['class'],$arr['username'])."</b></a>".($arr["donated"] > 0 ? "
<img src='pic/star.gif' border='0' alt='Donor'>" : "")."&nbsp;&nbsp;$gender<hr width='100'>
".("'".$arr['last_access']."'">$dt?"<img src='pic/button_online.gif' border='0' alt='online'/>":"<img src='pic/button_offline.gif' border='0' alt='offline'/>" )."&nbsp;&nbsp;
<a href='#' onclick=\"javascript:window.open('sendpm_".$arr['id']."', 'Отправить PM', 'width=650, height=465');return false;\" title='Отправить ЛС'><img src='pic/pn_inbox.gif' border='0' title='PM'/></a>&nbsp;&nbsp;$country<br/><br/><img src='pic/multitracker.png' border='0' alt='Рейтинг'/>&nbsp;<b>$ratio</b></center></td></tr></table><hr width='200'>
<table style=\"background:none;border:0;\" width='240'><tr><td class='embedded' align='left' style='background:none;border:0;'>
<b>Дата Рождения:</b>&nbsp;<font color='darkred'><b>".$arr['birthday']."&nbsp;(".$age." лет)</b></font></td></tr>
<tr><td class='embedded' align='left' style='background:none;border:0;'>
<b>Зарегистрирован:</b>&nbsp;<font color='green'><b>".get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]))." ".$tracker_lang['ago']."</b>
</font></td></tr><tr><td class='embedded' width='150' align='left' style='background:none;border:0;'><b>Последний визит:</b>&nbsp;<font color='blue'>
<b>".get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["last_access"]))." ".$tracker_lang['ago']."</b></font></td></tr></table></td></tr></table></td>");
++$nc;if($nc == 4){$nc=1;print("</tr>");}}}?></table>
<table style="margin-top:7px;background:none;cellspacing:0;cellpadding:0;width:100%;float:center;align:center;border:0;">
<tr><td align='center' style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'><?=$pagerbottom?></td></tr></table><?}else{
echo "<table style='background:none;border:none;cellspacing:0;cellpadding:0;margin-top:7px;width:200px;float:center;'><tr><td style='margin-top:7px;width:250px;float:center;border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;-khtml-border-radius:5px;border:1px solid white;display:block;' class='a'><center><font style='font-family:tahoma;font-size:14px;font-weight:10;color:red;'><b>НЕТ Парней на сайте, кругом одни бабы! Но гляньте еще на Трансиков! Они везде! Возможно они и у нас есть! Интересно? Сверху ссылка!</b></font></center></td></tr></table>";	
}?><?stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
