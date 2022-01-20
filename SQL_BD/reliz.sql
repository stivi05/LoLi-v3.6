CREATE TABLE IF NOT EXISTS `reliz` (
  `id` tinyint(1) unsigned NOT NULL,
  `sort` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(12) NOT NULL DEFAULT '',
  `image` varchar(12) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `reliz`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`sort`,`id`,`name`) USING BTREE;

ALTER TABLE `reliz`
  MODIFY `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
  
