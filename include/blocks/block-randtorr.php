<?php if (!defined('BLOCK_FILE')){header("Location: ../index.php");exit;}global $tracker_lang;$blocktitle = ".:: Случайный релиз ::.";
$content = "<table width='100%' style='border:none;' cellspacing='0' cellpadding='5' valign='top' align='center'><tr>";
$res = sql_query("SELECT id, name, image1 FROM tags ORDER BY rand() DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) > 0){while($arr = mysql_fetch_assoc($res)){
$content .= "<td style='border:none;'><center><a href='details_".$arr['id']."' alt='".$arr['name']."' title='".$arr['name']."'>
<img src='./torrents/images_small/".$arr['image1']."' width='130' alt='".$arr['name']."' title='".$arr['name']."'/></a></center></td>";
}}else $content .= "<td><b>".$tracker_lang['no_torrents']."</b></td>";$content .= "</tr></table>";?>
