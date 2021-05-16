<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
stdhead($tracker_lang['upload_torrent']);
if(strlen($CURUSER['passkey']) != 32){$CURUSER['passkey'] = md5($CURUSER['username'].get_date_time().$CURUSER['passhash']);
sql_query("UPDATE users SET passkey='$CURUSER[passkey]' WHERE id=$CURUSER[id]");}
$type = "<select name=\"type\" id=\"type\"><option value='0'>select Genre</option>";$cats = get_list('categories');
foreach ($cats as $row){$i ++;$type .= "<option value='".$row["id"]."'>".htmlspecialchars_uni($row["name"])."</option>";}$type .= "</select>";?>
<script>var src_count=2,src_max_count=3;function add_filed(){var t;src_count<=src_max_count?(t='<input type="text" name="screen'+src_count+'" id="screen'+src_count+'" size="70" /><br />',$("#src_place").append(t),src_count++):(alert("Максимальное количество скриншотов - "+src_max_count),$("#add_screen").fadeOut("fast"))}$(document).ready(function(){$("#type").change(function(){var t=parseInt($(this).val());$("#upload_div").empty(),$("#upload_div").html("Loading..."),$.post("shablons_new.php",{id:t},function(t){$("#upload_div").empty(),$("#upload_div").html(t)},"html")})});
</script><?begin_frame(".:: ".$tracker_lang['upload_torrent']." ::.", "100", true);
echo "<p align=\"center\"><span style=\"color:green;font-weight:bold;\">После загрузки торрента, вам нужно будет скачать торрент и поставить качаться
в папку где лежат оригиналы файлов.</span></font></p>\n";
echo "<fieldset><legend style=\"padding:5px;border:1px solid #ccc; background:#f6f6f6;\">Выберите категорию</legend>
<div>{$type}</div></fieldset><br /><div id=\"upload_div\"></div>";end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>