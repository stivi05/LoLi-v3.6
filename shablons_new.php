<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
$id = (isset($_REQUEST['id']) ? intval($_REQUEST['id']):0);
if(!is_valid_id($id) || empty($id))stderr2("Ошибка", "<center>ID указан не верно.</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
if($id != 0){
$res = sql_query("SELECT template, name FROM categories WHERE id = ".$id." LIMIT 1") or sqlerr(__FILE__,__LINE__);$row = mysql_fetch_assoc($res);$template = $row['template'];
switch($template){
case 'movies' :
/*//////// ШАБЛОН РАЗДАЧ - КАТЕГОРИЯ "ВИДЕО" //////*/
#Вывод основоной формы для заполнения
?><script>
function check_video() {
					 // Основные поля которые не могут быть пустыми
					 var tfile  = document.getElementById('tfile');
	                 var name   = document.getElementById('name');
					 var descr  = document.getElementById('descr');
					 // Дополнительные поля кот. не богут быть пустыми
					 var year = document.getElementById('year');
					 var country = document.getElementById('country');
					 var genre = document.getElementById('genre');
					 var time = document.getElementById('time');
					 var translate = document.getElementById('translate');
					 var director = document.getElementById('director');
					 var roles = document.getElementById('roles');
					 var quality = document.getElementById('quality');
					 var format = document.getElementById('format');
					 var video_info = document.getElementById('video_info');
					 var audio_info = document.getElementById('audio_info');
					 
		             if(tfile.value == '') {
						 alert( 'Пожалуйста выберите торрент файл' );
						   tfile.focus();
						     return false;
					 }
					 if(name.value == '') {
						 alert( 'Пожалуйста введите название раздачи' );
						   name.focus();
						     return false;
					 }
					 if(descr.value == '') {
						 alert( 'Пожалуйста введите описание раздачи' );
						   descr.focus();
						     return false;
					 }
					 // Проверка полей тех.данных категории видео
					 if(year.value == '') {
						 alert( 'Введите год выпуска фильма' );
						   year.focus();
						     return false;
					 }
					 /*if(typeof(year)) != 'number') {
						 alert( 'Неверный формат даты' );
						   year.focus();
						     return false;
					 }*/
					 if(country.value == '') {
						 alert( 'Введите страну, выпустившую фильм' );
						   country.focus();
						     return false;
					 }
					 if(genre.value == '') {
						 alert( 'Введите жанр фильма' );
						   genre.focus();
						     return false;
					 }
					 if(time.value == '') {
						 alert( 'Введите продолжительность фильма' );
						   time.focus();
						     return false;
					 }
					 if(translate.value == '') {
						 alert( 'Введите тип перевода фильма' );
						   translate.focus();
						     return false;
					 }
					 if(director.value == '') {
						 alert( 'Введите режиссера фильма' );
						   director.focus();
						     return false;
					 }
					 if(roles.value == '') {
						 alert( 'Заполните поле в ролях' );
						   roles.focus();
						     return false;
					 }
					 if(quality.value == '') {
						 alert( 'Введите качество фильма' );
						   quality.focus();
						     return false;
					 }
					 if(format.value == '') {
						 alert( 'Введите формат' );
						   format.focus();
						     return false;
					 }
					 if(video_info.value == '') {
						 alert( 'Введите тех.информацию по видео' );
						   video_info.focus();
						     return false;
					 }
					 if(audio_info.value == '') {
						 alert( 'Введите тех.информацию по аудио' );
						   audio_info.focus();
						     return false;
					 }
				 }
</script>
<form name="upload" enctype="multipart/form-data" target="_blank" action="takeupload_new.php" method="post" onsubmit="return check_video();">
<input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_torrent_size;?>" />
<fieldset><legend style="padding:5px;border:1px solid #ccc;background:#f6f6f6;">Основные данные</legend>
<table width="100%" cellpadding="5" align="center" cellspacing="0">
<tr><td width="20%" class="clear"><label for="tfile">.torrent файл*</label></td><td class="clear"><input type="file" name="tfile" id="tfile" size="80" /></td></tr>
<tr><td class="clear"><label for="name">Название*</label></td><td class="clear"><input type="text" name="name" id="name" size="70" /></td></tr>
<tr><td class="clear" valign="top">Постер</td><td class="clear"><input type="file" name="image0" size="80" /></td></tr>
<tr><td valign="top" class="clear"><label for="screen1">Скриншоты</label></td><td class="clear"><input type="text" name="screen1" id="screen1" size="70" />&nbsp;&nbsp;<a href="javascript:;" onclick="add_filed(); return false;" class="ajax-link" id="add_screen">Еще скриншот</a><br /><span id="src_place"></span></td></tr>
<tr><td valign="top" class="clear">Описание*</td><td class="clear"><?=textbbcode('upload','descr','');?></td></tr>
</table></fieldset><br/><?php
# Вывод дополнительной формы для заполнения
echo "<fieldset><legend style=\"padding:5px;border:1px solid #ccc; background:#f6f6f6;\">Тех. данные раздачи</legend>";
echo "<table align=\"center\" width=\"100%\" cellpadding=\"5\" cellspacing=\"0\"><tr><td class=\"clear\"><label for=\"year\">Год выпуска</label></td><td class=\"clear\"><input type=\"text\" name=\"year\" id=\"year\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: 2009</span></td></tr>"
."<tr><td class=\"clear\"><label for=\"country\">Страна</label></td><td class=\"clear\"><input type=\"text\" name=\"country\" id=\"country\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: Россия</span></td></tr>"
."<tr><td class=\"clear\"><label for=\"genre\">Жанр</label></td><td class=\"clear\"><input type=\"text\" name=\"genre\" id=\"genre\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: Фантастика</span></td></tr>"
."<tr><td class=\"clear\"><label for=\"time\">Продолжительность</label></td><td class=\"clear\"><input type=\"text\" name=\"time\" id=\"time\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: 1:22:37</span></td></tr>"
."<tr><td class=\"clear\"><label for=\"translate\">Перевод</label></td><td class=\"clear\"><input type=\"text\" name=\"translate\" id=\"translate\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: Профессиональный</span></td></tr>"
."<tr><td class=\"clear\"><label for=\"subtitles\">Субтитры</label></td><td class=\"clear\"><input type=\"text\" name=\"subtitles\" id=\"subtitles\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: Есть (русские)</span></td></tr>"
."<tr><td class=\"clear\"><label for=\"director\">Режиссер</label></td><td class=\"clear\"><input type=\"text\" name=\"director\" id=\"director\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: Майкл Бэй / Michael Bay</span></td></tr>"
."<tr><td class=\"clear\" valign=\"top\"><label for=\"roles\">В ролях</label></td><td class=\"clear\"><textarea name=\"roles\" id=\"roles\" style=\"width:450px;height:120px;\"></textarea><br /><span style=\"font-size:9px;color:#999999;\">Перечислите через запятую в формате: имя на русском / имя на англ. (если есть)</span></td></tr>"
."<tr><td class=\"clear\"><label for=\"quality\">Качество</label></td><td class=\"clear\"><input type=\"text\" name=\"quality\" id=\"quality\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: HDTVRip</span></td></tr>"
."<tr><td class=\"clear\"><label for=\"format\">Формат</label></td><td class=\"clear\"><input type=\"text\" name=\"format\" id=\"format\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: AVI</span></td></tr>"
."<tr><td class=\"clear\"><label for=\"video_info\">Видео</label></td><td class=\"clear\"><input type=\"text\" name=\"video_info\" id=\"video_info\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Укажите тех. данные видео. Напрмер: 688x384, 929 kbps, 23,976 fps, 0.15 b/p</span></td></tr>"
."<tr><td class=\"clear\"><label for=\"audio_info\">Аудио</label></td><td class=\"clear\"><input type=\"text\" name=\"audio_info\" id=\"audio_info\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Укажите тех. данные аудио. Напрмер: 48000 Hz, 2-channel, 128 kbps</span></td></tr>"
."<tr><td class=\"clear\"><label for=\"sample\">Семпл</label></td><td class=\"clear\"><input type=\"text\" name=\"sample\" id=\"sample\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Если есть укажите ссылку на него</span></td></tr>";
echo "</table></fieldset>";
echo "<input type=\"hidden\" name=\"shab_category\" value='".$template."' /><br />";
//echo "<input type=\"hidden\" name=\"type\" value=\"".intval($row['id'])."\" />";
//////////////////////////////////////
# Вывод настроек торрента
if(get_user_class() >= UC_ADMINISTRATOR){?>
<fieldset><legend style="padding:5px;border:1px solid #ccc;background:#f6f6f6;">Дополнительные настройки</legend>
<table width="100%" cellpadding="5" align="center" cellspacing="0">
<tr><td align="left" class="clear"><input type="checkbox" name="sticky" id="sticky" value="yes" />&nbsp;<label for="sticky">Прикрепить этот торрент (всегда наверху)</label></td></tr>
<tr><td align="left" class="clear"><input type="checkbox" name="free" id="free" value="yes" />&nbsp;<label for="free"><?=$tracker_lang['golden_descr'];?></label></td></tr>   
</table></fieldset><?}
echo "<br/><div align=\"center\"><input type=\"hidden\" name=\"type\" value='".$id."'/><input type=\"submit\" value=\"Загрузить торрент\"/></div></form>\n";
break;
//////////////////////////////////////////////////////////
/*////////  ШАБЛОН РАЗДАЧ - КАТЕГОРИЯ "АУДИО" //////*/
//////////////////////////////////////////////////////////////
case 'music' :?>
<script>
				   function check_audio() {
					   var tfile = document.getElementById('tfile');
					   var name  = document.getElementById('name');
					   var descr = document.getElementById('descr');
					   var genre = document.getElementById('genre');
					   var year  = document.getElementById('year');
					   var codec = document.getElementById('codec');
					   var kbps  = document.getElementById('kbps');
					   var time  = document.getElementById('time');
					   var track_list = document.getElementById('track_list');
					   
					   if(tfile.value == '') {
						   alert( 'Выберите торрент файл' );
						     tfile.focus();
							   return false;
					   }
					   if(name.value == '') {
						   alert( 'Введите название раздачи' );
						     name.focus();
							   return false;
					   }
					   if(descr.value == '') {
						   alert( 'Введите описание раздачи' );
						     descr.focus();
							   return false;
					   }
					   if(genre.value == '') {
						   alert( 'Введите жанр' );
						     genre.focus();
							   return false;
					   }
					   if(year.value == '') {
						   alert( 'Введите год выпуска диска' );
						     year.focus();
							   return false;
					   }
					   if(codec.value == '') {
						   alert( 'Введите аудио кодек' );
						     codec.focus();
							   return false;
					   }
					   if(kbps.value == '') {
						   alert( 'Введите битрейт' );
						     kbps.focus();
							   return false;
					   }
					   if(time.value == '') {
						   alert( 'Введите продолжительность' );
						     time.focus();
							   return false;
					   }
					   if(track_list.value == '') {
						   alert( 'Введите трэклист' );
						     track_list.focus();
							   return false;
					   }	 
				   }
				  </script>
<form name="upload" enctype="multipart/form-data" target="_blank" action="takeupload_new.php" method="post" onsubmit="return check_audio();"><input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_torrent_size;?>" />
		        <fieldset><legend style="padding:5px;border:1px solid #ccc;background:#f6f6f6;">Основные данные</legend>
                <table width="100%" cellpadding="5" align="center" cellspacing="0">
		        <tr><td width="20%" class="clear"><label for="tfile">.torrent файл*</label></td><td class="clear"><input type="file" name="tfile" id="tfile" size="80" /></td></tr>
                <tr><td class="clear" valign="top">Постер</td><td class="clear"><input type="file" name="image0" size="80" /></td></tr>	
				<tr><td class="clear"><label for="name">Название*</label></td><td class="clear"><input type="text" name="name" id="name" size="70" /></td></tr>
		        </table></fieldset><br />
                <?php
				
				# Вывод дополнительной формы для заполнения
echo "<fieldset><legend style=\"padding:5px;border:1px solid #ccc; background:#f6f6f6;\">Тех. данные</legend><table align=\"center\" width=\"100%\" cellpadding=\"5\" cellspacing=\"0\">
<tr><td class=\"clear\"><label for=\"year\">Год</label></td><td class=\"clear\"><input type=\"text\" name=\"year\" id=\"year\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: 2009</span></td></tr>

<tr><td class=\"clear\"><label for=\"genre\">Жанр</label></td><td class=\"clear\"><input type=\"text\" name=\"genre\" id=\"genre\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: R'n'b</span></td></tr>

<tr><td class=\"clear\"><label for=\"time\">Продолжительность</label></td><td class=\"clear\"><input type=\"text\" name=\"time\" id=\"time\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: 03:47:37</span></td></tr>

<tr><td class=\"clear\" valign=\"top\"><label for=\"track_list\">Трэклист</label></td><td class=\"clear\"><textarea name=\"track_list\" id=\"track_list\" style=\"width:450px;height:120px;\"></textarea><br /><span style=\"font-size:9px;color:#999999;\">Перечислите в порядке убывания список песен в формате - Имя исполнителя - название песни</span></td></tr>

<tr><td class=\"clear\"><label for=\"codec\">Кодек</label></td><td class=\"clear\"><input type=\"text\" name=\"codec\" id=\"codec\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: MP3</span></td></tr>

<tr><td class=\"clear\"><label for=\"kbps\">Битрейт</label></td><td class=\"clear\"><input type=\"text\" name=\"kbps\" id=\"kbps\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напрмер: 320 kbps</span></td></tr>";
echo "</table></fieldset><input type=\"hidden\" name=\"shab_category\" value=\"".intval($row['id'])."\" /><input type=\"hidden\" name=\"type\" value=\"".intval($row['id'])."\"<br />";
				  
				  # Вывод настроек торрента
				  if(get_user_class() >= UC_ADMINISTRATOR) { ?>
                  <fieldset><legend style="padding:5px;border:1px solid #ccc;background:#f6f6f6;">Дополнительные настройки</legend>
                  <table width="100%" cellpadding="5" align="center" cellspacing="0">
                    <tr>
                      <td align="left" class="clear"><input type="checkbox" name="sticky" id="sticky" value="yes" />&nbsp;<label for="sticky">Прикрепить этот торрент (всегда наверху)</label></td>
                   </tr>
                   <tr>
                      <td align="left" class="clear"><input type="checkbox" name="free" id="free" value="yes" />&nbsp;<label for="free"><?=$tracker_lang['golden_descr'];?></label></td>
                   </tr>   
                   </table></fieldset>
                   <?php  }
				   echo "<br /><div align=\"center\"><input type=\"hidden\" name=\"type\" value='".$id."' /><input type=\"submit\" value=\"Загрузить торрент\" /></div></form>\n";
			   break;
			   case 'sport' :
/*
// ==========================================================================================
//
// 
//  ШАБЛОН РАЗДАЧ - КАТЕГОРИЯ "ИГРЫ"
//
//
// ==========================================================================================
*/				  
                ?>
                <script>
				  function check_game() {
					  var tfile = document.getElementById('tfile');
					  var name  = document.getElementById('name');
					  var descr = document.getElementById('descr');
					  var year = document.getElementById('year');
					  var platform = document.getElementById('platform');
					  var genre = document.getElementById('genre');
					  var developer = document.getElementById('developer');
					  var publisher = document.getElementById('publisher');
					  var pub_type = document.getElementById('pub_type');
					  var language = document.getElementById('language');
					  var crack = document.getElementById('crack');
					  var requirements = document.getElementById('requirements');
					  
					  if(tfile.value == '') {
						  alert( 'Выберите торрент файл' );
						    tfile.focus();
							  return false;
					  }
					  if(name.value == '') {
						  alert( 'Введите название раздачи' );
						    name.focus();
							  return false;
					  }
					  if(descr.value == '') {
						  alert( 'Введите описание раздачи' );
						    descr.focus();
							  return false;
					  }
					  if(year.value == '') {
						  alert( 'Введите год выпуска игры' );
						    year.focus();
							  return false;
					  }
					  if(platform.value == '') {
						  alert( 'Введите платформу для игры' );
						    platform.focus();
							  return false;
					  }
					  if(genre.value == '') {
						  alert( 'Введите жанр игры' );
						    genre.focus();
							  return false;
					  }
					  if(developer.value == '') {
						  alert( 'Введите разработчика игры' );
						    developer.focus();
							  return false;
					  }
					  if(publisher.value == '') {
						  alert( 'Введите издателя игры' );
						    publisher.focus();
							  return false;
					  }
					  if(pub_type.value == '') {
						  alert( 'Введите тип издания' );
						    pub_type.focus();
							  return false;
					  }
					  if(language.value == '') {
						  alert( 'Введите язык интерфейса игры' );
						    language.focus();
							  return false;
					  }
					  if(requirements.value == '') {
						  alert( 'Введите системные требования для игры' );
						    requirements.focus();
							  return false;
					  }	  
				  }
				</script>
<form name="upload" enctype="multipart/form-data" target="_blank" action="takeupload_new.php" method="post" onsubmit="return check_game();"><input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_torrent_size;?>" />
		        <fieldset><legend style="padding:5px;border:1px solid #ccc;background:#f6f6f6;">Основные данные</legend>
                <table width="100%" cellpadding="5" align="center" cellspacing="0">
		        <tr><td width="20%" class="clear"><label for="tfile">.torrent файл*</label></td><td class="clear"><input type="file" name="tfile" id="tfile" size="80" /></td></tr>
                <tr><td class="clear"><label for="name">Название*</label></td><td class="clear"><input type="text" name="name" id="name" size="70" /></td></tr>
		        <tr><td class="clear" valign="top">Постер</td><td class="clear"><input type="file" name="image0" size="80" /></td></tr>
		        <tr><td valign="top" class="clear"><label for="screen1">Скриншоты</label></td><td class="clear"><input type="text" name="screen1" id="screen1" size="70" />&nbsp;&nbsp;<a href="javascript:;" onclick="add_filed(); return false;" class="ajax-link" id="add_screen">Еще скриншот</a><br /><span id="src_place"></span></td></tr>
		        <tr><td valign="top" class="clear">Описание*</td><td class="clear"><?=textbbcode('upload','descr','');?></td></tr>
		        </table></fieldset><br />
                <?php
				
				# Вывод дополнительной формы для заполнения
			    echo "<fieldset><legend style=\"padding:5px;border:1px solid #ccc; background:#f6f6f6;\">Тех. данные категории \"".htmlspecialchars($row['name'])."\"</legend>";
			    echo "<table align=\"center\" width=\"100%\" cellpadding=\"5\" cellspacing=\"0\"><tr><td class=\"clear\"><label for=\"year\">Год выпуска</label></td><td class=\"clear\"><input type=\"text\" name=\"year\" id=\"year\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Например: 2009</span></td></tr>"
				  ."<tr><td class=\"clear\"><label for=\"platform\">Платформа</label></td><td class=\"clear\"><input type=\"text\" name=\"platform\" id=\"platform\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Например: PC</span></td></tr>"
				  ."<tr><td class=\"clear\"><label for=\"genre\">Жанр</label></td><td class=\"clear\"><input type=\"text\" name=\"genre\" id=\"genre\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Например: Action (Shooter) / 3D / 3rd Person</span></td></tr>"
				  ."<tr><td class=\"clear\"><label for=\"developer\">Разработчик</label></td><td class=\"clear\"><input type=\"text\" name=\"developer\" id=\"developer\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Например: Starbreeze</span></td></tr>"
				  ."<tr><td class=\"clear\"><label for=\"publisher\">Издательство</label></td><td class=\"clear\"><input type=\"text\" name=\"publisher\" id=\"publisher\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Например: Ubisoft</span></td></tr>"
				  ."<tr><td class=\"clear\"><label for=\"pub_type\">Тип издания</label></td><td class=\"clear\"><input type=\"text\" name=\"pub_type\" id=\"pub_type\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Например: Лицензия</span></td></tr>"
				  ."<tr><td class=\"clear\"><label for=\"language\">Язык интерфейса</label></td><td class=\"clear\"><input type=\"text\" name=\"language\" id=\"language\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Например: Русский</span></td></tr>"
				  ."<tr><td class=\"clear\"><label for=\"crack\">Crack</label></td><td class=\"clear\"><input type=\"text\" name=\"crack\" id=\"crack\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напишите если есть</span></td></tr>"
				  ."<tr><td class=\"clear\" valign=\"top\"><label for=\"requirements\">Системные требования</label></td><td class=\"clear\"><textarea name=\"requirements\" id=\"requirements\" style=\"width:450px;height:120px;\"></textarea><br /><span style=\"font-size:9px;color:#999999;\">Приведите минимальные и рекомендуемые системные требования</span></td></tr>";
				  echo "</table></fieldset>";
				  echo "<input type=\"hidden\" name=\"shab_category\" value=\"{$template}\" />";
				  echo "<input type=\"hidden\" name=\"type\" value=\"".intval($row['id'])."\" /><br />";
				  
				  # Вывод настроек торрента
				  if(get_user_class() >= UC_ADMINISTRATOR) { ?>
                  <fieldset><legend style="padding:5px;border:1px solid #ccc;background:#f6f6f6;">Дополнительные настройки</legend>
                  <table width="100%" cellpadding="5" align="center" cellspacing="0">
                    <tr>
                      <td align="left" class="clear"><input type="checkbox" name="sticky" id="sticky" value="yes" />&nbsp;<label for="sticky">Прикрепить этот торрент (всегда наверху)</label></td>
                   </tr>
                   <tr>
                      <td align="left" class="clear"><input type="checkbox" name="free" id="free" value="yes" />&nbsp;<label for="free"><?=$tracker_lang['golden_descr'];?></label></td>
                   </tr>   
                   </table></fieldset>
                   <?php  }
				   echo "<br /><div align=\"center\"><input type=\"hidden\" name=\"type\" value='".$id."' /><input type=\"submit\" value=\"Загрузить торрент\" /></div></form>\n";
			   break;
			   case 'demo' :
/*
// ==========================================================================================
//
// 
//  ШАБЛОН РАЗДАЧ - КАТЕГОРИЯ "КНИГИ"
//
//
// ==========================================================================================
*/	
                ?>
                <script>
				  function check_book() {
					  var tfile = document.getElementById('tfile');
					  var name  = document.getElementById('name');
					  var descr = document.getElementById('descr');
					  var year  = document.getElementById('year');
					  var author = document.getElementById('author');
					  var genre = document.getElementById('genre');
					  var publisher = document.getElementById('publisher');
					  var format = document.getElementById('format');
					  var quality = document.getElementById('quality');
					  var pages = document.getElementById('pages');
					  
					  if(tfile.value == '') {
						  alert( 'Выберите торрент файл' );
						    tfile.focus();
							  return false;
					  }
					  if(name.value == '') {
						  alert( 'Введите название раздачи' );
						    name.focus();
							  return false;
					  }
					  if(descr.value == '') {
						  alert( 'Введите описание раздачи' );
						    descr.focus();
							  return false;
					  }
					  if(year.value == '') {
						  alert( 'Введите год издания' );
						    year.focus();
							  return false;
					  }
					  if(author.value == '') {
						  alert( 'Введите автора книги' );
						    author.focus();
							  return false;
					  }
					  if(genre.value == '') {
						  alert( 'Введите жанр книги' );
						    genre.focus();
							  return false;
					  }
					  if(publisher.value == '') {
						  alert( 'Введите издателя' );
						    publisher.focus();
							  return false;
					  }
					  if(format.value == '') {
						  alert( 'Введите формат книги' );
						    format.focus();
							  return false;
					  }
					  if(quality.value == '') {
						  alert( 'Введите качество книги' );
						    quality.focus();
							  return false;
					  }
					  if(pages.value == '') {
						  alert( 'Введите количество страниц' );
						    pages.focus();
							  return false;
					  }
				  }
				</script>
<form name="upload" enctype="multipart/form-data" target="_blank" action="takeupload_new.php" method="post" onsubmit="return check_book();"><input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_torrent_size;?>" />
		        <fieldset><legend style="padding:5px;border:1px solid #ccc;background:#f6f6f6;">Основные данные</legend>
                <table width="100%" cellpadding="5" align="center" cellspacing="0">
		        <tr><td width="20%" class="clear"><label for="tfile">.torrent файл*</label></td><td class="clear"><input type="file" name="tfile" id="tfile" size="80" /></td></tr>
                <tr><td class="clear"><label for="name">Название*</label></td><td class="clear"><input type="text" name="name" id="name" size="70" /></td></tr>
		        <tr><td class="clear" valign="top">Постер</td><td class="clear"><input type="file" name="image0" size="80" /></td></tr>
		        <tr><td valign="top" class="clear"><label for="screen1">Скриншоты</label></td><td class="clear"><input type="text" name="screen1" id="screen1" size="70" />&nbsp;&nbsp;<a href="javascript:;" onclick="add_filed(); return false;" class="ajax-link" id="add_screen">Еще скриншот</a><br /><span id="src_place"></span></td></tr>
		        <tr><td valign="top" class="clear">Описание*</td><td class="clear"><?=textbbcode('upload','descr','');?></td></tr>
		        </table></fieldset><br />                 
                  
                  <?php
			      echo "<fieldset><legend style=\"padding:5px;border:1px solid #ccc; background:#f6f6f6;\">Тех. данные категории \"".htmlspecialchars($row['name'])."\"</legend>";
				  echo "<table align=\"center\" width=\"100%\" cellpadding=\"5\" cellspacing=\"0\"><tr><td class=\"clear\" width=\"20%\"><label for=\"year\">Год выпуска</label></td><td class=\"clear\"><input type=\"text\" name=\"year\" id=\"year\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Например: 2009</span></td></tr>"
				  ."<tr><td class=\"clear\"><label for=\"author\">Автор</label></td><td class=\"clear\"><input type=\"text\" name=\"author\" id=\"author\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Например: Лукьяненко С.В.</span></td></tr>"
				  ."<tr><td class=\"clear\"><label for=\"genre\">Жанр</label></td><td class=\"clear\"><input type=\"text\" name=\"genre\" id=\"genre\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Например: Фэнтези</span></td></tr>"
				   ."<tr><td class=\"clear\"><label for=\"publisher\">Издательство</label></td><td class=\"clear\"><input type=\"text\" name=\"publisher\" id=\"publisher\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напишите издателя книги</span></td></tr>"
				   ."<tr><td class=\"clear\"><label for=\"format\">Формат</label></td><td class=\"clear\"><input type=\"text\" name=\"format\" id=\"format\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Например: PDF</span></td></tr>"
				   ."<tr><td class=\"clear\"><label for=\"quality\">Качество</label></td><td class=\"clear\"><input type=\"text\" name=\"quality\" id=\"quality\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Опишите качество страниц книги</span></td></tr>"
				   ."<tr><td class=\"clear\"><label for=\"pages\">Количество страниц</label></td><td class=\"clear\"><input type=\"text\" name=\"pages\" id=\"pages\" size=\"40\" /><br /><span style=\"font-size:9px;color:#999999;\">Напишите количество страниц в книге</span></td></tr>";
				  echo "</table></fieldset>";
				  echo "<input type=\"hidden\" name=\"shab_category\" value=\"{$template}\" />";
				  echo "<input type=\"hidden\" name=\"type\" value=\"".intval($row['id'])."\" /><br />";
				  
				  # Вывод настроек торрента
				  if(get_user_class() >= UC_ADMINISTRATOR) { ?>
                  <fieldset><legend style="padding:5px;border:1px solid #ccc;background:#f6f6f6;">Дополнительные настройки</legend>
                  <table width="100%" cellpadding="5" align="center" cellspacing="0">
                    <tr>
                      <td align="left" class="clear"><input type="checkbox" name="sticky" id="sticky" value="yes" />&nbsp;<label for="sticky">Прикрепить этот торрент (всегда наверху)</label></td>
                   </tr>
                   <tr>
                      <td align="left" class="clear"><input type="checkbox" name="free" id="free" value="yes" />&nbsp;<label for="free"><?=$tracker_lang['golden_descr'];?></label></td>
                   </tr>   
                   </table></fieldset>
                   <?php  }
				   echo "<br /><div align=\"center\"><input type=\"hidden\" name=\"type\" value='".$id."' /><input type=\"submit\" value=\"Загрузить торрент\" /></div></form>\n";
			   break;
			   default :
/*
// ==========================================================================================
//
// 
//  УНИВЕРСАЛЬНЫЙ ШАБЛОН РАЗДАЧ
//
//
// ==========================================================================================
*/	
           	   
			   ?>
               <script>
			     function check__() {
					 var tfile  = document.getElementById('tfile');
	                 var name   = document.getElementById('name');
					 var descr  = document.getElementById('descr');
					 
					 if(tfile.value == '') {
						  alert( 'Выберите торрент файл' );
						    tfile.focus();
							  return false;
					  }
					  if(name.value == '') {
						  alert( 'Введите название раздачи' );
						    name.focus();
							  return false;
					  }
					  if(descr.value == '') {
						  alert( 'Введите описание раздачи' );
						    descr.focus();
							  return false;
					  }
				 }
			   </script>
<form name="upload" enctype="multipart/form-data" action="takeupload_new.php" target="_blank" method="post" onsubmit="return check__();"><input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_torrent_size;?>" />
		        <fieldset><legend style="padding:5px;border:1px solid #ccc;background:#f6f6f6;">Основные данные <?=$row['template'];?></legend>
                <table width="100%" cellpadding="5" align="center" cellspacing="0">
		        <tr><td width="20%" class="clear"><label for="tfile">.torrent файл*</label></td><td class="clear"><input type="file" name="tfile" id="tfile" size="80" /></td></tr>
                <tr><td class="clear"><label for="name">Название*</label></td><td class="clear"><input type="text" name="name" id="name" size="70" /></td></tr>
		        <tr><td class="clear" valign="top">Постер</td><td class="clear"><input type="file" name="image0" size="80" /></td></tr>
		        <tr><td valign="top" class="clear"><label for="screen1">Скриншоты</label></td><td class="clear"><input type="text" name="screen1" id="screen1" size="70" />&nbsp;&nbsp;<a href="javascript:;" onclick="add_filed(); return false;" class="ajax-link" id="add_screen">Еще скриншот</a><br /><span id="src_place"></span></td></tr>
		        <tr><td valign="top" class="clear">Описание*</td><td class="clear"><?=textbbcode('upload','descr','');?></td></tr>
		        </table></fieldset><br />
               
               <?php 
                # Вывод настроек торрента
				  if(get_user_class() >= UC_ADMINISTRATOR) { ?>
                  <fieldset><legend style="padding:5px;border:1px solid #ccc;background:#f6f6f6;">Дополнительные настройки</legend>
                  <table width="100%" cellpadding="5" align="center" cellspacing="0">
                    <tr>
                      <td align="left" class="clear"><input type="checkbox" name="sticky" id="sticky" value="yes" />&nbsp;<label for="sticky">Прикрепить этот торрент (всегда наверху)</label></td>
                   </tr>
                   <tr>
                      <td align="left" class="clear"><input type="checkbox" name="free" id="free" value="yes" />&nbsp;<label for="free"><?=$tracker_lang['golden_descr'];?></label></td>
                   </tr>   
                   </table></fieldset>
                   <?php  }
				  echo "<input type=\"hidden\" name=\"type\" value='".$id."' />";
				   echo "<br /><div align=\"center\"><input type=\"submit\" value=\"Загрузить торрент\" /></div></form>\n";
			   break;
}
///////////////////////////////
}else{stdmsg( 'Внимание', 'Категория не выбрана','error' );}}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>