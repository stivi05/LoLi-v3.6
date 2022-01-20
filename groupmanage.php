<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
require_once("include/group_func.php");
$classes = get_classes_group();  
$id = 0 + (int)$_GET['id'];
$uid = 0 + (int)$_GET['uid'];

// НАЧАЛО ПРИГЛАШЕНИЙ
// выдача приглашения в групу
if ($_GET['action'] == "give_invite") {
    if (!$id) { header("Location: $BASEURL/group.php"); die();}
    
    $res = mysql_query("SELECT name FROM groups WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) == 0) stderr("Error", "Группа не найдена.");
    list($group_name) = mysql_fetch_array($res);
    $group_name = htmlspecialchars($group_name);
    
    $res = mysql_query("SELECT * FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." AND gid=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) == 0) stderr("Error", "Доступ запрещен.");
    $row = mysql_fetch_array($res);
    if ($row['access'] < $classes['admin'] and get_user_class() < UC_ADMINISTRATOR) stderr("Error", "Доступ запрещен.");
    
    $usr_invited =(int)$_POST['usr_invited'];
    // процесс выдачи приглашения
    if ($usr_invited > 0) {
        $res = mysql_query("SELECT * FROM groups_users WHERE uid=".sqlesc($usr_invited)." AND gid=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        if (mysql_num_rows($res) > 0) stderr("Error", "Пользователь уже является участником группы.");
    
        $res = mysql_query("SELECT COUNT(*) FROM groups_users WHERE uid =".sqlesc($usr_invited)) or sqlerr(__FILE__, __LINE__);
        list($user_groups) = mysql_fetch_array($res);
        if ($user_groups >= $MAX_USR_GROUPS) stderr("Error", "Пользователь не можете быть участником более чем $MAX_USR_GROUPS групп.");
    
        $res = mysql_query("SELECT username, bonus FROM users WHERE id=".sqlesc($usr_invited)) or sqlerr(__FILE__, __LINE__);
        if (mysql_num_rows($res) == 0) stderr("Error", "Приглашаемый пользователь не существует.");
        list($user_name,$user_bonus) = mysql_fetch_array($res);
        
        $res = mysql_query("SELECT id FROM groups_applications WHERE gid=".$id." AND uid=".sqlesc($usr_invited)) or sqlerr(__FILE__, __LINE__);
        if (mysql_num_rows($res) > 0) stderr("Error", "Пользователю уже отправлено приглашение, но он ещё не принял решение про вступление.");
        
        mysql_query("INSERT INTO groups_applications (uid, gid) VALUES($usr_invited, $id)") or sqlerr(__FILE__, __LINE__);
        $insert_id = mysql_insert_id();
        
        $subject = 'Приглашение в группу '.$group_name;
        $msg = "Вас приглашают в группу [url=".$DEFAULTBASEURL.'/group.php?action=viewforum&forumid='.$id.'][b]'.$group_name.'[/b][/url]. Приглашает [b]'.$CURUSER["username"]."[/b]. \n\r\n\r Для принятия приглашения нажмите [url=$DEFAULTBASEURL/groupmanage.php?action=confirm_invite&id=$insert_id][b]сюда[/b][/url], а чтоб отклонить [url=$DEFAULTBASEURL/groupmanage.php?action=reject_invite&id=$insert_id][b]сюда[/b][/url].";
        mysql_query("INSERT INTO messages (sender, receiver, added, msg, subject, saved) VALUES(2,
        $usr_invited, '" . get_date_time() . "', " . sqlesc($msg) . ", " . sqlesc($subject) . ", 'no')") or sqlerr(__FILE__, __LINE__);
        
        stdhead();
        stdmsg("Отправка приглашения", "Приглашение пользователю <a href=\"userdetails.php?id=$usr_invited\"><b>$user_name</b></a> отправлено</a>.");
        stdfoot();
        die();
    }
    
    stdhead("Отправка приглашения пользователю в группу $group_name");
    begin_main_frame();
    begin_frame("Отправка приглашения пользователю в группу <a href=\"group.php?action=viewforum&forumid=$id\"><b>$group_name</b></a>");
    ?>
<form method=post action="">
<table width="100%"  border="0" cellspacing="0" cellpadding="3" align="center">
<tr>
    <td><b>Уникальный идентификатор пользоватея <b>ID</b></td>
    <td><input name="usr_invited" type="text" size="20" maxlength="60" value=""></td>
  </tr>
  <tr align="center">
    <td colspan="2"><input type="hidden" name="id" value="<?=$id;?>"><input type="submit" name="Submit" value="Готово" class="btn"></form>
    <form method="get" action="group.php?action=viewforum&forumid=<?=$id?>"><input type="submit" value="Вернуться" class="btn" /></form></td>
  </tr>

</table>
<?
    end_frame(); 
    end_main_frame();
    stdfoot(); 
    die();
}

// отклонение юзером приглашения в группу
if ($_GET['action'] == "reject_invite") {
    if (!$id) { header("Location: $BASEURL/group.php"); die();}
    mysql_query("DELETE FROM groups_applications WHERE id=$id AND uid=".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    
    if (mysql_affected_rows() > 0) {
        stdhead();
        stdmsg("Отклонение приглашения", "Приглашение отклонено</a>.");
        stdfoot();
    } else header("Location: $BASEURL/group.php");
    die();
}

// принятие юзером приглашения в группу
if ($_GET['action'] == "confirm_invite") {
    if (!$id) { header("Location: $BASEURL/group.php"); die();}
    
    $res = mysql_query("SELECT uid, gid FROM groups_applications WHERE uid=".sqlesc($CURUSER["id"])." AND id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) == 0) stderr("Error", "Приглашение не найдено.");
    list($app_uid, $gid) = mysql_fetch_array($res);
    $res = mysql_query("SELECT name FROM groups WHERE id=".sqlesc($gid)) or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) == 0) stderr("Error", "Группа не найдена.");
    list($group_name) = mysql_fetch_array($res);
    $group_name = htmlspecialchars($group_name);
    $res = mysql_query("SELECT COUNT(*) FROM groups_users WHERE uid =".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    list($user_groups) = mysql_fetch_array($res);
    if ($user_groups >= 5) stderr("Error", "Вы не можете быть участником более чем 5 групп.");
    $res = mysql_query("SELECT bonus FROM users WHERE id =".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    list($user_bonus) = mysql_fetch_array($res);
    $in_groups = 0;
    $usr_in_group = 0;
    $res = mysql_query("SELECT * FROM groups_users WHERE gid =".sqlesc($gid)) or sqlerr(__FILE__, __LINE__);
    while ($row = mysql_fetch_array($res)) {
        $in_groups++;
        if ($row['uid'] == $CURUSER["id"]) $usr_in_group++;
    }
    if ($usr_in_group > 0) stderr("Error", "Вы уже являетесь участником этой группы.");
    if ($in_groups >= $GROUPS_MINUS_BONUS and $user_bonus < $PAY_BONUS) stderr("Error", "В группе больше $GROUPS_MINUS_BONUS участников. Для вступления в группу вы должны отдать $PAY_BONUS бонусов. У вас недостаточно бонусов для вступления в группу.");
    
    mysql_query("INSERT INTO groups_users (uid, gid, access) VALUES(".sqlesc($CURUSER["id"]).", $gid, 1)") or sqlerr(__FILE__, __LINE__);
    mysql_query("UPDATE groups SET bonus=bonus+100 WHERE id=".sqlesc($gid)) or sqlerr(__FILE__, __LINE__);
    if ($in_groups >= $GROUPS_MINUS_BONUS) mysql_query("UPDATE users SET bonus=bonus-$PAY_BONUS WHERE id=".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    mysql_query("DELETE FROM groups_applications WHERE id=$id") or sqlerr(__FILE__, __LINE__);
    
    stdhead();
    stdmsg("Вступление в группу", "Вы вступили в группу <a href=\"group.php?action=viewforum&forumid=$gid\"><b>$group_name</b></a>.");
    stdfoot();
    die();
}
// КОНЕЦ ПРИГЛАШЕНИЙ


// НАЧАЛО ЗАЯВОК НА ВСТУПЛЕНИЕ В ГРУППУ
// отказ на заявку
if ($_GET['action'] == "del_invite") {
    if (!$id or !$uid) { header("Location: $BASEURL/group.php"); die();}

    $res = mysql_query("SELECT name FROM groups WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($group_name) = mysql_fetch_array($res);
    if ($group_name == false) stderr("Error", "Группа не найдена.");
    $group_name = htmlspecialchars($group_name);
    $res = mysql_query("SELECT id, access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." AND gid=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($is_user,$usr_access) = mysql_fetch_array($res);
    if ($usr_access < $classes['admin'] and get_user_class() < UC_ADMINISTRATOR) stderr("Error", "Доступ запрещен.");
    $res = mysql_query("SELECT id FROM groups_invites WHERE uid=".sqlesc($uid)." AND gid=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($invite_id) = mysql_fetch_array($res);
    if ($invite_id == false) stderr("Error", "Заявки не существует.");
    
    mysql_query("DELETE FROM groups_invites WHERE id=".sqlesc($invite_id)) or sqlerr(__FILE__, __LINE__);
    
    $subject = 'Ответ на заявку по вступлению в группу '.$group_name;
    $msg = 'Вы получили отказ.';
    mysql_query("INSERT INTO messages (sender, receiver, added, msg, subject, saved) VALUES(2,
        $uid, '" . get_date_time() . "', " . sqlesc($msg) . ", " . sqlesc($subject) . ", 'no')") or sqlerr(__FILE__, __LINE__);
    
    header("Location: $BASEURL/groupmanage.php?action=list_invites&id=".$id);
    die();
}

// принятие в группу по заявке
if ($_GET['action'] == "take_to_group") {
    if (!$id or !$uid) { header("Location: $BASEURL/group.php"); die();}

    $res = mysql_query("SELECT name FROM groups WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($group_name) = mysql_fetch_array($res);
    if ($group_name == false) stderr("Error", "Группа не найдена.");
    $group_name = htmlspecialchars($group_name);
    $res = mysql_query("SELECT id, access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." AND gid=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($is_user,$usr_access) = mysql_fetch_array($res);
    if ($usr_access < $classes['admin'] and get_user_class() < UC_ADMINISTRATOR) stderr("Error", "Доступ запрещен.");
    $res = mysql_query("SELECT id FROM groups_invites WHERE uid=".sqlesc($uid)." AND gid=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($invite_id) = mysql_fetch_array($res);
    if ($invite_id == false) stderr("Error", "Заявки не существует.");
    $res = mysql_query("SELECT bonus FROM users WHERE id=".sqlesc($uid)) or sqlerr(__FILE__, __LINE__);
    list($usr_bonus) = mysql_fetch_array($res);
    if ($usr_bonus < $PAY_BONUS) stderr("Error", "У пользователя не хватает бонусов. Есть только $usr_bonus, а нужно $PAY_BONUS.");
    
    mysql_query("INSERT INTO groups_users (uid, gid, access) VALUES(".sqlesc($uid).", $id, 1)") or sqlerr(__FILE__, __LINE__);
    mysql_query("UPDATE groups SET bonus=bonus+100 WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    mysql_query("DELETE FROM groups_invites WHERE id=".sqlesc($invite_id)) or sqlerr(__FILE__, __LINE__);
    mysql_query("UPDATE users SET bonus=bonus-$PAY_BONUS WHERE id=".sqlesc($uid)) or sqlerr(__FILE__, __LINE__);
    
    $subject = 'Ответ на заявку по вступлению в группу '.$group_name;
    $msg = 'Вы приняты в группу [url='.$DEFAULTBASEURL.'/group.php?action=viewforum&forumid='.$id.'][b]'.$group_name.'[/b][/url].';
    mysql_query("INSERT INTO messages (sender, receiver, added, msg, subject, saved) VALUES(2,
        $uid, '" . get_date_time() . "', " . sqlesc($msg) . ", " . sqlesc($subject) . ", 'no')") or sqlerr(__FILE__, __LINE__);
    
    header("Location: $BASEURL/groupmanage.php?action=list_invites&id=".$id); 
    die();
}

// присок заявок на вступление в группу
if ($_GET['action'] == "list_invites") {
    if (!$id) { header("Location: $BASEURL/group.php"); die();}
    
    $res = mysql_query("SELECT name FROM groups WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($group_name) = mysql_fetch_array($res);
    if ($group_name == false) stderr("Error", "Группа не найдена.");
    $group_name = htmlspecialchars($group_name);
    $res = mysql_query("SELECT id, access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." AND gid=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($is_user,$usr_access) = mysql_fetch_array($res);
    if ($usr_access < $classes['admin'] and get_user_class() < UC_ADMINISTRATOR) stderr("Error", "Доступ запрещен.");
    
    stdhead("Заявки на вступление в группу $group_name");
    begin_main_frame();
    begin_frame("Заявки на вступление в группу <a href=\"group.php?action=viewforum&forumid=$id\"><b>$group_name</b></a>");
    
    echo '<table width="100%"  border="0" align="center" cellpadding="2" cellspacing="0">';
    $result = mysql_query ("SELECT g.*, u.username, u.class FROM groups_invites AS g LEFT JOIN users AS u ON g.uid=u.id WHERE g.gid=$id ORDER BY u.class DESC");
    if ($row = mysql_fetch_array($result)) {
        echo "<tr><td class=zaliwka align=left>Участник</td><td class=zaliwka>Действия</td></tr>";
        
        do {
            $uid = $row['uid'];
            $edit = "<td align=center nowrap><b>&nbsp;<a href=\"".$PHP_SELF."?action=take_to_group&id=".$row["gid"]."&uid=$uid\">Принять в группу</a>&nbsp;|&nbsp;";
            $edit .= "<a href=\"".$PHP_SELF."?action=del_invite&id=".$row["gid"]."&uid=$uid\">Отказать</a></b></td>";
            echo "<tr><td><a href=\"/userdetails.php?id=".$uid."\">".get_user_class_color($row["class"],$row['username'])."</a></td>$edit</tr>";

        } while($row = mysql_fetch_array($result));
    } else {
        print "<tr><td>Нет заявок!</td></tr>";
    }
    echo "</table>";
    
    end_frame(); 
    end_main_frame();
    stdfoot();
    
    die();
}

// подача заявки на вступление в группу
if ($_GET['action'] == "leave_invite") {
    if (!$id) { header("Location: $BASEURL/group.php"); die();}
    
    $res = mysql_query("SELECT access FROM groups_users WHERE gid=".sqlesc($id)." AND uid=".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    list($cur_usr_access) = mysql_fetch_array($res);
    if ($cur_usr_access) stderr("Error", "Вы уже являетесь участником этой группы.");
    
    $res = mysql_query("SELECT name, invite, close FROM groups WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) == 0) stderr("Error", "Группа не найдена.");
    list($group_name, $invite, $close) = mysql_fetch_array($res);
    $group_name = htmlspecialchars($group_name);
    if ($close == 1) stderr("Error", "Вступление в группу возможно только по приглашению.");
    if ($invite == 0) stderr("Error", "В эту группу можно <a href=\"/groupmanage.php?action=jointogroup&id=$id\"><b>вступить</b></a> без приглашения.");
    
    $res = mysql_query("SELECT id FROM groups_invites WHERE uid=".sqlesc($CURUSER["id"])." AND gid=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($invite_id) = mysql_fetch_array($res);
    if ($invite_id) stderr("Error", "Вы уже подали заявку на вступление. Ждите решение администрации.");
    
    mysql_query("INSERT INTO groups_invites (uid, gid) VALUES(".sqlesc($CURUSER["id"]).", $id)") or sqlerr(__FILE__, __LINE__);
    
    stdhead();
    stdmsg("Заявка на вступление в группу", "Вы подали заявку на вступление в группу <b>$group_name</b>. Ждите решение администратора группы. О нем вы будете оповещены ЛС");
    stdfoot();
    die;
}
// КОНЕЦ ЗАЯВОК НА ВСТУПЛЕНИЕ В ГРУППУ  


// изменение статуса участника группы
if ($_GET['action'] == "status_user") {
    if (!$id or !$uid) { header("Location: $BASEURL/group.php"); die();}
    
    $res = mysql_query("SELECT access FROM groups_users WHERE gid=".sqlesc($id)." AND uid=".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    list($cur_usr_access) = mysql_fetch_array($res);
    $res = mysql_query("SELECT username FROM users WHERE id=".sqlesc($uid)) or sqlerr(__FILE__, __LINE__);
    list($username) = mysql_fetch_array($res);
    $res = mysql_query("SELECT access FROM groups_users WHERE gid=".sqlesc($id)." AND uid=".$uid) or sqlerr(__FILE__, __LINE__);
    list($edit_usr_access) = mysql_fetch_array($res);
    $res = mysql_query("SELECT name, bonus FROM groups WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($group_name, $group_bonus) = mysql_fetch_array($res);
    $group_name = htmlspecialchars($group_name);
    if ($group_name == false) stderr("Error", "Группа не существует.");
    if ($edit_usr_access == false) stderr("Error", "Участник не найден.");
    if ($cur_usr_access < $classes['creator'] and $edit_usr_access >= $classes['admin']) stderr("Error", "Доступ запрещен.");
    if (get_user_class() < UC_ADMINISTRATOR and $cur_usr_access < $classes['admin']) stderr("Error", "Доступ запрещен.");
    
    // процесс изменения статуса
    $status = (int)$_POST['status'];
    if ($status >= $classes['user'] and $status <= $classes['admin']) {
        if ($cur_usr_access < $classes['creator'] and $status >= $classes['admin']) stderr("Error", "Доступ запрещен.");
        
        if ($status == $classes['admin']) {
            $minus_bonus = 300;
            $res = mysql_query("SELECT COUNT(*) FROM groups_users WHERE gid=".sqlesc($id)." AND access=".sqlesc($classes['admin'])) or sqlerr(__FILE__, __LINE__);
            list($users) = mysql_fetch_array($res);
            if ($users >= 2) stderr("Error", "В группе не может быть больше 2 администраторов.");
        } elseif ($status == $classes['moder']) {
            $minus_bonus = 300;
            $res = mysql_query("SELECT COUNT(*) FROM groups_users WHERE gid=".sqlesc($id)." AND access=".sqlesc($classes['moder'])) or sqlerr(__FILE__, __LINE__);
            list($users) = mysql_fetch_array($res);
            if ($users >= 5) stderr("Error", "В группе не может быть больше 5 модераторов.");
        } elseif ($status == $classes['vip']) {
            $minus_bonus = 200;

        } else $minus_bonus = 0;
        
        if ($group_bonus < $minus_bonus) stderr("Error", "Недостаточно бонусов. Необходимо $minus_bonus, а у группы только $group_bonus.");
        
        mysql_query("UPDATE groups_users SET access=$status WHERE gid=".sqlesc($id)." AND uid=".sqlesc($uid)) or sqlerr(__FILE__, __LINE__);
        mysql_query("UPDATE groups SET bonus=bonus-$minus_bonus WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        
        header("Location: $BASEURL/groupmanage.php?action=users&id=".$id); 
        die();
    }
    
    stdhead("Изменить статус участнику группы $group_name - $username");
    begin_main_frame();
    begin_frame("Изменить статус участнику группы $group_name - $username");
    ?>
<form method=post action="">
<table width="100%"  border="0" cellspacing="0" cellpadding="3" align="center">
<tr>
    <td><b>Выберите статус</td>
    <td>
    <select name="status">
    <? 
    foreach ($classes as $class) {
        if ($classes['creator'] == $class) continue;
        if ($cur_usr_access < $classes['creator'] and $class >= $classes['admin']) continue;
        
        print "<option value=".$class."".($class==$edit_usr_access?" selected":"").">".get_user_class_group($class)."</option>";
    } 
    ?>
    </select>
    </td>
  </tr>
  <tr align="center">
    <td colspan="2"><input type="hidden" name="action" value="editforum">
    <input type="hidden" name="id" value="<?=$id;?>"><input type="submit" name="Submit" value="Готово" class="btn"></form>
    </td>
  </tr>

</table>
<?
    end_frame(); 
    end_main_frame();
    stdfoot();
    die();
}    
    
// удаление юзера из группы
if ($_GET['action'] == "del_user") {
    if (!$id or !$uid) { header("Location: $BASEURL/group.php"); die();}
    
    $res = mysql_query("SELECT access FROM groups_users WHERE gid=".sqlesc($id)." AND uid=".$uid) or sqlerr(__FILE__, __LINE__);
    list($del_usr_access) = mysql_fetch_array($res);
    $res = mysql_query("SELECT access FROM groups_users WHERE gid=".sqlesc($id)." AND uid=".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    list($cur_usr_access) = mysql_fetch_array($res);
    
    if ($del_usr_access == false) stderr("Error", "Участник не найден.");
    if (get_user_class() < UC_ADMINISTRATOR and $cur_usr_access < $classes['admin']) stderr("Error", "Доступ запрещен.");
    if ($del_usr_access >= $classes['admin'] and $cur_usr_access < $classes['creator']) stderr("Error", "Доступ запрещен.");
    
    mysql_query("DELETE FROM groups_users WHERE gid=".sqlesc($id)." AND uid=".$uid) or sqlerr(__FILE__, __LINE__);
   
    header("Location: $BASEURL/groupmanage.php?action=users&id=".$id); 
    die();
}

// список групп в которых участвует юзер
if ($_GET['action'] == "user_groups") {
    
    if (get_user_class() < UC_ADMINISTRATOR or !$uid) $uid = $CURUSER["id"];
    
    if (!$uid) { header("Location: $BASEURL/group.php"); die();}
    
    $res = mysql_query("SELECT username FROM users WHERE id=".sqlesc($uid)) or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) == 0) stderr("Error", "Пользователь не существует.");
    list($username) = mysql_fetch_array($res);
    
    $res = mysql_query("SELECT gu.*, g.*, u.username, u.class FROM groups_users AS gu LEFT JOIN groups AS g ON gu.gid=g.id LEFT JOIN users AS u ON g.create_by=u.id WHERE gu.uid=".$uid." ORDER BY gu.id DESC") or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) == 0) stderr("Error", "Пользователь не является участником групп.");
    
    stdhead("Группы в которых участвует - $username");
    begin_main_frame();
    begin_frame("Группы в которых участвует - $username");
    
    ?>
    <table border=0 cellspacing=0 cellpadding=5 width='100%'><?php

    while ($row = mysql_fetch_array($res)) {
        $forumid = (int)$row["gid"];
        $poster = $row["poster"] ? '<img width="150" src="'.htmlspecialchars($row["poster"]).'">' : '';
        $description = $groups_arr["description"] ? 'Описание: '.htmlspecialchars($groups_arr["description"]) : ''; 
        ?>
        
        <tr valign="top">
            <td width="1%"><?php echo $poster; ?></td>
            <td>Название: <a href='/group.php?action=viewforum&forumid=<?php echo $forumid; ?>'><b><?php echo htmlspecialchars($row["name"]); ?></b></a><br>
            Создатель: <a href="/userdetails.php?id=<?=$row["create_by"]?>"><?php echo get_user_class_color($row["class"],$row['username']) ?></a><br>
            Участников: <?php echo number_format($row["users"]); ?><br>
            Бонусов: <?php echo number_format($row["bonus"]); ?><br>
            <?php echo $description; ?></td>
            <!--
            <td width="1%" nowrap>
            <?=$urls?>
            </td>
            -->
        </tr>    
        <?
        
        
    }
    print("</table>");

    end_frame(); 
    end_main_frame();
    stdfoot();
    die();
}
// список участников группы
if ($_GET['action'] == "users") {
    if (!$id) { header("Location: $BASEURL/group.php"); die();}
    
    $res = mysql_query("SELECT name FROM groups WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($group_name) = mysql_fetch_array($res);
    if ($group_name == false) stderr("Error", "Группа не найдена.");
    $group_name = htmlspecialchars($group_name);
    $res = mysql_query("SELECT id, access FROM groups_users WHERE uid=".sqlesc($CURUSER["id"])." and gid=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($is_user,$usr_access) = mysql_fetch_array($res);
    if ($is_user == 0 and get_user_class() < UC_MODERATOR) stderr("Error", "Вы не являетесь участником этой групы.");
    
    stdhead("Участники группы $group_name");
    begin_main_frame();
    begin_frame("Участники группы <a href=\"group.php?action=viewforum&forumid=$id\"><b>$group_name</b></a>");
    
    echo '<table width="100%"  border="0" align="center" cellpadding="2" cellspacing="0">';
    $result = mysql_query ("SELECT g.*, u.username, u.class FROM groups_users AS g LEFT JOIN users AS u ON g.uid=u.id WHERE g.gid=$id ORDER BY u.class DESC");
    if ($row = mysql_fetch_array($result)) {
        echo "<tr><td class=zaliwka align=left>Участник</td><td class=zaliwka>Статус в группе</td>".((get_user_class() >= UC_ADMINISTRATOR or $usr_access >= $classes['admin']) ?"<td class=zaliwka>Действия</td>":"")."</tr>";
        
        do {
            $uid = $row['uid'];

            if (get_user_class() >= UC_ADMINISTRATOR or $is_user && $usr_access >= $classes['admin']) $edit = "<td align=center nowrap><b>&nbsp;<a href=\"".$PHP_SELF."?action=status_user&id=".$row["gid"]."&uid=$uid\">Изменить статус</a>&nbsp;|&nbsp;<a href=\"".$PHP_SELF."?action=del_user&id=".$row["gid"]."&uid=$uid\"><font color=red>Удалить</font></a></b></td>";
        
            echo "<tr><td><a href=\"/userdetails.php?id=".$uid."\">".get_user_class_color($row["class"],$row['username'])."</td><td>".get_user_class_group($row["access"])."</a></td>$edit</tr>";

        } while($row = mysql_fetch_array($result));
    } else {
        print "<tr><td>Нет участников!</td></tr>";
    }
    echo "</table>";
    
    
    end_frame(); 
    end_main_frame();
    stdfoot();
    
    die();
}

// передача бонусов группе
if ($_GET['action'] == "givebonus") {
    if (!$id) { header("Location: $BASEURL/group.php"); die();}
    
    $res = mysql_query("SELECT name FROM groups WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    list($group_name) = mysql_fetch_array($res);
    if ($group_name == false) stderr("Error", "Группа не найдена.");
    $group_name = htmlspecialchars($group_name);
    // процесс передачи бонусов группе
    $give_bonuses = (int)$_POST['bonus'];
    if ($give_bonuses > 0) {
        $res = mysql_query("SELECT COUNT(*) FROM groups_users WHERE gid=".sqlesc($id)." AND uid =".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
        list($user_in_group) = mysql_fetch_array($res);
        if ($user_in_group == 0) stderr("Error", "Вы не являетесь участником этой группы.");
    
        $res = mysql_query("SELECT bonus FROM users WHERE id =".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
        list($user_bonus) = mysql_fetch_array($res);
        if ($give_bonuses > $user_bonus) stderr("Error", "У вас недостаточно бонусов.");
    
        mysql_query("UPDATE groups SET bonus=bonus+$give_bonuses WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        mysql_query("UPDATE users SET bonus=bonus-$give_bonuses WHERE id=".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
        
        stdhead();
        stdmsg("Передача бонусов", "$give_bonuses бонусов передано группе <a href=\"group.php?action=viewforum&forumid=$id\"><b>$group_name</b></a>.");
        stdfoot();
        die;
    }
    
    stdhead("Передача бонусов группе $group_name");
    begin_main_frame();
    begin_frame("Передача бонусов группе <a href=\"group.php?action=viewforum&forumid=$id\"><b>$group_name</b></a>");
    ?>
<form method=post action="">
<table width="100%"  border="0" cellspacing="0" cellpadding="3" align="center">
<tr>
    <td><b>Количество бонусов</td>
    <td><input name="bonus" type="text" size="20" maxlength="60" value=""></td>
  </tr>
  <tr align="center">
    <td colspan="2"><input type="hidden" name="action" value="editforum"><input type="hidden" name="id" value="<?=$id;?>"><input type="submit" name="Submit" value="Готово" class="btn"></form>
    <form method="get" action="group.php?action=viewforum&forumid=<?=$id?>"><input type="submit" value="Вернуться" class="btn" /></form></td>
  </tr>

</table>
<?
    end_frame(); 
    end_main_frame();
    stdfoot(); 
    
    die();
}
// вслупление в группу
if ($_GET['action'] == "jointogroup") {
    if (!$id) { header("Location: $BASEURL/group.php"); die();}
    
    $res = mysql_query("SELECT name, invite, close FROM groups WHERE id =".$id) or sqlerr(__FILE__, __LINE__);
    list($name,$invite,$close) = mysql_fetch_array($res);
    if ($name == false) stderr("Error", "Группа не найдена.");
    if ($close == 1 and get_user_class() < UC_ADMINISTRATOR) stderr("Error", "Встепление в эту группу возможно только по приглашению.</a>");
    if ($invite == 1 and get_user_class() < UC_ADMINISTRATOR) stderr("Error", "Встепление в эту группу возможно только по заявке. <a href=\"groupmanage.php?action=leave_invite&id=".$id."\"><b>Подать заявку на вступление</b></a>");
    $name = htmlspecialchars($name);
    $res = mysql_query("SELECT bonus FROM users WHERE id =".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    list($user_bonus) = mysql_fetch_array($res);
    
    $res = mysql_query("SELECT COUNT(*) FROM groups_users WHERE uid =".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    list($user_groups) = mysql_fetch_array($res);
    if ($user_groups >= $MAX_USR_GROUPS) stderr("Error", "Вы не можете быть участником более чем $MAX_USR_GROUPS групп.");
    
    $in_groups = 0;
    $usr_in_group = 0;
    $res = mysql_query("SELECT * FROM groups_users WHERE gid =".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    while ($row = mysql_fetch_array($res)) {
        $in_groups++;
        if ($row['uid'] == $CURUSER["id"]) $usr_in_group++;
    }
    if ($usr_in_group > 0) stderr("Error", "Вы уже являетесь участником этой группы.");
    if ($in_groups >= $GROUPS_MINUS_BONUS and $_GET['sure'] == 0) stderr("Error", "В группе больше $GROUPS_MINUS_BONUS участников. Для вступления в группу вы должны отдать $PAY_BONUS бонусов. Для продолжения нажмите <a href=\"group.php?action=jointogroup&id=".$id."&sure=1\"><b>сюда</b></a>");
    if ($user_bonus < $PAY_BONUS and $_GET['sure'] == 1) stderr("Error", "У вас недостаточно бонусов для вступления в группу.");
    
    mysql_query("INSERT INTO groups_users (uid, gid, access) VALUES(".sqlesc($CURUSER["id"]).", $id, 1)") or sqlerr(__FILE__, __LINE__);
    mysql_query("UPDATE groups SET bonus=bonus+100 WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    if ($in_groups >= $GROUPS_MINUS_BONUS) mysql_query("UPDATE users SET bonus=bonus-$PAY_BONUS WHERE id=".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    
    stdhead();
    stdmsg("Вступление в группу", "Вы вступили в группу <a href=\"group.php?action=viewforum&forumid=$id\"><b>$name</b></a>.");
    stdfoot();
    die;
}

// удаление группы
if ($_GET['action'] == "del") {

    if (!$id) { header("Location: $BASEURL/group.php"); die();}

    $res = mysql_query("SELECT * FROM groups WHERE id =".$id) or sqlerr(__FILE__, __LINE__);
    $row = mysql_fetch_array($res);
    
    if (get_user_class() >= UC_ADMINISTRATOR or $CURUSER["id"] == $row['create_by']) {
    
        $result = mysql_query ("SELECT * FROM groups_topics WHERE forumid = '".$id."'");
        if ($row = mysql_fetch_array($result)) {
            do {
                mysql_query ("DELETE FROM groups_posts WHERE topicid = '".$row["id"]."'") or sqlerr(__FILE__, __LINE__);
            } while($row = mysql_fetch_array($result));
        }
        mysql_query ("DELETE FROM groups_topics WHERE forumid = '".$id."'") or sqlerr(__FILE__, __LINE__);
        mysql_query ("DELETE FROM groups WHERE id = '".$id."'") or sqlerr(__FILE__, __LINE__);
        mysql_query ("DELETE FROM groups_users WHERE gid = '".$id."'") or sqlerr(__FILE__, __LINE__);
        mysql_query ("DELETE FROM groups_applications WHERE gid = '".$id."'") or sqlerr(__FILE__, __LINE__);
        mysql_query ("DELETE FROM groups_invites WHERE gid = '".$id."'") or sqlerr(__FILE__, __LINE__);
    }
    header("Location: $BASEURL/group.php");
    die();
}

// реадктирование группы (процесс)
if ($_POST['action'] == "editforum") {

    $name = ((string)$_POST['name']);
    $desc = ((string)$_POST['desc']);
    $long_desc = ((string)$_POST['long_desc']);
    $poster = ((string)$_POST['poster']);
    $privat = ($_POST['privat']==1?1:0);
    $invite = ($_POST['invite']==1?1:0);
    $close = ($_POST['close']==1?1:0);

    if (!$name && !$desc && !$long_desc && !$id) { header("Location: $BASEURL/group.php"); die();}

    mysql_query("UPDATE groups SET name = " . sqlesc($name). ", description = " . sqlesc($desc). ", long_description = " . sqlesc($long_desc). ", privat=$privat, poster=".sqlesc($poster).", invite=$invite, close=$close WHERE id = '".(int)$_POST['id']."'") or sqlerr(__FILE__, __LINE__);
    header("Location: $BASEURL/group.php?action=viewforum&forumid=".(int)$_POST['id']);
    die();
}

// создание группы (процесс)
if ($_POST['action'] == "addforum") {
    $res = mysql_query("SELECT bonus FROM users WHERE id =".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    list($user_bonus) = mysql_fetch_array($res);
    
    $res = mysql_query("SELECT COUNT(*) FROM groups WHERE create_by =".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    list($user_groups) = mysql_fetch_array($res);
    
    if ($user_groups == 0 and $user_bonus < 500) stderr("Error", "У вас не хватает бонусов для открытия группы. Нужно 500, а у вас $user_bonus");     
    elseif ($user_groups >= 1 and $user_bonus < 1500) stderr("Error", "У вас не хватает бонусов для открытия группы. Нужно 1500, а у вас $user_bonus");
    
    
    if ($user_groups == 0) $minus_bonus = 500;
    else $minus_bonus = 1500;
      
    $name = ((string)$_POST['name']);
    $desc = ((string)$_POST['desc']);
    $long_desc = ((string)$_POST['long_desc']);
    $poster = ((string)$_POST['poster']);
    $privat = ($_POST['privat']==1?1:0);
    $invite = ($_POST['invite']==1?1:0);
    $close = ($_POST['close']==1?1:0);

    if (!$name && !$desc && !$long_desc) { header("Location: $BASEURL/group.php"); die();}

    mysql_query("INSERT INTO groups (name, description, long_description, poster, bonus, privat, create_by, invite,close) VALUES(" . sqlesc($name). ", " . sqlesc($desc). ", " . sqlesc($long_desc). ", ".sqlesc($poster).", 300, $privat, ".sqlesc($CURUSER["id"]).", $invite, $close)") or sqlerr(__FILE__, __LINE__);
    $gid = mysql_insert_id();
    if ($gid) {
        mysql_query("INSERT INTO groups_users (uid, gid, access) VALUES(".sqlesc($CURUSER["id"]).", $gid, 5)") or sqlerr(__FILE__, __LINE__);
        mysql_query("UPDATE users SET bonus=bonus-$minus_bonus WHERE id=".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    }
    header("Location: $BASEURL/group.php?action=viewforum&forumid=$gid");
    die();
}

// SHOW groups WITH FORUM MANAGMENT TOOLS
stdhead("Редактирование / создание групп");

// реадактрование группы
if ($_GET['action'] == "editforum") {


    $id = (int)$_GET["id"];
    $result = mysql_query ("SELECT * FROM groups WHERE id=".sqlesc($id));
    if ($row = mysql_fetch_array($result)) {
        $row["name"] = htmlspecialchars($row["name"]);
        begin_frame("Редактирование группы ".$row["name"]);
        
        $res = mysql_query("SELECT access FROM groups_users WHERE gid=".sqlesc($id)." AND uid=".sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
        list($access) = mysql_fetch_array($res);
        
        if (get_user_class() >= UC_ADMINISTRATOR or $access >= $classes['admin']) {
?>

<form name='compose' method=post action="<?=$_SERVER["PHP_SELF"];?>">
<table width="100%"  border="0" cellspacing="0" cellpadding="3" align="center">
  <tr>
    <td><b>Название</td>
    <td><input name="name" type="text" size="75" maxlength="60" value="<?=$row["name"];?>"></td>
  </tr>
  <tr>
    <td><b>Приватная</b><br>Просматривать могут только участники группы</td>
    <td><input type="radio" name="privat" value="0" <?=($row['privat']==1?'':' checked=checked')?>>&nbsp;Нет&nbsp;&nbsp;&nbsp;<input type="radio" name="privat" value="1"<?=($row['privat']==1?' checked=checked':'')?>>&nbsp;Да</td>
  </tr>
  <tr>
    <td><b>Вступление по заявкам</b><br>Вступление возможно только по заявках или приглашениях</td>
    <td><input type="radio" name="invite" value="0" <?=($row['invite']==1?'':' checked=checked')?>>&nbsp;Нет&nbsp;&nbsp;&nbsp;<input type="radio" name="invite" value="1"<?=($row['invite']==1?' checked=checked':'')?>>&nbsp;Да</td>
  </tr>
  <tr>
    <td><b>Закрытая</b><br>Вступление возможно только по приглашениях</td>
    <td><input type="radio" name="close" value="0" <?=($row['close']==1?'':' checked=checked')?>>&nbsp;Нет&nbsp;&nbsp;&nbsp;<input type="radio" name="close" value="1"<?=($row['close']==1?' checked=checked':'')?>>&nbsp;Да</td>
  </tr>
  <tr>
    <td><b>Постер</td>
    <td><input name="poster" type="text" size="75" maxlength="60" value="<?=$row["poster"];?>"></td>
  </tr>
  <tr>
    <td><b>Описание короткое</td>
    <td><input name="desc" type="text" size="75" maxlength="60" value="<?php echo $row["description"];?>"></td>
  </tr>
  <tr>
    <td><b>Описание полное</td>
    <td>
<?
textbbcode("compose","long_desc",$row["long_description"], 1);
?>

<script src="js/preview.js"></script>
<div id="loading-layer" style="display:none;font-family: Verdana;font-size: 11px;width:200px;height:50px;background:#FFF;padding:10px;text-align:center;border:1px solid #000">
     <div style="font-weight:bold;" id="loading-layer-text">Загрузка. Пожалуйста, подождите...</div><br>
     <img src="pic/loading.gif" border="0" />
</div>
<br>
<div id="preview" style="width:530px;"></div>
    </td>
  </tr>

  <tr align="center">
    <td colspan="2"><input type="button" value="Предпросмотр" onClick="javascript:ajaxpreview('area');" ><input type="hidden" name="action" value="editforum"><input type="hidden" name="id" value="<?=$id;?>"><input type="submit" name="Submit" value="Готово" class="btn"></td>
  </tr>
</table>

<?
        } else stderr("Error", "Доступ запрещен.");
    } else {
        begin_frame("Редактирование группы");
        print "Группа не найдена!";
    }
    print("<tr><td align=center colspan=1><form method=\"get\" action=\"groupmanage.php#add\"><input type=\"submit\" value=\"Вернуться\" class=\"btn\" /></form></td></tr>\n");
    end_frame();
} 
// создание группы
else { 
begin_frame("Создать группу");
    ?>

<form name='compose' method=post action="<?=$_SERVER["PHP_SELF"];?>">
<table width="100%"  border="0" cellspacing="0" cellpadding="3" align="center">
  <tr>
    <td><b>Название</td>
    <td><input name="name" type="text" size="75" maxlength="60"></td>
  </tr>
  <tr>
    <td><b>Приватная</b><br>Просматривать могут только участники группы</td>
    <td><input type="radio" name="privat" value="0" checked=checked>&nbsp;Нет&nbsp;&nbsp;&nbsp;<input type="radio" name="privat" value="1">&nbsp;Да</td>
  </tr>
  <tr>
    <td><b>Вступление по заявкам</b><br>Вступление возможно только по заявках или приглашениях</td>
    <td><input type="radio" name="invite" value="0" checked=checked>&nbsp;Нет&nbsp;&nbsp;&nbsp;<input type="radio" name="invite" value="1">&nbsp;Да</td>
  </tr>
  <tr>
    <td><b>Закрытая</b><br>Вступление возможно только по приглашениях</td>
    <td><input type="radio" name="close" value="0" <?=($row['close']==1?'':' checked=checked')?>>&nbsp;Нет&nbsp;&nbsp;&nbsp;<input type="radio" name="close" value="1"<?=($row['close']==1?' checked=checked':'')?>>&nbsp;Да</td>
  </tr>
  <tr>
    <td><b>Постер</td>
    <td><input name="poster" type="text" size="75" maxlength="60" value=""></td>
  </tr>
  <tr>
    <td><b>Описание короткое</td>
    <td><input name="desc" type="text" size="75" maxlength="60"></td>
  </tr>
  <tr>
    <td><b>Описание полное</td>
    <td>
<?textbbcode("compose","long_desc","", 1);?><script src="js/preview.js"></script>
<div id="loading-layer" style="display:none;font-family: Verdana;font-size: 11px;width:200px;height:50px;background:#FFF;padding:10px;text-align:center;border:1px solid #000">
<div style="font-weight:bold;" id="loading-layer-text">Загрузка. Пожалуйста, подождите...</div><br>
<img src="pic/loading.gif" border="0" /></div><br><div id="preview" style="width:530px;"></div></td></tr><tr align="center">
<td colspan="2"><input type="button" value="Предпросмотр" onClick="javascript:ajaxpreview('area');" >
<input type="hidden" name="action" value="addforum"> <input type="submit" name="Submit" value="Создать" class=btn></td></tr></table>
<? end_frame();}stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>