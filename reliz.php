<?php require_once("include/bittorrent.php");dbconn(false);gzip();if($CURUSER && get_user_class() >= UC_SYSOP){
///////////////////// I N C A T reliz \\\\\\\\\\\\\\\\\\\\\\\\\\\\
function bark($msg){genbark($msg, $tracker_lang ['error']);}
function relizcategory(){stdhead("Релиз-группы");
///////////////////// D E L E T E C A T E G O R Y reliz \\\\\\\\\\\\\\\\\\\\\\\\\\\\
$sure = $_GET ['sure'];if($sure == "yes"){begin_frame(".:: Релиз-группы ::.", "100", true);
$delid = (int)$_GET['delid'];$query = "DELETE FROM reliz WHERE id=".sqlesc($delid)." LIMIT 1";$sql = mysql_query($query) or sqlerr(__FILE__, __LINE__);
echo("<center>Релиз-группа успешно удалена! [ <a href='reliz.php'>Назад</a> ]</center>");end_frame();stdfoot();die();}
$delid = (int)$_GET['delid'];$name = htmlspecialchars_uni($_GET ['reliz']);if($delid > 0){begin_frame(".:: Релиз-группы ::.", "100", true);
echo ("<center>Вы действительно хотите удалить эту Релиз-группу? ($name) ( <strong><a href=\"".$_SERVER ['PHP_SELF']."?delid=$delid&reliz=$name&sure=yes\">Да</a></strong> / 
<strong><a href=\"".$_SERVER ['PHP_SELF']."\">Нет</a></strong> )</center>");end_frame();stdfoot();die();}
///////////////////// E D I T A C A T E G O R Y reliz \\\\\\\\\\\\\\\\\\\\\\\\\\\\
$edited = $_GET['edited'];if($edited == 1){$id = (int)$_GET['id'];$reliz_name = htmlspecialchars_uni($_GET['reliz_name']);
$reliz_img = htmlspecialchars_uni($_GET ['reliz_img']);$reliz_sort = (int)$_GET['reliz_sort'];
$query = "UPDATE reliz SET name = ".sqlesc($reliz_name).", image = ".sqlesc($reliz_img).", sort = ".sqlesc($reliz_sort)." WHERE id=".sqlesc($id);
$sql = mysql_query($query) or sqlerr(__FILE__, __LINE__);if($sql){begin_frame("Релиз-группы", "100", true);
echo("<table class='main' cellspacing='0' cellpadding='5' width='100%'><tr><td><div align='center'>Ваша Релиз-группа отредактирована <strong>успешно!</strong>
[ <a href='reliz.php'>Назад</a> ]</div></tr></td></table>");
end_frame();stdfoot();die();}}
$editid = (int)$_GET['editid'];$name = htmlspecialchars_uni($_GET['name']);$img = htmlspecialchars_uni($_GET['img']);$sort = (int)$_GET['sort'];
if($editid > 0){begin_frame(".:: Редактирование Релиз-группы <strong>&quot;$name&quot;</strong> ::.", "100", true);
echo("<form name='form1' method='get' action='".$_SERVER['PHP_SELF']."'><table class='main' cellspacing='0' cellpadding='5' width='100%'>
<div align='center'><input type='hidden' name='edited' value='1'>Редактирование Релиз-группы <strong>&quot;$name&quot;</strong></div><br>
<input type='hidden' name='id' value='$editid'><table class='main' cellspacing='0' cellpadding='5' width='100%'>
<tr><td><center>Название: <input type='text' size='50' name='reliz_name' value='$name'></center></td></tr>
<tr><td><center>Картинка: <input type='text' size='50' name='reliz_img' value='$img'></center></td></tr>
<tr><td><center>Сортировка: <input type='text' size='50' name='reliz_sort' value='$sort'></center></td></tr>
<tr><td><center><input type='Submit' class='button4' value='Редактировать'></center></td></tr></table></form>");end_frame();stdfoot();die();}	
///////////////////// A D D A N E W C A T E G O R Y reliz \\\\\\\\\\\\\\\\\\\\\\\\\\\\
$add = $_GET['add'];if($add == 'true'){
$reliz_name = htmlspecialchars_uni($_GET['reliz_name']);$reliz_img = htmlspecialchars_uni($_GET['reliz_img']);$reliz_sort = (int)$_GET['reliz_sort'];
$query = "INSERT INTO reliz (name, image, sort) VALUE(".sqlesc($reliz_name).", ".sqlesc($reliz_img).", ".sqlesc($reliz_sort).")";
$sql = mysql_query($query) or sqlerr(__FILE__, __LINE__);if($sql){$success = TRUE;}else{$success = FALSE;}}	
///////////////////// E X I S T I N G C A T E G O R I E S reliz \\\\\\\\\\\\\\\\\\\\\\\\\\\\
begin_frame(".:: Существующие Релиз-группы ::.", "100", true);
echo("<table class='main' cellspacing='0' cellpadding='5' width='100%'><td class='zaliwka' width='50px' align='center'><center>ID</center></td>
<td class='zaliwka' width='100px' align='center'><center>Сортировка</center></td><td class='zaliwka' width='120px' align='center'><center>Картинка</center></td>
<td class='zaliwka' width='98%' align='center'><center>Название</center></td><td class='zaliwka' width='100px' align='center'><center>Просмотр</center></td>
<td class='zaliwka' width='100px' align='center'><center>Правка</center></td><td class='zaliwka' width='100px' align='center'><center>Удалить</center></td>");
$query = "SELECT * FROM reliz ORDER BY sort";$sql = mysql_query($query) or sqlerr(__FILE__, __LINE__);
while($row = mysql_fetch_array($sql)){$id = (int)$row['id'];$sort = $row['sort'];$name = $row['name'];$img = $row['image'];
echo ("<tr><td width='50px' align='center'><strong>$id</strong></td><td width='100px' align='center'><strong>$sort</strong></td><td width='120px' align=center>
<img src='pic/reliz/$img' border='0'/></td><td width='98%' align='center'><strong>$name</strong></td><td width='100px' align='center'><div align='center'>
<a href='browse.php?rg=$id'><img src='pic/viewnfo.gif' border='0' class=special /></a></div></td><td width='100px' align='center'>
<a href='reliz.php?editid=$id&name=$name&img=$img&sort=$sort'><div align='center'><img src='pic/pen.gif' border='0' class='special' /></a></div></td><td width='100px' align='center'>
<div align='center'><a href='reliz.php?delid=$id&reliz=$name'><img src='pic/warned2.gif' border='0' class='special' align='center' /></a></div></td></tr>");}
echo ("</table><br><table class='main' cellspacing='0' cellpadding='5' width='100px' align='center'><tr>
<form method='post' action='reliz.php?reliz=addreliz'><center><input type='submit' class='button4' value='Создать Группу'></center></form></tr></table><br>");
end_frame();stdfoot();}
function addreliz(){stdhead("Создать Релиз-группу");begin_frame(".:: Создать Релиз-группу ::.", "100", true);
echo ("<form name='form1' method='get' action='".$_SERVER['PHP_SELF']."'><table class='main' cellspacing='0' cellpadding='5' width='50%'>
<tr><div align='center'>Название: <input type='text' size='50' name='reliz_name'></div></tr><tr><div align='center'>Картинка: <input type='text' size='50' name='reliz_img'>
<input type='hidden' name='add' value='true'></div></tr><tr><div align='center'>Сортировка: <input type='text' size='50' name='reliz_sort'></div></tr>
<br><br><tr><div align='center'><input type='Submit' class='button4' value='Создать Группу'></div></div><br></tr></table>");
if($success == TRUE){print("<strong>Удачно!</strong>");}echo("</form>");end_frame();stdfoot();}
if($_GET ['reliz'] == "addreliz"){addreliz();exit();}else{relizcategory();exit();}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>