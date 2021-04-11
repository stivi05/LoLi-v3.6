<?php if (!defined('BLOCK_FILE')){Header("Location: ../index.php");exit;}global $tracker_lang, $CacheBlock, $rootpath; 
$blocktitle = ".:: ".$tracker_lang['news']." ::.".(get_user_class() >= UC_ADMINISTRATOR ? "<font class='small'> - [<a class='altlink' href='news.php'>
<b>".$tracker_lang['create']."</b></a>]</font>" : "");
$_cache = 'Blocks_news.cache';if(!file_exists($rootpath."include/cache/Blocks_news.cache")){
$resource = sql_query("SELECT * FROM news ORDER BY added DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
$content .= "<script src='js/show_hide.js'></script>";if(mysql_num_rows($resource)){
$content .= "<table width='100%' style='background:none;border:0;width:100%;float:center;' cellspacing='0' cellpadding='10'><tr>
<td style='background:none;border:0;width:100%;float:center;' class='text'><ul>";while($array = mysql_fetch_array($resource)){if($news_flag == 0){
$content .="<span style='cursor: pointer;' onclick=\"javascript:show_hide('s".$array["id"]."')\"><img border='0' src='pic/minus.gif' id='pics".$array["id"]."' title='Скрыть'></span>&nbsp;<span style='cursor:pointer;' onclick=\"javascript:show_hide('s".$array["id"]."')\">".date("d.m.Y",strtotime($array['added']))." - <b>".htmlspecialchars($array['subject'])."</b></span><span id='ss".$array["id"]."' style=\"display: block;\">".format_comment($array['body'])."</span><hr>";
$news_flag = 1;}else{
$content .="<span style='cursor:pointer;' onclick=\"javascript: show_hide('s".$array["id"]."')\"><img border='0' src='pic/plus.gif' id='pics".$array["id"]."' title='Показать'></span>&nbsp;<span style='cursor:pointer;' onclick=\"javascript:show_hide('s".$array["id"]."')\">".date("d.m.Y",strtotime($array['added']))." - <b>".htmlspecialchars($array['subject'])."</b></span><span id='ss".$array["id"]."' style='display:none;'>".format_comment($array['body'])."</span><hr>";
}}$content .= "</ul></td></tr></table>";}else{$content .= "<table class='main' style='background:none;border:0;width:100%;float:center;' cellspacing='0' cellpadding='10'><tr>
<td style='background:none;border:0;width:100%;float:center;' class='text'><div align='center'><h3>".$tracker_lang['no_news']."</h3></div></td></tr></table>";}
$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>