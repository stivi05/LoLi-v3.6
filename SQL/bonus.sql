CREATE TABLE IF NOT EXISTS `bonus` (
  `id` tinyint(2) NOT NULL,
  `name` varchar(140) NOT NULL,
  `points` decimal(12,0) NOT NULL DEFAULT '0',
  `description` varchar(90) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'traffic',
  `quanity` bigint(20) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

INSERT INTO `bonus` (`id`, `name`, `points`, `description`, `type`, `quanity`) VALUES
(1, '<img border="0" src="pic/arrowup.gif" title="1.0GB Uploaded"> 1.0GB Uploaded', 350, 'Обменять бонусы на траффик.', 'traffic', 1073741824),
(2, '<img border="0" src="pic/arrowup.gif" title="2.5GB Uploaded"> 2.5GB Uploaded', 800, 'Обменять бонусы на траффик.', 'traffic', 2684354560),
(3, '<img border="0" src="pic/arrowup.gif" title="5.0GB Uploaded"> 5GB Uploaded', 1500, 'Обменять бонусы на траффик.', 'traffic', 5368709120),
(4, '<img border="0" src="pic/arrowup.gif" title="10GB Uploaded"> 10GB Uploaded', 2800, 'Обменять бонусы на траффик.', 'traffic', 10737418240),
(5, '<img border="0" src="pic/arrowup.gif" title="25GB Uploaded"> 25GB Uploaded', 6800, 'Обменять бонусы на траффик.', 'traffic', 26843545600),
(6, '<img border="0" src="pic/arrowup.gif" title="50GB Uploaded"> 50GB Uploaded', 12000, 'Обменять бонусы на траффик.', 'traffic', 53687091200),
(7, '<img border="0" src="pic/arrowup.gif" title="100GB Uploaded"> 100GB Uploaded', 20000, 'Обменять бонусы на траффик.', 'traffic', 107374182400),
(8, '<img border="0" src="pic/arrowup.gif" title="500GB Uploaded"> 500GB Uploaded', 90000, 'Обменять бонусы на траффик.', 'traffic', 536870912000),
(9, '<img border="0" src="pic/arrowdown.gif" title="-1.0GB Downloaded"> - 1.0GB Downloaded', 350, 'Обменять бонусы на траффик.', 'traffics', 1073741824),
(10, '<img border="0" src="pic/arrowdown.gif" title="-2.5GB Downloaded"> - 2.5GB Downloaded', 800, 'Обменять бонусы на траффик.', 'traffics', 2684354560),
(11, '<img border="0" src="pic/arrowdown.gif" title="-5.0GB Downloaded"> - 5GB Downloaded', 1500, 'Обменять бонусы на траффик.', 'traffics', 5368709120),
(12, '<img border="0" src="pic/arrowdown.gif" title="-10GB Downloaded"> - 10GB Downloaded', 2800, 'Обменять бонусы на траффик.', 'traffics', 10737418240),
(13, '<img border="0" src="pic/arrowdown.gif" title="-25GB Downloaded"> - 25GB Downloaded', 6800, 'Обменять бонусы на траффик.', 'traffics', 26843545600),
(14, '<img border="0" src="pic/arrowdown.gif" title="-50GB Downloaded"> - 50GB Downloaded', 12000, 'Обменять бонусы на траффик.', 'traffics', 53687091200),
(15, '<img border="0" src="pic/arrowdown.gif" title="-100GB Downloaded"> - 100GB Downloaded', 20000, 'Обменять бонусы на траффик.', 'traffics', 107374182400),
(16, '<img border="0" src="pic/arrowdown.gif" title="-500GB Downloaded"> - 500GB Downloaded', 90000, 'Обменять бонусы на траффик.', 'traffics', 536870912000),
(17, '<img border="0" src="pic/arrowdown.gif" title="+1.0GB Downloaded"> + 1.0GB Downloaded', 700, 'Обменять бонусы на траффик.', 'trafficp', 1073741824),
(18, '<img border="0" src="pic/arrowdown.gif" title="+2.5GB Downloaded"> + 2.5GB Downloaded', 1600, 'Обменять бонусы на траффик.', 'trafficp', 2684354560),
(19, '<img border="0" src="pic/arrowdown.gif" title="+5.0GB Downloaded"> + 5GB Downloaded', 3200, 'Обменять бонусы на траффик.', 'trafficp', 5368709120),
(20, '<img border="0" src="pic/arrowdown.gif" title="+10GB Downloaded"> + 10GB Downloaded', 6600, 'Обменять бонусы на траффик.', 'trafficp', 10737418240),
(21, '<img border="0" src="pic/arrowdown.gif" title="+25GB Downloaded"> + 25GB Downloaded', 17200, 'Обменять бонусы на траффик.', 'trafficp', 26843545600),
(22, '<img border="0" src="pic/arrowdown.gif" title="+50GB Downloaded"> + 50GB Downloaded', 34800, 'Обменять бонусы на траффик.', 'trafficp', 53687091200),
(23, '<img border="0" src="pic/arrowdown.gif" title="+100GB Downloaded"> + 100GB Downloaded', 69500, 'Обменять бонусы на траффик.', 'trafficp', 107374182400),
(24, '<img border="0" src="pic/arrowdown.gif" title="+500GB Downloaded"> + 500GB Downloaded', 349000, 'Обменять бонусы на траффик.', 'trafficp', 536870912000),
(25, '<img border="0" src="pic/arrowdown.gif" title="+1TB Downloaded"> + 1TB Downloaded', 696000, 'Обменять бонусы на траффик.', 'trafficp', 1073741824000),
(26, '<img border="0" src="pic/class/vip.gif" title="VIP на 30 дней"> VIP на 30 дней', 3800000, 'Обменять бонусы на ВИП-статус на 30 дней.', 'vip', 30),
(27, '<img border="0" src="pic/class/vip.gif" title="VIP на 90 дней"> VIP на 90 дней', 10000000, 'Обменять бонусы на ВИП-статус на 90 дней.', 'vip', 90),
(28, '<img border="0" src="pic/class/vip.gif" title="VIP на 6 месяцев"> VIP на 6 месяцев', 20000000, 'Обменять бонусы на ВИП-статус на 6 месяцев.', 'vip', 183),
(29, '<img border="0" src="pic/class/vip.gif" title="VIP на 1 год"> VIP на 1 год', 38000000, 'Обменять бонусы на ВИП-статус на 1 год.', 'vip', 364),
(30, '<img border="0" src="pic/class/uploader.gif" title="Релизер на 1 день"> Релизер на 1 день', 120000, 'Обменять бонусы на статус Релизер на 1 день.', 'upl', 1),
(31, '<img border="0" src="pic/class/uploader.gif" title="Релизер на 30 дней"> Релизер на 30 дней', 3000000, 'Обменять бонусы на статус Релизер на 30 дней.', 'upl', 30),
(32, '<img border="0" src="pic/class/admin.gif" title="Админ на 1 день"> Админ на 1 день! Собери миллиард и стань Администратором ресурса!', 1000000000, 'Обменять бонусы на возможность стать Админом на 1 день.', 'adm', 1);

ALTER TABLE `bonus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`id`,`name`,`points`,`description`,`type`,`quanity`) USING BTREE;
  
ALTER TABLE `users` ADD `vipuntil` datetime NOT NULL default '0000-00-00 00:00:00';
ALTER TABLE `users` ADD `upluntil` datetime NOT NULL default '0000-00-00 00:00:00';
ALTER TABLE `users` ADD `admuntil` datetime NOT NULL default '0000-00-00 00:00:00';
ALTER TABLE `users` ADD `invtime` datetime NOT NULL default '0000-00-00 00:00:00';
ALTER TABLE `users` ADD `oldclass` tinyint(2) NOT NULL default '0';
