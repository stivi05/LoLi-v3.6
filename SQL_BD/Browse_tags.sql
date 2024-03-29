CREATE TABLE IF NOT EXISTS `browse` (
  `id` mediumint(7) unsigned NOT NULL,
  `name` varchar(175) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `category` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `incategory` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `reliz` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comments` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `leechers` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `remote_leechers` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `seeders` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `remote_seeders` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `owner` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `free` enum('bril','yes','silver','no') DEFAULT 'no',
  `not_sticky` enum('yes','no') NOT NULL DEFAULT 'yes',
  `multitracker` enum('yes','no') NOT NULL DEFAULT 'no',
  `dostup` enum('adm','mod','upl','vip','uhd','1080p','user') NOT NULL DEFAULT 'mod',
  `updatess` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `browse`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `owner` (`owner`,`id`) USING BTREE,
  ADD UNIQUE KEY `name_id` (`name`,`id`) USING BTREE,
  ADD UNIQUE KEY `multitracker_added` (`multitracker`,`added`) USING BTREE,
  ADD UNIQUE KEY `incategory_added` (`incategory`,`added`) USING BTREE,
  ADD UNIQUE KEY `reliz_added` (`reliz`,`added`) USING BTREE,
  ADD UNIQUE KEY `name_added` (`name`,`added`) USING BTREE,
  ADD UNIQUE KEY `category_added` (`category`,`added`) USING BTREE,
  ADD UNIQUE KEY `added` (`added`),
  ADD UNIQUE KEY `free_added` (`free`,`added`) USING BTREE,
  ADD KEY `size` (`size`) USING BTREE,
  ADD KEY `dostup` (`dostup`) USING BTREE,
  ADD KEY `updatess` (`updatess`) USING BTREE,
  ADD KEY `seeders_id` (`seeders`,`id`) USING BTREE,
  ADD KEY `id_dostup_owner` (`id`,`dostup`,`owner`) USING BTREE,
  ADD KEY `remote_seeders_id` (`remote_seeders`,`id`) USING BTREE,
  ADD KEY `remote_leechers_id` (`remote_leechers`,`id`) USING BTREE,
  ADD KEY `seeders_added` (`seeders`,`added`) USING BTREE,
  ADD KEY `leechers_seeders` (`leechers`,`seeders`),
  ADD FULLTEXT KEY `description` (`description`);

ALTER TABLE `browse`
  MODIFY `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT;
