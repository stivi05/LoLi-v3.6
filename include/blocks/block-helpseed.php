<?php if (!defined('BLOCK_FILE')){Header("Location: ../index.php");exit;}global $CacheBlock, $helpseedBlock_Refresh, $tracker_lang;
$blocktitle = ".:: Релизы, которым нужны раздающие ::.";$_cache = 'Blocks_helpseed.cache'; 
if (!$CacheBlock->Check($_cache, $helpseedBlock_Refresh?0:7200)){  //1 chas ||60 - 1 minuta || 600 - 10 minut || 6000 - 100 minut || 3600 - 1 chas
$content .= "<table width='100%' style='border:0;' cellspacing='0' cellpadding='10'><center><b>
<font color='#FF6633'>".$tracker_lang['help_seed']."</font></b><hr><tr><td class='text' style='border:0;'>";
$res = sql_query("SELECT id, name, seeders, leechers FROM torrents WHERE (leechers > 0 AND seeders = 0) OR (leechers / seeders >= 4) ORDER BY leechers DESC LIMIT 20") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res) > 0){while($arr = mysql_fetch_assoc($res)){$torrname = $arr['name'];
$content .= "<center><b><a href='details_".$arr['id']."' alt='".$arr['name']."' title='".$arr['name']."'>".$torrname."</a></b>
<font color='#0099FF'><b> (Раздают: ".number_format($arr['seeders'])." Качают: ".number_format($arr['leechers']).")</b></font><br></center>";
}}else $content .= "<center><b> ".$tracker_lang['no_need_seeding']." </b></center>";$content .= "</td></tr></center></table>";
$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>