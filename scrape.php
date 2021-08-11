<? define ('IN_ANNOUNCE', true);require_once('./include/core_announce.php');dbconn(false);
$infohash = array();foreach (explode("&", $_SERVER["QUERY_STRING"]) as $item){
if(substr($item, 0, 10) == "info_hash="){$hash = substr($item, 10);$hash = urldecode($hash);$info_hash = $hash;
if(strlen($info_hash) == 20)$info_hash = bin2hex($info_hash);elseif(strlen($info_hash) != 40)continue;$infohash[] = sqlesc(strtolower($info_hash));}}
if(!$_GET["info_hash"]) die("<html><head><meta http-equiv=refresh content='0;url=/'></head></html>");
$r = "d".benc_str("files")."d";$fields = "info_hash, info_hashs, times_completed, seeders, leechers";
if(!isset($_GET["info_hash"])){$query = "SELECT $fields FROM torrents ORDER BY info_hash";}else{$hash = bin2hex($_GET["info_hash"]);
if(!$_GET["info_hash"]) die("<html><head><meta http-equiv=refresh content='0;url=/'></head></html>");
if(strlen($_GET["info_hash"]) != 20) err("Invalid info-hash (".strlen($_GET["info_hash"]).")");
$query = "SELECT $fields FROM torrents WHERE IF(info_hash = ".sqlesc($hash).", info_hash = ".sqlesc($hash).", info_hashs = ".sqlesc($hash).")";}
$res = mysql_query($query) or err(mysql_error());while($row = mysql_fetch_assoc($res)){
if($row["info_hashs"] != ''){$info_hashd = $row["info_hashs"];}else{$info_hashd = $row["info_hash"];}
$r .= "20:".pack("H*", ($info_hashd))."d".
benc_str("complete")."i".$row["seeders"]."e".
benc_str("downloaded")."i".$row["times_completed"]."e".
benc_str("incomplete")."i".$row["leechers"]."e"."e";}$r .= "ee";header("Content-Type: text/plain");header("Pragma: no-cache");print($r);?>
