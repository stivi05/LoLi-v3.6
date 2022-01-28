<? if(!defined('IN_TRACKER')) die('Hacking attempt!');
function docleanupusers(){global $autoclean_users, $tracker_lang, $rootpath;
/////////////// CURUSER CACHE Nachalo ////////////////////////////
$usersres = sql_query("SELECT * FROM users WHERE status='confirmed' ORDER BY id") or sqlerr(__FILE__, __LINE__);
while($usersre = mysql_fetch_assoc($usersres)){$id = $usersre['id'];
$ressed = sql_query("SELECT COUNT(*) FROM peers WHERE userid = $id AND seeder='yes'");$rowsed = mysql_fetch_row($ressed);$activeseed = $rowsed[0];
$reslech = sql_query("SELECT COUNT(*) FROM peers WHERE userid = $id AND seeder='no'");$rowlech = mysql_fetch_row($reslech);$activeleech = $rowlech[0];
$rescom = sql_query("SELECT COUNT(id) FROM comments WHERE user = ".$id) or sqlerr(__FILE__, __LINE__);$arr3 = mysql_fetch_row($rescom);$torrentcomments = $arr3[0];
$resreliz = sql_query("SELECT COUNT(id) FROM torrents WHERE owner = ".$id) or sqlerr(__FILE__, __LINE__);$arreliz = mysql_fetch_row($resreliz);$relizs = $arreliz[0];
sql_query("UPDATE users SET leecher = '$activeleech', relizs = '$relizs', seeder = '$activeseed', comreliz = '$torrentcomments' WHERE id = $id");}
/////////////// CURUSER CACHE Konec ////////////////////////////
//////// Авто-очистка выполненых заказов из Стол Заказов НАЧАЛО ////////////////
$reszak = sql_query("SELECT id, image1 FROM zakaz WHERE status = '4'") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($reszak) > 0){while ($arrb = mysql_fetch_array($reszak)){$idz = $arrb["id"];
sql_query("DELETE FROM zakaz WHERE id = ".sqlesc($idz)) or sqlerr(__FILE__,__LINE__);
$imagezak = $rootpath."torrents/zakaz/".$arrb["image1"];if(file_exists($imagezak)){unlink($imagezak);}
write_log("Заказ id=".$idz." - Удален системой Так как был Выполнен и Подтвержден.", "5DDB6E", "tracker");}}
//////// Авто-очистка выполненых заказов из Стол Заказов КОНЕЦ ////////////////
////////обновление рейтинга КиноПоиск ////////////////
$secsnr = 7*86400;$dt1r = sqlesc(get_date_time(gmtime() - $secsnr));
$ressr = sql_query("SELECT id, kinopoisk FROM torrents WHERE kptime < $dt1r") or sqlerr(__FILE__,__LINE__);
if(mysql_num_rows($ressr) > 0){while($arrr = mysql_fetch_assoc($ressr)){
$idsr = $arrr["id"];$kinopoisks = $arrr['kinopoisk'];$kinopoisk = "https://rating.kinopoisk.ru/".$kinopoisks.".gif";
if($kinopoisks != "0"){$uploaddir = $rootpath."torrents/kinopoisk/";$ifile = $kinopoisk;$files = explode('.', $kinopoisk);
$ifilename = $kinopoisks.'.'.end($files);
$ifilenames = $rootpath."torrents/kinopoisk/".$ifilename;if(file_exists($ifilenames)){unlink($ifilenames);}
$copy = copy($ifile, $uploaddir.$ifilename);if (!$copy) stderr2($tracker_lang["error"], "Error occured uploading image! - Image");
sql_query("UPDATE torrents SET kptime = NOW() WHERE id = $idsr") or sqlerr();
write_log("Рейтинг КП с релиза id=".$idsr." обновлен системой.", "5DDB6E", "tracker");}}}
////обновление рейтинга КиноПоиск ////////////////
////обновление рейтинга imdb////////////////
$secsnri = 7*86400;$dt1ri = sqlesc(get_date_time(gmtime() - $secsnri));
$ressri = sql_query("SELECT id, imdb FROM torrents WHERE imdbtime < $dt1ri") or sqlerr(__FILE__,__LINE__);
if(mysql_num_rows($ressri) > 0){while($arrri = mysql_fetch_assoc($ressri)){
$idsri = $arrri["id"];$imdbs = $arrri['imdb'];$imdb = "https://ratinginformer.com/".$imdbs.".png";
if($imdbs != "0"){$uploaddir = $rootpath."torrents/imdb/";$ifile = $imdb;$files = explode('.', $imdb);$ifilename = $imdbs.'.'.end($files);
$ifilenames = $rootpath."torrents/imdb/".$ifilename;if(file_exists($ifilenames)){unlink($ifilenames);}
$copy = copy($ifile, $uploaddir.$ifilename);if (!$copy) stderr2($tracker_lang["error"], "Error occured uploading image! - Image");
sql_query("UPDATE torrents SET imdbtime = NOW() WHERE id = $idsr") or sqlerr();
write_log("Рейтинг imdb с релиза id=".$idsri." обновлен системой.", "5DDB6E", "tracker");}}}
////обновление рейтинга imdb ////////////////
}?>