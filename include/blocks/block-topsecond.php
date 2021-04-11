<?php if(!defined('BLOCK_FILE')){location("../index.php");exit;}$blocktitle = "TOP 20";
$cacheStatFile = "include/cache/block-top20.txt";$expire = 40*60; // 40 минут
if(file_exists($cacheStatFile) && filesize($cacheStatFile)<>0 && filemtime($cacheStatFile) > (time() - $expire)){ 
$content.=file_get_contents($cacheStatFile);}else{
$res = sql_query("SELECT id, images_sm, name FROM torrents WHERE views >= 2 ORDER BY rand() LIMIT 20") or sqlerr(__FILE__, __LINE__);
$num = mysql_num_rows($res);
$content .= "<table border='0' cellspacing='0' cellpadding='1' width='100%'><td><marquee scrollamount='3' scrolldelay='100'>";
if($num > 0){for($i = 0; $i < $num; ++$i){while($row = mysql_fetch_assoc($res)){
$content .= "<a href='details_".$row['id']."' alt='".$row['name']."'><img src='torrents/images_smals/".$row['images_sm']."' height='70' alt='".$row['name']."' border='0'/></a>&nbsp;";
}}}$content .= "</marquee></td></table>";$fp = fopen($cacheStatFile,"w");if($fp){fputs($fp, $content);fclose($fp);}}?>