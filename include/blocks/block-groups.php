<?php if(!defined('BLOCK_FILE')){Header("Location: ../index.php");exit;}global $CacheBlock, $rootpath;
$_cache = 'Blocks_groups.cache';if(!file_exists($rootpath."include/cache/Blocks_groups.cache")){
$result = mysql_query("SELECT id, name, bonus FROM groups ORDER BY bonus DESC LIMIT 10");
$content .= "<table border='0' width='100%'><tr><td align='center'><b>Название</b></td><td align='center'><b>Бонусы</b></td></tr>"; 
while (list($id, $name, $bonus) = mysql_fetch_row($result)){$names = htmlspecialchars_uni($name);    
$content .= "<tr><td align='center'><a href='group.php?action=viewforum&forumid=$id'><b>$names</b></a></td><td align='center'><b>$bonus</b></td></tr>";}
$content .= "</table>";$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>