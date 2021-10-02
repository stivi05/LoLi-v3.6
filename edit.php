<?
require_once("include/bittorrent.php");

if (!mkglobal("id"))
	die();

$id = intval($id);
if (!$id)
	die();

dbconn();

loggedinorreturn();

$res = sql_query("SELECT * FROM torrents WHERE id = $id");
$row = mysql_fetch_array($res);
if (!$row)
	die();

stdhead("Редактирование торрента \"" . $row["name"] . "\"");

if (!isset($CURUSER) || ($CURUSER["id"] != $row["owner"] && get_user_class() < UC_MODERATOR)) {
	stdmsg($tracker_lang['error'],"Вы не можете редактировать этот торрент.");
} else {
	print("<form name=\"edit\" method=post action=takeedit.php enctype=multipart/form-data>\n");
	print("<input type=\"hidden\" name=\"id\" value=\"$id\">\n");
	if (isset($_GET["returnto"]))
		print("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars_uni($_GET["returnto"]) . "\" />\n");
	print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\">\n");
	print("<tr><td class=\"colhead\" colspan=\"2\">Редактировать торрент</td></tr>");
	tr($tracker_lang['torrent_file'], "<input type=file name=tfile size=80 style=\"height: 25px; width: 700px\">", 1);
	tr($tracker_lang['torrent_name'], "<input type=\"text\" name=\"name\" value=\"" . $row["name"] . "\" size=\"80\" />", 1);
	tr($tracker_lang['img_poster'], "<input type=radio name=img1action value='keep' checked>Оставить постер&nbsp&nbsp"."<input type=radio name=img1action value='delete'>Удалить постер&nbsp&nbsp"."<input type=radio name=img1action value='update'>Обновить постер<br /><b>Постер:</b>&nbsp&nbsp<input type=file name=image0 size=80>", 1);

tr($tracker_lang['images'], $tracker_lang['max_file_size'].": 5mb.<br />

<a target=_blank href=\"ihost\">(Загрузить скриншоты через хостинг)</a>\n", 1);
if ((strpos($row["fulldescr"], "<") === false) || (strpos($row["fulldescr"], "&lt;") !== false))
  $c = "";
if ((strpos($row["ori_descr"], "<") === false) || (strpos($row["ori_descr"], "&lt;") !== false))
  $c = "";
else
  $c = " checked";
print("<tr><td class=rowhead style='padding: 3px'>Короткое Описание</td><td>");
	textbbcode("edit","fulldescr",htmlspecialchars($row["fulldescr"]));
	print("</td></tr>\n");
	print("<tr><td class=rowhead style='padding: 3px'>".$tracker_lang['description']."</td><td>");
	textbbcode("edit","descr",htmlspecialchars_uni($row["ori_descr"]));
	print("</td></tr>\n");
	
	tr('<b>Номер по Кинопоиск:</b>', "<input type=\"text\" name='kinopoisk' size=12>&nbsp&nbspВписывать только цифры, пример (жирным выделено в конце): https://www.kinopoisk.ru/level/1/film/<b>903831</b>", 1);
	tr('<b>Номер по IMDB:</b>', "<input type=\"text\" name='imdb' placeholder=\"" .htmlspecialchars_uni($row["imdb"]). "\" size=12>&nbsp&nbspВписывать только цифры и tt, пример (жирым выделенно в конце): https://www.imdb.com/title/<b>tt2527338</b>", 1);

$s = "<select name=\"type\">";
$cats = get_list(categories);
foreach ($cats as $subrow){
$s .= "<option value=\"".$subrow["id"]."\"";
if($subrow["id"] == $row["category"])
$s .= " selected=\"selected\"";
$s .= ">".htmlspecialchars_uni($subrow["name"])."</option>";}
$s .= "</select>";
tr("Категория", $s, 1);
/////////////////////////////
$j = "<select name=\"tip\">";
$incat = get_list(incategories);   
foreach($incat as $subrow){
$j .= "<option value=\"".$subrow["id"]."\"";
if ($subrow["id"] == $row["incategory"])
$j .= " selected=\"selected\"";
$j .= ">".htmlspecialchars_uni($subrow["name"])."</option>";}
$j .= "</select>";
tr("Тип", $j, 1);
tr('<u>Keywords</u><br>Ключевые слова "Поиск в Описании"', "<input type=\"text\" name=\"keywords\" value=\"".htmlspecialchars_uni($row["keywords"])."\" size=\"80\" style=\"height: 25px; width: 700px\" />", 1);
tr('<u>Description</u><br>Теги-жанры', "<input type=\"text\" name=\"description\" value=\"".htmlspecialchars_uni($row["description"])."\" size=\"80\" style=\"height: 25px; width: 700px\" />", 1);

	tr("Видимый", "<input type=\"checkbox\" name=\"visible\"" . (($row["visible"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />
					Видимый в торрентах<br /><table border=0 cellspacing=0 cellpadding=0 width=420><tr><td class=embedded>Обратите внимание, что торрент автоматически станет видимым когда появиться раздающий и автоматически перестанет быть видимым (станет мертвяком) когда не будет раздающего некоторое время.
					Используйте этот переключатель для ускорения процеса. Также учтите что невидимые торренты (мертвяки) все-равно могут быть просмотрены и найдены, это просто не по-умолчанию.</td></tr></table>", 1);
	if(get_user_class() >= UC_ADMINISTRATOR)
		tr("Забанен", "<input type=\"checkbox\" name=\"banned\"" . (($row["banned"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />", 1);
tr("Поднять в списке торрентов (Обновлено)<br>(Если заменили торрент-файл)", "<input type='checkbox' name='uplist' ".(($row["updatess"] == "yes") ? " checked='checked'" : "")." value='1' />", 1);
    if(get_user_class() >= UC_ADMINISTRATOR)
		tr('Заливка от System', '<input type="checkbox" value="yes" id="System" name="System" /><label for="System">Записать релиз на System</label><br><font class="small">Включение этой опции позволяет записать авторство раздачи на System (БОТ)</font>', 1);
         tr("Тип раздачи",
"<input type=\"radio\" name=\"free\" id=\"bril\" value=\"bril\"" . (($row["free"] == "bril") ? " checked" : "") . "><label for=\"bril\">Бриллиантовая раздача (удваивается раздача, скачка не учитываеться). <b>Дается для старых и редких релизов!</b></label><br>".
"<input type=\"radio\" name=\"free\" id=\"gold\" value=\"yes\"" . (($row["free"] == "yes") ? " checked" : "") . "><label for=\"gold\">Золотая раздача (считаеться только раздача, скачка не учитываеться). <b>Дается для релизов от 18ГБ и выше!</b></label><br>".
"<input type=\"radio\" name=\"free\" id=\"silver\" value=\"silver\"" . (($row["free"] == "silver") ? " checked" : "") . "><label for=\"silver\">Серебряная раздача (скачка не учитиваеться только на 50%). <b>Дается для релизов от 8ГБ и до 18ГБ.</b></label><br>".
"<input type=\"radio\" name=\"free\" id=\"no\" value=\"no\"" . (($row["free"] == "no") ? " checked" : "") . "><label for=\"no\">Обычная раздача (скачка и раздача учитиваеться как обычно)</label><br>", 1);
if(get_user_class() >= UC_ADMINISTRATOR){
$post_rest = sql_query("SELECT COUNT(id) FROM torrents WHERE not_sticky = 'no'") or sqlerr(__FILE__, __LINE__);$row1 = mysql_fetch_array($post_rest);$count = $row1[0];
if($count > 12 && get_user_class() < UC_ADMINISTRATOR){
tr("Важный", "Уже 12 торрентов прилеплено, вы хотите забить всю первую страницу ???", 1);
}else{
tr("Важный", "<input type=\"checkbox\" name=\"not_sticky\"".(($row["not_sticky"] == "no") ? " checked=\"checked\"" : "" )." value=\"1\"> Прикрепить этот торрент (всегда наверху)", 1);}}
	tr("Мультитрекер", "<input type=\"checkbox\" name=\"multitracker\"" . (($row["multitracker"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />Мультитрекерный торрент<br><font class=\"small\">Включение этой опции отключает установку private-флага и удаление других аннонсеров из файла, если ОТКЛЮЧЕН - удалит все левые анонсеры из загружаемого торрент-файла</font>", 1);

	print("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"Отредактировать\" style=\"height: 25px; width: 100px\"> <input type=reset value=\"Обратить изменения\" style=\"height: 25px; width: 100px\"></td></tr>\n");
	print("</table>\n");
	print("</form>\n");
	print("<p>\n");
	print("<form method=\"post\" action=\"delete.php\">\n");
  print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\">\n");
  print("<tr><td class=embedded style='background-color: #F5F4EA;padding-bottom: 5px' colspan=\"2\"><b>Удалить торрент</b> Причина:</td></tr>");
  print("<td><input name=\"reasontype\" type=\"radio\" value=\"1\">&nbsp;Мертвяк </td><td> 0 раздающих, 0 качающих = 0 соединений</td></tr>\n");
  print("<tr><td><input name=\"reasontype\" type=\"radio\" value=\"2\">&nbsp;Дупликат</td><td><input type=\"text\" size=\"40\" name=\"reason[]\"></td></tr>\n");
  print("<tr><td><input name=\"reasontype\" type=\"radio\" value=\"3\">&nbsp;Nuked</td><td><input type=\"text\" size=\"40\" name=\"reason[]\"></td></tr>\n");
  print("<tr><td><input name=\"reasontype\" type=\"radio\" value=\"4\">&nbsp;Правила</td><td><input type=\"text\" size=\"40\" name=\"reason[]\">(Обязательно)</td></tr>");
  print("<tr><td><input name=\"reasontype\" type=\"radio\" value=\"5\" checked>&nbsp;Другое:</td><td><input type=\"text\" size=\"40\" name=\"reason[]\">(Обязательно)</td></tr>\n");
	print("<input type=\"hidden\" name=\"id\" value=\"$id\">\n");
	if (isset($_GET["returnto"]))
		print("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars_uni($_GET["returnto"]) . "\" />\n");
  print("<td colspan=\"2\" align=\"center\"><input type=submit value='Удалить' style='height: 25px'></td></tr>\n");
  print("</table>");
	print("</form>\n");
	print("</p>\n");
}

stdfoot();

?>