<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){	
stdhead("ЧаВо сайта $SITENAME");begin_frame(".:: ЧаВо сайта $SITENAME ::.");?>
<table class="main" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="embedded"><table width="100%" cellspacing="0" cellpadding="3"><tr><td>
<ul><h2>О сайте</h2><ul><li><a href="#0" class="altlink">Что такое торрент (bittorrent)? Как скачивать файлы?</a></li></ul>
<h2>Информация для пользователей</h2>
<ul><li><a href="#2" class="altlink">Можно удалить мой аккаунт?</a></li></ul>
<ul><li><a href="#3" class="altlink">Не могли бы вы переименовать мою учетную запись?</a></li></ul>
<ul><li><a href="#4" class="altlink">Как начисляются Бонусы за сидирование релизов?</a></li></ul>
<ul><li><a href="#5" class="altlink">Какая система скидок на релизы?</a></li></ul>
<ul><li><a href="#5-2" class="altlink">Что такое Hit/Run (HnR) и как он работает?</a></li></ul>
<ul><li><a href="#6" class="altlink">А что такое мой рейтинг (ratio)?</a></li></ul>
<ul><li><a href="#7" class="altlink">А как мне повысить рейтинг (ratio)?</a></li></ul>
<ul><li><a href="#8" class="altlink">Почему мой IP отображается на странице с деталями?</a></li></ul>
<ul><li><a href="#9" class="altlink">Помогите! Я не могу войти (залогиниться)!?</a></li></ul>
<ul><li><a href="#10" class="altlink">Мой IP-адрес динамический. Что мне сделать, чтобы быть подключенным?</a></li></ul>
<ul><li><a href="#11" class="altlink">Почему написано, что я не могу подключиться? (В графе Порт мой порт красного цвета)</a></li></ul>
<ul><li><a href="#12" class="altlink">Что такое разные классы пользователей?</a></li></ul>
<ul><li><a href="#14" class="altlink">Почему мои знакомые не могут зарегистрироваться?</a></li></ul>
<ul><li><a href="#15" class="altlink">Как мне добавить аватар в свой профиль?</a></li></ul>
<ul><li><a href="#17" class="altlink">А что это за значки <img src="pic/bril.gif" border="0"> или <img src="pic/golden.gif" border="0"> или <img src="pic/silvers.gif" border="0"> около торрентов в списке?</a></li></ul>
<ul><li><a href="#18" class="altlink">А что это за значок <img src="pic/warned.gif" border="0"> рядом с моим ником?</a></li></ul>
<ul><li><a href="#19" class="altlink"><font color="red">Как мне защитить свой профиль от просмотра других юзеров?</font></a></li></ul><ul></ul>
<h2>Статистика</h2>
<ul><li><a href="#20" class="altlink">Почему пишет мне: <font color="blue">"Поднимите рейтинг! Вы можете скачать этот релиз только через *** часов"?</font></a></li></ul>
<ul><li><a href="#21" class="altlink">Наиболее часто встречающиеся причины необновления статистики.</a></li></ul>
<ul><li><a href="#22" class="altlink">Полезные советы.</a></li></ul>
<ul><li><a href="#24" class="altlink">Почему торрент, который я качаю/раздаю, отображается в профиле несколько раз?</a></li></ul>
<ul><li><a href="#25" class="altlink">Я закончил или отменил торрент. Почему в моем профиле он все ещё отображается?</a></li></ul>
<ul><li><a href="#26" class="altlink">Почему иногда в моем профайле присутствуют торренты, которые я не качал!?</a></li></ul>
<ul><li><a href="#27" class="altlink">Несколько IP (Могу ли я логинится с разных компьютеров)?</a></li></ul>
<ul><li><a href="#28" class="altlink">Как NAT/ICS может испортить малину?</a></li></ul>
<h2>Заливка (Uploading)/Сидирование/Раздача релизов <?=$SITENAME;?> на других ресурсах</h2>
<ul><li><a href="#30" class="altlink">Кто может раздавать на <?=$SITENAME;?>?</a></li></ul>
<ul><li><a href="#31" class="altlink">Что мне надо сделать, чтобы стать Аплодером?</a></li></ul>
<ul><li><a href="#32" class="altlink">Могу ли я раздавать ваши торренты на других трекерах?</a></li></ul>
<ul><li><a href="#33" class="altlink">Как помочь с раздачей, как продолжить сидирование уже скачанного материала?</a></li></ul>
<h2>Скачивание (Downloading)</h2>
<ul><li><a href="#37" class="altlink">Как можно продолжить скачивание/раздачу, если торрента нет в списке в моём клиенте?</a></li></ul>
<ul><li><a href="#38" class="altlink">Почему мои загрузки иногда останавливаются на 99%?</a></li></ul>
<ul><li><a href="#39" class="altlink">Что значит сообщение &quot;a piece has failed an hash check&quot;?</a></li></ul>
<ul><li><a href="#40" class="altlink">Размер торрента 1500Мб. Как я мог скачать 1800Мб?</a></li></ul>
<ul><li><a href="#42" class="altlink">Что такое "IOError - [Errno13] Permission denied"?</a></li></ul>
<ul><li><a href="#44" class="altlink">А почему у меня вообще ничего не качается, хотя я использую нормальный клиент?</a></li></ul>
<h2>Как я могу увеличить мою скорость?</h2>
<ul><li><a href="#45" class="altlink">Не набрасывайтесь на новые торренты</a></li></ul>
<ul><li><a href="#46" class="altlink">Настройте свои железки на нормальное подключение</a></li></ul>
<ul><li><a href="#47" class="altlink">Ограничьте свою скорость раздачи</a></li></ul>
<ul><li><a href="#50" class="altlink">Подождите немного</a></li></ul>
<ul><li><a href="#51" class="altlink">Почему страницы так медленно открываются, когда я качаю что-то?</a></li></ul>
<h2>Мой провайдер использует прокси. Что мне делать?</h2>
<ul><li><a href="#52" class="altlink">Что такое прокси (proxy)?</a></li></ul>
<ul><li><a href="#53" class="altlink">Как обнаружить, что я сижу за прокси?</a></li></ul>
<ul><li><a href="#54" class="altlink">Почему написано, что невозможно подключится, хотя я не использую NAT/firewall</a></li></ul>
<ul><li><a href="#55" class="altlink">Можно ли обойти прокси моего провайдера?</a></li></ul>
<ul><li><a href="#56" class="altlink">Как сделать, чтоб мой торрент-клиент использовал прокси?</a></li></ul>
<ul><li><a href="#57" class="altlink">Почему я не могу зарегистрироваться из под прокси?</a></li></ul>
<h2>Почему я не могу залогиниться? Меня заблокировали?</h2>
<ul><li><a href="#59" class="altlink">Может мой IP занесён в черный список?</a></li></ul>
<ul><li><a href="#60" class="altlink">Ваш провайдер блокирует адрес нашего сайта.</a></li></ul></ul></td></tr></table><br>
<h2>О сайте</h2>
<table width="100%" cellspacing="0" cellpadding="3"><tr><td>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="0"></a> <b>Что такое торрент (bittorrent)? Как скачивать файлы?</b><br/>
Битторрент - это протокол разработанный для обмена файлами. По сути он является peer-to-peer протоколом, когда каждый пользователь коннектится к другому напрямую, для приема или передачи частей информации. Для работы с этим протоколом мы рекомендуем использовать программу µTorrent, BitComet или Azureus (список рекомендованных клиентов смотрите в левом столбце на главной трекера клуба). Вам необходимо скачать торрент файл (клик по заголовку рядом с дискеткой на странице релиза) и затем запустить закачку в торрент-клиенте (указать путь сохранения файлов).<br/><br/>
</td></tr></table>								 
<h2>Информация для пользователей</h2>
<table width="100%" cellspacing="0" cellpadding="3"><tr><td>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="2"></a> <b>Можно удалить мой аккаунт?</b><br/>
Если вы решили покинуть наше сообщество навсегда, то пройдите <a href="delact"><b>СЮДА</b></a> и правильно заполните поля Логин/Пароль от вашего аккаунта. Но подумайте еще раз, вы точно не будете потом об этом жалеть?</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="3"></a> <b>Не могли бы вы переименовать мою учетную запись?</b><br/>
Мы не переименовываем аккаунты.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="4"></a> <b>Как начисляются Бонусы за сидирование релизов?</b><br/><br/>
Бонусы для Хит/Ран, если все время сидирования релиза <b>МЕНЬШЕ 7 дней</b> начисляются в таком порядке:<br><br/>
<table border="0" cellspacing="3" cellpadding="0">
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">0.1</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонуса в час за один торрент до <font color="#D21E36"><b>500Mb</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">0.5</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонуса в час за один торрент от <font color="#D21E36"><b>500Mb</b></font> и менее <font color="Indigo"><b>1GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">1.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонус в час за один торрент от <font color="#D21E36"><b>1GB</b></font> и менее <font color="Indigo"><b>10GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">2.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонуса в час за один торрент от <font color="#D21E36"><b>10GB</b></font> и менее <font color="Indigo"><b>50GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">6.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонусов в час за один торрент от <font color="#D21E36"><b>50GB</b></font> и менее <font color="Indigo"><b>100GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">10.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонусов в час за один торрент от <font color="#D21E36"><b>100GB</b></font> и менее <font color="Indigo"><b>200GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">20.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонусов в час за один торрент от <font color="#D21E36"><b>200GB</b></font> и менее <font color="Indigo"><b>300GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">30.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонусов в час за один торрент от <font color="#D21E36"><b>300GB</b></font> и менее <font color="Indigo"><b>400GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">40.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонусов в час за один торрент от <font color="#D21E36"><b>400GB</b></font> и <font color="Indigo"><b>выше</b></font></td>
</tr>
</table>
<br>
То-есть: вы сидируете, к примеру, два релиза по <font color="0F6CEE"><b>25GB</b></font> каждый. Значит у вас должно быть <b>2.0</b> + <b>2.0</b> = <font color="#D21E36"><b>4.0</b></font> бонуса в час за сидирование этих двух торрентов.
<br/><br/>
Бонусы для Хит/Ран, если все время сидирования релиза <b>БОЛЬШЕ 7 дней</b> и <b>ЕСЛИ</b> на раздаче сидеров <b>МЕНЬШЕ 3-х</b>, начисляются в таком порядке:<br><br/>
<table border="0" cellspacing="3" cellpadding="0">
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">0.2</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонуса в час за один торрент до <font color="#D21E36"><b>500Mb</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">1.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонус в час за один торрент от <font color="#D21E36"><b>500Mb</b></font> и менее <font color="Indigo"><b>1GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">2.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонуса в час за один торрент от <font color="#D21E36"><b>1GB</b></font> и менее <font color="Indigo"><b>10GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">4.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонуса в час за один торрент от <font color="#D21E36"><b>10GB</b></font> и менее <font color="Indigo"><b>50GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">12.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонусов в час за один торрент от <font color="#D21E36"><b>50GB</b></font> и менее <font color="Indigo"><b>100GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">20.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонусов в час за один торрент от <font color="#D21E36"><b>100GB</b></font> и менее <font color="Indigo"><b>200GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">40.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонусов в час за один торрент от <font color="#D21E36"><b>200GB</b></font> и менее <font color="Indigo"><b>300GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">60.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонусов в час за один торрент от <font color="#D21E36"><b>300GB</b></font> и менее <font color="Indigo"><b>400GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><b><font color="0F6CEE">80.0</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">бонусов в час за один торрент от <font color="#D21E36"><b>400GB</b></font> и <font color="Indigo"><b>выше</b></font></td>
</tr></table><br>
То-есть: вы сидируете, к примеру, два релиза по <font color="0F6CEE"><b>25GB</b></font> каждый. Значит у вас должно быть <b>4.0</b> + <b>4.0</b> = 
<font color="#D21E36"><b>8.0</b></font> бонусов в час за сидирование этих двух торрентов, при условии что вы сидируете их БОЛЬШЕ 7 дней КАЖДЫЙ из релизов!
<br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="5"></a> <b>Какая система скидок на релизы?</b><br/>
<table border="0" cellspacing="3" cellpadding="0">
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><img src="pic/silvers.gif" border="0" title="50%"></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">Релизы весом от <font color="#D21E36"><b>20GB</b></font> и до <font color="Indigo"><b>35GB</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><img src="pic/golden.gif" border="0" title="100%"></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">Релизы весом от <font color="#D21E36"><b>35GB</b></font> и <font color="Indigo"><b>выше</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><img src="pic/golden.gif" border="0" title="100%"></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">Все релизы <font color="#D21E36"><b>DSD</b></font> и <font color="Indigo"><b>UHD 8K / UHD 16K</b></font></td>
</tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><div align="center" valign="middle"><img src="pic/bril.gif" border="0" title="100%"></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">Релизы паков от <font color="#D21E36"><b>100GB</b></font> и раритетные, которые мало кто сидирует. 
	Даётся на усмотрение Администрации.</td>
</tr>
</table><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="5-2"></a> <b>Что такое Hit/Run (HnR) и как он работает?</b><br/><br/>
<b>Кнут и Пряник! С одной стороны, вас этим заставляют качать и ОТДАВАТЬ, ВНЕЗАПНО!</b><br/><br/>
<table border="0" cellspacing="3" cellpadding="0">
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">
<b>а)</b> Наши люди привыкли скачать и сбежать сразу, пофиг там - не раздал даже положенного 1:1 (сколько скачал, столько отдал чтобы рейтинг не "просел").
<br/>Вот тут и начинается кнут - юзвер должен отдать обратно на сайт (залить в свою статистику именно по ЭТОМУ релизу) веса в 2-1 раза больше чем скачал. 
<br/>Наглости нет, банальная совесть должна быть.<br/><br/></td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">
<b>б)</b> Теперь про пряник - О... Тут целая плеяда подводных камней. Есть подарки бонусами, или удваивание трафика после 2:1 роздано..<br/><br/>
</td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle"><b>Принцип работы мода:</b><br/><br/></td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">
<b>1.</b> Учитывает время сидирования каждой раздачи отдельно, за все время. Форс-мажоры по типу - отрубили внезапно свет, 
сами выключили случайно в клиенте, а вы сидировали релиз - все учитывается!<br/>Скрипт автоматически посчитает время сидирования до прекращения 
с <b>ВАШЕЙ</b> стороны сидирования и приплюсует к тому времени, что уже записано на раздачу в вашем списке Сидирует/Качает.<br/><br/></td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">
<b>2.</b> Время сидирования чтобы можно было уходить с раздачи (если скачали и сидируете) - <b>7 дней.</b><br/><br/></td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">
<b>3.</b> Вы можете уходить с раздачи, если вы не "отсидировали" <b>7 дней</b>, но раздали:<br/><br/></td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">
<b>a)</b> Если <img src="pic/bril.gif" border="0" title="50%"> <b>> 1</b> (больше чем 1 вес раздачи)<br/><br/></td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">
<b>б)</b> Если <img src="pic/golden.gif" border="0" title="100%"> <b>> 1.5</b> (больше чем 1,5 веса раздачи)<br/><br/></td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">
<b>в)</b> Если <img src="pic/silvers.gif" border="0" title="50%"> и Обычная раздача <b>> 2</b> (больше чем 2 веса раздачи)
<br/><br/></td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">
<b>4.</b> Если не раздали веса по таблице сверху, и не просидировали все 7 дней, по истечении срока (<b>7 дней</b> или рейтинг) включается скрипт наказания:
<br/><br/></td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">
<b>а)</b> Из вашей статистики "Залил на сайт" снимается вес согласно схеме скидок на релиз что вы качали (Бриллиант <b>1:1</b>), (Золото - <b>1.5:1</b>), 
(Серебро и Обычные <b>2:1</b>).<br/><br/></td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">
<b>б)</b> Вам приходит уведомление в ЛС о том, что с вас сняли такое-то количество ГБ, из-за того, что вы не выполнили условия обмена на сайте 
(Раздай или посиди на сидировании).<br/><br/></td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">
<b>в)</b> Если у вас в общей сумме будет больше <b>10</b> (<b>>10</b>) случаев (<b>ШТРАФОВ</b>) саботажа обмена, включается выдача предупреждения за 
НЕ выполнение условий обмена на сайте.<br/>Выкупить предупреждение можно бонусами за сидирование в пункте обмена бонусов.
</td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><br/><div align="center" valign="middle"><img src="pic/ojid.png" border="0" title="Уходить нельзя, вы не отдали норму"></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle"><br/><br/><b>Уходить рано, вы не выполнили условие обмена!</b><br/><br/>
</td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><br/><div align="center" valign="middle"><img src="pic/uhod.png" border="0" title="Можно уходить"></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle"><br/><br/><b>Можно уходить, вы выполнили условие обмена!</b>
</td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><br/><div align="center" valign="middle"><img src="pic/vipp.png" border="0" title="VIP"></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle"><br/><br/><b>VIP-юзер, имеет имунитет к Хит/Ран</b>. Можно уходить, вам не будет никакого штрафа.<br/><br/>
</td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><br/><div align="center" valign="middle"><img src="pic/starbig.gif" border="0" title="Помощь в сидировании"></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle"><br/><br/><b>Помощь в раздаче</b>, поскольку у вас оказался такой-же файл на HDD. 
	Возможно поощерение за долгое сидирование!<br/><br/>
</td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><br/><div align="center" valign="middle"><img src="pic/shtraf.png" border="0" title="Штраф!"></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle"><br/><br/><b>Вы получили ШТРАФ!</b> Читайте вашу почту, там должно быть подробное письмо за что, сколько и когда.<br/>
	Оспорить (если считаете что вас обидел скрипт) можете в ЛС любому юзеру из администрации на странице <a href="team"><b>КОМАНДА</b></a>.<br/><br/>
</td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><br/><div align="center" valign="middle"><img src="pic/class_error.gif" border="0" title="Ошибка доставки!"></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle"><br/><br/><b>Ошибка скрипта отправки ЛС.</b> Администрация мониторит список ошибок, и поправит это недоразумение.<br/><br/>
</td></tr>
<tr><td class="embedded" width="40">&nbsp;</td>
    <td class="embedded" width="20"><br/><div align="center" valign="middle"><img src="pic/nol.png" border="0" title="Ничего не сидировал"></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle"><br/><br/><b>Вы ничего не насидировали, всё по нулям.</b> Исправляйтесь!<br/><br/>
</td></tr>
</table><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="6"></a> <b>А что такое мой рейтинг (ratio)?</b><br/>
Ратио, оно же Рейтинг, оно же Соотношение - это количество отданной вами информации деленное на количество скачанной.
Ваше ратио написано сверху на панели информации, под вашим ником.
<br/>
Важно различать общий рейтинг (ratio) и рейтинг каждого торрента, который вы скачиваете или раздаёте. 
Общий рейтинг рассчитывается из общих значений загруженного и розданного вашим аккаунтом с того момента, как вы зарегистрировались на сайте.
Индивидуальный рейтинг каждого торрента учитывает только количество загруженного/скачанного для конкретного файла (торрента).
<br/>
Также возможны 2 обозначения вместо рейтинга: &quot;Inf.&quot;,
это аббревиатура от слова Infinity(бесконечность), и означает, что вы скачали 0 байт, в то время, как раздали не нулевое значение;
а так же может встретиться &quot;---&quot;,
которое должно читаться как "недоступно", и означает что вы ничего не скачали и не загрузили.</a><br/><br/>

<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="7"></a> <b>А как мне повысить рейтинг (ratio)?</b><br/>
<b>Следите, чтобы ратио надолго не падал ниже 0,30</b>, ибо тогда вы можете быть пожизненно забанены на трекере <?=$SITENAME;?>. Как повысить ратио? Это очень просто - отдавайте то, что скачали и ратио будет повышаться. Используйте золотые раздачи - на них засчитывается только розданное, а закачка не считается. Либо серебрянные - засчитывается лишь 50% закачки. Особенно внимательно отнеситесь к ратио, пока не наберете показатель 1 и более.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="8"></a> <b>Почему мой IP отображается на странице с деталями?</b><br/>
Только вы и модераторы могут смотреть ваш IP и email. Обычные пользователи не могут видеть эту информацию.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="9"></a> <b>Помогите! Я не могу войти (залогиниться)!?</b><br/>
Иногда эта проблема возникает из-за глюков Internet Explorer или других браузеров.
Закройте все окна браузера и откройте опции в панели управления.
Удалите cookies (обычно кликнуть на кнопку Delete Cookies). Это должно помочь.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="10"></a> <b>Мой IP-адрес динамический. Что мне сделать, чтобы быть подключенным?</b><br/>

Вам не нужно ничего делать. Всё, что вам нужно - это убедиться, что вы вошли (залогинились)
с текущим IP- адресом, когда стартуете новую торрент-сессию (начинаете новую загрузку/раздачу).
После этого, даже если ваш IP поменяется в течении сессии, скачивание или раздача продолжатся, и статистика обновится автоматически.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="11"></a> <b>Почему написано, что я не могу подключиться? (В графе Порт мой порт красного цвета)(И о чем мне надо позаботиться?)</b><br/>
Трекер обнаружил, что у вас файрвол (firewall) или NAT, и вы не можете принимать подключения. Это означает, что другие участники не смогут коннектиться к вам, лишь только вы к ним.
<br/>
Для решения данной проблемы откройте порты, используемые для входящих соединений (такие же, как и в установках вашего клиента)
в файрволе и/или настройте ваш NAT сервер.
(Обратитесь к документации к вашему роутеру или на форум производителя).
Так же вы можете найти нужную информацию на ресурсе: <a class="altlink" href="redirect.php?url=http://portforward.com/">PortForward</a>).</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="12"></a> <b>Что такое разные классы пользователей?</b><br/></a>

<table border="0" cellspacing="3" cellpadding="0">
<tr><td class="embedded" colspan="3"><hr/></td></tr>
<tr><td class="embedded"><div align="center" valign="middle"><b><font color="gray"> Личер</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">Понижение при предупреждении перед баном (сидируйте пока вас не отключили). Предупреждение выписывается когда скачано менее <b>500 Гбайт</b> и ратио менее <b>0.25</b>. Личер может только качать золотые раздачи или докачивать 1 текущий торрент и сидировать, сидировать, сидировать... На возврат в группу 720р дается <b>4 недели</b> и это происходит при ратио более <b>0.31</b>. Этот класс имеет <b>запрет</b> на отправку комментариев (детали релиза, новости, ожидаемые, форум) и не видит Чат на главной и в КазИно.</td></tr>
<tr><td class="embedded" colspan="3"><hr/></td></tr>
<tr>
	<td class="embedded"><div align="center" valign="middle"><b><font color="black"> 720p</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">Обычный, нормальный пользователь трекера (класс для новичков по умолчанию). Качает одновременно до <b>5 торрентов</b>. Этот класс имеет <b>запрет</b> на отправку комментариев (детали релиза, новости, ожидаемые, форум) и общению в чате. <b><font color="#D21E36">Если новый зарегистрированный пользователь ничего не скачал в течении 45 дней после регистрации, значит он тут случайный гость, а такие акаунты удаляются системой. То, что при регистрации дается буфер в 100/10 GB, еще не повод радоваться! Вы должны, именно ДОЛЖНЫ скачать больше чем вам дали бонусом при регистрации!</font></b></td>
</tr>
<tr>
	<td class="embedded" colspan="3"><hr/></td>
</tr>
<tr>
	<td class="embedded"><div align="center" valign="middle"><b><font color="#D21E36">1080i</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">Трекер автоматически присваивает (и отбирает) это звание у пользователей, чей аккаунт активен не менее <b>175 дней, кто скачал более 1 ТВ, имеет рейтинг 2.05 и 500000 бонусов на момент первичной проверки скриптом.</b> Понижение при <b>1,95</b>. Модератор может вручную присвоить этот статус до следующего автоматического исполнения скрипта. Качает одновременно до <b>15 торрентов</b>. С этого класса разрешены комментарии (везде) и общение в чате на главной страничке.</td>
</tr>
<tr>
	<td class="embedded" colspan="3"><hr/></td>
</tr>
<tr>
	<td class="embedded"><div align="center" valign="middle"><b><font color="Indigo">1080p</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">Элит Юзер. Трекер автоматически присваивает (и отбирает) это звание у пользователей, чей аккаунт активен не менее <b>210 дней, кто скачал более 5 ТВ, имеет рейтинг 3.05 и 1000000 бонусов на момент первичной проверки скриптом.</b> Понижение при <b>2,95</b>. Качает одновременно до <b>25 торрентов</b>. С этого класса доступен просмотр статистики сайта.</td>
</tr>
<tr>
	<td class="embedded" colspan="3"><hr/></td>
</tr>
<tr>
	<td class="embedded"><div align="center" valign="middle"><b><font color="#6A5ACD">UHD</font></b></div></td>
	<td class="embedded" width="5">&nbsp;</td>
	<td class="embedded" valign="middle">УльтраХД Юзер. Трекер автоматически присваивает (и отбирает) это звание у пользователей, чей аккаунт активен не менее <b>280 дней, кто скачал более 10 ТВ, имеет рейтинг 4.05 и 10000000 бонусов на момент первичной проверки скриптом.</b> Понижение при <b>3,95</b>. Качает одновременно до <b>50 торрентов</b></td>
</tr>
<tr>
	<td class="embedded" colspan="3"><hr/></td>
</tr>
<tr>
<td class="embedded"><div align="center" valign="middle"><b><font color="blue">Ветеран</font></b></div></td>
<td class="embedded" width="5">&nbsp;</td>
<td class="embedded" valign="middle">Ветеран Юзер. Трекер автоматически присваивает (и отбирает) это звание у пользователей, чей аккаунт активен не менее <b>365 дней, кто скачал более 25 TB, имеет рейтинг 5.00 и 100000000 бонусов на момент первичной проверки скриптом.</b> Понижение при <b>4,95</b>. Качает одновременно до <b>100 торрентов</b></td>
</tr><tr><td class="embedded" colspan="3"><hr/></td></tr>
<tr><td class="embedded"><div align="center" valign="middle"><b><font color="#FF9900">Релизер</font></b></div></td>
<td class="embedded" width="5">&nbsp;</td>
<td class="embedded" valign="middle">Пользователь с правом заливать и раздавать на <?=$SITENAME;?>. Присваивается Администрацией. Может общаться в Приват-чате (виден только от Аплоадер и выше) по разным техническим вопросам (создание релиза, оформление и прочее).<br><br><font color="red"><b>Автоматическое понижение класса обратно (до того как подняли):</b></font>&nbsp;&nbsp;<b>Если в течении 14-ти дней не было ни одной заливки на сайт, система понижает до того состояния класса, которое было ДО поднятия на Аплоадер. Все залитые им релизы в этом случае, автоматически переписываются на авторство системного бота - System.</b><br><br>Вы хорошо разбираетесь в HD, умеете работать с аудио- и видеопотоками? Подавайте заявку на <a href="uploader"><font color='#FF9900'><b>Релизер</b></font></a>. Если вы можете предложить только банальную перезаливку релизов с других ресурсов - пожалуйста, не тратьте зря свое и наше время.</td></tr>
<tr><td class="embedded" colspan="3"><hr/></td></tr>
<tr><td class="embedded"><div align="center" valign="middle"><b><font color="#9C2FE0">VIP</font></b></div></td>
<td class="embedded" width="5">&nbsp;</td>
<td class="embedded" valign="middle">Человек, оказывающий финансовую или другую помощь сайту / Данный статус можно приобрести за бонусы или выиграть в Лотерею.<br>
	Имеет право заливать релизы. Имунитет на <b>Hit/Run (HnR)</b>, так-же не учитывается количество скаченного с сайта.<br>
	Всегда при "бабках"/Бонусах - если количество бонусов падает ниже <font color="red"><b>100 000</b></font> (сто тысяч), 
	автоматически система начисляет дополнительные <font color="green"><b>500 000</b></font> (пол миллиона) бонусов.<br>
	Перевод бонусов другому юзеру происходит БЕЗ комиссии (с обычного юзера снимается комиссия). В Лотерее с <b>Джекпот: VIP на месяц</b>, 
	не принимает участия, автоматически запрещено покупать билет.</td></tr>
<tr><td class="embedded" colspan="3"><hr/></td></tr>
<tr><td class="embedded"><div align="center" valign="middle"><b><font color="red">Модератор</font></b></div></td>
<td class="embedded" width="5">&nbsp;</td>
<td class="embedded" valign="middle">Назначаются Администрацией и имеют функции модераторов и заслуженных релизеров.</td>
</tr><tr><td class="embedded" colspan="3"><hr/></td></tr><tr>
<td class="embedded"><div align="center" valign="middle"><b><font color="#339900">Администратор</font></b> и <b><font color="0F6CEE">Директор</font></b></div></td>
<td class="embedded" width="5">&nbsp;</td><td class="embedded" valign="middle">Администрация ресурса</td></tr>
<tr><td class="embedded" colspan="3"><hr/></td></tr>
<tr><td class="embedded"><div align="center" valign="middle"><b><font color="#808000">Владелец</font></b></div></td><td class="embedded" width="5">&nbsp;</td>
<td class="embedded" valign="middle">Владелец ресурса, тот кто создал данный проект. Тратит на поддержание все что нажито непосильным трудом и кровушку последнюю... до самой последней капелюшечки. Цените это и молитесь на него! *больших портретов не надо, просто мысленно не посылайте его в Далекую галлактику...</td></tr>
<tr><td class="embedded" colspan="3"><hr/></td></tr></table><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="14"></a> <b>Почему мои знакомые не могут зарегистрироваться?</b><br/>
Значит превышен лимит пользователей.
Аккаунты, неактивные в течении нескольких месяцев, автоматически удаляются, так что пусть попробуют позже.
(У нас нет системы резервирования мест, или очереди, не спрашивайте нас об этом!)</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="15"></a> <b>Как мне добавить аватар в свой профиль?</b><br/>
Для начала найдите картинку, которая вам понравится, и подходящую под
<a class="altlink" href="rules">правила</a>. Потом перейдите в <a class="altlink" href="usercp">профиль</a> и выберите аватар на своем компьютере. Загрузите его на сайт, он сразу появится в вашем профиле.<br/>
<br/><a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="17"></a> <b>А что это за значки <img src="pic/bril.gif" border="0"> или <img src="pic/golden.gif" border="0"> или <img src="pic/silvers.gif" border="0"> около торрентов в списке?</b><br/>
Значок <img src="pic/bril.gif" border="0"> означает, что торрент "Бриллиантовый". То есть, если вы будете его качать, у вас не будет учитываться количество скачанной информации, а количество отданного УДВАИВАЕТСЯ!<br/>
Значок <img src="pic/golden.gif" border="0"> означает, что торрент "Золотой", то есть если вы будете его качать, у вас будет считаться только количество розданной информации. Все, что вы скачаете на этом торренте не будет записано в глобальную статистику.<br/>
Значок <img src="pic/silvers.gif" border="0"> означает, что раздача серебряная: учитывается 50% закачки и 100% раздачи. Серебро по умолчанию дается всем Blu-ray дискам в коллекции трекера.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="18"></a> <b>А что это за значок <img src="pic/warned.gif" border="0"> рядом с моим ником?</b><br/>
Этот значок означает, что вы получили предупреждение за нарушение правил трекера. Причина предупреждения, его длительность, а также имя пользователя, который поставил вам его, посылается вам в ЛС. Также предупреждение накладывает на вас некоторые ограничения: <li>1) Вы не можете качать более одного торрента за один раз</li><li>2) Вы не можете комментировать релизы, ставить людям респекты или антиреспекты</li><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="19"></a> <b><font color="red">Как мне защитить свой профиль от просмотра других юзеров?</font></b><br/>
Переходите по ссылке в меню навигации <a href="usercp"><b>Профиль</b></a> и выбираете пункт <a href="usercp_security"><b>Настройки защиты</b></a> (по умолчанию для новых пользователей эти пункты уже включены):<br/>
<li>1) <b>"Аккаунт припаркован"</b> : можно припарковать аккаунт сроком на полных 300 дней, для класса ниже чем <b><font color=Indigo>1080р</font></b> (этот класс не нуждается в парковке, он не удаляется системой от бездействия). То-есть, к примеру вы уехали, не пользуютесь и хотите чтобы аккаунт сохранился за вами в период бездействия. Во время "парковки" аккаунту недоступны просмотр деталей релизов, общая страница 
<a href="browse"><b>Релизов</b></a> нашего сайта и многое другое. Однако мы сняли ограничение на Чатик (на главной страничке), вы сможете общаться с юзерами, будучи с припаркованным профилем.</li>
<li>2) <b>"Скрыть профиль"</b> : вы можете полностью скрыть страницу вашего профиля от просмотра других юзеров, но администрация сайта по прежнему будет видеть всю информацию на ней.</li>
<li>3) <b>"Скрыть раздачи"</b> : вы можете скрыть в профиле (если не хотите полностью закрывать свою страничку) текущие ваши раздачи (сидируемые). Для юзеров ниже классом чем Модератор, они не будут видны. Так-же скрывается с заменой на системного бота (System) и ваш логин в списке сидов деталей релиза. То-есть, никто больше не увидит нигде, что вы раздаете на нашем сайте.</li>
<li>4) <b>"Скрыть скачанные"</b> : вы можете скрыть в профиле (если не хотите полностью закрывать свою страничку) ваши скачанные раздачи. Для юзеров ниже классом чем Модератор, они не будут видны. Так-же скрывается с заменой на системного бота (System) и ваш логин в списке скачавших деталей релиза. То-есть, никто больше не увидит нигде, что вы скачали на нашем сайте.</li>
<li>5) <b>"Скрыть релизы"</b> : вы можете скрыть в профиле (если не хотите полностью закрывать свою страничку и отдавать авторство релиза системному боту) ваши залитые на сайт релизы. Для юзеров ниже классом чем Модератор, они не будут видны. Так-же скрывается с заменой на системного бота (System) и ваш логин как автора в деталях релиза. То-есть, никто больше не увидит нигде, что вы залили на нашем сайте.</li>
<li>6) <b>"Скрыть приглашенных"</b> : вы можете скрыть в профиле (если не хотите полностью закрывать свою страничку) список приглашенных вами пользователей. Для юзеров ниже классом чем Модератор, они не будут видны.</li>
<li>7) <b>"Скрыть кто пригласил"</b> : вы можете скрыть в профиле (если не хотите полностью закрывать свою страничку) логин пригласившего вас пользователя. Для юзеров ниже классом чем Модератор, он не будет виден.</li></td></tr></table>								 
<h2>Статистика</h2>
<table width="100%" cellspacing="0" cellpadding="3"><tr><td>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="20"></a> <b>Почему пишет мне: <font color="blue">"Поднимите рейтинг! Вы можете скачать этот релиз только через *** часов"?</font></b><br/>
<li>Если у вас рейтинг меньше <font color="green"><b>0.5</b></font> и скачано меньше <font color="blue"><b>11 GB</b></font>, то время ожидания для вас = <font color="red"><b>48 часов</b></font></li>
<li>Если у вас рейтинг меньше <font color="green"><b>0.65</b></font> и скачано меньше <font color="blue"><b>20 GB</b></font>, то время ожидания для вас = <font color="red"><b>24 часа</b></font></li>
<li>Если у вас рейтинг меньше <font color="green"><b>0.8</b></font> и скачано меньше <font color="blue"><b>30 GB</b></font>, то время ожидания для вас = <font color="red"><b>12 часов</b></font></li>
<li>Если у вас рейтинг меньше <font color="green"><b>0.95</b></font> и скачано меньше <font color="blue"><b>40 GB</b></font>, то время ожидания для вас = <font color="red"><b>6 часов</b></font></li>
<li>При рейтинге <font color="green"><b>1.0</b></font> время ожидания <font color="red"><b>ОТСУТСТВУЕТ</b></font></li><b>Поэтому вам нужно внимательно следить за рейтингом, чтобы не было ожидания скачки релиза.</b><br><br>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="21"></a> <b>Наиболее часто встречающиеся причины необновления статистики.</b><br/>
1) Юзер - читер. Используется специальная версия клиента с возможностью раздавать в никуда виртуальным юзерам и нечестно повышать показатели аплоада (ака &quot;Быстрый Бан&quot;)</li><br/>
2) Сервер перегружен и не отвечает. Просто постарайтесь продержать сессию открытой, пока сервер не заработает снова.
        (Зафлуживание сервера путём переодического ручного обновления страницы не рекомендуется.)</li><br/>
3) У вас были проблемы с доступом в Сеть и ваш торрент-клиент не передал данные нашим серверам. Либо же Вы используете неисправный торрент-клиент (хотите использовать экспериментальную версию - используйте её на свой страх и риск).</a></li><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="22"></a> <b>Полезные советы.</b><br/>
1) Если торрент, который вы скачиваете/раздаёте, не отображен в списке ваших закачек просто подождите, или обновите страницу вручную.</li><br/>
2) Убедитесь, что вы правильно закрыли ваш клиент, и трекер получил &quot;event=completed&quot;.</li><br/>
3) Если сервер трекера не отвечает, а сайт временно недоступен и "лежит" - не прекращайте раздачу. Мы максимально оперативно устраняем все технические неполадки и если сервер заработает до того, как вы закроете свой торрент-клиент - статистика обновится автоматически.</li><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="24"></a> <b>Почему торрент, который я скачиваю/раздаю, отображается несколько раз в моем профиле?</b><br/>
Если по некоторым причинам (например, экстренная перезагрузка компьютера, или зависание клиента) ваш клиент завершил работу некорректно,
и вы перезапустили его, вам будет выдан новый &quot;peer_id&quot;, таким образом ваша закачка будет опознана, как новый(другой) торрент.
А по старому торренту сервер так никогда и не получит &quot;event=completed&quot; или &quot;event=stopped&quot;,
и будет отображать его некоторое время в списке ваших активных торрентов.
Не обращайте на это внимания, в конечном счете глюк пропадет.</li><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="25"></a> <b>Я закончил или отменил торрент. Почему в моем профиле он все ещё отображается?</b><br/>
Некоторые клиенты не отправляют серверу сообщение о прекращении или отмене торрента.
В таких случаях трекер будет ждать сообщения от вашего клиента, и отображать что вы скачиваете или раздаете ещё некоторое время.<br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="26"></a> <b>Почему иногда в моем профайле присутствуют торренты, которые я никогда не качал!?</b><br/>
Когда запускается торрент-сессия трекер использует passkey для опознания пользователя.
Возможно кто-то украл/узнал ваш пасскей. Обязательно смените его у себя <a href="usercp" class="altlink">профиле</a> если вдруг обнаружите такое. После смены пасскея следует перекачать все активные торренты.<br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="27"></a> <b>Несколько IP (Могу ли я логинится с разных компьютеров)?</b><br/>
Да, трекер поддерживает несколько сессий с разных IP для одного пользователя.
Торрент ассоциируется с пользователем в тот момент, когда он стартует закачку, и только в этот момент IP важен.
Таким образом, если вы хотите скачивать/раздавать с компьютера А и компьютера
Б, используя один и тот же аккаунт, вам необходимо залогиниться на сайт с компьютера А,
запустить торрент, и затем проделать то же самое с компьютера Б (2 компьютера использовано только для примера,
ограничений на количество нет. Главное - выполнять оба шага на каждом из компьютеров).
Вам не нужно перелогиниваться заново, когда вы закрываете клиент.<br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="28"></a> <b>Как NAT/ICS может испортить малину?</b><br/>
 В случае использования NAT вам необходимо настроить различные диапазоны для торрент-клиентов на разных компьютерах,
 и создать NAT правила в роутере. (Подробности настройки роутеров выходят за рамки данного FAQ`а,
 поэтому обратитесь к документации к вашему девайсу и/или на форум техподдержки).
 За ошибки, связанные с работой за NAT`ом, администрация ответственности не несет.*</a><br/><br/></td></tr></table>				 
<h2>Заливка (Uploading)/Сидирование/Раздача релизов <?=$SITENAME;?> на других ресурсах</h2>
<table width="100%" cellspacing="0" cellpadding="3"><tr><td>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="30"></a> <b>Кто может заливать релизы на <?=$SITENAME;?>?</b><br/>
Только администрация и команда клуба (аплоадеры и VIP) имеют право заливать торренты.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="31"></a> <b>Что мне надо сделать, чтобы стать Аплодером?</b><br/>
Напишите в личку кому-то из Администрации. Расcкажите кратко о себе, сообщите о ваших навыках в работе над видео, аудио и субтитрами, поведайте нам, что можете предложить из релизов. Учтите, что на трекере <?=$SITENAME;?> фильмы делают только проверенные люди из команды клуба или опытные дружественные релизеры Рунета!
Любые релизы с русс или укр озвучкой с других трекеров мы не берем! Все иное - в Предложения - 25 голосов - оформляете и вперед на раздачу!
Все загруженные релизы спустя 2 недели карантина попадают в "вечное хранилище" и могут быть изменены только по решению администрации ресурса</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="32"></a> <b>Могу ли я раздавать ваши торренты на других трекерах?</b><br/>
Да, но с рядом ограничений. У нас элитарное сообщество пользователей. 
Размещение наших релизов на других трекерах возможно при условии, что вы указываете первоисточник <?=$SITENAME;?> (упоминаете текстом или вставляете кнопку клуба) и раздача не принадлежит к разряду запрещенных (об этом четко говорится большими красными буквами в нижней части оформления). Запрещена раздача пересобранных релизов от <?=$SITENAME;?>, а также использование наших аудидорожек без указания авторства. Нарушители без всяких предупреждений получают пожизненный бан - неуважения к своему (и какому-либо) труду мы неприемлем.
<br/><b>Вы можете пользоваться скачанным контентом в личных целях как вам угодно (НО без продажи третьим лицам).</b></a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="33"></a> <b>Как помочь с раздачей, как продолжить сидирование уже скачанного материала?</b><br/>
В случае, если вы хотите продолжить сидирование, но удалили торрент файл или задание из клиента и если файл/папка только перемещен(а) и не был переименован(а),
то вам надо скачать торрент-файл из раздачи и указать в качестве места для сохранения местоположение этого файла/папки.
Клиент проведет хеш-проверку и встанет на сид.<br/>
Если файл или папка были переименованы, то вам надо переименовать их в соответствии с оригинальной раздачей и провести манипуляции, указанные выше.
<br/>Если вы хотите помочь с раздачей и вам кажется, что у вас точно такой же файл (файлы) как у раздающего, то сначала надо проверить их размер.
Зайдите на страницу с раздачей и проверьте каков размер раздачи, затем проверьте размер своего файла (файлов) и, если размеры совпадают байт в байт, то переименуйте свой файл (файлы) в соответствии с оригинальной раздачей, скачайте торрент-файл для раздачи,
 укажите в клиенте в качестве места для сохранения местоположение ваших файлов. Клиент проведет хеш-проверку и встанет на сид.</a><br/><br/>
</td></tr></table>								 
<h2>Скачивание (Downloading)</h2><table width="100%" cellspacing="0" cellpadding="3"><tr><td>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="37"></a> <b>Как можно продолжить скачивание/раздачу, если торрента нет в списке в моём клиенте (из-за глюка, или из-за смены клиента, и т.д.)?</b><br/>
Откройте *.torrent файл. Когда ваш клиент спросит куда сохранять - выберите путь к уже существующим файлам. Скачивание продолжиться дальше.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="38"></a> <b>Почему мои загрузки иногда останавливаются на 99%?</b><br/>
 У вас уже скачано достаточно большое количество частей, и клиент пытается найти пользователей,
у которых есть части, которые у вас не скачаны, или скачаны с ошибками. Поэтому загрузка иногда может останавливаться в тот момент,
когда до завершения осталось всего несколько процентов. Потерпите немножко, и в скором (ну или не очень :) )
времени клиент докачает все недостающие части. </a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="39"></a> <b>Что значит сообщение &quot;a piece has failed an hash check&quot;?</b><br/>
Торрент-клиенты проверяют принятые данные на целостность.
Когда часть закачана с ошибками она автоматически загружается заново.
Это происходит практически у всех, так что не беспокойтесь.
В некоторых клиентах есть возможность автоматически игнорировать пользователей, которые присылают вам части с ошибками.
Если вы хотите, чтобы в дальнейшем вы не принимали частей от этого пользователя,
вам необходимо активизировать данную функцию в вашем клиенте.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="40"></a> <b>Размер торрента 1500Мб. Как я мог скачать 1800Мб?</b><br/>
Смотрите предыдущий пункт. Если ваш клиент получил часть с ошибками, он перезакачает её.
Таким образом, общее количество скачанного может быть больше, чем размер торрента.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="42"></a> <b>Что такое "IOError - [Errno13] Permission denied"?</b><br/>
Если вы просто хотите решить эту проблему - перезагрузите компьютер, это должно помочь.
Любопытным читать дальше.<br/><br/>
IOError означает ошибку Ввод-Вывода, и это ошибка вашей системы (компьютера), а не трекера.
Она выскакивает, когда клиент по некоторым причинам не может открыть скачанные файлы.
Наиболее вероятная причина - запущенные одновременно 2 клиента: это может происходить,
например, если вы закрыли клиент, но на самом деле он не закрылся, и продолжал работать в фоне, затем вы запустили вторую копию клиента,
но первый всё ещё блокирует файлы, второй не может получить к ним доступ, и выкидывает вам эту ошибку.<br/><br/>
Наиболее редкий случай - это нарушение FAT-таблицы вашей файловой системы,
что может привести к нечитабельности загруженных файлов. Соответственно, будет выскакивать такая ошибка.
(Это может произойти, если вы используете FAT. NTFS более надёжная файловая система, и не должна приводить к таким ошибкам).</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="44"></a> <b>А почему у меня вообще ничего не качается, хотя я использую нормальный клиент?</b><br/>
Возможно вы используете один из забаненых клиентов.
Если забанены только конкретные версии вашего клиента, то вы можете обновить ваш клиент до последней версии и снова продолжать качать.
Если вы используете клиент, все версии которого забанены, то вам придется сменить клиент, иначе вы не сможете ничего скачать с нашего трекера.</a><br/><br/>
</td></tr></table>								 
<h2>Как я могу увеличить мою скорость?</h2><table width="100%" cellspacing="0" cellpadding="3"><tr><td>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="45"></a> <b>Не набрасывайтесь на новые торренты</b><br/>
Особенно, если у вас медленная скорость. Дайте скачать в первую очередь людям с широкими каналами,
которые потом будут раздавать это, в том числе и вам. Наилучшее время для скачивания находится ближе к середине раздачи торрента, именно в этот момент SLR достигает своего апогея,
и вы можете качать с максимальной скоростью. (Однако в этом случае у вас не будет возможности раздавать так долго,
как если бы вы скачали данный файл с самого начала. Вот вам задачка: необходимо балансировать между этими 2мя критериями :)</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="46"></a> <b>Настройте свои железки на нормальное подключение</b><br/>
Смотрите пункт <i>Почему написано, что я не могу подключиться? (В графе Доступен написано Нет)(И о чем мне надо позаботиться?)</i></a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="47"></a> <b>Ограничьте свою скорость раздачи</b><br/>
Скорость раздачи может негативно сказываться на скорости загрузки в двух случаях:<br/>
<ul>
    <li>Торрент участники имеют тенденции к тому, чтобы поощрять тех, кто им раздаёт.
    Это означает, что если А и Б скачивают один и тот же файл, и А отсылает данные Б с высокой скоростью,
    тогда Б будет стараться поделиться тоже. Таким образом высокая скорость раздачи ведёт к высокой скорости загрузки.
    </li>

    <li>Однако, когда А загрузил что-то с Б, он должен сказать Б, что посланные данные были успешно получены.
    (Это называется подтверждения(acknowledgements) - ACKs - это один из видов сообщения "получено!").
    Если А не смог отправить такой ответ Б, тогда он (Б) приостановит раздачу ему (А) и будет ждать.
    Если А раздаёт на полной скорости, может случиться так, что подтверждения
    (ACKs) будут задерживаться. Таким образом раздача на полной скорости приведёт к снижению скорости загрузки.</li>
</ul>
Наилучшего результата вы достигнете, балансируя между этими 2мя пунктами.
Скорость аплоада должна быть максимально высокой, при которой ACKs проходят без задержек.
<b>Наилучший вариант - это ограничить вашу скорость аплоада до 80% от теоретически возможной.</b>
Однако вам может понадобиться более точная настройка, которая будет наилучшим вариантом именно в вашем случае.
(Помните, что поддержание высокой скорости раздачи положительно сказывается на вашем рейтинге(ratio)).</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="50"></a> <b>Подождите немного</b><br/>
Как описано выше, другие участники стараются в первую очередь делиться с теми, кто им раздаёт.
Когда вы только начинаете скачивать новый файл, у вас нечего предложить другим участникам, и они будут игнорировать вас.
Это приведёт к тому, что в начале загрузки скорость будет достаточно низкой, особенно, если не соединены ни с одним или с очень
малым количеством сидеров.
Скорость загрузки должна увеличиться как только у вас появятся несколько частей для раздачи.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="51"></a> <b>Почему страницы так медленно открываются, когда я качаю что-то?</b><br/>
Ваша скорость загрузки имеет конечное значение (зависит от вашего провайдера, тарифа и т.д. и т.п.).
Если вы участник быстрого торрента это привидёт к тому, что ваш канал будет загружен по максимуму,
и соответственно серфинг будет очень медленным. Однако, вы можете ограничить скорость загрузки в вашем клиенте.
А также вы можете использовать другие программы для ограничения загрузки канала
определённой программой, например при помощи <a class="altlink" href="redirect.php?url=http://www.netlimiter.com/">NetLimiter</a>.</a><br/><br/>
</td></tr></table>								 
<h2>Мой провайдер использует прокси. Что мне делать?</h2><table width="100%" cellspacing="0" cellpadding="3"><tr><td>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="52"></a> <b>Что такое прокси (proxy)?</b><br/>
Можно сказать, что это посредник. Когда вы серфите по интернету, прокси-сервер получает ваш запрос,
и перенаправляет его на сайт, к которому вы хотите подключиться.
Бывает несколько классов прокси (терминология далека от стандартной):<br/><br/>
<table cellspacing="3" cellpadding="0"><tr>
<td class="embedded" valign="top" bgcolor="#E6E9ED" width="100">&nbsp; Прозрачные</td><td class="embedded" width="10">&nbsp;</td>
<td class="embedded" valign="top">Прозрачные прокси не требуют настроек клиентов. Они работают путём автоматического перенаправления траффика с 80го порта на прокси. (Иногда используется как синоним не анонимных прокси.)</td>
</tr><tr><td class="embedded" valign="top" bgcolor="#E6E9ED">&nbsp; Явные/Бесплатные</td><td class="embedded" width="10">&nbsp;</td>
<td class="embedded" valign="top">Вы должны настроить свой браузер, чтобы использовать их.</td>
</tr><tr><td class="embedded" valign="top" bgcolor="#E6E9ED">&nbsp; Анонимные</td><td class="embedded" width="10">&nbsp;</td>
<td class="embedded" valign="top">Данный тип прокси не отсылает данные по клиенту на сервер (заголовок HTTP_X_FORWARDED_FOR не отсылается; и сервер не видит ваш IP.)</td>
</tr><tr><td class="embedded" valign="top" bgcolor="#E6E9ED">&nbsp; Очень анонимные</td><td class="embedded" width="10">&nbsp;</td>
<td class="embedded" valign="top">Прокси не посылает на сервер ни информации о клиенте, ни инофрмации о прокси (заголовки HTTP_X_FORWARDED_FOR, HTTP_VIA и HTTP_PROXY_CONNECTION не отсылаются; сервер не видит ваш IP и не знает что вы используете прокси).</td>
</tr><tr><td class="embedded" valign="top" bgcolor="#E6E9ED">&nbsp; Публичные</td><td class="embedded" width="10">&nbsp;</td>
<td class="embedded" valign="top">(Разберите этот вопрос самостоятельно :) )</td></tr></table><br/>
Прозрачные прокси могут быть, а могут и не быть анонимными. В свою очередь анонимные прокси имеют несколько уровней анонимности.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="53"></a> <b>Как обнаружить, что я сижу за прокси?</b><br/>
Попробуйте <a href="redirect.php?url=http://proxyjudge.org" class="altlink">ProxyJudge</a>. Он выдаст вам HTTP заголовки, которые получил сервер от вас.
Самые важные - это HTTP_CLIENT_IP, HTTP_X_FORWARDED_FOR и REMOTE_ADDR.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="54"></a> <b>Почему написано, что невозможно подключится, хотя я не использую NAT/firewall</b><br/>
Наш трекер достаточно сообразительный относительно вопроса определения вашего реального IP,
однако, ему необходимо, чтобы прокси отсылал заголовок HTTP_X_FORWARDED_FOR. Если прокси вашего провайдера этого не
делает - происходит следующее: трекер интерпретирует IP прокси, как ваш собственный. И когда вы пытаетесь зайти на трекер,
он пытается соединится с вашим клиентом, чтобы определить, сидите ли вы за NAT/firewall, однако на самом деле он коннектиться к
прокси-серверу, по порту, который вы указали в своём клиенте. Т.к. прокси ничего не принимает по данному порту, соединение
не будет установлено, и трекер будет думать, что вы за НАТ.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="55"></a> <b>Можно ли обойти прокси моего провайдера?</b><br/>
Если ваш провайдер разрешает только HTTP траффик через 80й порт, или блокирует стандартные прокси-порты,
тогда попробуйте что-то вроде этого <a href="redirect.php?url=http://www.socks.permeo.com">socks</a>.
Данный вопрос выходит далеко за пределы данного FAQ.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="56"></a> <b>Как сделать, чтоб мой торрент-клиент использовал прокси?</b><br/>
Когда вы настраиваете прокси для Internet Explorer`a, вы фактически настраиваете прокси для всего http-траффика
 (скажите спасибо Microsoft, и за то что их IE является частью операционной системы).
С другой стороны, если вы используете другой браузер (Opera/Mozilla/Firefox и т.д.)
и настраиваете в нем прокси - эти настройки будут действовать только на этот браузер.
Мы не знаем торрент клиенты, позволяющие настраивать прокси только для себя.</a><br/><br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="57"></a> <b>Почему я не могу зарегистрироваться из под прокси?</b><br/>
У нас такие правила - мы не позволяем создавать новые аккаунты из-под прокси.</a><br/><br/></td></tr></table>								 
<h2>Почему я не могу залогиниться? Меня заблокировали?</h2><table width="100%" cellspacing="0" cellpadding="3"><tr><td>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="59"></a> <b>Может мой IP занесён в черный список?</b><br/>
Наш сайт блокирует все IP, занесенные в базу забаненных пользователей. Это работает на уровне Apache/PHP и представляет
из себя обычный скрипт, который блокирует <i>логины</i> с этих адресов. Хотя не блокирует низкоуровневые протоколы,
вам необходимо попытаться сделать ping/traceroute. Если они не проходят, значит причина не в бане.<br/>
<a href="#top"><img src="pic/arrowups.gif" border="0"></a><a name="60"></a> <b>Ваш провайдер блокирует адрес нашего сайта.</b><br/>
(Прежде всего, маловероятно, что ваш провайдер делает это. Чаще бывают виноваты DNS-сервера, и/или временные (или постоянные :) ) проблемы с вашей сетью/настройками).
Помните, что вы будете всё время отображены, как не подключенный, потому что трекер не сможет проверить принимает ли ваш клиент входящие соединения.</a><br/><br/>
</td></tr></table><p align="right"><font size="1" color="#004E98"><b>ЧаВо отредактирован 31-08-2019 (23:00 GMT+2)</b></font></p>
</td></tr></table><?end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>