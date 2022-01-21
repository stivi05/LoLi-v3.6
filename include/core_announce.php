<?php if(!defined("IN_ANNOUNCE")) die("<html><head><meta http-equiv='refresh' content='0;url=/'></head><body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");
@error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
@ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT);
@ini_set('display_errors', '1');
@ini_set('display_startup_errors', '0');
@ini_set('ignore_repeated_errors', '1');
@ignore_user_abort(1);
@set_time_limit(0);
function benc($obj){if(!is_array($obj) || !isset($obj["type"]) || !isset($obj["value"]))return;$c = $obj["value"];
switch($obj["type"]){case "string": return benc_str($c);case "integer": return benc_int($c);case "list": return benc_list($c);case "dictionary": return benc_dict($c);default: return;}}
function benc_str($s){return strlen($s).":$s";}function benc_int($i){return "i".$i."e";}function benc_list($a){$s = "l";foreach ($a as $e){$s .= benc($e);}$s .= "e";return $s;}
function benc_dict($d){$s = "d";$keys = array_keys($d);sort($keys);foreach ($keys as $k){$v = $d[$k];$s .= benc_str($k);$s .= benc($v);}$s .= "e";return $s;}
function bdec_file($f, $ms){$fp = fopen($f, "rb");if(!$fp)return;$e = fread($fp, $ms);fclose($fp);return bdec($e);}
function bdec($s){if(preg_match('/^(\d+):/', $s, $m)){$l = $m[1];$pl = strlen($l) + 1;$v = substr($s, $pl, $l);$ss = substr($s, 0, $pl + $l);
if(strlen($v) != $l)return;return array('type' => "string", 'value' => $v, 'strlen' => strlen($ss), 'string' => $ss);}
if(preg_match('/^i(-{0,1}\d+)e/', $s, $m)){$v = $m[1];$ss = "i".$v."e";if($v === "-0") return;
if($v[0] == "0" && strlen($v) != 1) return;return array('type' => "integer", 'value' => $v, 'strlen' => strlen($ss), 'string' => $ss);}
switch ($s[0]){case "l": return bdec_list($s);case "d": return bdec_dict($s);default: return;}}
function bdec_list($s){if($s[0] != "l")return;$sl = strlen($s);$i = 1;$v = array();$ss = "l";for (;;){if($i >= $sl) return;if($s[$i] == "e") break;$ret = bdec(substr($s, $i));
if(!isset($ret) || !is_array($ret)) return;$v[] = $ret;$i += $ret["strlen"];$ss .= $ret["string"];}$ss .= "e";
return array('type' => "list", 'value' => $v, 'strlen' => strlen($ss), 'string' => $ss);}
function bdec_dict($s){if ($s[0] != "d")return;$sl = strlen($s);$i = 1;$v = array();$ss = "d";
for (;;){if($i >= $sl)return;if($s[$i] == "e")break;$ret = bdec(substr($s, $i));if(!isset($ret) || !is_array($ret) || $ret["type"] != "string")return;
$k = $ret["value"];$i += $ret["strlen"];$ss .= $ret["string"];if($i >= $sl)return;$ret = bdec(substr($s, $i));if(!isset($ret) || !is_array($ret))return;
$v[$k] = $ret;$i += $ret["strlen"];$ss .= $ret["string"];}$ss .= "e";return array('type' => "dictionary", 'value' => $v, 'strlen' => strlen($ss), 'string' => $ss);}
/////////////////////
$mysql_host = "localhost"; //прописать ваши данные!//
$mysql_user = "пользователь базы данных"; //прописать ваши данные!//
$mysql_pass = "пароль пользователя базы данных"; //прописать ваши данные!//
$mysql_db = "база данных"; //прописать ваши данные!//
//////////////////////////
if(!function_exists("htmlspecialchars_uni")){function htmlspecialchars_uni($message){
$message = preg_replace("#&(?!\#[0-9]+;)#si", "&amp;", $message); // Fix & but allow unicode
$message = str_replace("<","&lt;",$message);$message = str_replace(">","&gt;",$message);
$message = str_replace("\"","&quot;",$message);$message = str_replace("  ", "&nbsp;&nbsp;", $message);return $message;}}
// DEFINE IMPORTANT CONSTANTS
define ('TIMENOW', time());
$url = explode('/', htmlspecialchars_uni($_SERVER['PHP_SELF']));array_pop($url);
$DEFAULTBASEURL = (($_SERVER['SERVER_PORT'] == 443) ? "https://" : "https://").htmlspecialchars_uni($_SERVER['HTTP_HOST']).implode('/', $url);
$BASEURL = $DEFAULTBASEURL;
$announce_urls = array();$announce_urls[] = "$DEFAULTBASEURL/announce.php";
// SECURITY
define ('COOKIE_SALT', 'lskdflkijfef7w6438794389tn9cp043t8uc4ppodemoip4o98mr9r8m49rm32404m9x9u4xu9nmcpti9tu9tu94ttum'); // Заполните эту переменную любым мусором, символов эдак 32 - нужно для соли кукисов
// После смены этих двух параметров всем пользователям надо будет ввести логин пароль
define ('COOKIE_UID', 'uid'); // Имя куки для userid
define ('COOKIE_PASSHASH', 'pass'); // Имя куки для пароля
// DEFINE TRACKER GROUPS
define ("UC_USER", 0);
define ("UC_720p", 1);
define ("UC_1080i", 2);
define ("UC_1080p", 3);
define ("UC_UHD", 4);
define ("UC_VIPS", 5);
define ("UC_UPLOADER", 6);
define ("UC_VIP", 7);
define ("UC_MODERATOR", 8);
define ("UC_ADMINISTRATOR", 9);
define ("UC_SYSOP", 10);
define ("UC_VLADELEC", 11);
//////////////////////////
$SITENAME = 'название вашего сайта'; //прописать ваши данные!//
$announce_interval = 60 * 30;
$autoclean_interval = 60 * 30;
$nc = 'no'; // Не пропускать на трекер пиров с закрытыми портами.
/////////////////////
function err($msg){benc_resp(array("failure reason" => array('type' => 'string', 'value' => $msg)));exit();}
function benc_resp($d){benc_resp_raw(benc(array('type' => 'dictionary', 'value' => $d)));}
function benc_resp_raw($x){header('Content-Type: text/plain');header('Pragma: no-cache');print($x);}
function get_date_time($timestamp = 0){if($timestamp)return date('Y-m-d H:i:s', $timestamp);else return date('Y-m-d H:i:s');}
function gmtime(){return strtotime(get_date_time());}
function mksize($bytes){if($bytes < 1000 * 1024)return number_format($bytes / 1024, 2) . ' kB';elseif ($bytes < 1000 * 1048576)return number_format($bytes / 1048576, 2) . ' MB';
elseif ($bytes < 1000 * 1073741824)return number_format($bytes / 1073741824, 2) . ' GB';else return number_format($bytes / 1099511627776, 2) . ' TB';}
function portblacklisted($port){if($port >= 411 && $port <= 413)return true;if($port >= 6881 && $port <= 6889)return true;
if($port == 1214)return true;if($port >= 6346 && $port <= 6347)return true;if($port == 4662)return true;if($port == 6699)return true;return false;}
function validip($ip){if(!empty($ip) && $ip == long2ip(ip2long($ip))){
$reserved_ips = array(array('0.0.0.0', '2.255.255.255'), array('10.0.0.0', '10.255.255.255'), array('127.0.0.0', '127.255.255.255'), array('169.254.0.0', '169.254.255.255'), array('172.16.0.0', '172.31.255.255'), array('192.0.2.0', '192.0.2.255'), array('192.168.0.0', '192.168.255.255'), array('255.255.255.0', '255.255.255.255'));
foreach ($reserved_ips as $r){$min = ip2long($r[0]);$max = ip2long($r[1]);if((ip2long($ip) >= $min) && (ip2long($ip) <= $max))return false;}return true;}else return false;}
function getip(){return $_SERVER['REMOTE_ADDR'];}
function dbconn(){global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
if(!@mysql_connect($mysql_host, $mysql_user, $mysql_pass)){err('dbconn: mysql_connect: '.mysql_error());}
mysql_select_db($mysql_db) or err('dbconn: mysql_select_db: '.mysql_error());mysql_query("SET NAMES 'utf8'");register_shutdown_function('mysql_close');}
function sqlesc($value){if(!is_numeric($value)){$value = "'".mysql_real_escape_string($value)."'";}return $value;}
function hash_pad($hash){return str_pad($hash, 20);}
function unesc($x){$x = is_array($x) ? array_map('unesc', $x) : stripslashes($x);return $x;}
function gzip(){if(@extension_loaded('zlib') && @ini_get('zlib.output_compression') != '1' && @ini_get('output_handler') != 'ob_gzhandler'){@ob_start('ob_gzhandler');}}
function check_port($host, $port, $timeout){if(function_exists('socket_create')){$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if($socket == false){return false;}if(socket_set_nonblock($socket) == false){socket_close($socket);return false;}
@socket_connect($socket, $host, $port);if(socket_set_block($socket) == false){socket_close($socket);return false;}
switch (socket_select($r = array($socket), $w = array($socket), $f = array($socket), $timeout)){
case 2: $result = false;break;case 1: $result = true;break;case 0: $result = false;break;}socket_close($socket);}else{
$socket = @fsockopen($host, $port, $errno, $errstr, $timeout);if(!$socket)$result = false;else{$result = true;@fclose($socket);}}return $result;}?>
