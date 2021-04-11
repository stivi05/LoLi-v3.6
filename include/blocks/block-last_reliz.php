<?php if(!defined('BLOCK_FILE')){Header("Location: ../");exit;}
global $CacheBlock;$blocktitle = ".:: Последние 10 релизов ::.";$_cache = 'Blocks_lastreliz_10.cache';
$Blrelizs_cache = $rootpath."include/cache/Blocks_lastreliz_10.cache";if(!file_exists($Blrelizs_cache)){
$content .= "<table cellspacing='0' cellpadding='5' style='background:none;border:0;' width='100%'><tr><center>";   
$res = sql_query("SELECT torrents.id, torrents.name, torrents.images_sm FROM torrents ORDER BY added DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
while($release = mysql_fetch_array($res)){$nazvanie = $release["name"];
$content .= "<td style='background:none;border:0;' width='80px'><center>
<a href='details_".$release['id']."' alt='$nazvanie' title='$nazvanie'><img border='none' title='$nazvanie' src='torrents/images_smals/".$release["images_sm"]."'/></a></center></td>";}
$content .= "</center></tr></table>";$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>