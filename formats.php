<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
stdhead("ЧаВо: Форматы Файлов");begin_frame(".:: ЧаВо: Форматы Файлов ::.");?>
<script src="js/jquerytab.js"></script><script src="js/js_global.js"></script><link rel="stylesheet" href="css/faq.css"><script>$(function(){$("#tabs").tabs({remote: true})});</script>
<!-------->
<table style='background:none;width:100%;border:0;'><tr><td valign='top' style="border:0px"><div id="tabs">
<ul><li><a href="#tabs-1">Архивы</a></li><li><a href="#tabs-2">Мультимедийные файлы</a></li>
<li><a href="#tabs-3">Образы дисков</a></li><li><a href="#tabs-4">Другие файлы</a></li><li><a href="#tabs-5">Ошибки, неточности</a></li></ul>
<!-------->
<div id="tabs-1"><table style='background:none;width:100%;float:left;border:0;'><ul><b>*.rar / *.zip / *.ace / *.r01 / *.001</b><br>Это самые распространённые расширения архивов.
<br>Файлы упаковываются в архивы для уменьшения объёма и чтобы их было удобнее скачивать.<br>
Чтобы открыть эти архивы вы иожете использовать <a href="http://www.rarsoft.com/download.htm">WinRAR</a> или <a href="http://www.powerarchiver.com/download/">PowerArchiver</a>.<br>
<br>Если эти программы не помогли вам открыть <b>*.zip</b> файл, попробуйте <a href="http://www.winzip.com/download.htm">WinZip</a> (Демо версия).<br>
Если предыдущие программы не помогли вам открыть <b>*.ace</b> или <b>*.001</b> файл, попробуйте <a href="http://www.winace.com/">Winace</a> (Демо версия).<br>
<br><b>*.cbr / *.cbz</b><br>
Обычно это заархивированные комиксы. Файлы с расширением <b>*.cbr</b> аналогичны файлам с расширением <b>*.rar</b>, а файлы с расширением <b>*.cbz</b> - файлам с расширением <b>*.zip</b> . Не смотря на это 
<b>WinRAR</b> или <b>WinZip</b> могут не корректно открыть эти файлы. Если такое произошло, попробуйте программу <a href="http://www.geocities.com/davidayton/CDisplay">CDisplay</a>.
</ul></table></div>
<!-------->
<div id="tabs-2"><table style='background:none;width:100%;float:left;border:0;'><ul><b>*.avi / *.mpg. / *.mpeg / *.divx / *.xvid / *.wmv / *.ts / *.m2ts / *.mkv / *.mp4 / *.webm</b><br>
Это обычно видео файлы. Их можно открыть любым видео плеером, но мы рекомендуем использовать следующие программы:<br><br>
<a href="http://www.inmatrix.com/files/zoomplayer_download.shtml">Zoomplayer</a>,
<a href="http://www.bsplayer.org/">BSPlayer</a>, <a href="http://www.videolan.org/vlc/">VLC media player</a>, <a href="http://softella.com/la/index.ru.htm">Light Alloy</a> 
или <a href="http://www.microsoft.com/windows/windowsmedia/default.aspx">Windows Media Player</a>. Также вам понадобятся кодеки, для открыия соответствующих файлов.
<br>Очень часто бывает, что фильм не открывается, из-за отсутствия нужного кодека. Для определения необходимого кодека используйте программу 
<a href="http://www.headbands.com/gspot/download.html">GSpot</a>. Ниже перечислены самые распространённые кодеки:<br><br>
• <a href="http://sourceforge.net/project/showfiles.php?group_id=53761&release_id=95213">ffdshow</a> (Рекомендуемый! (открывает многие форматы: XviD, DivX, 3ivX, mpeg-4))<br><br>
• <a href="http://nic.dnsalias.com/xvid.html">XviD codec</a><br><br>• <a href="http://www.divx.com/divx/">DivX codec</a><br><br>
• <a href="http://sourceforge.net/project/showfiles.php?group_id=66022&release_id=178906">ac3filter</a> (для звука)<br><br>
• <a href="http://tobias.everwicked.com/oggds.htm">Ogg media codec</a> (для .OGM файлов и для звука)<br><br><b>*.mov</b><br>
Это видео файлы от <a href="http://www.apple.com/quicktime/">QuickTime</a>. Оригинальную программу для их открытия можно скачать с сайта 
<a href="http://www.apple.com/quicktime/download/">QuickTime</a>.
Есть также альтернативная програма, скачать можно <a href="http://download2.times.lv/master/files/0/Multimedia/Video/quicktimealt140.exe">отсюда</a>.<br>
<br><b>*.ra / *.rm / *.ram</b><br>Это видео файлы от <a href="http://www.real.com">Real.com</a>. Для их открытия рекомендуется использовать альтернативную программу - 
<a href=" http://download2.times.lv/master/files/0/Multimedia/Video/realalt130[www.free-codecs.com].exe">Real Alternative</a>.<br>
<br><b>*.mp3 / *.mp2 / *.ogg / *.m4a / *.flac / *.ape / *.opus / *.wav / *.wv / *.dsf /*.dff</b><br>Музыкальные файлы. Если у вас установлен нужный кодек, то для их открытия подойдёт: 
<a href="http://www.winamp.com/">WinAmp</a>, <a href="https://www.aimp.ru/">AIMP</a> или <a href="http://softella.com/la/index.ru.htm">Light Alloy</a>
</ul></table></div>
<!-------->
<div id="tabs-3"><table style='background:none;width:100%;float:left;border:0;'><ul><b>*.bin / *.cue / *.iso</b><br>
Это стандартные образы CD-дисков. Образ диска - это точная копия CD-диска. Есть несколько вариантов открытия этих файлов. Можно записать их на CD, с помощью 
<a href="http://www.ahead.de">Nero</a> (демо версия) или использовать программу для эмулирования cd-rom, <a href="http://www.daemon-tools.cc/portal/portal.php">Daemon Tools</a>.
<br><br><b>*.ccd / *.img / *.sub</b><br>Это образы программы <a href="http://www.elby.ch/english/products/clone_cd/index.html"> CloneCD</a>. Смысл тот же, что и *.bin / *.cue / *.iso.
</center></ul></table></div>
<!-------->
<div id="tabs-4"><table style='background:none;width:100%;float:left;border:0;'><ul><b>*.txt / *.doc</b><br>
Текстовые файлы. Файлы с расширением .txt можно открыть в любом текстовом редакторе. Файлы с расширением .doc можно открыть с помощью Microsoft Word.<br><br><b>*.nfo</b><br>
Файлы с этим расширением содержат информацию о файлах, которые вы скачали. Рекомендуется их читать! Это текстовые файлы, часто содержащие ascii-art. Открыть можно с помощью 
Notepad, Wordpad, <a href="http://www.damn.to/software/nfoviewer.html">DAMN NFO Viewer</a> или <a href="http://www.ultraedit.com/">UltraEdit</a>.<br><br>
<b>*.pdf</b><br>Открываются с помощью <a href="http://www.adobe.com/products/acrobat/main.html">Adobe Acrobat Reader</a>.<br>
<br><b>*.jpg / *.gif / *.tga / *.psd</b><br>Графические файлы. В основном содержат картинки, открыть можно с помощью Adobe Photoshop или любым другим графическим редактором.<br><br>
<b>*.sfv</b><br>Служат для проверки целостности скаченных файлов. Для проверки используйте программу <a href="http://www.traction-software.co.uk/SFVChecker/">SFVChecker</a> 
(Демо версия) или <a href="http://www.big-o-software.com/products/hksfv/">hkSFV</a>.</ul></table></div>
<!-------->
<div id="tabs-5"><table style='background:none;width:100%;float:left;border:0;'> 
<ul><b>Если заметите ошибки или неточности, обратитесь к <a href='staff.php'><u>Администрации</u></a></b>.</ul></table></div>
<!-------->
</div></td></tr></table>
<!-------->
<table style='margin-top:7px;width:100%;background:none;border:0;cellspacing:0;'>
<font style='font-size:8px;color:#004E98;font-weight:bold;float:right;'>Форматы отредактированы 03.06.2021 (06:00 GMT+2)</font></table>
<!-------->
<?end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>