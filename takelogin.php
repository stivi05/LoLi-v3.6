<? require_once("include/bittorrent.php");dbconn();gzip();if(!$CURUSER){failedloginscheck();		
function bark($text = "<center>Username or password are incorrect</center>"){
?><html><head><meta http-equiv='refresh' content='8;url=/'></head><body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"><?=stderr("Login failed", $text);?></body></html><?}
$nip = sqlesc(getip());$res = sql_query("SELECT * FROM bans WHERE first = $nip") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res) > 0){$comment = mysql_fetch_assoc($res);$comment = $comment["comment"];
bark("<center>Your IP is banned on the site!</center>");}if(!mkglobal("username:password")) failedlogins();
function validpassword($password){if($password == "") return false;
$allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789><^*-|_";
for ($i = 0; $i < strlen($password); ++$i)if(strpos($allowedchars, $password[$i]) === false) return false;return true;}
if(!validpassword($password)) bark("<center><b>Invalid password!</b> Allowed characters are: <td class='code'>abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789><^*-|_</td></center>");
$username = strip_tags($username);$username = htmlspecialchars_uni($username);$username = mysql_real_escape_string($username);$password = strip_tags($password);$password = htmlspecialchars_uni($password);$password = mysql_real_escape_string($password);
function is_password_correct($password, $secret, $hash){
return ($hash == md5($secret . $password . $secret) || $hash == md5($secret . trim($password) . $secret));}
$res = mysql_query("SELECT id, passhash, secret, enabled, status, (seeder + leecher) AS peers, language FROM users WHERE username = ".sqlesc($username));
$row = mysql_fetch_array($res);if(!$row){$ip = sqlesc(getip());$added = sqlesc(get_date_time());
$a = (@mysql_fetch_row(@mysql_query("select count(*) from loginattempts where ip=$ip"))) or sqlerr(__FILE__, __LINE__);
if($a[0] == 0){mysql_query("INSERT INTO loginattempts (ip, added, attempts) VALUES ($ip, $added, 1)") or sqlerr(__FILE__, __LINE__);}
else{mysql_query("UPDATE loginattempts SET attempts = attempts + 1 where ip=$ip") or sqlerr(__FILE__, __LINE__);}
write_log("Неудачная попытка войти под ЛОГИНОМ <font color=red><b>".$username."</b></font> и ПАРОЛЕМ <font color=blue><b>".$password."</b></font> с IP: <font color=dark><b><a href=usersearch.php?ip=".getip().">".getip()."</a></b></font>", "5DDB6E", "login");
bark("<center><font color='dark'>You are not registered in the system. Check the spelling of your LOGIN case sensitive!</font><br><br><font color=red>Вы не зарегистрированы в системе! Проверьте правильность написания Вашего ЛОГИНА с учетом РЕГИСТРА!</font></center>");}
if ($row["status"] == 'pending') bark("<center>You have not activated your account yet! Activate your account and try again.</center>");
if(!is_password_correct($password, $row['secret'], $row['passhash'])){
$sql = mysql_query("SELECT username FROM users WHERE id = $row[id]");$arr = mysql_fetch_assoc($sql);$name = $arr["username"];
$msgs = "Только что была произведена неудачная попытка входа (использованный пароль: [color=dark][b]".$password."[/b][/color]) под Вашим аккаунтом с [b]IP:[/b] [color=red][b]".getip()."[/b][/color], если это не Вы, рекомендуем немедленно сменить пароль на сложный много символьный, а данный [b]IP:[/b] ([color=red][b]".getip()."[/b][/color]) передать Администрации сайта !";
$msga = unesc($msgs);send_pm(2, $row['id'], get_date_time(), "Попытка ВЗЛОМА вашего Аккаунта !", $msga);  
write_log("Неудачная попытка войти под аккаунтом юзера <font color=red><b>$name</b></font> с ПАРОЛЕМ <font color=blue><b>".$password."</b></font> с IP: <font color=dark><b><a href=usersearch.php?ip=".getip().">".getip()."</a></b></font>", "5DDB6E", "login");
failedlogins();}if($row['enabled'] == 'no'){
list($reason, $disuntil) = mysql_fetch_row(mysql_query('SELECT reason, disuntil FROM users_ban WHERE userid = '.$row['id']));if($disuntil){
bark('<center><font color="red"><b>This account has been banned.</b></font><br><b>Inclusion date:</b> '.$disuntil.'<br><b>Cause:</b> '.$reason.'</center>');}else{
bark('<center><font color="red"><b>This account has been disabled.</b></font></center>');}}
$ip = getip();if($row[peers] > 0 && $row[ip] != $ip && $row[ip]) bark("<center>This user is currently active from another IP. Input is not possible.</center>");
$expires = (int) $_POST["expires"];if (!$expires or $expires <= 0 or $expires > 31556926){$expires = 0x7fffffff;}else{$expires = time() + $expires;}
$rowid = $row["id"];$Cacher = Cache::getInstance();$Cacher->delete("user_cache_".$rowid);
logincookie($row["id"], $row["passhash"], $row["language"], 1, $expires);if(!empty($_POST["returnto"])) header("Location: $DEFAULTBASEURL/$_POST[returnto]");else header("Location: $DEFAULTBASEURL"); 
}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>