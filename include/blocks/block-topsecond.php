<?php if(!defined('BLOCK_FILE')){location("../index.php");exit;}global $CacheBlock, $top20_Refresh; 
$blocktitle = ".:: TOP 20 ::.";$_cache = 'Blocks_top20.cache';if(!$CacheBlock->Check($_cache, $top20_Refresh?0:86400)){ //5 chasov
$res = sql_query("SELECT id, images_sm, name FROM torrents WHERE views >= 2 ORDER BY rand() LIMIT 20") or sqlerr(__FILE__, __LINE__);$num = mysql_num_rows($res);
$content .= "<table border='0' cellspacing='0' cellpadding='1' width='100%'><td><marquee scrollamount='3' scrolldelay='100'>";
if($num > 0){for($i = 0; $i < $num; ++$i){while($row = mysql_fetch_assoc($res)){
$content .= "<a href='details_".$row['id']."' alt='".$row['name']."'><img src='torrents/images_smals/".$row['images_sm']."' height='70' alt='".$row['name']."' border='0'/></a>&nbsp;";
}}}$content .= "</marquee></td></table>";$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>