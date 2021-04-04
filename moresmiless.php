<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){$ss_uri = select_theme();?><html><head>
<script>function SmileIT(smile,form,text){window.opener.document.forms[form].elements[text].value = window.opener.document.forms[form].elements[text].value+" "+smile+" ";window.opener.document.forms[form].elements[text].focus();}
</script><title>Смайлики</title><link rel="stylesheet" href="themes/HDclub/HDClub.css" type="text/css"></head>
<table width="98%" border=1 cellspacing="2" cellpadding="2"><tr>
<?$ctr=0;global $smilies2;while((list($code, $url) = each($smilies2))){if($count % 5==0) print("<tr>");
print("<td align='center' style='background-color:none;'>
<a href=\"javascript: SmileIT('".str_replace("'","\'",$code)."','".htmlentities($_GET["form"])."','".htmlentities($_GET["text"])."')\"><img border=\"0\" src=\"pic/smilies/".$url."\"></a></td>");
$count++;if($count % 5==0) print("</tr>");}?></tr></table><div align="center"><a class="altlink_green" href="javascript:window.close()">
<? echo Закрыть;?></a></div><?}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>