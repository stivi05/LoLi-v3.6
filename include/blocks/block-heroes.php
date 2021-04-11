<?php if(!defined('BLOCK_FILE')){Header("Location: ../index.php");exit;}
global $CacheBlock, $heroesBlock_Refresh;$blocktitle = ".:: Наши герои ::.";$_cache = 'Blocks_heroes.cache'; 
if(!$CacheBlock->Check($_cache, $heroesBlock_Refresh?0:86400)){ //20 chasov
$content .= "<table width='100%' border='0' cellspacing='0' cellpadding='2'><td align='center' class='embedded'><table class='main' border='1' cellspacing='0' 
cellpadding='10' padding-bottom='0'><table width='100%' border='0' cellspacing='0' cellpadding='5'><tr><td width='33%' align='center' style='border:none;' valign='top'><table class='main' border='1' cellspacing='0' cellpadding='5'><tr><td class='zaliwka' colspan='3' align='center'>Бонусы</td></tr><tr><td align='center'>№</td><td align='left'>Пользователь</td><td align='center'>Кол-во</td></tr>";
$bonus = sql_query("SELECT bonus, id, class, username FROM users WHERE bonus > 1 ORDER BY bonus DESC LIMIT 5") or sqlerr(__FILE__, __LINE__);
$num = 0;while($bonus2 = mysql_fetch_array($bonus)){++$num;$id = $bonus2["id"];$bonus3 = $bonus2["bonus"];
$content .= "<tr><td>$num.</td><td class='row3' width='100%'><a href='user_$id'>".get_user_class_color($bonus2["class"], $bonus2["username"])."</a></td><td align='center' class='row3'>$bonus3</td></tr>";}
$content .= "</table></td><td width='33%' align='center' valign='top' style='border:none;'><table class='main' border='1' cellspacing='0' cellpadding='5'>
<tr><td class='zaliwka' colspan='3' align='center'>Спасибо Юзеру</td></tr><tr><td align='center'>№</td><td align='left'>Пользователь</td><td align='center'>Кол-во</td></tr>";
$sym = sql_query("SELECT simpaty, id, class, username FROM users WHERE simpaty >= 1 ORDER BY simpaty DESC LIMIT 5") or sqlerr(__FILE__, __LINE__);
$num = 0;while ($sym2 = mysql_fetch_array($sym)){++$num;$id = $sym2["id"];$sym3 = $sym2["simpaty"];
$content .= "<tr><td>$num.</td><td class='row3' width='100%'><a href='user_$id'>".get_user_class_color($sym2["class"], $sym2["username"])."</a></td><td align='center' class='row3'>$sym3</td></tr>";}
$content .= "</table></td><td width='33%' align='center' valign='top' style='border:none;'><table class='main' border='1' cellspacing='0' cellpadding='5'><tr><td class='zaliwka' colspan='3' align='center'>Комментарии</td></tr><tr><td align='center'>№</td><td align='left'>Пользователь</td><td align='center'>Кол-во</td></tr>";
$comm = sql_query("SELECT id, class, username, (SELECT COUNT(*) FROM comments WHERE users.id = comments.user) AS num_comm FROM users ORDER BY num_comm DESC LIMIT 5") or sqlerr(__FILE__, __LINE__);
$num = 0;while ($comm2 = mysql_fetch_array($comm)){++$num;$id = $comm2["id"];$comm3 = $comm2["num_comm"];if($comm3 >= 1)
$content .= "<tr><td>$num.</td><td class='row3' width='100%'><a href='user_$id'>".get_user_class_color($comm2["class"], $comm2["username"])."</a></td><td align='center' class='row3'>$comm3</td></tr>";}
$content .= "</table></td></table></td></tr></table>";$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>