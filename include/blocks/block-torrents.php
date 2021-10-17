<?php if (!defined('BLOCK_FILE')){Header("Location: ../index.php");exit;}$blocktitle = "Новинки";
global $CURUSER, $CacheBlock, $tracker_lang, $rootpath;$_cache = 'Blocks_torrents.cache';
$Bltorrents_cache = $rootpath."include/cache/Blocks_torrents.cache";if(!file_exists($Bltorrents_cache)){
$res1 = sql_query("SELECT COUNT(*) FROM tags");$row1 = mysql_fetch_array($res1);$count = $row1[0];
$CacheBlock->Write($_cache, $count);}else $count = $CacheBlock->Read($_cache);$perpage = 20;  
list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"] . "?" ); 
$res = sql_query("SELECT image1, id, name FROM tags ORDER BY id DESC $limit") or sqlerr(__FILE__, __LINE__);$num = mysql_num_rows($res);
$content .= $pagertop;if ($num > 0){$content .= "<table width='100%' cellspacing='0' align='center' style='background:none;border:0'>";
$nc=1;for($i = 0;$i < $num;++$i){while($row = mysql_fetch_assoc($res)){if($nc == 1){$content .= "<tr>";}
$content .= "<td align='center' style='border:0;'><br><br><center><div border=\"0\"><a href='details.php?id=$row[id]'>
<img style='border-radius:5px;border:0;height:180px;' src='torrents/images/$row[image1]' title='$row[name]'/></a></div></center></td>";
++$nc;if($nc == 5){$nc=1;$content .= "</tr>";}}}$content .= "</tr></table>";}$content .= $pagerbottom;?>