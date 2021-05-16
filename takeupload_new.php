<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){require_once("include/benc.php");global $rootpath;
function bark($msg){genbark($msg, $tracker_lang['error']);}

foreach(explode(":","type:name") as $v) {
	if (!isset($_POST[$v]))
		bark("missing form data");
}

if (!isset($_FILES["tfile"]))
	bark("missing form data");

$f = $_FILES["tfile"];
$fname = unesc($f["name"]);
if(empty($fname))
	bark( 'Файл не загружен. Пустое имя файла!' );

$descr = unesc($_POST["descr"]);

$catid = ( is_numeric($_POST['type']) ? intval( $_POST['type'] ) : 0 );

if(!$catid || $catid <= 0)
	bark( 'Вы должны выбрать категорию, в которую поместить торрент!' );
	
if (!validfilename($fname))
	bark( 'Неверное имя torrent файла!' );
if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches))
	bark( 'Неверное имя файла (не .torrent).' );
$shortfname = $torrent = $matches[1];
if(!empty($_POST['name']))
	$torrent = unesc($_POST['name']);

$tmpname = $f['tmp_name'];
if (!is_uploaded_file($tmpname))
	bark( '.torrent file doesn\'t be uploaded' );
if (!filesize($tmpname))
	bark( 'Пустой файл!' );

$dict = bdec_file($tmpname, $max_torrent_size);
if (!isset($dict))
	bark( 'Так не пойдет!' );

if($_POST['free'] == 'yes' AND get_user_class() >= UC_ADMINISTRATOR) {
	$free = 'yes';
} else {
	$free = 'no';
};

if ($_POST['sticky'] == 'yes' AND get_user_class() >= UC_ADMINISTRATOR)
    $sticky = 'yes';
else
    $sticky = 'no';

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

list($info) = dict_check($dict, "info");
list($dname, $plen, $pieces) = dict_check($info, "name(string):piece length(integer):pieces(string)");

if (strlen($pieces) % 20 != 0)
	bark("invalid pieces");

$filelist = array();
$totallen = dict_get($info, "length", "integer");
if (isset($totallen)) {
	$filelist[] = array($dname, $totallen);
	$type = "single";
} else {
	$flist = dict_get($info, "files", "list");
	if (!isset($flist))
		bark("missing both length and files");
	if (!count($flist))
		bark("no files");
	$totallen = 0;
	foreach ($flist as $fn) {
		list($ll, $ff) = dict_check($fn, "length(integer):path(list)");
		$totallen += $ll;
		$ffa = array();
		foreach ($ff as $ffe) {
			if ($ffe["type"] != "string")
				bark("filename error");
			$ffa[] = $ffe["value"];
		}
		if (!count($ffa))
			bark("filename error");
		$ffe = implode("/", $ffa);
		$filelist[] = array($ffe, $ll);
	if ($ffe == 'Thumbs.db')
        {
            stderr("Ошибка", "В торрентах запрещено держать файлы Thumbs.db!");
            die;
        }
	}
	$type = "multi";
}

$dict['value']['announce']=bdec(benc_str($announce_urls[0]));  // change announce url to local
$dict['value']['info']['value']['private']=bdec('i1e');  // add private tracker flag
$dict['value']['info']['value']['source']=bdec(benc_str( "[$DEFAULTBASEURL] $SITENAME")); // add link for bitcomet users
unset($dict['value']['announce-list']); // remove multi-tracker capability
unset($dict['value']['nodes']); // remove cached peers (Bitcomet & Azareus)
unset($dict['value']['info']['value']['crc32']); // remove crc32
unset($dict['value']['info']['value']['ed2k']); // remove ed2k
unset($dict['value']['info']['value']['md5sum']); // remove md5sum
unset($dict['value']['info']['value']['sha1']); // remove sha1
unset($dict['value']['info']['value']['tiger']); // remove tiger
unset($dict['value']['azureus_properties']); // remove azureus properties
$dict=bdec(benc($dict)); // double up on the becoding solves the occassional misgenerated infohash
$dict['value']['comment']=bdec(benc_str( "Торрент создан для '$SITENAME'")); // change torrent comment
$dict['value']['created by']=bdec(benc_str( "$CURUSER[username]")); // change created by
$dict['value']['publisher']=bdec(benc_str( "$CURUSER[username]")); // change publisher
$dict['value']['publisher.utf-8']=bdec(benc_str( "$CURUSER[username]")); // change publisher.utf-8
$dict['value']['publisher-url']=bdec(benc_str( "$DEFAULTBASEURL/userdetails.php?id=$CURUSER[id]")); // change publisher-url
$dict['value']['publisher-url.utf-8']=bdec(benc_str( "$DEFAULTBASEURL/userdetails.php?id=$CURUSER[id]")); // change publisher-url.utf-8
list($info) = dict_check($dict, "info");

$infohash = sha1($info["string"]);

//////////////////////////////////////////////
//////////////Take Image Uploads//////////////
$maxfilesize = $max_image_size; // default 1mb
$allowed_types = array(
"image/gif" => "gif",
"image/pjpeg" => "jpg",
"image/jpeg" => "jpg",
"image/jpg" => "jpg",
"image/png" => "png");
for ($x=0; $x < 2; $x++){
if (!($_FILES['image'.$x]['name'] == "")){
$ret = mysql_query("SHOW TABLE STATUS LIKE 'torrents'");$row = mysql_fetch_array($ret);$next_id = $row['Auto_increment'];
$y = $x + 1;if(!array_key_exists($_FILES['image'.$x]['type'], $allowed_types)) 
bark("Invalid file type! Image $y (".htmlspecialchars_uni($_FILES['image'.$x]['type']).")");
if (!preg_match('/^(.+)\.(jpg|jpeg|png|gif)$/si', $_FILES['image'.$x]['name']))
bark("Неверное имя файла (не картинка).");
if ($_FILES['image'.$x]['size'] > $maxfilesize)
bark("Превышен размер файла! Картинка $y - Должна быть меньше ".mksize($maxfilesize));
$uploaddir = "torrents/images/";
$ifile = $_FILES['image'.$x]['tmp_name'];
$files = explode('.', $_FILES[ 'image' . $x ]['name']);
$ifilename = $next_id.'.'. end($files);
$copy = copy($ifile, $rootpath.$uploaddir.$ifilename);
////////////////
if (!$copy) bark("Error occured uploading image! - Image $y");
$inames[] = $ifilename;}}
//////////////////////////////////////////////

// Replace punctuation characters with spaces

$torrent = htmlspecialchars_uni(str_replace("_", " ", $torrent));


/*
// ====================================================================
//
// [BEGIN] Шаблоны раздач by Strong v0.1
//
// ====================================================================
*/

# Get category
$shab_category = unesc($_POST['shab_category']);

switch($shab_category) {
	case 'video' :
	  # Define variables
	  $iYear = ( is_numeric($_REQUEST['year']) ? intval($_REQUEST['year']) :  0 );
	  $sCountry = ( isset($_REQUEST['country']) ? strval(htmlspecialchars_uni($_REQUEST['country'])) : '' );
	  $sGenre = ( isset($_REQUEST['genre']) ? htmlspecialchars_uni($_REQUEST['genre']) : '' );
	  $sTime = ( isset($_REQUEST['time']) ? htmlspecialchars_uni($_REQUEST['time']) : '' );
	  $sTranslate = ( isset($_REQUEST['translate']) ? htmlspecialchars_uni($_REQUEST['translate']) : '' );
	  $sSubtitles = ( isset($_REQUEST['subtitles']) ? htmlspecialchars_uni($_REQUEST['subtitles']) : '' );
	  $sDirector = ( isset($_REQUEST['director']) ? htmlspecialchars_uni($_REQUEST['director']) : '' );
	  $sRoles = ( isset($_REQUEST['roles']) ? htmlspecialchars_uni($_REQUEST['roles']) : '' );
	  $sQuality = ( isset($_REQUEST['quality']) ? htmlspecialchars_uni($_REQUEST['quality']) : '' );
	  $sFormat = ( isset($_REQUEST['format']) ? htmlspecialchars_uni($_REQUEST['format']) : '' );
	  $sVideoInfo = ( isset($_REQUEST['video_info']) ? htmlspecialchars_uni($_REQUEST['video_info']) : '' );
	  $sAudioInfo = ( isset($_REQUEST['audio_info']) ? htmlspecialchars_uni($_REQUEST['audio_info']) : '' );
	  $sSample = ( isset($_REQUEST['sample']) ? htmlspecialchars_uni($_REQUEST['sample']) : '' );
	  
	  # Compile template
	  
	  $tpl .= ( $iYear != 0 ? "[b]Год выпуска:[/b] {$iYear}\n" : "" );
	  $tpl .= ( !empty($sCountry) ? "[b]Страна:[/b] {$sCountry}\n" : "" );
	  $tpl .= ( !empty($sGenre) ? "[b]Жанр:[/b] {$sGenre}\n" : "" );
	  $tpl .= ( !empty($sTime) ? "[b]Продолжительность:[/b] {$sTime}\n" : "" );
	  $tpl .= ( !empty($sTranslate) ? "[b]Перевод:[/b] {$sTranslate}\n" : "" );
	  $tpl .= ( !empty($sSubtitles) ? "[b]Субтитры:[/b] {$sSubtitles}\n" : "" );
	  $tpl .= ( !empty($sDirector) ? "\n[b]Режиссер:[/b] {$sDirector}\n" : "" );
	  $tpl .= ( !empty($sRoles) ? "\n[b]В ролях:[/b] {$sRoles}\n\n" : "" );
	  $tpl .= ( !empty($sQuality) ? "[b]Качество:[/b] {$sQuality}\n" : "" );
	  $tpl .= ( !empty($sFormat) ? "[b]Формат:[/b] {$sFormat}\n" : "" );
	  $tpl .= ( !empty($sVideoInfo) ? "[b]Видео:[/b] {$sVideoInfo}\n" : "" );
	  $tpl .= ( !empty($sAudioInfo) ? "[b]Аудио:[/b] {$sAudioInfo}\n" : "" );
	  $tpl .= ( !empty($sSample) ? "[b]Сэмпл:[/b] [url={$sSample}]{$sSample}[/url]\n" : "" );
	  
	
	break;
	case 'audio' :
	  # define variables
	  
	  $sGenre = unesc($_POST['genre']);
	  $iYear = unesc($_POST['year']);
	  $sCodec = unesc($_POST['codec']);
	  $sKbps = unesc($_POST['kbps']);
	  $sTime = unesc($_POST['time']);
	  $sTracklist = unesc($_POST['track_list']);
	  
	  # compile template
	  $tpl .= ( $iYear != 0 ? "[b]Год:[/b] {$iYear}\n" : "" );
	  $tpl .= ( !empty($sGenre) ? "[b]Жанр:[/b] {$sGenre}\n" : "" );
	  $tpl .= ( !empty($sTime) ? "[b]Продолжительность:[/b] {$sTime}\n" : "" );
	  $tpl .= ( !empty($sTracklist) ? "\n\n[spoiler=Tracklist]{$sTracklist}[/spoiler]\n" : "" );
	  $tpl .= ( !empty($sCodec) ? "[b]Кодек:[/b] {$sCodec}\n" : "" );
	  $tpl .= ( !empty($sKbps) ? "[b]Битрейт:[/b] {$sKbps}\n" : "" );	  

	break;
	case 'games' :
	  # define variables
	  $iYear = ( is_numeric($_REQUEST['year']) ? intval($_REQUEST['year']) : 0 );
	  $sPlatform = ( isset($_REQUEST['platform']) ? htmlspecialchars_uni($_REQUEST['platform']) : '');
	  $sGenre = ( isset($_REQUEST['genre']) ? htmlspecialchars_uni($_REQUEST['gener']) : '' );
	  $sDeveloper = ( isset($_REQUEST['developer']) ? htmlspecialchars_uni($_REQUEST['developer']) : '' );
	  $sPublisher = ( isset($_REQUEST['publisher']) ? htmlspecialchars_uni($_REQUEST['publisher']) : '' );
	  $sPub_type = ( isset($_REQUEST['pub_type']) ? htmlspecialchars_uni($_REQUEST['pub_type']) : '' );
	  $sLanguage = ( isset($_REQUEST['language']) ? htmlspecialchars_uni($_REQUEST['language']) : '' );
	  $sCrack = ( isset($_REQUEST['crack']) ? htmlspecialchars_uni($_REQUEST['crack']) : '' );
	  $sRequirements = ( isset($_REQUEST['requirements']) ? htmlspecialchars_uni($_REQUEST['requirements']) : '' );
	  
	  $tpl .= ( $iYear != 0 ? "[b]Год выпуска:[/b] {$iYear}\n" : "" );
	  $tpl .= ( !empty($sPlatform) ? "[b]Платформа:[/b] {$sPlatform}\n" : "" );
	  $tpl .= ( !empty($sGenre) ? "[b]Жанр:[/b] {$sGenre}\n" : "" );
	  $tpl .= ( !empty($sDeveloper) ? "[b]Разработчик:[/b] {$sDeveloper}\n" : "" );
	  $tpl .= ( !empty($sPublisher) ? "[b]Издательство:[/b] {$sPublisher}\n" : "" );
	  $tpl .= ( !empty($sPub_type) ? "[b]Тип издания:[/b] {$sPub_type}\n" : "" );
	  $tpl .= ( !empty($sLanguage) ? "[b]Язык интерфейса:[/b] {$sLanguage}\n" : "" );
	  $tpl .= ( !empty($sCrack) ? "[b]Crack:[/b] {$sCrack}\n" : "" );
	  $tpl .= ( !empty($sRequirements) ? "\n[b]Системные требования:[/b] {$sRequirements}\n" : "" );
	  
	break;
	case 'books' :
      # define variables
	  $iYear = ( is_numeric($_REQUEST['year']) ? intval($_REQUEST['year']) : 0 );
	  $sAuthor = ( isset($_REQUEST['author']) ? htmlspecialchars_uni($_REQUEST['author']) : '' );
	  $sGenre ( isset($_REQUEST['genre']) ? htmlspecialchars_uni($_REQUEST['genre']) : '' );
	  $sPublisher = ( isset($_REQUEST['publisher']) ? htmlspecialchars_uni($_REQUEST['publisher']) : '' );
	  $sFormat = ( isset($_REQUEST['format']) ? htmlspecialchars_uni($_REQUEST['format']) : '' );
	  $sQuality = ( isset($_REQUEST['quality']) ? htmlspecialchars_uni($_REQUEST['quality']) : '' );
	  $iPages = ( is_numeric($_REQUEST['pages']) ? intval($_REQUEST['pages']) : 0 );
	  
	  # compile template
	  
	  $tpl .= ( $iYear != 0 ? "[b]Год выпуска:[/b] {$iYear}\n" : "" );
	  $tpl .= ( !empty($sAuthor) ? "[b]Автор:[/b] {$sAuthor}\n" : "" );
	  $tpl .= ( !empty($sGenre) ? "[b]Жанр:[/b] {$sGenre}\n" : "" );
	  $tpl .= ( !empty($sPublisher) ? "[b]Издательство:[/b] {$sPublisher}\n" : "" );
	  $tpl .= ( !empty($sFormat) ? "[b]Формат:[/b] {$sFormat}\n" : "" );
	  $tpl .= ( !empty($sQuality) ? "[b]Качество:[/b] {$sQuality}\n" : "" );
	  $tpl .= ( $iPages != 0 ? "[b]Количество страниц:[/b] {$iPages}\n" : "" );
	
	break;
}$tpls = $tpl;

# Screenshotes
$src .= "\n\n[spoiler=Скриншоты к раздаче \"{$torrent}\"]";
$src .= ( !empty($_POST['screen1']) ? "[img]".htmlspecialchars_uni($_POST['screen1'])."[/img]\n" : "" );
$src .= ( !empty($_POST['screen2']) ? "[img]".htmlspecialchars_uni($_POST['screen2'])."[/img]\n" : "" );
$src .= ( !empty($_POST['screen3']) ? "[img]".htmlspecialchars_uni($_POST['screen3'])."[/img]\n" : "" );									
$src .= "[/spoiler]\n";

if(empty($_POST['screen1']) && empty($_POST['screen2']) && empty($_POST['screen3']))
  $src='';
if(!empty($descr)){$descr = "\n[b]Описание:[/b] {$descr}\n";}
# полностью собранное описание
$sTotalDescr = $tpls.$descr.$src;

/*
// ====================================================================
//
// [END] Шаблоны раздач by Strong v0.1
//
// ====================================================================
*/

$ret = sql_query("INSERT INTO torrents (filename, owner, visible, not_sticky, info_hash, name, size, fulldescr, free, 
image1, category, added, last_action) VALUES (" . implode(",", array_map("sqlesc", array($fname, $CURUSER["id"], "no", $sticky, $infohash, 
$torrent, $totallen, $sTotalDescr, $free, $inames[0], intval($_POST["type"])))) . ", '" . get_date_time() . "', '" . get_date_time() . "')");
if (!$ret) {
	if (mysql_errno() == 1062)
		bark("torrent already uploaded!");
	bark("mysql puked: ".mysql_error());
}
$id = mysql_insert_id();
sql_query("INSERT INTO checkcomm (checkid, userid, torrent) VALUES ($id, $CURUSER[id], 1)") or sqlerr(__FILE__,__LINE__);

move_uploaded_file($tmpname, "torrents/$id.torrent");

$fp = fopen("torrents/$id.torrent", "w");
if ($fp)
{
    @fwrite($fp, benc($dict), strlen(benc($dict)));
    fclose($fp);
}

write_log("Торрент номер $id ($torrent) был залит пользователем " . $CURUSER["username"],"5DDB6E","torrent");
header("Location: $DEFAULTBASEURL/details.php?id=$id");}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>