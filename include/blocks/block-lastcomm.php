<?php if(!defined('BLOCK_FILE')){Header("Location: ../index.php");exit;}global $CacheBlock, $rootpath; 
$blocktitle = ".:: Комментарии ::.";$_cache = 'Blocks_lastcom.cache';if(!file_exists($rootpath."include/cache/Blocks_lastcom.cache")){
$result = mysql_query("SELECT comments.torrent, text FROM comments LEFT JOIN users ON comments.user = users.id "." ORDER BY comments.id DESC limit 20") or sqlerr(__FILE__, __LINE__); 
$content.= '<A name= "scrollingCode"></A><MARQUEE behavior= "scroll" align= "center" direction= "up" height="170" scrollamount= "2" scrolldelay= "30" onmouseover="this.stop()" onmouseout="this.start()">'; 
while ($row = mysql_fetch_assoc($result)){ 
$subres = mysql_query("SELECT name from torrents where id=".$row["torrent"]) or sqlerr(__FILE__, __LINE__);$subrow = mysql_fetch_array($subres); 
$pid = intval($row['torrent']);$desc = trim($row['text']);$desc2 = trim($subrow['name']);  
$content .= "<center><a href=\"details_$pid\"><font color=#0080FF><u>$desc2</u></font></a><br>".format_comment($desc)."</center><br><br>";} 
$content.="</MARQUEE>";$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>