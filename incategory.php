<?php require_once("include/bittorrent.php");dbconn(false);gzip();if($CURUSER && get_user_class() >= UC_SYSOP){
function bark($msg){genbark($msg, $tracker_lang ['error']);}
function incategory() {
	global $pic_base_url;
	stdhead ("Тип Релиза");
	///////////////////// D E L E T E C A T E G O R Y \\\\\\\\\\\\\\\\\\\\\\\\\\\\	

	$sure = $_GET ['sure'];
	if ($sure == "yes") {
		begin_frame (".:: ТИП релиза ::.", "100", true);
		$delid = ( int ) $_GET ['delid'];
		$query = "DELETE FROM incategories WHERE id=" . sqlesc ( $delid ) . " LIMIT 1";
		$sql = mysql_query ( $query ) or sqlerr ( __FILE__, __LINE__ );
		echo ("Тип Релиза успешно удален! [ <a href='incategory.php'>Назад</a> ]");
		end_frame ();
		stdfoot ();
		die ();
	}
	$delid = ( int ) $_GET ['delid'];
	$name = htmlspecialchars_uni($_GET ['incat']);
	if ($delid > 0) {
		begin_frame (".:: Тип Релиза ::>", "100", true);
		echo ("Вы действительно хотите удалить этот тип релиза? ($name) 
		( <strong><a href=\"" . $_SERVER ['PHP_SELF'] . "?delid=$delid&incat=$name&sure=yes\">Да</a></strong> / 
		<strong><a href=\"" . $_SERVER ['PHP_SELF'] . "\">Нет</a></strong> )");
		end_frame ();
		stdfoot ();
		die ();
	
	}
	
	///////////////////// E D I T A C A T E G O R Y \\\\\\\\\\\\\\\\\\\\\\\\\\\\
	$edited = $_GET ['edited'];
	if ($edited == 1) {
		$id = ( int ) $_GET ['id'];
		$incat_name = htmlspecialchars_uni ( $_GET ['incat_name'] );
		$incat_img = htmlspecialchars_uni ( $_GET ['incat_img'] );
		$incat_sort = ( int ) $_GET ['incat_sort'];
		$query = "UPDATE incategories SET
name = " . sqlesc ( $incat_name ) . ",
image = " . sqlesc ( $incat_img ) . ",
sort = " . sqlesc ( $incat_sort ) . " WHERE id=" . sqlesc ( $id );
		$sql = mysql_query ( $query ) or sqlerr ( __FILE__, __LINE__ );
		if ($sql) {
			begin_frame(".:: Тип Релиза ::.", "100", true);
			echo ("<table class=main cellspacing=0 cellpadding=5 width=100%>");
			echo ("<tr><td><div align='center'>Ваш тип релиза отредактирован <strong>успешно!</strong>
			[ <a href='incategory.php'>Назад</a> ]</div></tr>");
			echo ("</td></table>");
			end_frame();
			stdfoot();
			die ();
		}
	}
	
	$editid = ( int ) $_GET ['editid'];
	$name = htmlspecialchars_uni($_GET ['name']);
	$img = htmlspecialchars_uni($_GET ['img']);
	$sort = ( int ) $_GET ['sort'];
	if ($editid > 0) {
		begin_frame (".:: Тип Релиза ::.", "100", true);
		echo ("<form name='form1' method='get' action='" . $_SERVER ['PHP_SELF'] . "'>");
		echo ("<table class=main cellspacing=0 cellpadding=5 width=100%>");
		echo ("<div align='center'><input type='hidden' name='edited' value='1'>Редактирование Типа Релиза <strong>&quot;$name&quot;</strong></div>");
		echo ("<br>");
		echo ("<input type='hidden' name='id' value='$editid'><table class=main cellspacing=0 cellpadding=5 width=100%>");
		echo ("<tr><td><center>Название: <input type='text' size=50 name='incat_name' value='$name'></center></td></tr>");
		echo ("<tr><td><center>Картинка: <input type='text' size=50 name='incat_img' value='$img'></center></td></tr>");
		echo ("<tr><td><center>Сортировка: <input type='text' size=50 name='incat_sort' value='$sort'></center></td></tr>");
		echo ("<tr><td><center><input type='Submit' class=\"button4\" value='Редактировать'></center></td></tr>");
		echo ("</table></form>");
		end_frame ();
		stdfoot ();
		die ();
	}
	
	///////////////////// A D D A N E W C A T E G O R Y \\\\\\\\\\\\\\\\\\\\\\\\\\\\
	global $pic_base_url;
	$add = $_GET ['add'];
	if ($add == 'true') {
		$incat_name = htmlspecialchars_uni($_GET ['incat_name']);
		$incat_img = htmlspecialchars_uni($_GET ['incat_img']);
		$incat_sort = ( int ) $_GET ['incat_sort'];
		$query = "INSERT INTO incategories (name, image, sort) VALUE(
" . sqlesc ( $incat_name ) . ",
" . sqlesc ( $incat_img ) . ",
" . sqlesc ( $incat_sort ) . ")";
		$sql = mysql_query ( $query ) or sqlerr ( __FILE__, __LINE__ );
		if ($sql) {
			$success = TRUE;
		} else {
			$success = FALSE;
		}
	}
	
	///////////////////// E X I S T I N G C A T E G O R I E S \\\\\\\\\\\\\\\\\\\\\\\\\\\\
	
    begin_frame(".:: Существующие Типы Релизов ::.", "100", true);
	echo ("<table class=main cellspacing=0 cellpadding=5 width=100%>");
	echo ("<td class=colhead width='50px' align=center><center>ID</center></td>
	<td class=colhead width='100px' align=center><center>Сортировка</center></td>
	<td class=colhead width='100px' align=center><center>Картинка</center></td>
	<td class=colhead width='98%' align=center><center>Название</center></td>
		<td class=colhead width='100px' align=center><center>Просмотр</center></td>
	<td class=colhead width='100px' align=center><center>Правка</center></td>
	<td class=colhead width='100px' align=center><center>Удалить</center></td>");
	$query = "SELECT * FROM incategories ORDER BY sort";
$sql = mysql_query ( $query ) or sqlerr ( __FILE__, __LINE__ );
	while ( $row = mysql_fetch_array ( $sql ) ) {
		$id = ( int ) $row ['id'];
		$sort = $row ['sort'];
		$name = $row ['name'];
		$img = $row ['image'];
		echo ("<tr><td width='50px' align=center><strong>$id</strong></td>
		<td width='100px' align=center><strong>$sort</strong></td>
		<td width='100px' align=center><img src='pic/cats/$img' border='0' /></td>
		<td width='98%' align=center><strong>$name</strong></td>
		<td width='100px' align=center><div align='center'><a href='tip_$id'><img src='pic/viewnfo.gif' border='0' class=special /></a></div></td>
		<td width='100px' align=center><a href='incategory.php?editid=$id&name=$name&img=$img&sort=$sort'><div align='center'><img src='pic/pen.gif' border='0' class=special /></a></div></td>
		<td width='100px' align=center><div align='center'><a href='incategory.php?delid=$id&cat=$name'><img src='pic/warned2.gif' border='0' class=special align='center' /></a></div></td></tr>");
	}
	echo ("</table>
	<table class=main cellspacing=0 cellpadding=5 width='100px' align=center><tr>
	<form method=post action=incategory.php?incat=addincat><center><input type=\"submit\" class=\"button4\" value=\"Создать Тип Релиза\"></center></form></tr></table><br>");
	end_frame ();
	stdfoot ();
}
	function addincat() {
	stdhead ("Создать Тип Релиза");
	begin_frame ( "Создать Тип Релиза", "100", true );
	print ( "<br>" );
	echo ("<form name='form1' method='get' action='" . $_SERVER ['PHP_SELF'] . "'>");
	echo ("<table class=main cellspacing=0 cellpadding=5 width=100%>");
	echo ("<tr><div align='center'>Название: <input type='text' size=50 name='incat_name'></div></tr>");
	echo ("<tr><div align='center'>Картинка: <input type='text' size=50 name='incat_img'>
	<input type='hidden' name='add' value='true'></div></tr>");
	echo ("<tr><div align='center'>Сортировка: <input type='text' size=50 name='incat_sort'></div></tr>");
	echo ("</br><tr><div align='center'><input type='Submit' class=\"button4\" value='Создать Тип Релиза'></div></div></tr>");
	echo ("</table>");;
	if ($success == TRUE) {
		print ( "<strong>Удачно!</strong>" );
	}
	echo ("<br>");
	echo ("</form>");
	end_frame ();
	stdfoot ();}
if($_GET ['incat'] == "addincat"){addincat();exit();}else{incategory();exit();}
}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>