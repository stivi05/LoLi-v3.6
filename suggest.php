<?php require_once("include/bittorrent.php");dbconn(false);gzip();if($CURUSER){
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && $_SERVER["REQUEST_METHOD"] == 'GET'){$q = trim(strip_tags(unesc(base64_decode($_GET["q"]))));
if(empty($q) || strlen($q) < 3){die();}
$res = mysql_query("SELECT t.id, t.name, t.added, t.free, t.category, t.incategory FROM torrents AS t WHERE t.name COLLATE UTF8_GENERAL_CI LIKE ".sqlesc("%$q%")." ORDER BY id DESC LIMIT 0,10;") or sqlerr(__FILE__, __LINE__);
print("<div style=\"position:absolute;width:800px;\">");?><table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='b'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:25px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
Результаты быстрого поиска</td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;"><?if(mysql_num_rows($res) < 1){
print("<table style='background:none;margin-top:7px;cellspacing:0;cellpadding:0;width:300px;float:center;'><tr>
<td style='border-radius:15px;border:none;' class='a'><table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:20px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;'>
".$tracker_lang['nothing_found']."</td></tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table>");}
else{$i = 1;while ($row = mysql_fetch_array($res)){
switch ($row['category']){case '1': $cat = "<a href='HDAudio'><img class='audio' src='pic/trans.gif' title='HD-Музыка'/></a>";break;   
case '2': $cat = "<a href='MusVideo'><img class='musvid' src='pic/trans.gif' title='Музыкальные Видео'/></a>";break;   
case '3': $cat = "<a href='Animation'><img class='anime' src='pic/trans.gif' title='Анимация'/></a>";break;
case '4': $cat = "<a href='Movie'><img class='movie' src='pic/trans.gif' title='Фильмы'/></a>";break;
case '5': $cat = "<a href='TV-Show'><img class='tvshow' src='pic/trans.gif' title='Сериалы'/></a>";break;   
case '6': $cat = "<a href='Docum'><img class='docum' src='pic/trans.gif' title='Документалки'/></a>";break;   
case '7': $cat = "<a href='Sport'><img class='sport' src='pic/trans.gif' title='Спорт'/></a>";break;
case '8': $cat = "<a href='Demo'><img class='demo' src='pic/trans.gif' title='Demo'/></a>";break;}$cats = $cat;
switch ($row['incategory']){
case '1': $incat = "<a href='Lossless'><img class='lossless' src='pic/trans.gif' title='lossless'/></a>";break;
case '2': $incat = "<a href='DSD'><img class='dsd' src='pic/trans.gif' title='DSD'/></a>";break;
case '3': $incat = "<a href='DTS'><img class='dts' src='pic/trans.gif' title='DTS'/></a>";break;
case '4': $incat = "<a href='720p'><img class='sdp' src='pic/trans.gif' title='720p'/></a>";break;
case '5': $incat = "<a href='1080i'><img class='tvi' src='pic/trans.gif' title='1080i'/></a>";break;
case '6': $incat = "<a href='1080p'><img class='tvp' src='pic/trans.gif' title='1080p'/></a>";break;
case '7': $incat = "<a href='BD-REMUX'><img class='remux' src='pic/trans.gif' title='BD-REMUX'/></a>";break;
case '8': $incat = "<a href='BluRay'><img class='hddisc' src='pic/trans.gif' title='Blu Ray 1080p'/></a>";break;
case '9': $incat = "<a href='4K_UHDTV'><img class='uhdtv4k' src='pic/trans.gif' title='UHD 4K UHDTV'/></a>";break;
case '10': $incat = "<a href='4K_WEB-DL'><img class='uhd4kweb' src='pic/trans.gif' title='UHD 4K WEB-DL'/></a>";break;
case '11': $incat = "<a href='4K_BD-Rip'><img class='uhdrip' src='pic/trans.gif' title='UHD 4K BD-Rip'/></a>";break;
case '12': $incat = "<a href='4K_BD-REMUX'><img class='uhdremux' src='pic/trans.gif' title='UHD 4K BD-REMUX'/></a>";break;
case '13': $incat = "<a href='4K_BluRay'><img class='uhddisc' src='pic/trans.gif' title='UHD 4K Blu Ray'/></a>";break;
case '14': $incat = "<a href='8K_WEB-DL'><img class='uhd8kweb' src='pic/trans.gif' title='UHD 8K WEB-DL'/></a>";break;
case '15': $incat = "<a href='8K_MASTER'><img class='uhd8kmaster' src='pic/trans.gif' title='UHD 8K MASTER'/></a>";break;
case '16': $incat = "<a href='16K_WEB-DL'><img class='uhd16' src='pic/trans.gif' title='UHD 16K WEB-DL'/></a>";break;
case '17': $incat = "<a href='Exclusive'><img class='exclusive' src='pic/trans.gif' title='Exclusive'/></a>";break;}$incats = $incat;
switch ($row['free']){
case 'bril': $disname = "<b style='color:blue' title='Бриллиантовая раздача! Это значит, что кол-во розданного на этой раздаче удваивается!'>".$row['name']."</b>";break;
case 'yes': $disname = "<b style='color:#d08700' title='Золотая раздача! Это значит, что кол-во скачанного на этой раздаче не идет в общую статистику!'>".$row['name']."</b>";break;
case 'silver': $disname = "<b style='color:#778899' title='Серебрянная раздача! Это значит, что половина скачанного на этой раздаче не идет в общую статистику!'>".$row['name']."</b>";break;
case 'no': $disname = $row['name'];}$disnames = $disname;
print("<table style='background:none;border:none;cellspacing:0;cellpadding:0;margin-top:7px;width:100%;float:center;'><tr>
<td style='border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;-khtml-border-radius:5px;border:1px solid white;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td align='center' style='background:none;width:100%;float:center;border:0;'>
<table style='background:none;cellspacing:0;cellpadding:0;margin-top:0;width:100%;float:center;'><tr>
<td style='background:none;margin-left:20px;border:0;width:60px;' align='left'>$cats</td><td style='background:none;border:0;width:60px;' align='center'>$incats</td>
<td style='background:none;border:0;width:10px;' align='center'></td><td style='background:none;border:0;' align='left'>
<a href=\"details_".$row['id']."\">".preg_replace("#($q)#siu", "<span style='color:#FF0000'>\\1</span>", $disnames)."</font></a><hr align='left' width='300px'>
<span style='margin-top:4px;' class='badge-extra text-bold'>Релиз залит:&nbsp;".nicetime($row["added"], true)."</span>
</td></tr></table></td></tr></table></td></tr></table>");
$i++;}}print("</td></tr></table></td></tr></table></div>");die();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body>
</html><?}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>