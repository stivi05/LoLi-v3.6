<? if(!defined('IN_TRACKER')) die('Hacking attempt!');
$MAX_CREATE_GROUPS = 50; // максимально колличество групп которые может создать юзер
$MAX_USR_GROUPS = 50; // максимально колличество групп в которых может состоять юзер
$GROUPS_MINUS_BONUS = 10; // при каком колличестве участников в группе надо платить бонусами за вступление
$PAY_BONUS = 150; // цена за вступление в группу
$last_new_users = 8; // сколько новых юзеров группы выводить 
$forum_width = '100%';
$maxsubjectlength = 300; // максимальная длинна заголовка темы
$groups_postsperpage = 15; // количество сообщений на страницу в теме
$groups_themeperpage = 15; // количество тем на страницу в группе
$groups_perpage = 20;// количество групп на страницу
$READPOST_EXPIRY = 14*86400;
$use_flood_mod = true;
$minutes = 3;
$limit = 2;
if (!function_exists('highlight'))
{
	function highlight($search, $subject, $hlstart = '<b><font color=red>', $hlend = '</font></b>')
	{
		$srchlen = strlen($search);    // lenght of searched string
		if ($srchlen == 0)
			return $subject;
		
		$find = $subject;
		while ($find = stristr($find, $search)) // find $search text in $subject -case insensitiv
		{
			$srchtxt = substr($find,0,$srchlen);    // get new search text
			$find = substr($find,$srchlen);
			$subject = str_replace($srchtxt, $hlstart.$srchtxt.$hlend, $subject);    // highlight founded case insensitive search text
		}
		
		return $subject;
	}
}


function forum_menu_bottom(){
    print("<br><br><p align=center><a href=group.php><b>Главная</b></a> | <a href=?action=search><b>Поиск по группах</b></a> | 
	<a href=?action=getdaily><b>Сообщения за сегодня</b></a> | <a href=?catchup><b>Отметить все, как прочитанные</b></a> | 
	<a href=groupmanage.php#add><b>Создать группу</b></a></p>");
}

function last_group_users($groupid) {
     global $CURUSER, $forum_width, $READPOST_EXPIRY, $DEFAULTBASEURL, $avatar_max_width, $last_new_users;
     
     begin_frame("Новые участники группы");
     ?>
     <table border="0px" cellspacing=0 cellpadding=5 width=<?php echo $forum_width; ?>>
     <?
     $res = mysql_query("SELECT g.access, g.uid, u.username, u.class, u.avatar, u.gender, u.uploaded, u.downloaded, 
	 u.last_access, u.donor, u.warned, u.title  ".
                              "FROM groups_users AS g
                               LEFT JOIN users AS u ON g.uid=u.id 
                               WHERE g.gid=".$groupid.
                             " ORDER BY g.id DESC
                               LIMIT $last_new_users") or sqlerr(__FILE__, __LINE__);
     $i=0;
     while ($row = mysql_fetch_assoc($res)) {
         $i++;     
         if ($i % 2) echo "<tr>";
         
         if ($row["downloaded"] > 0) {
                    $ratio = $row['uploaded'] / $row['downloaded'];
                    $ratio = number_format($ratio, 2);
         } elseif ($row["uploaded"] > 0) {
                    $ratio = "Inf.";
         } else {
                    $ratio = "---";
         }
         if (strtotime($row["last_access"]) > gmtime() - 600) {
                     $online = "online";
                     $online_text = "В сети";
         } else {
                     $online = "offline";
                     $online_text = "Не в сети";
         }
         $title = $row["title"];
         if ($title == ""){
                $title = get_user_class_name($row["class"]);
         }else{
                $title = htmlspecialchars_uni($title);
         }
         $avatar = htmlspecialchars_uni($row["avatar"]);
         if (!$avatar){$avatar = "pic/default_avatar.gif"; }
         if ($row["gender"] == "1") $gender = "<img src=\"pic/male1.gif\" alt=\"Парень\" style=\"margin-left: 4pt\">";
         elseif ($row["gender"] == "2") $gender = "<img src=\"pic/female1.gif\" alt=\"Девушка\" style=\"margin-left: 4pt\">";
         
         print("<td style=\"padding: 0px; width: 5%;\" align=\"center\"><img src=$avatar width=\"$avatar_max_width\"> </td><td>\n");
         print(" <img src=\"pic/buttons/button_".$online.".gif\" alt=\"".$online_text."\" title=\"".$online_text."\" style=\"position: relative; top: 2px;\" border=\"0\" height=\"14\">"
               ." <a name=comm". $row["id"]." href=userdetails.php?id=" . $row["uid"] . " class=altlink_white><b>". get_user_class_color($row["class"], htmlspecialchars_uni($row["username"])) . "</b></a> $gender<br>"
               .($row["donor"] == "yes" ? "<img src=pic/star.gif alt='Donor'>" : "") . ($row["warned"] == "yes" ? "<img src=\"/pic/warned.gif\" alt=\"Warned\">" : "") . " $title <br>\n")
               ."<font color='blue'>Рейтинг:</font> <font color=\"".get_ratio_color($ratio)."\">$ratio</font> <br><font color='green'>Раздал:</font> ".mksize($row["uploaded"]) ." <br><font color='red'>Скачал:</font> ".mksize($row["downloaded"])." </td>";
         
         if ($i % 2) echo "";
         else          echo "</tr>\n";
     }
     if ($i % 2) echo "<td></td><td></td></tr>\n";
     
     end_table();
     end_frame();
}

function show_groups()
{
    global $CURUSER, $READPOST_EXPIRY, $DEFAULTBASEURL, $main_pager, $forum_width, $groups_perpage;
    
    $page = (isset($_GET["page"]) ? (int)$_GET["page"] : 0);
    
    $groups_res = mysql_query("SELECT COUNT(*) FROM groups") or sqlerr(__FILE__, __LINE__);
    list($groups) = mysql_fetch_row($groups_res);
    
    
    $perpage = $groups_perpage;
    $num = $groups;
    
    if ($page == 0)
        $page = 1;
    
    $first = ($page * $perpage) - $perpage + 1;
    $last = $first + $perpage - 1;
    
    if ($last > $num)
        $last = $num;
    
    $pages = floor($num / $perpage);
    
    if ($perpage * $pages < $num)
        ++$pages;
    
    //------ Build menu
    $menu1 = "<p class=success align=center>";
    $menu2 = '';
    
    $lastspace = false;
    for ($i = 1; $i <= $pages; ++$i)
    {
        if ($i == $page)
            $menu2 .= "<b>[<u>$i</u>]</b>\n";
        
        else if ($i > 3 && ($i < $pages - 2) && ($page - $i > 3 || $i - $page > 3))
        {
            if ($lastspace)
                continue;
            
            $menu2 .= "... \n";
            
            $lastspace = true;
        }
        else
        {
            $menu2 .= "<a href=".$_SERVER['PHP_SELF']."?page=$i><b>$i</b></a>\n";
    
            $lastspace = false;
        }
    
        if ($i < $pages)
            $menu2 .= "</b>|<b>";
    }    
    
    $menu1 .= ($page == 1 ? "<img src='pic/prev.gif' border='0px'/>" : "<a href=".$_SERVER['PHP_SELF']."?page=" . ($page - 1) . ">
	<img src='pic/prev.gif' border='0px'/></a>");
    $mlb = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $menu3 = ($last == $num ? "<img src='pic/next.gif' border='0px'/></p>" : "<a href=".$_SERVER['PHP_SELF']."?page=" . ($page + 1) . ">
	<img src='pic/next.gif' border='0px'/></a></p>");
    
    $offset = $first - 1;
    
    $main_pager =  $menu1.$mlb.$menu2.$mlb.$menu3;
    
    
    $groups_res = mysql_query("SELECT f.id, f.name, f.description, f.bonus, f.users, f.create_by, f.privat, 
	f.invite, f.close, f.poster, u.username, u.class ".
                              "FROM groups AS f
                               LEFT JOIN users AS u ON f.create_by=u.id ".
                              "ORDER BY f.bonus DESC, f.id DESC
                               LIMIT $offset, $perpage") or sqlerr(__FILE__, __LINE__);

    ?><table border=0 cellspacing=0 cellpadding=5 width='<?php echo $forum_width; ?>'><?
    while ($groups_arr = mysql_fetch_assoc($groups_res))
    {
        $forumid = (int)$groups_arr["id"];
        $poster = $groups_arr["poster"] ? '<img width="150" src="'.htmlspecialchars($groups_arr["poster"]).'">' : '';
        
        if ($groups_arr['close'] == 1) {
            $urls = "Только по приглашениях";
        } elseif ($groups_arr['invite'] == 1) {
            $urls = "<a href=\"groupmanage.php?action=leave_invite&id=".$forumid."\">Подать заявку</a>";
        } else {
            $urls = "<a href=\"groupmanage.php?action=jointogroup&id=".$forumid."\">Вступить в группу</a>";
        }
        
        $description = $groups_arr["description"] ? 'Описание: '.htmlspecialchars($groups_arr["description"]) : '';
         
        ?>
        
        <tr valign="top">
            <td width="1%"><?php echo $poster; ?></td>
            <td>Название: <a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=viewforum&forumid=<?php echo $forumid; ?>'><b><?php echo htmlspecialchars($groups_arr["name"]); ?></b></a><br>
            Создатель: <a href="/userdetails.php?id=<?=$groups_arr["create_by"]?>"><?php echo get_user_class_color($groups_arr["class"],$groups_arr['username']) ?></a><br>
            Участников: <?php echo number_format($groups_arr["users"]); ?><br>
            Бонусов: <?php echo number_format($groups_arr["bonus"]); ?><br>
            <?php echo $description; ?></td>

            <td width="1%" nowrap>
            <?=$urls?>
            </td>
        </tr>
        
        <?
    }
    print('</table>');
}


function catch_up($id = 0)
{	
	global $CURUSER, $READPOST_EXPIRY;
	
	$userid = (int)$CURUSER['id'];
	
	$res = mysql_query("SELECT t.id, t.lastpost, r.id AS r_id, r.lastpostread ".
					   "FROM groups_topics AS t ".
					   "LEFT JOIN groups_posts AS p ON p.id = t.lastpost ".
					   "LEFT JOIN groups_readposts AS r ON r.userid=".sqlesc($userid)." AND r.topicid=t.id ".
					   "WHERE p.added > ".sqlesc(get_date_time() - $READPOST_EXPIRY).
					   (!empty($id) ? ' AND t.id '.(is_array($id) ? 'IN ('.implode(', ', $id).')' : '= '.sqlesc($id)) : '')) or sqlerr(__FILE__, __LINE__);

	while ($arr = mysql_fetch_assoc($res))
	{
		$postid = (int)$arr['lastpost'];
		
		if (!is_valid_id($arr['r_id']))
			@mysql_query("INSERT INTO groups_readposts (userid, topicid, lastpostread) VALUES($userid, ".(int)$arr['id'].", $postid)") or sqlerr(__FILE__, __LINE__);
		else if ($arr['lastpostread'] < $postid)
			@mysql_query("UPDATE LOW_PRIORITY groups_readposts SET lastpostread = $postid WHERE id = ".$arr['r_id']) or sqlerr(__FILE__, __LINE__);
	}
	mysql_free_result($res);
}

//-------- Returns the minimum read/write class levels of a forum



//-------- Returns the forum ID of a topic, or false on error
function get_topic_forum($topicid)
{
    $res = mysql_query("SELECT forumid FROM groups_topics WHERE id=".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);

    if (mysql_num_rows($res) != 1)
      return false;

    $arr = mysql_fetch_row($res);

    return $arr[0];
}

//-------- Returns the ID of the last post of a forum
function update_topic_last_post($topicid)
{
    $res = mysql_query("SELECT id FROM groups_posts WHERE topicid=".sqlesc($topicid)." ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);

    $arr = mysql_fetch_row($res) or die("No post found");

    $postid = $arr[0];

    @mysql_query("UPDATE LOW_PRIORITY groups_topics SET lastpost=$postid WHERE id=".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
}

function get_forum_last_post($forumid)
{
    $res = mysql_query("SELECT lastpost FROM groups_topics WHERE forumid=".sqlesc($forumid)." ORDER BY lastpost DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);

    $arr = mysql_fetch_row($res);

    $postid = $arr[0];

    if ($postid)
      return $postid;

    else
      return 0;
}


//-------- Inserts a compose frame
function insert_compose_frame($id, $newtopic = true, $quote = false)
{
	global $maxsubjectlength, $CURUSER, $forum_pics, $DEFAULTBASEURL;
	
	if ($newtopic)
	{
		$res = mysql_query("SELECT name FROM groups WHERE id = ".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
		if (mysql_num_rows($res) == 0) stderr('Error', 'Группа не найдена!');
        $arr = mysql_fetch_assoc($res);
        
        $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        list($usr_access) = mysql_fetch_array($res);
        if ($usr_access == false and get_user_class() < UC_ADMINISTRATOR) {
            stdmsg("Извините", "Вы должны быть участником группы.");
            end_table();
            end_frame();
            stdfoot();
            exit();
        }
	}
	else
	{
		$res = mysql_query("SELECT subject, locked, forumid FROM groups_topics WHERE id = ".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
		if (mysql_num_rows($res) == 0) stderr('Error', 'Топик не найден!');
        $arr = mysql_fetch_assoc($res);

        $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($gid)) or sqlerr(__FILE__, __LINE__);
        list($usr_access) = mysql_fetch_array($res);
        if ($usr_access == false and get_user_class() < UC_ADMINISTRATOR) {
            stdmsg("Извините", "Вы должны быть участником группы.");
            end_table();
            end_frame();
            stdfoot();
            exit();
        }
        
		if ($arr['locked'] == 'yes' and get_user_class() < UC_ADMINISTRATOR and $usr_access < $classes['moder'])
		{
			stdmsg("Извините", "Топик закрыт.");
			end_table();
            end_frame();
            stdfoot();
			exit();
		}				
	}
	
	//begin_frame(".:: Ответ в Теме ::.", true);
	
	?>
	<form method='post' name='compose' id='compose' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
	<input type="hidden" name="action" value="post" />
	<input type='hidden' name='<?php echo ($newtopic ? 'forumid' : 'topicid'); ?>' value='<?php echo $id; ?>'><?php
	
	begin_table(true);
	
	if ($newtopic)
	{
		?>
		<tr>
			<td class='coolhead'><center><b>Тема:</b>&nbsp;&nbsp;<input type='text' size='120' maxlength='<?php echo $maxsubjectlength; ?>' name='subject' style='height: 19px'>
			</center></td>
		</tr><?php
	}
		
	if ($quote)
	{
		$postid = (int)$_GET["postid"];
		if (!is_valid_id($postid))
		{
			stdmsg("Error", "Invalid ID!");
			end_table();
            end_frame();
            stdfoot();
			exit();
		}
		
		$res = mysql_query("SELECT groups_posts.*, users.username FROM groups_posts JOIN users ON groups_posts.userid = users.id WHERE groups_posts.id = $postid") or sqlerr(__FILE__, __LINE__);
		
		if (mysql_num_rows($res) == 0)
		{
			stdmsg("Error", "Сообщение не найдено");
			end_table();
            end_main_frame();
            stdfoot();
			exit();
		}
		
		$arr = mysql_fetch_assoc($res);
	}
		begin_frame(".:: Ответ в Теме ::.");
		begin_table();
	?><tr>
		<td><center><?php
		$qbody = ($quote ? "[quote=".htmlspecialchars($arr["username"])."]".htmlspecialchars(unesc($arr["body"]))."[/quote]" : '');
			textbbcode("compose", "body", $qbody);
	
		?><tr>
        	<td colspan='2' align='center'>
            <input type="button" value="Предпросмотр" onClick="javascript:ajaxpreview('area');" ><input type='submit' value='Отправить'>
			</center>

<div id="loading-layer" style="display:none;font-family: Verdana;font-size: 11px;width:200px;height:50px;background:#FFF;padding:10px;text-align:center;border:1px solid #000">
     <div style="font-weight:bold;" id="loading-layer-text">Загрузка. Пожалуйста, подождите...</div><br>
     <img src="pic/loading.gif" border="0" />
</div>
<br>
<div id="preview" style="width:530px;"></div>
			</td>
		</tr>        
		</td>
        </tr><?php
		end_table();
		end_frame();		
		end_table();		
		?></form><?php				
	//	end_frame();		
		//------ Get 10 last groups_posts if this is a reply
		if (!$newtopic)
		{
			$postres = mysql_query("SELECT p.id, p.added, p.body, u.id AS uid, u.username, u.avatar ".
								   "FROM groups_posts AS p ".
								   "LEFT JOIN users AS u ON u.id = p.userid ".
								   "WHERE p.topicid = ".sqlesc($id)." ".
								   "ORDER BY p.id DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
			if (mysql_num_rows($postres) > 0)
			{
				?><br><?php
				begin_frame("10 последних постов");				
				while ($post = mysql_fetch_assoc($postres))
				{
					$avatar = ($CURUSER["avatars"] == "yes" ? htmlspecialchars($post["avatar"]) : '');					
					if (empty($avatar))
						$avatar = "pic/default_avatar.gif";					
					?><p class=sub>#<?php echo $post["id"]; ?> от <?php echo (!empty($post["username"]) ? $post["username"] : "unknown[{$post['uid']}]"); ?> в <?php echo $post["added"]; ?></p><?php
					begin_table(true);					
					?>
					<tr>
						<td height='100' width='100' align='center' style='padding: 0px' valign="top"><img height='100' width='100' src="<?php echo $avatar; ?>" /></td>
						<td class='comment' valign='top'><?php echo format_comment($post["body"]); ?></td>
					</tr><?php					
					end_table();
				}				
				end_frame();
			}
		}		
}
 ?>