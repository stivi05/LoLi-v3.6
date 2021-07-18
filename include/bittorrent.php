<?php if(!defined('IN_TRACKER')){define('IN_TRACKER', true);
if(isset($_REQUEST['GLOBALS']) OR isset($_FILES['GLOBALS'])){die("<html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'>
</body></html>");}
@error_reporting(E_ALL & ~E_NOTICE);
@ini_set('error_reporting', E_ALL & ~E_NOTICE);
@ini_set('display_errors', '1');
@ini_set('display_startup_errors', '0');
@ini_set('ignore_repeated_errors', '1');
@ignore_user_abort(1);
@set_time_limit(0);
@session_start();
define ('ROOT_PATH', dirname(dirname(__FILE__))."/");
$allowed_referrers = <<<REF
REF;
if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' AND !defined('SKIP_REFERRER_CHECK')){
if($_SERVER['HTTP_HOST'] OR $_ENV['HTTP_HOST']){$http_host = ($_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : $_ENV['HTTP_HOST']);
}else if($_SERVER['SERVER_NAME'] OR $_ENV['SERVER_NAME']){$http_host = ($_SERVER['SERVER_NAME'] ? $_SERVER['SERVER_NAME'] : $_ENV['SERVER_NAME']);}
if($http_host AND $_SERVER['HTTP_REFERER']){$http_host = preg_replace('#:80$#', '', trim($http_host));$referrer_parts = @parse_url($_SERVER['HTTP_REFERER']);
if(isset($referrer_parts['port']))$ref_port = intval($referrer_parts['port']);else $ref_post = 80;
$ref_host = $referrer_parts['host'] . ((!empty($ref_port) AND $ref_port != '80') ? ":$ref_port" : '');
$allowed = preg_split('#\s+#', $allowed_referrers, -1, PREG_SPLIT_NO_EMPTY);$allowed[] = preg_replace('#^www\.#i', '', $http_host);
$allowed[] = '.paypal.com';$pass_ref_check = false;foreach ($allowed AS $host){
if(preg_match('#' . preg_quote($host, '#') . '$#siU', $ref_host)){$pass_ref_check = true;break;}}unset($allowed);
if($pass_ref_check == false)die('In order to accept POST request originating from this domain, the admin must add this domain to the whitelist.');}}
function timer(){list($usec, $sec) = explode(" ", microtime());return ((float)$usec + (float)$sec);}
function detect_sqlinjection($query){$query = preg_replace ( "#(\\\'|\\\")#si", "", $query );$query = preg_replace ( "#'(.*?)'#si", "", $query ); 
if(preg_match("#(UNION|INTO\sOUTFILE|INTO\sDUMPFILE|LOAD_FILE\s\((.*?)\)|BENCHMARK\s\((.*?)\)|\<\?php(.*?)\?\>|USER\s\((.*?)\)|DATABASE\s\((.*?)\)|\#|\-\-|\\\\*(.*?)\*\\\)#si", $query)) die("SQL Injection DETECTED! HA-HA!");}
if(version_compare(PHP_VERSION, '5.2.0', '<'))die('Извините, трекер работает на PHP от версии 5.2 и выше. Обновите версию PHP.');
if(!interface_exists('ArrayAccess'))die('У вас не установлено расширение PHP SPL (Standard PHP Library). Без установки этого расширения дальнейшая работа невозможна.');
if(ini_get('register_globals') == '1' || strtolower(ini_get('register_globals')) == 'on')die('Отключите register_globals в php.ini/.htaccess (угроза безопасности)');
if((int) ini_get('short_open_tag') == '0')die('Включите short_open_tag в php.ini/.htaccess (техническое требование)');
$tstart = timer(); // Start time
$mysql_host = "localhost"; //прописать ваши данные!//
$mysql_user = "пользователь базы данных"; //прописать ваши данные!//
$mysql_pass = "пароль пользователя базы данных"; //прописать ваши данные!//
$mysql_db = "база данных"; //прописать ваши данные!//
//////////////////////////
if(!function_exists("htmlspecialchars_uni")){function htmlspecialchars_uni($message){
$message = preg_replace("#&(?!\#[0-9]+;)#si", "&amp;", $message);$message = str_replace("<","&lt;",$message);$message = str_replace(">","&gt;",$message);
$message = str_replace("\"","&quot;",$message);$message = str_replace("  ", "&nbsp;&nbsp;", $message);return $message;}}
// DEFINE IMPORTANT CONSTANTS
define ('TIMENOW', time());
$url = explode('/', detect_sqlinjection($_SERVER['PHP_SELF']));
array_pop($url);
$DEFAULTBASEURL = (($_SERVER['SERVER_PORT'] == 443) ? "https://" : "https://").htmlspecialchars_uni($_SERVER['HTTP_HOST']).implode('/', $url);
$BASEURL = $DEFAULTBASEURL;
$announce_urls = array();
$announce_urls[] = "$DEFAULTBASEURL/announce.php";
// SECURITY
define ('COOKIE_SALT', 'Заполните любым мусором символов 32 без пробелов'); // Заполните любым мусором символов 32, нужно для соли кукисов
// После смены этих двух параметров всем пользователям надо будет ввести логин пароль
define ('COOKIE_UID', 'uid'); // Имя куки для userid
define ('COOKIE_PASSHASH', 'pass'); // Имя куки для пароля
// Группы-классы сайта (меняйте на свои, если не хотите эти)
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
$max_torrent_size = 1024 * 1024 * 6;
$announce_interval = 60 * 30;
$signup_timeout = 86400 * 3;
$minvotes = 1;
$max_dead_torrent_time = 175*86400;
$maxloginattempts = 3; // Максимальное количество попыток входа 
$maxloginattemptss = 3; // Максимальное количество попыток подбора ответа на секретный вопрос
$maxusers = 250000;
$SITEEMAIL = 'емайл вашего сайта'; //прописать ваши данные!//
$SITENAME = 'название вашего сайта'; //прописать ваши данные!//
$autoclean_interval = 60 * 30;
$pic_base_url = 'pic';
$allowed_types = array( 
  "image/gif" => "gif", 
  "image/pjpeg" => "jpg", 
  "image/jpeg" => "jpg", 
  "image/jpg" => "jpg", 
  "image/png" => "png");
$maxavatarsize = 5242880; //100 kB 
$maxfilesize = 5242880; // 5mb
$max_image_size = 5242880; // 5mb
$avatar_max_width = 180; // Максимальная ширина аватары.
$avatar_max_height = 360; // Максимальная высота аватары.
$image_max_width = 2000; // Максимальная ширина image.
$image_max_height = 2000; // Максимальная высота image.
$default_theme = 'HDGray'; // Тема по умолчанию.
$nc = 'no'; // Не пропускать на трекер пиров с закрытыми портами.
$default_language = 'russian'; // Язык трекера по умолчанию.
$use_email_act = 1; // Использовать активацию по почте, иначе - автоматическая активация при регистрации.
$use_lang = 1; // Включить языковую систему. Выключите если вы хотите перевести шаблоны и другие файлы - тогда все фразы от системы станут пустым местом.
$use_sessions = 1; // Использовать сессии. 0 - нет, 1 - да.
$smtptype = 'default';
$allow_block_hide = true; // Разрешить сворачивание блоков
$check_for_working_smtp = true; // Проверять работу почтового MTA при регистрации пользователя (TCP connect @ domain:25)
$force_private_tracker = true;
$admin_email = 'емайл админа сайта'; // Почта администратора трекера, для формы обратной связи //прописать ваши данные!//
$website_name = 'Название сайта'; // Краткое имя сайта, для формы обратной связи //прописать ваши данные!//
$head[] = '<meta http-equiv="imagetoolbar" content="no" /><meta name="resource-type" content="document" /><meta name="distribution" content="global" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9" /><meta name="copyright" content="Ваш Сайт" />
<meta name="keywords" content="Фильмы, Мультфильмы, Сериалы, Мультсериалы" />
<script src="js/jquery.js"></script><script src="js/tooltips.js"></script><script src="js/ajax.js"></script><script src="js/ajaxs.js"></script>
<script src="js/showshides.js"></script><link rel="alternate" type="application/rss+xml" title="Последние торренты" href="rss">';
/////////////////////////
if(empty($rootpath))$rootpath = ROOT_PATH;
////////// functions_global ON /////////////
function get_user_class_color($class, $username){global $tracker_lang;switch ($class){
case UC_VLADELEC: return "<span style='color:#808000' title='".$tracker_lang['class_vladelec']."'>".$username."</span>";break;
case UC_SYSOP: return "<span style='color:#0F6CEE' title='".$tracker_lang['class_sysop']."'>".$username."</span>";break;
case UC_ADMINISTRATOR: return "<span style='color:#339900' title='".$tracker_lang['class_administrator']."'>".$username."</span>";break;
case UC_MODERATOR: return "<span style='color:red' title='".$tracker_lang['class_moderator']."'>".$username."</span>";break;
case UC_VIP: return "<span style='color:#9C2FE0' title='".$tracker_lang['class_vip']."'>".$username."</span>";break;
case UC_UPLOADER: return "<span style='color:#FF9900' title='".$tracker_lang['class_uploader']."'>".$username."</span>";break;
case UC_VIPS: return "<span style='color:blue' title='".$tracker_lang['class_vips']."'>".$username."</span>";break;
case UC_UHD: return "<span style='color:#6A5ACD' title='".$tracker_lang['class_uhd']."'>".$username."</span>";break;
case UC_1080p: return "<span style='color:Indigo' title='".$tracker_lang['class_1080p']."'>".$username."</span>";break;
case UC_1080i: return "<span style='color:#D21E36' title='".$tracker_lang['class_1080i']."'>".$username."</span>";break;	
case UC_720p: return "<span style='color:black' title='".$tracker_lang['class_720p']."'>".$username."</span>";break;
case UC_USER: return "<span style='color:gray' title='".$tracker_lang['class_user']."'>".$username."</span>";break;}return "$username";}
/////////////////////
function display_date_time($timestamp = 0, $tzoffset = 0){return date("Y-m-d H:i:s", $timestamp + ($tzoffset * 60));}
/////////////////////////////
function cut_text($txt, $car){while(strlen($txt) > $car){return substr($txt, 0, $car) . "...";}return $txt;}
///////////////////////////////////
function textbbcode($form, $name, $content=""){?><script>
function RowsTextarea(n, w) {
	var inrows = document.getElementById(n);
	if (w < 1) {
		var rows = -5;
	} else {
		var rows = +5;
	}
	var outrows = inrows.rows + rows;
	if (outrows >= 5 && outrows < 50) {
		inrows.rows = outrows;
	}
	return false;
}

var SelField = document.<?php echo $form;?>.<?php echo $name;?>;
var TxtFeld  = document.<?php echo $form;?>.<?php echo $name;?>;

var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));

var is_moz = 0;

var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);

function StoreCaret(text) {
	if (text.createTextRange) {
		text.caretPos = document.selection.createRange().duplicate();
	}
}
function FieldName(text, which) {
	if (text.createTextRange) {
		text.caretPos = document.selection.createRange().duplicate();
	}
	if (which != "") {
		var Field = eval("document.<?php echo $form;?>."+which);
		SelField = Field;
		TxtFeld  = Field;
	}
}
function AddSmile(SmileCode) {
	var SmileCode;
	var newPost;
	var oldPost = SelField.value;
	newPost = oldPost+SmileCode;
	SelField.value=newPost;
	SelField.focus();
	return;
}
function AddSelectedText(Open, Close) {
	if (SelField.createTextRange && SelField.caretPos && Close == '\n') {
		var caretPos = SelField.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? Open + Close + ' ' : Open + Close;
		SelField.focus();
	} else if (SelField.caretPos) {
		SelField.caretPos.text = Open + SelField.caretPos.text + Close;
	} else {
		SelField.value += Open + Close;
		SelField.focus();
	}
}
function InsertCode(code, info, type, error) {
	if (code == 'name') {
		AddSelectedText('[b]' + info + '[/b]', '\n');
	} else if (code == 'url' || code == 'mail') {
		if (code == 'url') var url = prompt(info, 'http://');
		if (code == 'mail') var url = prompt(info, '');
		if (!url) return alert(error);
		if ((clientVer >= 4) && is_ie && is_win) {
			selection = document.selection.createRange().text;
			if (!selection) {
				var title = prompt(type, type);
				AddSelectedText('[' + code + '=' + url + ']' + title + '[/' + code + ']', '\n');
			} else {
				AddSelectedText('[' + code + '=' + url + ']', '[/' + code + ']');
			}
		} else {
			mozWrap(TxtFeld, '[' + code + '=' + url + ']', '[/' + code + ']');
		}
	} else if (code == 'color' || code == 'family' || code == 'size') {
		if ((clientVer >= 4) && is_ie && is_win) {
			AddSelectedText('[' + code + '=' + info + ']', '[/' + code + ']');
		} else if (TxtFeld.selectionEnd && (TxtFeld.selectionEnd - TxtFeld.selectionStart > 0)) {
			mozWrap(TxtFeld, '[' + code + '=' + info + ']', '[/' + code + ']');
		}
	} else if (code == 'li' || code == 'hr') {
		if ((clientVer >= 4) && is_ie && is_win) {
			AddSelectedText('[' + code + ']', '');
		} else {
			mozWrap(TxtFeld, '[' + code + ']', '');
		}
} else if (code == 'spoiler') {
        var text = '\n';
        var header = false;
        if (!header)
            header = 'Скрытая информация';
        AddSelectedText('[' + code + '=' + header + ']' + text,'[/' + code + ']');
	} else {
		if ((clientVer >= 4) && is_ie && is_win) {
			var selection = false;
			selection = document.selection.createRange().text;
			if (selection && code == 'quote') {
				AddSelectedText('[' + code + ']' + selection + '[/' + code + ']', '\n');
			} else {
				AddSelectedText('[' + code + ']', '[/' + code + ']');
			}
		}
	
		else {
			mozWrap(TxtFeld, '[' + code + ']', '[/' + code + ']');
		}
	}
}

function mozWrap(txtarea, open, close)
{
        var selLength = txtarea.textLength;
        var selStart = txtarea.selectionStart;
        var selEnd = txtarea.selectionEnd;
        if (selEnd == 1 || selEnd == 2)
                selEnd = selLength;

        var s1 = (txtarea.value).substring(0,selStart);
        var s2 = (txtarea.value).substring(selStart, selEnd)
        var s3 = (txtarea.value).substring(selEnd, selLength);
        var sT = txtarea.scrollTop, sL = txtarea.scrollLeft;
        txtarea.value = s1 + open + s2 + close + s3;
        txtarea.focus();
        txtarea.scrollTop=sT;
        xtarea.scrollLeft=sL;
	return;
}

language=1;
richtung=1;
var DOM = document.getElementById ? 1 : 0, 
opera = window.opera && DOM ? 1 : 0, 
IE = !opera && document.all ? 1 : 0, 
NN6 = DOM && !IE && !opera ? 1 : 0; 
var ablauf = new Date();
var jahr = ablauf.getTime() + (365 * 24 * 60 * 60 * 1000);
ablauf.setTime(jahr);
var richtung=1;
var isChat=false;
NoHtml=true;
NoScript=true;
NoStyle=true;
NoBBCode=true;
NoBefehl=false;

function setZustand() {
	transHtmlPause=false;
	transScriptPause=false;
	transStylePause=false;
	transBefehlPause=false;
	transBBPause=false;
}
setZustand();
function keks(Name,Wert){
	document.cookie = Name+"="+Wert+"; expires=" + ablauf.toGMTString();
}
function changeNoTranslit(Nr){
	if(document.trans.No_translit_HTML.checked)NoHtml=true;else{NoHtml=false}
	if(document.trans.No_translit_BBCode.checked)NoBBCode=true;else{NoBBCode=false}
	keks("NoHtml",NoHtml);keks("NoScript",NoScript);keks("NoStyle",NoStyle);keks("NoBBCode",NoBBCode);
}
function changeRichtung(r){
	richtung=r;keks("TransRichtung",richtung);setFocus()
}
function changelanguage(){  
	if (language==1) {language=0;}
	else {language=1;}
	keks("autoTrans",language);
	setFocus();
	setZustand();
}
function setFocus(){
	TxtFeld.focus();
}
function repl(t,a,b){
	var w=t,i=0,n=0;
	while((i=w.indexOf(a,n))>=0){
		t=t.substring(0,i)+b+t.substring(i+a.length,t.length);	
		w=w.substring(0,i)+b+w.substring(i+a.length,w.length);
		n=i+b.length;
		if(n>=w.length){
			break;
		}
	}
	return t;
}
var rus_lr2 = ('Е-е-О-о-Ё-Ё-Ё-Ё-Ж-Ж-Ч-Ч-Ш-Ш-Щ-Щ-Ъ-Ь-Э-Э-Ю-Ю-Я-Я-Я-Я-ё-ё-ж-ч-ш-щ-э-ю-я-я').split('-');
var lat_lr2 = ('/E-/e-/O-/o-ЫO-Ыo-ЙO-Йo-ЗH-Зh-ЦH-Цh-СH-Сh-ШH-Шh-ъ'+String.fromCharCode(35)+'-ь'+String.fromCharCode(39)+'-ЙE-Йe-ЙU-Йu-ЙA-Йa-ЫA-Ыa-ыo-йo-зh-цh-сh-шh-йe-йu-йa-ыa').split('-');
var rus_lr1 = ('А-Б-В-Г-Д-Е-З-И-Й-К-Л-М-Н-О-П-Р-С-Т-У-Ф-Х-Х-Ц-Щ-Ы-Я-а-б-в-г-д-е-з-и-й-к-л-м-н-о-п-р-с-т-у-ф-х-х-ц-щ-ъ-ы-ь-я').split('-');
var lat_lr1 = ('A-B-V-G-D-E-Z-I-J-K-L-M-N-O-P-R-S-T-U-F-H-X-C-W-Y-Q-a-b-v-g-d-e-z-i-j-k-l-m-n-o-p-r-s-t-u-f-h-x-c-w-'+String.fromCharCode(35)+'-y-'+String.fromCharCode(39)+'-q').split('-');
var rus_rl = ('А-Б-В-Г-Д-Е-Ё-Ж-З-И-Й-К-Л-М-Н-О-П-Р-С-Т-У-Ф-Х-Ц-Ч-Ш-Щ-Ъ-Ы-Ь-Э-Ю-Я-а-б-в-г-д-е-ё-ж-з-и-й-к-л-м-н-о-п-р-с-т-у-ф-х-ц-ч-ш-щ-ъ-ы-ь-э-ю-я').split('-');
var lat_rl = ('A-B-V-G-D-E-JO-ZH-Z-I-J-K-L-M-N-O-P-R-S-T-U-F-H-C-CH-SH-SHH-'+String.fromCharCode(35)+String.fromCharCode(35)+'-Y-'+String.fromCharCode(39)+String.fromCharCode(39)+'-JE-JU-JA-a-b-v-g-d-e-jo-zh-z-i-j-k-l-m-n-o-p-r-s-t-u-f-h-c-ch-sh-shh-'+String.fromCharCode(35)+'-y-'+String.fromCharCode(39)+'-je-ju-ja').split('-');
var transAN=true;
function transliteText(txt){
	vorTxt=txt.length>1?txt.substr(txt.length-2,1):"";
	buchstabe=txt.substr(txt.length-1,1);
	txt=txt.substr(0,txt.length-2);
	return txt+translitBuchstabeCyr(vorTxt,buchstabe);
}
function translitBuchstabeCyr(vorTxt,txt){
	var zweiBuchstaben = vorTxt+txt;
	var code = txt.charCodeAt(0);
	
	if (txt=="<")transHtmlPause=true;else if(txt==">")transHtmlPause=false;
	if (txt=="<script")transScriptPause=true;else if(txt=="<"+"/script>")transScriptPause=false;
	if (txt=="<style")transStylePause=true;else if(txt=="<"+"/style>")transStylePause=false;
	if (txt=="[")transBBPause=true;else if(txt=="]")transBBPause=false;
	if (txt=="/")transBefehlPause=true;else if(txt==" ")transBefehlPause=false;
	
	if (
		(transHtmlPause==true &&   NoHtml==true)||
		(transScriptPause==true &&   NoScript==true)||
		(transStylePause==true &&   NoStyle==true)||
		(transBBPause==true &&   NoBBCode==true)||
		(transBefehlPause==true &&   NoBefehl==true)||
		
		!(((code>=65) && (code<=123))||(code==35)||(code==39))) return zweiBuchstaben;
	
	for (x=0; x<lat_lr2.length; x++){
		if (lat_lr2[x]==zweiBuchstaben) return rus_lr2[x];
	}
	for (x=0; x<lat_lr1.length; x++){
		if (lat_lr1[x]==txt) return vorTxt+rus_lr1[x];
	}
	return zweiBuchstaben;
}
function translitBuchstabeLat(buchstabe){
	for (x=0; x<rus_rl.length; x++){
		if (rus_rl[x]==buchstabe)
		return lat_rl[x];
	}
	return buchstabe;
}
function translateAlltoLatin(){
	if (!IE){
		var txt=TxtFeld.value;
		var txtnew = "";
		var symb = "";
		for (y=0;y<txt.length;y++){
			symb = translitBuchstabeLat(txt.substr(y,1));
			txtnew += symb;
		}
		TxtFeld.value = txtnew;
		setFocus()
	} else {
		var is_selection_flag = 1;
		var userselection = document.selection.createRange();
		var txt = userselection.text;

		if (userselection==null || userselection.text==null || userselection.parentElement==null || userselection.parentElement().type!="textarea"){
			is_selection_flag = 0;
			txt = TxtFeld.value;
		}
		txtnew="";
		var symb = "";
		for (y=0;y<txt.length;y++){
			symb = translitBuchstabeLat(txt.substr(y,1));
			txtnew +=  symb;
		}
		if (is_selection_flag){
			userselection.text = txtnew; userselection.collapse(); userselection.select();
		}else{
			TxtFeld.value = txtnew;
			setFocus()
		}
	}
	return;
}
function TransliteFeld(object, evnt){
	if (language==1 || opera) return;
	if (NN6){
		var code=void 0;
		var code =  evnt.charCode; 
		var textareafontsize = 14; 
		var textreafontwidth = 7;
		if(code == 13){
			return;
		}
		if ( code && (!(evnt.ctrlKey || evnt.altKey))){
			pXpix = object.scrollTop;
			pYpix = object.scrollLeft;
        	evnt.preventDefault();
			txt=String.fromCharCode(code);
			pretxt = object.value.substring(0, object.selectionStart);
			result = transliteText(pretxt+txt);
			object.value = result+object.value.substring(object.selectionEnd);
			object.setSelectionRange(result.length,result.length);
			object.scrollTop=100000;
			object.scrollLeft=0;
				
			cXpix = (result.split("\n").length)*(textareafontsize+3);
			cYpix = (result.length-result.lastIndexOf("\n")-1)*(textreafontwidth+1);
			taXpix = (object.rows+1)*(textareafontsize+3);
			taYpix = object.clientWidth;
				
			if ((cXpix>pXpix)&&(cXpix<(pXpix+taXpix))) object.scrollTop=pXpix;
			if (cXpix<=pXpix) object.scrollTop=cXpix-(textareafontsize+3);
			if (cXpix>=(pXpix+taXpix)) object.scrollTop=cXpix-taXpix;
				
			if ((cYpix>=pYpix)&&(cYpix<(pYpix+taYpix))) object.scrollLeft=pYpix;
			if (cYpix<pYpix) object.scrollLeft=cYpix-(textreafontwidth+1);
			if (cYpix>=(pYpix+taYpix)) object.scrollLeft=cYpix-taYpix+1;
		}
		return true;
	} else if (IE){
		if (isChat){
			var code = frames['input'].event.keyCode;
			if(code == 13){
				return;
			}
			txt=String.fromCharCode(code);
			cursor_pos_selection = frames['input'].document.selection.createRange();
			cursor_pos_selection.text="";
			cursor_pos_selection.moveStart("character",-1);
			vorTxt = cursor_pos_selection.text;
			if (vorTxt.length>1){
				vorTxt="";
			}
			frames['input'].event.keyCode = 0;
			if (richtung==2){
				result = vorTxt+translitBuchstabeLat(txt)
			}else{
				result = translitBuchstabeCyr(vorTxt,txt)
			}
			if (vorTxt!=""){
				cursor_pos_selection.select(); cursor_pos_selection.collapse();
			}
			with(frames['input'].document.selection.createRange()){
				text = result; collapse(); select()
			}	
		} else {
			var code = event.keyCode;
			if(code == 13){
				return;
			}
			txt=String.fromCharCode(code);
			cursor_pos_selection = document.selection.createRange();
			cursor_pos_selection.text="";
			cursor_pos_selection.moveStart("character",-1);
			vorTxt = cursor_pos_selection.text;
			if (vorTxt.length>1){
				vorTxt="";
			}
			event.keyCode = 0;
			if (richtung==2){
				result = vorTxt+translitBuchstabeLat(txt)
			}else{
				result = translitBuchstabeCyr(vorTxt,txt)
			}
			if (vorTxt!=""){
				cursor_pos_selection.select(); cursor_pos_selection.collapse();
			}
			with(document.selection.createRange()){
				text = result; collapse(); select()
			}	
		}
		return;
   }
}
function translateAlltoCyrillic(){
	if (!IE){
		txt = TxtFeld.value;
		var txtnew = translitBuchstabeCyr("",txt.substr(0,1));
		var symb = "";
		for (kk=1;kk<txt.length;kk++){
			symb = translitBuchstabeCyr(txtnew.substr(txtnew.length-1,1),txt.substr(kk,1));
			txtnew = txtnew.substr(0,txtnew.length-1) + symb;
		}
		TxtFeld.value = txtnew;
		setFocus()
	}else{
		var is_selection_flag = 1;
		var userselection = document.selection.createRange();
		var txt = userselection.text;
		if (userselection==null || userselection.text==null || userselection.parentElement==null || userselection.parentElement().type!="textarea"){
			is_selection_flag = 0;
			txt = TxtFeld.value;
		}
		var txtnew = translitBuchstabeCyr("",txt.substr(0,1));
		var symb = "";
		for (kk=1;kk<txt.length;kk++){
			symb = translitBuchstabeCyr(txtnew.substr(txtnew.length-1,1),txt.substr(kk,1));
			txtnew = txtnew.substr(0,txtnew.length-1) + symb;
		}
		if (is_selection_flag){
			userselection.text = txtnew; userselection.collapse(); userselection.select();
		}else{
			TxtFeld.value = txtnew;
			setFocus()
		}
	}
	return;
}
</script><table style="width:100%;background:none;border:0;"><tr><td style="background:none;width:98%;border:0;">
<textarea class="editorinput" id="area" name="<?php echo $name;?>" style='border:0;width:100%;background:none;' cols="65" rows="10" OnKeyPress="TransliteFeld(this, event)" OnSelect="FieldName(this, this.name)" OnClick="FieldName(this, this.name)" OnKeyUp="FieldName(this, this.name)"><?php echo $content;?></textarea></td></tr><tr>
<td style="background:#DCDCDC;width:98%;border:0;border-radius:5px;"><table style="background:none;border:0;"><div class="editor" style="width:100%;background:none;border:0;">
<div class="editorbutton" OnClick="InsertCode('b')"><img title="Жирный текст" src="pic/editor/bold.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('i')"><img title="Наклонный текст" src="pic/editor/italic.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('u')"><img title="Подчеркнутый текст" src="pic/editor/underline.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('s')"><img title="Перечеркнутый текст" src="pic/editor/striket.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('li')"><img title="Маркированный список" src="pic/editor/li.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('hr')"><img title="Разделительная линия" src="pic/editor/hr.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('left')"><img title="Выравнивание по левому краю" src="pic/editor/left.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('center')"><img title="Выравнивание по центру" src="pic/editor/center.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('right')"><img title="Выравнивание по правому краю" src="pic/editor/right.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('justify')"><img title="Выравнивание по ширине" src="pic/editor/justify.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('code')"><img title="Код" src="pic/editor/code.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('php')"><img title="PHP-Код" src="pic/editor/php.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('spoiler')"><img title="Скрытое содержимое" src="pic/editor/spoiler.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('url','Введите полный адрес','Введите описание','Вы не указали адрес!')"><img title="Вставить ссылку" src="pic/editor/url.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('mail','Введите полный адрес','Введите описание','Вы не указали адрес!')"><img title="Вставить E-Mail" src="pic/editor/mail.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('imdb')"><img title="imdb" src="pic/editor/imdb.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('kp')"><img title="КиноПоиск" src="pic/editor/kp.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('img')"><img title="Вставить картинку" src="pic/editor/img.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('quote')"><img title="Цитировать" src="pic/editor/quote.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('youtube')"><img title="Вставить видеоролик с YouTube" src="pic/editor/youtube.gif"/></div>
<div class="editorbutton" OnClick="InsertCode('rutube')"><img title="Вставить видеоролик с RuTube. Берем только номер для вставки между кодами" src="pic/editor/rutube.gif"/></div>
<div class="editorbutton" OnClick="translateAlltoCyrillic()"><img title="Перевод текста с латиницы в кириллицу" src="pic/editor/rus.gif"/></div>
<div class="editorbutton" OnClick="translateAlltoLatin()"><img title="Перевод текста с кириллицы в латиницу" src="pic/editor/eng.gif"/></div>
<div class="editorbutton" OnClick="changelanguage()"><img title="Автоматический перевод текста" src="pic/editor/auto.gif"/></div>
<div class="editorbutton"><select class="editorinput" tabindex="1" style="font-size:10px;background:white;font-weight:bold;" name="family" onChange="InsertCode('family',this.options[this.selectedIndex].value)">
<option style="font-family:Verdana;background:white;font-weight:bold;" value="Verdana">Verdana</option>
<option style="font-family:Arial;background:white;font-weight:bold;" value="Arial">Arial</option>
<option style="font-family:Courier New;background:white;font-weight:bold;" value="Courier New">Courier New</option>
<option style="font-family:Tahoma;background:white;font-weight:bold;" value="Tahoma">Tahoma</option>
<option style="font-family:Helvetica;background:white;font-weight:bold;" value="Helvetica">Helvetica</option></select></div>
<div class="editorbutton"><select class="editorinput" tabindex="1" style="font-size:10px;background:white;font-weight:bold;" name="color" onChange="InsertCode('color',this.options[this.selectedIndex].value)">
<option style="color:black;background:white;font-weight:bold;" value="black">Цвет</option><option style="color:silver;background:white;font-weight:bold;" value="silver">Цвет</option>
<option style="color:gray;background:white;font-weight:bold;" value="gray">Цвет</option><option style="color:white;background:black;font-weight:bold;" value="white">Цвет</option>
<option style="color:maroon;background:white;font-weight:bold;" value="maroon">Цвет</option><option style="color:red;background:white;font-weight:bold;" value="red">Цвет</option>
<option style="color:purple;background:white;font-weight:bold;" value="purple">Цвет</option><option style="color:fuchsia;background:white;font-weight:bold;" value="fuchsia">Цвет</option>
<option style="color:green;background:white;font-weight:bold;" value="green">Цвет</option><option style="color:lime;background:white;font-weight:bold;" value="lime">Цвет</option>
<option style="color:olive;background:white;font-weight:bold;" value="olive">Цвет</option><option style="color:yellow;background:white;font-weight:bold;" value="yellow">Цвет</option>
<option style="color:navy;background:white;font-weight:bold;" value="navy">Цвет</option><option style="color:blue;background:white;font-weight:bold;" value="blue">Цвет</option>
<option style="color:teal;background:white;font-weight:bold;" value="teal">Цвет</option><option style="color:aqua;background:white;font-weight:bold;" value="aqua">Цвет</option></select></div>
<div class="editorbutton"><select class="editorinput" tabindex="1" style="font-size:10px;background:white;font-weight:bold;" name="size" onChange="InsertCode('size',this.options[this.selectedIndex].value)">
<option value="8">Размер 8</option><option value="10">Размер 10</option><option value="12">Размер 12</option><option value="14">Размер 14</option>
<option value="18">Размер 18</option><option value="24">Размер 24</option></select></div>
<div class="editorbutton" OnClick="InsertCode('th')"><b title="Уменьшить огромную картинку до 360px по высоте">[th]</b></div></div></table></td></tr></table><?}
/////////////////////////////////////////////////////////
function get_row_count($table, $suffix = ""){if($suffix)$suffix = " $suffix";($r = mysql_query("SELECT COUNT(*) FROM $table$suffix")) or die(mysql_error());
($a = mysql_fetch_row($r)) or die(mysql_error());return $a[0];}
/////////////////////////////////////////
function stdmsg($heading = '', $text = '', $div = 'success', $htmlstrip = false){
if($htmlstrip){$heading = htmlspecialchars_uni(trim($heading));$text = htmlspecialchars_uni(trim($text));}
print("<table class='main' width='100%' border='0' cellpadding='0' cellspacing='0'><tr><td class='embedded'>
<div class='$div'>".($heading ? "<b>$heading</b><br>" : "")."$text</div></td></tr></table>\n");}
////////////////////////////
function stderr($heading = '', $text = ''){global $CURUSER;stdhead();?>
<div style="display:yes;position:fixed;margin-top:200px;margin-left:470px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr><td align="center"><div style="padding:5px"><center><b style="color:#A52A2A"><?=$heading?></b>
</center></div></td></tr><tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:center;">  
<div style="padding-left:2px" align="center"><center><?=stdmsg($text)?></center></div></td></tr></table></div><?stdfoot();die;}
///////////////////////
function stderr2($heading = '', $text = ''){stdhead();begin_frame(".:: Error ::.");stdmsg($text);end_frame();stdfoot();die;}
//////////////////
function stderrs($heading = '', $text = ''){global $CURUSER;stdhead();?>
<div style="display:yes;position:fixed;margin-top:10px;margin-left:470px;border:1px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#e0e0e0;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<table cellpadding="0" cellspacing="0" border="0" width="400px" height="200px"><tr><td align="center"><div style="padding:5px"><center><b style="color:#A52A2A"><?=$heading?></b>
</center></div></td></tr><tr><td align="center" width="100%" style="padding-left:4px;padding-bottom:2px;text-align:center;">  
<div style="padding-left:2px" align="center"><center><?=stdmsg($text)?></center></div></td></tr></table></div><?stdfoot();die;}
////////////////////////
function newerr($heading = '', $text = '', $head = true, $foot = true, $die = true, $div = 'error', $htmlstrip = true){
if($head)stdhead($heading);newmsg($heading, $text, $div, $htmlstrip);if($foot)stdfoot();if($die)die;}
/////////////////
function sqlerr($file = '', $line = ''){global $queries;stdhead();begin_frame(".:: Ошибка в SQL ::.");
print("<b style='color:#A52A2A'>Ответ от сервера MySQL: ".htmlspecialchars_uni(mysql_error()).($file != '' && $line != '' ? "<p>в $file, линия $line</p>" : "")." Запрос номер 
$queries.</b><hr width='50%'>");end_frame();stdfoot();die;}
// Returns the current time in GMT in MySQL compatible format.
function get_date_time($timestamp = 0){if($timestamp)return date("Y-m-d H:i:s", $timestamp);else return date("Y-m-d H:i:s");}
///////////////////
function encodehtml($s, $linebreaks = true){$s = str_replace("<", "&lt;", str_replace("&", "&amp;", $s));if($linebreaks)$s = nl2br($s);return $s;}
//////////////////
function get_dt_num(){return date("YmdHis");}
///////////////////
function format_urls($s){return preg_replace("/(\A|[^=\]'\"a-zA-Zа-яА-ЯёЁ0-9])((http|ftp|https|ftps|irc):\/\/[^()<>\s]+)/i","\\1<a href='\\2'>\\2</a>", $s);}
///////////////////////in PHP5 use strripos() instead of this
function _strlastpos($haystack, $needle, $offset = 0){$addLen = strlen($needle);$endPos = $offset - $addLen;
while(true){if(($newPos = strpos($haystack, $needle, $endPos + $addLen)) === false) break;$endPos = $newPos;}return ($endPos >= 0) ? $endPos : false;}
/////////////////////////////////
function format_quotes($s){while($old_s != $s){$old_s = $s;
$close = strpos($s, "[/quote]");if($close === false)return $s;
$open = _strlastpos(substr($s, 0, $close), "[quote");if($open === false)return $s;$quote = substr($s, $open, $close - $open + 8);
$quote = preg_replace("/\[quote\]\s*((\s|.)+?)\s*\[\/quote\]\s*/i","<p class=sub><b>Quote:</b></p>
<table class='main' border='1' cellspacing='0' cellpadding='10'><tr><td style='border:1px black dotted'>\\1</td></tr></table><br>",$quote);
$quote = preg_replace("/\[quote=(.+?)\]\s*((\s|.)+?)\s*\[\/quote\]\s*/i","<p class=sub><b>\\1 wrote:</b></p>
<table class='main' border='1' cellspacing='0' cellpadding='10'><tr><td style='border:1px black dotted'>\\2</td></tr></table><br>",$quote);
$s = substr($s, 0, $open).$quote.substr($s, $close + 8);}return $s;}
///////////////////////
function encode_quote($text){
$start_html = "<div align='left' style='width:85%;overflow:auto;'>
<table style='float:left;width:avto;background:none;padding-left:5px;margin-top:7px;padding-right:15px;border:0;'><tr><td style='background:none;border:0;width:100%;'>
<table style='background:none;width:100%;float:left;border:0;'><tr>
<td class='zaliwka' style='font-weight:bold;font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:left;border:0;border-radius:5px;width:200px;'>&nbsp;&nbsp;&nbsp;&nbsp;
Цитата</td><td style='background:none;border:0;'></td></tr></table></td></tr><tr>
<td style='float:left;border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #4682B4;display:block;' class='a'>";
$end_html = "</td></tr></table></div>";$text = preg_replace("#\[quote\](.*?)\[/quote\]#si", "".$start_html."\\1".$end_html."", $text);return $text;}
//////////////////////////
function encode_quote_from($text){
$start_html = "<div align='left' style='width:85%;overflow:auto;'>
<table style='float:left;width:avto;background:none;padding-left:5px;margin-top:7px;padding-right:15px;border:0;'><tr><td style='background:none;border:0;width:100%;'>
<table style='background:none;width:100%;float:left;border:0;'><tr>
<td class='zaliwka' style='font-weight:bold;font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:left;border:0;border-radius:5px;width:200px;'>&nbsp;&nbsp;&nbsp;&nbsp;
\\1 писал</td><td style='background:none;border:0;'></td></tr></table></td></tr><tr>
<td style='float:left;border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #4682B4;display:block;' class='a'>";
$end_html = "</td></tr></table></div>";$text = preg_replace("#\[quote=(.+?)\](.*?)\[/quote\]#si", "".$start_html."\\2".$end_html."", $text);return $text;}
////////////////////////
function encode_quotes($text){
$start_html = "<div align='center'><div style='width:85%;overflow:auto;'><table width='100%' cellspacing='1' cellpadding='3' border='0' align='center' class='bgcolor4'>
<tr bgcolor='#A9A9A9'><td class='block-title'>Цитата</td></tr><tr class='bgcolor1'><td>";
$end_html = "</td></tr></table></div></div>";$text = preg_replace("#\[quotes\](.*?)\[/quotes\]#si", "".$start_html."\\1".$end_html."", $text);return $text;}
/////////////////////////
function encode_quotes_from($text){
$start_html = "<div align='center'><div style='width:85%;overflow:auto;'><table width='100%' cellspacing='1' cellpadding='3' border='0' align='center' class='bgcolor4'>
<tr bgcolor='#A9A9A9'><td class='block-title'>\\1 писал</td></tr><tr class='bgcolor1'><td>";
$end_html = "</td></tr></table></div></div>";$text = preg_replace("#\[quotes=(.+?)\](.*?)\[/quotes\]#si", "".$start_html."\\2".$end_html."", $text);return $text;}
////////////////////
function encode_code($text){
$start_html = "<div align='left' style='width:85%;overflow:auto;'><table style='float:left;width:avto;background:none;padding-left:5px;margin-top:7px;padding-right:15px;border:0;'>
<tr><td style='background:none;border:0;width:100%;'><table style='background:none;width:100%;float:left;border:0;'><tr>
<td style='background:black;font-weight:bold;font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:left;border:0;border-radius:5px;width:80px;'>&nbsp;&nbsp;&nbsp;&nbsp;
Код</td><td style='background:none;border:0;'></td></tr></table></td></tr><tr>
<td style='float:left;border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid black;display:block;' class='a'>
<code style='pointer-events:none;color:black;'>";
$end_html = "</code></td></tr></table></div>";
$match_count = preg_match_all("#\[code\](.*?)\[/code\]#si", $text, $matches);
for($mout = 0; $mout < $match_count; ++$mout){
$before_replace = $matches[1][$mout];$after_replace = $matches[1][$mout];$after_replace = trim($after_replace);$zeilen_array = explode("<br>", $after_replace);$j = 1;$zeilen = "";
foreach($zeilen_array as $str){$zeilen .= "".$j."<br>";++$j;}
$after_replace = str_replace("", "", $after_replace);$after_replace = str_replace("&amp;", "&", $after_replace);$after_replace = str_replace("", "&nbsp; ", $after_replace);
$after_replace = str_replace("", " &nbsp;", $after_replace);$after_replace = str_replace("", "&nbsp; &nbsp;", $after_replace);
$after_replace = preg_replace("/^ {1}/m", "&nbsp;", $after_replace);$str_to_match = "[code]".$before_replace."[/code]";$replace = str_replace("{ZEILEN}", $zeilen, $start_html);
$replace .= $after_replace;$replace .= $end_html;$text = str_replace($str_to_match, $replace, $text);}
$text = str_replace("[code]", $start_html, $text);$text = str_replace("[/code]", $end_html, $text);return $text;}
///////////////////////////////
function encode_php($text){
$start_html = "<div align='left' style='width:85%;overflow:auto;'><table style='float:left;width:avto;background:none;padding-left:5px;margin-top:7px;padding-right:15px;border:0;'>
<tr><td style='background:none;border:0;width:100%;'><table style='background:none;width:100%;float:left;border:0;'><tr>
<td style='background:darkred;font-weight:bold;font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:left;border:0;border-radius:5px;width:100px;'>&nbsp;&nbsp;&nbsp;&nbsp;
PHP - Код</td><td style='background:none;border:0;'></td></tr></table></td></tr><tr>
<td style='float:left;border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid darkred;display:block;' class='a'>
<code style='pointer-events:none;'>";
$end_html = "</code></td></tr></table></div>";
$match_count = preg_match_all("#\[php\](.*?)\[/php\]#si", $text, $matches);
for($mout = 0; $mout < $match_count; ++$mout){
$before_replace = $matches[1][$mout];$after_replace = $matches[1][$mout];$after_replace = trim($after_replace);$after_replace = str_replace("&amp;", "&", $after_replace);
$after_replace = str_replace("&lt;", "<", $after_replace);$after_replace = str_replace("&gt;", ">", $after_replace);$after_replace = str_replace("&quot;", '"', $after_replace);
$after_replace = preg_replace("/<br.*/i", "", $after_replace);$after_replace = (substr($after_replace, 0, 5) != "<?php") ? "<?php\n\n".$after_replace."" : "".$after_replace."";
$after_replace = (substr($after_replace, -2) != "?>") ? "".$after_replace."\n\n?>" : "".$after_replace."";
ob_start();highlight_string($after_replace);$after_replace = ob_get_contents();ob_end_clean();$zeilen_array = explode("<br>", $after_replace);$j = 1;$zeilen = "";
foreach($zeilen_array as $str){$zeilen .= "" . $j . "<br>";++$j;}$after_replace = str_replace("\n", "", $after_replace);$after_replace = str_replace("&amp;", "&", $after_replace);
$after_replace = str_replace("  ", "&nbsp; ", $after_replace);$after_replace = str_replace("  ", " &nbsp;", $after_replace);
$after_replace = str_replace("\t", "&nbsp; &nbsp;", $after_replace);$after_replace = str_replace("&", "&", $after_replace);
$after_replace = preg_replace("/^ {1}/m", "&nbsp;", $after_replace);$str_to_match = "[php]".$before_replace."[/php]";$replace = str_replace("{ZEILEN}", $zeilen, $start_html);
$replace .= $after_replace;$replace .= $end_html;$text = str_replace($str_to_match, $replace, $text);}$text = str_replace("[php]", $start_html, $text);
$text = str_replace("[/php]", $end_html, $text);return $text;}
//////////////////
function code_nobb($matches){$code = $matches[1];$code = str_replace("[", "&#91;", $code);$code = str_replace("]", "&#93;", $code);return '[code]'.$code.'[/code]';}
////////////////////////////
function format_comment($text, $strip_html = true){global $smilies, $smilies2, $privatesmilies, $pic_base_url, $DEFAULTBASEURL;
$smiliese = $smilies;$smiliese2 = $smilies2;$s = $text;$s = str_replace(";)", ":wink:", $s);
$badwords=array("хуй","хрен","блять","блядь","бладь","бляд","пизда","пиздец","пизду","хуйня","сука","гандон","гондонище","гандонище","пидар","пидарас","пидор","пидорас","мудак",
"конченый","гондон","сцука","ссука","сука","сцуко","импотент","гондурас","блябля","блядище","дыбил","дибил","децил","дэцел","дэцил","дебил","сучара","дрочи","дрочить","дрочка",
"ебаный","ебанный","ебанько","ибаный","ибанный","ибанько","ёбаный","ёбан","ебан","уебан","уебанище","уёбок","уйобок","уйобище","уйо","стрампон","фалос","ебу","ёбу","йобу",
"пидарасище","хуйло","еблан","ебло","йаебу","яебу","ояебу","pizda","suka","scuko","пиzда","hуй","huy");
$s = str_replace($badwords,"пи",$s);
////////////////////////////////////////
$s = preg_replace_callback("#\[code\](.*?)\[/code\]#si", "code_nobb", $s);if($strip_html)$s = htmlspecialchars_uni($s);
$bb[] = "#\[img\](?!javascript:)([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#i";
$html[] = "<img class='linked-image' src='\\1' border='0' alt='\\1' title='\\1'/>";
$bb[] = "#\[img=([a-zA-Z]+)\](?!javascript:)([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
$html[] = "<img class='linked-image' src='\\2' align='\\1' border='0' alt='\\2' title='\\2'/>";
$bb[] = "#\[img\ alt=([a-zA-Zа-яА-Я0-9\_\-\. ]+)\](?!javascript:)([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
$html[] = "<img class='linked-image' src='\\2' align='\\1' border='0' alt='\\1' title='\\1'/>";
$bb[] = "#\[img=([a-zA-Z]+) alt=([a-zA-Zа-яА-Я0-9\_\-\. ]+)\](?!javascript:)([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
$html[] = "<img class='linked-image' src='\\3' align='\\1' border='0' alt='\\2' title='\\2'/>";	
$bb[] = "#\[kp\](.*?)\[/kp\]#si"; 
$html[] = '<a target="_blank" href="https://www.kinopoisk.ru/level/1/film/\\1" title="Кинопоиск"><img src="'.$DEFAULTBASEURL.'/torrents/kinopoisk/\\1.gif" border="0" alt="Кинопоиск" title="Кинопоиск"/></a>';
$bb[] = "#\[imdb\](.*?)\[/imdb\]#i";
$html[] = '<a target="_blank" href="https://www.imdb.com/title/\\1"><img src="'.$DEFAULTBASEURL.'/torrents/imdb/\\1.png" border="0" alt="IMDb" title="IMDb"/></a>';
$bb[] = "#\[url\]([\w]+?://([\w\#$%&~/.\-;:=,?@\]+]+|\[(?!url=))*?)\[/url\]#is";
$html[] = "<a href='\\1' title='\\1'>\\2</a>";
$bb[] = "#\[url=([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is";
$html[] = "<a href='\\1' title='\\1'>\\2</a>";
$bb[] = "#\[mail\](\S+?)\[/mail\]#i";
$html[] = "<a href='mailto:\\1'>\\1</a>";
$bb[] = "#\[mail\s*=\s*([\.\w\-]+\@[\.\w\-]+\.[\w\-]+)\s*\](.*?)\[\/mail\]#i";
$html[] = "<a href='mailto:\\1'>\\2</a>";
$bb[] = "#\[color=(\#[0-9A-F]{6}|[a-z]+)\](.*?)\[/color\]#si";
$html[] = "<span style='color: \\1'>\\2</span>";
$bb[] = "#\[(font|family)=([A-Za-z ]+)\](.*?)\[/\\1\]#si";
$html[] = "<span style='font-family: \\2'>\\3</span>";
$bb[] = "#\[size=([0-9]+)\](.*?)\[/size\]#si";
$html[] = "<span style='font-size: \\1px'>\\2</span>";
$bb[] = "#\[(left|right|center|justify)\](.*?)\[/\\1\]#is";
$html[] = "<div align='\\1'>\\2</div>";
$bb[] = "#\[b\](.*?)\[/b\]#si";
$html[] = "<b>\\1</b>";
$bb[] = "#\[i\](.*?)\[/i\]#si";
$html[] = "<i>\\1</i>";
$bb[] = "#\[u\](.*?)\[/u\]#si";
$html[] = "<u>\\1</u>";
$bb[] = "#\[s\](.*?)\[/s\]#si";
$html[] = "<s>\\1</s>";
$bb[] = "#\[li\]#si";
$html[] = "<li>";
$bb[] = "#\[hr\]#si";
$html[] = "<hr>";
$bb[] = "#\[youtube=([[:alnum:]]+)\]#si";
$html[] = '<iframe width="640" height="360" src="https://www.youtube.com/embed/\\1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
$bb[] = "#\[rutube=([[:alnum:]]+)\]#si";
$html[] = '<iframe width="640" height="480" src="https://rutube.ru/play/embed/\\1" frameBorder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
$bb[] = "#\[th\](?!javascript:)([^?](?:[^\[]+|\[(?!url))*?)\[/th\]#i";
$html[] = "<a href='\\1' class='highslide' onclick='return hs.expand(this)'><img style='margin: 2px 2px 0 0;width:360px;' src='\\1' border='0' alt='\\1' title='\\1'/></a>";
$s = preg_replace($bb, $html, $s);$s = nl2br($s);$s = format_urls($s);
foreach ($smiliese as $code => $url)$s = str_replace($code, "<img border='0' src='pic/smilies1/$url'/>", $s);
foreach ($smiliese2 as $code => $url)$s = str_replace($code, "<img border='0' src='pic/smilies/$url'/>", $s);					 
foreach ($privatesmilies as $code => $url)$s = str_replace($code, "<img border='0' src='pic/smilies1/$url'/>", $s);
/////////////////////////////////Tag [youtube][/youtube]
while (preg_match("/\[youtube\]((\s|.)+?)\[\/youtube\]/i", $s)){
$s = preg_replace ("/\[youtube\]((\s|.)+?)\[\/youtube\]/i", "<object width='640' height='360'><param name=movie value='https://www.youtube.com/embed/\\1'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='https://www.youtube.com/embed/\\1' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='640' height='360'></embed></object>", $s);}
/////////////////////////////////Tag [rutube][/rutube]
while (preg_match("/\[rutube\]((\s|.)+?)\[\/rutube\]/i", $s)){
$s = preg_replace ("/\[rutube\]((\s|.)+?)\[\/rutube\]/i", "<object width='640' height='360'><param name=movie value='https://rutube.ru/play/embed/\\1'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='https://rutube.ru/play/embed/\\1' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='640' height='360'></embed></object>", $s);}
///////////////////////////////
while (preg_match("#\[quote\](.*?)\[/quote\]#si", $s)) $s = encode_quote($s);
while (preg_match("#\[quote=(.+?)\](.*?)\[/quote\]#si", $s)) $s = encode_quote_from($s);
while (preg_match("#\[quotes\](.*?)\[/quotes\]#si", $s)) $s = encode_quotes($s);
while (preg_match("#\[quotes=(.+?)\](.*?)\[/quotes\]#si", $s)) $s = encode_quotes_from($s);
if(preg_match("#\[code\](.*?)\[/code\]#si", $s)) $s = encode_code($s);
if(preg_match("#\[php\](.*?)\[/php\]#si", $s)) $s = encode_php($s);
while (preg_match("#\[spoiler=((\s|.)+?)\]((\s|.)+?)\[/spoiler\]#is", $s)){$q = time().mt_rand(1, 1024);
$s = preg_replace("/\[spoiler=((\s|.)+?)\]((\s|.)+?)\[\/spoiler\]/i", "<details class='desc'><summary data-open='Свернуть' data-close='\\1'></summary><div class='spoiler'>\\3</div></details>", $s, 1);}
$s = format_urls($s);
foreach ($smiliese as $code => $url)$s = str_replace($code, "<img border='0' src='pic/smilies1/$url' alt='".htmlspecialchars_uni($code)."'/>", $s);
foreach ($smiliese2 as $code => $url)$s = str_replace($code, "<img border='0' src='pic/smilies/$url' alt='".htmlspecialchars_uni($code)."'/>", $s);	
foreach ($privatesmilies as $code => $url) $s = str_replace($code, "<img border='0' src='pic/smilies1/$url'/>", $s);return $s;}
///////////////////
function get_user_class(){global $CURUSER;return $CURUSER["class"];}
////////////////
function get_user_class_name($class){global $tracker_lang;switch($class){
case UC_USER: return $tracker_lang['class_user'];
case UC_720p: return $tracker_lang['class_720p'];
case UC_1080i: return $tracker_lang['class_1080i'];
case UC_1080p: return $tracker_lang['class_1080p'];
case UC_UHD: return $tracker_lang['class_uhd'];
case UC_VIPS: return $tracker_lang['class_vips'];
case UC_UPLOADER: return $tracker_lang['class_uploader'];
case UC_VIP: return $tracker_lang['class_vip'];
case UC_MODERATOR: return $tracker_lang['class_moderator'];
case UC_ADMINISTRATOR: return $tracker_lang['class_administrator'];
case UC_SYSOP: return $tracker_lang['class_sysop'];
case UC_VLADELEC: return $tracker_lang['class_vladelec'];}return "";}
///////////////////
function is_valid_user_class($class){return is_numeric($class) && floor($class) == $class && $class >= UC_USER && $class <= UC_VLADELEC;}
///////// функция для проверки ответа в моде группы ////////////
function int_check($value, $stdhead = false, $stdfood = true, $die = true, $log = true){global $CURUSER;
$msg = "Invalid ID Attempt: Username: ".$CURUSER["username"]." - UserID: ".$CURUSER["id"]." - UserIP : ".getip();
if(is_array($value)){foreach ($value as $val) int_check($val);}else{if(!is_valid_id($value)){if($stdhead){if($log)write_log($msg);
stderr("ERROR", "Invalid ID! For security reason, we have been logged this action.");
}else{print("<h2>Error</h2><table width='100%' border='1' cellspacing='0' cellpadding='10'><tr><td class='text'>
Invalid ID! For security reason, we have been logged this action.</td></tr></table>");if($log)write_log($msg);}if($stdfood)stdfoot();
if($die)die;}else return true;}}
////////////////////////////
function is_valid_id($id){return is_numeric($id) && ($id > 0) && (floor($id) == $id);}
///////////////////////////
function sql_ts_to_ut($s){return sql_timestamp_to_unix_timestamp($s);}
////////////////////////////
function sql_timestamp_to_unix_timestamp($s){return mktime(substr($s, 11, 2), substr($s, 14, 2), substr($s, 17, 2), substr($s, 5, 2), substr($s, 8, 2), substr($s, 0, 4));}
/////////////////////////////////////
function get_ratio_color($ratio){if($ratio < 0.1) return "#ff0000";if($ratio < 0.2) return "#ee0000";if($ratio < 0.3) return "#dd0000";
if($ratio < 0.4) return "#cc0000";if($ratio < 0.5) return "#bb0000";if($ratio < 0.6) return "#aa0000";if($ratio < 0.7) return "#990000";
if($ratio < 0.8) return "#880000";if($ratio < 0.9) return "#770000";if($ratio < 1) return "#660000";return "#000000";}
////////////////////////////////
function get_slr_color($ratio){if($ratio < 0.025) return "#ff0000";if($ratio < 0.05) return "#ee0000";if($ratio < 0.075) return "#dd0000";
if($ratio < 0.1) return "#cc0000";if($ratio < 0.125) return "#bb0000";if($ratio < 0.15) return "#aa0000";if($ratio < 0.175) return "#990000";
if($ratio < 0.2) return "#880000";if($ratio < 0.225) return "#770000";if($ratio < 0.25) return "#660000";if($ratio < 0.275) return "#550000";
if($ratio < 0.3) return "#440000";if($ratio < 0.325) return "#330000";if($ratio < 0.35) return "#220000";if($ratio < 0.375) return "#110000";return "";}
////////////////////////////////////
function write_log($text, $color = "transparent", $type = "tracker"){$type = sqlesc($type);$color = sqlesc($color);$text = sqlesc($text);
$added = sqlesc(get_date_time());mysql_query("INSERT INTO sitelog (added, color, txt, type) VALUES($added, $color, $text, $type)");}
///////////////////////////////////////////
function check_banned_emails($email){$expl = explode("@", $email);$wildemail = "*@".$expl[1]; 
$res = mysql_query("SELECT id FROM bannedemails WHERE email = ".sqlesc($email)." OR email = ".sqlesc($wildemail)."") or sqlerr(__FILE__, __LINE__); 
if (!$arr = mysql_fetch_assoc($res))stderr("Error!","<center>E-mail address banned!<br><br><strong>Reason</strong>: Only mail is allowed gmail.com</center>
<html><head><meta http-equiv=refresh content='10;url=/'></head></html>", false);}
////////////////////////////////////////
function getWord($number, $suffix){$keys = array(2, 0, 1, 1, 1, 2);$mod = $number % 100;$suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
return $suffix[$suffix_key];}
//////////////////////////////////
function get_et($ts){return get_elapsed_time_plural($ts);}
//////////////////////////////////////
function get_elapsed_time_plural($time_start, $decimals = 0){$divider['years'] = (60 * 60 * 24 * 365);$divider['months'] = (60 * 60 * 24 * 365 / 12);
$divider['weeks'] = (60 * 60 * 24 * 7);$divider['days'] = (60 * 60 * 24);$divider['hours'] = (60 * 60);$divider['minutes'] = (60);
$langs['years'] = array("год", "года", "лет");$langs['months'] = array("месяц", "месяца", "месяцев");$langs['weeks'] = array("неделю", "недели", "недель");
$langs['days'] = array("день", "дня", "дней");$langs['hours'] = array("час", "часа", "часов");$langs['minutes'] = array("минуту", "минуты", "минут");
foreach($divider as $unit => $div){${'elapsed_time_'.$unit} = floor(((TIMENOW - $time_start) / $div));if(${'elapsed_time_'.$unit} >= 1)break;}
$elapsed_time = ${'elapsed_time_'.$unit}.' '.getWord(${'elapsed_time_'.$unit}, $langs[$unit]);return $elapsed_time;}
///////////////////////////////////
function get_elapsed_time($ts){$mins = floor((time() - $ts) / 60);$hours = floor($mins / 60);
$mins -= $hours * 60;$days = floor($hours / 24);$hours -= $days * 24;$weeks = floor($days / 7);$days -= $weeks * 7;$t = "";
if($weeks > 0)return "$weeks недел".($weeks > 4 ? "ь" : "я");if($days > 0)return "$days д".($days > 1 ? "ней" : "ень");
if($hours > 0)return "$hours час".($hours > 1 ? "ов" : "");if($mins > 0)return "$mins минут".($mins > 1 ? "" : "а");return "< 1 минуты";}
//////////////////////////////////////
function get_user_rgbcolor($class, $username){global $tracker_lang;switch ($username){case 'Shoky': return "808000";break;case 'Тя': return "808000";break;}
switch ($class){case UC_VLADELEC: return "#808000";break;case UC_SYSOP: return "#0F6CEE";break;case UC_ADMINISTRATOR: return "#339900";break;
case UC_MODERATOR: return "red";break;case UC_VIP: return "#9C2FE0";break;case UC_UPLOADER: return "#FF9900";break;
case UC_VIPS: return "blue";break;case UC_UHD: return "#6A5ACD";break;case UC_1080p: return "Indigo";break;
case UC_1080i: return "#D21E36";break;case UC_720p: return "black";break;case UC_USER: return "gray";break;}return $username;}
///////////////////////
function ajaxerr($text, $width="135"){print("<div id='ajaxerror' style='width:".$width."px;'>$text</div>\n");return;}
/////////////////////
function ajaxsucc($text, $width="135"){print("<div id=ajaxsuccess style='width:".$width."px;'>$text</div>\n");return;}  
//////////////////
function get_user_class_group($class){if($class == 1) return 'Участник';elseif($class == 2) return 'VIP';elseif($class == 3) return 'Модератор';
elseif($class == 4) return 'Администратор';elseif($class == 5) return 'Создатель';else return 'n\a';}
/////////////////////////////////////
function get_classes_group(){$classes = array();$classes['user'] = 1;$classes['vip'] = 2;$classes['moder'] = 3;$classes['admin'] = 4;
$classes['creator'] = 5;return $classes;}
////////////////////////////////////
function dltable($name, $arr, $torrent){global $CURUSER, $tracker_lang;if(!count($arr)) return $s;
$s .= "<table width='100%' class='main' border='1' cellspacing='0' cellpadding='5'><tr>
<td class='zaliwka' align='center' style='color:#FFFFFF;font-weight:bold;'>".$tracker_lang['user']."</td>
<td class='zaliwka' align='center' style='width:40px;color:#FFFFFF;font-weight:bold;'>".$tracker_lang['port_open']."</td>
<td class='zaliwka' align='center' style='width:60px;'><img border='0' src='pic/arrowup.gif' alt='".$tracker_lang['uploaded']."' title='".$tracker_lang['uploaded']."'/></td>
<td class='zaliwka' align='center' style='width:60px;'><img border='0' src='pic/up.png' alt='Скорость заливки на сайт' title='Скорость заливки на сайт'/></td>
<td class='zaliwka' align='center' style='width:60px;'><img border='0' src='pic/arrowdown.gif' alt='".$tracker_lang['downloaded']."' title='".$tracker_lang['downloaded']."'/></td>
<td class='zaliwka' align='center' style='width:60px;'><img border='0' src='pic/down.png' alt='Скорость скачки с сайта' title='Скорость скачки с сайта'/></td>
<td class='zaliwka' align='center' style='width:50px;'><img border='0' src='pic/multitracker.png' alt='".$tracker_lang['ratio']."' title='".$tracker_lang['ratio']."'/></td>
<td class='zaliwka' align='center' style='width:50px;'><img border='0' src='pic/disk.gif' alt='".$tracker_lang['completed']."' title='".$tracker_lang['completed']."'/></td>
<td class='zaliwka' align='center' style='width:100px;color:#FFFFFF;font-weight:bold;'>".$tracker_lang['client']."</td>
<td class='zaliwka' align='center' style='width:120px;color:#FFFFFF;font-weight:bold;'>".$tracker_lang['connected']."<hr>day:hour:min:sec</td></tr>";
$now = time();foreach ($arr as $e){$s .= "<tr>";
//////////////////////////////////////
if($e["st"] > 0){$hours_seedd = "<b style='color:green'>".mkprettytime($e["st"])."</b>";
}else{$hours_seedd = "<img border='0' src='pic/nol.png' alt='Ничего не сидировал' title='Ничего не сидировал'/>";}
///////// zashita usera nachalo ///////
$mod = get_user_class() >= UC_MODERATOR;
if($e['hides']=='yes' && !$mod){$hz="<a href='LoLi' alt='LoLi'><b style='color:#008080'>LoLi</b></a>";
}else{$hz="<a href='user_".$e['userid']."'><b>".get_user_class_color($e["class"], $e["username"])."</b></a>";}
$s .= "<td align='center'>".$hz.($mod ? "&nbsp;<span title='{$e["ip"]}' style='cursor: pointer'><img src='pic/ip.png' title='{$e["ip"]}'/></span>" : "")."</td>";
///////// zashita usera konec ///////
$secs = max(10, ($e["la"]) - $e["pa"]); /// schitaem skorost ///
$s .= "<td align='center' width='40px\'>".($e[connectable] == "yes" ? "<span style='color:green;cursor:help;' title='Порт открыт. 
Этот пир может подключатся к любому пиру.'>".$tracker_lang['yes']."</span>" : "<span style='color:red;cursor:help;' title='Порт закрыт. 
Рекомендовано проверить настройки Firwewall'а.'>".$tracker_lang['no']."</span>")."</td>";  /// NAT (Port otkrit ili net) ///
$s .= "<td align='center' width='60px'><b style='color:#228B22'>".mksize($e["uploaded"])."</b></td>";  /// zalil na sayt ///
$s .= "<td align='center' width='60px'>".mksize($e["uploadoffset"] / $secs)."/s</td>";  //// skorost zalivki na sayt ///
$s .= "<td align='center' width='60px'><b style='color:#4169E1'>".mksize($e["downloaded"])."</b></td>";  /// skachal ///
$s .= "<td align='center' width='60px'>".mksize($e["downloadoffset"] / $secs)."/s</td>";  /// skorost skachki s sayta ///
///////// ратио начало ////////////
if($e["downloaded"]){$ratio = floor(($e["uploaded"] / $e["downloaded"]) * 1000) / 1000;
$s .= "<td align='center' width='50px'><b style='color:".get_ratio_color($ratio)."'>".number_format($ratio, 3, '.', '')."</b></td>";
}elseif($e["uploaded"]) $s .= "<td align='center' width='50px\'>Inf.</td>";else $s .= "<td align='center' width='50px\'>Inf.</td>";
/////////// ратио конец //////////////	
$s .= "<td align='center' width='50px'>".sprintf("%.2f%%", 100 * (1 - ($e["to_go"] / $torrent["size"])))."</td>";  /// zakonchil % ///
$s .= "<td align='center' width='100px\'>".$e["agent"]."</td>";  //// torrent-klient ///
$s .= "<td align='center' width='120px'>$hours_seedd</td></tr>";  //// vremya sidirovaniya
}$s .= "</table>\n";return $s;}
///////////////
function errs($msg){benc_resp(array("failure reason" => array(type => "string", value => $msg)));exit();}
//////// functions_global OFF ///////////////
function torrenttable($res, $variant = "index"){global $tracker_lang, $CURUSER;
if (($CURUSER["class"] < UC_VIP) && $CURUSER){$gigs = $CURUSER["uploaded"] / (1024*1024*1024);
$ratio = (($CURUSER["downloaded"] > 0) ? ($CURUSER["uploaded"] / $CURUSER["downloaded"]) : 0);
if($ratio < 0.5 || $gigs < 5) $wait = 0;elseif($ratio < 0.65 || $gigs < 6.5) $wait = 0;elseif($ratio < 0.8 || $gigs < 8) $wait = 0;
elseif($ratio < 0.95 || $gigs < 9.5) $wait = 0;else $wait = 0;}$count_get = 0;
foreach ($_GET as $get_name => $get_value) {
$get_name = mysql_real_escape_string(strip_tags(str_replace(array("\"","'"),array("",""),$get_name)));
$get_value = mysql_real_escape_string(strip_tags(str_replace(array("\"","'"),array("",""),$get_value)));
if($get_name != "sort" && $get_name != "type"){
if($count_get > 0)$oldlink = $oldlink . "&" . $get_name . "=" . $get_value;else $oldlink = $oldlink . $get_name . "=" . $get_value;$count_get++;}}
if($count_get > 0)$oldlink = $oldlink . "&";
if($_GET['sort'] == "1"){if($_GET['type'] == "desc"){$link1 = "asc";}else{$link1 = "desc";}}
if($_GET['sort'] == "3"){if($_GET['type'] == "desc"){$link3 = "asc";}else{$link3 = "desc";}}
if($_GET['sort'] == "4"){if($_GET['type'] == "desc"){$link4 = "asc";}else{$link4 = "desc";}}
if($_GET['sort'] == "5"){if($_GET['type'] == "desc"){$link5 = "asc";}else{$link5 = "desc";}}
if($_GET['sort'] == "7"){if($_GET['type'] == "desc"){$link7 = "asc";}else{$link7 = "desc";}}
if($_GET['sort'] == "8"){if ($_GET['type'] == "desc"){$link8 = "asc";}else{$link8 = "desc";}}
if($_GET['sort'] == "9"){if($_GET['type'] == "desc"){$link9 = "asc";}else{$link9 = "desc";}}
if($link1 == ""){$link1 = "asc";}if($link3 == ""){$link3 = "desc";}if($link4 == ""){$link4 = "desc";}if($link5 == ""){$link5 = "desc";}
if($link7 == ""){$link7 = "desc";}if($link8 == ""){$link8 = "desc";}if($link9 == ""){$link9 = "desc";}
if($variant == "index"){$script = "browse.php";}elseif($variant == "mytorrents"){$script = "mytorrents.php";}elseif($variant == "bookmarks"){$script = "bookmarks.php";}?>
<tr><td align="center" width="50px"><b>Категория</b></td><td align="center" width="50px"><b>Тип</b></td><td align="left">
<a href="<?php print $script; ?>?<?php print $oldlink; ?>sort=1&type=<?php print $link1; ?>" class="altlink_white"><?php echo $tracker_lang['name'];?></a> / 
<a href="<?php print $script; ?>?<?php print $oldlink; ?>sort=4&type=<?php print $link4; ?>" class="altlink_white"><?php echo $tracker_lang['added'];?></a></td>
<?php if($wait)print("<td align=\"center\">".$tracker_lang['wait']."</td>\n");
if($variant == "mytorrents")print("<td align=\"center\">".$tracker_lang['visible']."</td>\n");?>
<td align="center"><a href="<?php print $script; ?>?<?php print $oldlink; ?>sort=3&type=<?php print $link3; ?>" class="altlink_white"><?php echo $tracker_lang['comments'];?></a></td>
<td align="center"><a href="<?php print $script; ?>?<?php print $oldlink; ?>sort=5&type=<?php print $link5; ?>" class="altlink_white"><?php echo $tracker_lang['size'];?></a></td>
<td align="center"><a href="<?php print $script; ?>?<?php print $oldlink; ?>sort=7&type=<?php print $link7; ?>" class="altlink_white"><?php echo $tracker_lang['seeds'];?></a>|<a href="<?php print $script; ?>?<?php print $oldlink; ?>sort=8&type=<?php print $link8; ?>" class="altlink_white"><?php echo $tracker_lang['leechers'];?></a></td><?php
if ($variant == "index" || $variant == "bookmarks")
	print("<td align=\"center\"><a href=\"{$script}?{$oldlink}sort=9&type={$link9}\" class=\"altlink_white\">".$tracker_lang['uploadeder']."</a></td>\n");
?><td align="center"><img src="pic/delbook.png"  border="0" title="в избранное ?"/></td><?
if ($variant == "bookmarks")print("<td align=\"center\">".$tracker_lang['delete']."</td>\n");
print("</tr><tbody id=\"highlighted\">");
if ((get_user_class() >= UC_MODERATOR) && $variant == "index")print("<form method=\"post\" action=\"deltorrent.php?mode=delete\">");

if ($variant == "bookmarks")print ("<form method=\"post\" action=\"takedelbookmark.php\">");
while($row = mysql_fetch_assoc($res)){$day_added = $row['added'];$day_show = strtotime($day_added);$thisdate = date('Y-m-d',$day_show);
if($thisdate==$prevdate){$cleandate = '';}else{$day_added = '  '.date('l d M', strtotime($row['added']));
$cleandate = "<tr><td class=\"zaliwka\" style='color:#FFFFFF;font-size:14px;font-family:cursive;margin-left:20px;text-align:left;border:0;border-radius:5px;' colspan='15'>&nbsp;&nbsp;Релизы за $day_added</td></tr>";}
$prevdate = $thisdate;
$man = array(
    'Jan' => 'Января',
    'Feb' => 'Февраля',
    'Mar' => 'Марта',
    'Apr' => 'Апреля',
    'May' => 'Мая',
    'Jun' => 'Июня',
    'Jul' => 'Июля',
    'Aug' => 'Августа',
    'Sep' => 'Сентября',
    'Oct' => 'Октября',
    'Nov' => 'Ноября',
    'Dec' => 'Декабря'
);
foreach($man as $eng => $rus){$cleandate = str_replace($eng, $rus,$cleandate);}
$dag = array(
    'Mon' => 'Понедельник',
    'Tues' => 'Вторник',
    'Wednes' => 'Среда',
    'Thurs' => 'Четверг',
    'Fri' => 'Пятница',
    'Satur' => 'Суббота',
    'Sun' => 'Воскресенье'
);
foreach($dag as $eng => $rus){$cleandate = str_replace($eng.'day', $rus.'',$cleandate);}
if(!$_GET['sort'] && !$_GET['d']){echo $cleandate;}
$id = $row["id"];
print("<tr>");
print("<td align=\"center\" style=\"padding: 0px\">");
if($row["cat_name"] != ''){print("<a href=\"browse.php?janr=" . $row["category"] . "\">");
if($row["cat_pic"] != ""){print("<img border=\"0\" src=\"pic/cats/" . $row["cat_pic"] . "\" alt=\"" . $row["cat_name"] . "\" />");}else{print($row["cat_name"]);}
print("</a>");}else print("-");
print("</td>");
print("<td align=\"center\" style=\"padding: 0px\">");
if($row["incat_name"] != ''){print("<a href=\"browse.php?tip=".$row["incategory"]."\">");
if($row["incat_pic"] != ""){print("<img border=\"0\" src=\"pic/cats/".$row["incat_pic"]."\" alt=\"".$row["incat_name"]."\" />");}else{print($row["incat_name"]);}
print("</a>");}else print("-");
print("</td>");

$dispname = $row["name"];
switch ($row['free']) {
case 'bril': $freepic = "&nbsp;<a href=\"Brilliant\" alt=\"Brilliant\" title=\"Brilliant\"><img src=\"pic/bril.gif\" title=\"Brilliant\" alt=\"Brilliant\"></a>";break;
case 'yes': $freepic = "&nbsp;<a href=\"Gold\" alt=\"".$tracker_lang['golden']."\" title=\"".$tracker_lang['golden']."\"><img src=\"pic/golden.gif\" title=\"".$tracker_lang['golden']."\" alt=\"".$tracker_lang['golden']."\"></a>";break;
case 'silver': $freepic = "&nbsp;<a href=\"Silver\" alt=\"".$tracker_lang['silver']."\" title=\"".$tracker_lang['silver']."\"><img src=\"pic/silvers.gif\" title=\"".$tracker_lang['silver']."\" alt=\"".$tracker_lang['silver']."\"></a>";break;
case 'no': $freepic = '';}
$thisisfree = $freepic;

print("<td align=\"left\">".($row["not_sticky"] == "no" ? "<font size='3' title='Важный'>📌</font> " : "")."");
/////////////////////// 
if($row["suid"]){?>&nbsp;
<a href="download.php?id=<?=$row['id']?>"><img src="pic/trans.gif" title="Вы уже брали этот торрент. Нажмите, чтобы загрузить файл .torrent еще раз."/></a>&nbsp;<?} 
////////////////////////////
print("<a href=\"details.php?");
if ($variant == "mytorrents")
			print("returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;");
		print("id=$id");
if ($variant == "index" || $variant == "bookmarks")
print("&amp;hit=1");         
print("\">");      
switch ($row['free']) {
case 'bril': $disname = "<font color=\"blue\" title=\"Бриллиантовая раздача! Это значит, что кол-во розданного на этой раздаче удваивается!\">$dispname</font>";break;
case 'yes': $disname = "<font color=\"#d08700\" title=\"Золотая раздача! Это значит, что кол-во скачанного на этой раздаче не идет в общую статистику!\">$dispname</font>";break;   
case 'silver': $disname = "<font color=\"#778899\" title=\"Серебрянная раздача! Это значит, что половина скачанного на этой раздаче не идет в общую статистику!\">$dispname</font>";break;   
case 'no': $disname = "$dispname";}
$disnames = $disname;
print("<b>$disnames</b></a> $thisisfree");

if($CURUSER["id"] == $row["owner"] || get_user_class() >= UC_MODERATOR){
print("<a target=_blank href='edit.php?id=$row[id]'><img border='0' src='pic/pen.gif' alt='".$tracker_lang['edit']."' title='".$tracker_lang['edit']."'/></a>");}

if(!empty($row["description"])){print("<br />");$slova = $row["description"];$arr = explode(', ', $slova);
foreach ($arr as $word){$word = trim($word);$words = str_replace("+", "%2B", $word);
print("<span class='badge-extra text-bold'><a style='font-weight:normal;color:#696969;' href='browse.php?jsearch=".unesc($words)."' title='".$words."'>".$words."</a></span> ");}
}else{print("<span class='badge-extra text-bold'>Не прописано</span>");}
if($wait){$elapsed = floor((gmtime() - strtotime($row["added"])) / 3600);if($elapsed < $wait){$color = dechex(floor(127*($wait - $elapsed)/48 + 128)*65536);
print("<br><nobr><b style='font-size:10px;color:red;'>Поднимите рейтинг! Вы можете скачать этот релиз только через</b>&nbsp;<a href='faq#7'><b style='color:$color'>".number_format($wait - $elapsed)." h</b></a></nobr>");}}
print("<br><b style='font-size:1;color:grey;'>Релиз залит:&nbsp;<i>".nicetime($row["added"], true)."</i></b>");
if($row["updatess"] != 'no'){?>&nbsp;&nbsp;&nbsp;<img src="pic/updated.png" border="0" alt="Релиз был обновлен!" title="Релиз был обновлен!"/><?}			
////////////////////
$elapseds = floor((gmtime() - strtotime($row["added"])) / 86400);
if($elapseds < 7 && $variant == "index"){print ("&nbsp;&nbsp;&nbsp;<img border='0' src='pic/new.png' alt='Новинка' title='Новинка'/>");}
print("</td>\n");

		if ($variant == "mytorrents") {
			print("<td align=\"right\">");
			if ($row["visible"] == "no")
				print("<font color=\"red\"><b>".$tracker_lang['no']."</b></font>");
			else
				print("<font color=\"green\">".$tracker_lang['yes']."</font>");
			print("</td>\n");
		}
		if (!$row["comments"])
			print("<td align=\"right\">" . $row["comments"] . "</td>\n");
		else {
			if ($variant == "index")
				print("<td align=\"right\"><b><a href=\"details.php?id=$id&amp;hit=1&amp;tocomm=1\">" . $row["comments"] . "</a></b></td>\n");
			else
				print("<td align=\"right\"><b><a href=\"details.php?id=$id&amp;page=0#startcomments\">" . $row["comments"] . "</a></b></td>\n");
		}
		print("<td align=\"center\">" . str_replace(" ", "<br />", mksize($row["size"])) . "</td>\n");
		print("<td align=\"center\">");
if($row["seeders"] > 0){print("<b><a href=\"details.php?id=$id\"><font color='green'>".$row["seeders"]."</font></a></b>");}else{print("0");}
print(" | ");
if($row["leechers"] > 0){print("<b><a href=\"details.php?id=$id\"><font color='red'>".$row["leechers"]."</font></a></b>");}else{print("0");}
if ($row['multitracker'] == 'yes'){print("<hr><b>MULTI</b><br>");
if($row["remote_seeders"] > 0){print("<b><a href=\"details.php?id=$id\"><font color='green'>".$row["remote_seeders"]."</font></a></b>");}else{print("0");}
print(" | ");
if($row["remote_leechers"] > 0){print("<b><a href=\"details.php?id=$id\"><font color='red'>".$row["remote_leechers"]."</font></a></b>");}else{print("0");}}
print("</td>");

		if ($variant == "index" || $variant == "bookmarks")
			print("<td align=\"center\">" . (isset($row["username"]) ? ("<a href=\"userdetails.php?id=" . $row["owner"] . "\"><b>" . get_user_class_color($row["class"], htmlspecialchars_uni($row["username"])) . "</b></a>") : "<i>(unknown)</i>") . "</td>\n");
////////////////////
if($variant != "bookmarks" && $CURUSER){?>
<td class=\"a\"><span class="bmark"><center>
<?//Проверяем, сущесвует ли закладка 
if($row["userid"]) echo '<div id="bookmark_'.$row['id'].'"><img src="pic/bookdel.png"  border="0" title="Убрать из избранного" onclick="bookmark('.$row['id'].', \'del\' , \'browse\');" /></div>'; 
else echo '<div id="bookmark_'.$row['id'].'"><img src="pic/bookadd.png"  border="0" title="Добавить в избранное" onclick="bookmark('.$row['id'].', \'add\' , \'browse\');"  /></div>'; 
?></center></span></td><?}if($variant == "bookmarks"){?><td class=\"a\"><span class="bmark"><center>
<?//Проверяем, сущесвует ли закладка 
if($row["userid"]) echo '<div id="bookmark_'.$row['id'].'"><img src="pic/bookdel.png"  border="0" title="Убрать из избранного" onclick="bookmark('.$row['id'].', \'del\' , \'browse\');"  /></div>'; 
else echo '<div id="bookmark_'.$row['id'].'"><img src="pic/bookadd.png"  border="0" title="Добавить в избранное" onclick="bookmark('.$row['id'].', \'add\' , \'browse\');" /></div>'; 
?></center></span></td><?}
/////////////////////
		if ($variant == "bookmarks")
			print ("<td align=\"center\"><input type=\"checkbox\" name=\"delbookmark[]\" value=\"" . $row[bookmarkid] . "\" /></td>");

		if ((get_user_class() >= UC_MODERATOR) && $variant == "index")
			print("<td align=\"center\"><input type=\"checkbox\" name=\"delete[]\" value=\"" . $id . "\" /></td>\n");

	print("</tr>\n");

	}

	print("</tbody>");

	if ($variant == "index" && $CURUSER)
		print("<tr><td colspan=\"12\" align=\"center\"></td></tr>");

	if ($variant == "index") {
		if (get_user_class() >= UC_MODERATOR) {
			print("<tr><td align=\"right\" colspan=\"12\"><input type=\"submit\" value=\"Удалить\"></td></tr>\n");
		}
	}

	if ($variant == "bookmarks")
		print("<tr><td colspan=\"12\" align=\"right\"><input type=\"submit\" value=\"".$tracker_lang['delete']."\"></td></tr>\n");

	if ($variant == "index" || $variant == "bookmarks") {
		if (get_user_class() >= UC_MODERATOR) {
			print("</form>\n");
		}
	}
return $rows;}

//////////////////////
function commenttable($rows, $redaktor = "comment", $event="onchange='jquerypreview();' onkeyup='jquerypreview();'"){global $CURUSER;$count = 0;foreach ($rows as $row){
if(strtotime($row["last_access"]) > gmtime() - 600){$online = "online";$online_text = "В сети";}else{$online = "offline";$online_text = "Не в сети";}
?><br><table style='background:none;' width='98%' border='0' cellspacing='0' cellpadding='3'><?
if(!empty($row["avatar"])){$avatar = $row["avatar"];}else{$avatar = "pic/default_avatar.gif";}$text = $row['text_html'];
print("<tr valign='top'><td style='padding:10px;width:150;background:none;'><table style='background:none;'border='0' cellspacing='0'><tr>
<td style='padding:10px;width:150;height:160;border-radius:10px;border:0;' class='b'><center>
<a href='user_".$row['user']."'><img src='".$avatar."' width='120' border='1' alt='".($row["username"]?($row["username"]):"Anonymous")."' title='".($row["username"]?($row["username"]):"Anonymous")."'/></a><br>");
if(isset($row["username"])){
print("<a href='user_".$row["user"]."'><b>".get_user_class_color($row["class"], htmlspecialchars_uni($row["username"]))."</b></a>
".($row["donor"] == "yes" ? "&nbsp;<img src='pic/star.gif' alt='Donor'/>" : "").($row["warned"] == "yes" ? "&nbsp;<img src='pic/warned.gif' alt='Warned'/>" : "")."<hr width='120'>
<img src='pic/buttons/button_".$online.".gif' alt='".$online_text."' title='".$online_text."' style='position:relative;top:2px;' border='0' height='14'/>
&nbsp;<a href='#' onclick=\"javascript:window.open('sendpm_".$row["user"]."', 'Отправить PM', 'width=650px, height=465px');return false;\" title='Отправить ЛС'><img src='pic/pn_inbox.gif' border='0' title='PM'/></a>");
}else{print("<a href='details.php?id=".$row["torrent"]."&viewcomm=".$row["id"]."#comm".$row["id"]."'><i>[Anonymous]</i></a>");}
print("</center></td></tr><tr><td style='width:150;background:none;'></td></tr></table></td><td style='padding:10px;width:10;background:none;'></td>
<td width='100%' style='padding:10px;border-radius:10px;border:0;' class='b'><table style='background:none;width:100%;border:0;'><tr>
<td class='zaliwka' style='font-family:tahoma;color:#FFFFFF;colspan:16;font-size:14px;border:0;border-radius:5px;'>
<div style='font-family:tahoma;font-size:11px;font-weight:10;color:#FFFFFF;margin-left:10px;letter-spacing:0;text-align:left;float:left;border:0;'>
<a name='comm".$row["id"]."' href='details.php?id=".$row["torrent"]."&viewcomm=".$row["id"]."#comm".$row["id"]."' class='but'>(".nicetime($row["added"], true).")</a>");
if($row["editedby"] && get_user_class() >= UC_MODERATOR){
print("&nbsp;&nbsp;&nbsp;<span style='color:#FFFFFF;font-family:tahoma;font-size:11px;margin:0;margin-top:3px;padding:2px;letter-spacing:0;'>
Last edited by <a href='user_".$row['editedby']."'><b>".$row['editedbyname']."</b></a> in ".$row['editedat']."</span>");}print("</div>");
if($CURUSER["comentoff"] == 'no'){?></td></tr><tr><td style='background:none;width:100%;border:0;'><?}else{
print"<div align='right' border='0'><a href='".$redaktor.".php?action=quote&amp;cid=".$row['id']."' class='but'>Quote</a>".($row["user"] == $CURUSER["id"] || get_user_class() >= UC_MODERATOR ? "&nbsp;&nbsp;&nbsp;<a href=".$redaktor.".php?action=edit&amp;cid=".$row['id']." class='but'>Edit</a>" : "")
.(get_user_class() >= UC_MODERATOR ? "&nbsp;&nbsp;&nbsp;<a href='".$redaktor.".php?action=delete&amp;cid=".$row['id']."' class='but'><b style='color:red'>Delete</b></a>" : "")
.($row["editedby"] && get_user_class() >= UC_MODERATOR ? "&nbsp;&nbsp;&nbsp;<a href='".$redaktor.".php?action=vieworiginal&amp;cid=".$row['id']."' class='but'>Original</a>" : "")
.(get_user_class() >= UC_SYSOP ? "&nbsp;&nbsp;&nbsp;IP: ".($row["ip"] ? "<a href='usersearch.php?ip=".$row['ip']."' class='but'>".$row["ip"]."</a>" : "Unknown" ) : "")."
&nbsp;&nbsp;&nbsp;</div></td></tr><tr><td style='background:none;width:100%;border:0;'>";}
print("<div style='margin-left:20px;border:0;'><br>$text</div><div id='cleft' border='0'></div></td></tr></table></td></tr></table>");}}
//////////////////////
function check_port($host, $port, $timeout, $force_fsock = false){
if(function_exists('socket_create') && !$force_fsock){$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);if($socket == false){return false;}
if(socket_set_nonblock($socket) == false){socket_close($socket);return false;}@socket_connect($socket, $host, $port);
if(socket_set_block($socket) == false){socket_close($socket);return false;}switch(socket_select($r = array($socket), $w = array($socket), $f = array($socket), $timeout)){
case 2: $result = false;break;case 1: $result = true;break;case 0: $result = false;break;}socket_close($socket);}else{$socket = @fsockopen($host, $port, $errno, $errstr, 5);
if(!$socket) $result = false;else{$result = true;@fclose($socket);}}return $result;}
//////////////////////////
function is_theme($theme = ""){global $rootpath, $stdhead;return file_exists($rootpath."stdfoot.php");}
/////////////////////////
function get_themes(){global $rootpath;$handle = opendir($rootpath."themes");$themelist = array();while ($file = readdir($handle)){
if(is_theme($file) && $file != "." && $file != ".."){$themelist[] = $file;}}closedir($handle);sort($themelist);return $themelist;}
/////////////////////
function theme_selector($sel_theme = "", $use_fsw = false){global $DEFAULTBASEURL;$themes = get_themes();
$content = "<select name='theme'".($use_fsw ? " onchange=\"window.location='$DEFAULTBASEURL/changetheme.php?theme='+this.options[this.selectedIndex].value\"" : "").">";
foreach($themes as $theme)$content .= "<option value='$theme'".($theme == $sel_theme ? " selected" : "").">$theme</option>\n";$content .= "</select>";return $content;}
/////////////////////
function select_theme(){global $CURUSER, $default_theme;if($CURUSER)$theme = $CURUSER["theme"];else $theme = $default_theme;
if(!is_theme($theme))$theme = $default_theme;return $theme;}
/////////////////////////
function title($str){static $title='';if(!empty($str)) $title=$str;return $title;}
//////////////////
function decode_to_utf8($int = 0){$t = '';if($int < 0){return chr(0);}elseif($int <= 0x007f){$t .= chr($int);}elseif($int <= 0x07ff){
$t .= chr(0xc0 | ($int >> 6));$t .= chr(0x80 | ($int & 0x003f));}elseif($int <= 0xffff){$t .= chr(0xe0 | ($int  >> 12));$t .= chr(0x80 | (($int >> 6) & 0x003f));
$t .= chr(0x80 | ($int  & 0x003f));}elseif($int <= 0x10ffff){$t .= chr(0xf0 | ($int  >> 18));$t .= chr(0x80 | (($int >> 12) & 0x3f));$t .= chr(0x80 | (($int >> 6) & 0x3f));
$t .= chr(0x80 | ($int  &  0x3f));}else{return chr(0);}return $t;}
////////////////
function sql_query($query, $detect = true){if($detect == true){detect_sqlinjection($query);}global $queries, $query_stat, $querytime;
$queries++;$query_start_time = timer(); // Start time
$result = mysql_query($query);$query_end_time = timer(); // End time
$query_time = ($query_end_time - $query_start_time);$querytime = $querytime + $query_time;$query_stat[] = array("seconds" => $query_time, "query" => $query);return $result;}
/////////////////////
function dbconn($autoclean = false, $lightmode = false){global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
if(!@mysql_connect($mysql_host, $mysql_user, $mysql_pass)) die("[".mysql_errno()."] dbconn: mysql_connect: ".mysql_error());
mysql_select_db($mysql_db) or die("dbconn: mysql_select_db: ".mysql_error());mysql_query("SET NAMES 'utf8'");userlogin($lightmode);gzip();
if(basename($_SERVER['SCRIPT_FILENAME']) == 'index.php') register_shutdown_function("autoclean");register_shutdown_function("mysql_close");}
///////////////
function recache_bans(){$bans_sql = mysql_query("SELECT first, haker FROM bans") or sqlerr(__FILE__,__LINE__);
while($ban = mysql_fetch_assoc($bans_sql))$bans[] = $ban;cache_writes("bans", $bans);}
////////функция CURUSER начало////////////
function userlogin($lightmode = false){global $default_language, $tracker_lang, $use_lang;unset($GLOBALS["CURUSER"]);
if (COOKIE_SALT == '' || (COOKIE_SALT == 'default' && $_SERVER['SERVER_ADDR'] != '127.0.0.1' && $_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR']))
die('Скрипт заблокирован! Измените значение константы COOKIE_SALT в файле include/bittorrent на случайное');
$ip = getip();$c_uid = $_COOKIE[COOKIE_UID];$c_pass = $_COOKIE[COOKIE_PASSHASH];if(empty($c_uid) || empty($c_pass)){
if(empty($_COOKIE["lang"]) || !$use_lang) include_once('languages/lang_'.$default_language.'/lang_main.php'); 
else @include_once('languages/lang_'.$_COOKIE["lang"].'/lang_main.php');user_session();return;}
if(!$CURUSER){$id = intval($c_uid);if(!$id || strlen($c_pass) != 32){die("Cokie ID invalid or cookie pass hash problem.");}
////////////////////////
$cache = new Memcache();$cache->connect('127.001.001.000', 11211); // IP вашего сервера и порт Мемкеша //прописать ваши данные!//
$row = array();if(!$row = $cache->get('user_cache_'.$id)){$res = mysql_query('SELECT * FROM users WHERE id = '.sqlesc($id)) or err('There is no user with this ID');
$row = mysql_fetch_array($res);$cache->set('user_cache_'.$id, $row, MEMCACHE_COMPRESSED, 1800);}
if(!$row){if (empty($_COOKIE["lang"]) || !$use_lang) include_once('languages/lang_'.$default_language.'/lang_main.php'); 
else @include_once('languages/lang_'.$_COOKIE["lang"].'/lang_main.php');user_session();return;}}
$subnet = explode('.', getip());$subnet[2] = $subnet[3] = 0;$subnet = implode('.', $subnet);
if($c_pass !== md5($row["passhash"].COOKIE_SALT.$subnet)){if(empty($_COOKIE["lang"]) || !$use_lang) include_once('languages/lang_'.$default_language.'/lang_main.php'); 
else @include_once('languages/lang_'.$_COOKIE["lang"].'/lang_main.php');user_session();return;}$updateset = array();
if(strtotime($row['last_access']) < (strtotime(get_date_time()) - 300)) $updateset[] = 'last_access = '.sqlesc(get_date_time()); 
if(count($updateset)) mysql_query("UPDATE LOW_PRIORITY users SET ".implode(", ", $updateset)." WHERE id=".$row["id"]);$row['ip'] = $ip; 
if($row['override_class'] < $row['class']) $row['class'] = $row['override_class'];$GLOBALS["CURUSER"] = $row;
if(empty($_COOKIE["lang"]) || !$use_lang) include_once('languages/lang_'.$default_language.'/lang_main.php'); 
else @include_once('languages/lang_'.$_COOKIE["lang"].'/lang_main.php');if($row['enabled'] == 'no'){logoutcookie();}if(!$lightmode) user_session();}
////////////функция CURUSER конец///////////////////////
function get_server_load(){global $tracker_lang, $phpver;
if(strtolower(substr(PHP_OS, 0, 3)) === 'win'){return 0;}elseif(@file_exists("/proc/loadavg")){
$load = @file_get_contents("/proc/loadavg");$serverload = explode(" ", $load);$serverload[0] = round($serverload[0], 4);
if(!$serverload){$load = @exec("uptime");$load = @preg_split("load averages?: ", $load);$serverload = explode(",", $load[1]);}
}else{$load = @exec("uptime");$load = @preg_split("load averages?: ", $load);$serverload = explode(",", $load[1]);}
$returnload = trim($serverload[0]);if(!$returnload){$returnload = $tracker_lang['unknown'];}return $returnload;}
////////////функция сессии начало///////////////////////
function user_session(){global $CURUSER, $use_sessions;if(!$use_sessions) return;
$client = @$_SERVER['HTTP_CLIENT_IP'];$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];$remote = @$_SERVER['REMOTE_ADDR']; 
if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
else $ip = $remote;$url = getenv("REQUEST_URI");if($ip != '127.001.001.000'){ // прописать IP вашего сервера! //прописать ваши данные!//
if(!$CURUSER){$uid = -1;$username = '';$avatar = '';$class = -1;}else{$uid = $CURUSER['id'];$username = $CURUSER['username'];
if(!$CURUSER['avatar']){$avatar = "pic/noavatar.gif";}else{$avatar = $CURUSER['avatar'];}$class = $CURUSER['class'];}  
$sid = session_id();$where = array();$updateset = array();if($sid) $where[] = "sid = ".sqlesc($sid);elseif ($uid) $where[] = "uid = $uid";else $where[] = "ip = ".sqlesc($ip);
$ctime = get_date_time();$agent = $_SERVER["HTTP_USER_AGENT"];$updateset[] = "sid = ".sqlesc($sid);$updateset[] = "uid = ".sqlesc($uid);
$updateset[] = "username = ".sqlesc($username);$updateset[] = "class = ".sqlesc($class);$updateset[] = "avatar = ".sqlesc($avatar);$updateset[] = "ip = ".sqlesc($ip);
$updateset[] = "time = ".sqlesc($ctime);$updateset[] = "url = ".sqlesc($url);session_write_close();
if(count($updateset)) mysql_query("UPDATE sessions SET ".implode(", ", $updateset)." WHERE ".implode(" AND ", $where)) or sqlerr(__FILE__,__LINE__);
if (mysql_modified_rows() < 1) mysql_query("INSERT INTO sessions (sid, uid, username, class, avatar, ip, time, url) 
VALUES (".implode(", ", array_map("sqlesc", array($sid, $uid, $username, $class, $avatar, $ip, $ctime, $url))).")") or sqlerr(__FILE__,__LINE__);}}
////////////функция сессии конец///////////////////////
function loading_layer($id = 'loading_layer'){global $pic_base_url;return "&nbsp;";}
////////////////////////////
function unesc($x){$x = is_array($x) ? array_map('unesc', $x) : stripslashes($x);return $x;} 
////////////////////////
function gzip(){static $already_loaded;if(extension_loaded('zlib') && ini_get('zlib.output_compression') != '1' && ini_get('output_handler') != 'ob_gzhandler' && !$already_loaded){
@ob_start('ob_gzhandler');}elseif(!$already_loaded) @ob_start();$already_loaded = true;}
///////////// IP Validation
function validip($ip){if(!empty($ip) && $ip == long2ip(ip2long($ip))){$reserved_ips = array(
array('0.0.0.0','2.255.255.255'),
array('10.0.0.0','10.255.255.255'),
array('127.0.0.0','127.255.255.255'),
array('169.254.0.0','169.254.255.255'),
array('172.16.0.0','172.31.255.255'),
array('192.0.2.0','192.0.2.255'),
array('192.168.0.0','192.168.255.255'),
array('255.255.255.0','255.255.255.255') );
foreach ($reserved_ips as $r){$min = ip2long($r[0]);$max = ip2long($r[1]);if((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;}return true;}else return false;}
//////////////////////////
function getip(){if(!empty($_SERVER['HTTP_CLIENT_IP'])){return $_SERVER['HTTP_CLIENT_IP'];}
if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){return $_SERVER['HTTP_X_FORWARDED_FOR'];}return $_SERVER['REMOTE_ADDR'];}
//////////////////////////
function autoclean(){global $autoclean_interval, $rootpath;$now = time();$docleanup = 0;    
$res = sql_query("SELECT value_u FROM avps WHERE arg = 'lastcleantime'");$row = mysql_fetch_array($res);
if(!$row){sql_query("INSERT INTO avps (arg, value_u) VALUES ('lastcleantime',$now)");return;}$ts = $row[0];if($ts + $autoclean_interval > $now) return;
if($ts > $now){sql_query("UPDATE avps SET value_u=$now WHERE arg='lastcleantime' AND value_u = $ts");return;}
sql_query("UPDATE avps SET value_u=$now WHERE arg='lastcleantime' AND value_u = $ts");
if(!mysql_affected_rows()) return;require_once($rootpath.'include/cleanup.php');docleanup();}
//////////////////////////////
function mksize($bytes){if($bytes < 1000 * 1024)return number_format($bytes / 1024, 2)." kB";elseif($bytes < 1000 * 1048576)return number_format($bytes / 1048576, 2)." MB";
elseif($bytes < 1000 * 1073741824)return number_format($bytes / 1073741824, 2)." GB";else return number_format($bytes / 1099511627776, 2)." TB";}
////////////////////////
function deadtime(){global $announce_interval;return time() - floor($announce_interval * 1.3);}
///////////////////////////
function mkprettytime($s){if($s < 0)$s = 0;$t = array();foreach (array("60:sec","60:min","24:hour","0:day") as $x){$y = explode(":", $x);
if($y[0] > 1){$v = $s % $y[0];$s = floor($s / $y[0]);}else $v = $s;$t[$y[1]] = $v;}if($t["day"])return $t["day"]."d ".sprintf("%02d:%02d:%02d", $t["hour"], $t["min"], $t["sec"]);
if($t["hour"])return sprintf("%d:%02d:%02d", $t["hour"], $t["min"], $t["sec"]);return sprintf("%d:%02d", $t["min"], $t["sec"]);}
/////////////////////////////////
function mkglobal($vars){if(!is_array($vars))$vars = explode(":", $vars);foreach ($vars as $v){
if(isset($_GET[$v]))$GLOBALS[$v] = unesc($_GET[$v]);elseif(isset($_POST[$v]))$GLOBALS[$v] = unesc($_POST[$v]);else return 0;}return 1;}
////////////////////////////
function tr($x, $y, $noesc=0, $prints = true, $width = "", $relation = ''){if($noesc)$a = $y;else{$a = htmlspecialchars_uni($y);$a = str_replace("\n", "<br>\n", $a);}if($prints){
$print = "<td width='". $width ."' class='heading' valign='top' align='right'>$x</td>";$colpan = "align='left'";}else{
$colpan = "colspan='2'";}print("<tr".( $relation ? " relation='$relation'" : "").">$print<td valign='top' $colpan>$a</td></tr>\n");}
/////////////////////////
function validfilename($name){return preg_match('/^[^\0-\x1f:\\\\\/?*\xff#<>|]+$/si', $name);}
////////////////////////
function validemail($email){return filter_var($email, FILTER_VALIDATE_EMAIL);}
////////////////////////
function mail_possible($email){list(, $domain) = explode('@', $email);if(function_exists('checkdnsrr'))return checkdnsrr($domain, 'MX');else return true;}
/////////////////////////
function send_pm($sender, $receiver, $added, $subject, $msg){sql_query('INSERT INTO messages (sender, receiver, added, subject, msg) VALUES ('.implode(', ', array_map('sqlesc', 
array($sender, $receiver, $added, $subject, $msg))).')') or sqlerr(__FILE__,__LINE__);}
////////////////////////////
function sent_mail($to, $subject, $body, $fromname, $fromemail){global $SITENAME, $SITEEMAIL;$result = true;
@mail($to, $subject, $body, "From: admin@ваш_сайт") or $result = false;} //прописать ваши данные!//
///////////////////////////////
function sqlesc($value, $force = false){if(!is_numeric($value) || $force){$value = "'".mysql_real_escape_string($value)."'";}return $value;}
////////////////////////
function sqlwildcardesc($x){return str_replace(array("%","_"), array("\\%","\\_"), mysql_real_escape_string($x));}
/////////////////////////////////////////////////
function begin_main_frame(){print("<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td>");}
function end_main_frame(){print("</td></tr></table>");}
function begin_table(){print("<table width='100%' border='0' cellspacing='0' cellpadding='0'>");}
function end_table(){print("</table>");}
function begin_frame($caption = "", $center = false, $padding = 10){?><table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:30px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
<?=$caption?></td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;"><?}
function attach_frame($padding = 10){print("</td></tr><tr><td style='border-top:0px;'>");}
function end_frame(){?></td></tr></table></td></tr></table><br><?}
function blok_menu($title, $content, $width="155"){$thefile = addslashes(file_get_contents('block-left.php'));
$thefile = "\$r_file='".$thefile."';";eval($thefile);echo $r_file;}
//////////////////////////////////////////////
function stdhead($title = ''){global $CURUSER, $SITENAME, $DEFAULTBASEURL, $ss_uri, $tracker_lang, $default_theme, $keywords, $description, $rootpath;
header ('Content-Type: text/html; charset=utf-8');header ('X-Powered-by: LoLi v3.6');header ('Cache-Control: public, max-age=86400');	
if(empty($title)){$title = $SITENAME;}else{$title = $SITENAME.' :: '.htmlspecialchars_uni($title);}$ss_uri = select_theme();
if($CURUSER){?><!DOCTYPE html><html lang="ru"><head><link rel="preconnect" href="<?=$DEFAULTBASEURL?>"/><link rel="dns-prefetch" href="<?=$DEFAULTBASEURL?>"/>
<meta charset="utf-8"><meta name="description" content="<?=$SITENAME?>"><link rel="canonical" href="<?=$DEFAULTBASEURL?>/index.php"/>
<title><?=$title?></title><?header("Cache-Control: public, max-age=604800, immutable");?><link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" type="image/x-icon" href="data:image/x-icon"><style>
nav{display:block}ul{list-style:none}.container{margin:10px auto;width:480px;text-align:center}.container.nav{display:inline-block;text-align:center}.nav{padding:4px;background:rgba(0,0,0,0.04);border-radius:23px;-webkit-box-shadow:inset 0 1px rgba(0,0,0,0.08),0 -1px rgba(0,0,0,0.3),0 1px rgba(255,255,255,0.12);box-shadow:inset 0 1px rgba(0,0,0,0.08),0 -1px rgba(0,0,0,0.3),0 1px rgba(255,255,255,0.12)}.nav-list{padding:0 6px;height:34px;background:#f4f5f7;border-radius:18px;background-image:-webkit-linear-gradient(top,white,#e1e2eb);background-image:-moz-linear-gradient(top,white,#e1e2eb);background-image:-o-linear-gradient(top,white,#e1e2eb);background-image:linear-gradient(to bottom,white,#e1e2eb);-webkit-box-shadow:inset 0 0 0 1px rgba(255,255,255,0.3),0 1px 1px rgba(0,0,0,0.2);box-shadow:inset 0 0 0 1px rgba(255,255,255,0.3),0 1px 1px rgba(0,0,0,0.2)}.nav-list>li{float:left;height:17px;margin:8px 0}.nav-list>li+li{border-left:1px dotted #989ca8}.nav-link{float:left;position:relative;margin-top:-8px;padding:0 14px;line-height:34px;font-size:10px;font-weight:700;color:#555;text-decoration:none;text-shadow:0 1px #fff}.nav-link:hover{color:#333;text-decoration:underline}.fancymenu{float:left;list-style:none;margin:0;padding:0}.fancymenu li{float:left;list-style:none}.fancymenu li a{color:#fff;display:block;float:left;font:bold 14px arial;height:30px;letter-spacing:0;margin:auto 10px;outline:none;overflow:hidden;position:relative;text-align:center;text-decoration:none;text-transform:uppercase;top:7px;z-index:10}.fancymenu li.back{background:url(images/menu_r.png) no-repeat 100% 0;position:absolute;z-index:2}.fancymenu li.back .left{background:url(images/menu_l.png) no-repeat 0 0;height:40px;margin-right:5px}.fancymenu li a:hover,.fancymenu li a:active,.fancymenu li a:visited{border:none}div#menu{height:40px;left:50%;margin-left:-300px;position:relative;top:0;width:600px}input.common{border:1px solid #CECECE;background-color:#F2F2F2}input.valid{border:1px solid #B3D577;background-color:#E0F5BD}input.error{border:1px solid #DB8180;background-color:#F7C7C7}input.important{border:1px solid #DCCB61;background-color:#F8EEB9}.bmark{text-align:center;white-space:nowrap}.bookmarked{background:#FF9}body{font-family:"tahoma";font-size:8pt;color:#306A82;background:#e5e5e5 repeat-y top;width:100%;margin:0 5px}td.null{background:#FAFAFA;color:#000;border:0;font-family:tahoma;font-size:11px;padding:0}#frame{width:100%;margin:0;padding:0;vertical-align:middle;border:0;height:15px}#cright{width:auto;padding:0;text-align:left;float:right}#cleft{width:60%;color:#afafaf;font-family:tahoma;font-size:11px;font-weight:700;margin:0;margin-top:3px;padding:2px;letter-spacing:0;text-align:left;float:left}.spoiler_head{color:#2A2A2A;font-weight:700;border:1px solid #C3CBD1;border-left:3px solid #C3CBD1;padding:3px;background:#E9E9E6;cursor:pointer}.spoiler_body{border:1px solid #C3CBD1;border-left:3px solid #C3CBD1;border-top:none;padding:3px;background:#F5F5F5}.layer{overflow:auto;height:450px;padding:5px}.spoiler-wrap{width:95%;margin:6px auto;clear:both;background:#E9E9E6;border:solid #C3CBD1;border-width:1px 1px 1px 2px;background-color:#f6f6f6}.clickable{cursor:pointer}.folded{background:transparent url(images/icon_plus.gif) no-repeat left center;padding-left:14px}.unfolded{background:transparent url(images/icon_minus.gif) no-repeat left center;padding-left:14px}.linked-image{margin:0;padding:0;border:0}.resized-linked-image{margin:1px 0 0;padding:0;background-color:#000;border:0;color:#FFF;font-size:10px;width:auto;-moz-border-radius-topleft:7px;-moz-border-radius-topright:7px}.resized-linked-image-zoom{width:200px;height:30px;background-color:#FFF;padding-top:6px;padding-left:5px;top:0;left:0;position:absolute;display:none}#highlighted{background-color:#FAFAFA}#highlighted tr:hover{background-color:#f1f1f1}#tooltip{background-color:#E9EFF5;border:2px solid #6AA6CC;color:#0E3A63;font:menu;margin:0;padding:3px 5px;position:absolute}.header6{float:right;padding:2px 2px 0 0}.header6 .banka{background:url(images/header_banka.png) no-repeat 0 0;width:468px;height:60px;padding:7px 66px 34px 7px}.header6 .banka img{width:468px;height:60px}.header6 a.buy_adv{display:block;background:url(images/header_banka.png) no-repeat 0 -106px;width:161px;height:28px;margin:-10px 50px 0 0;line-height:22px;text-align:center;font-family:Tahoma;font-size:11px;font-weight:700;color:#53c5f6;text-shadow:1px 1px 0 #294b58;text-decoration:none}.header6 a:hover.buy_adv{opacity:.8;-moz-opacity:.8;filter:alpha(opacity=80)}.error{color:#900;background-color:#FFF0F0;padding:7px;border:1px dashed #900;margin:5px}.error b{color:#900;background:inherit}.success{color:#000;background:#F5FBE1;padding:7px;margin:5px;border:1px dashed #7BA813}.success b{color:#7BA813;background:inherit}.editor{margin:0 0 1px;width:485px;height:21px;border:1px #D1D8EC solid}.editorinput{background:#FAFAFA;color:#000;border:1px #D1D8EC solid;font-size:11px;font-family:Verdana,Helvetica;text-decoration:none}.editorbutton{float:left;cursor:pointer;padding:2px 1px 0 5px}code{background:none;color:#00F;font-size:11px;font-family:Verdana,Helvetica}.code{color:#00B;font-size:11px;font-family:Verdana,Helvetica}a.copyright:link,a.copyright:visited,a.copyright:active{text-decoration:none;color:#FFF;border-top:dashed 1px #5087AD;padding:0}td.pager{background-color:#EFEFEF;border:0;padding:2px}td.pagebr{background-color:#EFEFEF;border:0;padding:0}td.highlight{background-color:#EFEFEF;border-bottom:1px dotted #3782B7;padding:2px}hr{height:0;border:solid #cacaca 0;border-top-width:1px}table{border-collapse:collapse;background-color:#efefef}table.main{background-color:#F4F5F9}table.mainouter{background-color:#e5e5e5;border:0;margin-top:-12px}table.bottom{color:#F4F5F9;background:transparent}table.main2{background-color:#F4F5F9;border:0}table.blok{background-color:#F4F5F9}h1{font-size:12pt;text-align:center}.colhead h1{font-size:8pt;text-align:left;margin:0;float:left}h2{background:#4ca1e4;border-radius:5px;border:0;color:#fff;font-size:10pt;height:18px;letter-spacing:1px;margin-bottom:0;margin-top:5px;text-align:center;text-shadow:1px 1px 1px #565656}.topnav{background-image:url(images/topnav.gif);background-position:top;padding:5px}h3{font-size:10pt;margin-bottom:5px;text-align:center}p{font-size:8pt}p.sub{margin-bottom:4pt}td{font-size:8pt;border:1px solid #E5E5E5}td.block{font-size:8pt;border:0;background-color:#1692C5}.block-title{text-shadow:0 1px 1px #175c77;color:#daeff7}td.right_menu{border:0}td.commenttable{background-color:#FFFEF2}td.embedded{border:none;text-align:left}td.bottom{border:none}td.heading{font-weight:700;border-left:0;background-color:#F5F5F5}td.heading_r{border-right:0}table.heading_b{border-bottom:0}td.text{padding:10pt;text-align:left}td.comment{padding:10pt;font-size:8pt;text-align:left}td.colhead{font-weight:700;color:#ECF6FA;background-image:url(images/header.png);background-color:#419ADF;border-color:#3782b7;text-shadow:0 1px 1px #397fb6}td.colhead2{font-weight:700;color:#ECF6FA;height:20px;background-image:url(images/header.gif);background-color:#419ADF;border-color:#3782b7;text-shadow:0 1px 1px #397fb6}td.colhead3{font-weight:700;color:#ECF6FA;height:20px;background-image:url(images/header2.png);background-color:#419ADF;border-color:#3782b7;text-shadow:0 1px 1px #397fb6}td.rowhead{font-weight:700;text-align:right;vertical-align:top}td.title{font-size:14pt}td.navigation{font-weight:700;font-size:10pt;border:none}form{margin-top:0;margin-bottom:0}.sublink{font-style:italic;font-size:7pt;font-weight:400}a:link,a:visited{text-decoration:none;color:#5b5b5b;font-weight:700;background-color:transparent!important}a:hover{color:#1582b0}a.index{font-weight:700}a.biglink{font-weight:700;font-size:12pt}a.online:link,a.online:visited{font-weight:400;text-decoration:none}a.menu:link,a.menu:visited{font-weight:400}a.menu:active{border-left:2px solid #dbe3e8;text-shadow:none}a.menu:hover{color:#117892;text-shadow:1px 1px 1px #dbe3e8;border-right:2px solid #c6d9e6;background-color:#f8f8f8!important;margin-right:6px}a.menu{display:block;padding-bottom:2px;margin-left:4px;font-weight:700}a.altlink_white:link,a.altlink_white:visited{font-weight:700;color:#666}a.altlink_white:hover{text-decoration:underline}.important{font-weight:700;font-size:8pt}div.popup{position:absolute;top:0;left:0;width:170px;height:85px;border:1px solid #000;display:none;background-color:ffffff}.red{color:#e00}.yellow{color:#970}.green{color:#000}input,select,textarea{margin-top:3px;margin-bottom:0;font-family:"tahoma";font-size:8pt}.small{font-size:7pt}.big{font-size:10pt}li{margin-top:6pt;margin-bottom:6pt}ul{margin-left:16pt;margin-top:0;margin-bottom:0}.startmenu{font-weight:700;text-align:center;padding:2px;margin:0;background-image:url(images/menu_head.gif)}.menutitle{font-weight:700;text-align:center;color:#7E110E;margin:2px;background-color:#FFC58C}input.button{border:solid #FFC58C 1px;background-color:#FFC58C}div#ajaxerror{background:#FDD url(images/err.gif) no-repeat 5px 50%;padding:5px 5px 5px 24px;text-align:left;font-family:Verdana,Arial,Helvetica,sans-serif;color:#333;font-size:11px}div#ajaxsuccess{background:#E7FFCE url(images/succ.gif) no-repeat 5px 50%;padding:5px 5px 5px 24px;text-align:left;font-family:Verdana,Arial,Helvetica,sans-serif;color:#333;font-size:11px}td.logo_cellpic{background:#e5e5e5 url(images/logo_cellpic.jpg) repeat-x;border:none}td.main_cellpic{background:#c7c7c7 url(images/main_cellpic.png) repeat-x;border:none;text-align:center;color:#626262!important;vertical-align:middle}td.main_space{background:#c7c7c7 url(images/main_cellpic.png) repeat-x;border:none}td.main_cellpic:hover{background:#C7C7C7 url(images/main_cellpic.png) repeat-x scroll 0 -39px;border:none;text-align:center;color:#000!important;cursor:pointer}td.main_l{background:#E5E5E5 url(images/main_l.png) no-repeat 0 -40px;border:none;width:22px;height:39px}td.main_r{background:#E5E5E5 url(images/main_l.png) no-repeat 0 0;border:none;width:22px;height:39px}td.main_bottom{background:#E5E5E5 url(images/main_bottom.jpg) no-repeat;border:none;height:51px;padding-left:40px}a.button27{position:relative;display:inline-block;width:4em;height:2em;line-height:2em;vertical-align:middle;text-align:center;text-decoration:none;color:#000;outline:none;border-radius:5px;box-shadow:0 0 0 1px #ddd inset,0 1px 1px #fff}a.button27:hover{background:#dcdcdc linear-gradient(#fff,#dcdcdc);box-shadow:0 0 0 1px #aaa inset,0 1px 1px #aaa}a.button27:active{background:none;box-shadow:0 0 0 1px #bbb inset,0 1px 3px rgba(0,0,0,.5) inset,0 1px 2px #fff}a.button26{position:relative;display:inline-block;width:5em;height:2em;line-height:2em;vertical-align:middle;text-align:center;text-decoration:none;color:#000;outline:none;border-radius:5px;box-shadow:0 0 0 1px #ddd inset,0 1px 1px #fff}a.button26:hover{background:#dcdcdc linear-gradient(#fff,#dcdcdc);box-shadow:0 0 0 1px #aaa inset,0 1px 1px #aaa}a.button26:active{background:none;box-shadow:0 0 0 1px #bbb inset,0 1px 3px rgba(0,0,0,.5) inset,0 1px 2px #fff}a.button25{position:relative;display:inline-block;width:6em;height:2em;line-height:2em;vertical-align:middle;text-align:center;text-decoration:none;color:#000;outline:none;border-radius:5px;box-shadow:0 0 0 1px #ddd inset,0 1px 1px #fff}a.button25:hover{background:#dcdcdc linear-gradient(#fff,#dcdcdc);box-shadow:0 0 0 1px #aaa inset,0 1px 1px #aaa}a.button25:active{background:none;box-shadow:0 0 0 1px #bbb inset,0 1px 3px rgba(0,0,0,.5) inset,0 1px 2px #fff}a.button24{position:relative;display:inline-block;width:6em;height:2em;line-height:2em;vertical-align:middle;text-align:center;text-decoration:none;color:#000;outline:none;border-radius:5px;box-shadow:0 0 0 1px #ddd inset,0 1px 1px #fff}a.button24:hover{background:#dcdcdc linear-gradient(#fff,#dcdcdc);box-shadow:0 0 0 1px #aaa inset,0 1px 1px #aaa}a.button24:active{background:none;box-shadow:0 0 0 1px #bbb inset,0 1px 3px rgba(0,0,0,.5) inset,0 1px 2px #fff}a.but:link{color:#696969;background-color:transparent}a.but:visited{color:#696969;background-color:transparent}a.but:hover{color:#FFF;background-color:transparent}a.but:active{color:red;background-color:transparent}td.main_bottom2{background:#E5E5E5 url(images/main_bottom2.jpg) no-repeat;border:none;height:51px;padding-right:30px;padding-left:10px}td.footer_cellpic{background:#CECECE url(images/foot_cellpic.jpg) repeat-x;border:none;height:45px}.vhr{margin-left:3px}td.rpan{background:#e5e5e5 url(images/rpan_bg.png) no-repeat;border:none;width:157px}td.comment_head{background:#d1d1d1;border:1px solid silver;font-weight:700;padding:0 7px 4px}td.comment_footer{background:#ededef url(images/comment_bottom_bg.jpg) repeat-x;border:1px solid #e5e7e6;color:#666;font-size:11px}a.reliz-lnk{color:#ecf6fa!important;font-weight:700;text-decoration:none}a.reliz-lnk-red{color:red!important;font-weight:700;text-decoration:none}.t-date{font-size:11px;font-family:tahoma;font-color:#424242}.rread-more{font-color:#1582b0!important;font-size:11px;font-family:tahoma}div.navigation{padding:.8em;border-bottom:1px solid #000}div.navigation a{font-size:13px;font-weight:700;margin-right:.5em;text-decoration:none}td.page_bottom:{border-bottom:1px solid #3782B7!important}a.lnk-m{text-shadow:0 1px 2px #fff}a.lnk-m:hover{border-bottom:1px dotted}.inputs{background:transparent url(images/srchbg.png) no-repeat 0 0;border:0 none;color:#5A5A5A;font-family:Tahoma,Verdana;font-size:8pt;height:22px;padding-left:19px;width:120px;display:block}.bg1{background-color:#E5E5E5}.bg2{background-color:#fff}.quote-title{color:#306A82!important;text-shadow:0 1px 1px #fff}.gallerycontainer{position:relative}.thumbnail img{border:1px solid #fff;margin:0 5px 5px 0}.thumbnail:hover{background-color:transparent}.thumbnail:hover img{border:1px solid blue}.thumbnail span{position:absolute;background-color:#ffffe0;padding:5px;left:-1000px;border:1px dashed gray;visibility:hidden;color:#000;text-decoration:none}.thumbnail span img{border-width:0;padding:2px}.thumbnail:hover span{visibility:visible;top:0;left:165px;z-index:50}.stepcarousel{position:relative;overflow:scroll;width:100%;height:95px}.stepcarousel .belt{position:absolute;left:0;top:0}.stepcarousel .panel{float:left;overflow:hidden;margin-right:8px;margin-top:0;width:119px;text-align:center}.stepcarousel .panel a{text-decoration:none!important;line-height:14px;color:#000}.stepcarousel .panel a:hover,.stepcarousel .panel a:hover h4{color:#e42828}.stepcarousel .panel img{display:block;margin-bottom:5px;margin-left:5px}.stepcarousel .panel span{font-size:10px;line-height:3px;color:#91a6b4;font-weight:strong}.highslide-html-content{position:absolute;display:none}.highslide-display-block{display:block}.highslide-display-none{display:none}.highslide-loading{display:block;color:#fff;font-size:9px;font-weight:700;text-decoration:none;padding:3px;border:1px solid #fff;background-color:#000}table.pm{font-size:11px;text-align:center}table.pm td.pm_head{background:#F5F5F5;padding:2px 2px 3px;border-right:0}table.pm td{border:1px solid #EEE;padding:2px 2px 3px;border-right:0}table.pm td:last-child{border-right:1px solid #EEE}td.a{background-color:#ececec;padding:6px;font-family:Verdana,Helvetica,sans-serif;font-size:8pt;border-style:solid;border-width:1px}td.b{background-color:#f7f7f7;padding:6px;font-family:Verdana,Helvetica,sans-serif;font-size:8pt;border-style:solid;border-width:1px}td.c{background-color:#90EE90;padding:6px;font-family:Verdana,Helvetica,sans-serif;font-size:8pt;border-style:solid;border-width:1px}a img{border:none}td.null{background:#FAFAFA;color:#000;border:0;font-family:tahoma;font-size:11px;padding:0}input.button4{position:relative;display:inline-block;font-family:Arial,Helvetica,FreeSans,"Liberation Sans","Nimbus Sans L",sans-serif;font-size:1.5em;font-weight:700;color:#f5f5f5;text-shadow:0 -1px rgba(0,0,0,.1);text-decoration:none;user-select:none;padding:.3em 1em;outline:none;border:none;border-radius:3px;background:#0c9c0d linear-gradient(#82d18d,#0c9c0d);box-shadow:inset #72de26 0 -1px 1px,inset 0 1px 1px #98ff98,#3caa3c 0 0 0 1px,rgba(0,0,0,.3) 0 2px 5px;-webkit-animation:pulsate 1.2s linear infinite;animation:pulsate 1.2s linear infinite}input.button4:hover{-webkit-animation-play-state:paused;animation-play-state:paused;cursor:pointer}input.button4:active{top:1px;color:#fff;text-shadow:0 -1px rgba(0,0,0,.3),0 0 5px #ffd,0 0 8px #fff;box-shadow:0 -1px 3px rgba(0,0,0,.3),0 1px 1px #fff,inset 0 1px 2px rgba(0,0,0,.8),inset 0 -1px 0 rgba(0,0,0,.05)}@-webkit-keyframes pulsate{50%{color:#fff;text-shadow:0 -1px rgba(0,0,0,.3),0 0 5px #ffd,0 0 8px #fff}}@keyframes pulsate{50%{color:#fff;text-shadow:0 -1px rgba(0,0,0,.3),0 0 5px #ffd,0 0 8px #fff}}a.button25{position:relative;display:inline-block;width:10em;height:2.5em;line-height:2.5em;vertical-align:middle;text-align:center;text-decoration:none;text-shadow:0 -1px 1px #777;color:#fff;outline:none;border:2px solid #F64C2B;border-radius:5px;box-shadow:0 0 0 60px rgba(0,0,0,0) inset,.1em .1em .2em #800;background:linear-gradient(#FB9575,#F45A38 48%,#EA1502 52%,#F02F17)}a.button25:active{top:.1em;left:.1em;box-shadow:0 0 0 60px rgba(0,0,0,.05) inset}a.button6{position:relative;font-weight:700;color:#fff;text-decoration:none;text-shadow:0 -1px 1px #c50;user-select:none;padding:.8em 2em;outline:none;border-radius:1px;background:linear-gradient(to left,rgba(0,0,0,.3),rgba(0,0,0,.0) 50%,rgba(0,0,0,.3)),linear-gradient(#d77d31,#fe8417,#d77d31);background-size:100% 100%,auto;background-position:50% 50%;box-shadow:inset #ebab00 0 -1px 1px,inset 0 1px 1px #ffbf00,#c72 0 0 0 1px,#000 0 10px 15px -10px;transition:.2s}a.button6:hover{background-size:140% 100%,auto}a.button6:active{top:1px;color:#ffdead;box-shadow:inset #ebab00 0 -1px 1px,inset 0 1px 1px #ffbf00,#c72 0 0 0 1px,0 10px 10px -9px #000}a.button10{display:inline-block;color:#000;font-size:125%;font-weight:700;text-decoration:none;user-select:none;padding:.25em .5em;outline:none;border:1px solid #faac11;border-radius:7px;background:#ffd403 linear-gradient(#ffd403,#f89d17);box-shadow:inset 0 -2px 1px rgba(0,0,0,0),inset 0 1px 2px rgba(0,0,0,0),inset 0 0 0 60px rgba(255,255,0,0);transition:box-shadow .2s,border-color .2s}a.button10:hover{box-shadow:inset 0 -1px 1px rgba(0,0,0,0),inset 0 1px 2px rgba(0,0,0,0),inset 0 0 0 60px rgba(255,255,0,.5)}a.button10:active{padding:calc(.25em+1px);border-color:rgba(177,159,0,1);box-shadow:inset 0 -1px 1px rgba(0,0,0,.1),inset 0 1px 2px rgba(0,0,0,.3),inset 0 0 0 60px rgba(255,255,0,.45)}a.button13{display:inline-block;width:15em;font-size:80%;color:rgba(255,255,255,.9);text-shadow:#2e7ebd 0 1px 2px;text-decoration:none;text-align:center;line-height:1.1;white-space:pre-line;padding:.7em 0;border:1px solid;border-color:#60a3d8 #2970a9 #2970a9 #60a3d8;border-radius:6px;outline:none;background:#60a3d8 linear-gradient(#89bbe2,#60a3d8 50%,#378bce);box-shadow:inset rgba(255,255,255,.5) 1px 1px}a.button13:first-line{font-size:170%;font-weight:700}a.button13:hover{color:#fff;background-image:linear-gradient(#9dc7e7,#74afdd 50%,#378bce)}a.button13:active{color:#fff;border-color:#2970a9;background-image:linear-gradient(#5796c8,#6aa2ce);box-shadow:none}#closemyprofile{cursor:pointer;text-decoration:none;position:absolute;top:4px;right:5px}div.closemyprofile{background:url(images/close.png) no-repeat;width:15px;height:15px;background-position:0 0}div.closemyprofile:hover{background-position:-16px 0;width:15px;height:15px}.screenshot img{margin:6px;padding:5px;-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;-moz-box-shadow:0 0 5px #6A6A6A;box-shadow:0 0 5px #6A6A6A;-webkit-box-shadow:0 0 5px #6A6A6A}table.tabs{background-color:transporent;border-collapse:collapse;border:0 none}table.tabs td{border:0 none;font:bold 11px Arial;color:#57533C;white-space:nowrap}table.tabs td a,table.tabs td a:visited{font-weight:700;color:#57533C;text-decoration:none}table.tabs td a:hover{color:#000}table.tabs td.active{background-image:url(../../pic/tabs/bg_active.gif);background-color:#000;color:#FFF}table.tabs td.notactive{background-image:url(../../pic/tabs/bg.gif);color:#57533C}table.tabs td.space{width:100%;background-image:none;text-align:right}table.ustats{border-collapse:separate;border:1px solid #000}table.ustats td{white-space:nowrap}table.ustats td.head{background-color:#000;border:1px solid #000;font-weight:700;font-size:7pt;color:#FFF}table.ustats td.cell{border:0 none;border-bottom:1px solid #DDD}table.ustats td.hhcell{background-color:#EEEEF8;border-top:1px solid #6FDF1B;border-bottom:1px solid #6FDF1B;border-left:0 none;border-right:0 none;color:#000}table.ustats td.hvcell{background-color:#EEEEF8;border-top:0 none;border-bottom:1px solid #DDD;border-left:1px solid #6FDF1B;border-right:1px solid #6FDF1B}table.ustats td.hccell{background-color:#6FDF1B;border-top:1px solid #F8C71E;border-bottom:1px solid #F8C71E;border-left:1px solid #F8C71E;border-right:1px solid #F8C71E;color:#000}table.ustats td.hhcell a,table.ustats td.hhcell a:visited,table.ustats td.hccell a,table.ustats td.hccell a:visited{font-weight:700;color:#000;text-decoration:none}table.ustats td.hhcell a:hover,table.ustats td.hccell a:hover{color:red}table.ustats td.foot{background-color:#F5F4EA;border:1px solid #F5F4EA;text-align:right;color:#000}table.ustats td.foot a,table.ustats td.foot a:visited{font-weight:400;color:#000;text-decoration:underline}table.ustats td.foot a:hover{color:red}img.main-arrowup{background:url(images/main_sprites.png);width:12px;height:12px}img.main-arrowdown{background:url(images/main_sprites.png) -12px 0;width:12px;height:12px}img.main-addbookmark{background:url(images/main_sprites.png) -24px 0;width:16px;height:16px}img.main-delbookmark{background:url(images/main_sprites.png) -40px 0;width:16px;height:16px}img.main-completed{background:url(images/main_sprites.png) -56px 0;width:16px;height:16px}img.main-bookmark{background:url(images/main_sprites.png) -72px 0;width:16px;height:16px}img.main-comments{background:url(images/main_sprites.png) -88px 0;width:16px;height:15px}img.main-inbox,img.main-inboxnew,img.main-sentbox,img.main-viewnfo{width:16px;height:16px}img.main-inbox{background:url(images/main_sprites.png) -104px 0}img.main-inboxnew{background:url(images/main_sprites.png) -120px 0}img.main-sentbox{background:url(images/main_sprites.png) -136px 0}img.main-viewnfo{background:url(images/main_sprites.png) -152px 0}img.main-buddylist{background:url(images/main_sprites.png) -168px 0;width:14px;height:14px}img.main-rss{background:url(images/main_sprites.png) -182px 0;width:14px;height:14px}img.main-magglass{background:url(images/main_sprites.png) -196px 0;width:11px;height:11px}img.main-multipage{background:url(images/main_sprites.png) -207px 0;width:8px;height:10px}img.main-warned2{background:url(images/main_sprites.png) -215px 0;width:13px;height:11px}img.main-warned{background:url(images/main_sprites.png) -228px 0;width:13px;height:11px}img.main-disabled{background:url(images/main_sprites.png) -241px 0;width:11px;height:11px}img.main-donor{background:url(images/main_sprites.png) -252px 0;width:11px;height:11px}img.main-warnedbig{background:url(images/main_sprites.png) -263px 0;width:16px;height:16px}img.main-disabledbig{background:url(images/main_sprites.png) -279px 0;width:16px;height:16px}img.main-donorbig{background:url(images/main_sprites.png) -295px 0;width:16px;height:16px}img.main-bluray{background:url(images/main_sprites.png) -311px 0;width:30px;height:15px!important}img.main-top{background:url(images/main_sprites.png) -341px 0;width:15px;height:13px}img.main-button_pm{background:url(images/main_sprites.png) -356px 0;width:25px;height:15px}img.main-new{background:url(images/main_sprites.png) -381px 0;width:27px;height:11px}img.main-updated{background:url(images/main_sprites.png) -408px 0;width:46px;height:11px}img.main-bar_left{background:url(images/main_sprites.png) -454px 0;width:2px;height:9px}img.main-bar_right{background:url(images/main_sprites.png) -456px 0;width:2px;height:9px}#tablelegend{width:48.5%;float:left;text-align:right}#searchtips{width:48.5%;float:right;text-align:left}#searchtips span{font-family:monospace;font-weight:700}.torrenttable tfoot,span.dvd5-sized,span.zero-month{color:grey}.torrenttable tfoot ol{list-style:none;margin:0;padding:0}.torrenttable tfoot li{margin:2px 0;line-height:16px}.torrenttable img,.torrenttable tfoot td,h1 img,img{border:none}.voted{color:#999}.thanks{color:#36AA3D}.static{color:#5D3126}div.scrollup{position:fixed;color:#fff;background-color:#286090;right:20px;bottom:0;padding:4px 10px;font-size:20px;border-top-left-radius:4px;border-top-right-radius:4px;cursor:pointer;display:none;text-align:center}div.scrollup:hover{background-color:#000}td.myhighlight{background-color:#EFEEE6;border:1px solid #D9D7C4;padding:0}.fas{margin-right:.3em;margin-left:.3em;-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:inline-block;font-style:normal;font-variant:normal;text-rendering:auto;line-height:1;font-family:Font Awesome 5 Pro;font-weight:900}.fa-tag:before{content:"\F02B"}.tooltipss{font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-style:normal;line-height:1.428571429;line-break:auto;text-align:start;text-decoration:none;text-shadow:none;text-transform:none;letter-spacing:normal;word-break:normal;word-spacing:normal;word-wrap:normal;white-space:normal;font-size:12px}.badge-extra{display:inline-block;min-width:10px;padding:3px 7px;font-size:10px;font-weight:400;line-height:1;vertical-align:middle;text-align:center;background-color:transparent;border-radius:2px;margin-left:2px;white-space:nowrap;border:1px solid #E0FFFF;border-radius:6px;background:rgba(76,79,80,.14)}.text-bold{font-weight:700}.badge-extra{float:left}.badges-extras{display:inline-block;min-width:10px;padding:3px 7px;font-size:10px;font-weight:400;line-height:1;vertical-align:middle;text-align:center;background-color:transparent;border-radius:2px;margin-left:2px;white-space:nowrap;border:1px solid #E0FFFF;border-radius:6px;background:rgba(76,79,80,.14)}.texts-bolds{font-weight:700}.badges-extras{float:center}details summary{background-color:#DCDCDC;margin-left:5px;width:200px;height:15px;padding:4px;cursor:pointer;color:#696969;font-weight:700;border-radius:5px;border:1px solid #C0C0C0}details div.spoiler{background-color:#ececec;border:1px solid #C0C0C0;border-radius:5px;padding:10px;width:avto;}details[open] div.spoiler{animation:slide .5s}@keyframes slide{0%{opacity:0;transform:translate(0,-20px)}100%{opacity:1;transform:translate(0,0)}}details.desc> summary::after{margin-left:5px;content:attr(data-close)}details.desc[open]>summary::after{content:attr(data-open);margin-left:5px}
</style><link rel="stylesheet" href="themes/<?=$ss_uri;?>/<?=$ss_uri;?>.css"/><?=get_head();?><?
if($keywords){echo "<meta name='keywords' content='$keywords'>";}if($description){echo "<meta name='description' content='$description'>";}?>
<div id="myprofile" style="display:none;position:fixed;margin-top:0;margin-left:450px;border:2px solid #bdbdbd;-moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px;align:center;text-align:center;background:#008080;box-shadow:1px 1px 5px #5d5d5d;-moz-box-shadow:1px 1px 5px #5d5d5d;-webkit-box-shadow:1px 1px 5px #5d5d5d;">
<?$usernames = iconv('cp1251', 'UTF-8', $CURUSER["username"]);$iduser = $CURUSER["id"];$uped = mksize($CURUSER['uploaded']);$downed = mksize($CURUSER['downloaded']);
if ($CURUSER["downloaded"] > 0){$ratio = $CURUSER['uploaded'] / $CURUSER['downloaded'];$ratio = number_format($ratio, 3);}
elseif($CURUSER["uploaded"] > 0) $ratio = "<img src='pic/captcha_init.gif' alt='Inf.' title='Inf.'/>";else $ratio = "<img src='pic/captcha_init.gif' alt='Inf.' title='Inf.'/>";
if($CURUSER['donor'] == "yes") $medaldon = "<img src='pic/star.gif' alt='Донор' title='Донор'/>";
if($CURUSER['warned'] == "yes") $warn = "<img src='pic/warned.gif' alt='Предупрежден' title='Предупрежден'/>";$activeseed = $CURUSER["seeder"];$activeleech = $CURUSER["leecher"];
switch ($CURUSER['class']){case '0':$maxtorrents = "1";break;case '1':$maxtorrents = "5";break;case '2':$maxtorrents = "10";break;
case '3':$maxtorrents = "15";break;case '4':$maxtorrents = "25";break;case '5':$maxtorrents = '50';break;case '6':$maxtorrents = 'inf.';break;
case '7':$maxtorrents = 'inf.';break;case '8':$maxtorrents = 'inf.';break;case '9':$maxtorrents = 'inf.';break;case '10':$maxtorrents = 'inf.';
break;case '11':$maxtorrents = 'inf.';}$maxtorrentss = $maxtorrents;$activeleech = $activeleech." / ".$maxtorrentss;$bonuss = $CURUSER["bonus"];
if(get_user_class() >= UC_MODERATOR){$usrclass = "&nbsp;<a href='sclass'><img src='pic/warning.gif' title='Сменить временно КЛАСС' alt='Сменить временно КЛАСС' border='0'/></a>&nbsp;";}
echo "<table cellpadding='0' style='background:none;color:white;' cellspacing='0' valign='top' border='0' width='400px' height='200px' style='border:0;'><tr style='border:0;'><td align='left' width='80%' style='background:none;color:white;border:0;valign:top;'><div style='padding:5px' style='border:0;' valign='top'>".$tracker_lang['welcome_back']."<a href='user_".$CURUSER["id"]."'><b>".get_user_class_color($CURUSER["class"], $usernames)."</b></a>$usrclass$medaldon$warn<hr></div></td>
<td align='right' width='20%' style='border:0;'><div style='padding:5px;border:0;'>
<a href='javascript://' onclick=\"$('#myprofile').fadeOut('fast');\"><img src='pic/close.png'/></a></div></td></tr>
<tr style='border:0;'><td align='left' width='60%' style='padding-left:4px;padding-bottom:2px;text-align:left;border:0;'>
<div style='padding-left:2px' style='border:0;'><b style='color:#D3D3D3;'>ЛС:</b>&nbsp;&nbsp;<a href='message' title='ЛС'><img height='16px' style='border:none' alt='ЛС' title='ЛС' src='pic/pn_inbox.gif'/></a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href='friends' title='Друзья'><b style='color:#D3D3D3;'>Друзья</b></a>&nbsp;<img style='border:none;' alt='Друзья' title='Друзья' src='pic/buddylist.gif'/>&nbsp;&nbsp;||&nbsp;&nbsp;<a href='group' title='Релиз-группы'><b style='color:#D3D3D3;'>Группы</b></a><br>
<br><b style='color:#D3D3D3;'>Рейтинг:</b>&nbsp;<font color='#FFFFFF'>$ratio</font><br><br><b style='color:#D3D3D3;'>Раздал:</b>&nbsp;
<font color='#FFFFFF'>$uped</font>&nbsp;&nbsp;<b style='color:#D3D3D3;'>Скачал:</b>&nbsp;<font color='#FFFFFF'>$downed</font><br><br>
<b style='color:#D3D3D3;'>Релизы:</b>&nbsp;<font color='#FFFFFF'><span class='smallfont'>$activeseed</span></font><font size='4' color='green' alt='Раздаю' title='Раздаю'>&#9650;</font><font size='4' color='red' alt='Качаю' title='Качаю'>&#9660;</font><font color='#FFFFFF'><span class='smallfont'>$activeleech</span></font><br>
<br><b style='color:#D3D3D3;'>Мой Бонус:</b>&nbsp;<a href='mybonus' class='online' title='Мой Бонус'><font color='#FFFFFF'>$bonuss</font></a>&nbsp;
<img style='border:none;' src='pic/gold.gif'/><br><br><a href='usercp' title='Редактировать Профиль'><b style='color:#D3D3D3;'>Редактировать Профиль</b></a>&nbsp;&nbsp;||&nbsp;&nbsp;
<a href='myrelease' title='Мои Релизы'><b style='color:#D3D3D3;'>Мои Релизы</b></a><br><br>
<a href='bookmarks' title='Мои Закладки Релизов'><b style='color:#D3D3D3;'>Закладки Релизов</b></a><br><br></div></td><td align='right' width='40%' style='border:0;'>
<div class='screenshot'><a href='user_".$CURUSER['id']."'>";
if($CURUSER["avatar"]){echo "<img style='border-radius:5px;border:0;width:100px;' alt='Посмотреть мой профиль' title='Посмотреть мой профиль' align='center' src='".$CURUSER["avatar"]."'/>";}
else{echo "<img style='border-radius:5px;border:0;width:100px;' align='center' alt='Посмотреть мой профиль' title='Посмотреть мой профиль' src='pic/default_avatar.gif'/>";}
echo "</a></div></td></tr></table>";?></div><?$datum = getdate();$datum[hours] = sprintf("%02.0f", $datum[hours]);$datum[minutes] = sprintf("%02.0f", $datum[minutes]);
$datum[seconds] = sprintf("%02.0f", $datum[seconds]);$check_mes = "<div id='getNewMes' align='left' style='width:200px;'><font size='-2'>Загрузка...</font></div>";?></head>
<body width="100%"><table style="background:none;cellspacing:0;cellpadding:0;width:100%;">
<tr><td style="background:none;width:100%;border:0;"><table width="100%" class="clear" align="center" border="0" cellspacing="0" cellpadding="0" style="background:transparent;"><tr>
<td style='background: linear-gradient(0deg, rgb(227, 227, 227) 66%, rgb(237, 237, 237));'><a href="<?=$DEFAULTBASEURL?>"><img style='margin-left:0px;border:0;' alt="У нас вы найдете только качественные рипы" title="У нас вы найдете только качественные рипы" src='pic/logo_leto.png'/></a></td>
<td style='background: linear-gradient(0deg, rgb(227, 227, 227) 66%, rgb(237, 237, 237));'><center><div class="header6"><div class="banka"><a href="UHD" title="UHD 4K релизы"><img src="pic/UHDBanka.jpg" width="468" height="60" border="0" title="UHD 4K релизы" alt="UHD 4K релизы"/></a>
<?if($CURUSER['override_class'] != 255 && $CURUSER){print("<br><br><table align='center' width='98%' cellpadding='0' cellspacing='0' border='0'><center><td style='padding:10px;background:green'><center><b><a href='restoreclass'><font color='white'>".$tracker_lang['lower_class']."</font></a></b></center></td></center></table>");}?>
</div></div></center></td></tr></table></td></tr><tr><td style="background:none;width:100%;text-align:center;border:0;">
<table align="center" style="background:none;cellspacing:0;cellpadding:0;width:98%;"><tr><td style="border-radius:15px;border:none;" class='a'>
<table style="background:none;width:100%;border:0;"><tr><td class="zaliwka" style="color:white;colspan:14;height:30px;font-weight:bold;font-size:14px;border:0;border-radius:5px;">
<table align="center" style="background:none;cellspacing:0;cellpadding:0;width:98%;"><tr><? //прописать ваши данные!// ссылки в меню //?>
<td style="background:none;width:100%;text-align:center;font-size:12px;border:0;"><a class="but" title="Home" href="/">Home</a>&nbsp;•&nbsp;<a class="but" href="browse" title="Browse">Browse</a><?if(get_user_class() >= UC_UPLOADER){?>&nbsp;•&nbsp;<a class="but" title="Upload" href="upload">Upload</a><?}?>&nbsp;•&nbsp;<a class="but" title="Requests" href="zakaz.php">Requests</a>&nbsp;•&nbsp;<a class="but" title="Privat Chat" href="chat">Chat</a>&nbsp;•&nbsp;<a class="but" title="Forum" href="forum.php">Forum</a>&nbsp;•&nbsp;<a class="but" title="Rules" href="rules">Rules</a>&nbsp;•&nbsp;<a class="but" title="FAQ" href="faq">FAQ</a>&nbsp;•&nbsp;<a class="but" title="Staff" href="team">Staff</a>&nbsp;•&nbsp;<a class="but" title="Users" href="users">Users</a></td>
<?if(get_user_class() >= UC_SYSOP){?>
<td style="background:none;border:0;"><a alt="AdminPanel" href="admincp.php"><img style='margin-top:0;margin-right:10px;' align='right' border='0' src="pic/adcp.png" alt="AdminPanel"/></a></td><?}?>
<td style="background:none;border:0;"><a href="javascript://" onclick="$('#myprofile').fadeIn('fast');" title='Profile' alt='Profile'><img style='margin-top:0;margin-right:10px;' align='right' border='0' src="pic/profs.png" alt="Profile"/></a></td>
<td style="background:none;border:0;"><a alt="Logout" href="logout"><img style='margin-top:0;margin-right:10px;' align='right' border='0' src="pic/logout.png" alt="Logout"/></a></td>
<td style="background:none;border:0;"><a alt="Русский" href="rus"><img style='margin-top:0;margin-right:10px;' align='right' border='0' src="pic/russia.png" alt="RUS"/></a></td>
<td style="background:none;border:0;"><a alt="Украинский" href="ukr"><img style='margin-top:0;margin-right:10px;' align='right' border='0' src="pic/ukr.gif" alt="UA"/></a></td>
<td style="background:none;border:0;"><a alt="English" href="usa"><img style='margin-top:0;margin-right:10px;' align='right' border='0' src="pic/usa.png" alt="ENG"/></a></td>
<td style="background:none;border:0;"><a href="grss" title="RSS"><img style='border:none;margin-top:0;margin-right:10px;' align='right' alt="RSS" title="RSS" src="pic/rssf.png"/></a></td>
<td style="background:none;border:0;"><a href="https://t.me/" target="_blank"><img style='margin-top:0;margin-right:0px;' align='right' border='0' alt="Telegram" title="Telegram" src="pic/tlgr.png"/></a>
</td><td style="background:none;width:100%;text-align:right;border:0;float:right;"><form name="srch" method="get" action="browse"><div style="padding-left: 13px;"><div class="inputs">
<div align="center" style="position:relative;"><script src="js/suggest0.js"></script>
<input id="suggestinput0" type="text" style="padding:0px 0px;background-image:none;width:117px ! important;" class="inputs" onblur="if(this.value=='') this.value='torrent search...';" name="search" value="torrent search..." onfocus="if(this.value=='torrent search...') this.value='';"/>
<div style='float:center;' id="suggest0"></div></div></div></div></form></td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;"></td></tr>
</table></td></tr></table></td></tr><tr><td style="background:none;width:100%;text-align:center;border:0;">
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr><td style="background:#f7f7f7;border-radius:10px;border:none;">
<table style="background:none;width:100%;float:center;border:0;"><tr><td style="width:98%;text-align:center;border:0;border-radius:10px;background:#ececec;">
<table align="center" style='background:none;border:0;width:100%;cellpadding:4;cellspacing:0;' class="a">
<tr><td align="left" width="560px" style='background:none;border:2px;margin-left:15px;cellspacing:0;'>
<?if($CURUSER["newmess"] == 0){$messagaimg = "<a href='message' title='ЛС'><img height='16px' style='border:none;' alt='ЛС' title='ЛС' src='pic/pn_inbox.gif'/></a>";
$messaga = "";}elseif($CURUSER["newmess"] == 1){
$messaga = "<td class='bottom' align='left'><table align='left' width='200px' cellpadding='0' cellspacing='0' border='0'><td align='left' style='padding:10px;background:darkred;'><center><a href='message'><b style='color:white;'>".$CURUSER["newmess"]." новое сообщение!</b></a></center></td></table></td>";
$messagaimg = "<a href='message' title='ЛС'><img height='16px' style='border:none' alt='ЛС' title='ЛС' src='pic/pn_inboxnew.gif'/></a>";
}else{$messaga = "<td class='bottom' align='left'><table align='left' width='200px' cellpadding='0' cellspacing='0' border='0'><td align='left' style='padding:10px;background:darkred;'><center><a href='message'><b style='color:white;'>".$CURUSER["newmess"]." новых сообщений!</b></a></center></td></table></td>";
$messagaimg = "<a href='message' title='ЛС'><img height='16px' style='border:none;' alt='ЛС' title='ЛС' src='pic/pn_inboxnew.gif'/></a>";}
/////////////////////////////
print "<span class='smallfont'>".$tracker_lang['welcome_back']."<a class='users' href='user_".$CURUSER['id']."' onClick='user_".$CURUSER['id']."'><b>".get_user_class_color($CURUSER['class'], $usernames)."</b></a><b>!</b> ".$medaldon.$warn."</span>&nbsp;•&nbsp;<b>".$tracker_lang['bookmarks'].":</b>&nbsp;<a href='bookmarks' title='".$tracker_lang['bookmarks']." Релизов'>Релизов</a><br>
<font color='#1900D1'>Рейтинг:</font> ".$ratio."&nbsp;•&nbsp;<font color='green'>Раздал:</font>&nbsp;<font color='black'>".$uped."</font>&nbsp;•&nbsp;<font color='darkred'>Скачал:</font> <font color='black'>".$downed."</font>&nbsp;•&nbsp;<font color='darkblue'>Бонус:</font> <a href='mybonus' class='online' style='color:black;'>".$CURUSER["bonus"]."</a>
&nbsp;•&nbsp;<font color='#1900D1'>Торренты:&nbsp;<font color='green'><span class='smallfont'>".$activeseed."</span></font><font size='4' color='green' alt='Раздаю' title='Раздаю'>&#9650;</font><font size='4' color='red' alt='Качаю' title='Качаю'>&#9660;</font><font color='red'><span class='smallfont'>".$activeleech."</span></font>&nbsp;".$messagaimg."&nbsp;<a href='friends' title='Друзья'><img style='border:none' alt='Друзья' title='Друзья' src='pic/frnds.png'/></a>";?>
</td><?global $CacheBlock, $freleechBlock_Refresh;$_cache2 = 'freleech.cache';if(!$CacheBlock->Check($_cache2, $freleechBlock_Refresh?0:360000)){
$res = mysql_query("SELECT freeleech.value FROM freeleech WHERE name = 'freeleech'") or die(mysql_error());$row = mysql_fetch_array($res);$content.= "";switch ($row['value']){case 'no':$frels = "";break;
case 'gold':$frels = "<td class='bottom' align='center' style='background:none;margin-left:0px;padding:0px;border:0px;'><a href='faq#17'><img align='center' src='pic/freedownload.gif' style='border:0pt none;' alt='Сейчас действует Золотой Фрилич' title='Сейчас действует Золотой Фрилич'/></a>
<b align='left' style='padding:0px;border:0px;color:#d08700;'>Золотой Фрилич</b><br><b style='color:#999966;'>Только АПЛОАД !</b></td>";break;
case 'brill':$frels = "<td class='bottom' align='center' style='background:none;padding:0px;border:0px;'><a href='faq#17'><img align='center' src='pic/brill.gif' style='border:0pt none;' alt='Сейчас действует Бриллиантовый Фрилич' title='Сейчас действует Бриллиантовый Фрилич'/></a><b align='left' style='padding:0px;border:0px;color:blue;'>Бриллиантовый Фрилич</b><br><b style='color:'#999966;'>Двойной АПЛОАД !</b></td>";break;}
$frelss = $frels;$content.="$frelss";$CacheBlock->Write($_cache2, $content);}else{echo($CacheBlock->Read($_cache2));}?>
<?=$messaga?><td class="bottom" align="center" style='background:none;width:150px;padding:0px;border:0px;'><span class="smallfont"><b>Current time:</b> <span id="clock">Загрузка...</span><br>
<script>function refrClock(){var d=new Date();var s=d.getSeconds();var m=d.getMinutes();var h=d.getHours();var day=d.getDay();var date=d.getDate();var month=d.getMonth();var year=d.getFullYear();var am_pm;if (s<10) {s="0" + s}if (m<10) {m="0" + m}if (h>12){h-=12;am_pm = "<b>PM</b>"}else {am_pm="<b>AM</b>"}if (h<10) {h="0" + h}document.getElementById("clock").innerHTML=h + ":" + m + ":" + s + " " + am_pm;setTimeout("refrClock()",1000);}refrClock();
</script></span></td></tr></table></td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;"></td></tr></table></td></tr></table></td></tr>
<tr><td style="width:100%;border:none;"><table class="mainouter" style="width:100%;border:0;margin-top:3px;cellspacing:0;cellpadding:5;"><td valign="top" width="160px">
<?show_blocks("l");?></td><td align="center" width="100%" valign="top" class="outer" style="padding-bottom:5px"><?show_blocks('b');show_blocks('c');}}
////////////////
function stdfoot(){global $CURUSER, $tracker_lang, $queries, $tstart, $query_stat, $querytime, $rootpath;
if($CURUSER){?><?show_blocks('d');?><?show_blocks('f');?></td><td valign="top" width="155px"><?show_blocks('r');?></td></table></td></tr><tr>
<td style="width:98%;border:none;float:center;"><center><table style="color:#F4F5F9;background:none;cellspacing:0;cellpadding:0;" width="98%"><tr>
<td style="border-radius:15px;border:none;" width="98%" class="a"><div align="center"><a href="#top" style="position:fixed;bottom:0pt;right:0pt;"><font size='6'>⮉</font></a></div>
<table width="100%" style="background:none;border:0;"><tr><td width="100%" class="zaliwka" style="colspan:16;font-size:14px;text-align:center;border:0;border-radius:5px;">
<a href='#'>&#9650;&nbsp;&nbsp;UP&nbsp;&nbsp;&#9650;</a></td></tr><tr><td width="100%" style="background:none;text-align:center;color:#808080;border:0;">
<? $secondss = (timer() - $tstart);if($secondss < 0){$seconds = 0;$percentphp = 0;$percentsql = 0;}else{$seconds = $secondss;
$phptime = $seconds - $querytime;$query_time = $querytime;$percentphp = number_format(($phptime/$seconds) * 100, 2);$percentsql = number_format(($query_time/$seconds) * 100, 2);
$seconds = substr($seconds, 0, 8);}$memory = mksize(round(@memory_get_usage()));if($queries < 1){$queries = 0;}else{$queries;}
$queries_staff = (" <b>$queries</b> queries (<b>$percentphp%</b>  PHP / <b>$percentsql%</b> MySQL). Server memory wasted => $memory");
print("<b>".LoLi."<br>Page generated in <b>".$seconds."</b> seconds with ".$queries_staff."");?>
</td></tr></table></td></tr></table></center></td></tr></table></td></tr></body></html><?}
if(get_user_class() >= UC_MODERATOR){if(DEBUG_MODE && count($query_stat)){?><table><?foreach ($query_stat as $key => $value){
print('<li>['.($key+1).'] => '.($value['seconds'] > 0.01 ? '<b style="color:red;" title="Рекомендуется оптимизировать запрос. Время исполнения превышает норму.">'.$value['seconds'].'</b>' : '<b style="color:green;" title="Запрос не нуждается в оптимизации. Время исполнения допустимое.">'.$value['seconds'].'</b>').'</b> ['.htmlspecialchars_uni($value['query']).']');}?></table><?}}}
//////////////////////////////
function genbark($x,$y){stdhead($y);begin_frame(".:: ".$y." ::.");?><table cellpadding="0" cellspacing="0" border="0" width="100%">
<center><?=htmlspecialchars_uni($x);?></center></table><?end_frame();stdfoot();exit();}
///////////////////////
function mksecret($length = 20){
$set = array('a','A','b','B','c','C','d','D','e','E','f','F','g','G','h','H','i','I','j','J','k','K','l','L','m','M','n','N','o','O','p','P','q','Q','r','R','s','S','t','T','u','U','v','V','w','W','x','X','y','Y','z','Z','1','2','3','4','5','6','7','8','9');
$str;for($i = 1; $i <= $length; $i++){$ch = rand(0, count($set)-1);$str .= $set[$ch];}return $str;}
///////////////////////
function httperr($code = 404){$sapi_name = php_sapi_name();if($sapi_name == 'cgi' OR $sapi_name == 'cgi-fcgi'){header('Status: 404 Not Found');}else{
header('HTTP/1.1 404 Not Found');}exit;}
//////////////////////
function gmtime(){return strtotime(get_date_time());}
///////////////////////
function logincookie($id, $passhash, $language, $updatedb = 1, $expires = 0x7fffffff){
$subnet = explode('.', getip());$subnet[2] = $subnet[3] = 0;$subnet = implode('.', $subnet); // 255.255.0.0
setcookie(COOKIE_UID, $id, $expires, '/');setcookie(COOKIE_PASSHASH, md5($passhash.COOKIE_SALT.$subnet), $expires, '/');setcookie("lang", $language, $expires, "/");
if($updatedb)mysql_query('UPDATE users SET last_login = NOW() WHERE id = '.$id);}
/////////////////////////
function logoutcookie(){setcookie(COOKIE_PASSHASH, '', 0x7fffffff, '/');setcookie("lang", $language, $expires, "/");}
///////////////
function deletetorrent($id){
$images = mysql_fetch_array(sql_query('SELECT image1 FROM torrents WHERE id = '.$id));if($images){for($x=1; $x <= 2; $x++){
if($images['image'.$x] != '' && file_exists('torrents/images/'.$images['image'.$x]))unlink('torrents/images/'.$images['image'.$x]);}}
@unlink('include/cache/flist'.intval($id).'.cache');
sql_query('DELETE FROM torrents WHERE id = '.$id);	   
sql_query('DELETE FROM snatched WHERE torrent = '.$id);
sql_query('DELETE FROM bookmarks WHERE torrentid = '.$id);
sql_query('DELETE FROM comments WHERE torrentid = '.$id);
foreach(explode('.','peers.comments') as $x)sql_query('DELETE FROM '.$x.' WHERE torrent = '.$id);
sql_query('DELETE FROM torrents_scrape WHERE tid = '.$id);unlink('torrents/'.$id.'.torrent');}
//////////////////////////
function pager($rpp, $count, $href, $opts = array()){$pages = ceil($count / $rpp);
if(!isset($opts['lastpagedefault']))$pagedefault = 0;else{$pagedefault = floor(($count - 1) / $rpp);if ($pagedefault < 0)$pagedefault = 0;}
if(isset($_GET['page'])){$page = 0 + (int) $_GET['page'];if($page < 0)$page = $pagedefault;}else $page = $pagedefault;
$pager = "<td class='pager' style='background:none;'><b>Страницы:</b>&nbsp;</td>";
$pager2 = "";$bregs = "";$mp = $pages - 1;$as = "<b>«</b>";
if($page >= 1){$pager .= "<td class='pager' style='background:none;'><a href='index_".($page - 1)."' style='text-decoration:none;'>$as</a></td><td class='pagebr' style='background:none;'>&nbsp;</td>";}
$as = "<b>»</b>";if ($page < $mp && $mp >= 0){$pager2 .= "<td class='pager' style='background:none;'><a href='index_".($page + 1)."' style='text-decoration:none;'>$as</a></td>$bregs";
}else $pager2 .= $bregs;if($count){$pagerarr = array();$dotted = 0;$dotspace = 3;$dotend = $pages - $dotspace;$curdotend = $page - $dotspace;$curdotstart = $page + $dotspace;
for($i = 0; $i < $pages; $i++){
if(($i >= $dotspace && $i <= $curdotend) || ($i >= $curdotstart && $i < $dotend)){if(!$dotted)$pagerarr[] = "<td class='pager' style='background:none;border:none;'>...&nbsp;</td>";$dotted = 1;continue;}
$dotted = 0;$start = $i * $rpp + 1;$end = $start + $rpp - 1;if ($end > $count)$end = $count;$text = $i+1;
if($i != $page)$pagerarr[] = "<td class='pager' style='background:none;border:none;'><a title='$start&nbsp;-&nbsp;$end' href='index_$i' style='text-decoration:none;border:none;'><b>$text</b></a>&nbsp;</td>";
else $pagerarr[] = "<td style='background:white;border-radius:5px;border:none;color:red;width:20px;height:20px;text-align:center;'><b>$text</b></td><td class='pager' style='background:none;border:none;'>&nbsp;</td>";}
$pagerstr = join("", $pagerarr);if($i > 1){
$pagertop = "<table style='background:none;cellspacing:0;cellpadding:0;width:550px;float:center;border:none;'><tr><td style='border-radius:15px;border:none;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td class='zaliwka' style='color:#FFFFFF;colspan:16;font-size:18px;text-align:center;border:0;border-radius:5px;'>
<table style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'>$pager $pagerstr $pager2<script>
function to_page_click(){var to_page_num = document.to_page.to_page_num.value;to_page_num = parseInt(to_page_num) + 0;var url = '/index_';url= url.replace(/\&amp;/g,'&');
if(to_page_num >= 1 ){to_page_num = to_page_num - 1;window.location = url + to_page_num;}else alert('Вы должны ввести номер страницы');}</script>
<td class='pager' style='background:none;'><form name='to_page'><input name='to_page_num' value='' size='4'/>
<input type='button' name='to_page_btn' value='Перейти' onclick='to_page_click();'/></form></td></table></td>
</tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table>";
$pagerbottom .= "<table style='background:none;cellspacing:0;cellpadding:0;width:550px;float:center;border:none;'><center>
<tr><td align='center' style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'>
<span class='badges-extras texts-bolds' style='font-weight:normal;color:#696969;'>Найдено всего: <b style='color:#800000;'>$count</b> на <b style='color:#4169E1;'>$i</b> страницах по <b style='color:#4169E1;'>$rpp</b> на каждой странице</span></td></tr>
<tr><td style='border-radius:15px;border:none;' class='a'><table style='background:none;width:100%;float:center;border:0;'><tr><td class='zaliwka' style='color:#FFFFFF;colspan:16;font-size:18px;text-align:center;border:0;border-radius:5px;'>
<table style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'>$pager $pagerstr $pager2";
if($i > 1){$pagerbottom .= "<script>
function to_page_clicks(){var to_page_nums = document.to_pages.to_page_nums.value;to_page_nums = parseInt(to_page_nums) + 0;var url = 'index_';url= url.replace(/\&amp;/g,'&');
if(to_page_nums >= 1 ){to_page_nums = to_page_nums - 1;window.location = url + to_page_nums;}else alert('Вы должны ввести номер страницы');}</script>
<td class='pager' style='background:none;'><form name='to_pages'><input name='to_page_nums' value='' size='4'/>
<input type='button' name='to_page_btn' value='Перейти' onclick='to_page_clicks();'/></form></td>";}$pagerbottom .= "</table></td>
</tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table>";}
}else{$pagertop = $pager;$pagerbottom = $pagertop;}$start = $page * $rpp;return array($pagertop, $pagerbottom, "LIMIT $start,$rpp");}
///////////////////////////////
function pager2($rpp, $count, $href, $opts = array()){$pages = ceil($count / $rpp);
if(!isset($opts['lastpagedefault']))$pagedefault = 0;else{$pagedefault = floor(($count - 1) / $rpp);if($pagedefault < 0)$pagedefault = 0;}
if(isset($_GET['page'])){$page = 0 + (int) $_GET['page'];if ($page < 0)$page = $pagedefault;}else $page = $pagedefault;
$pager = "<td class='pager' style='background:none;'><b>Страницы:</b>&nbsp;</td>";$pager2 = "";$bregs = "";$mp = $pages - 1;$as = "<b>«</b>";
if($page >= 1){$pager .= "<td class='pager' style='background:none;'><a href='".$href."page=".($page - 1)."' style='text-decoration:none;'>$as</a></td><td class='pagebr' style='background:none;'>&nbsp;</td>";}
$as = "<b>»</b>";if($page < $mp && $mp >= 0){$pager2 .= "<td class='pager' style='background:none;'><a href='".$href."page=".($page + 1)."' style='text-decoration:none;'>$as</a></td>$bregs";
}else $pager2 .= $bregs;if($count){$pagerarr = array();$dotted = 0;$dotspace = 3;$dotend = $pages - $dotspace;$curdotend = $page - $dotspace;
$curdotstart = $page + $dotspace;for($i = 0; $i < $pages; $i++){if(($i >= $dotspace && $i <= $curdotend) || ($i >= $curdotstart && $i < $dotend)){
if(!$dotted)$pagerarr[] = "<td class='pager' style='background:none;border:none;'>...&nbsp;</td>";$dotted = 1;continue;}$dotted = 0;
$start = $i * $rpp + 1;$end = $start + $rpp - 1;if($end > $count)$end = $count;$text = $i+1;
if($i != $page)$pagerarr[] = "<td class='pager' style='background:none;border:none;'><a title='$start&nbsp;-&nbsp;$end' href='".$href."page=$i' style='text-decoration:none;'><b>$text</b></a>&nbsp;</td>";
else $pagerarr[] = "<td style='background:white;border-radius:5px;border:none;color:red;width:20px;height:20px;text-align:center;'><b>$text</b></td><td class='pager' style='background:none;border:none;'>&nbsp;</td>";}
$pagerstr = join("", $pagerarr);if($i > 1){
$pagertop = "<table style='background:none;cellspacing:0;cellpadding:0;width:550px;float:center;border:none;'><tr><td style='border-radius:15px;border:none;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td class='zaliwka' style='color:#FFFFFF;colspan:16;font-size:18px;text-align:center;border:0;border-radius:5px;'>
<table style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'>$pager $pagerstr $pager2<script>
function to_page_click(){var to_page_num = document.to_page.to_page_num.value;to_page_num = parseInt(to_page_num) + 0;var url = '/".$href."page=';url= url.replace(/\&amp;/g,'&');
if(to_page_num >= 1 ){to_page_num = to_page_num - 1;window.location = url + to_page_num;}else alert('Вы должны ввести номер страницы');}</script>
<td class='pager' style='background:none;'><form name='to_page'><input name='to_page_num' value='' size='4'/>
<input type='button' name='to_page_btn' value='Перейти' onclick='to_page_click();'/></form></td></table></td>
</tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table>";
$pagerbottom .= "<table style='background:none;cellspacing:0;cellpadding:0;width:550px;float:center;border:none;'><center>
<tr><td align='center' style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'>
<span class='badges-extras texts-bolds' style='font-weight:normal;color:#696969;'>Найдено всего: <b style='color:#800000;'>$count</b> на <b style='color:#4169E1;'>$i</b> страницах по <b style='color:#4169E1;'>$rpp</b> на каждой странице</span></td></tr>
<tr><td style='border-radius:15px;border:none;' class='a'><table style='background:none;width:100%;float:center;border:0;'><tr><td class='zaliwka' style='color:#FFFFFF;colspan:16;font-size:18px;text-align:center;border:0;border-radius:5px;'>
<table style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'>$pager $pagerstr $pager2<script>
function to_page_clicks(){var to_page_nums = document.to_pages.to_page_nums.value;to_page_nums = parseInt(to_page_nums) + 0;var url = '/".$href."page=';url= url.replace(/\&amp;/g,'&');
if(to_page_nums >= 1 ){to_page_nums = to_page_nums - 1;window.location = url + to_page_nums;}else alert('Вы должны ввести номер страницы');}</script>
<td class='pager' style='background:none;'><form name='to_pages'><input name='to_page_nums' value='' size='4'/>
<input type='button' name='to_page_btn' value='Перейти' onclick='to_page_clicks();'/></form></td></table></td>
</tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></center></table>";}else{
$pagerbottom .= "<center><span class='badges-extras texts-bolds' style='font-weight:normal;color:#696969;'>Найдено всего: <b style='color:#800000;'>$count</b></span></center>";}}
else{$pagertop = $pager;$pagerbottom = $pagertop;}$start = $page * $rpp;return array($pagertop, $pagerbottom, "LIMIT $start,$rpp");}
////////////////////////////////
function pager3($rpp, $count, $href, $opts = array()){$pages = ceil($count / $rpp);
if(!isset($opts['lastpagedefault']))$pagedefault = 0;else{$pagedefault = floor(($count - 1) / $rpp);if($pagedefault < 0)$pagedefault = 0;}
if(isset($_GET['page'])){$page = 0 + (int) $_GET['page'];if ($page < 0)$page = $pagedefault;}else $page = $pagedefault;
$pager = "<td class='pager' style='background:none;'>Страницы:</td><td class='pagebr' style='background:none;'>&nbsp;</td>";$pager2 = "";$bregs = "";$mp = $pages - 1;$as = "<b>«</b>";
if($page >= 1){$pager .= "<td class='pager' style='background:none;'><a href='".$href."page=".($page - 1)."' style='text-decoration:none;'>$as</a></td><td class='pagebr'>&nbsp;</td>";}
$as = "<b>»</b>";if($page < $mp && $mp >= 0){$pager2 .= "<td class='pager'><a href='".$href."page=".($page + 1)."' style='text-decoration:none;'>$as</a></td>$bregs";
}else $pager2 .= $bregs;if($count){$pagerarr = array();$dotted = 0;$dotspace = 3;$dotend = $pages - $dotspace;$curdotend = $page - $dotspace;
$curdotstart = $page + $dotspace;for($i = 0; $i < $pages; $i++){if(($i >= $dotspace && $i <= $curdotend) || ($i >= $curdotstart && $i < $dotend)){
if(!$dotted)$pagerarr[] = "<td class='pager'>...</td><td class='pagebr'>&nbsp;</td>";$dotted = 1;continue;}$dotted = 0;
$start = $i * $rpp + 1;$end = $start + $rpp - 1;if($end > $count)$end = $count;$text = $i+1;
if($i != $page)$pagerarr[] = "<td class='pager'><a title='$start&nbsp;-&nbsp;$end' href='".$href."page=$i' style='text-decoration:none;'><b>$text</b></a></td><td class='pagebr'>&nbsp;</td>";
else $pagerarr[] = "<td class='highlight'><b>$text</b></td><td class='pagebr'>&nbsp;</td>";}$pagerstr = join("", $pagerarr);if($i > 1){
$pagerbottom .= "<table class='main' style='background:none;'><center>$pager $pagerstr $pager2<script>
function to_page_clicks(){var to_page_nums = document.to_pages.to_page_nums.value;to_page_nums = parseInt(to_page_nums) + 0;var url = '/".$href."page=';url= url.replace(/\&amp;/g,'&');
if(to_page_nums >= 1 ){to_page_nums = to_page_nums - 1;window.location = url + to_page_nums;}else alert('Вы должны ввести номер страницы');}</script>
<td class='pager' style='background:none;'><form name='to_pages'><input name='to_page_nums' value='' size='4'/>
<input type='button' name='to_page_btn' value='Перейти' onclick='to_page_clicks();'/></form></td></center></table>";}else{
$pagerbottom .= "<center><span class='badges-extras texts-bolds' style='font-weight:normal;color:#696969;'>Найдено всего: <b style='color:#800000;'>$count</b></span></center>";}}
else{$pagerbottom = $pager;}$start = $page * $rpp;return array($pagerbottom, "LIMIT $start,$rpp");}
////////////////memcashed nachalo Category///////////////////////////////////////
$table = array('categories', 'incategories');
function get_list($table){$ret = array();$Cacher = Cache::getInstance();
if(!($res = $Cacher->get($table))){$ret = sql_query("SELECT id, name FROM $table ORDER BY sort ASC"); 
while($row = mysql_fetch_array($ret)){$res[] = $row;}$Cacher->set($table, $res);}return $res;} 
//////////////////////memcashed conec//////////////////////////////////////
////////////////memcashed nachalo relizi_block///////////////////////////////////////
function relizi_block($limit){$ret = array();$Cacher = Cache::getInstance();if(!($res = $Cacher->get("relizi_block".$limit))){  
$ret = sql_query("SELECT textt FROM relizi_block ORDER BY time DESC $limit") or sqlerr(__FILE__, __LINE__); 
while($row = mysql_fetch_array($ret)){$res[] = $row;}$Cacher->set("relizi_block".$limit, $res, 864000);}return $res;}  
//////////////////////memcashed conec relizi_block//////////////////////////////////////
function linkcolor($num){if (!$num)return 'red';return 'green';}
/////////////////////////
function hash_pad($hash){return str_pad($hash, 20);}
//////////////////
function get_user_icons($arr, $big = false){
if($big){$donorpic = "star.gif";$warnedpic = "warnedbig.gif";$disabledpic = "disabledbig.gif";$style = "style='margin-left:4pt'";}else{
$donorpic = "star.gif";$warnedpic = "warned.gif";$disabledpic = "disabled.gif";$parkedpic = "parked.gif";$style = "style='margin-left:2pt'";}
$pics = $arr["donor"] == "yes" ? "<img src='pic/$donorpic' alt='Donor' border='0' $style/>" : "";
if ($arr["enabled"] == "yes")$pics .= $arr["warned"] == "yes" ? "<img src=pic/$warnedpic alt='Warned' border='0' $style/>" : "";
else $pics .= "<img src='pic/$disabledpic' alt='Disabled' border='0' $style/>";
$pics .= $arr["parked"] == "yes" ? "<img src=pic/$parkedpic alt='Parked' border='0' $style>" : "";return $pics;}
//////////////////////////
function parked(){global $CURUSER;if($CURUSER['parked'] == 'yes')
stderr2($tracker_lang['error'], "<center>Ваш аккаунт припаркован.</center><html><head><meta http-equiv=refresh content='3;url=/'></head></html>");}
///////////////////////////////
function viped(){global $CURUSER;$id = (isset($_GET["id"]) ? intval($_GET["id"]):0);
$res = sql_query("SELECT dostup, owner FROM torrents WHERE id = $id") or sqlerr(__FILE__, __LINE__);$row = mysql_fetch_array($res);	   
if($row['dostup'] == 'adm' && get_user_class() < UC_ADMINISTRATOR){
stderr2($tracker_lang['error'], '<center>Релиз <b style="color:#9C2FE0">ЗАКРЫТ</b></center><html><head><meta http-equiv=refresh content="3;url=details_'.$id.'"></head></html>');
}elseif($row['dostup'] == 'mod' && $row['owner'] != $CURUSER['id'] && get_user_class() < UC_MODERATOR){
stderr2($tracker_lang['error'], '<center>Релиз <b style="color:#9C2FE0">На проверке</b>.</center><html><head><meta http-equiv=refresh content="3;url=details_'.$id.'"></head></html>');
}elseif($row['dostup'] == 'upl' && $row['owner'] != $CURUSER['id'] && get_user_class() < UC_UPLOADER){
stderr2($tracker_lang['error'], '<center>Релиз только для <b style="color:#9C2FE0">UPLOADER</b>-класса.</center><html><head><meta http-equiv=refresh content="3;url=details_'.$id.'"></head></html>');
}elseif($row['dostup'] == 'vip' && $row['owner'] != $CURUSER['id'] && get_user_class() < UC_VIP){
stderr2($tracker_lang['error'], '<center>Релиз только для <b style="color:9C2FE0">VIP</b>-класса.</center><html><head><meta http-equiv=refresh content="3;url=details_'.$id.'"></head></html>');
}elseif($row['dostup'] == 'uhd' && $row['owner'] != $CURUSER['id'] && get_user_class() < UC_UHD){
stderr2($tracker_lang['error'], '<center>Релиз только для <b style="color:#6A5ACD">UHD</b>-класса.</center><html><head><meta http-equiv=refresh content="3;url=details_'.$id.'"></head></html>');
}elseif($row['dostup'] == '1080p' && $row['owner'] != $CURUSER['id'] && get_user_class() < UC_1080p){
stderr2($tracker_lang['error'], '<center>Релиз только для <b style="color:#6A5ACD">1080p</b>-класса.</center><html><head><meta http-equiv=refresh content="3;url=details_'.$id.'"></head></html>');}}
///////////////////
function magnet($html = true, $info_hash, $name, $size, $announces = array()){$ampersand = $html ? '&amp;' : '&';
return sprintf('magnet:?xt=urn:btih:%2$s%1$sdn=%3$s%1$sxl=%4$d%1$str=%5$s', $ampersand, $info_hash, urlencode($name), $size, implode($ampersand.'tr=', $announces));}
/////////////////////////////
define('LoLi', 'Powered by LoLi v3.6 Copyright &copy; 2017-'.date('Y'));
//////////////////////////////
function mysql_modified_rows(){$info_str = mysql_info();$a_rows = mysql_affected_rows();
preg_match("/Rows matched: ([0-9]*)/", $info_str, $r_matched);return ($a_rows < 1)?($r_matched[1]?$r_matched[1]:0):$a_rows;}
//////////////////////////
function str($input){$input = ereg_replace("'","",htmlspecialchars(trim($input)));return $input;}
////////////////////
function num($input){$input = (int) 0 + $input;return $input;}
/////////////////////////////
function decode_unicode_url($str){$res = '';$i = 0;$max = strlen($str) - 6; 
while($i <= $max){$character = $str[$i];if($character == '%' && $str[$i + 1] == 'u'){$value = hexdec(substr($str, $i + 2, 4));$i += 6; 
if($value < 0x0080) $character = chr($value);elseif($value < 0x0800) $character = chr((($value & 0x07c0) >> 6) | 0xc0). chr(($value & 0x3f) | 0x80); // 2 bytes: 110xxxxx 10xxxxxx
else // 3 bytes: 1110xxxx 10xxxxxx 10xxxxxx 
$character = chr((($value & 0xf000) >> 12) | 0xe0). chr((($value & 0x0fc0) >> 6) | 0x80). chr(($value & 0x3f) | 0x80);}else $i++;$res .= $character;}return $res. substr($str, $i);} 
/////////////////////////////
function convert_text($s){$out = ""; 
for ($i=0; $i<strlen($s); $i++){ 
$c1 = substr ($s, $i, 1); 
$byte1 = ord ($c1); 
if ($byte1>>5 == 6){ // 110x xxxx, 110 prefix for 2 bytes unicode
$i++; 
$c2 = substr ($s, $i, 1); 
$byte2 = ord ($c2); 
  $byte1 &= 31; // remove the 3 bit two bytes prefix 
  $byte2 &= 63; // remove the 2 bit trailing byte prefix 
  $byte2 |= (($byte1 & 3) << 6); // last 2 bits of c1 become first 2 of c2 
  $byte1 >>= 2; // c1 shifts 2 to the right 
  $word = ($byte1<<8) + $byte2; 
  if ($word==1025) $out .= chr(168);                    // ? 
  elseif ($word==1105) $out .= chr(184);                // ? 
  elseif ($word>=0x0410 && $word<=0x044F) $out .= chr($word-848); // ?-? ?-? 
elseif ($word==0x0456) $out .= chr(179); //і-179  
  elseif ($word==0x0406) $out .= chr(178); //І-178  
  elseif ($word==0x0404) $out .= chr(170);//170-Є 
  elseif ($word==0x0407) $out .= chr(175);//Ї - 175  
  elseif ($word==0x0457) $out .= chr(191); //  191-ї 
  elseif ($word==0x0454) $out .= chr(186); //є-186 
  else { 
    $a = dechex($byte1); 
    $a = str_pad($a, 2, "0", STR_PAD_LEFT); 
    $b = dechex($byte2); 
    $b = str_pad($b, 2, "0", STR_PAD_LEFT); 
    $out .= "&#x".$a.$b.";"; 
}}else{$out .= $c1;}}return $out;}
///////// БОТ В ЧАТЕ ///////////////
function bot_msg($text){$botid = 2;$botclass = 6;$botname = "LoLi";$datee = get_date_time(); //прописать ваши данные бота!//
sql_query("INSERT INTO shoutbox (text, date, userid, class, username, warned) VALUES (".implode(", ", array_map("sqlesc", array($text, $datee, $botid, $botclass, 
$botname, 'no'))).")") or sqlerr(__FILE__, __LINE__);}
////////////////////////////////////////////////////////////////////////////////
function write_bonuslog($text){$text = sqlesc($text);$added = sqlesc(get_date_time()); 
sql_query("INSERT INTO bonuslog (added, txt) VALUES($added, $text)") or sqlerr(__FILE__, __LINE__);}  
/////// Конфигурационные заголовки  Зачем прописывать заголовки каждый раз заново? Функция get_headers() облегчит вам жизнь ///////////////
function get_head(){global $head;foreach($head AS $header){$head_array[] = $header;}return implode("\n" , $head_array);} 
///////////////////////////////////////
function ajax_text_convert($s){return iconv('UTF-8', 'UTF-8', $s);}
////////////////////////
function strip_quotes($text){$lowertext = strtolower($text);$start_pos = array();$curpos = 0;do{$pos = strpos($lowertext, '[quote', $curpos); 
if($pos !== false){$start_pos["$pos"] = 'start';$curpos = $pos + 6;}}while ($pos !== false);
if(sizeof($start_pos) == 0){return $text;}$end_pos = array();$curpos = 0;do{$pos = strpos($lowertext, '[/quote]', $curpos); 
if($pos !== false){$end_pos["$pos"] = 'end';$curpos = $pos + 8;}}while ($pos !== false);if(sizeof($end_pos) == 0){return $text;}
$pos_list = $start_pos + $end_pos;ksort($pos_list);do{$stack = array();$newtext = '';$substr_pos = 0;
foreach ($pos_list AS $pos => $type){$stacksize = sizeof($stack); 
if($type == 'start'){if($stacksize == 0){$newtext .= substr($text, $substr_pos, $pos - $substr_pos);}
array_push($stack, $pos);}else{if($stacksize){array_pop($stack);$substr_pos = $pos + 8;}}}$newtext .= substr($text, $substr_pos);
if($stack){foreach ($stack AS $pos){unset($pos_list["$pos"]);}}}while ($stack);return $newtext;} 
///////////////////////////
function strip_bbcode($message, $stripquotes = false, $fast_and_dirty = false, $showlinks = true){$find = array();$replace = array(); 
if($stripquotes){$message = strip_quotes($message);} 
if($fast_and_dirty){$find[] = '#\[.*/?\]#siU';$replace[] = '';$message = preg_replace($find, $replace, $message);}else{  
$find[] = '#\[(email|url)=("??)(.+)\\2\]\\3\[/\\1\]#siU';$replace[] = '\3';$find[] = '#\[(email|url)=("??)(.+)\\2\](.+)\[/\\1\]#siU';$replace[] = ($showlinks ? '\4 (\3)' : '\4');
$message = preg_replace($find, $replace, $message);while(preg_match_all('#\[(\w+?)(?>[^\]]*?)\](.*)(\[/\1\])#siU', $message, $regs)){ 
foreach($regs[0] AS $key => $val){$message  = str_replace($val, $regs[2]["$key"], $message);}}$message = str_replace('[*]', ' ', $message);}return trim($message);}
//////////////////////////////////////
function failedloginscheck(){global $maxloginattempts;$total = 1;$ip = sqlesc(getip());$first = ip2long(getip());$username = htmlspecialchars_uni($_POST["username"]);
$comment = sqlesc("Юзер $username исчерпал свои попытки входа.");
$added = sqlesc(get_date_time());$Query = sql_query("SELECT SUM(attempts) FROM loginattempts WHERE ip=$ip") or sqlerr(__FILE__, __LINE__); 
list($total) = mysql_fetch_array($Query);if($total == $maxloginattempts){        
sql_query("INSERT INTO bans (added, addedby, comment, first) VALUES($added, '2', $comment, $first)") or sqlerr(__FILE__, __LINE__);	
sql_query("UPDATE loginattempts SET banned = 'yes' WHERE ip=$ip") or sqlerr(__FILE__, __LINE__);
sql_query("UPDATE users SET enabled = 'no' WHERE username=".sqlesc($username)) or sqlerr(__FILE__, __LINE__);
write_log("Аккаунт юзера: <b style='color:red'>".$username."</b> отключен, так как исчерпаны попытки входа. Попытка взломать аккаунт?", "5DDB6E", "login");
stderr("You can not enter!", "<center>You have exhausted your entry attempts! Your IP-address <b>(".htmlspecialchars($ip).")</b> was banned.</center><html><head><meta http-equiv='refresh' content='4;url=/'></head><body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");}} 
/////////////////////
function failedlogins(){$ip = sqlesc(getip());$added = sqlesc(get_date_time()); 
$a = (@mysql_fetch_row(@sql_query("select count(*) from loginattempts WHERE ip=$ip"))) or sqlerr(__FILE__, __LINE__); 
if($a[0] == 0) sql_query("INSERT INTO loginattempts (ip, added, attempts) VALUES ($ip, $added, 1)") or sqlerr(__FILE__, __LINE__); 
else sql_query("UPDATE loginattempts SET attempts = attempts + 1 WHERE ip=$ip") or sqlerr(__FILE__, __LINE__);      
stderr("Login failed!","<center><b>Error</b>: The username or password is not correct!<br>Forgot your password? <b><a href='/'>Restore</a></b> it!</center><html><head><meta http-equiv='refresh' content='4;url=/'></head><body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");} 
/////////////////////////////
function remaining(){global $maxloginattempts;$total = 1;$ip = sqlesc(getip()); 
$Query = sql_query("SELECT SUM(attempts) FROM loginattempts WHERE ip=$ip") or sqlerr(__FILE__, __LINE__); 
list($total) = mysql_fetch_array($Query);$remaining = $maxloginattempts - $total; 
if($remaining <= 2 ) $remaining = "<b style='color:red;font-size:14px;'>".$remaining."</b>";
else $remaining = "<b style='color:green;font-size:14px;'>".$remaining."</b>";return $remaining;}
//////////////////////////////////////
function failedloginschecks(){global $maxloginattemptss;$total = 0;$ip = sqlesc(getip());$first = ip2long(getip());$username = htmlspecialchars_uni($_POST["username"]);
$comment = sqlesc("Юзер $username исчерпал свои попытки вспомнить ответ на секретный вопрос.");
$added = sqlesc(get_date_time());$Query = sql_query("SELECT SUM(attemptss) FROM loginattempts WHERE ip=$ip") or sqlerr(__FILE__, __LINE__); 
list($total) = mysql_fetch_array($Query);if($total == $maxloginattemptss){         
sql_query("INSERT INTO bans (added, addedby, comment, first) VALUES($added, '2', $comment, $first)") or sqlerr(__FILE__, __LINE__);	
sql_query("UPDATE loginattempts SET banned = 'yes' WHERE ip=$ip") or sqlerr(__FILE__, __LINE__);
sql_query("UPDATE users SET enabled = 'no' WHERE username=".sqlesc($username)) or sqlerr(__FILE__, __LINE__);
write_log("Аккаунт юзера: <b style='color:red'>".$username."</b> отключен, так как исчерпаны попытки вспомнить ответ на секретный пароль. Попытка взломать аккаунт?", "5DDB6E", "login");		
stderr("You can not enter!", "<center>You have exhausted your entry attempts! Your IP-address <b>(".htmlspecialchars($ip).")</b> was banned.</center><html><head><meta http-equiv='refresh' content='4;url=/'></head><body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");}} 
/////////////////////
function failedloginss(){$ip = sqlesc(getip());$added = sqlesc(get_date_time()); 
$a = (@mysql_fetch_row(@sql_query("select count(*) from loginattempts where ip=$ip"))) or sqlerr(__FILE__, __LINE__); 
if($a[0] == 0) sql_query("INSERT INTO loginattempts (ip, added, attemptss) VALUES ($ip, $added, 1)") or sqlerr(__FILE__, __LINE__); 
else sql_query("UPDATE loginattempts SET attemptss = attemptss + 1 where ip=$ip") or sqlerr(__FILE__, __LINE__);      
stderr("Restore failed!","<center><b>Error</b>: Sorry your answer is incorrect!<br>Forgot your password? <b><a href='/'>Restore</a></b> it!</center><html><head><meta http-equiv='refresh' content='4;url=/'></head><body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");} 
/////////////////////////////
function remainings(){global $maxloginattemptss;$total = 0;$ip = sqlesc(getip()); 
$Query = sql_query("SELECT SUM(attemptss) FROM loginattempts WHERE ip=$ip") or sqlerr(__FILE__, __LINE__); 
list($total) = mysql_fetch_array($Query);$remainings = $maxloginattemptss - $total; 
if ($remainings <= 2 ) $remainings = "<b style='color:red;font-size:14px;'>".$remainings."</b>"; 
else $remainings = "<b style='color:green;font-size:14px;'>".$remainings."</b>";return $remainings;}
//////////////////////////
function get_online_users(){$rey = array();$Cachery = Cache::getInstance();if(!($resy = $Cachery->get("users"))){  
$rey = sql_query("SELECT * FROM users WHERE last_access > UNIX_TIMESTAMP() - 60*10") or sqlerr(__FILE__, __LINE__); 
while ($rowy = mysql_fetch_array($rey)){$resy[] = $rowy;}$Cachery->set("users", $resy, 1800);}return $resy;}
////////////////////////////
function ipinnet($ip, $net, $mask){$ip_ = ip2long($ip);$net_ = ip2long($net);$mask_ = long2ip($net_) == $mask ? $net_ : 0xffffffff << (32 - $mask);  
$res = $ip_ & $mask_;return ($res == $net_);}
//////////////////
function nicetime($input, $time = false){ 
$search = array('January','February','March','April','May','June','July','August','September','October','November','December'); 
$replace = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'); 
$seconds = strtotime($input);if ($time == true) $data = date("j F Y в H:i:s", $seconds);else $data = date("j F Y", $seconds);
$data = str_replace($search, $replace, $data);return $data;}
//////////////////////
function ipv6_numeric($ip){$binNum = '';foreach (unpack('C*', inet_pton($ip)) as $byte){$binNum .= str_pad(decbin($byte), 8, "0", STR_PAD_LEFT);}
return base_convert(ltrim($binNum, '0'), 2, 10);}
/////////////////////
function random_str_c($length="8"){
$set = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U","v","V","w","W","x","X","y","Y","z","Z","а","А","б","Б","в","В","г","Г","д","Д","е","Е","ё","Ё","ж","Ж","з","З","и","И","й","Й","к","К","л","Л","м","М","н","Н","о","О","п","П","р","Р","с","С","т","Т","у","У","ф","Ф","х","Х","ш","Ш","щ","Щ","ц","Ц","ч","Ч","ы","Ы","э","Э","ю","Ю","я","Я","1","2","3","4","5","6","7","8","9");
$str;for($i = 1; $i <= $length; $i++){$ch = rand(0, count($set)-1);$str .= $set[$ch];}return $str;}
/////////////////////
function salt_password($password, $salt){return md5(md5($salt).$password);}
//////////////////////
function httpauth(){global $CURUSER, $tracker_lang;if(isset($_SERVER['HTTP_AUTHORIZATION'])){
$auth_params = explode(":" , base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
$_SERVER['PHP_AUTH_USER'] = $auth_params[0];unset($auth_params[0]);$_SERVER['PHP_AUTH_PW'] = implode('',$auth_params);}
if($CURUSER['passhash'] != md5($CURUSER['secret'].$_SERVER["PHP_AUTH_PW"].$CURUSER['secret'])){
header("WWW-Authenticate: Basic realm='Логин и Пароль'");
header("HTTP/1.0 401 Unauthorized");stderr2($tracker_lang['error'],$tracker_lang['access_denied']);}}
////////////////
function GetMAC(){ob_start();system('getmac');$Content = ob_get_contents();ob_clean();return substr($Content, strpos($Content,'\\')-20, 17);}
///////////////////////
function render_blocks($side, $blockfile, $blocktitle, $content, $bid, $bposition){global $showbanners, $foot, $blockid; 
if(empty ($blockid)){$blockid = explode (".", $_COOKIE ["hidebid"]);$GLOBALS ["blockid"] = $blockid;} 
$bidpos = in_array ("b".$bid, $blockid);if($bidpos){$contenta = "<div id='bb".$bid."' style='display:none;'>";}else{ 
$contenta = "<div id='bb".$bid."' style='display: block;'>";} 
if($blockfile != ""){if(file_exists("include/blocks/".$blockfile."")){ 
define('BLOCK_FILE', 1);require("include/blocks/".$blockfile."");$blocktitlea .= $blocktitle;$contenta .= $content; 
}else{$contenta = "<center>Существует проблема с этим блоком!</center>";}}if($bidpos){ 
$blocktitlea .= "&nbsp;&nbsp;<span style='cursor:pointer;' onclick=\"javascript: showshides('b".$bid."');\"><img border='0' src='pic/minus.png' id='picb".$bid."' title='Показать'/></span>"; 
}else{$blocktitlea .= "&nbsp;&nbsp;<span style='cursor:pointer;' onclick=\"javascript: showshides('b".$bid."');\"><img border='0' src='pic/minus.png' id='picb".$bid."' title='Скрыть'/></span>";} 
$contenta .= "<span style='cursor: pointer;' onclick=\"javascript: showshides('b".$bid."');\">"; 
if(!((isset ($content) AND !empty ($content)))){$contenta = "<center>Существует проблема с этим блоком!</center>";}  
preg_match('#<!-- {(.*?)} -->#si', $content, $matches);$time = intval($matches [1]); 
if(isset($content) and ! empty ($content) and $content != '<!-- {'.$time.'} -->'){ 
switch($side){case 'b': $showbanners = $content;return null;case 'f': $foot = $content;return null;case 'n': echo $content;return null;
case 'p': return $content;case 'o': return "$blocktitle - $content";}
$contenta .= "</div>";themesidebox($blocktitlea, $contenta, $bposition);return null;}}
function themesidebox($title, $content, $position){static $bl_mass;switch($position){case 'l': $bl_name = 'block-left';break;case 'r': $bl_name = 'block-right';break; 
case 'c': $bl_name = 'block-center';break;case 'd': $bl_name = 'block-down';break;default: $bl_name = 'block-all';break;}
if(file_exists($bl_name.'.php')){$f_str = file_get_contents($bl_name.'.php'); 
$f_str = ' echo "'.addslashes($f_str).'";';$bl_mass[$bl_name]['f'] = create_function('$title, $content', $f_str); 
$bl_mass[$bl_name]['f']($title, $content);}else{echo '<fieldset><legend>'.$title.'</legend>'.$content.'</fieldset>';}}
$orbital_blocks = array();function show_blocks($position){global $CURUSER, $orbital_blocks, $cache_control, $memcache; 
static $showed_show_hide;if(!$showed_ajax && !$noblocks){?><?php $GLOBALS ['showed_ajax'] = true;}$orbital_cache = array(); 
if($cache_control == false){if(cache_check("orbital_blocks", 86400)) $orbital_cache = cache_read("orbital_blocks");else{     
$blocks_res = sql_query("SELECT * FROM orbital_blocks WHERE active = 1 ORDER BY weight ASC") or sqlerr(__FILE__,__LINE__); 
while($blocks_row = mysql_fetch_array($blocks_res)) $orbital_cache[] = $blocks_row;cache_write("orbital_blocks", $orbital_cache);     
}}else{if(false === ($orbital_cache = $memcache->get('orbital_blocks'))){ 
$blocks_res = sql_query("SELECT * FROM orbital_blocks WHERE active = 1 ORDER BY weight DESC") or sqlerr(__FILE__,__LINE__); 
while ($blocks_row = mysql_fetch_array($blocks_res)) $orbital_cache[] = $blocks_row;     
$memcache->set('orbital_blocks', $orbital_cache, 0, 86400);}}$orbital_blocks = $orbital_cache;if(!$orbital_blocks) $orbital_blocks = array();
foreach($orbital_blocks as $block){$bid = $block["bid"];$content = $block["content"];$title = $block["title"];  
$blockfile = $block["blockfile"];$bposition = $block["bposition"];  
if($position != $bposition) continue;$view = $block["view"];$which = explode(",", $block["which"]);  
$module_name = str_replace(".php", "", basename($_SERVER["PHP_SELF"]));  
if(!(in_array($module_name, $which) || in_array("all", $which) || (in_array("ihome", $which) && $module_name == "index"))){continue;} 
if($view == 0){render_blocks($side, $blockfile, $title, $content, $bid, $bposition); 
}elseif($view == 1 && (get_user_class() >= UC_USER)){render_blocks($side, $blockfile, $title, $content, $bid, $bposition); 
}elseif($view == 2 && (get_user_class() >= UC_720p)){render_blocks($side, $blockfile, $title, $content, $bid, $bposition);              
}elseif($view == 3 && (get_user_class() >= UC_1080i)){render_blocks($side, $blockfile, $title, $content, $bid, $bposition); 
}elseif($view == 4 && (get_user_class() >= UC_1080p)){render_blocks($side, $blockfile, $title, $content, $bid, $bposition);
}elseif($view == 5 && (get_user_class() >= UC_UHD)){render_blocks($side, $blockfile, $title, $content, $bid, $bposition); 
}elseif($view == 6 && (get_user_class() >= UC_VIPS)){render_blocks($side, $blockfile, $title, $content, $bid, $bposition); 
}elseif($view == 7 && (get_user_class() >= UC_UPLOADER)){render_blocks($side, $blockfile, $title, $content, $bid, $bposition); 
}elseif($view == 8 && (get_user_class() >= UC_VIP)){render_blocks($side, $blockfile, $title, $content, $bid, $bposition);
}elseif($view == 9 && (get_user_class() >= UC_MODERATOR)){render_blocks($side, $blockfile, $title, $content, $bid, $bposition); 
}elseif($view == 10 && (get_user_class() >= UC_ADMINISTRATOR)){render_blocks($side, $blockfile, $title, $content, $bid, $bposition);             
}elseif($view == 11 && (!$CURUSER || get_user_class() >= UC_MODERATOR)){render_blocks($side, $blockfile, $title, $content, $bid, $bposition);}}}
//////////////////////////////
function cache_check($file, $time){global $rootpath;
return file_exists("include/cache/$file.cache") && is_readable("include/cache/$file.cache") && (gmtime() - $time < filemtime("include/cache/$file.cache")) && filesize("include/cache/$file.cache") > 0 && $_GET["no_cache"] != 1;}
function cache_read($file){global $rootpath;return unserialize(@file_get_contents("include/cache/$file.cache"));}
function cache_write($file, $data){global $rootpath;
if(file_exists("include/cache/$file.cache")){if(is_writable("include/cache/$file.cache")) @file_put_contents("include/cache/$file.cache", serialize($data));}else{
$fh = fopen("include/cache/$file.cache",'w+');fwrite($fh,serialize($data));fclose($fh);}}
function cache_left($file, $time){global $rootpath;return $time - (gmtime() - filemtime($rootpath."include/cache/$file.cache"));}
///////////////////////////
function cache_checks($file){global $rootpath;
return file_exists("include/cache/$file.cache") && is_readable("include/cache/$file.cache") && filesize("include/cache/$file.cache") > 0 && $_GET["no_cache"] != 1;}
function cache_reads($file){global $rootpath;return unserialize(@file_get_contents("include/cache/$file.cache"));}
function cache_writes($file, $data){global $rootpath;
if(file_exists("include/cache/$file.cache")){if(is_writable("include/cache/$file.cache")) @file_put_contents("include/cache/$file.cache", serialize($data));}else{
$fh = fopen("include/cache/$file.cache",'w+');fwrite($fh,serialize($data));fclose($fh);}}
function cache_lefts($file){global $rootpath;return;}
/////////////////////////////////
interface ICache{public function Check($Filename, $Time);public function Read($Filename);public function Write($Filename, $Data);}
class CacheBlock //implements ICache // уберите комментарии, если у вас PHP 5.2+
{private $_rootpath;function __construct($rootpath){$this->_rootpath = $rootpath;}protected function GetCachePath(){return $this->_rootpath;}
public function Check($file, $lifetime_in_sec = 120){return 
file_exists($this->_rootpath . $file) && is_readable($this->_rootpath . $file) && (time() - filemtime($this->_rootpath . $file) < $lifetime_in_sec) && filesize($this->_rootpath . $file) > 0;}
public function Read($file){return unserialize(file_get_contents($this->_rootpath . $file));}
public function Write($file, $data){file_put_contents($this->_rootpath . $file, serialize($data));}}
class CacheOutputBrowser extends CacheBlock //implements ICache  // уберите комментарии, если у вас PHP 5.2+
{private function Callback_Flush($buffer, $flags){return $buffer;}
public function Init($Options=''){return ob_start("self::Callback_Flush");}
public function Write($file, $data){file_put_contents(parent::GetCachePath() . $file, serialize(ob_get_flush()));}}
$CacheBlock = new CacheBlock($rootpath . 'include/cache/'); // здесь будет кэш
///////////////////
$zodiac[] = array("Козерог", "capricorn.png", "22-12");
$zodiac[] = array("Стрелец", "sagittarius.png", "23-11");
$zodiac[] = array("Скорпион", "scorpio.png", "24-10");
$zodiac[] = array("Весы", "libra.png", "24-09");
$zodiac[] = array("Дева", "virgo.png", "24-08");
$zodiac[] = array("Лев", "leo.png", "23-07");
$zodiac[] = array("Рак", "cancer.png", "22-06");
$zodiac[] = array("Близнецы", "gemini.png", "22-05");
$zodiac[] = array("Телец", "taurus.png", "21-04");
$zodiac[] = array("Овен", "aries.png", "22-03");
$zodiac[] = array("Рыбы", "pisces.png", "21-02");
$zodiac[] = array("Водолей", "aquarius.png", "21-01");
///////////////////////
$smilies2 = array(
":nonono:" => "nonono.gif", 
":kawaii:" => "kawaii.gif",
":huh2:" => "huh.gif",  
":hm:" => "hmm.gif",  
":hehe:" => "hehe.gif", 
":happy:" => "happy.gif",  
":haha:" => "haha.gif",  
":good:" => "good.gif",  
":cry:" => "cry1.gif",  
":cool2:" => "cool.gif",  
":bah:" => "bah.gif",  
":ah:" => "ah.gif",  
":sad:" => "sad.gif",  
":cry2:" => "cry2.gif", 
":cry3:" => "cry3.gif", 
":dunno:" => "dunno.gif",  
":pleased:" => "pleased.gif",  
":advise:" => "advise.gif",  
":agr:" => "agr.gif",  
":angry:" => "angry1.gif",  
":angry2:" => "angry2.gif",  
":bath:" => "bath.gif",  
":bye:" => "bye.gif",  
":cry3:" => "cry3.gif",  
":depressed:" => "depressed.gif",  
":frozen:" => "frozen.gif",  
":greedy:" => "greedy.gif",  
":hi2:" => "hi.gif",  
":hopeless:" => "hopeless.gif",  
":hotness:" => "hotness.gif",  
":idontcare:" => "idontcare.gif",  
":dead:" => "imdead.gif",  
":khekhe:" => "khekhe.gif",  
":knife:" => "knife.gif",  
":lol:" => "lol.gif",  
":love:" => "love1.gif",  
":love2:" => "love2.gif",  
":omg:" => "omg.gif",  
":penalty:" => "penalty.gif",  
":roar:" => "roar.gif", 
":shy:" => "shy.gif",  
":slap:" => "slap.gif",  
":sleep:" => "sleep.gif",  
":smoke:" => "smoke.gif",  
":stfu:" => "stfu.gif",  
":tired:" => "tired1.gif",  
":tired2:" => "tired2.gif",  
":tuktuk:" => "tuktuk.gif",  
":uhuh:" => "uhuh.gif",   
":wall:" => "wall.gif",  
":wat:" => "wat1.gif",  
":wat2:" => "wat2.gif",  
":wind:" => "wind.gif",  
":yawn1:" => "yawn1.gif",  
":yawn2:" => "yawn2.gif",); 
///////////////////
$smilies = array(
  ":-)" => "smile1.gif",
  ":smile:" => "smile2.gif",
  ":-D" => "grin.gif",
  ":lol:" => "laugh.gif",
  ":w00t:" => "w00t.gif",
  ":-P" => "tongue.gif",
  ";-)" => "wink.gif",
  ":-|" => "noexpression.gif",
  ":-/" => "confused.gif",
  ":-(" => "sad.gif",
  ":'-(" => "cry.gif",
  ":weep:" => "weep.gif",
  ":-O" => "ohmy.gif",
  ":o)" => "clown.gif",
  "8-)" => "cool1.gif",
  "|-)" => "sleeping.gif",
  ":innocent:" => "innocent.gif",
  ":whistle:" => "whistle.gif",
  ":unsure:" => "unsure.gif",
  ":closedeyes:" => "closedeyes.gif",
  ":cool:" => "cool2.gif",
  ":fun:" => "fun.gif",
  ":thumbsup:" => "thumbsup.gif",
  ":thumbsdown:" => "thumbsdown.gif",
  ":blush:" => "blush.gif",
  ":unsure:" => "unsure.gif",
  ":yes:" => "yes.gif",
  ":no:" => "no.gif",
  ":love:" => "love.gif",
  ":?:" => "question.gif",
  ":!:" => "excl.gif",
  ":idea:" => "idea.gif",
  ":arrow:" => "arrow.gif",
  ":arrow2:" => "arrow2.gif",
  ":hmm:" => "hmm.gif",
  ":hmmm:" => "hmmm.gif",
  ":bred:" => "bred.gif", 
  ":huh:" => "huh.gif",
  ":geek:" => "geek.gif",
  ":look:" => "look.gif",
  ":rolleyes:" => "rolleyes.gif",
  ":kiss:" => "kiss.gif",
  ":shifty:" => "shifty.gif",
  ":blink:" => "blink.gif",
  ":smartass:" => "smartass.gif",
  ":sick:" => "sick.gif",
  ":crazy:" => "crazy.gif",
  ":wacko:" => "wacko.gif",
  ":alien:" => "alien.gif",
  ":wizard:" => "wizard.gif",
  ":wave:" => "wave.gif",
  ":wavecry:" => "wavecry.gif",
  ":baby:" => "baby.gif",
  ":angry:" => "angry.gif",
  ":ras:" => "ras.gif",
  ":sly:" => "sly.gif",
  ":devil:" => "devil.gif",
  ":evil:" => "evil.gif",
  ":evilmad:" => "evilmad.gif",
  ":sneaky:" => "sneaky.gif",
  ":axe:" => "axe.gif",
  ":slap:" => "slap.gif",
  ":wall:" => "wall.gif",
  ":rant:" => "rant.gif",
  ":jump:" => "jump.gif",
  ":yucky:" => "yucky.gif",
  ":nugget:" => "nugget.gif",
  ":smart:" => "smart.gif",
  ":shutup:" => "shutup.gif",
  ":shutup2:" => "shutup2.gif",
  ":crockett:" => "crockett.gif",
  ":zorro:" => "zorro.gif",
  ":snap:" => "snap.gif",
  ":beer:" => "beer.gif",
  ":beer2:" => "beer2.gif",
  ":drunk:" => "drunk.gif",
  ":strongbench:" => "strongbench.gif",
  ":weakbench:" => "weakbench.gif",
  ":dumbells:" => "dumbells.gif",
  ":music:" => "music.gif",
  ":stupid:" => "stupid.gif",
  ":dots:" => "dots.gif",
  ":offtopic:" => "offtopic.gif",
  ":spam:" => "spam.gif",
  ":oops:" => "oops.gif",
  ":lttd:" => "lttd.gif",
  ":please:" => "please.gif",
  ":sorry:" => "sorry.gif",
  ":hi:" => "hi.gif",
  ":yay:" => "yay.gif",
  ":cake:" => "cake.gif",
  ":hbd:" => "hbd.gif",
  ":band:" => "band.gif",
  ":punk:" => "punk.gif",
  ":rofl:" => "rofl.gif",
  ":bounce:" => "bounce.gif",
  ":mbounce:" => "mbounce.gif",
  ":thankyou:" => "thankyou.gif",
  ":gathering:" => "gathering.gif",
  ":hang:" => "hang.gif",
  ":chop:" => "chop.gif",
  ":rip:" => "rip.gif",
  ":whip:" => "whip.gif",
  ":judge:" => "judge.gif",
  ":chair:" => "chair.gif",
  ":tease:" => "tease.gif",
  ":box:" => "box.gif",
  ":boxing:" => "boxing.gif",
  ":guns:" => "guns.gif",
  ":shoot:" => "shoot.gif",
  ":shoot2:" => "shoot2.gif",
  ":flowers:" => "flowers.gif",
  ":wub:" => "wub.gif",
  ":lovers:" => "lovers.gif",
  ":kissing:" => "kissing.gif",
  ":kissing2:" => "kissing2.gif",
  ":console:" => "console.gif",
  ":group:" => "group.gif",
  ":hump:" => "hump.gif",
  ":hooray:" => "hooray.gif",
  ":happy2:" => "happy2.gif",
  ":clap:" => "clap.gif",
  ":clap2:" => "clap2.gif",
  ":weirdo:" => "weirdo.gif",
  ":yawn:" => "yawn.gif",
  ":bow:" => "bow.gif",
  ":dawgie:" => "dawgie.gif",
  ":cylon:" => "cylon.gif",
  ":book:" => "book.gif",
  ":fish:" => "fish.gif",
  ":mama:" => "mama.gif",
  ":pepsi:" => "pepsi.gif",
  ":medieval:" => "medieval.gif",
  ":rambo:" => "rambo.gif",
  ":ninja:" => "ninja.gif",
  ":hannibal:" => "hannibal.gif",
  ":party:" => "party.gif",
  ":snorkle:" => "snorkle.gif",
  ":evo:" => "evo.gif",
  ":king:" => "king.gif",
  ":chef:" => "chef.gif",
  ":mario:" => "mario.gif",
  ":pope:" => "pope.gif",
  ":fez:" => "fez.gif",
  ":cap:" => "cap.gif",
  ":cowboy:" => "cowboy.gif",
  ":pirate:" => "pirate.gif",
  ":pirate2:" => "pirate2.gif",
  ":rock:" => "rock.gif",
  ":cigar:" => "cigar.gif",
  ":icecream:" => "icecream.gif",
  ":oldtimer:" => "oldtimer.gif",
  ":trampoline:" => "trampoline.gif",
  ":banana:" => "bananadance.gif",
  ":smurf:" => "smurf.gif",
  ":yikes:" => "yikes.gif",
  ":osama:" => "osama.gif",
  ":saddam:" => "saddam.gif",
  ":santa:" => "santa.gif",
  ":indian:" => "indian.gif",
  ":pimp:" => "pimp.gif",
  ":nuke:" => "nuke.gif",
  ":jacko:" => "jacko.gif",
  ":ike:" => "ike.gif",
  ":greedy:" => "greedy.gif",
  ":super:" => "super.gif",
  ":wolverine:" => "wolverine.gif",
  ":spidey:" => "spidey.gif",
  ":spider:" => "spider.gif",
  ":bandana:" => "bandana.gif",
  ":construction:" => "construction.gif",
  ":sheep:" => "sheep.gif",
  ":police:" => "police.gif",
  ":detective:" => "detective.gif",
  ":bike:" => "bike.gif",
  ":fishing:" => "fishing.gif",
  ":clover:" => "clover.gif",
  ":horse:" => "horse.gif",
  ":shit:" => "shit.gif",
  ":soldiers:" => "soldiers.gif",);
///////////////////////
$privatesmilies = array(
  ":)" => "smile1.gif",
  ":wink:" => "wink.gif",
  ":D" => "grin.gif",
  ":P" => "tongue.gif",
  ":(" => "sad.gif",
  ":'(" => "cry.gif",
  ":|" => "noexpression.gif",
  ":Boozer:" => "alcoholic.gif",
  ":deadhorse:" => "deadhorse.gif",
  ":spank:" => "spank.gif",
  ":yoji:" => "yoji.gif",
  ":locked:" => "locked.gif",
  ":grrr:" => "angry.gif",
  "O:-" => "innocent.gif",
  ":sleeping:" => "sleeping.gif",
  "-_-" => "unsure.gif",
  ":clown:" => "clown.gif",
  ":mml:" => "mml.gif",
  ":rtf:" => "rtf.gif",
  ":morepics:" => "morepics.gif",
  ":rb:" => "rb.gif",
  ":rblocked:" => "rblocked.gif",
  ":maxlocked:" => "maxlocked.gif",
  ":hslocked:" => "hslocked.gif",);
$linebreak = "\r\n";
////////////////////
function get_user_class_image($class){switch ($class){
case UC_USER: return "pic/class/leecher.gif";
case UC_720p: return "pic/class/user.gif";
case UC_1080i: return "pic/class/power.gif";
case UC_1080p: return "pic/class/staff_leader.gif";
case UC_UHD: return "pic/class/veteran_user.gif";
case UC_VIPS: return "pic/class/veteran.gif";
case UC_UPLOADER: return "pic/class/uploader.gif";
case UC_VIP: return "pic/class/vip.gif";
case UC_MODERATOR: return "pic/class/mod.gif";
case UC_ADMINISTRATOR: return "pic/class/admin.gif";
case UC_SYSOP: return "pic/class/supervisor.gif";
case UC_VLADELEC: return "pic/class/sysop.gif";}return "";}
///////////////////////////////////////////////
$cracktrack = strtolower(urldecode($_SERVER['QUERY_STRING']));
$wormprotector = array('chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(', 'cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20',
'union%20', '%20union', 'union(', 'union=', 'union+', 'echr(', '%20echr', 'echr%20', 'echr=', 'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20',
'%20mdir', 'mdir(', 'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm', 'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20',
'mv(', 'rmdir(', 'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(', 'locate%20', 'grep%20',
'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall', 'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20', 'insert%20into',
'select%20', 'nigga(', '%20nigga', 'nigga%20', 'fopen', 'fwrite', '%20like', 'like%20', '$_request', '$_get', '$request', '$get', '.system',
'HTTP_PHP', '&aim', '%20getenv', 'getenv%20', 'new_password', '&icq', '/etc/password', '/etc/shadow', '/etc/groups', '/etc/gshadow', 'HTTP_USER_AGENT',
'HTTP_HOST', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id', '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+',
'bin/python', 'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/X11R6/bin/xterm', 'lsof%20', '/bin/mail', '.conf',
'motd%20', 'HTTP/1.', '.inc.php', 'cgi-', '.eml', 'file\://', 'window.open', '<script>', 'javascript\://', 'img src', 'img%20src',
'.jsp', 'ftp.exe', 'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd', 'servlet', '/etc/passwd', 'wwwacl',
'~root', '~ftp', '.js', '.jsp', 'admin_', '.history', 'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20',
'halt%20', 'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con', '<script', '/robot.txt', '/XSS/',
'/perl', 'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from', 'select from', 'drop%20', '.system', 'getenv', 'http_', '_php', 'php_', 'HelloThinkPHP21',
'/Index/\think\app/invokefunction&function=call_user_func_array&vars[0]=md5&vars[1][]=HelloThinkPHP21', 
'/index.php?s=/Index/\think\app/invokefunction&function=call_user_func_array&vars[0]=md5&vars[1][]=HelloThinkPHP21',
'index.php?s=/Index/\think\app/invokefunction&function=call_user_func_array&vars[0]=md5&vars[1][]=HelloThinkPHP21', 
'user_func_array', 'phpinfo()', '@md5', 'phpstorm', '/?XDEBUG_SESSION_START=phpstorm', '?XDEBUG_SESSION_START=phpstorm', 'XDEBUG', 'SESSION', 'XDEBUG_SESSION_START', 
'?a=fetch&content=<php>die(@md5(HelloThinkCMF))</php>', '/?a=fetch&content=die(@md5(HelloThinkCMF))', '?a=fetch&content=die(@md5(HelloThinkCMF))', 'HelloThinkCMF',
'</php>', '<php>', '<?php', '?>', '/EN/_vti_bin/WebPartPages.asmx', '_vti_bin/WebPartPages.asmx', 'WebPartPages.asmx', '.asmx', 'sql=');
$checkworm = str_ireplace($wormprotector, '*', $cracktrack);
if($cracktrack != $checkworm){global $CURUSER, $rootpath;$cremotead = $_SERVER['REMOTE_ADDR'];$cuseragent = $_SERVER['HTTP_USER_AGENT'];
$ip = getip();$ag = getenv("HTTP_USER_AGENT");$host = getenv("REQUEST_URI");$date = date("d.m.y");$time = date("H:i:s");dbconn();$first = sqlesc(getip());
$resyy = sql_query("SELECT * FROM bans WHERE first=$first AND haker = 'yes'") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($resyy) > 0){stderr("<html><head><meta http-equiv='refresh' content='3;url=https://www.fbi.gov".$host."'></head>
<body style='background:black no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'>
Hacker? Well, congratulations!</body></html>");}else{if($CURUSER){$modcomment = "Hakker? Don't break us!";
$flist = $rootpath."include/user_cache/user_".$CURUSER["id"].".cache";if(file_exists($flist)){unlink($rootpath."include/user_cache/user_".$CURUSER["id"].".cache");}
mysql_query("UPDATE users SET enabled='no', modcomment = ".sqlesc($modcomment)." WHERE id = ".$CURUSER["id"]);mysql_query("DELETE FROM sessions WHERE ip = ".sqlesc(getip()));
$userr = $CURUSER["username"];logoutcookie();}else{$userr = "Гость";}$comments = "Hakker? Don't break us!";$comment = trim($comments);
$comment = sqlesc(htmlspecialchars_uni($comment));$added = sqlesc(get_date_time());
mysql_query("INSERT INTO bans (added, addedby, first, comment, haker) VALUES($added, 2, $first, $comment, 'yes')");
mysql_query("DELETE FROM sessions WHERE ip = ".sqlesc(getip()));unlink("include/cache/bans.cache");
write_log("Атака остановлена! Отаковал(а): $userr! Его(её) данные: $ip ; $ag<br>URL SQL-inection: $host<br>$date ; $time.","5DDB6E","bans");
stderr("<html><head><meta http-equiv='refresh' content='3;url=https://www.fbi.gov".$host."'></head>
<body style='background:black no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'>
Attack detected!<br><br><b>Youre attack was blocked:</b><br>$cremotead - $cuseragent<br><br>Hacker? Well, congratulations!<br><br>You are banned! Farewell!</body></html>");}}
///////////////////////////////////////////////
define ("DEBUG_MODE", 1); // Shows the queries at the bottom of the page.
// BACKWARD CODE COMPATIBILITY
if(!isset($_POST) && isset($_POST)){$_POST = htmlspecialchars_uni($_POST);$_GET = isset($_GET);
$_SERVER = isset($_SERVER);$_COOKIE = isset($_COOKIE);$_ENV = isset($_ENV);$_FILES = isset($_FILES);}
/////////////////////////////
class Cache{private $_cache_type = 'auto';private $_memcache = null;private static $instance = null;public static function getInstance ($options = null){
if(is_null(self::$instance)){self::$instance = new Cache($options);}return self::$instance;}private function __clone() {}
private function __construct($options = null){
if($options == null){$options = array('cache'=>'auto','memcache'=>array('server'=>array('host'=>"localhost", 'port'=>11211)));}$cache_systems = array();
if(function_exists('eaccelerator_get'))$cache_systems[] = 'eaccelerator';if(function_exists('apc_fetch'))$cache_systems[] = 'apc';
if(function_exists('xcache_get'))$cache_systems[] = 'xcache';if(class_exists('Memcache'))$cache_systems[] = 'memcache';
$required_cache = isset($options['cache']) ? $options['cache'] : $this->_cache_type;
if(count($cache_systems) && $required_cache != 'none') {
if($required_cache == 'auto'){$this->_cache_type = array_shift($cache_systems);}elseif(in_array($required_cache, $cache_systems)){$this->_cache_type = $required_cache;}else{
$this->_cache_type = 'none';}}else{$this->_cache_type = 'none';}if($this->_cache_type == 'memcache'){$failed = true;
if(isset($options['memcache']) && is_array($options['memcache'])){$this->_memcache = new Memcache;
foreach ($options['memcache'] as $server){if(!is_array($server) || !isset($server['host'])){continue;}
$server['port'] = isset($server['port']) ? (int) $server['port'] : ini_get('memcache.default_port');
$server['persistent'] = isset($server['persistent']) ? (bool) $server['persistent'] : true;
if($this->_memcache->addServer($server['host'], $server['port'], $server['persistent'])){$failed = false;}}
if($failed)$this->_memcache = null;}if($failed)$this->_cache_type = 'none';}}
function get($key){$data = null;switch ($this->_cache_type){case 'none': break;case 'eaccelerator': $data = eaccelerator_get($key);break;
case 'apc': $data = apc_fetch($key);break;case 'xcache': $data = xcache_get($key);break;case 'memcache': $data = $this->_memcache->get($key);break;}return $data;}
function set($key, $data, $ttl=0){switch ($this->_cache_type){case 'none': break;case 'eaccelerator': eaccelerator_put($key, $data, $ttl);break;
case 'apc': apc_store($key, $data, $ttl);break;case 'xcache': xcache_set($key, $data, $ttl);break;
case 'memcache': if(!$this->_memcache->replace($key, $data, MEMCACHE_COMPRESSED, $ttl)){$this->_memcache->set($key, $data, MEMCACHE_COMPRESSED, $ttl);}break;}}
function delete($key, $ttl=null){switch ($this->_cache_type){case 'none': break;case 'eaccelerator': eaccelerator_rm($key);break;
case 'apc': apc_delete($key);break;case 'xcache': xcache_unset($key);break;case 'memcache': $this->_memcache->delete($key, $ttl);break;}}
function getCacher(){return $this->_cache_type;}}
//////////////////////////////////
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
/////////////////////////////////
class BDecode{
function numberdecode($wholefile, $start){$ret[0] = 0;$offset = $start;$negative = false;if($wholefile[$offset] == '-'){$negative = true;$offset++;}
if($wholefile[$offset] == '0'){$offset++;if($negative) return array(false);if($wholefile[$offset] == ':' || $wholefile[$offset] == 'e'){$offset++;$ret[0] = 0;$ret[1] = $offset;
return $ret;}return array(false);}while(true){if($wholefile[$offset] >= '0' && $wholefile[$offset] <= '9'){$ret[0] *= 10;$ret[0] += ord($wholefile[$offset]) - ord("0");$offset++;}
else if($wholefile[$offset] == 'e' || $wholefile[$offset] == ':'){$ret[1] = $offset+1;if($negative){if($ret[0] == 0) return array(false);$ret[0] = - $ret[0];}return $ret;
}else return array(false);}}
function decodeEntry($wholefile, $offset=0){
if($wholefile[$offset] == 'd') return $this->decodeDict($wholefile, $offset);if($wholefile[$offset] == 'l') return $this->decodelist($wholefile, $offset);
if($wholefile[$offset] == "i"){$offset++;return $this->numberdecode($wholefile, $offset);}$info = $this->numberdecode($wholefile, $offset);
if($info[0] === false) return array(false);$ret[0] = substr($wholefile, $info[1], $info[0]);$ret[1] = $info[1]+strlen($ret[0]);return $ret;}
function decodeList($wholefile, $start){$offset = $start+1;$i = 0;if($wholefile[$start] != 'l') return array(false);$ret = array();while(true){
if($wholefile[$offset] == 'e') break;$value = $this->decodeEntry($wholefile, $offset);if($value[0] === false) return array(false);$ret[$i] = $value[0];$offset = $value[1];$i ++;}
$final[0] = $ret;$final[1] = $offset+1;return $final;}
function decodeDict($wholefile, $start=0){$offset = $start;if($wholefile[$offset] == 'l') return $this->decodeList($wholefile, $start);
if($wholefile[$offset] != 'd') return false;$ret = array();$offset++;
while(true){if($wholefile[$offset] == 'e'){$offset++;break;}$left = $this->decodeEntry($wholefile, $offset);if(!$left[0]) return false;$offset = $left[1];
if($wholefile[$offset] == 'd'){$value = $this->decodedict($wholefile, $offset);if(!$value[0]) return false;$ret[addslashes($left[0])] = $value[0];$offset= $value[1];continue;}
else if($wholefile[$offset] == 'l'){$value = $this->decodeList($wholefile, $offset);if(!$value[0] && is_bool($value[0])) return false;$ret[addslashes($left[0])] = $value[0];
$offset = $value[1];}else{$value = $this->decodeEntry($wholefile, $offset);if($value[0] === false) return false;$ret[addslashes($left[0])] = $value[0];$offset = $value[1];}}
if(empty($ret)) $final[0] = true;else $final[0] = $ret;$final[1] = $offset;return $final;}}
////////////////////
function BDecode($wholefile){$decoder = new BDecode;$return = $decoder->decodeEntry($wholefile);return $return[0];}
////////////////
class BEncode{
function makeSorted($array){$i=0;if(empty($array)) return $array;foreach($array as $key => $value)$keys[$i++] = stripslashes($key);sort($keys);
for($i=0; isset($keys[$i]); $i++)$return[addslashes($keys[$i])] = $array[addslashes($keys[$i])];return $return;}
function encodeEntry($entry, &$fd, $unstrip = false){if(is_bool($entry)){$fd .= "de";return;}if(is_int($entry) || is_float($entry)){$fd .= "i".$entry."e";return;}
if($unstrip) $myentry = stripslashes($entry);else $myentry = $entry;$length = strlen($myentry);$fd .= $length.":".$myentry;return;}
function encodeList($array, &$fd){$fd .= "l";if(empty($array)){$fd .= "e";return;}for($i=0; isset($array[$i]); $i++) $this->decideEncode($array[$i], $fd);$fd .= "e";}
function decideEncode($unknown, &$fd){if(is_array($unknown)){if(isset($unknown[0]) || empty($unknown)) return $this->encodeList($unknown, $fd);
else return $this->encodeDict($unknown, $fd);}$this->encodeEntry($unknown, $fd);}
function encodeDict($array, &$fd){$fd .= "d";if(is_bool($array)){$fd .= "e";return;}$newarray = $this->makeSorted($array);
foreach($newarray as $left => $right){$this->encodeEntry($left, $fd, true);$this->decideEncode($right, $fd);}$fd .= "e";return;}}
/////////////
function BEncode($array){$string = "";$encoder = new BEncode;$encoder->decideEncode($array, $string);return $string;}
/////////  httptscraper ON ////////////////
class ScraperException extends Exception{private $connectionerror;		
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
foreach($infohash as $hash){$retd = unpack("Nseeders/Ncompleted/Nleechers",substr($ret,$index,12));$retd['infohash'] = $hash;$torrents[$hash] = $retd;$index = $index + 12;}return($torrents);}}
/////////  httptscraper OFF ////////////////
}?>