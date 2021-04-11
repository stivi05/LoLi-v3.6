<?php if(!defined('BLOCK_FILE')){Header("Location: ../");exit;}$blocktitle = ".:: Последние 20 релизов ::.";
global $CURUSER, $CacheBlock, $tracker_lang, $rootpath;$_cache = 'Blocks_relizs_last.cache';
$Blrelizslast_cache = $rootpath."include/cache/Blocks_relizs_last.cache";if(!file_exists($Blrelizslast_cache)){
$content .= "<table cellspacing='0' cellpadding='5' width='100%'>";   
$res = sql_query("SELECT torrents.id, torrents.name, (torrents.leechers + torrents.remote_leechers) AS leechers, 
(torrents.seeders + torrents.remote_seeders) AS seeders FROM torrents ORDER BY added DESC LIMIT 20") or sqlerr(__FILE__, __LINE__);
while($release = mysql_fetch_array($res)){$nazvanie = $release["name"];
$content .= "<tr><td><center><a href='details_".$release['id']."' alt='$nazvanie' title='$nazvanie'><b>$nazvanie</b></a>
&nbsp;&nbsp;(seeders=>".$release['seeders']." / leechers=>".$release['leechers'].")</center></td></tr>";}
$content .= "</table>";$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>
