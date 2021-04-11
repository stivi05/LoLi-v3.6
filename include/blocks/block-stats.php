<?php if (!defined('BLOCK_FILE')){location("../index.php");exit;}global $rootpath, $tracker_lang, $CacheBlock;
$blocktitle = ".:: ".$tracker_lang['statistic']." ::.";$_cache = 'statsblock.cache';if(file_exists($rootpath."include/cache/statsblock.cache")){
$content = $CacheBlock->Read($_cache);}else{$a = mysql_fetch_array(sql_query("SELECT textt FROM stats WHERE id=1"));$content = $a['textt'];}?>