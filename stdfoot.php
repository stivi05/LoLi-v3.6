<?php if (!defined('UC_SYSOP')) die("<html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");
if($CURUSER){?><?show_blocks('d');?><?show_blocks('f');?></td><td valign="top" width="155px"><?show_blocks('r');?></td></table></td></tr><tr>
<td style="width:98%;border:none;float:center;"><center><table style="color:#F4F5F9;background:none;cellspacing:0;cellpadding:0;" width="98%"><tr>
<td style="border-radius:15px;border:none;" width="98%" class="a"><div align="center"><a href="#top" style="position:fixed;bottom:0pt;right:0pt;"><font size='6'>⮉</font></a></div>
<table width="100%" style="background:none;border:0;"><tr><td width="100%" class="zaliwka" style="colspan:16;font-size:14px;text-align:center;border:0;border-radius:5px;">
<a href='#'>&#9650;&nbsp;&nbsp;UP&nbsp;&nbsp;&#9650;</a></td></tr><tr><td width="100%" style="background:none;text-align:center;color:#808080;border:0;">
<? $secondss = (timer() - $tstart);if($secondss < 0){$seconds = 0;$percentphp = 0;$percentsql = 0;}else{$seconds = $secondss;
$phptime = $seconds - $querytime;$query_time = $querytime;$percentphp = number_format(($phptime/$seconds) * 100, 2);$percentsql = number_format(($query_time/$seconds) * 100, 2);
$seconds = substr($seconds, 0, 8);}$memory = mksize(round(@memory_get_usage()));if($queries < 1){$queries = 0;}else{$queries;}
$queries_staff = (" <b>$queries</b> queries (<b>$percentphp%</b>  PHP / <b>$percentsql%</b> MySQL). Server memory wasted => $memory");
print("<b>".LoLi."<br>Page generated in <b>".$seconds."</b> seconds with ".$queries_staff."");?></td></tr></table></td></tr></table></center></td></tr></table></td></tr></body></html><?}?>