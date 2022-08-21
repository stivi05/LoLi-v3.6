<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && get_user_class() >= UC_UPLOADER){
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$release_group = array(
"INTERFILM" => "[img]$DEFAULTBASEURL/pic/groups/interfilm.gif[/img]",
"KAMO" => "[img]$DEFAULTBASEURL/pic/groups/kamo.gif[/img]",
"Киношники" => "[img]$DEFAULTBASEURL/pic/groups/kinoshniki.gif[/img]",
"KinoFan" => "[img]$DEFAULTBASEURL/pic/groups/kinofan.gif[/img]",
"NetLab" => "[img]$DEFAULTBASEURL/pic/groups/netlab.gif[/img]",
"25kadr" => "[img]$DEFAULTBASEURL/pic/groups/25kadr.gif[/img]",
"BiNMoViE" => "[img]$DEFAULTBASEURL/pic/groups/binmovie.gif[/img]",
"RDA" => "[img]$DEFAULTBASEURL/pic/groups/rda.gif[/img]",
"Капуцины" => "[img]$DEFAULTBASEURL/pic/groups/capucini.gif[/img]",
"KiViTeam" => "[img]$DEFAULTBASEURL/pic/groups/kivi_team.gif[/img]",
"KiNOFACK" => "[img]$DEFAULTBASEURL/pic/groups/kinofack.jpg[/img]",
"ПАРОВОЗ" => "[img]$DEFAULTBASEURL/pic/groups/parovoz.gif[/img]", );
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$video_codec = array ('DivX', 'XviD', 'WMV', 'SVCD', 'VCD');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kachestvo = array ('DVDRip', 'DVDScr', 'TVRip', 'TS', 'TC', 'CAMRip', 'TVRip', 'SATRip', 'HDTVRip', 'HD-DVDRip', 'VHSRip');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$perevod = array ('Оригинал', 'Любительский (один голос)', 'Любительский (многоголосный)', 'Профессиональный (полное дублирование)', 'Гоблин', 'Дублированный');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$format = array ('DivX', 'XviD', 'WMV', 'AVI', 'SVCD', 'VCD');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$music_format  = array ('MP3', 'AC3', 'WMA', 'OGG', 'MP2', 'FLAC', 'APE', 'AAC');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$ab  = array ('192 kbps', '256 kbps', '320 kbps', '384 kbps', '448 kbps', '640 kbps', '1536 kbps', '192-320kbps',  '~3000 kbps', '~4000 kbps', '~5000 kbps', '~6000 kbps');
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$trtd = "<tr><td class=\"heading\" valign=\"top\" align=\"right\">"; $tdtd = "</td><td valign=\"top\" align=left>";

///////////////////////////Видео//////////////////////////////////////////////////////////////////////////////////////////////////////
$trf = "$trtd Торент: $tdtd <input type=file name=tfile size=60 required /></td></tr>\n";
$image0 = "$trtd Постер: $tdtd <input name=image0 type='file' size=80 required /></td></tr>\n";
$name = "$trtd Заглавие: $tdtd <input type=text name=name  size=80 required /></td></tr>\n";
$originalfilmsname = "$trtd Оригинално заглавие: $tdtd <input name=originalfilmsname type=text size=80 required /></td></tr>\n";
$god_vihoda = "$trtd Година: $tdtd <input name=god_vihoda type=text size=20 maxlength=80 required /></td></tr>\n";
$description = "$trtd Жанр: $tdtd <input type=text name=description size=80 required /></td></tr>\n";
//$issued = "$trtd Студио: $tdtd <input type=text name=issued size=80 required /></td></tr>\n";
$regi = "$trtd Режисьор: $tdtd <input name=regi type=text size=80 required /></td></tr>\n";
$cast = "$trtd В ролите: $tdtd <input name=cast type=text size=80 required /></td></tr>\n";
//$kinopoisk = "$trtd Кинопоиск: $tdtd <input type=text name=kinopoisk  size=20> Вставляете только номер Пример: <b>809087</b></td></tr>\n";
$imdb = "$trtd IMDB: $tdtd <input type=text name=imdb size=20>  Вставляете только номер Пример: <b> tt5519340</b></td></tr>\n";
$sujet = "$trtd Резюме: $tdtd <textarea class=editorinput id=area name=sujet cols=65 rows=10 style=width:90% onkeypress=TransliteFeld(this, event) onselect=FieldName(this, this.name) onclick=FieldName(this, this.name) onkeyup=FieldName(this, this.name) required ></textarea></td></tr>\n";
$strana = "$trtd Държава: $tdtd <input name=strana type=text size=80 required /></td></tr>\n";
$studua = "$trtd Студио: $tdtd <input name=studua type=text size=80 /></td></tr>\n";
$time = "$trtd Времетраене: $tdtd <input name=time type=text size=20 required /><b> Пример: </b>01:34:23</td></tr>\n";
$pr = "<select name=\"perevod\">\n<option value=\"0\">(избери)</option>\n";
 while (list($key, $val) = each($perevod)) {
$pr .= "<option value=\"$val\">$val</option>\n";}
$pr .= "</select>\n";
$pr = "$trtd Превод: $tdtd $pr</td></tr>\n";
$fr = "<select name=\"format\">\n<option value=\"0\">(избери)</option>\n";
 while (list($key, $val) = each($format)) {
$fr .= "<option value=\"$val\">$val</option>\n";}
$fr .= "</select>\n";
$fr = "$trtd Формат: $tdtd $fr</td></tr>\n";
$kach = "<select name=\"kachestvo\">\n<option value=\"0\">(избери)</option>\n";
while (list($key, $val) = each($kachestvo)) {
$kach .= "<option value=\"$val\">$val</option>\n";}
$kach .= "</select>\n";
$kach = "$trtd Качество: $tdtd $kach</td></tr>\n";
$kogec = "$trtd Кодек: $tdtd <input name=kogec type=text size=80 /></td></tr>\n";
$forma = "$trtd Формат: $tdtd <input name=forma type=text size=80 required /></td></tr>\n";
$stvo = "$trtd Качество: $tdtd <input name=stvo type=text size=80 required /><b> Пример: </b>WEB-DL 1080p</td></tr>\n";
$video = "$trtd Видео: $tdtd <input name=video type=text size=80 maxlength=80 required /><b> Пример: </b>MPEG4 Video (AVC, H264), 5606 Кбит/с, 1920х804</td></tr>\n";
$audio = "$trtd Аудио: $tdtd <input name=audio type=text size=80 maxlength=80 required /><b> Пример: </b>Русский: AC3, 2 ch, 192 Кбит/с | IVI</td></tr>\n";
$subs = "$trtd Субтитри: $tdtd <input name=subs type=text size=80 /></td></tr>\n";
$dops = "$trtd Допълнително: $tdtd <textarea class=editorinput id=area name=dops cols=65 rows=10 style=width:90% onkeypress=TransliteFeld(this, event) onselect=FieldName(this, this.name) onclick=FieldName(this, this.name) onkeyup=FieldName(this, this.name) required ></textarea></td></tr>\n";
$s = "<select name=\"group\">\n<option value=\"0\">(избери)</option>\n";
while (list($key, $val) = each($release_group)) {
$s .= "<option value=\"$val\">$key</option>\n";}
$s .= "</select>\n";
$group = "$trtd Релийз от: $tdtd $s</td></tr>\n";
$sample = "$trtd Семпл: $tdtd <input name=sample type=text size=80></td></tr>\n";
$image1 = "$trtd Снимка:1 $tdtd <input name=image1 type=" . (!$img_on_server?"text":"file") . " style=width:80%></td></tr>\n";
$image2 = "$trtd Снимка:2 $tdtd <input name=image2 type=" . (!$img_on_server?"text":"file") . " style=width:80%></td></tr>\n";
$image3 = "$trtd Снимка:3 $tdtd <input name=image3 type=" . (!$img_on_server?"text":"file") . " style=width:80%></td></tr>\n";
$image4 = "$trtd Снимка:4 $tdtd <input name=image4 type=" . (!$img_on_server?"text":"file") . " style=width:80%></td></tr>\n";
$youtube = "$trtd YouTube трейлър: $tdtd <input name=youtube type=text size=80 /> Поставя се само номера (пример):<b> bjD3r8wPQQA</b></td></tr>\n";
////////////////////////////Игры ////////////////////////////////////////////////////////////////////////////////////////////////
$razrabotchik = "$trtd Разработчик $tdtd <input type=text name=razrabotchik size=80 required /></td></tr>\n";
$released_igra = "$trtd Выпущено $tdtd <input type=text name=released_igra size=80 required /></td></tr>\n";
$text_language = "$trtd Язык интерфейса $tdtd <input type=text name=text_language size=80 required /></td></tr>\n";
$voice_language = "$trtd Язык озвучки $tdtd <input type=text name=voice_language size=80 required /></td></tr>\n";
$primechaniye = "$trtd Таблетка $tdtd <input type=text name=primechaniye size=80 required /></td></tr>\n";
$description_igre = "$trtd Об игре $tdtd <textarea class=editorinput id=area name=description_igre cols=65 rows=10 style=width:90% onkeypress=TransliteFeld(this, event) onselect=FieldName(this, this.name) onclick=FieldName(this, this.name) onkeyup=FieldName(this, this.name) required ></textarea></td></tr>\n";
$operating_system = "$trtd Операционная система $tdtd <input type=text name=operating_system size=80 required /></td></tr>\n";
$cpu_igra = "$trtd Процессор $tdtd <input type=text name=cpu_igra size=80 required /></td></tr>\n";
$memory_igra = "$trtd Память $tdtd <input type=text name=memory_igra size=80 required /></td></tr>\n";
$video_card = "$trtd Видеокарта $tdtd <input type=text name=video_card size=80 required /></td></tr>\n";
$free_place = "$trtd Свободное место $tdtd <input type=text name=free_place size=80 required /></td></tr>\n";
$installation_igra = "$trtd Установка $tdtd <textarea class=editorinput id=area name=installation_igra cols=65 rows=10 style=width:90% onkeypress=TransliteFeld(this, event) onselect=FieldName(this, this.name) onclick=FieldName(this, this.name) onkeyup=FieldName(this, this.name) required ></textarea></td></tr>\n";

////////////////////////////Музыка///////////////////////////////////////////////////////////////////////////////////////////////
$album = "$trtd Албум: $tdtd <input type=text name=album size=80 required /></td></tr>\n";
$artist = "$trtd Изпълнител: $tdtd <input type=text name=artist size=80 required /></td></tr>\n";
$release_date = "$trtd Година: $tdtd <input type=text name=release_date size=80 required /></td></tr>\n";
$keywords = "$trtd Тагове: $tdtd <input type=text name=keywords size=80 required /></td></tr>\n";
$music_format_ = "<select name=\"music_format_\"><option value=\"0\">(избери)</option>\n";
while (list($key, $val) = each($music_format)) {
$music_format_ .= "<option value=\"$val\">$val</option>\n";}
$music_format_ .= "</select>\n";
$music_format_ = "$trtd Формат: $tdtd $music_format_</td></tr>\n";
$ab_ = "<select name=\"ab_\"><option value=\"0\">(избери)</option>\n";
while (list($key, $val) = each($ab)) {
$ab_ .= "<option value=\"$val\">$val</option>\n";}
$ab_ .= "</select>\n";
$ab_ = "$trtd Битрейт: $tdtd $ab_</td></tr>\n";
$tracklist = "$trtd Траклист: $tdtd <textarea class=editorinput id=area name=tracklist cols=65 rows=10 style=width:90% onkeypress=TransliteFeld(this, event) onselect=FieldName(this, this.name) onclick=FieldName(this, this.name) onkeyup=FieldName(this, this.name) required ></textarea></td></tr>\n";

////////////////////////////Мультфильмы////////////////////////////////////////////////////////////////////////////////////////////////
$multname = "$trtd Название мультфильма: $tdtd <input name=multname type=text value=\"Пример: Шрек\" size=80 required /></td></tr>\n";
$originalmultname = "$trtd Оригинальное название: $tdtd <input name=originalmultname type=text value=\"Пример:  Shrek\" size=80 required /></td></tr>\n";
$roli_ozvuchivali = "$trtd Роли озвучивали: $tdtd <input name=roli_ozvuchivali type=text size=80 required /></td></tr>\n";
$mult_descr = "$trtd О мультфильме: $tdtd <textarea name=mult_descr cols=50 rows=10></textarea></td></tr>\n";

////////////////////////////Разное////////////////////////////////////////////////////////////////////////////////////////////////////
$raznoe_descr = "$trtd Описание: $tdtd <textarea name=descr cols=50 rows=10></textarea></td></tr>\n";

////////////////////////////Сериалы///////////////////////////////////////////////////////////////////////////////////////////
$season = "$trtd Сезон: $tdtd <input name=season type=text size=10 required /></td></tr>\n";
$num_seriy = "$trtd Количество серий: $tdtd <input name=num_seriy type=text size=10 required /></td></tr>\n";

////////////////////////////Программы///////////////////////////////////////////////////////////////////////////////////////////////////
$version_prog = "$trtd Версия: $tdtd <input type=text name=version_prog size=80 required /></td></tr>\n";
$repack_prog = "$trtd Repack: $tdtd <input type=text name=repack_prog size=80 required /></td></tr>\n";
$bit_depth = "$trtd Разрядность: $tdtd <input type=text name=bit_depth size=80 required /></td></tr>\n";
$medicine_prog = "$trtd Лекарство: $tdtd <input type=text name=medicine_prog size=80 required /></td></tr>\n";
$soft_descr = "$trtd Описание: $tdtd <textarea class=editorinput id=area name=soft_descr cols=65 rows=10 style=width:90% onkeypress=TransliteFeld(this, event) onselect=FieldName(this, this.name) onclick=FieldName(this, this.name) onkeyup=FieldName(this, this.name) required ></textarea></td></tr>\n";
$system_operating = "$trtd Системные требования: $tdtd <textarea class=editorinput id=area name=system_operating cols=65 rows=10 style=width:90% onkeypress=TransliteFeld(this, event) onselect=FieldName(this, this.name) onclick=FieldName(this, this.name) onkeyup=FieldName(this, this.name) required ></textarea></td></tr>\n";
$tweaks_prog = "$trtd Твики: $tdtd <textarea class=editorinput id=area name=tweaks_prog cols=65 rows=10 style=width:90% onkeypress=TransliteFeld(this, event) onselect=FieldName(this, this.name) onclick=FieldName(this, this.name) onkeyup=FieldName(this, this.name) required ></textarea></td></tr>\n";
$cut_out = "$trtd Вырезано: $tdtd <textarea class=editorinput id=area name=cut_out cols=65 rows=10 style=width:90% onkeypress=TransliteFeld(this, event) onselect=FieldName(this, this.name) onclick=FieldName(this, this.name) onkeyup=FieldName(this, this.name) required ></textarea></td></tr>\n";
$established = "$trtd Установлено: $tdtd <textarea class=editorinput id=area name=established cols=65 rows=10 style=width:90% onkeypress=TransliteFeld(this, event) onselect=FieldName(this, this.name) onclick=FieldName(this, this.name) onkeyup=FieldName(this, this.name) required ></textarea></td></tr>\n";
$checksums = "$trtd Контрольные суммы: $tdtd <textarea class=editorinput id=area name=checksums cols=65 rows=10 style=width:90% onkeypress=TransliteFeld(this, event) onselect=FieldName(this, this.name) onclick=FieldName(this, this.name) onkeyup=FieldName(this, this.name) required ></textarea></td></tr>\n";
$treatment_procedure = "$trtd Процедура лечения: $tdtd <textarea class=editorinput id=area name=treatment_procedure cols=65 rows=10 style=width:90% onkeypress=TransliteFeld(this, event) onselect=FieldName(this, this.name) onclick=FieldName(this, this.name) onkeyup=FieldName(this, this.name) required ></textarea></td></tr>\n";

$submit = "$trtd </td><td align=left><input type=\"submit\" value=\"Продолжить дальше!\"></td></tr>";
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
stdhead("Качване");
////////////////////////////////////////////////////////////////////////////////////////////////
begin_frame("Качване на торент", "70", "true")
?>
<form enctype="multipart/form-data" action="takeupload_sky.php" method="post" name="form1" onsubmit="return CheckForm();">
<table width="70%" border="0" cellpadding="2" cellspacing="2">
<tr>
<?
echo $trf;
/// Шаблон для музыки ///
if($_GET["shab"]=='audio'){
?><script>
function CheckForm()
{
d = document.form1;
d.poster.value = d.image0.value;
d.descr.value = "\n[b][color=Olive]Албум | Album:[/color] [/b]" + d.album.value
+ "\n[b][color=Olive]Изпълнител | Executor:[/color] [/b]" + d.artist.value
+ "\n[b][color=Olive]Година | Year:[/color] [/b]" + d.release_date.value
+ "\n[b][color=Olive]Жанр | Genre:[/color] [/b]" + d.description.value
//+ "\n[b][color=Olive]Тагове | Tags:[/color] [/b]" + d.keywords.value
+ "\n[b][color=Olive]Формат/Кодек | Format/Codec:[/color] [/b]" + d.music_format_.value
+ "\n[b][color=Olive]Времетраене | Duration:[/color] [/b]" + d.time.value
+ "\n[b][color=Olive]Битрейт аудио | Audio bitrate:[/color] [/b]" + d.ab_.value
+ "\n\n[spoiler=Траклист:] " + d.tracklist.value  + "[/spoiler]"
d.genre.value = d.description.value
d.genre.value = d.keywords.value
d.nazvanie.value = d.album.value + " (" + d.release_date.value + ")" + " " + d.music_format_.value + " ";

return true;
}
</script><?
echo $image0;
echo $album;
echo $artist;
echo $release_date;
echo $description;
echo $keywords;
echo $music_format_;
echo $time;
echo $ab_;
echo $tracklist;
$s = "<select name=\"janr\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$cats = get_list('categories');foreach ($cats as $row) $s .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$s .= "</select>\n";tr("Категория", $s, 1);
$j = "<select name=\"tip\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$incat = get_list('incategories');foreach ($incat as $row) $j .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$j .= "</select>\n";tr("Тип", $j, 1);
//tr('Качено от System', '<input type="checkbox" value="yes" id="System" name="System" /><label for="System"> Записать релиз на System</label><font class="small"> Включение этой опции позволяет записать авторство раздачи на System (БОТ)</font>', 1);
tr("Мултитракер", "<input type=\"checkbox\" name=\"multitracker\"" . (($row["multitracker"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />Мультитрекерный торрент<font class=\"small\"> Включение этой опции отключает установку private-флага и удаление других аннонсеров из файла, если ОТКЛЮЧЕН - удалит все левые анонсеры из загружаемого торрент-файла</font>", 1);
echo $submit;
?>
<input type="hidden" name="descr"><input type="hidden" name="nazvanie"><input type="hidden" name="poster"><input type="hidden" name="genre"><input type="hidden" name="type" value="1"></table></form>
<? end_frame();}
/// Конец шаблона для музыки///

///Шаблон для фильмов///
if($_GET["shab"]=='movie'){
?><script>		  
function CheckForm()
{
d = document.form1;
d.poster.value = d.image0.value;
d.descr.value = "\n[b][color=Olive]Заглавие:[/color] [/b]" + d.name.value
+ "\n[b][color=Olive]Оригинално заглавие:[/color] [/b]" + d.originalfilmsname.value
+ "\n[b][color=Olive]Година:[/color] [/b]" + d.god_vihoda.value
+ "\n[b][color=Olive]Държава | Студио:[/color] [/b]" +" "+ d.strana.value +" "+"[color=green][b] | "+ d.studua.value +"[/b][/color]"
+ "\n[b][color=Olive]Жанр:[/color] [/b]" + d.description.value
+ "\n[b][color=Olive]Режисьор:[/color] [/b]" + d.regi.value
+ "\n[b][color=Olive]В ролите:[/color] [/b]" + d.cast.value
+ "\n\n[imdb]" + d.imdb.value +"[/imdb]"
+ "\n\n[b][color=Olive]Резюме:[/color][/b]\n" + d.sujet.value
+ "\n\n\n[b][color=Olive]Качество:[/color] [/b]" + d.stvo.value
+ "\n[b][color=Olive]Видео:[/color] [/b]" + d.video.value
+ "\n[b][color=Olive]Аудио:[/color] [/b]" + d.audio.value
+ "\n[b][color=Olive]Времетраене:[/color] [/b]" + d.time.value
+ "\n[b][color=Olive]Субтитри:[/color] [/b]" + d.subs.value
+ "\n\n[youtube]" + d.youtube.value +"[/youtube]"
d.screenshot.value = "\n\n[th]" + d.image1.value +"[/th]"
+ "[th]" + d.image2.value +"[/th]"
+ "[th]" + d.image3.value +"[/th]"
+ "[th]" + d.image4.value +"[/th]";
d.genre.value = d.description.value
d.nazvanie.value = d.name.value + " / " + d.originalfilmsname.value + " (" + d.god_vihoda.value + ") " + d.stvo.value;
return true;
}
//-->
</script>
<?
echo $image0;
echo $name;
echo $originalfilmsname;
echo $god_vihoda;
echo $strana;
echo $studua;
echo $description;
echo $keywords;
echo $regi;
echo $cast;
echo $sujet;
echo $imdb;
//echo $kinopoisk;
echo $stvo;
echo $video;
echo $audio;
echo $time;
echo $subs;
echo $youtube;
echo $image1;
echo $image2;
echo $image3;
echo $image4;
$s = "<select name=\"janr\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$cats = get_list('categories');foreach ($cats as $row) $s .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$s .= "</select>\n";tr("Категория", $s, 1);
$j = "<select name=\"tip\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$incat = get_list('incategories');foreach ($incat as $row) $j .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$j .= "</select>\n";tr("Тип", $j, 1);
//tr('Качено от System', '<input type="checkbox" value="yes" id="System" name="System" /><label for="System"> Записать релиз на System</label><font class="small"> Включение этой опции позволяет записать авторство раздачи на System (БОТ)</font>', 1);
tr("Мултитракер", "<input type=\"checkbox\" name=\"multitracker\"" . (($row["multitracker"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />Мультитрекерный торрент<font class=\"small\"> Включение этой опции отключает установку private-флага и удаление других аннонсеров из файла, если ОТКЛЮЧЕН - удалит все левые анонсеры из загружаемого торрент-файла</font>", 1);
echo $submit;
?>
<input type="hidden" name="descr">
<input type="hidden" name="poster">
<input type="hidden" name="genre">
<input type="hidden" name="screenshot">
<input type="hidden" name="nazvanie">
<input type="hidden" name="type" value="2">
</table>
</form>
<?
end_frame();
}
/// Конец шаблону фильмов ///

/// Шаблон для сериалов///
if($_GET["shab"]=='seriali'){
?><script>		  
function CheckForm()
{
d = document.form1;
d.poster.value = d.image0.value;
d.descr.value = "\n[b][color=Olive]Название:[/color] [/b]" + d.name.value
+ "\n[b][color=Olive]Оригинальное название:[/color] [/b]" + d.originalfilmsname.value
+ "\n[b][color=Olive]Год выхода:[/color] [/b]" + d.god_vihoda.value
+ "\n[b][color=Olive]Жанр:[/color] [/b]" + d.keywords.value
+ "\n[b][color=Olive]Выпущено:[/color] [/b]" +" "+ d.strana.value +" "+"[color=green][b] | "+ d.studua.value +"[/b][/color]"
+ "\n[b][color=Olive]Режиссер:[/color] [/b]" + d.regi.value
+ "\n[b][color=Olive]В ролях:[/color] [/b]" + d.cast.value
+  "\n\n[imdb]" + d.imdb.value +"[/imdb]" + "[kp]" + d.kinopoisk.value +"[/kp]"
+ "\n\n[b][color=Olive]О фильме:[/color][/b]\n" + d.description.value
+ "\n\n[b][color=Olive]Сезон:[/color] [/b]" + d.season.value
+ "\n[b][color=Olive]Количество серий:[/color] [/b]" + d.num_seriy.value
+ "\n\n[b][color=Olive]Качество:[/color] [/b]" + d.stvo.value
+ "\n[b][color=Olive]Видео:[/color] [/b]" + d.video.value
+ "\n[b][color=Olive]Аудио:[/color] [/b]" + d.audio.value
+ "\n[b][color=Olive]Продолжительность:[/color] [/b]" + d.time.value
+ "\n[b][color=Olive]Субтитры:[/color] [/b]" + d.subs.value
+  "\n\n[center][youtube]" + d.youtube.value +"[/youtube][/center]"
d.screenshot.value = "\n\n[th]" + d.image1.value +"[/th]"
+ "[th]" + d.image2.value +"[/th]"
+ "[th]" + d.image3.value +"[/th]"
+ "[th]" + d.image4.value +"[/th]";
d.genre.value = d.keywords.value
d.nazvanie.value = d.name.value + " / " + d.originalfilmsname.value + " (" + d.god_vihoda.value + ") " + d.stvo.value;
return true;
}
//-->
</script>
<?
echo $image0;
echo $name;
echo $originalfilmsname;
echo $god_vihoda;
echo $keywords;
echo $strana;
echo $studua;
echo $regi;
echo $cast;
echo $imdb;
echo $kinopoisk;
echo $description;
echo $season;
echo $num_seriy;
echo $stvo;
echo $video;
echo $audio;
echo $time;
echo $subs;
echo $youtube;
echo $image1;
echo $image2;
echo $image3;
echo $image4;
$s = "<select name=\"janr\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$cats = get_list('categories');foreach ($cats as $row) $s .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$s .= "</select>\n";tr("Категория", $s, 1);
$j = "<select name=\"tip\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$incat = get_list('incategories');foreach ($incat as $row) $j .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$j .= "</select>\n";tr("Тип", $j, 1);
//tr('Заливка от System', '<input type="checkbox" value="yes" id="System" name="System" /><label for="System"> Записать релиз на System</label><font class="small"> Включение этой опции позволяет записать авторство раздачи на System (БОТ)</font>', 1);
tr("Мультитрекер", "<input type=\"checkbox\" name=\"multitracker\"" . (($row["multitracker"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />Мультитрекерный торрент<font class=\"small\"> Включение этой опции отключает установку private-флага и удаление других аннонсеров из файла, если ОТКЛЮЧЕН - удалит все левые анонсеры из загружаемого торрент-файла</font>", 1);
echo $submit;
?>
<input type="hidden" name="descr">
<input type="hidden" name="poster">
<input type="hidden" name="genre">
<input type="hidden" name="screenshot">
<input type="hidden" name="nazvanie">
<input type="hidden" name="type" value="3">
</table>
</form>
<?
end_frame();
}
/// Конец шаблону сериалов ///

///Шаблон для Мультфилмов///
if($_GET["shab"]=='anime'){
?><script>		  
function CheckForm()
{
d = document.form1;
d.poster.value = d.image0.value;
d.descr.value = "\n[b][color=Olive]Название:[/color] [/b]" + d.name.value
+ "\n[b][color=Olive]Оригинальное название:[/color] [/b]" + d.originalfilmsname.value
+ "\n[b][color=Olive]Год выхода:[/color] [/b]" + d.god_vihoda.value
+ "\n[b][color=Olive]Жанр:[/color] [/b]" + d.keywords.value
+ "\n[b][color=Olive]Выпущено:[/color] [/b]" +" "+ d.strana.value +" "+"[color=green][b] | "+ d.studua.value +"[/b][/color]"
+ "\n[b][color=Olive]Режиссер:[/color] [/b]" + d.regi.value
+ "\n[b][color=Olive]В ролях:[/color] [/b]" + d.cast.value
+  "\n\n[imdb]" + d.imdb.value +"[/imdb]" + "[kp]" + d.kinopoisk.value +"[/kp]"
+ "\n\n[b][color=Olive]О фильме:[/color][/b]\n" + d.description.value
+ "\n\n[b][color=Olive]Качество:[/color] [/b]" + d.stvo.value
+ "\n[b][color=Olive]Видео:[/color] [/b]" + d.video.value
+ "\n[b][color=Olive]Аудио:[/color] [/b]" + d.audio.value
+ "\n[b][color=Olive]Продолжительность:[/color] [/b]" + d.time.value
+ "\n[b][color=Olive]Субтитры:[/color] [/b]" + d.subs.value
+  "\n\n[center][youtube]" + d.youtube.value +"[/youtube][/center]"
d.screenshot.value = "\n\n[th]" + d.image1.value +"[/th]"
+ "[th]" + d.image2.value +"[/th]"
+ "[th]" + d.image3.value +"[/th]"
+ "[th]" + d.image4.value +"[/th]";
d.genre.value = d.keywords.value
d.nazvanie.value = d.name.value + " / " + d.originalfilmsname.value + " (" + d.god_vihoda.value + ") " + d.stvo.value;
return true;
}
//-->
</script>
<?
echo $image0;
echo $name;
echo $originalfilmsname;
echo $god_vihoda;
echo $keywords;
echo $strana;
echo $studua;
echo $regi;
echo $cast;
echo $imdb;
echo $kinopoisk;
echo $description;
echo $stvo;
echo $video;
echo $audio;
echo $time;
echo $subs;
echo $youtube;
echo $image1;
echo $image2;
echo $image3;
echo $image4;
$s = "<select name=\"janr\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$cats = get_list('categories');foreach ($cats as $row) $s .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$s .= "</select>\n";tr("Категория", $s, 1);
$j = "<select name=\"tip\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$incat = get_list('incategories');foreach ($incat as $row) $j .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$j .= "</select>\n";tr("Тип", $j, 1);
//tr('Заливка от System', '<input type="checkbox" value="yes" id="System" name="System" /><label for="System"> Записать релиз на System</label><font class="small"> Включение этой опции позволяет записать авторство раздачи на System (БОТ)</font>', 1);
tr("Мультитрекер", "<input type=\"checkbox\" name=\"multitracker\"" . (($row["multitracker"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />Мультитрекерный торрент<font class=\"small\"> Включение этой опции отключает установку private-флага и удаление других аннонсеров из файла, если ОТКЛЮЧЕН - удалит все левые анонсеры из загружаемого торрент-файла</font>", 1);
echo $submit;
?>
<input type="hidden" name="descr">
<input type="hidden" name="poster">
<input type="hidden" name="genre">
<input type="hidden" name="screenshot">
<input type="hidden" name="nazvanie">
<input type="hidden" name="type" value="4">
</table>
</form>
<?
end_frame();
}
/// Конец шаблону мультфилмов ///

/// Шаблон для Игры ///
if($_GET["shab"]=='games'){
?><script>
<!--
function CheckForm()
{
d = document.form1;
d.poster.value = d.image0.value;
d.descr.value = "\n[b][color=Olive]Название:[/color] [/b]" + d.name.value
+ "\n[b][color=Olive]Год выхода:[/color] [/b]" + d.god_vihoda.value
+ "\n[b][color=Olive]Жанр:[/color] [/b]" + d.keywords.value
+ "\n[b][color=Olive]Разработчик:[/color] [/b]" + d.razrabotchik.value
+ "\n[b][color=Olive]Выпущено:[/color] [/b]" + d.released_igra.value
+ "\n[b][color=Olive]Язык интерфейса:[/color] [/b]" + d.text_language.value
+ "\n[b][color=Olive]Язык озвучки:[/color] [/b]" + d.voice_language.value
+ "\n[b][color=Olive]Таблетка:[/color] [/b]" + d.primechaniye.value
+ "\n\n[b][color=Olive]Об игре:[/color] [/b]\n" +  d.description_igre.value
+ "\n\n[b][u][color=Olive]Минимальные системные требования[/color][/u][/b]"
+ "\n[b][color=Olive]Операционная система:[/color] [/b]" + d.operating_system.value
+ "\n[b][color=Olive]Процессор:[/color] [/b]" + d.cpu_igra.value
+ "\n[b][color=Olive]Память:[/color] [/b]" + d.memory_igra.value
+ "\n[b][color=Olive]Видеокарта:[/color] [/b]" + d.video_card.value
+ "\n[b][color=Olive]Свободное место:[/color] [/b]" + d.free_place.value
+ "\n\n[b][color=Olive]Установка:[/color] [/b]\n" + d.installation_igra.value
+  "\n\n[center][youtube]" + d.youtube.value +"[/youtube][/center]"
d.screenshot.value = "\n\n[th]" + d.image1.value +"[/th]"
+ "[th]" + d.image2.value +"[/th]"
+ "[th]" + d.image3.value +"[/th]"
+ "[th]" + d.image4.value +"[/th]";
d.genre.value = d.keywords.value
d.nazvanie.value = d.name.value + " (" + d.god_vihoda.value + ")";
return true;
}
//-->
</script><?
echo $image0;
echo $name;
echo $god_vihoda;
echo $keywords;
echo $razrabotchik;
echo $released_igra;
echo $text_language;
echo $voice_language;
echo $primechaniye;
echo $description_igre;
echo $operating_system;
echo $cpu_igra;
echo $memory_igra;
echo $video_card;
echo $free_place;
echo $installation_igra;
echo $youtube;
echo $image1;
echo $image2;
echo $image3;
echo $image4;
$s = "<select name=\"janr\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$cats = get_list('categories');foreach ($cats as $row) $s .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$s .= "</select>\n";tr("Категория", $s, 1);
$j = "<select name=\"tip\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$incat = get_list('incategories');foreach ($incat as $row) $j .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$j .= "</select>\n";tr("Тип", $j, 1);
//tr('Заливка от System', '<input type="checkbox" value="yes" id="System" name="System" /><label for="System"> Записать релиз на System</label><font class="small"> Включение этой опции позволяет записать авторство раздачи на System (БОТ)</font>', 1);
tr("Мультитрекер", "<input type=\"checkbox\" name=\"multitracker\"" . (($row["multitracker"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />Мультитрекерный торрент<font class=\"small\"> Включение этой опции отключает установку private-флага и удаление других аннонсеров из файла, если ОТКЛЮЧЕН - удалит все левые анонсеры из загружаемого торрент-файла</font>", 1);
echo $submit;
?>
<input type="hidden" name="descr">
<input type="hidden" name="poster">
<input type="hidden" name="genre">
<input type="hidden" name="screenshot">
<input type="hidden" name="nazvanie">
<input type="hidden" name="type" value="5">
</table>
</form>
<?
end_frame();
}
/// Конец  шаблона для Игр///

/// Шаблон для приложений///
if($_GET["shab"]=='soft'){
?><script>
<!--
function CheckForm()
{
d = document.form1;
d.poster.value = d.image0.value;
d.descr.value = "\n[b][color=Olive]Название:[/color] [/b]" + d.name.value
+ "\n[b][color=Olive]Оригинальное название:[/color] [/b]" + d.originalfilmsname.value
+ "\n[b][color=Olive]Год выпуска:[/color] [/b]" + d.god_vihoda.value
+ "\n[b][color=Olive]Жанр:[/color] [/b]" + d.keywords.value
+ "\n[b][color=Olive]Разработчик:[/color] [/b]" + d.razrabotchik.value
+ "\n[b][color=Olive]Версия:[/color] [/b]" + d.version_prog.value
+ "\n[b][color=Olive]Repack:[/color] [/b]" + d.repack_prog.value
+ "\n[b][color=Olive]Разрядность:[/color] [/b]" + d.bit_depth.value
+ "\n[b][color=Olive]Язык интерфейса:[/color] [/b]" + d.text_language.value
+ "\n[b][color=Olive]Лекарство:[/color] [/b]" + d.medicine_prog.value
+ "\n\n[b][color=Olive]Описание:[/color] [/b]\n" +  d.soft_descr.value
+ "\n[b][color=Olive]Системные требования:[/color] [/b]" + d.system_operating.value
+ "\n\n[b][u][color=Olive]Дополнительная информация:[/color][/u][/b]"
+ "\n\n[spoiler=Твики:] " + d.tweaks_prog.value  + "[/spoiler]"
+ "\n\n[spoiler=Вырезано:] " + d.cut_out.value  + "[/spoiler]"
+ "\n\n[spoiler=Установлено:] " + d.established.value  + "[/spoiler]"
+ "\n\n[spoiler=Контрольные суммы:] " + d.checksums.value  + "[/spoiler]"
+ "\n\n[spoiler=Процедура лечения:] " + d.treatment_procedure.value  + "[/spoiler]"
+  "\n\n[center][youtube]" + d.youtube.value +"[/youtube][/center]"
d.screenshot.value = "\n\n[th]" + d.image1.value +"[/th]"
+ "[th]" + d.image2.value +"[/th]"
+ "[th]" + d.image3.value +"[/th]"
+ "[th]" + d.image4.value +"[/th]";
d.genre.value = d.keywords.value
d.nazvanie.value = d.name.value + " (" + d.god_vihoda.value + ")";
return true;
}
//-->
</script><?
echo $image0;
echo $name;
echo $originalfilmsname;
echo $god_vihoda;
echo $keywords;
echo $razrabotchik;
echo $version_prog;
echo $repack_prog;
echo $bit_depth;
echo $text_language;
echo $medicine_prog;
echo $soft_descr;
echo $system_operating;
echo $tweaks_prog;
echo $cut_out;
echo $established;
echo $checksums;
echo $treatment_procedure;
echo $youtube;
echo $image1;
echo $image2;
echo $image3;
echo $image4;
$s = "<select name=\"janr\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$cats = get_list('categories');foreach ($cats as $row) $s .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$s .= "</select>\n";tr("Категория", $s, 1);
$j = "<select name=\"tip\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$incat = get_list('incategories');foreach ($incat as $row) $j .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$j .= "</select>\n";tr("Тип", $j, 1);
//tr('Заливка от System', '<input type="checkbox" value="yes" id="System" name="System" /><label for="System"> Записать релиз на System</label><font class="small"> Включение этой опции позволяет записать авторство раздачи на System (БОТ)</font>', 1);
tr("Мультитрекер", "<input type=\"checkbox\" name=\"multitracker\"" . (($row["multitracker"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />Мультитрекерный торрент<font class=\"small\"> Включение этой опции отключает установку private-флага и удаление других аннонсеров из файла, если ОТКЛЮЧЕН - удалит все левые анонсеры из загружаемого торрент-файла</font>", 1);
echo $submit;
?>
<input type="hidden" name="descr">
<input type="hidden" name="poster">
<input type="hidden" name="genre">
<input type="hidden" name="screenshot">
<input type="hidden" name="nazvanie">
<input type="hidden" name="type" value="6">
</table>
</form>
<?
end_frame();
}
/// Конец шаблона для приложений///

/// Шаблон для Спорта ///
if($_GET["shab"]=='sport'){
?><script>
<!--
function CheckForm()
{
d = document.form1;
d.poster.value = d.image0.value;
d.descr.value = "[b]Название: [/b]" + d.name.value
+ "\n[b]Оригинальное название: [/b]" + d.originalfilmsname.value
+ "\n[b]Год выхода: [/b]" + d.god_vihoda.value
+ "\n[b]Жанр: [/b]" + d.keywords.value
+ "\n[b]Страна: [/b]" + d.strana.value				
+ "\n\n[b]Описание:[/b]\n" + d.description.value				
+ "\n[b]Продолжительность: [/b]" + d.time.value				
+ "\n[b]Перевод: [/b]" + d.perevod.value			
+ "\n[b]Качество: [/b]" + d.kachestvo.value
+ "\n[b]Видео: [/b]" + d.video.value
+ "\n[b]Звук: [/b]" + d.audio.value
+  "\n\n[center][youtube]" + d.youtube.value +"[/youtube][/center]"
d.reliz.value = d.group.value;
d.screenshot.value = "\n\n[th]" + d.image1.value +"[/th]"
+ "[th]" + d.image2.value +"[/th]"
+ "[th]" + d.image3.value +"[/th]"
+ "[th]" + d.image4.value +"[/th]";
d.nazvanie.value = d.name.value + " / " + d.originalfilmsname.value + " (" + d.god_vihoda.value + ") " + d.kachestvo.value;
d.genre.value = d.keywords.value;
return true;
}
//-->
</script><?
echo $image0;
echo $name;
echo $originalfilmsname;
echo $god_vihoda;
echo $keywords;
echo $strana;
echo $description;
echo $time;		
echo $perevod;
echo $kachestvo;
echo $video;
echo $audio;
echo $reliz;
echo $youtube;
echo $image1;
echo $image2;
echo $image3;
echo $image4;
$s = "<select name=\"janr\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$cats = get_list('categories');foreach ($cats as $row) $s .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$s .= "</select>\n";tr("Категория", $s, 1);
$j = "<select name=\"tip\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$incat = get_list('incategories');foreach ($incat as $row) $j .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$j .= "</select>\n";tr("Тип", $j, 1);
//tr('Заливка от System', '<input type="checkbox" value="yes" id="System" name="System" /><label for="System"> Записать релиз на System</label><font class="small"> Включение этой опции позволяет записать авторство раздачи на System (БОТ)</font>', 1);
tr("Мультитрекер", "<input type=\"checkbox\" name=\"multitracker\"" . (($row["multitracker"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />Мультитрекерный торрент<font class=\"small\"> Включение этой опции отключает установку private-флага и удаление других аннонсеров из файла, если ОТКЛЮЧЕН - удалит все левые анонсеры из загружаемого торрент-файла</font>", 1);
echo $submit;
?>
<input type="hidden" name="descr">
<input type="hidden" name="nazvanie">
<input type="hidden" name="poster">
<input type="hidden" name="genre">
<input type="hidden" name="screenshot">
<input type="hidden" name="reliz">
<input type="hidden" name="dops">
<input type="hidden" name="type" value="7">
</table>
</form><?
end_frame();
}
/// Конец ///

/// Шаблон для Библиотека///
if($_GET["shab"]=='knigi'){
?><script>
<!--
function CheckForm()
{
d = document.form1;
d.poster.value = d.image0.value;
d.descr.value = "Тип: " + d.soft_type.value
+ "\nВерсия: " + d.soft_version.value
+ "\nГод выпуска: " + d.god_vihoda.value
+ "\nОписание\n[quote]" + d.soft_descr.value + "[/quote]"
d.screenshot.value = "\n\n[th]" + d.image1.value +"[/th]"
+ "[th]" + d.image2.value +"[/th]"
+ "[th]" + d.image3.value +"[/th]"
+ "[th]" + d.image4.value +"[/th]";
d.nazvanie.value = d.name.value + " (" + d.god_vihoda.value + ")";
return true;
}
//-->
</script>
<?
echo $image0;
echo $name;
echo $soft_type;
echo $soft_version;
echo $god_vihoda;
echo $soft_descr;
echo $image1;
echo $image2;
echo $image3;
echo $image4;
echo $golden;
echo $stick;
$s = "<select name=\"janr\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$cats = get_list('categories');foreach ($cats as $row) $s .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$s .= "</select>\n";tr("Категория", $s, 1);
$j = "<select name=\"tip\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$incat = get_list('incategories');foreach ($incat as $row) $j .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$j .= "</select>\n";tr("Тип", $j, 1);
//tr('Заливка от System', '<input type="checkbox" value="yes" id="System" name="System" /><label for="System"> Записать релиз на System</label><font class="small"> Включение этой опции позволяет записать авторство раздачи на System (БОТ)</font>', 1);
tr("Мультитрекер", "<input type=\"checkbox\" name=\"multitracker\"" . (($row["multitracker"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />Мультитрекерный торрент<font class=\"small\"> Включение этой опции отключает установку private-флага и удаление других аннонсеров из файла, если ОТКЛЮЧЕН - удалит все левые анонсеры из загружаемого торрент-файла</font>", 1);
echo $submit;
?>
<input type="hidden" name="descr">
<input type="hidden" name="poster">
<input type="hidden" name="screenshot">
<input type="hidden" name="nazvanie">
<input type="hidden" name="type" value="8">		
</table>
</form>
<?
end_frame();
}
/// Конец ///
/// Шаблон Music Video ///
if($_GET["shab"]=='clips'){
?><script>
<!--
function CheckForm()
{
d = document.form1;
d.poster.value = d.image0.value;
d.descr.value = "[b]Название: [/b]" + d.name.value
+ "\n[b]Оригинальное название: [/b]" + d.originalfilmsname.value
+ "\n[b]Год выхода: [/b]" + d.god_vihoda.value
+ "\n[b]Жанр: [/b]" + d.keywords.value
+ "\n[b]Режиссер: [/b]" + d.regi.value
+ "\n[b]В ролях: [/b]" + d.cast.value
+ "\n\n[b]Описание:[/b]\n" + d.description.value
+ "\n[b]Видео: [/b]" + d.video.value
+ "\n[b]Звук: [/b]" + d.audio.value + "\n";
d.dops.value = (d.sample.value !=''?"[b]Скачать: [/b][url=" + d.sample.value + "]Сэмпл[/url]\n\n" : "\n");
d.reliz.value = d.group.value;
d.screenshot.value = "\n\n[th]" + d.image1.value +"[/th]"
+ "[th]" + d.image2.value +"[/th]"
+ "[th]" + d.image3.value +"[/th]"
+ "[th]" + d.image4.value +"[/th]";
d.nazvanie.value = d.name.value + " / " + d.originalfilmsname.value + " (" + d.god_vihoda.value + ") " + d.genre.value = d.keywords.value;
return true;
} //-->
</script><?
echo $image0;
echo $name;
echo $originalfilmsname;
echo $god_vihoda;
echo $keywords;
echo $regi;
echo $cast;
echo $description;
echo $video;
echo $audio;
echo $sample;
echo $group;
echo $image1;
echo $image2;
echo $image3;
echo $image4;
$s = "<select name=\"janr\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$cats = get_list('categories');foreach ($cats as $row) $s .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$s .= "</select>\n";tr("Категория", $s, 1);
$j = "<select name=\"tip\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$incat = get_list('incategories');foreach ($incat as $row) $j .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$j .= "</select>\n";tr("Тип", $j, 1);
//tr('Заливка от System', '<input type="checkbox" value="yes" id="System" name="System" /><label for="System"> Записать релиз на System</label><font class="small"> Включение этой опции позволяет записать авторство раздачи на System (БОТ)</font>', 1);
tr("Мультитрекер", "<input type=\"checkbox\" name=\"multitracker\"" . (($row["multitracker"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />Мультитрекерный торрент<font class=\"small\"> Включение этой опции отключает установку private-флага и удаление других аннонсеров из файла, если ОТКЛЮЧЕН - удалит все левые анонсеры из загружаемого торрент-файла</font>", 1);
echo $submit;
?>
<input type="hidden" name="descr">
<input type="hidden" name="nazvanie">
<input type="hidden" name="poster">
<input type="hidden" name="genre">
<input type="hidden" name="screenshot">
<input type="hidden" name="reliz">
<input type="hidden" name="dops">
<input type="hidden" name="type" value="9">
</table></form><?
end_frame();}
/// Конец ///

/// Шаблон для playboy ///
if($_GET["shab"]=='playboy'){
?><script><!--
function CheckForm(){
d = document.form1;
d.poster.value = d.image0.value;
d.descr.value = "[u]Информация о фильме[/u]\n[b]Название: [/b]" + d.name.value
+ "\n[b]Название: [/b]" + d.name.value
+ "\n[b]Оригинальное название: [/b]" + d.originalfilmsname.value
+ "\n[b]Год выхода: [/b]" + d.god_vihoda.value
+ "\n[b]Жанр: [/b]" + d.keywords.value
+ "\n[b]Режиссер: [/b]" + d.regi.value
+ "\n[b]В ролях: [/b]" + d.cast.value
+ "\n\n[b]О фильме:[/b]\n" + d.description.value
+ (d.imdb_link.value !=''?"\n\n[url=" + d.imdb_link.value + "][b]IMDB[/b][/url] ":'') + (d.imdb_rate.value !=''?"[color=darkblue]" + d.imdb_rate.value + "[/color]":'')
+ "\n\n[b]Выпущено: [/b]" + d.studio.value
+ "\n[b]Продолжительность: [/b]" + d.time.value
+ "\n[b]Перевод: [/b]" + d.perevod.value
+ "\n\n[u]Файл[/u]"
+ "\n[b]Формат: [/b]" + d.format.value
+ "\n[b]Качество: [/b]" + d.kachestvo.value
+ "\n[b]Видео: [/b]" + d.video.value
+ "\n[b]Звук: [/b]" + d.audio.value + "\n";
d.dops.value = (d.sample.value !=''?"[b]Скачать: [/b][url=" + d.sample.value + "]Сэмпл[/url]\n\n" : "\n");
d.reliz.value = d.group.value;
d.screenshot.value = "\n\n[th]" + d.image1.value +"[/th]"
+ "[th]" + d.image2.value +"[/th]"
+ "[th]" + d.image3.value +"[/th]"
+ "[th]" + d.image4.value +"[/th]";
d.nazvanie.value = d.name.value + " / " + d.originalfilmsname.value + " (" + d.god_vihoda.value + ") " + d.kachestvo.value;
d.genre.value = d.keywords.value;
return true;
}//-->
</script><?
echo $image0;
echo $name;
echo $originalfilmsname;
echo $god_vihoda;
echo $keywords;
echo $regi;
echo $cast;
echo $description;
echo $imdb_link;
echo $imdb_rate;
echo $studio;
echo $time;
echo $pr;
echo $fr;
echo $kach;
echo $video;
echo $audio;
echo $sample;
echo $group;
echo $image1;
echo $image2;
echo $image3;
echo $image4;
$s = "<select name=\"janr\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$cats = get_list('categories');foreach ($cats as $row) $s .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$s .= "</select>\n";tr("Категория", $s, 1);
$j = "<select name=\"tip\">\n<option value=\"0\">(".$tracker_lang['choose'].")</option>\n";$incat = get_list('incategories');foreach ($incat as $row) $j .= "<option value=\"".$row["id"]."\">".htmlspecialchars_uni($row["name"])."</option>\n";$j .= "</select>\n";tr("Тип", $j, 1);
//tr('Заливка от System', '<input type="checkbox" value="yes" id="System" name="System" /><label for="System"> Записать релиз на System</label><font class="small"> Включение этой опции позволяет записать авторство раздачи на System (БОТ)</font>', 1);
tr("Мультитрекер", "<input type=\"checkbox\" name=\"multitracker\"" . (($row["multitracker"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" />Мультитрекерный торрент<font class=\"small\"> Включение этой опции отключает установку private-флага и удаление других аннонсеров из файла, если ОТКЛЮЧЕН - удалит все левые анонсеры из загружаемого торрент-файла</font>", 1);
echo $submit;
?>
<input type="hidden" name="descr">
<input type="hidden" name="nazvanie">
<input type="hidden" name="poster">
<input type="hidden" name="genre">
<input type="hidden" name="dops">
<input type="hidden" name="screenshot">
<input type="hidden" name="reliz">
<input type="hidden" name="type" value="10">
</table></form><?
end_frame();}
/// Конец ///

stdfoot();
}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>