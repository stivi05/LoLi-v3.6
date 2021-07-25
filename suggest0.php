<?php require_once("include/bittorrent.php");dbconn(false);gzip();if($CURUSER){
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && $_SERVER["REQUEST_METHOD"] == 'GET'){
$q = trim(strip_tags(unesc(base64_decode($_GET["q"]))));if(empty($q) || strlen($q) < 3){die();}
$res = mysql_query("SELECT t.id, t.name, t.added, t.free, t.category FROM torrents AS t WHERE t.name COLLATE UTF8_GENERAL_CI LIKE ".sqlesc("%$q%")." ORDER BY id DESC LIMIT 0,10;") or sqlerr(__FILE__, __LINE__);
print("<br><div><table><tr><td class='zaliwka' colspan='2' style='padding:5px;float:center;'>Результаты быстрого поиска</td></tr>");
if(mysql_num_rows($res) < 1){print("<tr><td style='padding:5px;'>Поиск не дал результатов</td></tr>");die();}
else{$i = 1;while ($row = mysql_fetch_array($res)){
switch ($row['category']){case '1': $cat = "<a href='HDAudio'><img class='audio' src='pic/trans.gif' title='HD-Музыка'/></a>";break;   
case '2': $cat = "<a href='MusVideo'><img class='musvid' src='pic/trans.gif' title='Музыкальные Видео'/></a>";break;   
case '3': $cat = "<a href='Animation'><img class='anime' src='pic/trans.gif' title='Анимация'/></a>";break;
case '4': $cat = "<a href='Movie'><img class='movie' src='pic/trans.gif' title='Фильмы'/></a>";break;
case '5': $cat = "<a href='TV-Show'><img class='tvshow' src='pic/trans.gif' title='Сериалы'/></a>";break;   
case '6': $cat = "<a href='Docum'><img class='docum' src='pic/trans.gif' title='Документалки'/></a>";break;   
case '7': $cat = "<a href='Sport'><img class='sport' src='pic/trans.gif' title='Спорт'/></a>";break;
case '8': $cat = "<a href='Demo'><img class='demo' src='pic/trans.gif' title='Demo'/></a>";break;}$cats = $cat;
switch ($row['free']){
case 'bril': $disname = "<b style='color:blue' title='Бриллиантовая раздача! Это значит, что кол-во розданного на этой раздаче удваивается!'>".$row['name']."</b>";break;
case 'yes': $disname = "<b style='color:#d08700' title='Золотая раздача! Это значит, что кол-во скачанного на этой раздаче не идет в общую статистику!'>".$row['name']."</b>";break;
case 'silver': $disname = "<b style='color:#778899' title='Серебрянная раздача! Это значит, что половина скачанного на этой раздаче не идет в общую статистику!'>".$row['name']."</b>";break;
case 'no': $disname = $row['name'];}$disnames = $disname;
print("<tr><td width='60px' border='none'>$cats</td><td style='border?:none;padding:0 10px;'>
<a href='details_".$row['id']."' title='".$row['name']."'>".preg_replace("#($q)#siu", "<span style='color:#FF0000'>\\1</span>", $disnames)."</a><br><small>".$row['added']."</small></td></tr>");
$i++;}}print("</table></div>");die();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body>
</html><?}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>