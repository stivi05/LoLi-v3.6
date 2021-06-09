<?php if (!defined('UC_SYSOP')) die("Direct access denied.<html><head><meta http-equiv='refresh' content='0;url=/'></head><body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");
function begin_main_frame(){print("<table class='main' width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td class='embedded'>");}
function end_main_frame(){print("</td></tr></table>");}
function begin_table(){print("<table class='main' width='100%' border='0' cellspacing='0' cellpadding='0'>");}
function end_table(){print("</table>");}
function begin_frame($caption = "", $center = false, $padding = 10){?><table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:30px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
<?=$caption?></td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;"><?}
function attach_frame($padding = 10){print("</td></tr><tr><td style='border-top:0px;'>");}
function end_frame(){?></td></tr></table></td></tr></table><br><?}
function blok_menu($title, $content, $width="155"){global $ss_uri;$thefile = addslashes(file_get_contents('themes/'.$ss_uri.'/html/block-left.html'));
$thefile = "\$r_file='".$thefile."';";eval($thefile);echo $r_file;}?>