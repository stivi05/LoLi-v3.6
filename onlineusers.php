<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && get_user_class() >= UC_MODERATOR){
//////////////////// Array ////////////////////
        $arrSystem['Windows 3.1'] = "Windows 3.1";
        $arrSystem['Win16'] = "Windows 3.1";
        $arrSystem['16bit'] = "Windows 3.1";
        $arrSystem['Win32'] = "Windows 95";
        $arrSystem['32bit'] = "Windows 95";
        $arrSystem['Win 32'] = "Windows 95";
        $arrSystem['Win95'] = "Windows 95";
        $arrSystem['Windows 95/NT'] = "Windows 95";
        $arrSystem['Win98'] = "Windows 98";
        $arrSystem['Windows 95'] = "Windows 95";
        $arrSystem['Windows 98'] = "Windows 98";
        $arrSystem['Windows NT 5.0'] = "Windows 2000";
        $arrSystem['Windows NT 5.1'] = "Windows XP";
        $arrSystem['Windows NT'] = "Windows NT";
        $arrSystem['WinNT'] = "Windows NT";
        $arrSystem['Windows ME'] = "Windows ME";
        $arrSystem['Windows CE'] = "Windows CE";
        $arrSystem['Windows'] = "Windows 95";
        $arrSystem['Mac_68000'] = "Macintosh";
        $arrSystem['Mac_PowerPC'] = "Macintosh";
        $arrSystem['Mac_68K'] = "Macintosh";
        $arrSystem['Mac_PPC'] = "Macintosh";
        $arrSystem['Macintosh'] = "Macintosh";
        $arrSystem['IRIX'] = "Unix";
        $arrSystem['SunOS'] = "Unix";
        $arrSystem['AIX'] = "Unix";
        $arrSystem['Linux'] = "Unix";
        $arrSystem['HP-UX'] = "Unix";
        $arrSystem['SCO_SV'] = "Unix";
        $arrSystem['FreeBSD'] = "Unix";
        $arrSystem['BSD/OS'] = "Unix";
        $arrSystem['OS/2'] = "OS/2";
        $arrSystem['WebTV/1.0'] = "WebTV/1.0";
        $arrSystem['WebTV/1.2'] = "WebTV/1.2";
        $arrBrowser['Lynx'] = "Lynx";
        $arrBrowser['libwww-perl'] = "Lynx";
        $arrBrowser['ia_archiver'] = "Crawler";
        $arrBrowser['ArchitextSpider'] = "Crawler";
        $arrBrowser['Lycos_Spider_(T-Rex)'] = "Crawler";
        $arrBrowser['Scooter'] = "Crawler";
        $arrBrowser['InfoSeek'] = "Crawler";
        $arrBrowser['AltaVista'] = "Crawler";
        $arrBrowser['Eule-Robot'] = "Crawler";
        $arrBrowser['SwissSearch'] = "Crawler";
        $arrBrowser['Checkbot'] = "Crawler";
        $arrBrowser['Crescent Internet ToolPak'] = "Crawler";
        $arrBrowser['Slurp'] = "Crawler";
        $arrBrowser['WiseWire-Widow'] = "Crawler";
        $arrBrowser['NetAttache'] = "Crawler";
        $arrBrowser['Web21 CustomCrawl'] = "Crawler";
        $arrBrowser['CheckUrl'] = "Crawler";
        $arrBrowser['LinkLint-checkonly'] = "Crawler";
        $arrBrowser['Namecrawler'] = "Crawler";
        $arrBrowser['ZyBorg'] = "Crawler";
        $arrBrowser['Googlebot'] = "Crawler";
        $arrBrowser['WebCrawler'] = "Crawler";
        $arrBrowser['WebCopier'] = "Crawler";
        $arrBrowser['JBH Agent 2.0'] = "Crawler";
////////////////////////
function getSystem($arrSystem,$userAgent){$system = 'Other';foreach($arrSystem as $key => $value){if (strpos($userAgent, $key) !== false){$system = $value;break;}}return $system;}
function getBrowser($arrBrowser,$userAgent){$version = "";$browser = 'Other';if (($pos = strpos($userAgent, 'Opera')) !== false){$browser = 'Opera';$pos += 6;
if ((($posEnd = strpos($userAgent, ';', $pos)) !== false) || (($posEnd = strpos($userAgent, ' ', $pos)) !== false))$version = trim(substr($userAgent, $pos, $posEnd - $pos));
}elseif (($pos = strpos($userAgent, 'MSIE')) !== false){$browser = 'Internet Explorer';$posEnd = strpos($userAgent, ';', $pos);
if ($posEnd !== false){$pos += 4;$version = trim(substr($userAgent, $pos, $posEnd - $pos));}
}elseif (((strpos($userAgent, 'Gecko')) !== false) && ((strpos($userAgent, 'Netscape')) === false)){$browser = 'Mozila';
if (($pos = strpos($userAgent, 'rv:')) !== false){$posEnd = strpos($userAgent, ')', $pos);if ($posEnd !== false){$pos += 3;$version = trim(substr($userAgent, $pos, $posEnd - $pos));}}
}elseif ((strpos($userAgent, ' I;') !== false) || (strpos($userAgent, ' U;') !== false) || (strpos($userAgent, ' U ;') !== false) || (strpos($userAgent, ' I)') !== false) || (strpos($userAgent, ' U)') !== false)){$browser = 'Netscape Navigator';if (($pos = strpos($userAgent, 'Netscape6')) !== false){$pos += 10;$version = trim(substr($userAgent, $pos, strlen($userAgent) - $pos));}else{
if (($pos = strpos($userAgent, 'Mozilla/')) !== false){if (($posEnd = strpos($userAgent, ' ', $pos)) !== false){$pos += 8;$version = trim(substr($userAgent, $pos, $posEnd - $pos));}}}}else{
foreach($arrBrowser as $key => $value){if (strpos($userAgent, $key) !== false){$browser = $value;break;}}}
$userAgentArr['browser'] = $browser;$userAgentArr['version'] = $version;return $userAgentArr;}
///////////////////////////////////////////////// 
stdhead("Где пользователь");begin_frame(".:: Где пользователь :: <font size=2><a class=altlink href='clear_session.php?action=clearlog'><b>Oчистить ВСЕ сессии</b></a></font> ::.");
$search = unesc($_GET["search"]);$search = htmlspecialchars($search);$search_cat = unesc($_GET["cat"]);$search_cat = intval($search_cat);
switch ($search_cat){default: $sql_r = "username";$check1 = "checked";break;case 1: $sql_r = "username";$check1 = "checked";break;
case 2: $sql_r = "url";$check2 = "checked";break;case 3: $check3 = "checked";break;}
if($search_cat != 3){if($search) $searchs = "$sql_r LIKE '%".sqlwildcardesc($search)."%'";}else{$searchs = "uid LIKE '%".sqlwildcardesc("-1")."%'";}
$res = sql_query("SELECT COUNT(*) FROM sessions WHERE ip <> '00.00.000.000' $searchs");$row = mysql_fetch_array($res);$count = $row[0];$per_list = 50;
list($pagertop, $pagerbottom, $limit) = pager2($per_list, $count, "onlineusers.php?");
$spy_res = sql_query("SELECT url, uid, username, class, ip, time, useragent FROM sessions WHERE ip <> '00.00.000.000' $searchs ORDER BY class ASC $limit");
?><table  class='embedded' cellspacing='0' cellpadding='3' align='center' width='100%'><tr><td width='100%' colspan='3' align='center'>
<table class='embedded' border='0' cellpadding='0' cellspacing='10' align='center'><form method='get' action='onlineusers.php'><tr>
<td class='embedded' align='center'><input type='text' name='search' size='40'  value='<?=htmlspecialchars($search)?>'/>&nbsp;&nbsp;&nbsp;По имени: 
<input name='cat' type='radio' value='1' <?=$check1?>>&nbsp;&nbsp;&nbsp;По адресу: <input name='cat' type='radio' value='2' <?=$check2?>>
&nbsp;&nbsp;&nbsp;Анонимные: <input name='cat' type='radio' value='3' <?=$check3?>></td><td class='embedded' align='center'>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class='btn' type='submit' value='Найти и отсортировать'/></td></form></tr></table></td></tr>
<script src='js/show_hide.js'></script><tr><td class='zaliwka' style='color:#FFFFFF;colspan:3;text-align:center;border:1;'>Пользователь</td>
<td class='zaliwka' style='color:#FFFFFF;colspan:3;text-align:center;border:1;' align='center'>Звание \ IP</td>
<td class='zaliwka' style='color:#FFFFFF;colspan:3;text-align:center;border:1;'>Просматривает</td></tr><?
if($per_list < $count){?><tr><td class='index' colspan='3' align='center'><?=$pagertop?></td></tr><?}
if (isset($searchs) && $count < 1){?><tr><td class='index' colspan='3' align='center'><?=$tracker_lang['nothing_found']?></td></tr><?}
$i=20;while(list($spy_url, $user_id, $user_name, $user_class, $user_ip, $time, $user_agent) = mysql_fetch_array($spy_res)){
$i++;$spy_urlse = basename($spy_url);$res_list = explode(".php", $spy_urlse);$brawser = getBrowser($arrBrowser,$user_agent);$read = "";
if($CURUSER['id'] == $user_id){$read = "<font color='red'>(Вы здесь)</font>";}
$slep = "<span style='cursor:pointer;' onclick=\"javascript:show_hide('s$i')\">
<img title='рacкрыть' tooltip='рacкрыть' src='pic/plus.gif' id='pics$i' border='0'></span><span id='ss$i' style='display:none;'>
<br>Браузер - ".$brawser['browser']." V.".$brawser['version']."<br>Ос - ".getSystem($arrSystem,$user_agent)."<br>IP - 
<a target='_blank' href='https://db-ip.com/".$user_ip."'>". $user_ip."</a><br></span>";
if($user_class != -1){?><tr><td align='center'><a target='_blank' href='userdetails.php?id=<?=$user_id?>'><?=get_user_class_color($user_class, $user_name)?></a> <?=$slep?></td>
<td align='center'><b><?=get_user_class_name($user_class)?></b></td><td align='center'><?}else{?>
<tr><td align='center'><a target='_blank' href='https://db-ip.com/<?=$user_ip?>'>Гость</a> <?=$slep?></td><td align='center'><?=$user_ip?></td><td align='center'><?}
?><font size='1' color='grey'><i><?=nicetime($time, true)?></i></font>&nbsp;<img src='pic/icon_topic.gif' border='0'/>&nbsp;<a target='_blank' href='<?=$spy_url?>'><?=$spy_url?></a> <?=$read?></td></tr><?}
if($per_list < $count){?><tr><td class='index' colspan='3' align='center'><?=$pagerbottom?></td></tr></td></tr><?}
?></table><?end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
