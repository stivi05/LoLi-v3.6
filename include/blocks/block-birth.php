<?php if(!defined('BLOCK_FILE')){header("Location: ../index.php");exit;}
global $CacheBlock, $lastnewsBlock_Refresh;$blocktitle = ".:: Дни рождениия ::.";$_cache = 'Blocks_birth.cache'; 
if(!$CacheBlock->Check($_cache, $lastnewsBlock_Refresh?0:86400)){ //20 chasov 
$b = 0;$currentdate = date("Y-m-d", time() + $CURUSER['tzoffset'] * 60);list($year1, $month1, $day1) = explode('-', $currentdate); 
$res = mysql_query("SELECT birthday, id, username, class, donor, warned, gender FROM users WHERE  birthday != '0000-00-00'") or sqlerr(); 
while ($arr = mysql_fetch_assoc($res)){$birthday = date($arr["birthday"]);$username = get_user_class_color($arr["class"], $arr["username"]);$id = $arr["id"]; 
list($year2, $month2, $day2) = explode('-', $birthday); 
if(($month1 == $month2) && ($day1 == $day2)){if($b > 0) $content .=", ";
$donator = $arr["donor"] == "yes";if($donator){$username .= "<img border='0' alt='Звезданутый' src='pic/star.gif'/>";}
$female = $arr["gender"] == "2";if($female){$username .= "<img border='0' alt='Девушка' src='pic/ico_f.gif'/>";}
$male = $arr["gender"] == "1";if($male){$username .= "<img border='0' alt='Парень' src='pic/ico_m.gif'/>";}
$warned = $arr["warned"] == "yes";if($warned){$username .= "<img border='0' alt='предупрежден' src='pic/warned.gif'/>";}
$content .="<a href='user_$id'><b>$username</b></a>"; 
$b = $b + 1;}}if ($b == 0) $content .="Сегодня нет дней рождений...";$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);?>