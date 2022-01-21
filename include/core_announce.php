<?php if(!defined("IN_ANNOUNCE")) die("<html><head><meta http-equiv='refresh' content='0;url=/'></head><body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");
@error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);@ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT);@ini_set('display_errors', '1');
@ini_set('display_startup_errors', '0');@ini_set('ignore_repeated_errors', '1');@ignore_user_abort(1);@set_time_limit(0);
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
$DEFAULTBASEURL = (($_SERVER['SERVER_PORT'] == 443) ? "https://" : "https://").htmlspecialchars_uni($_SERVER['HTTP_HOST']).implode('/', $url);$BASEURL = $DEFAULTBASEURL;
$announce_urls = array();$announce_urls[] = "$DEFAULTBASEURL/announce.php";$announce_interval = 60 * 30;$nc = 'no'; // Не пропускать на трекер пиров с закрытыми портами.
/////////////////////
function benc($obj){if(!is_array($obj) || !isset($obj["type"]) || !isset($obj["value"]))return;$c = $obj["value"];
switch($obj["type"]){case "string": return benc_str($c);case "integer": return benc_int($c);case "list": return benc_list($c);case "dictionary": return benc_dict($c);default: return;}}
function benc_str($s){return strlen($s).":$s";}function benc_int($i){return "i".$i."e";}function benc_list($a){$s = "l";foreach ($a as $e){$s .= benc($e);}$s .= "e";return $s;}
function benc_dict($d){$s = "d";$keys = array_keys($d);sort($keys);foreach ($keys as $k){$v = $d[$k];$s .= benc_str($k);$s .= benc($v);}$s .= "e";return $s;}
function err($msg){benc_resp(array("failure reason" => array('type' => 'string', 'value' => $msg)));exit();}
function benc_resp($d){benc_resp_raw(benc(array('type' => 'dictionary', 'value' => $d)));}
function benc_resp_raw($x){header('Content-Type: text/plain');header('Pragma: no-cache');print($x);}
function get_date_time($timestamp = 0){if($timestamp)return date('Y-m-d H:i:s', $timestamp);else return date('Y-m-d H:i:s');}
function portblacklisted($port){if($port >= 411 && $port <= 413)return true;if($port >= 6881 && $port <= 6889)return true;
if($port == 1214)return true;if($port >= 6346 && $port <= 6347)return true;if($port == 4662)return true;if($port == 6699)return true;return false;}
function getip(){return $_SERVER['REMOTE_ADDR'];}
function dbconn(){global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
if(!@mysql_connect($mysql_host, $mysql_user, $mysql_pass)){err('dbconn: mysql_connect: '.mysql_error());}
mysql_select_db($mysql_db) or err('dbconn: mysql_select_db: '.mysql_error());mysql_query("SET NAMES 'utf8'");register_shutdown_function('mysql_close');}
function sqlesc($value){if(!is_numeric($value)){$value = "'".mysql_real_escape_string($value)."'";}return $value;}
function gzip(){if(@extension_loaded('zlib') && @ini_get('zlib.output_compression') != '1' && @ini_get('output_handler') != 'ob_gzhandler'){@ob_start('ob_gzhandler');}}
function check_port($host, $port, $timeout){if(function_exists('socket_create')){$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if($socket == false){return false;}if(socket_set_nonblock($socket) == false){socket_close($socket);return false;}
@socket_connect($socket, $host, $port);if(socket_set_block($socket) == false){socket_close($socket);return false;}
switch (socket_select($r = array($socket), $w = array($socket), $f = array($socket), $timeout)){
case 2: $result = false;break;case 1: $result = true;break;case 0: $result = false;break;}socket_close($socket);}else{
$socket = @fsockopen($host, $port, $errno, $errstr, $timeout);if(!$socket)$result = false;else{$result = true;@fclose($socket);}}return $result;}?>