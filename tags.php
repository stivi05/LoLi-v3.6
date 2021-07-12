<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
stdhead("Теги");begin_frame(".:: Теги ::.");$test = (string) $_POST["test"];?>
<p><?=$SITENAME?> поддерживает большое количество <i>BB тегов</i> которые вы можете использовать для украшения ваших раздач и постов.</p>
<form method='post' action='tags.php'><textarea name='test' cols='60' rows='3'><?print($test ? htmlspecialchars_uni($test) : "")?></textarea>
<input type='submit' value="Проверить этот код!" style='height:23px;margin-left:5px'></form><?if($test != "") print("<p><hr>".format_comment($test)."<hr></p>");?>
<?/// жирный текст ///////?>
<p class='sub'><b>Bold</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Makes the enclosed text bold.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[b]<i>Text</i>[/b]</tt></td></tr><tr valign='top'><td>Пример:</td>
<td><tt>[b]This is bold text.[/b]</tt></td></tr><tr valign='top'><td>Результат:</td><td><b>This is bold text.</b></td></tr></table>
<?/// наклонный текст ///////?>
<p class='sub'><b>Italic</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'>
<tr valign='top'><td width='25%'>Описание:</td><td>Makes the enclosed text italic.</td></tr>
<tr valign='top'><td>Синтаксис:</td><td><tt>[i]<i>Text</i>[/i]</tt></td></tr><tr valign='top'><td>Пример:</td><td><tt>[i]This is italic text.[/i]</tt></td></tr>
<tr valign='top'><td>Результат:</td><td><i>This is italic text.</i></td></tr></table>
<?/// подчеркнутый текст ///////?>
<p class='sub'><b>Underline</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Makes the enclosed text underlined.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[u]<i>Text</i>[/u]</tt></td></tr><tr valign='top'><td>Пример:</td>
<td><tt>[u]This is underlined text.[/u]</tt></td></tr><tr valign='top'><td>Результат:</td><td><u>This is underlined text.</u></td></tr></table>
<?/// цветной текст версия 1 ///////?>
<p class='sub'><b>Color (alt. 1)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Changes the color of the enclosed text.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[color=<i>Color</i>]<i>Text</i>[/color]</tt></td></tr><tr valign='top'>
<td>Пример:</td><td><tt>[color=blue]This is blue text.[/color]</tt></td></tr><tr valign='top'><td>Результат:</td><td><span style="color: blue">This is blue text.</span></td>
</tr><tr><td>Примечание:</td><td>What colors are valid depends on the browser. If you use the basic colors (red, green, blue, yellow, pink etc) you should be safe.</td></tr></table>
<?/// цветной текст версия 2 ///////?>
<p class='sub'><b>Color (alt. 2)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Changes the color of the enclosed text.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[color=#<i>RGB</i>]<i>Text</i>[/color]</tt></td></tr><tr valign='top'>
<td>Пример:</td><td><tt>[color=#0000ff]This is blue text.[/color]</tt></td></tr><tr valign='top'><td>Результат:</td><td><span style="color: #0000ff">This is blue text.</span></td>
</tr><tr><td>Примечание:</td><td><i>RGB</i> must be a six digit hexadecimal number.</td></tr></table>
<?/// размер текста ///////?>
<p class='sub'><b>Size</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Sets the size of the enclosed text.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[size=<i>n</i>]<i>text</i>[/size]</tt></td></tr><tr valign='top'>
<td>Пример:</td><td><tt>[size=11]This is size 10.[/size]</tt></td></tr><tr valign='top'><td>Результат:</td><td><span style='font-size: 11px'>This is size 10.</span></td></tr>
<tr><td>Примечание:</td><td><i>n</i> must be an integer in the range 1 (smallest) to 20 (biggest). The default size is 11.</td></tr></table>
<?/// стиль текста ///////?>
<p class='sub'><b>Font</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Sets the type-face (font) for the enclosed text.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[font=<i>Font</i>]<i>Text</i>[/font]</tt></td></tr><tr valign='top'>
<td>Пример:</td><td><tt>[font=Impact]Hello world![/font]</tt></td></tr><tr valign='top'><td>Результат:</td><td><span style="font-family: Impact">Hello world!</span></td></tr>
<tr><td>Примечание:</td><td>You specify alternative fonts by separating them with a comma.</td></tr></table>
<?/// Гиперссылка текст вариант 1 ///////?>
<p class='sub'><b>Гиперссылка (вариант 1)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Вставка ссылки.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[url]<i>URL</i>[/url]</tt></td></tr><tr valign='top'><td>Пример:</td><td>
<tt>[url]<?=$DEFAULTBASEURL?>[/url]</tt></td></tr><tr valign='top'><td>Результат:</td><td><a href="<?=$DEFAULTBASEURL?>" title="<?=$DEFAULTBASEURL?>"/><?=$DEFAULTBASEURL?></a>
</td></tr><tr><td>Примечание:</td><td>This tag is superfluous; all URLs are automatically hyperlinked.</td></tr></table>
<?/// Гиперссылка текст вариант 2 ///////?>
<p class='sub'><b>Гиперссылка (вариант 2)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Вставка ссылки.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[url=<i>URL</i>]<i>Текст-название (сайт, страница и т.д.)</i>[/url]</tt></td></tr><tr valign='top'>
<td>Пример:</td><td><tt>[url=<?=$DEFAULTBASEURL?>]<?=$SITENAME?>[/url]</tt></td></tr><tr valign='top'><td>Результат:</td><td>
<a href="<?=$DEFAULTBASEURL?>" title="<?=$DEFAULTBASEURL?>"><?=$SITENAME?></a></td></tr><tr><td>Примечание:</td><td>
You do not have to use this tag unless you want to set the link text; all URLs are automatically hyperlinked.</td></tr></table>
<?/// вставка картинки ///////?>
<p class='sub'><b>Image</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td><td>Inserts a picture.</td>
</tr><tr valign='top'><td>Синтаксис:</td><td><tt>[img]<i>URL</i>[/img]</tt></td></tr><tr valign='top'><td>Пример:</td><td>
<tt>[img]<?=$DEFAULTBASEURL?>/pic/smilies/happy.gif[/img]</tt></td></tr><tr valign='top'><td>Результат:</td><td>
<img src="<?=$DEFAULTBASEURL?>/pic/smilies/happy.gif" border="0" alt="<?=$DEFAULTBASEURL?>/pic/smilies/happy.gif" title="<?=$DEFAULTBASEURL?>/pic/smilies/happy.gif"/>
</td></tr><tr><td>Примечание:</td><td>The URL must end with <b>.gif</b>, <b>.jpg</b> or <b>.png</b>.</td></tr></table>
<?/// цитата вариант 1 (старый) ///////?>
<p class='sub'><b>Цитата (вариант 1 - старый вид)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Вставка цитируемого текста.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[quotes]<i>Цитируемый текст</i>[/quotes]</tt></td></tr><tr valign='top'><td>Пример:</td><td>
<tt>[quotes]The quick brown fox jumps over the lazy dog.[/quotes]</tt></td></tr><tr valign='top'><td>Результат:</td><td><div align="center"><div style="width: 85%; overflow: auto">
<table width="100%" cellspacing="1" cellpadding="3" border="0" align="center" class="bgcolor4"><tr bgcolor="#A9A9A9"><td><font class="block-title">Цитата</font></td></tr>
<tr class="bgcolor1"><td>The quick brown fox jumps over the lazy dog.</td></tr></table></div></div></td></tr></table>
<?/// ответ цитированием вариант 2 (старый) ///////?>
<p class='sub'><b>Цитата - Ответ цитированием (вариант 2 - старый вид)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'>
<td width='25%'>Описание:</td><td>Вставка цитируемого текста</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[quotes=<i>логин автора текста для цитаты</i>]<i>Цитируемый текст</i>[/quotes]</tt></td></tr>
<tr valign='top'><td>Пример:</td><td><tt>[quotes=LoLi]The quick brown fox jumps over the lazy dog.[/quotes]</tt></td></tr><tr valign='top'><td>Результат:</td><td><div align="center">
<div style="width: 85%; overflow: auto"><table width="100%" cellspacing="1" cellpadding="3" border="0" align="center" class="bgcolor4"><tr bgcolor="#A9A9A9"><td>
<font class="block-title">LoLi писал</font></td></tr><tr class="bgcolor1"><td>The quick brown fox jumps over the lazy dog.</td></tr></table></div></div></td></tr></table>
<?/// цитата вариант 3 (новый) ///////?>
<p class='sub'><b>Цитата (вариант 3 - новый вид)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Вставка цитируемого текста.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[quote]<i>Цитируемый текст</i>[/quote]</tt></td></tr><tr valign='top'><td>Пример:</td><td>
<tt>[quote]The quick brown fox jumps over the lazy dog.[/quote]</tt></td></tr><tr valign='top'><td>Результат:</td><td><div align='left' style='width:85%;overflow:auto;'>
<table style='float:left;width:avto;background:none;padding-left:5px;margin-top:7px;padding-right:15px;border:0;'><tr><td style='background:none;border:0;width:100%;'>
<table style='background:none;width:100%;float:left;border:0;'><tr>
<td class='zaliwka' style='font-weight:bold;font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:left;border:0;border-radius:5px;width:200px;'>&nbsp;&nbsp;&nbsp;&nbsp;
Цитата</td><td style='background:none;border:0;'></td></tr></table></td></tr><tr>
<td style='float:left;border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #4682B4;display:block;' class='a'>
The quick brown fox jumps over the lazy dog.</td></tr></table></div></td></tr></table>
<?/// ответ цитированием вариант 4 (новый) ///////?>
<p class='sub'><b>Цитата - Ответ цитированием (вариант 4 - новый вид)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'>
<td width='25%'>Описание:</td><td>Вставка цитируемого текста.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[quote=<i>логин автора текста для цитаты</i>]<i>Цитируемый текст</i>[/quote]</tt></td></tr>
<tr valign='top'><td>Пример:</td><td><tt>[quote=LoLi]The quick brown fox jumps over the lazy dog.[/quote]</tt></td></tr><tr valign='top'><td>Результат:</td><td>
<div align='left' style='width:85%;overflow:auto;'>
<table style='float:left;width:avto;background:none;padding-left:5px;margin-top:7px;padding-right:15px;border:0;'><tr><td style='background:none;border:0;width:100%;'>
<table style='background:none;width:100%;float:left;border:0;'><tr>
<td class='zaliwka' style='font-weight:bold;font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:left;border:0;border-radius:5px;width:200px;'>&nbsp;&nbsp;&nbsp;&nbsp;
LoLi писал</td><td style='background:none;border:0;'></td></tr></table></td></tr><tr>
<td style='float:left;border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #4682B4;display:block;' class='a'>
The quick brown fox jumps over the lazy dog.</td></tr></table></div></td></tr></table>
<?/// КОД ///////?>
<p class='sub'><b>Вставка КОД</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'>
<td width='25%'>Описание:</td><td>Вставка КОДа в текст (ссылки внутри КОД не работают - блокирует, как простой текст показывает)</td></tr><tr valign='top'><td>Синтаксис:</td>
<td><tt>[code]текст[/code]</tt></td></tr><tr valign='top'><td>Пример:</td><td><tt>[code]Audio<br />ID : 2<br />Format : FLAC<br />Format/Info : Free Lossless Audio Codec<br />
Codec ID : A_FLAC<br />Duration : 3 min 10 s<br />Bit rate mode : Variable<br />Bit rate : 3 724 kb/s<br />Channel(s) : 2 channels<br />Channel layout : L R<br />
Sampling rate : 96.0 kHz<br />Frame rate : 23.438 FPS (4096 SPF)<br />Bit depth : 24 bits<br />Compression mode : Lossless<br />Stream size : 84.5 MiB (23%)<br />
Writing library : libFLAC 1.3.2 (UTC 2017-01-01)<br />Language : Korean<br />Default : Yes<br />Forced : Yes[/code]</tt></td></tr><tr valign='top'><td>Результат:</td><td>
<div align='left' style='width:85%;overflow:auto;'><table style='float:left;width:avto;background:none;padding-left:5px;margin-top:7px;padding-right:15px;border:0;'>
<tr><td style='background:none;border:0;width:100%;'><table style='background:none;width:100%;float:left;border:0;'><tr>
<td style='background:black;font-weight:bold;font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:left;border:0;border-radius:5px;width:80px;'>&nbsp;&nbsp;&nbsp;&nbsp;
Код</td><td style='background:none;border:0;'></td></tr></table></td></tr><tr>
<td style='float:left;border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid black;display:block;' class='a'>
<code style='pointer-events:none;color:black;'>Audio<br />ID : 2<br />Format : FLAC<br />Format/Info : Free Lossless Audio Codec<br />Codec ID : A_FLAC<br />
Duration : 3 min 10 s<br />Bit rate mode : Variable<br />Bit rate : 3 724 kb/s<br />Channel(s) : 2 channels<br />Channel layout : L R<br />Sampling rate : 96.0 kHz<br />
Frame rate : 23.438 FPS (4096 SPF)<br />Bit depth : 24 bits<br />Compression mode : Lossless<br />Stream size : 84.5 MiB (23%)<br />
Writing library : libFLAC 1.3.2 (UTC 2017-01-01)<br />Language : Korean<br />Default : Yes<br />Forced : Yes</code></td></tr></table></div></td></tr></table>
<?/// PHP-КОД ///////?>
<p class='sub'><b>Вставка PHP-код</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'>
<td width='25%'>Описание:</td><td>Вставка PHP-кода в текст</td></tr><tr valign='top'><td>Синтаксис:</td>
<td><tt>[php]текст[/php]</tt></td></tr><tr valign='top'><td>Пример:</td><td><tt>[php]
Audio<br />ID : 2<br />Format : FLAC<br />Format/Info : Free Lossless Audio Codec<br />
Codec ID : A_FLAC<br />Duration : 3 min 10 s<br />Bit rate mode : Variable<br />Bit rate : 3 724 kb/s<br />Channel(s) : 2 channels<br />Channel layout : L R<br />
Sampling rate : 96.0 kHz<br />Frame rate : 23.438 FPS (4096 SPF)<br />Bit depth : 24 bits<br />Compression mode : Lossless<br />Stream size : 84.5 MiB (23%)<br />
Writing library : libFLAC 1.3.2 (UTC 2017-01-01)<br />Language : Korean<br />Default : Yes<br />Forced : Yes[/php]</tt></td></tr><tr valign='top'><td>Результат:</td><td>
<div align='left' style='width:85%;overflow:auto;'><table style='float:left;width:avto;background:none;padding-left:5px;margin-top:7px;padding-right:15px;border:0;'>
<tr><td style='background:none;border:0;width:100%;'><table style='background:none;width:100%;float:left;border:0;'><tr>
<td style='background:darkred;font-weight:bold;font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:left;border:0;border-radius:5px;width:100px;'>&nbsp;&nbsp;&nbsp;&nbsp;
PHP - Код</td><td style='background:none;border:0;'></td></tr></table></td></tr><tr>
<td style='float:left;border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid darkred;display:block;' class='a'>
<code style='pointer-events:none;'><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br /><br />Audio<br />ID&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">2<br />Format&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">FLAC<br />Format</span><span style="color: #007700">/</span><span style="color: #0000BB">Info&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">Free&nbsp;Lossless&nbsp;Audio&nbsp;Codec<br />Codec&nbsp;ID&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">A_FLAC<br />Duration&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">3&nbsp;min&nbsp;10&nbsp;s<br />Bit&nbsp;rate&nbsp;mode&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">Variable<br />Bit&nbsp;rate&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">3&nbsp;724&nbsp;kb</span><span style="color: #007700">/</span><span style="color: #0000BB">s<br />Channel</span><span style="color: #007700">(</span><span style="color: #0000BB">s</span><span style="color: #007700">)&nbsp;:&nbsp;</span><span style="color: #0000BB">2&nbsp;channels<br />Channel&nbsp;layout&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">L&nbsp;R<br />Sampling&nbsp;rate&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">96.0&nbsp;kHz<br />Frame&nbsp;rate&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">23.438&nbsp;FPS&nbsp;</span><span style="color: #007700">(</span><span style="color: #0000BB">4096&nbsp;SPF</span><span style="color: #007700">)<br /></span><span style="color: #0000BB">Bit&nbsp;depth&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">24&nbsp;bits<br />Compression&nbsp;mode&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">Lossless<br />Stream&nbsp;size&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">84.5&nbsp;MiB&nbsp;</span><span style="color: #007700">(</span><span style="color: #0000BB">23</span><span style="color: #007700">%)<br /></span><span style="color: #0000BB">Writing&nbsp;library&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">libFLAC&nbsp;1.3.2&nbsp;</span><span style="color: #007700">(</span><span style="color: #0000BB">UTC&nbsp;2017</span><span style="color: #007700">-</span><span style="color: #0000BB">01</span><span style="color: #007700">-</span><span style="color: #0000BB">01</span><span style="color: #007700">)<br /></span><span style="color: #0000BB">Language&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">Korean<br /></span><span style="color: #007700">Default&nbsp;:&nbsp;</span><span style="color: #0000BB">Yes<br />Forced&nbsp;</span><span style="color: #007700">:&nbsp;</span><span style="color: #0000BB">Yes
<br /><br />?&gt;</span></span></code></code></td></tr></table></div></td></tr></table>
<?/// список - точка ///////?>
<p class='sub'><b>Спойлер (скрытая информация - картинки, текст)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td><td>Вставка спойлера (скрытая информация - картинки, текст)
</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[spoiler=Скрытая информация]<i>Text</i>[/spoiler]</tt></td></tr><tr valign='top'><td>Пример:</td><td><tt>[spoiler=Скрытая информация]Спойлер (скрытая информация - картинки, текст)[/spoiler]</tt></td></tr>
<tr valign='top'><td>Результат:</td><td><div class='spoiler_head' onclick="javascript:showspoiler('1626095091351')"><img border='0' src='pic/plus.gif' id='pic1626095091351' title='Показать'/>&nbsp;&nbsp;Скрытая информация</div><div class='spoiler_body' style='display:none;' id=1626095091351 name=1626095091351>Спойлер (скрытая информация - картинки, текст)
<br /></div></td></tr></table>
<?/// список - точка ///////?>
<p class='sub'><b>Список</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td><td>Вставка списка (точек)
</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[li]<i>Text</i></tt></td></tr><tr valign='top'><td>Пример:</td><td><tt>[li] This is item 1 [li] This is item 2</tt></td></tr>
<tr valign='top'><td>Результат:</td><td><li> This is item 1 <li> This is item 2</td></tr></table>
<?/// Ютуб-видео ///////?>
<p class='sub'><b>Видео с <u>youtube.com</u>. Берем номер для вставки между кодами (веделенно жирным):</b> youtube.com/watch?v=<b>DWqlZchiDPs</b></p>
<table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td><td>Вставка видео с Ютуб
</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[youtube]номер[/youtube]</tt></td></tr><tr valign='top'><td>Пример:</td><td><tt>[youtube]DWqlZchiDPs[/youtube]</tt></td>
</tr><tr valign='top'><td>Результат:</td><td><object width='640' height='360'><param name=movie value='https://www.youtube.com/embed/DWqlZchiDPs'></param>
<param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='https://www.youtube.com/embed/DWqlZchiDPs' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='640' height='360'></embed></object></td></tr></table>
<?/// Рутуб-видео ///////?>
<p class='sub'><b>Видео с <u>rutube.ru</u>. Берем номер для вставки между кодами (веделенно жирным):</b> rutube.ru/video/<b>11b32e75065bd36b01b543d55264fabd</b></p>
<table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td><td>Вставка видео с Рутуб
</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[rutube]номер[/rutube]</tt></td></tr><tr valign='top'><td>Пример:</td><td><tt>[rutube]11b32e75065bd36b01b543d55264fabd[/rutube]</tt></td></tr><tr valign='top'><td>Результат:</td><td><object width='640' height='360'><param name=movie value='https://rutube.ru/play/embed/11b32e75065bd36b01b543d55264fabd'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='https://rutube.ru/play/embed/11b32e75065bd36b01b543d55264fabd' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='640' height='360'></embed></object>
</td></tr></table>
<?/// Уменьшить картинку по высоте ///////?>
<p class='sub'><b>Уменьшить огромную картинку до 360px по высоте</b></p>
<table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>В описании картинка высотой 360px (автоматически уменьшает огромные размеры вставляемого изображения)</td></tr><tr valign='top'><td>Синтаксис:</td><td>
<tt>[th]URL-картинки[/th]</tt></td></tr><tr valign='top'><td>Пример:</td><td><tt>[th]https://hdclub.top/torrents/images/1169.jpg[/th]</tt></td></tr><tr valign='top'>
<td>Результат:</td><td><a href='<?=$DEFAULTBASEURL?>/torrents/images/10.jpg' class='highslide' onclick='return hs.expand(this)'><img style='margin: 2px 2px 0 0;width:360px;' src='https://hdclub.top/torrents/images/1169.jpg' border='0' alt='https://hdclub.top/torrents/images/1169.jpg' title='https://hdclub.top/torrents/images/1169.jpg'/></a>
</td></tr></table>
<?end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
