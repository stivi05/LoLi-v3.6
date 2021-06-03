<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
$search = unesc($_GET['search']);$class = $_GET['class'];if($class == 'All' || !is_valid_user_class($class))$class = '';
if($search != '' || $class){$query = " WHERE username LIKE '%".sqlwildcardesc("$search")."%'";if($search)$q = "search=".$search;}else{
$letter = trim($_GET["letter"]);if (strlen($letter) > 1)die;
if($letter != "" && strpos("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789><^*-|_", $letter) === false)$letter = "";
$query = ( $letter != "" ? " WHERE username LIKE '$letter%'" : "");if($letter != "")$q = "letter=$letter";}
if(is_valid_user_class($class)){$query .= " AND class = $class";$q .= ($q ? "&amp;" : "")."class=$class";}
stdhead("Пользователи");?>
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:30px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
.:: Пользователи ::.</td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;">
<center><form method="get" action="users">Поиск: <input id="searchinput" type="text" size="40" name="search" autocomplete="off" 
ondblclick="suggest(event.keyCode,this.value);" onkeyup="suggest(event.keyCode,this.value);" 
onkeypress="return noenter(event.keyCode);" value="<?=htmlspecialchars_uni($search)?>"><?
if(get_user_class() >= UC_ADMINISTRATOR){print("<select name='class'><option value='All'>(Все уровни)</option>");for($i = 0;;++$i){
if($c = get_user_class_name($i))print("<option value='$i'".(is_valid_user_class($class) && $class == $i ? " selected" : "").">$c</option>");else break;}
print("</select>");}print("<input type='submit' value='Вперед'></form>");?> 
<script src="js/users_suggest.js"></script><div id="suggcontainer" style="text-align:left;width:520px;display:none;"> 
<div id="suggestions" style="cursor:default;position:absolute;background-color:#FFFFFF;border:1px solid #777777;"></div></div><? print("<p>\n");
for($i = 1; $i < 10; ++$i){if($i == $letter)print("<b>$i</b>\n");elseif($i!=10)print("<a href='users.php?letter=$i'><b>$i</b></a>\n");} 
for($i = 97; $i < 123; ++$i){$l = chr($i);$L = chr($i - 32);if($l == $letter)print("<b>$L</b>\n");else print("<a href='users.php?letter=$l'><b>$L</b></a>\n");}
print("</p>");$q .= ($q ? "&amp;" : "");$page = $_GET['page'];$dt = gmtime() - 300;$dt = sqlesc(get_date_time($dt));
$res = sql_query("SELECT COUNT(id) FROM users$query") or sqlerr(__FILE__, __LINE__);$arr = mysql_fetch_row($res);$count = $arr[0];
$perpage = 12;list($pagertop, $pagerbottom, $limit) = pager2($perpage, $count, "users?".$q);
$res = sql_query("SELECT u.*, c.name, c.flagpic FROM users AS u LEFT JOIN countries AS c ON c.id = u.country$query ORDER BY added $limit") or sqlerr(__FILE__, __LINE__);
$num = mysql_num_rows($res);?></td></tr></table></td></tr></table><?if(mysql_num_rows($res) == 0){
echo "<table style='background:none;border:none;cellspacing:0;cellpadding:0;margin-top:7px;width:200px;float:center;'><tr><td style='margin-top:7px;width:250px;float:center;border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;-khtml-border-radius:5px;border:1px solid white;display:block;' class='a'><center><font style='font-family:tahoma;font-size:14px;font-weight:10;color:red;'><b>НЕТ юзеров по вашему запросу!</b></font></center></td></tr></table>";
}else{?><table style="margin-top:7px;background:none;cellspacing:0;cellpadding:0;width:100%;float:center;align:center;border:0;">
<tr><td align='center' style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'><?=$pagertop?></td></tr></table>
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;align:center;border:0;"><?$nc=1;for($i = 0; $i < $num; ++$i){
/////////////////////
while($arr = mysql_fetch_assoc($res)){if($nc == 1){print("<tr>");}
if($arr['country'] > 0){$country = "<img src='pic/flag/".$arr['flagpic']."' alt='".$arr['name']."' title='".$arr['name']."'/>";}else{$country = "<Не указанно";}
if($arr['added'] == '0000-00-00 00:00:00')$arr['added'] = '-';if($arr['last_access'] == '0000-00-00 00:00:00')$arr['last_access'] = '-';
if($arr["downloaded"] > 0){$ratio = number_format($arr["uploaded"] / $arr["downloaded"], 2);if(($arr["uploaded"] / $arr["downloaded"]) > 100)$ratio = "100+";
$ratio = "<font color='".get_ratio_color($ratio)."'>$ratio</font>";}elseif($arr["uploaded"] > 0) $ratio = "Inf.";else $ratio = "Inf.";
if($arr["gender"] == "1") $gender = "<img src='pic/male1.gif' alt='Парень' style='margin-left:4px;'/>";
elseif($arr["gender"] == "2") $gender = "<img src='pic/female1.gif' alt='Девушка' style='margin-left:4pt;'/>";
elseif($arr["gender"] == "3") $gender = "<img src='pic/transgenders.gif' alt='Трансгендер' style='margin-left:4pt;'/>";
if(!$arr[avatar]){$avatar=("<a href='user_".$arr['id']."'><img border='0' height='80px' title='".$arr['username']."' src='pic/default_avatar.gif'></a>");
}else{$avatar=("<a href='user_".$arr['id']."'><img height='80px' src='".$arr['avatar']."' title='".$arr['username']."'/></a>");}
print("<td style='padding:10px;width:240px;background:none;'><table style='background:none;'border='0' cellspacing='0'><tr>
<td style='border-radius:10px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:2px solid #E0FFFF;display:block;padding:10px;width:240px;' class='a'><table style='background:none;align:center;border:0;' width='240px'><tr><td class='embedded' width='90px' style='background:none;align:center;border:0;'><center>$avatar
</center></td><td class='embedded' valign='top' align='center' style='background:none;border:0;'><center>
<a class='altlink' href='user_".$arr['id']."'><b>".get_user_class_color($arr['class'],$arr['username'])."</b></a>".($arr["donated"] > 0 ? "
<img src='pic/star.gif' border='0' alt='Donor'/>" : "")."&nbsp;&nbsp;$gender<hr width='100px'>
".("'".$arr['last_access']."'">$dt?"<img src='pic/button_online.gif' border='0' alt='online'/>":"<img src='pic/button_offline.gif' border='0' alt='offline'/>" )."&nbsp;&nbsp;
<a href='#' onclick=\"javascript:window.open('sendpm_".$arr['id']."', 'Отправить PM', 'width=650, height=465');return false;\" title='Отправить ЛС'><img src='pic/pn_inbox.gif' border='0' title='PM'/></a>&nbsp;&nbsp;$country<br><br><img src='pic/multitracker.png' border='0' alt='Рейтинг'/>&nbsp;<b>$ratio</b></center></td></tr></table><hr width='200px'>
<table style='background:none;border:0;' width='240'><tr><td class='embedded' align='left' style='background:none;border:0;'>
<b>Зарегистрирован:</b>&nbsp;<font color='green'><b>".get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]))." ".$tracker_lang['ago']."</b>
</font></td></tr><tr><td class='embedded' width='150px' align='left' style='background:none;border:0;'><b>Последний визит:</b>&nbsp;<font color='blue'>
<b>".get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["last_access"]))." ".$tracker_lang['ago']."</b></font></td></tr></table></td></tr></table></td>");
++$nc;if($nc == 4){$nc=1;print("</tr>");}}}?></table><table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;align:center;border:0;">
<tr><td align='center' style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'><?=$pagerbottom?></td></tr></table>
<?}?><?stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>