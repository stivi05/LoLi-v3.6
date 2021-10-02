<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && get_user_class() >= UC_POWER_USER){
$idr = (isset($_POST["id"]) ? intval($_POST["id"]):0);function bark($msg){stderr2("Ошибка", $msg);}global $rootpath;
if (!is_valid_id($idr) || empty($idr)) stderr2("Ошибка", "<center>Темы не существует или ID указан не верно.</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
////////////////////////////////////////////////
function uploadimage($x, $imgname, $tid) {
   global $max_image_size;

   $maxfilesize = $max_image_size; // default 1mb

   $allowed_types = array(
   "image/gif" => "gif",
   "image/pjpeg" => "jpg",
   "image/jpeg" => "jpg",
   "image/jpg" => "jpg",
   "image/png" => "png"
   // Add more types here if you like
   );

   if (!($_FILES['image'.$x]['name'] == "")) {

      if ($imgname != "") {
         // Make sure is same as in takeedit.php (except for the $imgname bit)
         $img = "torrents/images/$imgname";
         $del = unlink($img);
      }

      $y = $x + 1;

      // Is valid filetype?
      if (!array_key_exists($_FILES['image'.$x]['type'], $allowed_types))
         bark("Invalid file type! Image $y (".htmlspecialchars_uni($_FILES['image'.$x]['type']).")");

      if (!preg_match('/^(.+)\.(jpg|jpeg|png|gif)$/si', $_FILES['image'.$x]['name']))
         bark("Неверное имя файла (не картинка).");

      // Is within allowed filesize?
      if ($_FILES['image'.$x]['size'] > $maxfilesize)
         bark("Превышен размер файла! Картинка $y - Должна быть меньше ".mksize($maxfilesize));

      // Where to upload?
      // Make sure is same as on takeupload.php
      $uploaddir = "torrents/images/";

      // What is the temporary file name?
      $ifile = $_FILES['image'.$x]['tmp_name'];

      // By what filename should the tracker associate the image with?
      //$ifilename = $tid . $x . substr($_FILES['image'.$x]['name'], strlen($_FILES['image'.$x]['name'])-4, 4);
      $ifilename = $tid . $x . '.' . end(explode('.', $_FILES['image'.$x]['name']));

      // Upload the file
      $copy = copy($ifile, $uploaddir.$ifilename);

      if (!$copy)
         bark("Error occured uploading image! - Image $y");

      return $ifilename;

   }

}
////////////////////////////////////////////////

function dict_check($d, $s) {
   if ($d["type"] != "dictionary")
      bark("not a dictionary");
   $a = explode(":", $s);
   $dd = $d["value"];
   $ret = array();
   foreach ($a as $k) {
      unset($t);
      if (preg_match('/^(.*)\((.*)\)$/', $k, $m)) {
         $k = $m[1];
         $t = $m[2];
      }
      if (!isset($dd[$k]))
         bark("dictionary is missing key(s)");
      if (isset($t)) {
         if ($dd[$k]["type"] != $t)
            bark("invalid entry in dictionary");
         $ret[] = $dd[$k]["value"];
      }
      else
         $ret[] = $dd[$k];
   }
   return $ret;
}

function dict_get($d, $k, $t) {
   if ($d["type"] != "dictionary")
      bark("not a dictionary");
   $dd = $d["value"];
   if (!isset($dd[$k]))
      return;
   $v = $dd[$k];
   if ($v["type"] != $t)
      bark("invalid dictionary entry type");
   return $v["value"];
}

if (!mkglobal("id:name:descr:keywords:type:tip")) bark("missing form data");mkglobal("description");$id = intval($id);if(!$id)die();
$res = sql_query("SELECT owner, filename, save_as, image1 FROM torrents WHERE id = $id");$row = mysql_fetch_array($res);if(!$row)die();
if($CURUSER["id"] != $row["owner"] && get_user_class() < UC_UPLOADER){bark("You're not the owner! How did that happen?\n");}
$updateset = array();$fname = $row["filename"];preg_match('/^(.+)\.torrent$/si', $fname, $matches);$shortfname = $matches[1];
$dname = $row["save_as"];
// picturemod
for ($x=1; $x <= 5; $x++) {
$_GLOBALS['img'.$x.'action'] = $_POST['img'.$x.'action'];
if ($_GLOBALS['img'.$x.'action'] == 'update') $updateset[] = 'image' . $x . ' = ' .sqlesc(uploadimage($x - 1, $row['image' . $x], $id));
if ($_GLOBALS['img'.$x.'action'] == 'delete') {
if ($row['image'.$x]){$del = unlink('torrents/images/' . $row['image' . $x]);$updateset[] = 'image' . $x . ' = ""';}}}
// picturemod ///////////
/////////Kinopoisk nachalo///////////
$kinopoisks = $_POST["kinopoisk"];$kinopoisk = "https://rating.kinopoisk.ru/".$kinopoisks.".gif";
if($kinopoisks != ""){@unlink($rootpath.'torrents/kinopoisk/'.$kinopoisks.'.gif');$uploaddir = "torrents/kinopoisk/";$ifile = $kinopoisk;
$files = explode('.', $kinopoisk);$ifilename = $kinopoisks.'.'.end($files);$copy = copy($ifile, $rootpath.$uploaddir.$ifilename);
if (!$copy) bark("Error occured uploading image! - Image");$updateset[] = "kinopoisk = " . sqlesc($kinopoisks);$updateset[] = "kptime = NOW()";}
/////////IMDB nachalo///////////
$imdbs = $_POST["imdb"];$imdb = "https://ratinginformer.com/".$imdbs.".png";if ($imdbs != ""){$uploaddir = "torrents/imdb/";$ifile = $imdb;
$files = explode('.', $imdb);$ifilename = $imdbs.'.'.end($files);$copy = copy($ifile, $uploaddir.$ifilename);
if (!$copy) bark("Error occured uploading image! - Image");$inames[] = $ifilename;$updateset[] = "imdb = ".sqlesc($imdbs);$updateset[] = "imdbtime = NOW()";}
//////////////////////
if (isset($_FILES["tfile"]) && !empty($_FILES["tfile"]["name"]))$update_torrent = true;
///////////////////////////////////////////////////////////////////////////////////////////////
if($update_torrent){$f = $_FILES["tfile"];$fname = unesc($f["name"]);
if(empty($fname))bark("Файл не загружен. Пустое имя файла!");
if(!validfilename($fname))bark("Неверное имя файла!");
if(!preg_match('/^(.+)\.torrent$/si', $fname, $matches))bark("Неверное имя файла (не .torrent).");
$tmpname = $f["tmp_name"];if(!is_uploaded_file($tmpname))bark("eek");if(!filesize($tmpname))bark("Пустой файл!");
$dict = bdecode(file_get_contents($tmpname));
if(!isset($dict))bark("Что за хрень ты загружаешь? Это не бинарно-кодированый файл!");$info = $dict['info'];
list($dname, $plen, $pieces, $totallen) = array($info['name'], $info['piece length'], $info['pieces'], $info['length']);
if(strlen($pieces) % 20 != 0)bark("invalid pieces");$filelist = array();
if (isset($totallen)){$filelist[] = array($dname, $totallen);}else{$flist = $info['files'];
if (!isset($flist))bark("missing both length and files");if (!count($flist))bark("no files");$totallen = 0;
foreach($flist as $fn){list($ll, $ff) = array($fn['length'], $fn['path']);$totallen += $ll;$ffa = array();
foreach ($ff as $ffe){$ffa[] = $ffe;}if(!count($ffa)) bark("filename error");$ffe = implode("/", $ffa);$filelist[] = array($ffe, $ll);
if($ffe == 'Thumbs.db'){stderr("Ошибка", "В торрентах запрещено держать файлы Thumbs.db!");die;}}}
$infohash = sha1(BEncode($dict['info']));
mysql_query('DELETE FROM torrents_scrape WHERE tid = '.sqlesc($id)) or sqlerr(__FILE__,__LINE__);
//////////////////////////////
if(!$_POST["multitracker"]){
	$dict['value']['announce'] = $announce_urls[0];  // change announce url to local
	$dict['info']['private'] = 1;  // add private tracker flag
	$dict['info']['source'] = "[$DEFAULTBASEURL] $SITENAME"; // add link for bitcomet users	
	unset($dict['announce-list']); // remove multi-tracker capability
	unset($dict['nodes']); // remove cached peers (Bitcomet & Azareus)
	unset($dict['info']['crc32']); // remove crc32
	unset($dict['info']['ed2k']); // remove ed2k
	unset($dict['info']['md5sum']); // remove md5sum
	unset($dict['info']['sha1']); // remove sha1
	unset($dict['info']['tiger']); // remove tiger
	unset($dict['azureus_properties']); // remove azureus properties
}
$dict = BDecode(BEncode($dict)); // double up on the becoding solves the occassional misgenerated infohash
$dict['value']['comment'] = bdec(benc_str("$DEFAULTBASEURL/details_$id")); //torrent comment 
$dict['created by'] = "$CURUSER[username]"; // change created by
$dict['publisher'] = "$CURUSER[username]"; // change publisher
$dict['publisher.utf-8'] = "$CURUSER[username]"; // change publisher.utf-8
$dict['publisher-url'] = "$DEFAULTBASEURL/users_$CURUSER[id]"; // change publisher-url
$dict['publisher-url.utf-8'] = "$DEFAULTBASEURL/user_$CURUSER[id]"; // change publisher-url.utf-8
////////////////////////
if($_POST["multitracker"]){if(!empty($dict['announce-list'])){$parsed_urls = array();foreach($dict['announce-list'] as $al_url){
$al_url[0] = trim($al_url[0]);if($al_url[0] == 'http://retracker.local/announce')continue;if(!preg_match('#^(udp|http)://#si', $al_url[0]))continue;
if(in_array($al_url[0], $parsed_urls))continue;$url_array = parse_url($al_url[0]);if(substr($url_array['host'], -6) == '.local')continue;$parsed_urls[] = $al_url[0];
mysql_query('REPLACE INTO torrents_scrape (tid, info_hash, url) VALUES ('.implode(', ', array_map('sqlesc', array($id, $infohash, $al_url[0]))).')') or sqlerr(__FILE__,__LINE__);}}}
//////////////////////////////////////////////
move_uploaded_file($tmpname, "torrents/$id.torrent");
$fp = fopen("torrents/$id.torrent", "w");
if($fp){$dict_str = BEncode($dict);@fwrite($fp, $dict_str, strlen($dict_str));fclose($fp);}
$updateset[] = "info_hash = " . sqlesc($infohash);
$updateset[] = "filename = " . sqlesc($fname);
$updateset[] = "size = " . sqlesc($totallen);
$updateset[] = "leechers = 0, remote_leechers = 0, seeders = 0, remote_seeders = 0, last_mt_update = ''";
$flist = $rootpath."include/flist/$id.cache";if($flist){unlink($rootpath."include/flist/$id.cache");}} // укажи свой путь к кешу списка файлов
///////////////////////////////////////////////////
$name = unesc($name);
$fulldescr = unesc($_POST["fulldescr"]);if (!$fulldescr)bark("Вы должны ввести короткое описание!");
$descr = unesc($_POST["descr"]);if(!$descr)bark("Вы должны ввести описание!");
$keywords = unesc($keywords);
$description = unesc($description);
$updateset[] = "keywords = " . sqlesc($keywords);
$updateset[] = "description = " . sqlesc($description);
$updateset[] = "name = " . sqlesc($name);
$updateset[] = "fulldescr = " . sqlesc($fulldescr);
$updateset[] = "descr = " . sqlesc($descr);
$updateset[] = "ori_descr = " . sqlesc($descr);
sql_query('REPLACE INTO torrents_descr (tid, descr_hash, descr_parsed) VALUES ('.implode(', ', array_map('sqlesc', array($id, md5($descr), format_comment($descr)))).')') or sqlerr(__FILE__,__LINE__);
$updateset[] = "category = " . (intval($type));
$updateset[] = "incategory = " . (intval($tip));

if (get_user_class() >= UC_ADMINISTRATOR) {
   if ($_POST["banned"]) {
      $updateset[] = "banned = 'yes'";
      $_POST["visible"] = 0;
   } else
      $updateset[] = "banned = 'no'";
$updateset[] = "not_sticky = '" . ($_POST["not_sticky"] ? "no" : "yes") . "'";
$Blrecom_cache = $rootpath."include/cache/Block_recomend.cache";if(file_exists($Blrecom_cache)){unlink($Blrecom_cache);}}
$updateset[] = "multitracker = '" . ($_POST["multitracker"] ? "yes" : "no") . "'";
//////////
$updateset[] = "updatess = '".($_POST["uplist"] ? "yes" : "no")."'";	
/////////////
if($_POST['uplist']) $updateset[] = "added=NOW()";
if(get_user_class() >= UC_UPLOADER && in_array($_POST['free'], array('bril', 'yes', 'silver', 'no'))){
$updateset[] = "free = " . sqlesc($_POST['free']); }
$updateset[] = "visible = '" . ($_POST["visible"] ? "yes" : "no") . "'";
$updateset[] = "moderated = 'yes'";
$updateset[] = "moderatedby = ".sqlesc($CURUSER["id"]);
@unlink('include/cache/flist'.intval($id).'.cache');
////////// owner //////////////
if ($_POST['System'] == 'yes'){$updateset[] = "owner = '2'";}
///////////////////////////////////
sql_query("UPDATE torrents SET " . join(", ", $updateset) . " WHERE id = $id") or sqlerr(__FILE__,__LINE__);
write_log("Торрент $name был отредактирован пользователем ".iconv('cp1251', 'UTF-8', $CURUSER["username"]), "F25B61", "torrent");
$returl = "details.php?id=$id";if (isset($_POST["returnto"])) $returl .= "&returnto=".urlencode($_POST["returnto"]);
header("Refresh: 0; url=$returl");}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>