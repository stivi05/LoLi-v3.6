<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){global $CURUSER;if(get_user_class() > UC_VLADELEC || get_user_class() < UC_USER){
write_log("Пользователь ".$CURUSER["username"]." пытается поиметь нас! ха-ха его IP=".getip()."","white","error");
logoutcookie();mysql_query("update users set enabled='no' where id='".$CURUSER['id']."'");}stdhead();stdfoot();}else{
global $CacheBlock, $SITENAME;$_cache = 'signup.cache';$_cache2 = 'inwayts.cache';$signup = $CacheBlock->Read($_cache);
$inwayts = $CacheBlock->Read($_cache2);$banes = sql_query("SELECT first FROM bans WHERE first = '".getip()."'") or sqlerr(__FILE__, __LINE__);if(mysql_num_rows($banes) > 0){
?><!DOCTYPE html><html lang="ru"><head><meta http-equiv='refresh' content='0;url=https://www.fbi.gov/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">
</body></html><? die;}else{$users = get_row_count("users");$newres = sql_query("SELECT username FROM users WHERE ip = '".getip()."'") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($newres) > 0){$signup1 = "";$signup2 = "";}else{$signup1 = "<span id='signup'>Sign Up</span>";$signup2 = "<span id='signup2'>Sign Up</span>";}
?><!DOCTYPE html><html lang="ru"><head><meta charset="utf-8"><meta name="description" content="<?=$SITENAME?>"><link rel="canonical" href="index.php">
<title><?=$SITENAME?></title><?header("Cache-Control: public, max-age=604800, immutable");header("Expires: ".gmdate("D, d M Y H:i:s", time() + 60*60*744)." GMT");?>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" /><link rel="shortcut icon" type="image/x-icon" href="data:image/x-icon"><link rel="stylesheet" href="login.css">
</head><body><div id="login-button" style='font-size:98px;' title="Login. Just click here">👤</div>
<div id="container"><h1>Log In</h1><span class="close-btn" style='font-size:24px;font-weight:bold;color:white;' title='close'>⮾</span>
<form id="login" method="post" action="takelogin"><p>You <?=remaining();?> login attempts</p><input type="text" name="username" id="loginEmail" placeholder="Login" required />
<input type="password" name="password" id="loginPass" placeholder="Password" required /><input type="submit" class="orange-btn" value="Login now">
<?if(isset($returnto))print("<input type='hidden' name='returnto' value='".htmlspecialchars_uni($returnto)."'/>");?></form>
<div id="remember-container"><?if($signup['vibor'] == 0){}else{?><?=$signup1?><?}?>
<span id="telega"><a target='_blank' href='https://t.me'>Contacts</a></span><span id="forgotten">Password Recovery</span></div></div>
<div id="forgotten-container" style='text-align:center'><h1>Recover</h1><span class="close-btn" style='font-size:24px;font-weight:bold;color:white;' title='close'>⮾</span>
<a href='rqst'>Secret Question</a><form id="recover" method="post" action="recover">
<input type="text" name="email" id="recoverEmail" placeholder="Your Email Address" required /><input type="submit" class="orange-btn" value="Restore"/></form>
<div id="logins-container"><span id="logins2">Login</span><span id="telega2"><a target='_blank' href='https://t.me'>Contacts</a></span><?
if($signup['vibor'] == 0){}else{?><?=$signup2?><?}?></div></div><?if($signup['vibor'] == 0){}else{?>
<div id="signup-container"><h1>Sign Up</h1><span class="close-btn" style='font-size:24px;font-weight:bold;color:white;' title='close'>⮾</span>
<form id="reg" method="post" action="treg"><input class="login" type="text" name="wantusername" placeholder="Login in English" id="wantusername" required />
<input class="pass" type="password" name="passagain" placeholder="Password" id="passagain" required />
<input class="pass" type="password" name="wantpassword" placeholder="Password again" id="wantpassword" required />
<input class="mail" type="text" name="email" id="email" placeholder="E-mail (only @gmail.com)" required />
<?if($inwayts['vibor'] == 0 && $users > 0){?><input type="text" name="invite" placeholder="Invitation code" required /><?}else{}?>
<input class="orange-btn" type="submit" value="Sign Up"><div id="signups-container"><span id="logins">Login</span>
<span id="telega3"><a target='_blank' href='https://t.me'>Contacts</a></span><span id="forgotten2">Password Recovery</span></div></form></div><?}?>
<script src="login.js" async></script></body></html><?}}?>
