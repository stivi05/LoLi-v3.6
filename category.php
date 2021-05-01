<?php require_once("include/bittorrent.php");dbconn(false);gzip();if($CURUSER && get_user_class() >= UC_SYSOP){
function bark($msg){genbark($msg, $tracker_lang ['error']);}
function category(){
stdhead("Жанры");
///////////////////// D E L E T E C A T E G O R Y \\\\\\\\\\\\\\\\\\\\\\\\\\\\	
$sure = $_GET ['sure'];
if($sure == "yes"){
begin_frame(".:: Жанры ::.", "100", true);
$delid = (int) $_GET['delid'];
$query = "DELETE FROM categories WHERE id=".sqlesc($delid)." LIMIT 1";
$sql = sql_query ($query) or sqlerr (__FILE__, __LINE__);
echo("<center>Жанр успешно удален! [ <a href='category.php'>Назад</a> ]</center>");
end_frame();stdfoot();die();}
$delid = (int) $_GET['delid'];
$name = htmlspecialchars_uni($_GET['cat']);
if($delid > 0){begin_frame(".:: Жанры ::.", "100", true);
echo ("<center>Вы действителньо хотите удалить этот Жанр? ($name) ( <strong><a href=\"".$_SERVER ['PHP_SELF']."?delid=$delid&cat=$name&sure=yes\">Да</a></strong> / <strong><a href=\"".$_SERVER ['PHP_SELF']."\">Нет</a></strong> )</center>");
end_frame();stdfoot();die();}	
///////////////////// E D I T A C A T E G O R Y \\\\\\\\\\\\\\\\\\\\\\\\\\\\
$edited = $_GET ['edited'];
if ($edited == 1){
$id = ( int ) $_GET ['id'];
$cat_name = htmlspecialchars_uni ( $_GET ['cat_name'] );
$cat_img = htmlspecialchars_uni ( $_GET ['cat_img'] );
$cat_sort = ( int ) $_GET ['cat_sort'];
$query = "UPDATE categories SET name = ".sqlesc($cat_name).", image = ".sqlesc($cat_img).", sort = ".sqlesc($cat_sort)." WHERE id=".sqlesc($id);
$sql = sql_query($query) or sqlerr (__FILE__, __LINE__);
if($sql){begin_frame(".:: Жанр ::.", "100", true);
echo ("<table class=main cellspacing=0 cellpadding=5 width=100%><tr><td>
<div align='center'>Ваш Жанр отредактирован <strong>успешно!</strong>[ <a href='category.php'>Назад</a> ]</div></tr></td></table>");
end_frame();stdfoot();die();}}
//////////
$editid = (int) $_GET['editid'];
$name = htmlspecialchars_uni($_GET['name']);
$img = htmlspecialchars_uni($_GET['img']);
$sort = (int) $_GET['sort'];
if($editid > 0){
begin_frame(".:: Жанр ::.", "100", true);
echo ("<form name='form1' method='get' action='".$_SERVER ['PHP_SELF']."'><table class=main cellspacing=0 cellpadding=5 width=100%>
<div align='center'><input type='hidden' name='edited' value='1'>Редактирование Жанра <strong>&quot;$name&quot;</strong></div>
<br><input type='hidden' name='id' value='$editid'><table class=main cellspacing=0 cellpadding=5 width=100%>
<tr><td><center>Название: <input type='text' size=50 name='cat_name' value='$name'></center></td></tr>
<tr><td><center>Картинка: <input type='text' size=50 name='cat_img' value='$img'></center></td></tr>
<tr><td><center>Сортировка: <input type='text' size=50 name='cat_sort' value='$sort'></center></td></tr>
<tr><td><center><input type='Submit' class=\"button4\" value='Редактировать'></center></td></tr></table></form>");
end_frame();stdfoot();die();}	
///////////////////// A D D A N E W C A T E G O R Y \\\\\\\\\\\\\\\\\\\\\\\\\\\\
$add = $_GET ['add'];
if($add == 'true'){
$cat_name = htmlspecialchars_uni($_GET['cat_name']);
$cat_img = htmlspecialchars_uni($_GET['cat_img']);
$cat_sort = (int) $_GET['cat_sort'];
$query = "INSERT INTO categories (name, image, sort) VALUE(".sqlesc($cat_name).", ".sqlesc($cat_img).", ".sqlesc($cat_sort).")";
$sql = mysql_query ($query) or sqlerr (__FILE__, __LINE__);
if($sql){$success = TRUE;}else{$success = FALSE;}}	
///////////////////// E X I S T I N G C A T E G O R I E S \\\\\\\\\\\\\\\\\\\\\\\\\\\\
begin_frame(".:: Существующие Жанры ::.", "100", true);
echo ("<table class=main cellspacing=0 cellpadding=5 width=100%><td class=colhead width='50px' align=center><center>ID</center></td>
<td class=colhead width='100px' align=center><center>Сортировка</center></td><td class=colhead width='100px' align=center><center>Картинка</center></td>
<td class=colhead width='98%' align=center><center>Название</center></td><td class=colhead width='100px' align=center><center>Просмотр</center></td>
<td class=colhead width='100px' align=center><center>Правка</center></td><td class=colhead width='100px' align=center><center>Удалить</center></td>");
$query = "SELECT * FROM categories ORDER BY sort";
$sql = sql_query ($query) or sqlerr (__FILE__, __LINE__);
while ($row = mysql_fetch_array($sql)){
$id = ( int ) $row ['id'];
$sort = $row ['sort'];
$name = $row ['name'];
$img = $row ['image'];
echo ("<tr><td width='50px' align=center><strong>$id</strong></td><td width='100px' align=center><strong>$sort</strong></td>
<td width='100px' align=center><img src='pic/cats/$img' border='0' /></td><td width='98%' align=center><strong>$name</strong></td>
<td width='100px' align=center><div align='center'><a href='janr_$id'><img src='pic/viewnfo.gif' border='0' class=special /></a></div></td>
<td width='100px' align=center><a href='category.php?editid=$id&name=$name&img=$img&sort=$sort'>
<div align='center'><img src='pic/pen.gif' border='0' class=special /></a></div></td>
<td width='100px' align=center><div align='center'><a href='category.php?delid=$id&cat=$name'>
<img src='pic/warned2.gif' border='0' class=special align='center' /></a></div></td></tr>");}
echo ("</table><table class=main cellspacing=0 cellpadding=5 width='100px' align=center><tr>
<form method=post action=category.php?cat=addcat><center><input type=\"submit\" class=\"button4\" value=\"Создать Жанр\"></center>
</form></tr></table><br>");end_frame();stdfoot();}
function addcat(){
stdhead("Создать Жанр");begin_frame(".:: Создать Жанр ::.", "100", true);
echo ("<form name='form1' method='get' action='".$_SERVER ['PHP_SELF']."'><table class=main cellspacing=0 cellpadding=5 width=100%>
<tr><div align='center'>Название: <input type='text' size=50 name='cat_name'></div></tr>
<tr><div align='center'>Картинка: <input type='text' size=50 name='cat_img'><input type='hidden' name='add' value='true'></div></tr>
<tr><div align='center'>Сортировка: <input type='text' size=50 name='cat_sort'></div></tr>
</br><tr><div align='center'><input type='Submit' class=\"button4\" value='Создать Жанр'></div></div></tr></table>");
if($success == TRUE){print("<strong>Удачно!</strong>");}
echo ("</form>");end_frame();stdfoot();}if($_GET ['cat'] == "addcat"){addcat();exit();}else{category();exit();}
}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>