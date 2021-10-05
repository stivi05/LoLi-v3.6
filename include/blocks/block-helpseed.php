<?php if (!defined('BLOCK_FILE')){Header("Location: ../index.php");exit;}global $CacheBlock, $helpseedBlock_Refresh, $tracker_lang;
$blocktitle = ".:: Релизы, которым нужны раздающие ::.";$_cache = 'Blocks_helpseed.cache'; 
if(!$CacheBlock->Check($_cache, $helpseedBlock_Refresh?0:7200)){ /*/ 1 chas ||60 - 1 minuta || 3600 - 1 chas /*/
$content .= "<table style='background:none;width:98%;border:0;' cellspacing='0' cellpadding='10px'>";
$res = sql_query("SELECT id, name, seeders, free, leechers FROM browse WHERE leechers > 0 AND seeders = 0 ORDER BY leechers DESC LIMIT 20") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res) > 0){while($arr = mysql_fetch_assoc($res)){$torrname = htmlspecialchars_uni($arr['name']);switch($arr['free']){
case 'bril': $disname = "<font color='blue' title='Бриллиантовая раздача! Это значит, что кол-во розданного на этой раздаче удваивается!'>$torrname</font>";break;
case 'yes': $disname = "<font color='#d08700' title='Золотая раздача! Это значит, что кол-во скачанного на этой раздаче не идет в общую статистику!'>$torrname</font>";break;
case 'silver': $disname = "<font color='#778899' title='Серебрянная раздача! Это значит, что половина скачанного на этой раздаче не идет в общую статистику!'>$torrname</font>";break;
case 'no': $disname = $torrname;}$disnames = $disname;
$content .= "<tr><td style='margin-top:3px;border-radius:8px;font-weight:bold;font-family:Georgia;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='b'>
&nbsp;&nbsp;<a href='details_".$arr['id']."' alt='".$torrname."' title='".$torrname."'>".$disnames."</a></td>
<td width='2px' align='center' valign='top' style='background:none;border:none;'></td>
<td style='margin-top:3px;border-radius:8px;font-family:cursive;-webkit-border-radius:8px;font-size:10px;font-weight:bold;text-align:center;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='b'>
<font color='green'><b>".number_format($arr['seeders'])."</b></font><font color='green' alt='Раздают' title='Раздают'>&#9650;</font>
<font color='red' alt='Качают' title='Качают'>&#9660;</font><font color='red'><b>".number_format($arr['leechers'])."</b></font></td></tr>";
}}else $content .= "<center><b>".$tracker_lang['no_need_seeding']."</b></center>";$content .= "</td></tr></center></table>";
$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>
