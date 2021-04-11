<?php if(!defined('BLOCK_FILE')){Header("Location: ../");exit;}global $CacheBlock, $rootpath;$_cache = 'Block_recomend.cache';$blocktitle = ".:: Рекомендуемые Релизы ::.";
$Blrecom_cache = $rootpath."include/cache/Block_recomend.cache";if(!file_exists($Blrecom_cache)){
$res = sql_query("SELECT id, image1, name FROM torrents WHERE not_sticky = 'no' ORDER BY id LIMIT 12") or sqlerr(__FILE__, __LINE__);$num = mysql_num_rows($res);
$content .= "<table style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;border:none;'>
<td style='background:none;width:100%;float:center;border:none;'><center>";
if($num > 0){for($i = 0; $i < $num; ++$i){while($row = mysql_fetch_assoc($res)){
$content .= "<a href='details_".$row['id']."' alt='".$row['name']."'><img src='torrents/images/".$row['image1']."' height='90px' alt='".$row['name']."' border='none'/></a>&nbsp;";}}}
$content .= "</center></td></table>";$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>