<?php if (!defined('BLOCK_FILE')) {header("Location: ../index.php");exit;}global $CacheBlock, $kalendarBlock_Refresh, $tracker_lang; 
$blocktitle = ".:: Календарик ::.";$_cache = 'Blocks_kalendar.cache';
if(!$CacheBlock->Check($_cache, $kalendarBlock_Refresh?0:86400)){ //1 den!
$res = sql_query("SELECT UNIX_TIMESTAMP(added) FROM users WHERE id='1' LIMIT 1") or sqlerr(__LINE__,__FILE__);$row = mysql_fetch_array($res);
$sitedate = get_elapsed_time($row["UNIX_TIMESTAMP(added)"]);$content = "<center>Нашему сайту $sitedate</center><hr>";$content .= <<<BLOCKHTML
<center><SCRIPT>var mydate=new Date()
var year=mydate.getYear()
if(year < 1000) year+=1900
var day=mydate.getDay()
var month=mydate.getMonth()
var daym=mydate.getDate()
if (daym<10) daym="0"+daym
var dayarray=new Array("<div tooltip='Последний выходной'>Воскресенье - Последний выходной</div>","<div tooltip='Самый тяжолый день'>Понедельник - Самый тяжолый день</div>","<div tooltip='Второй рабочий, полет нормальный'>Вторник - Второй рабочий, полет нормальный</div>","<div tooltip='Вечером можно вспомнить воскресенье'>Среда - Вечером можно вспомнить воскресенье</div>","<div tooltip='Скоро выходной'>Четверг - Скоро выходной</div>","<div tooltip='УРА последний рабочий день'>Пятница - УРА последний рабочий день!</div>","<div tooltip='Ну наконец дождались'>Суббота - Ну наконец дождались!</div>")
var montharray=new Array("января","февраля","марта","апреля","мaя","июня","июля","августа","сентября","октября","ноября","декабря")
document.write("<div tooltip='Дата'><font size='4px' color='red'>Сегодня "+daym+" "+montharray[month]+"</font><br/>"+year+ " года, "+dayarray[day]+"</div>")
</script></center>
BLOCKHTML;
$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>