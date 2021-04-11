<?php if(!defined('BLOCK_FILE')){Header("Location: ../index.php");exit;}global $CacheBlock, $exrelizBlock_Refresh; 
$blocktitle = ".:: ТОП-релизы ::.";$_cache = 'Blocks_exreliz.cache';?><link rel="stylesheet" href="css/slider2.css"/><script src="js/slider2.js"></script><?
if(!$CacheBlock->Check($_cache, $exrelizBlock_Refresh?0:864000)){ //1 den!
$content .= '<table width="100%" height="500px" style="border:0;" cellspacing="1" cellpadding="3"><tr><td align="left" style="border:0;" height="500px">
<div id="coloredPicturesPanel" height="500px"><div id="leftNav" height="500px"><div><center><h4 class="active"><font color=red>ТОП-релизы</font></h4></center><ul>';
$res = sql_query("SELECT id, image1, name, descr_html FROM torrents ORDER BY views DESC LIMIT 15") or sqlerr ( __FILE__, __LINE__ );
while($row = mysql_fetch_assoc($res)){
$content .= '<li><a href="details_'.$row['id'].'">'.$row['name'].'</a><div><h5>'.$row['name'].'</h5><p>'.$row['descr_html'].'</p>
<a href="details.php?id='.$row['id'].'" class="details icon"></a></div><img class="changeImage" src="torrents/images/'.$row['image1'].'"/></li>';}
$content .='</ul></div></div><div id="subPanel"><div class="content"></div><div id="arrow"><span></span></div></div>
<div class="image"><img src="" alt="" title="" class="bg"/><img src="" alt="" title="" class="fg"/></div></div></td></tr></table>';
$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>