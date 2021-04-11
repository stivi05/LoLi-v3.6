<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){$res = mysql_query("SELECT id, name FROM categories ORDER BY name");
while($cat = mysql_fetch_assoc($res))$catoptions .= "<input type='checkbox' name='cat[]' value='$cat[id]'/>$cat[name]<br>";$category[$cat['id']] = $cat['name'];
$res2 = mysql_query("SELECT id, name FROM incategories ORDER BY name");while($incat = mysql_fetch_assoc($res2))
$incatoptions .= "<input type='checkbox' name='incat[]' value='$incat[id]'/>$incat[name]<br>";$incategory[$incat['id']] = $incat['name'];
stdhead("RSS");begin_frame(".:: RSS ::.");if($_SERVER['REQUEST_METHOD'] == "POST"){$link = "$DEFAULTBASEURL/rss.php";
if($_POST['feed'] == "dl")$query[] = "feed=dl";if(isset($_POST['cat']))$query[] = "cat=".@implode(',', $_POST['cat']);
if(isset($_POST['incat']))$query[] = "incat=".@implode(',', $_POST['incat']);if($_POST['login'] == "passkey")$query[] = "passkey=$CURUSER[passkey]";
$queries = @implode("&", $query);if ($queries)$link .= "?$queries";
stdmsg("<center>".$tracker_lang['success']."</center>", "<center><b>Используйте этот адрес в вашей программе для чтения RSS:</b><br><a href='$link'>$link</a></center>");
end_frame();stdfoot();die();}?>
<FORM method="POST" action="getrss.php"><table width="100%" border=0 align="center" class="embedded" cellspacing="0" cellpadding="5"><TR><TD class="rowhead">Жанры:</TD><TD>
<?=$catoptions?><span class="small">Если вы не выберете Жанр для просмотра,<br> вам будет выдана ссылка на все Жанры.</span></TD></TR><TR><TD class="rowhead">Типы:</TD><TD>
<?=$incatoptions?><span class="small">Если вы не выберете Тип для просмотра,<br> вам будет выдана ссылка на все Типы.</span></TD></TR><TR><TD class="rowhead">Тип ссылки в RSS:</TD>
<TD><INPUT type="radio" name="feed" value="web" checked />Ссылка на страницу<BR><INPUT type="radio" name="feed" value="dl" />Ссылка на скачивание</TD></TR><TR>
<TD class="rowhead">Тип логина:</TD><TD><INPUT type="radio" name="login" value="cookie" />Стандарт (cookies)<BR><INPUT type="radio" name="login" value="passkey" checked />
Альтернативный (passkey)</TD></TR><TR><TD colspan="2" align="center"><BUTTON type="submit">Сгенерировать RSS ссылку</BUTTON></TD></TR></TABLE></FORM>
<?end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>