<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
require "include/group_func.php";$classes = get_classes_group();	
$action = (isset($_GET["action"]) ? trim($_GET["action"]) : (isset($_POST["action"]) ? trim($_POST["action"]) : ''));
if ($action == "newtopic"){$forumid = (int)$_GET["forumid"];stdhead("Создание новой темы");insert_compose_frame($forumid,true,false);stdfoot();die;}
//-------- Action: Post
elseif ($action == "post"){
    $forumid = (int)$_POST["forumid"];
	$topicid = (int)$_POST["topicid"];

    $newtopic = $forumid > 0;

    $subject = htmlspecialchars($_POST["subject"]);

    if ($newtopic)
    {
        $subject = trim($subject);
        if (!$subject) stderr("Error", "Введите заголовок.");
        if (strlen($subject) > $maxsubjectlength) stderr("Error", "Длинна заголовка больше допустимой.");
        
        $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
        list($usr_access) = mysql_fetch_array($res);
        if (get_user_class() < UC_ADMINISTRATOR and $usr_access == false) stderr('Error', 'Вы должны быть участником группы!');
        
    }
    else {
        $forumid = get_topic_forum($topicid) or die("Bad topic ID");
    
        $res = mysql_query("SELECT forumid FROM groups_topics WHERE id =".$topicid) or sqlerr(__FILE__, __LINE__);
        list($gid) = mysql_fetch_array($res);
        if ($gid == false) stderr('Error', 'Топик не найден!');  
        $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($gid)) or sqlerr(__FILE__, __LINE__);
        list($usr_access) = mysql_fetch_array($res);
    }
    if (get_user_class() < UC_ADMINISTRATOR and $usr_access == false) stderr('Error', 'Вы должны быть участником группы!');
    
    //------ Make sure sure user has write access in forum

    $arr = $forumid or die("Bad forum ID");

    $body = trim($_POST["body"]);
    if ($body == "") stderr("Error", "Сообщение пустое.");

    $userid = (int)$CURUSER["id"];
    
    if ($CURUSER['class'] < UC_MODERATOR)
	{
		$res = mysql_query("SELECT COUNT(id) AS c FROM groups_posts WHERE userid = ".$CURUSER['id']." AND added > '".get_date_time() - ($minutes * 60)."'");
		$arr = mysql_fetch_assoc($res);
		
		if ($arr['c'] > $limit)
			stderr("Flood", "More than ".$limit." groups_posts in the last ".$minutes." minutes.");
	}
    if ($newtopic)
    {
      //---- Create topic 

      $subject = sqlesc($subject);

      @mysql_query("INSERT INTO groups_topics (userid, forumid, subject) VALUES($userid, $forumid, $subject)") or sqlerr(__FILE__, __LINE__);

      $topicid = mysql_insert_id() or stderr("Error", "No topic ID returned");
    }
    else
    {
      //---- Make sure topic exists and is unlocked

      $res = mysql_query("SELECT * FROM groups_topics WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

      $arr = mysql_fetch_assoc($res) or die("Topic id n/a");

      if ($arr["locked"] == 'yes' && (get_user_class() < UC_ADMINISTRATOR and $usr_access < $classes['moder']))
        stderr("Error", "Топик закрыт.");

      //---- Get forum ID

      $forumid = $arr["forumid"];
    }	 
    
    //------ Insert post
	$added = "'" . get_date_time() . "'";
    $body = sqlesc($body);
	$secsdp = 1*300;
	$dtdp = sqlesc(get_date_time(get_date_time() - $secsdp)); // calculate date.
    
     //------ Check double post     
     $doublepost = mysql_query("SELECT groups_posts.id, groups_posts.added, groups_posts.userid, groups_posts.body, groups_topics.lastpost, groups_topics.id FROM groups_posts INNER JOIN groups_topics on groups_posts.id = groups_topics.lastpost WHERE groups_topics.id=$topicid AND groups_posts.userid = $userid AND groups_posts.added > $dtdp ORDER BY added DESC	LIMIT 1") or sqlerr(__FILE__, __LINE__);
     $results = mysql_fetch_assoc($doublepost);
     
     
     if (!$results) {
			@mysql_query("INSERT INTO groups_posts (topicid, userid, added, body) VALUES($topicid, $userid, $added, $body)") or sqlerr(__FILE__, __LINE__);
			$postid = mysql_insert_id() or die("Post id n/a");
			update_topic_last_post($topicid);
			
	} else {
			$oldbody = trim($results['body']);
			$newbody =  trim($_POST["body"]);
			$updatepost = sqlesc("$oldbody\n\n$newbody");
			$editedat = sqlesc(get_date_time());
	      	@mysql_query("UPDATE LOW_PRIORITY groups_posts SET body=$updatepost, editedat=$editedat, editedby=$userid WHERE id=$results[lastpost]") or sqlerr(__FILE__, __LINE__);	      	
	}	
 
    //------ All done, redirect user to the post
    $headerstr = "Location: $BASEURL/group.php?action=viewtopic&topicid=$topicid&page=last";
    if ($newtopic) header($headerstr);
    else header("$headerstr#$postid");
    die;
  }

//-------- Action: View topic
elseif ($action == "viewtopic")
{
    unset($count);
    $topicid = (int)$_GET["topicid"];
    $page = (int)$_GET["page"];
    $userid = (int)$CURUSER["id"];

	//------ Get topic info
	$res = mysql_query("SELECT t.locked, t.subject, t.sticky, t.userid AS t_userid, t.forumid, f.privat, f.close, f.name AS forum_name 
					   FROM groups_topics AS t 
					   LEFT JOIN groups AS f ON f.id = t.forumid 
					   WHERE t.id = ".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
	if (mysql_num_rows($res) == 0) stderr("Error", "Топик не найден!");
    $arr = mysql_fetch_assoc($res);
	
	$t_userid = (int)$arr['t_userid'];
	$locked = ($arr['locked'] == 'yes' ? true : false);
	$subject = $arr['subject'];
	$sticky = ($arr['sticky'] == "yes" ? true : false);
	$forumid = (int)$arr['forumid'];
	$forum = htmlspecialchars($arr["forum_name"]);
    $privat = (int)$arr['privat'];
    $close = (int)$arr['close']; 
    
    $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
    list($usr_access) = mysql_fetch_array($res);
    if ($usr_access == false and $privat == 1 and $close == 1 and get_user_class() < UC_MODERATOR) stderr("Error", "Эта группа закрытая. Что бы получить доступ вы должны вступить в группу. Вступление возможно только по приглашению.");    
    if ($usr_access == false and $privat == 1 and get_user_class() < UC_MODERATOR) stderr("Error", "Эта группа приватная. Что бы получить доступ вы должны <a href=\"groupmanage.php?action=jointogroup&id=".$forumid."\"><b>Вступить в группу</b></a>.");

	
	//------ Update hits column	

    @mysql_query("UPDATE LOW_PRIORITY groups_topics SET views = views + 1 WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

    //------ Get forum

    //------ Get post count

    $res = mysql_query("SELECT COUNT(*) FROM groups_posts WHERE topicid=$topicid") or sqlerr(__FILE__, __LINE__);

    $arr = mysql_fetch_row($res);

    $postcount = $arr[0];

    //------ Make page menu

    $pagemenu1 = "<p class=success align=center>\n";
    $perpage = $groups_postsperpage;
    $pages = ceil($postcount / $perpage);
    if ($page[0] == "p")
  	{
	    $findpost = substr($page, 1);
	    $res = mysql_query("SELECT id FROM groups_posts WHERE topicid=$topicid ORDER BY added") or sqlerr(__FILE__, __LINE__);
	    $i = 1;
	    while ($arr = mysql_fetch_row($res))
	    {
	      if ($arr[0] == $findpost)
	        break;
	      ++$i;
	    }
	    $page = ceil($i / $perpage);
	  }

    if ($page == "last")
      $page = $pages;
    else
    {
      if($page < 1)
        $page = 1;
      elseif ($page > $pages)
        $page = $pages;
    }

    $offset = $page * $perpage - $perpage;

    for ($i = 1; $i <= $pages; ++$i)
    {
      if ($i == $page)
        $pagemenu2 .= "<b>[<u>$i</u>]</b>\n";

      else
        $pagemenu2 .= "<a href=?action=viewtopic&topicid=$topicid&page=$i><b>$i</b></a>\n";
    }

    if ($page == 1)
      $pagemenu1 .= "<img src='pic/prev.gif' border='0px'></a>";

    else
      $pagemenu1 .= "<a href=?action=viewtopic&topicid=$topicid&page=" . ($page - 1) .
        "><img src='pic/prev.gif' border='0px'></a>";

    $pmlb = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    if ($page == $pages)
      $pagemenu3 .= "<img src='pic/next.gif' border='0px'></a></p>\n";

    else
      $pagemenu3 .= "<a href=?action=viewtopic&topicid=$topicid&page=" . ($page + 1) .
        "><img src='pic/next.gif' border='0px'></a></p>\n";
		
		
		
    stdhead("Группа $forum :: Тема - $subject");    
    begin_frame(".:: Группа $forum :: Тема - $subject ::.");
?>
<a name='top'></a>
<table width="97%" border="0" cellpadding="0" cellspacing="0" style="border:none;" align="center">
		<tr>
			<td align="left" width="80%" style="border:none;">
			    <h1><a href="<?php echo $_SERVER['PHP_SELF']; ?>" title="На главную форума">Группа</a> - 
				<a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=viewforum&forumid=<?php echo $forumid; ?>">
				<?php echo $forum; ?></a> - <?php echo htmlspecialchars($subject); ?></h1>
</td> 
		</tr>
	</table><?php
	$res = mysql_query(
	"SELECT p.id, p.added, p.userid, p.added, p.body, p.editedby, p.editedat, u.id as uid, u.username as uusername, u.class AS uclass, u.avatar, u.donor,
	u.title, u.enabled, u.warned,
	u.last_access, (SELECT COUNT(id) FROM groups_posts WHERE userid = u.id) AS groups_posts_count, u2.username as u2_username 
	, (SELECT lastpostread FROM groups_readposts WHERE userid = ".sqlesc((int)$CURUSER['id'])." AND topicid = p.topicid LIMIT 1) AS lastpostread
	 FROM groups_posts AS p 
	LEFT JOIN users AS u ON p.userid = u.id 
	LEFT JOIN users AS u2 ON u2.id = p.editedby
	WHERE p.topicid = ".sqlesc($topicid)." 
	ORDER BY id LIMIT $offset,$perpage") or sqlerr(__FILE__, __LINE__);
	$pc = mysql_num_rows($res);
	$pn = 0;
	
	while ($arr = mysql_fetch_assoc($res))
	{
		++$pn;
		
		$lpr = $arr['lastpostread'];
		$postid = (int)$arr["id"];
		$postadd = $arr['added'];
		$posterid = (int)$arr['userid'];
		$added = $arr['added'] . " , <i>(" . get_elapsed_time(strtotime($arr['added'])) . ") назад</i>";
	
		//---- Get poster details		
		$last_access = $arr['last_access'];
	
		$postername = get_user_class_color($arr['uclass'],$arr['uusername']).get_user_icons($arr);
		$avatar = $arr["avatar"];
		$title = (!empty($postername) ? (empty($arr['title']) ? "(".get_user_class_name($arr['uclass']).")" : "(".format_comment($arr['title']).")") : '');
		$forumgroups_posts = (!empty($postername) ? ($arr['groups_posts_count'] != 0 ? $arr['groups_posts_count'] : 'N/A') : 'N/A');
		$by = (!empty($postername) ? "<a href='userdetails.php?id=$posterid'>".$postername."</a>" : "");
	
      if (!$avatar)
        $avatar = "pic/default_avatar.gif";

		echo "<a name=$postid></a>";
		echo ($pn == $pc ? '<a name=last></a>' : '');
      print("<p class=sub><table border=0 cellspacing=0 cellpadding=0><tr><td class=embedded width=99%>#$postid by $by $title в $added");      

      print("</td><td class=embedded width=1%><a href=#top><img src=pic/top.gif border=0 alt='Top'></a></td></tr>");

      print("\n");

      begin_table(true);

		$highlight = (isset($_GET['highlight']) ? $_GET['highlight'] : '');
		$body = (!empty($highlight) ? highlight(htmlspecialchars(trim($highlight)), format_comment($arr['body'])) : format_comment($arr['body']));
      		if (is_valid_id($arr['editedby']))
			$body .= "<br><p><font size=1 class=small_com><i>Отредактировал(а) <a href='userdetails.php?id=".$arr['editedby']."'><b>".$arr['u2_username']."</b></a> в ".$arr['editedat']." </i></font></p>";
		


      $stats = "<br>&nbsp;&nbsp;Сообщений: $forumgroups_posts<br>";
      	unset($onoffpic,$dt);
      	$dt = get_date_time(gmtime() - 180);
		if (get_user_class() < UC_MODERATOR AND $posterid != $CURUSER[id])
			$onoffpic = "<img src='pic/button_offline.gif' border='0' />";
		elseif ($last_access > $dt OR $posterid == $CURUSER[id])
			$onoffpic = "<img src='pic/button_online.gif' border='0' />";
		else
			$onoffpic = "<img src='pic/button_offline.gif' border=0>";
    print("<tr valign=top><td width=150 align=left style='padding: 0px'><br>"."&nbsp; " .
       ($avatar ? "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img width=100 src=\"$avatar\">": ""). "<br>"."&nbsp;$stats<br><br></td>");

	   
	print("<td class=comment>$body</td></tr>\n");
	print("<tr><td>".$onoffpic." <a href=\"message.php?receiver=".htmlspecialchars($posterid)."&action=sendmessage\"><img src='pic/button_pm.gif' border=\"0\" alt=\"Отправить сообщеньку\"></a></td>");
	print("<td align=right>");
	
    if ((!$locked && $CURUSER) or get_user_class() >= UC_ADMINISTRATOR)				
		print("<a href=?action=quotepost&topicid=$topicid&postid=$postid><b>[ цитировать ]</b>&nbsp;</a>");

    if (get_user_class() >= UC_ADMINISTRATOR or (!$locked && $usr_access))	
		print("<a href=?action=reply&topicid=$topicid><b>[ ответить ]</b>&nbsp;</a>");
	    
				
	if (get_user_class() >= UC_ADMINISTRATOR || $usr_access >= $classes['moder'])
        print("<a href=?action=deletepost&postid=$postid><b>[ удалить ]</b>&nbsp;</a>");
	
	if (($CURUSER["id"] == $posterid && !$locked) || get_user_class() >= UC_ADMINISTRATOR || $usr_access >= $classes['moder'])
        print("<a href=?action=editpost&postid=$postid><b>[ редактировать ]</b>&nbsp;</a>");
	print("</td></tr></table></p>");
	

}
	if ($CURUSER){
	    if (($postid > $lpr) && ($postadd > (get_date_time() - $READPOST_EXPIRY)))
	    {
		    if ($lpr)
			    mysql_query("UPDATE LOW_PRIORITY groups_readposts SET lastpostread = $postid WHERE userid = $userid AND topicid = $topicid") or sqlerr(__FILE__, __LINE__);
		    else
			    mysql_query("INSERT INTO groups_readposts (userid, topicid, lastpostread) VALUES($userid, $topicid, $postid)") or sqlerr(__FILE__, __LINE__);
	    } 
    }

  	if (get_user_class() >= UC_ADMINISTRATOR or $usr_access >= $classes['moder'] or (!$locked && $usr_access)) {
?>
<table id="no_border" width=100%><tr>
<td colspan=2 class=zaliwka><center><b>Быстрый ответ</b></td></tr>
<tr><td id="no_border">
<center><form name='compose' id='compose' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'  enctype='multipart/form-data'>
<input type="hidden" name="action" value="post" />
<input type=hidden name=topicid value=<? echo $topicid;?>>
<?
textbbcode("compose","body","", 1)
?>
<center><input type="button" value="Предпросмотр" onClick="javascript:ajaxpreview('area');" ><input type=submit class=gobutton value="Добавить ответ">
</center>
<script src="js/preview.js"></script>
<div id="loading-layer" style="display:none;font-family: Verdana;font-size: 11px;width:200px;height:50px;background:#FFF;padding:10px;text-align:center;border:1px solid #000">
     <div style="font-weight:bold;" id="loading-layer-text">Загрузка. Пожалуйста, подождите...</div><br>
     <img src="pic/loading.gif" border="0" />
</div>
<br>
<div id="preview" style="width:530px;"></div>
</form>
</td></tr>
</table>
<?
}
    //------ Mod options

  	print("$pagemenu1 $pmlb $pagemenu2 $pmlb $pagemenu3");


	if (get_user_class() >= UC_ADMINISTRATOR or $usr_access >= $classes['moder'])
	{
	    print("<table border=0 cellspacing=0 cellpadding=0>\n");

	    print("<form method=post action=?action=setsticky>\n");
	    print("<input type=hidden name=topicid value=$topicid>\n");
	    print("<input type=hidden name=returnto value=$_SERVER[REQUEST_URI]>\n");
	    print("<tr><td class=embedded align=right>Важный:</td>\n");
	    print("<td class=embedded><input type=radio name=sticky value='yes' " . ($sticky ? " checked" : "") . "> да <input type=radio name=sticky value='no' " . (!$sticky ? " checked" : "") . "> нет\n");
	    print("<input type=submit value='Да' class=btn></td></tr>");
	    print("</form>\n");

	    print("<form method=post action=?action=setlocked>\n");
	    print("<input type=hidden name=topicid value=$topicid>\n");
	    print("<input type=hidden name=returnto value=$_SERVER[REQUEST_URI]>\n");
	    print("<tr><td class=embedded align=right>Закрыть:</td>\n");
	    print("<td class=embedded><input type=radio name=locked value='yes' " . ($locked ? " checked" : "") . "> да <input type=radio name=locked value='no' " . (!$locked ? " checked" : "") . "> нет\n");
	    print("<input type=submit value='Да' class=btn></td></tr>");
	    print("</form>\n");

	    print("<form method=post action=?action=renametopic>\n");
	    print("<input type=hidden name=topicid value=$topicid>\n");
	    print("<input type=hidden name=returnto value=$_SERVER[REQUEST_URI]>\n");
	    print("<tr><td class=embedded align=right>Переименовать:</td><td class=embedded><input type=text name=subject size=60 maxlength=$maxsubjectlength value=\"" . htmlspecialchars($subject) . "\">\n");
	    print("<input type=submit value='вперед' class=btn></td></tr>");
	    print("</form>\n");

	    print("<tr><td class=embedded>Удалить</td><td class=embedded>\n");
	    print("<form method=get action=group.php>\n");
	    print("<input type=hidden name=action value=deletetopic>\n");
	    print("<input type=hidden name=topicid value=$topicid>\n");
	    print("<input type=hidden name=forumid value=$forumid>\n");
	    print("<input type=checkbox name=sure value=1>Я уверен\n");
	    print("<input type=submit value='вперед' class=btn>\n");
	    print("</form>\n");
	    print("</td></tr>\n");
	    print("</table>\n");
    }

    //------ Forum quick jump drop-down
 	end_frame();
    stdfoot();
    die;
}

//-------- Action: Quote

elseif ($action == "quotepost")
{
	$topicid = (int)$_GET["topicid"];
    stdhead("Ответить");	
    insert_compose_frame($topicid, false, true);	
    stdfoot();
    die;
}

//-------- Action: Reply
elseif ($action == "reply")
{
    $topicid = (int)$_GET["topicid"];
    int_check($topicid,true);
    stdhead("Ответить");
    insert_compose_frame($topicid, false, false);
    stdfoot();
    die;
}


//-------- Action: Delete topic
elseif ($action == "deletetopic")
{
    $topicid = (int)$_GET["topicid"];
    $forumid = (int)$_GET["forumid"];
    if (!is_valid_id($topicid)) die;

    $res = mysql_query("SELECT forumid FROM groups_topics WHERE id =".$topicid) or sqlerr(__FILE__, __LINE__);
    list($gid) = mysql_fetch_array($res);
    if ($gid == false) stderr('Error', 'Топик не найден!');

    $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($gid)) or sqlerr(__FILE__, __LINE__);
    list($usr_access) = mysql_fetch_array($res);
    
    if (get_user_class() < UC_ADMINISTRATOR and $usr_access < $classes['moder']) stderr('Error', 'Доступ запрещен!');   
      
    $sure = (int)$_GET["sure"];

    if (!$sure)
    {
	begin_frame(".:: Удалить Тему ::.");
      stderr("Удалить Тему", "Вы уверены что хотите удалить Тему ?\n" .
      "Нажмите <a href=?action=deletetopic&topicid=$topicid&sure=1>да</a> если уверены .",false);
    end_frame();
	}
	
    @mysql_query("DELETE FROM groups_topics WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

    @mysql_query("DELETE FROM groups_posts WHERE topicid=$topicid") or sqlerr(__FILE__, __LINE__);

    header("Location: $BASEURL/group.php?action=viewforum&forumid=$forumid");
    die;
}

//-------- Action: Edit post
elseif ($action == "editpost")
{
    $postid = (int)$_GET["postid"];

    $res = mysql_query("SELECT * FROM groups_posts WHERE id=$postid") or sqlerr(__FILE__, __LINE__);
	if (mysql_num_rows($res) != 1) stderr("Error", "Сообщение не найдено!");
	$arr = mysql_fetch_assoc($res);

    $res2 = mysql_query("SELECT locked, forumid FROM groups_topics WHERE id = " . $arr["topicid"]) or sqlerr(__FILE__, __LINE__);
	$arr2 = mysql_fetch_assoc($res2);
 	if (mysql_num_rows($res) != 1) stderr("Error", "Не найдено темы для этого сообщения!");

    $locked = ($arr2["locked"] == 'yes'); 
    
    $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($arr2['forumid'])) or sqlerr(__FILE__, __LINE__);
    list($usr_access) = mysql_fetch_array($res);
    
    if (get_user_class() < UC_ADMINISTRATOR and $usr_access < $classes['moder'] and ($CURUSER["id"] != $arr["userid"] || $locked)) stderr('Error', 'Доступ запрещен!');
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
    	$body = $_POST['body'];

    	if ($body == "")
    	  stderr("Error", "Сообщение не может быть пустым!");

      $body = sqlesc($body);

      @mysql_query("UPDATE LOW_PRIORITY groups_posts SET body=$body, editedat=NOW(), editedby=$CURUSER[id] WHERE id=$postid") or sqlerr(__FILE__, __LINE__);

		$returnto = $_POST["returnto"];

			if ($returnto != "")
			{
				$returnto .= "&page=p$postid#$postid";
				header("Location: $returnto");
			}
			else
			begin_frame();
				stderr("Готово", "Сообщение успешно изменено.");
			end_frame();
	}

    stdhead("Редактирование");
	begin_frame(".:: Редактирование ::.");
	begin_table();
?>
 <form name=edit id=edit method=post action="?action=editpost&postid=<?=$postid?>"><tr><td id="no_border">
   <center>
  <input type=hidden name=returnto value="<?=htmlspecialchars($HTTP_SERVER_VARS["HTTP_REFERER"])?>">
 <?      
   textbbcode("edit","body",htmlspecialchars(unesc($arr["body"])));
   ?>          
<input type="button" value="Предпросмотр" onClick="javascript:ajaxpreview('area');" ><input type=submit class=gobutton value="Сохранить">
<script src="js/preview.js"></script>

<div id="loading-layer" style="display:none;font-family: Verdana;font-size: 11px;width:200px;height:50px;background:#FFF;padding:10px;text-align:center;border:1px solid #000">
     <div style="font-weight:bold;" id="loading-layer-text">Загрузка. Пожалуйста, подождите...</div><br>
     <img src="pic/loading.gif" border="0" />
</div>
<br><br>
<div id="preview" style="width:530px;"></div></center>   

   
   </td></tr></form>
<?	end_table();
    end_frame();
    stdfoot();
  	die;
}

//-------- Action: Delete post
elseif ($action == "deletepost")
{
    $postid = (int)$_GET["postid"];
    $sure = (int)$_GET["sure"];
    if (!is_valid_id($postid)) die;

    //------- Get topic id
    $res = mysql_query("SELECT topicid FROM groups_posts WHERE id=$postid") or sqlerr(__FILE__, __LINE__);

    $arr = mysql_fetch_row($res) or stderr("Error", "Post not found");

    $topicid = $arr[0];
    
    $res = mysql_query("SELECT forumid FROM groups_topics WHERE id =".$topicid) or sqlerr(__FILE__, __LINE__);
    list($gid) = mysql_fetch_array($res);
    if ($gid == false) stderr('Error', 'Топик не найден!');

    $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($gid)) or sqlerr(__FILE__, __LINE__);
    list($usr_access) = mysql_fetch_array($res);
    
    if (get_user_class() < UC_ADMINISTRATOR and $usr_access < $classes['moder']) stderr('Error', 'Доступ запрещен!');

    //------- We can not delete the post if it is the only one of the topic
    $res = mysql_query("SELECT COUNT(*) FROM groups_posts WHERE topicid=$topicid") or sqlerr(__FILE__, __LINE__);

    $arr = mysql_fetch_row($res);

    if ($arr[0] < 2){
	stderr("Error", "Can't delete post; it is the only post of the topic. You should\n" .
    "<a href=?action=deletetopic&topicid=$topicid&sure=1>delete the topic</a> instead.\n",false);
	  }

    //------- Get the id of the last post before the one we're deleting
    $res = mysql_query("SELECT id FROM groups_posts WHERE topicid=$topicid AND id < $postid ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
	if (mysql_num_rows($res) == 0)
			$redirtopost = "";
	else
	{
			$arr = mysql_fetch_row($res);
			$redirtopost = "&page=p$arr[0]#$arr[0]";
	}

    //------- Make sure we know what we do :-)
    if (!$sure)
    {
      stderr("Удалить сообщение ?", "Вы действительно хотите удалить сообщение ?\n" .
      "Нажмите <a href=?action=deletepost&postid=$postid&sure=1>да</a> если уверены .",false);
    }

    //------- Delete post
    @mysql_query("DELETE FROM groups_posts WHERE id=$postid") or sqlerr(__FILE__, __LINE__);
    
     //------- Delete attachments
    
    //------- Update topic
    update_topic_last_post($topicid);
   
    header("Location: $BASEURL/group.php?action=viewtopic&topicid=$topicid$redirtopost");
    die;
  }

//-------- Action: Lock topic
elseif ($action == "locktopic")
{
    $forumid = (int)$_GET["forumid"];
    $topicid = (int)$_GET["topicid"];
    $page = (int)$_GET["page"];

    $res = mysql_query("SELECT forumid FROM groups_topics WHERE id =".$topicid) or sqlerr(__FILE__, __LINE__);
    list($gid) = mysql_fetch_array($res);
    if ($gid == false) stderr('Error', 'Топик не найден!');

    $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($gid)) or sqlerr(__FILE__, __LINE__);
    list($usr_access) = mysql_fetch_array($res);
    
    if (get_user_class() < UC_ADMINISTRATOR and $usr_access < $classes['moder']) stderr('Error', 'Доступ запрещен!');
    
    mysql_query("UPDATE LOW_PRIORITY groups_topics SET locked='yes' WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

    header("Location: $BASEURL/group.php?action=viewforum&forumid=$forumid&page=$page");
    die;
}

//-------- Action: Unlock topic
elseif ($action == "unlocktopic")
{
    $forumid = (int)$_GET["forumid"];
    $topicid = (int)$_GET["topicid"];
    $page = (int)$_GET["page"];
      
    $res = mysql_query("SELECT forumid FROM groups_topics WHERE id =".$topicid) or sqlerr(__FILE__, __LINE__);
    list($gid) = mysql_fetch_array($res);
    if ($gid == false) stderr('Error', 'Топик не найден!');

    $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($gid)) or sqlerr(__FILE__, __LINE__);
    list($usr_access) = mysql_fetch_array($res);
    
    if (get_user_class() < UC_ADMINISTRATOR and $usr_access < $classes['moder']) stderr('Error', 'Доступ запрещен!');

    @mysql_query("UPDATE LOW_PRIORITY groups_topics SET locked='no' WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

    header("Location: $BASEURL/group.php?action=viewforum&forumid=$forumid&page=$page");
    die;
}

//-------- Action: Set locked on/off
elseif ($action == "setlocked")
{
    $topicid = (int)$_POST["topicid"];

    $res = mysql_query("SELECT forumid FROM groups_topics WHERE id =".$topicid) or sqlerr(__FILE__, __LINE__);
    list($gid) = mysql_fetch_array($res);
    if ($gid == false) stderr('Error', 'Топик не найден!');

    $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($gid)) or sqlerr(__FILE__, __LINE__);
    list($usr_access) = mysql_fetch_array($res);
    
    if (get_user_class() < UC_ADMINISTRATOR and $usr_access < $classes['moder']) stderr('Error', 'Доступ запрещен!');
    
	$locked = sqlesc($_POST["locked"]);
    @mysql_query("UPDATE LOW_PRIORITY groups_topics SET locked=$locked WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

    header("Location: $_POST[returnto]");
    die;
}

//-------- Action: Set sticky on/off
elseif ($action == "setsticky")
{
    $topicid = (int)$_POST["topicid"];    
    
    $res = mysql_query("SELECT forumid FROM groups_topics WHERE id =".$topicid) or sqlerr(__FILE__, __LINE__);
    list($gid) = mysql_fetch_array($res);
    if ($gid == false) stderr('Error', 'Топик не найден!');

    $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($gid)) or sqlerr(__FILE__, __LINE__);
    list($usr_access) = mysql_fetch_array($res);
    
    if (get_user_class() < UC_ADMINISTRATOR and $usr_access < $classes['moder']) stderr('Error', 'Доступ запрещен!');

	$sticky = sqlesc($_POST["sticky"]);
    @mysql_query("UPDATE LOW_PRIORITY groups_topics SET sticky=$sticky WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

    header("Location: $_POST[returnto]");
    die;
}

//-------- Action: Rename topic

elseif ($action == 'renametopic')
{
  	$topicid = (int)$_POST['topicid'];
  	$subject = (string)$_POST['subject'];

    $res = mysql_query("SELECT forumid FROM groups_topics WHERE id =".$topicid) or sqlerr(__FILE__, __LINE__);
    list($gid) = mysql_fetch_array($res);
    if ($gid == false) stderr('Error', 'Топик не найден!');

    $res = mysql_query("SELECT access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($gid)) or sqlerr(__FILE__, __LINE__);
    list($usr_access) = mysql_fetch_array($res);
    
    if (get_user_class() < UC_ADMINISTRATOR and $usr_access < $classes['moder']) stderr('Error', 'Доступ запрещен!');
    
  	if ($subject == '') stderr('Error', 'Введите название!');
  	$subject = sqlesc($subject);

  	@mysql_query("UPDATE LOW_PRIORITY groups_topics SET subject=$subject WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

  	$returnto = (string)$_POST['returnto'];

  	if ($returnto) header("Location: $returnto");
  	die;
}

//-------- Action: View forum
elseif ($action == "viewforum")
{

	$forumid = (int)$_GET['forumid'];
	if (!is_valid_id($forumid))
		stderr('Error', 'Invalid ID!');
	
	$page = (isset($_GET["page"]) ? (int)$_GET["page"] : 0);
	$userid = (int)$CURUSER["id"];
	
	//------ Get forum details
	$res = mysql_query("SELECT f.name AS forum_name, f.long_description, f.privat, f.close, f.poster, f.users, (SELECT COUNT(id) FROM groups_topics WHERE forumid = f.id) AS t_count ".
					   "FROM groups AS f ".
					   "WHERE f.id = ".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
	$arr = mysql_fetch_assoc($res) or stderr('Error', 'Группа не найдена!');
	
	$perpage = $groups_themeperpage;
	$num = (int)$arr['t_count'];
	
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
			$menu2 .= "<a href=".$_SERVER['PHP_SELF']."?action=viewforum&forumid=$forumid&page=$i><b>$i</b></a>\n";
	
			$lastspace = false;
		}
	
		if ($i < $pages)
			$menu2 .= "</b>|<b>";
	}    
	
	$menu1 .= ($page == 1 ? "<img src='pic/prev.gif' border='0px'/>" : "<a href=".$_SERVER['PHP_SELF']."?action=viewforum&forumid=$forumid&page=" . ($page - 1) . "><img src='pic/prev.gif' border='0px'/></a>");
	$mlb = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$menu3 = ($last == $num ? "<img src='pic/next.gif' border='0px'/></p>" : "<a href=".$_SERVER['PHP_SELF']."?action=viewforum&forumid=$forumid&page=" . ($page + 1) . "><img src='pic/next.gif' border='0px'/></a></p>");
	
	$offset = $first - 1;
	
    $res = mysql_query("SELECT access FROM groups_users WHERE gid=".sqlesc($forumid)." AND uid =".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    list($access) = mysql_fetch_array($res);
    
    if (!$access and get_user_class() < UC_MODERATOR and $arr['close'] == 1 and $arr['privat'] == 1) stderr("Error", "Эта группа закрытая. Что бы получить доступ вы должны вступить в группу. Вступление возможно только по приглашению.");
    elseif (!$access and get_user_class() < UC_MODERATOR) stderr("Error", "Эта группа приватная. Что бы получить доступ вы должны <a href=\"groupmanage.php?action=jointogroup&id=".$forumid."\"><b>Вступить в группу</b></a>.");
    
    $battons = array();
    if ($access == 0) $battons[] = "<a href=\"groupmanage.php?action=jointogroup&id=".$forumid."\">Вступить в группу</a>";
    if (get_user_class() >= UC_ADMINISTRATOR or $access) $battons[] = "<a href=\"groupmanage.php?action=givebonus&id=".$forumid."\">Передать бонусы группе</a>";
    if (get_user_class() >= UC_ADMINISTRATOR or $access) $battons[] = "<a href=\"groupmanage.php?action=users&id=".$forumid."\">Участники группы ($arr[users])</a>";
    if ($access >= $classes['admin'] or get_user_class() >= UC_ADMINISTRATOR) {
            $res = mysql_query("SELECT COUNT(*) FROM groups_invites WHERE gid=".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
            list($invites) = mysql_fetch_array($res);
            $battons[] = "<a href=\"groupmanage.php?action=list_invites&id=".$forumid."\">Заявки на вступление ($invites)</a>";
            $battons[] = "<a href=\"groupmanage.php?action=give_invite&id=".$forumid."\">Выдать приглашение</a>";
    }
    if ($access >= $classes['admin'] or get_user_class() >= UC_ADMINISTRATOR) $battons[] = "<a href=\"groupmanage.php?action=editforum&id=".$forumid."\">Редактировать</a>";
    if ($access >= $classes['creator'] or get_user_class() >= UC_ADMINISTRATOR) $battons[] = "<a href=\"javascript:confirm_delete('".$forumid."');\"><font color=red>Удалить группу</font></a>";
    
    if (count($battons) > 1) $btn_str = implode('&nbsp;|&nbsp;',$battons);
    else $btn_str = $battons[0];
    
    if ($arr['poster']) $poster = '<img src="'.htmlspecialchars($arr['poster']).'"><br><br>';
        
	$groups_topics_res = mysql_query(
	"SELECT t.id, t.userid,t.views, t.locked, t.lastpost AS tlast, t.sticky, t.subject, u1.username, u1.class, r.lastpostread, p.id AS p_id, p.userid AS p_userid, p.added AS p_added, 
	(SELECT COUNT(id) FROM groups_posts WHERE topicid=t.id) AS p_count,  u2.class AS u2_class , u2.username AS u2_username ".
	"FROM groups_topics AS t ".
	"LEFT JOIN users AS u1 ON u1.id=t.userid ".
	"LEFT JOIN groups_readposts AS r ON r.userid = ".sqlesc($userid)." AND r.topicid = t.id ".
	"LEFT JOIN groups_posts AS p ON p.id = (SELECT MAX(id) FROM groups_posts WHERE topicid = t.id) ".
	"LEFT JOIN users AS u2 ON u2.id = p.userid ".
	"WHERE t.forumid = ".sqlesc($forumid)." 
    ORDER BY t.sticky, p_added DESC 
    LIMIT $offset, $perpage") or sqlerr(__FILE__, __LINE__);
	
	stdhead("Группа - ".htmlspecialchars($arr["forum_name"]));     
	
	?>
<script language="JavaScript">
<!--
function confirm_delete(id)
{
   if(confirm('Вы уверены что хотите удалить группу?'))
   {
      self.location.href='groupmanage.php?action=del&id='+id;
   }
}
//-->
</script>
	<!--<h1><a href="<-?php echo $_SERVER['PHP_SELF']; ?>">Группы</a> - <-?php echo htmlspecialchars($arr["forum_name"]); ?></h1>-->
<?php
	begin_frame("<a href=". $_SERVER['PHP_SELF'].">Группа</a> - ". htmlspecialchars($arr["forum_name"]));
    echo $poster.format_comment($arr['long_description']);
    echo '<br><br><b>'.$btn_str.'</b>';
    end_frame();
	begin_frame(".:: Форум группы  - ". htmlspecialchars($arr["forum_name"]). " ::.");
	if (mysql_num_rows($groups_topics_res) > 0)
	{
		?><table border="0px" cellspacing=0 cellpadding=5 width=<?php echo $forum_width; ?>>
		<tr>
			<td class=zaliwka><center>Тема</center></td>
			<td class=zaliwka><center>Ответов</center></td>
			<td class=zaliwka><center>Просмотров</center></td>
			<td class=zaliwka><center>Автор</center></td>
			<td class=zaliwka><center><nobr>Последние сообщение</nobr></center></td>
		</tr>
		<?php
		while ($topic_arr = mysql_fetch_assoc($groups_topics_res))
		{
			$topicid = (int)$topic_arr['id'];
			$topic_userid = (int)$topic_arr['userid'];
			$sticky = ($topic_arr['sticky'] == "yes");
			$lpost = (int)$topic_arr["tlast"];
			
			$tpages = floor($topic_arr['p_count'] / $groups_postsperpage);
			
			if (($tpages * $groups_postsperpage) != $topic_arr['p_count'])
				++$tpages;
			
			if ($tpages > 1)
			{
				$topicpages = "&nbsp;(<img src='pic/multipage.gif' alt='Много страничная тема' title='Много страничная тема'>";
				$split = ($tpages > 10) ? true : false;
				$flag = false;
				
				for ($i = 1; $i <= $tpages; ++$i)
				{
					if ($split && ($i > 4 && $i < ($tpages - 3)))
					{
						if (!$flag)
						{
							$topicpages .= '&nbsp;...';
							$flag = true;
						}
						continue;
					}
					$topicpages .= "&nbsp;<a href=".$_SERVER['PHP_SELF']."?action=viewtopic&topicid=$topicid&page=$i>$i</a>";
				}
				$topicpages .= ")";
			}
			else
				$topicpages = '';
			$lpusername = (is_valid_id($topic_arr['p_userid']) && !empty($topic_arr['u2_username']) ? "<a href='userdetails.php?id=".(int)$topic_arr['p_userid']."'>".get_user_class_color($topic_arr['u2_class'],$topic_arr['u2_username'])."</b></a>" : "unknown[$topic_userid]");
			$lpauthor = (is_valid_id($topic_arr['userid']) && !empty($topic_arr['username']) ? "<a href='userdetails.php?id=$topic_userid'>".get_user_class_color($topic_arr['class'],$topic_arr['username'])."</b></a>" : "unknown[$topic_userid]");
			$new = ($topic_arr["p_added"] > (get_date_time() - $READPOST_EXPIRY)) ? ((int)$topic_arr['p_id'] > $topic_arr['lastpostread']) : 0;
			$topicpic = ($topic_arr['locked'] == "yes" ? ($new ? "lockednew" : "locked") : ($new ? "unlockednew" : "unlocked"));
			
			?>
			<tr>
				<td align=left width="100%">
					<table border=0 cellspacing=0 cellpadding=0>
						<tr>
							<td class=embedded style='padding-right: 5px'><img src='pic/<?=$topicpic; ?>.gif'></td>
							<td class=embedded align=left width="100%"><?php echo ($sticky ? '<img src=pic/sticky.gif border=0px />&nbsp;' : ''); ?><a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=viewtopic&topicid=<?php echo $topicid; ?>' title="<?php echo htmlspecialchars($topic_arr['subject']); ?>"><?php echo htmlspecialchars($topic_arr['subject']); ?></a><?php echo $topicpages; ?></td>

						</tr>
					</table>
				</td>
				<td align="center"><?php echo max(0, $topic_arr['p_count'] - 1); ?></td>
				<td align="center"><?php echo number_format($topic_arr['views']); ?></td>
				<td align="center"><?php echo $lpauthor; ?></td>
				<td align='left'>&nbsp;<?php echo $lpusername; ?>&nbsp;<a href="group.php?action=viewtopic&topicid=<?=$topicid;?>&amp;page=p<?=$lpost;?>#<?=$lpost;?>"><img src='pic/new.gif' border='0px' alt='Читать сообщение'></a><br>&nbsp;<?php echo $topic_arr["p_added"]; ?></td>
			</tr>
			<?php
		}
		
		end_table();
	}
	else
	{
		?><p align=center>No groups_topics found</p><?php
	}
	
	echo $menu1.$mlb.$menu2.$mlb.$menu3;
	?>
	<table class=main border=0 cellspacing=0 cellpadding=0 align=center>
	<tr valing=center>
		<td class=embedded><img src='pic/unlockednew.gif' style='margin-right: 5px'></td>
		<td class=embedded>Новое сообщение</td>
		<td class=embedded><img src='pic/locked.gif' style='margin-left: 10px; margin-right: 5px'></td>
		<td class=embedded>Тема закрыта</td>
	</tr>
	</table>
	<?php
	$arr = ($forumid) or die();
	
	$maypost = ($CURUSER);
	
	if (!$maypost)
	{
		?><p><i>У Вас нету прав открывать новые Темы.</i></p><?php
	}
	
	?>
	<table border=0 class=main cellspacing=0 cellpadding=0 align=center>
	<tr>
	<?php
	if ($maypost)
	{
		?>
		<td class=embedded><form method=get action='<?php echo $_SERVER['PHP_SELF']; ?>'>
		<input type=hidden name=action value=newtopic>
		<input type=hidden name=forumid value=<?php echo $forumid; ?>>
		<input type=submit value='Новая Тема' class=gobutton style='margin-left: 10px'></form><br></td>
		<?php
	}
	
	?></tr></table><?php    
    end_frame();
	begin_frame(".:: Навигация по Группам ::.");
	forum_menu_bottom();
	end_frame(); 	
	last_group_users($forumid);	
    stdfoot();
	exit();
}


elseif ($action == "getdaily") {

	stdhead("Сообщения за последние 24 ч.");
	begin_frame(".:: Сообщения за последние 24 ч. ::.");
	$page = 0 + (int)$_GET["page"];
	$perpage = 10;
	$r = mysql_query("SELECT COUNT(*) FROM groups_posts WHERE  groups_posts.added >= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY)") or sqlerr(__FILE__,__LINE__);
	$r1 = mysql_fetch_array($r); 
	$countrows = $r1[0];
	list($pagertop, $pagerbottom, $limit) = pager2($perpage, $countrows, "group.php?action=getdaily&");
	print("<table width=100% border=0 cellspacing=0 cellpadding=5>	
		<tr><td>$pagertop</td></tr>
	<tr><td class=zaliwka align=left>Тема</td>
	<td class=zaliwka align=center>Просмотров</td>
	<td class=zaliwka align=center>Автор</td>
	<td class=zaliwka align=center>Добавлено</td></tr>");
	$res = mysql_query("SELECT groups_posts.id AS pid, groups_posts.topicid, groups_posts.userid AS userpost, groups_posts.added, groups_topics.id AS tid, groups_topics.subject, groups_topics.forumid, groups_topics.lastpost, groups_topics.views, groups.name, users.username
	FROM groups_posts, groups_topics, groups, users, users AS topicposter
	WHERE groups_posts.topicid = groups_topics.id AND groups_posts.added >= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY) AND groups_topics.forumid = groups.id AND groups_posts.userid = users.id AND groups_topics.userid = topicposter.id
	ORDER BY groups_posts.added DESC $limit") or sqlerr(__FILE__,__LINE__);
	while ($getdaily = mysql_fetch_assoc($res))
	{		
		print("<tr><td><a href=\"group.php?action=viewtopic&topicid={$getdaily["tid"]}&page=p{$getdaily["pid"]}#{$getdaily["pid"]}\">
		<b>".htmlspecialchars($getdaily["subject"])."</b></a>
		<br>в <a href=\"group.php?action=viewforum&forumid={$getdaily["forumid"]}\">{$getdaily["name"]}</a></td>
		<td align=center>{$getdaily["views"]}</td>
		<td align=center><a href=userdetails.php?id={$getdaily["userpost"]}><b>{$getdaily["username"]}</b></a></td>
		<td><center>".$getdaily["added"]."</td></tr>");
	}
	print("<tr><td>$pagerbottom</td></tr></table>");
	forum_menu_bottom();
	end_frame();	
	stdfoot();
	die;
}
    
//-------- Action: Search
elseif ($action == "search") 
{
	stdhead("Поиск по форуму");
	begin_table();
	$error = false;
	$found = '';
	$keywords = (isset($_GET['keywords']) ? trim($_GET['keywords']) : '');
    $where = (int)$_GET['where'];
    $sort = (int)$_GET['sort'];
    
	?><style type="text/css">
<!--
.search{
	width:159px;
	
	margin:5px 0 5px 0;
	text-align:left;
}
.search_title{
	color:#0062AE;
	background-color:#DAF3FB;
	font-size:12px;
	font-weight:bold;
	text-align:left;
	padding:7px 0 0 15px;
}

.search_table {
  border-collapse: collapse;
  border: none;
   
}
-->
</style>
<?
begin_frame(".:: Поиск по группам ::.",70);
?>
<center>
 </div>
<form method="get" action="group.php" id="search_form" style="margin: 0pt; padding: 0pt; font-family: Tahoma,Arial,Helvetica,sans-serif; font-size: 11px;">
<center><input type="hidden" name="action" value="search">
<input name="keywords" type="text" value="<?=$keywords?>" size="65" />
<input type=submit value=Поиск class=gobutton><br>
Где искать&nbsp;&nbsp;&nbsp;<input type="radio" name="where" value="0" <?=($where==0?' checked=checked':'')?>>&nbsp;В названиях групп&nbsp;&nbsp;&nbsp;<input type="radio" name="where" value="1" <?=($where==1?' checked=checked':'')?>>&nbsp;В описании групп&nbsp;&nbsp;&nbsp;<input type="radio" name="where" value="2" <?=($where==2?' checked=checked':'')?>>&nbsp;В сообщениях<br>

Сортировать результат по &nbsp;&nbsp;&nbsp;<input type="radio" name="sort" value="0" <?=($sort==0?' checked=checked':'')?>>&nbsp;Количеству бонусов&nbsp;&nbsp;&nbsp;<input type="radio" name="sort" value="1" <?=($sort==1?' checked=checked':'')?>>&nbsp;Количеству участников&nbsp;&nbsp;&nbsp;<input type="radio" name="sort" value="2" <?=($sort==2?' checked=checked':'')?>>&nbsp;Дате основания группы
</center>
</form>
<?
	
	$error = false;
	$found = '';
	$keywords = (isset($_GET['keywords']) ? trim($_GET['keywords']) : '');
	if ($sort == 2) $order = 'id';
    elseif ($sort == 1) $order = 'users';
    else $order = 'bonus';
    
    if (!empty($keywords))
	{
		if ($where == 2) {
            $res = mysql_query("SELECT COUNT(id) AS c FROM groups_posts WHERE body LIKE ".sqlesc("%".sqlwildcardesc($keywords)."%")) or sqlerr(__FILE__, __LINE__);
		    $arr = mysql_fetch_assoc($res);
		    $count = (int)$arr['c'];
		    $keywords = htmlspecialchars($keywords);
		
		    if ($count == 0)
			    $error = true;
		    else
		    {
			    list($pagertop, $pagerbottom, $limit) = pager2(20, $count, $_SERVER['PHP_SELF'].'?action='.$action.'&keywords='.$keywords.'&where='.$where.'&sort='.$sort.'&');
			
			    $res = mysql_query(
			    "SELECT p.id, p.topicid, p.userid, p.added, t.forumid, t.subject, f.name, u.username ".
			    "FROM groups_posts AS p ".
			    "LEFT JOIN groups_topics AS t ON t.id=p.topicid ".
			    "LEFT JOIN groups AS f ON f.id=t.forumid ".
			    "LEFT JOIN users AS u ON u.id=p.userid ".
			    "WHERE p.body LIKE ".sqlesc("%".$keywords."%")." $limit");
	
			    $num = mysql_num_rows($res);
			    echo "<p>$pagertop</p>";
			   
			
			    ?>
                <table border=0 cellspacing=0 cellpadding=5 width='100%'>
			    <tr align="left">
            	    <td class=zaliwka>Сообщение</td>
                    <td class=zaliwka>Тема</td>
                    <td class=zaliwka>Группа</td>
                    <td class=zaliwka>Автор</td>
			    </tr>
                <?php
			    for ($i = 0; $i < $num; ++$i)
			    {
				    $post = mysql_fetch_assoc($res);
	
				    echo "<tr>".
					 	"<td align='center'>".$post['id']."</td>".
						"<td align=left width='100%'><a href=".$_SERVER['PHP_SELF']."?action=viewtopic&highlight=$keywords&topicid=".$post['topicid']."&page=p".$post['id']."#".$post['id']."><b>" . htmlspecialchars($post['subject']) . "</b></a></td>".
						"<td align=left><nobr>".(empty($post['name']) ? 'unknown['.$post['forumid'].']' : "<a href=".$_SERVER['PHP_SELF']."?action=viewforum&forumid=".$post['forumid']."><b>" . htmlspecialchars($post['name']) . "</b></a>")."</nobr></td>".
						"<td align=left><nobr>".(empty($post['username']) ? 'unknown['.$post['userid'].']' : "<b><a href='userdetails.php?id=".$post['userid']."'>".$post['username']."</a></b>")."<br>&nbsp;".$post['added']."</nobr></td>".
					 "</tr>";
	            }
	            end_table();
			
			    
			    echo "<p>$pagerbottom</p>";
			    $found ="[<b><font color=red> Found $count post" . ($count != 1 ? "s" : "")." </font></b> ]";
			
		    }
        } elseif ($where == 0) {
            $res = mysql_query("SELECT COUNT(id) AS c FROM groups WHERE name LIKE ".sqlesc("%".sqlwildcardesc($keywords)."%")) or sqlerr(__FILE__, __LINE__);
            $arr = mysql_fetch_assoc($res);
            $count = (int)$arr['c'];
            $keywords = htmlspecialchars($keywords);
        
            if ($count == 0)
                $error = true;
            else
            {
                list($pagertop, $pagerbottom, $limit) = pager2(20, $count, $_SERVER['PHP_SELF'].'?action='.$action.'&keywords='.$keywords.'&where='.$where.'&sort='.$sort.'&');
                
                $res = mysql_query(
                "SELECT g.id, g.name, g.description, g.bonus, g.create_by, g.users, u.username, u.class ".
                "FROM groups AS g ".
                "LEFT JOIN users AS u ON g.create_by=u.id ".
                "WHERE g.name LIKE ".sqlesc("%".$keywords."%")." ORDER BY g.$order DESC $limit");
$num = mysql_num_rows($res);echo "<p>$pagertop</p>";?>
<table border=0 cellspacing=0 cellpadding=5 width='100%'><tr align="left"><td align='left' id="no_border" class='zaliwka'>Название</td>
<td class='zaliwka' align='center'><b>Короткое oписание</b></td><td class='zaliwka' align='center'><b>Участников</b></td>
<td class='zaliwka' align='center'><b>Бонусов</b></td><td class='zaliwka' align='center'><b>Создатель</b></td></tr>
<?for($i = 0; $i < $num; ++$i){$post = mysql_fetch_assoc($res);$forumid = (int)$post["id"];?><tr>
<td width="25%"><a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=viewforum&forumid=<?php echo $forumid; ?>'><b><?php echo htmlspecialchars($post["name"]); ?></b></a></td>
<td><?php echo htmlspecialchars($post["description"]); ?></td><td align='center' width="1%"><?php echo number_format($post["users"]); ?></td>
<td align='center' width="1%"><?php echo number_format($post["bonus"]); ?></td>
<td align='center' width="1%"><?php echo get_user_class_color($post["class"],$post['username']); ?></td></tr>
<?}end_table();echo "<p>$pagerbottom</p>";
$found ="[<b><font color=red> Found $count group" . ($count != 1 ? "s" : "")." </font></b> ]";}}else{
$res = mysql_query("SELECT COUNT(id) AS c FROM groups WHERE long_description LIKE ".sqlesc("%".sqlwildcardesc($keywords)."%")) or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res);
$count = (int)$arr['c'];
$keywords = htmlspecialchars($keywords);
if ($count == 0)$error = true;else{
list($pagertop, $pagerbottom, $limit) = pager2(20, $count, $_SERVER['PHP_SELF'].'?action='.$action.'&keywords='.$keywords.'&where='.$where.'&sort='.$sort.'&');
$res = mysql_query("SELECT g.id, g.name, g.description, g.bonus, g.create_by, g.users, u.username, u.class FROM 
groups AS g LEFT JOIN users AS u ON g.create_by=u.id WHERE g.long_description LIKE ".sqlesc("%".$keywords."%")." ORDER BY g.$order DESC $limit");
$num = mysql_num_rows($res);
echo "<p>$pagertop</p>";?>
<table border=0 cellspacing=0 cellpadding=5 width='100%'>
<tr align="left"><td align='left' id="no_border" class='zaliwka'>Название</td>
<td class='zaliwka' align='center'><b>Короткое oписание</b></td><td class='zaliwka' align='center'><b>Участников</b></td>
<td class='zaliwka' align='center'><b>Бонусов</b></td><td class='zaliwka' align='center'><b>Создатель</b></td></tr>
<?php for ($i = 0; $i < $num; ++$i){
$post = mysql_fetch_assoc($res);
$forumid = (int)$post["id"];
?><tr>
<td width="25%"><a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=viewforum&forumid=<?php echo $forumid; ?>'><b><?php echo htmlspecialchars($post["name"]); ?></b></a></td>
<td><?php echo htmlspecialchars($post["description"]); ?></td>
<td align='center' width="1%"><?php echo number_format($post["users"]); ?></td>
<td align='center' width="1%"><?php echo number_format($post["bonus"]); ?></td>
<td align='center' width="1%"><?php echo get_user_class_color($post["class"],$post['username']); ?></td></tr>
<?}end_table();echo "<p>$pagerbottom</p>";
$found ="[<b><font color=red> Found $count group".($count != 1 ? "s" : "")." </font></b> ]";}}}
print ($error ? "[<b><font color=red> Ничего не найдено</font></b> ]" : $found);
forum_menu_bottom();end_frame();stdfoot();exit();}
if (isset($_GET["catchup"])){catch_up();header('Location: '.$_SERVER['PHP_SELF']);exit();}
stdhead("Релиз-Группы");begin_frame(".:: Релиз-Группы ::.");show_groups();echo $main_pager; 
forum_menu_bottom();end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>