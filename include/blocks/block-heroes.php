<?php if(!defined('BLOCK_FILE')){Header("Location: ../index.php");exit;}
global $CacheBlock, $heroesBlock_Refresh;$blocktitle = ".:: Наши герои ::.";$_cache = 'Blocks_heroes.cache';
if(!$CacheBlock->Check($_cache, $heroesBlock_Refresh?0:86400)){ // 1 den
$content .= "<table style='background:none;width:100%;float:center;border:0;'><tr><td width='5px' align='center' valign='top' style='background:none;border:none;'></td>
<td width='24%' align='center' valign='top' style='background:none;border:none;'><table style='margin-top:3px;background:none;width:100%;float:center;border:0;'>
<tr><td class='zaliwka' colspan='3' style='color:#FFFFFF;height:15px;font-weight:bold;text-align:center;border:0;border-radius:5px;'>Бонусы</td></tr>";
$bonus = sql_query("SELECT bonus, id, class, username FROM users WHERE bonus > 1000 ORDER BY bonus DESC LIMIT 5") or sqlerr(__FILE__, __LINE__);
while($bonus2 = mysql_fetch_array($bonus)){$id = $bonus2["id"];$bonus3 = $bonus2["bonus"];
$content .= "<tr><td style='margin-top:3px;border-radius:8px;font-family:Georgia;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='b'>
&nbsp;&nbsp;<a href='userdetails.php?id=$id'>".get_user_class_color($bonus2["class"], $bonus2["username"])."</a></td>
<td width='3px' align='center' valign='top' style='background:none;border:none;'></td>
<td style='margin-top:3px;border-radius:8px;font-family:monospace;-webkit-border-radius:8px;font-size:10px;font-weight:bold;text-align:center;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='b'>
$bonus3</td></tr>";}
$content .= "</table></td><td width='5px' align='center' valign='top' style='background:none;border:none;'></td>
<td width='24%' align='center' valign='top' style='background:none;border:none;'><table style='margin-top:3px;background:none;width:100%;float:center;border:0;'>
<tr><td class='zaliwka' colspan='3' style='color:#FFFFFF;height:15px;font-weight:bold;text-align:center;border:0;border-radius:5px;'>Спасибо Юзеру</td></tr>";
$sym = sql_query("SELECT simpaty, id, class, username FROM users WHERE simpaty >= 1 ORDER BY simpaty DESC LIMIT 5") or sqlerr(__FILE__, __LINE__);
while ($sym2 = mysql_fetch_array($sym)){$id = $sym2["id"];$sym3 = $sym2["simpaty"];
$content .= "<tr>
<td style='margin-top:3px;border-radius:8px;font-family:Georgia;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='b'>
&nbsp;&nbsp;<a href='userdetails.php?id=$id'>".get_user_class_color($sym2["class"], $sym2["username"])."</a></td>
<td width='3px' align='center' valign='top' style='background:none;border:none;'></td>
<td style='margin-top:3px;border-radius:8px;font-family:monospace;-webkit-border-radius:8px;font-size:10px;font-weight:bold;text-align:center;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='b'>
$sym3</td></tr>";}
$content .= "</table></td><td width='5px' align='center' valign='top' style='background:none;border:none;'></td>
<td width='24%' align='center' valign='top' style='background:none;border:none;'><table style='margin-top:3px;background:none;width:100%;float:center;border:0;'>
<tr><td class='zaliwka' colspan='3' style='color:#FFFFFF;height:15px;font-weight:bold;text-align:center;border:0;border-radius:5px;'>Комментарии в Релизах</td></tr>";
$comm = sql_query("SELECT comreliz, id, class, username FROM users WHERE comreliz > 1 ORDER BY comreliz DESC LIMIT 5") or sqlerr(__FILE__, __LINE__);
while ($comm2 = mysql_fetch_array($comm)){$id = $comm2["id"];$comm3 = $comm2["comreliz"];
$content .= "<tr>
<td style='margin-top:3px;border-radius:8px;font-family:Georgia;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='b'>
&nbsp;&nbsp;<a href='userdetails.php?id=$id'>".get_user_class_color($comm2["class"], $comm2["username"])."</a></td>
<td width='3px' align='center' valign='top' style='background:none;border:none;'></td>
<td style='margin-top:3px;border-radius:8px;font-family:monospace;-webkit-border-radius:8px;font-size:10px;font-weight:bold;text-align:center;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='b'>
$comm3</td></tr>";}
$content .= "</table></td><td width='5px' align='center' valign='top' style='background:none;border:none;'></td>
<td width='24%' align='center' valign='top' style='background:none;border:none;'><table style='margin-top:3px;background:none;width:100%;float:center;border:0;'>
<tr><td class='zaliwka' colspan='3' style='color:#FFFFFF;height:15px;font-weight:bold;text-align:center;border:0;border-radius:5px;'>Релизов</td></tr>";
$reliz = sql_query("SELECT relizs, id, class, username FROM users WHERE relizs > 1 ORDER BY relizs DESC LIMIT 5") or sqlerr(__FILE__, __LINE__);
while ($relizs = mysql_fetch_array($reliz)){$id = $relizs["id"];$relizsz = $relizs["relizs"];
$content .= "<tr>
<td style='margin-top:3px;border-radius:8px;font-family:Georgia;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='b'>
&nbsp;&nbsp;<a href='userdetails.php?id=$id'>".get_user_class_color($relizs["class"], $relizs["username"])."</a></td>
<td width='3px' align='center' valign='top' style='background:none;border:none;'></td>
<td style='margin-top:3px;border-radius:8px;font-family:monospace;-webkit-border-radius:8px;font-size:10px;font-weight:bold;text-align:center;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='b'>
$relizsz</td></tr>";}
$content .= "</table></td><td width='5px' align='center' valign='top' style='background:none;border:none;'></td></tr></table>";
$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>
