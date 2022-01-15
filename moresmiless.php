<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){?><html><head>
<script>function SmileIT(smile,form,text){window.opener.document.forms[form].elements[text].value = window.opener.document.forms[form].elements[text].value+" "+smile+" ";window.opener.document.forms[form].elements[text].focus();}
</script><title>Смайлики</title><link rel="stylesheet" href="themes/<?=$CURUSER['theme'];?>/<?=$CURUSER['theme'];?>.css"/></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body>
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:30px;font-family:Tahoma,Geneva,sans-serif;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
Смайлики&nbsp;<b style='color:#FFFFFF;'>•</b>&nbsp;<a style="color:#FFFFFF;" href="javascript:window.close()"><? echo Закрыть;?></a></td></tr><tr>
<td align="center" style="background:none;width:100%;float:center;border:0;"><table width='98%' border='1' cellspacing='2' cellpadding='2'>
<?$ctr=0;global $smilies2;while((list($code, $url) = each($smilies2))){if($count % 5==0) print("<tr>");print("<td align='center' style='background:white'>
<a href=\"javascript: SmileIT('".str_replace("'","\'",$code)."','".htmlentities($_GET["form"])."','".htmlentities($_GET["text"])."')\"><img border='0' src='pic/smilies/".$url."'></a></td>");
$count++;if($count % 5==0) print("</tr>");}?></table></td></tr></table></td></tr></table></body></html><?}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>