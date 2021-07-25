<?php require_once("include/bittorrent.php");dbconn(false);gzip();if($CURUSER){
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && $_SERVER["REQUEST_METHOD"] == 'GET'){$q = trim(strip_tags(unesc(base64_decode($_GET["q"]))));
if(empty($q) || strlen($q) < 3){die();}
$res = mysql_query("SELECT zakaz.id, zakaz.cat_id, zakaz.incat_id, zakaz.name, zakaz.data, c.name AS cat_name, c.image AS cat_pic, i.name AS incat_name, 
i.image AS incat_pic FROM zakaz LEFT JOIN categories AS c ON zakaz.cat_id = c.id LEFT JOIN incategories AS i ON zakaz.incat_id = i.id 
WHERE zakaz.name COLLATE UTF8_GENERAL_CI LIKE ".sqlesc("%$q%")." ORDER BY id DESC LIMIT 0,10;") or sqlerr(__FILE__, __LINE__);
print("<div style=\"position:absolute;width:600px;\">");?>
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='b'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:25px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
Результаты быстрого поиска</td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;"><?
if(mysql_num_rows($res) < 1){
print("<table style='background:none;margin-top:7px;cellspacing:0;cellpadding:0;width:300px;float:center;'><tr>
<td style='border-radius:15px;border:none;' class='a'><table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:20px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;'>
".$tracker_lang['nothing_found']."</td></tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table>");}
else{$i = 1;while ($row = mysql_fetch_array($res)){
$cats = "<a href='?janr=".$row["cat_id"]."'><img border='0' width='60px' src='pic/cats/".$row["cat_pic"]."' alt='".$row["cat_name"]."'/></a>";
$incats = "<a href='?tip=".$row["incat_id"]."'><img border='0' width='60px' src='pic/cats/".$row["incat_pic"]."' alt='".$row["incat_name"]."'/></a>";
print("<table style='background:none;border:none;cellspacing:0;cellpadding:0;margin-top:7px;width:100%;float:center;'><tr>
<td style='border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;-khtml-border-radius:5px;border:1px solid white;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td align='center' style='background:none;width:100%;float:center;border:0;'>
<table style='background:none;cellspacing:0;cellpadding:0;margin-top:0;width:100%;float:center;'><tr>
<td style='background:none;margin-left:20px;border:0;width:60px;' align='left'>$cats</td><td style='background:none;border:0;width:60px;' align='center'>$incats</td>
<td style='background:none;border:0;width:10px;' align='center'></td><td style='background:none;border:0;' align='left'>
<a href=\"?action=zakaz&id=".$row['id']."\">".preg_replace("#($q)#siu", "<span style=\"color: #FF0000\">\\1</span>", $row['name'])."</a><hr align='left' width='300px'>
<img src='pic/icon_topic.gif' border='0'/>&nbsp;<font size=\"1\" color=\"grey\"><i>".nicetime($row["data"], true)."</i></font></td></tr></table></td></tr></table>
</td></tr></table>");$i++;}}print("</td></tr></table></td></tr></table></div>");die();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body>
</html><?}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>