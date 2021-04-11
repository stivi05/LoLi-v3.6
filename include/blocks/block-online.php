<?php if(!defined('BLOCK_FILE')){Header("Location: ../");exit;}global $rootpath, $CacheBlock;
$blocktitle = ".:: Онлайн ::.";$_cache = 'onlineblock.cache';if(file_exists($rootpath."include/cache/onlineblock.cache")){
$content = $CacheBlock->Read($_cache);}else{$a = mysql_fetch_array(sql_query("SELECT textt FROM online WHERE id=1"));$content = $a['textt'];}?>