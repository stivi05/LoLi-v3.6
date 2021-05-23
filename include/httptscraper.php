<?php class ScraperException extends Exception{private $connectionerror;		
public function __construct($message,$code=0,$connectionerror=false){$this->connectionerror = $connectionerror;parent::__construct($message, $code);}
public function isConnectionError(){return($this->connectionerror);}}abstract class tscraper{protected $timeout;public function __construct($timeout=2){$this->timeout = $timeout;}}
/////////////////
class lightbenc{static function bdecode($s, &$pos=0){if($pos>=strlen($s)){return null;}
switch($s[$pos]){case 'd': $pos++;$retval=array();while($s[$pos]!='e'){$key=self::bdecode($s, $pos);$val=self::bdecode($s, $pos);
if($key===null || $val===null)break;$retval[$key]=$val;}$retval["isDct"]=true;$pos++;return $retval;
case 'l': $pos++;$retval=array();while ($s[$pos]!='e'){$val=self::bdecode($s, $pos);if($val===null)break;$retval[]=$val;}$pos++;return $retval;
case 'i': $pos++;$digits=strpos($s, 'e', $pos)-$pos;$val=(int)substr($s, $pos, $digits);$pos+=$digits+1;return $val;
default: $digits=strpos($s, ':', $pos)-$pos;if($digits<0 || $digits >20)return null;$len=(int)substr($s, $pos, $digits);$pos+=$digits+1;$str=substr($s, $pos, $len);$pos+=$len;
return (string)$str;}return null;}
static function bencode(&$d){if(is_array($d)){$ret="l";if($d["isDct"]){$isDict=1;$ret="d";ksort($d, SORT_STRING);}
foreach($d as $key=>$value){if($isDict){if($key=="isDct" and is_bool($value)) continue;$ret.=strlen($key).":".$key;}
if(is_string($value)){$ret.=strlen($value).":".$value;}elseif(is_int($value)){$ret.="i${value}e";}else{$ret.=self::bencode ($value);}}
return $ret."e";}elseif(is_string($d)) return strlen($d).":".$d;elseif(is_int($d))return "i${d}e";else return null;}
static function bdecode_file($filename){$f=file_get_contents($filename, FILE_BINARY);return bdecode($f);}}
/////////////////
class httptscraper extends tscraper{protected $maxreadsize;
public function __construct($timeout=2,$maxreadsize=4096){$this->maxreadsize = $maxreadsize;parent::__construct($timeout);}
public function scrape($url,$infohash){if(!is_array($infohash)){$infohash = array($infohash);}
foreach($infohash as $hash){if(!preg_match('#^[a-f0-9]{40}$#i',$hash)){throw new ScraperException('Invalid infohash: '.$hash.'.');}}$url = trim($url);		
if(preg_match('%(http://.*?/)announce([^/]*)$%i', $url, $m)){$url = $m[1].'scrape'.$m[2];}elseif(preg_match('%(http://.*?/)scrape([^/]*)$%i', $url, $m)){}else{
throw new ScraperException('Invalid tracker url.');}
$sep = preg_match ('/\?.{1,}?/i', $url) ? '&' : '?';$requesturl = $url;foreach($infohash as $hash){$requesturl .= $sep.'info_hash='.rawurlencode(pack('H*', $hash));$sep = '&';}
ini_set('default_socket_timeout',$this->timeout);$rh = @fopen($requesturl,'r');if(!$rh){throw new ScraperException('Could not open HTTP connection.',0,true);}
stream_set_timeout($rh, $this->timeout);$return = '';$pos = 0;while(!feof($rh) && $pos < $this->maxreadsize){$return .= fread($rh,1024);}fclose($rh);
if(!substr($return, 0, 1) == 'd'){throw new ScraperException('Invalid scrape response.');}$arr_scrape_data = lightbenc::bdecode($return);$torrents = array();
foreach($infohash as $hash){$ehash = pack('H*', $hash);if(isset($arr_scrape_data['files'][$ehash])){
$torrents[$hash] = array('infohash'=>$hash, 'seeders'=>(int) $arr_scrape_data['files'][$ehash]['complete'], 'completed'=>(int) $arr_scrape_data['files'][$ehash]['downloaded'], 'leechers'=>(int) $arr_scrape_data['files'][$ehash]['incomplete']);
}else{$torrents[$hash] = false;}}return($torrents);}}
//////////////////
class udptscraper extends tscraper{public function scrape($url, $infohash){if(!is_array($infohash)){$infohash = array($infohash);}
foreach($infohash as $hash){if(!preg_match('#^[a-f0-9]{40}$#i',$hash)){throw new ScraperException('Invalid infohash: '.$hash.'.');}}
if(count($infohash) > 74){throw new ScraperException('Too many infohashes provided.');}
if(!preg_match('%udp://([^:/]*)(?::([0-9]*))?(?:/)?%si', $url, $m)){throw new ScraperException('Invalid tracker url.');}
$tracker = 'udp://'.$m[1];$port = isset($m[2]) ? $m[2] : 80;$transaction_id = mt_rand(0,65535);$fp = fsockopen($tracker, $port, $errno, $errstr);
if(!$fp){throw new ScraperException('Could not open UDP connection: '.$errno.' - '.$errstr,0,true);}stream_set_timeout($fp, $this->timeout);
$current_connid = "\x00\x00\x04\x17\x27\x10\x19\x80";$packet = $current_connid.pack("N", 0).pack("N", $transaction_id);fwrite($fp,$packet);$ret = fread($fp, 16);
if(strlen($ret) < 1){throw new ScraperException('No connection response.',0,true);}
if(strlen($ret) < 16){throw new ScraperException('Too short connection response.');}$retd = unpack("Naction/Ntransid",$ret);
if($retd['action'] != 0 || $retd['transid'] != $transaction_id){throw new ScraperException('Invalid connection response.');}$current_connid = substr($ret,8,8);
$hashes = '';foreach($infohash as $hash){$hashes .= pack('H*', $hash);}$packet = $current_connid.pack("N", 2).pack("N", $transaction_id).$hashes;fwrite($fp,$packet);
$readlength = 8 + (12 * count($infohash));$ret = fread($fp, $readlength);
if(strlen($ret) < 1){throw new ScraperException('No scrape response.',0,true);}if(strlen($ret) < 8){throw new ScraperException('Too short scrape response.');}
$retd = unpack("Naction/Ntransid",$ret);if($retd['action'] != 2 || $retd['transid'] != $transaction_id){throw new ScraperException('Invalid scrape response.');}
if(strlen($ret) < $readlength){throw new ScraperException('Too short scrape response.');}$torrents = array();$index = 8;
foreach($infohash as $hash){$retd = unpack("Nseeders/Ncompleted/Nleechers",substr($ret,$index,12));$retd['infohash'] = $hash;$torrents[$hash] = $retd;$index = $index + 12;}return($torrents);}}?>