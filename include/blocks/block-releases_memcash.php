<?php if(!defined('BLOCK_FILE')){Header("Location: ../");exit;}global $CURUSER, $CacheBlock, $tracker_lang, $rootpath;$_cache = 'Blocks_relizs.cache';
$Blrelizs_cache = $rootpath."include/cache/Blocks_relizs.cache";if(!file_exists($Blrelizs_cache)){
$res1 = sql_query("SELECT COUNT(id) FROM relizi_block");$row1 = mysql_fetch_array($res1);$count = $row1[0];
$CacheBlock->Write($_cache, $count);}else $count = $CacheBlock->Read($_cache);
$blocktitle = ".:: Наши Релизы ::.";
$content .= "<table style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'><tr><td align='center' style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'>";
$perpage = 10;list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"]."?");
$content .= $pagertop."</td></tr>";$torrents = relizi_block($limit);foreach($torrents as $release){$content .= $release["textt"];}
$content .= "<tr><td align='center' style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'>".$pagerbottom."</td></tr></table>";?>