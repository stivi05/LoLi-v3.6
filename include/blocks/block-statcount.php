<?php if(!defined('BLOCK_FILE')) {Header("Location: ../index.php");exit;}global $CacheBlock, $statcountBlock_Refresh; 
$blocktitle = ".:: Посещаемость ::.";$_cache = 'Blocks_statcount.cache';if(!$CacheBlock->Check($_cache, $statcountBlock_Refresh?0:86400)){ //5 chasov
$dt24 = gmtime() - 86400;$dt24 = sqlesc(get_date_time($dt24));
$result = sql_query("SELECT SUM(last_access >= $dt24) AS totalol24 FROM users") or sqlerr(__FILE__, __LINE__);while($row = mysql_fetch_array ($result)){
$totalonline24 = $row["totalol24"];}$dt7 = gmtime() - 604800;$dt7 = sqlesc(get_date_time($dt7));
$result = sql_query("SELECT SUM(last_access >= $dt7) AS totalol7 FROM users") or sqlerr(__FILE__, __LINE__);while($row = mysql_fetch_array ($result)){
$totalonline7 = $row["totalol7"];}$dt30 = gmtime() - 2678400;$dt30 = sqlesc(get_date_time($dt30));
$result = sql_query("SELECT SUM(last_access >= $dt30) AS totalol30 FROM users") or sqlerr(__FILE__, __LINE__);while($row = mysql_fetch_array ($result)){
$totalonline30 = $row["totalol30"];}$dt356 = gmtime() - 31536000;$dt356 = sqlesc(get_date_time($dt356));
$result = sql_query("SELECT SUM(last_access >= $dt356) AS totalol356 FROM users") or sqlerr(__FILE__, __LINE__);while($row = mysql_fetch_array ($result)){
$totalonline356 = $row["totalol356"];}$dtall = gmtime() - 315360000;$dtall = sqlesc(get_date_time($dtall));
$result = sql_query("SELECT SUM(last_access >= $dtall) AS totalolall FROM users") or sqlerr(__FILE__, __LINE__);while($row = mysql_fetch_array ($result)){
$totalonlineall = $row["totalolall"];}
$content .= "<center><table border='0' cellspacing='1' cellpadding='5' class='main' width='100%'><tr><td class='a' align='center'>
<b>За день:</b> $totalonline24</td></tr><tr><td class='b' align='center'><b>За неделю:</b> $totalonline7</td></tr><tr><td class='a' align='center'>
<b>За месяц:</b> $totalonline30</td></tr><tr><td class='b' align='center'><b>За год:</b> $totalonline356</td></tr><tr><td class='a' align='center'>
<b>За всё время:</b> $totalonlineall</td></tr></table></center>";
$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>