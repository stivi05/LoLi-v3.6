--
-- Структура таблицы `avps`
--

CREATE TABLE IF NOT EXISTS `avps` (
  `arg` varchar(20) NOT NULL DEFAULT '',
  `value_s` datetime NOT NULL,
  `value_i` int(11) unsigned NOT NULL DEFAULT '0',
  `value_u` int(10) unsigned NOT NULL DEFAULT '0',
  `work` enum('yes','no') NOT NULL DEFAULT 'no',
  `answer` varchar(100) NOT NULL DEFAULT '',
  `temp` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `bannedemails`
--

CREATE TABLE IF NOT EXISTS `bannedemails` (
  `id` tinyint(1) unsigned NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `addedby` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(12) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bannedemails`
--

INSERT INTO `bannedemails` (`id`, `added`, `addedby`, `comment`, `email`) VALUES
(1, '2019-07-14 09:36:41', 1, 'Only mail is allowed Gmail.com', '*@gmail.com');

-- --------------------------------------------------------

--
-- Структура таблицы `bans`
--

CREATE TABLE IF NOT EXISTS `bans` (
  `id` smallint(5) unsigned NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `addedby` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(150) NOT NULL DEFAULT '',
  `first` varchar(25) DEFAULT NULL,
  `haker` enum('yes','no') DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `blocks`
--

CREATE TABLE IF NOT EXISTS `blocks` (
  `id` int(10) unsigned NOT NULL,
  `userid` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `blockid` mediumint(7) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `bonus`
--

CREATE TABLE IF NOT EXISTS `bonus` (
  `id` tinyint(2) NOT NULL,
  `name` varchar(140) NOT NULL,
  `points` decimal(12,0) NOT NULL DEFAULT '0',
  `description` varchar(90) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'traffic',
  `quanity` bigint(20) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bonus`
--

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
(32, '<img border="0" src="pic/class/admin.gif" title="Админ на 1 день"> Админ на 1 день! Собери миллиард и стань Администратором ресурса!', 1000000000, 'Обменять бонусы на возможность стать Админом на 1 день.', 'adm', 1),
(33, '<img border="0" src="pic/golden.gif" title="Все в Золото на 1 день"> Все в Золото на 1 день', 6000000, 'Обменять бонусы на возможность сделать все релизы Золотыми на 1 день.', 'free', 1),
(34, '<img border="0" src="pic/golden.gif" title="Все в Золото на 1 неделю"> Все в Золото на 1 неделю', 38000000, 'Обменять бонусы на возможность сделать все релизы Золотыми на 1 неделю.', 'free', 7),
(35, '<img border="0" src="pic/bril.gif" title="Все в Бриллиант на 1 день"> Все в Бриллиант на 1 день', 10000000, 'Обменять бонусы на возможность сделать все релизы Бриллиантовыми на 1 день.', 'bril', 1),
(36, '<img border="0" src="pic/bril.gif" title="Все в Бриллиант на 1 неделю"> Все в Бриллиант на 1 неделю', 60000000, 'Обменять бонусы на возможность сделать все релизы Бриллиантовыми на 1 неделю.', 'bril', 7);

-- --------------------------------------------------------

--
-- Структура таблицы `bonuslog`
--

CREATE TABLE IF NOT EXISTS `bonuslog` (
  `id` tinyint(3) unsigned NOT NULL,
  `added` datetime DEFAULT NULL,
  `txt` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `bookmarks`
--

CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id` mediumint(7) unsigned NOT NULL,
  `userid` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `torrentid` mediumint(7) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` tinyint(1) unsigned NOT NULL,
  `sort` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(15) NOT NULL DEFAULT '',
  `image` varchar(14) NOT NULL DEFAULT '',
  `template` varchar(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `sort`, `name`, `image`, `template`) VALUES
(1, 1, 'HD Audio', 'audio.png', 'music'),
(2, 2, 'Music Video', 'mv.png', 'mv'),
(3, 3, 'Animation', 'anime.png', 'anime'),
(4, 4, 'Movie', 'movie.png', 'movies'),
(5, 5, 'TV Show', 'tvshow.png', 'serials'),
(6, 6, 'Documentary', 'docum.png', 'dokumental'),
(7, 7, 'Sport', 'sport.png', 'sport'),
(8, 8, 'Demo', 'demo.png', 'demo');

-- --------------------------------------------------------

--
-- Структура таблицы `checkcomm`
--

CREATE TABLE IF NOT EXISTS `checkcomm` (
  `id` int(11) NOT NULL,
  `checkid` mediumint(7) NOT NULL DEFAULT '0',
  `userid` mediumint(7) NOT NULL DEFAULT '0',
  `torrent` mediumint(7) NOT NULL DEFAULT '0',
  `req` mediumint(7) NOT NULL DEFAULT '0',
  `offer` mediumint(7) NOT NULL DEFAULT '0',
  `oj` tinyint(4) NOT NULL DEFAULT '0',
  `news` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `closesayt`
--

CREATE TABLE IF NOT EXISTS `closesayt` (
  `name` varchar(4) NOT NULL DEFAULT '',
  `value` varchar(1) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `closesayt`
--

INSERT INTO `closesayt` (`name`, `value`) VALUES
('clst', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` smallint(5) unsigned NOT NULL,
  `user` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `torrent` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL,
  `text_html` text NOT NULL,
  `ori_text` text NOT NULL,
  `ori_text_html` text NOT NULL,
  `editedby` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `editedat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `request` mediumint(7) NOT NULL DEFAULT '0',
  `offer` mediumint(7) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `name` varchar(6) NOT NULL DEFAULT '',
  `vibor` varchar(1) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `config`
--

INSERT INTO `config` (`name`, `vibor`) VALUES
('signup', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` tinyint(3) unsigned NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `flagpic` varchar(30) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `name`, `flagpic`) VALUES
(1, 'Sweden', 'sweden.gif'),
(2, 'USA', 'usa.gif'),
(3, 'Russia', 'russia.gif'),
(4, 'Finland', 'finland.gif'),
(5, 'Canada', 'canada.gif'),
(6, 'France', 'france.gif'),
(7, 'Germany', 'germany.gif'),
(8, 'China', 'china.gif'),
(9, 'Italy', 'italy.gif'),
(10, 'Denmark', 'denmark.gif'),
(11, 'Norway', 'norway.gif'),
(12, 'UK', 'uk.gif'),
(13, 'Ireland', 'ireland.gif'),
(14, 'Poland', 'poland.gif'),
(15, 'Netherlands', 'netherlands.gif'),
(16, 'Belgium', 'belgium.gif'),
(17, 'Japan', 'japan.gif'),
(18, 'Brazil', 'brazil.gif'),
(19, 'Argentina', 'argentina.gif'),
(20, 'Australia', 'australia.gif'),
(21, 'New Zealand', 'newzealand.gif'),
(22, 'Spain', 'spain.gif'),
(23, 'Portugal', 'portugal.gif'),
(24, 'Mexico', 'mexico.gif'),
(25, 'Singapore', 'singapore.gif'),
(26, 'India', 'india.gif'),
(27, 'Albania', 'albania.gif'),
(28, 'South Africa', 'southafrica.gif'),
(29, 'South Korea', 'southkorea.gif'),
(30, 'Jamaica', 'jamaica.gif'),
(31, 'Luxembourg', 'luxembourg.gif'),
(32, 'Hong Kong', 'hongkong.gif'),
(33, 'Belize', 'belize.gif'),
(34, 'Algeria', 'algeria.gif'),
(35, 'Angola', 'angola.gif'),
(36, 'Austria', 'austria.gif'),
(37, 'Yugoslavia', 'yugoslavia.gif'),
(38, 'Samoa', 'westernsamoa.gif'),
(39, 'Malaysia', 'malaysia.gif'),
(40, 'Dominican Republic', 'dominicanrep.gif'),
(41, 'Greece', 'greece.gif'),
(42, 'Guatemala', 'guatemala.gif'),
(43, 'Israel', 'israel.gif'),
(44, 'Pakistan', 'pakistan.gif'),
(45, 'Czech Republic', 'czechrep.gif'),
(46, 'Serbia', 'serbia.gif'),
(47, 'Seychelles', 'seychelles.gif'),
(48, 'Taiwan', 'taiwan.gif'),
(49, 'Puerto Rico', 'puertorico.gif'),
(50, 'chili', 'chile.gif'),
(51, 'Cuba', 'cuba.gif'),
(52, 'Congo', 'congo.gif'),
(53, 'Afghanistan', 'afghanistan.gif'),
(54, 'Turkey', 'turkey.gif'),
(55, 'Uzbekistan', 'uzbekistan.gif'),
(56, 'Switzerland', 'switzerland.gif'),
(57, 'Kiribati', 'kiribati.gif'),
(58, 'Philippines', 'philippines.gif'),
(59, 'Burkina Faso', 'burkinafaso.gif'),
(60, 'Nigeria', 'nigeria.gif'),
(61, 'Iceland', 'iceland.gif'),
(62, 'Nauru', 'nauru.gif'),
(63, 'Slovakia', 'slovenia.gif'),
(64, 'Turkmenistan', 'turkmenistan.gif'),
(65, 'Bosnia and Herzegovina', 'bosniaherzegovina.gif'),
(66, 'Andorra', 'andorra.gif'),
(67, 'Lithuania', 'lithuania.gif'),
(68, 'Macedonia', 'macedonia.gif'),
(69, 'Netherlands Antilles', 'nethantilles.gif'),
(70, 'Ukraine', 'ukraine.gif'),
(71, 'Venezuela', 'venezuela.gif'),
(72, 'Hungary', 'hungary.gif'),
(73, 'Romania', 'romania.gif'),
(74, 'Vanuatu', 'vanuatu.gif'),
(75, 'Vietnam', 'vietnam.gif'),
(76, 'Trinidad and Tobago', 'trinidadandtobago.gif'),
(77, 'Honduras', 'honduras.gif'),
(78, 'Kyrgyzstan', 'kyrgyzstan.gif'),
(79, 'Ecuador', 'ecuador.gif'),
(80, 'Bahamas', 'bahamas.gif'),
(81, 'Peru', 'peru.gif'),
(82, 'Cambodia', 'cambodia.gif'),
(83, 'Barbados', 'barbados.gif'),
(84, 'Bangladesh', 'bangladesh.gif'),
(85, 'Laos', 'laos.gif'),
(86, 'Uruguay', 'uruguay.gif'),
(87, 'Antigua and Barbuda', 'antiguabarbuda.gif'),
(88, 'Paraguay', 'paraguay.gif'),
(89, 'Thailand', 'thailand.gif'),
(90, 'USSR', 'ussr.gif'),
(91, 'Senegal', 'senegal.gif'),
(92, 'Togo', 'togo.gif'),
(93, 'North Korea', 'northkorea.gif'),
(94, 'Croatia', 'croatia.gif'),
(95, 'Estonia', 'estonia.gif'),
(96, 'Colombia', 'colombia.gif'),
(97, 'Lebanon', 'lebanon.gif'),
(98, 'Latvia', 'latvia.gif'),
(99, 'Costa Rica', 'costarica.gif'),
(100, 'Egypt', 'egypt.gif'),
(101, 'Bulgaria', 'bulgaria.gif'),
(102, 'Isla de Muerto', 'jollyroger.gif'),
(103, 'Moldova', 'moldova.gif'),
(104, 'Belarus', 'belarus.gif'),
(105, 'Kazakhstan', 'kazakhstan.gif'),
(106, 'Tajikistan', 'tajikistan.gif'),
(107, 'Georgia', 'georgia.gif'),
(108, 'Armenia', 'armenia.gif'),
(109, 'Azerbaijan', 'azerbaijan.gif');

-- --------------------------------------------------------

--
-- Структура таблицы `freeleech`
--

CREATE TABLE IF NOT EXISTS `freeleech` (
  `name` varchar(9) NOT NULL DEFAULT '',
  `value` enum('brill','gold','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `freeleech`
--

INSERT INTO `freeleech` (`name`, `value`) VALUES
('freeleech', 'no');

-- --------------------------------------------------------

--
-- Структура таблицы `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(10) unsigned NOT NULL,
  `userid` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `friendid` mediumint(7) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `gost`
--

CREATE TABLE IF NOT EXISTS `gost` (
  `name` varchar(4) NOT NULL DEFAULT '',
  `value` varchar(1) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `gost`
--

INSERT INTO `gost` (`name`, `value`) VALUES
('gost', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `incategories`
--

CREATE TABLE IF NOT EXISTS `incategories` (
  `id` tinyint(2) unsigned NOT NULL,
  `sort` tinyint(2) NOT NULL DEFAULT '0',
  `name` varchar(15) NOT NULL DEFAULT '',
  `image` varchar(15) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `incategories`
--

INSERT INTO `incategories` (`id`, `sort`, `name`, `image`) VALUES
(1, 1, 'Lossless', 'flac.png'),
(2, 2, 'DSD', 'dsd.png'),
(3, 3, 'DTS', 'dts.png'),
(4, 4, '720p', '720p.png'),
(5, 5, '1080i', '1080i.png'),
(6, 6, '1080p', '1080p.png'),
(7, 7, 'BD-REMUX', 'remux.png'),
(8, 8, 'Blu Ray 1080p', 'hddisc.png'),
(9, 9, 'UHD 4K UHDTV', 'uhdtv4k.png'),
(10, 10, 'UHD 4K WEB-DL', 'uhd4kweb.png'),
(11, 11, 'UHD 4K BD-Rip', 'uhdrip.png'),
(12, 12, 'UHD 4K BD-REMUX', 'uhdremux.png'),
(13, 13, 'UHD 4K Blu Ray', 'uhddisc.png'),
(14, 14, 'UHD 8K WEB-DL', 'uhd8kweb.png'),
(15, 15, 'UHD 8K MASTER', 'uhd8kmaster.png'),
(16, 16, 'UHD 16K WEB-DL', 'uhd16.png'),
(17, 17, 'Exclusive', 'exclusive.png');

-- --------------------------------------------------------

--
-- Структура таблицы `invites`
--

CREATE TABLE IF NOT EXISTS `invites` (
  `id` mediumint(7) unsigned NOT NULL,
  `inviter` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `inviteid` mediumint(7) NOT NULL DEFAULT '0',
  `invite` varchar(32) NOT NULL DEFAULT '',
  `time_invited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `confirmed` char(3) NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `inwayts`
--

CREATE TABLE IF NOT EXISTS `inwayts` (
  `name` varchar(7) NOT NULL DEFAULT '',
  `vibor` varchar(1) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `inwayts`
--

INSERT INTO `inwayts` (`name`, `vibor`) VALUES
('inwayts', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `loginattempts`
--

CREATE TABLE IF NOT EXISTS `loginattempts` (
  `id` int(10) unsigned NOT NULL,
  `ip` varchar(15) NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `banned` enum('yes','no') NOT NULL DEFAULT 'no',
  `attempts` tinyint(1) NOT NULL DEFAULT '0',
  `attemptss` tinyint(1) NOT NULL DEFAULT '0',
  `userid` mediumint(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` mediumint(7) unsigned NOT NULL,
  `sender` mediumint(7) unsigned NOT NULL,
  `sender_class` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `sender_username` varchar(20) NOT NULL DEFAULT '',
  `sender_avatar` varchar(30) NOT NULL DEFAULT '',
  `receiver` mediumint(7) unsigned NOT NULL,
  `receiver_class` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `receiver_username` varchar(20) NOT NULL DEFAULT '',
  `receiver_avatar` varchar(30) NOT NULL DEFAULT '',
  `added` datetime DEFAULT NULL,
  `subject` varchar(65) NOT NULL DEFAULT '',
  `msg` text,
  `unread` enum('yes','no') NOT NULL DEFAULT 'yes',
  `location` tinyint(1) NOT NULL DEFAULT '1',
  `saved` enum('no','yes') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` tinyint(3) unsigned NOT NULL,
  `userid` mediumint(7) NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `body` text NOT NULL,
  `subject` varchar(75) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `notconnectablepmlog`
--

CREATE TABLE IF NOT EXISTS `notconnectablepmlog` (
  `id` mediumint(7) unsigned NOT NULL,
  `user` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `online`
--

CREATE TABLE IF NOT EXISTS `online` (
  `id` tinyint(1) unsigned NOT NULL,
  `textt` varchar(6000) NOT NULL DEFAULT '',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orbital_blocks`
--

CREATE TABLE IF NOT EXISTS `orbital_blocks` (
  `bid` tinyint(2) NOT NULL,
  `bkey` varchar(15) NOT NULL DEFAULT '',
  `title` varchar(60) NOT NULL DEFAULT '',
  `content` varchar(1000) NOT NULL,
  `bposition` varchar(1) NOT NULL DEFAULT '',
  `weight` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `time` varchar(15) NOT NULL DEFAULT '0',
  `blockfile` varchar(30) NOT NULL DEFAULT '',
  `view` tinyint(3) NOT NULL DEFAULT '0',
  `expire` varchar(14) NOT NULL DEFAULT '0',
  `action` varchar(1) NOT NULL DEFAULT '',
  `which` varchar(15) NOT NULL DEFAULT '',
  `allow_hide` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orbital_blocks`
--

INSERT INTO `orbital_blocks` (`bid`, `bkey`, `title`, `content`, `bposition`, `weight`, `active`, `time`, `blockfile`, `view`, `expire`, `action`, `which`, `allow_hide`) VALUES
(14, '', '.:: <b>Навигация</b> ::.', '', 'l', 1, 1, '', 'block-menu.php', 1, '0', 'd', 'ihome,', ''),
(8, '', '.:: <b>Статистика</b> ::.', '', 'd', 6, 1, '', 'block-stats.php', 4, '0', 'd', 'ihome,', 'yes'),
(9, '', '.:: <b>Релизы, которым нужны раздающие</b> ::.', '', 'd', 2, 1, '', 'block-helpseed.php', 1, '0', 'd', 'ihome,browse,', 'yes'),
(2, '', '.:: <b>Новости</b> ::.', '', 'b', 3, 1, '', 'block-news.php', 1, '0', 'd', 'ihome,', 'yes'),
(3, '', '.:: <b>Онлайн</b> ::.', '', 'r', 1, 1, '', 'block-online.php', 2, '0', 'd', 'ihome,', 'yes'),
(5, '', '.:: <b>Опрос</b> ::.', '', 'c', 6, 0, '', 'block-poll.php', 9, '0', 'd', 'ihome,', 'yes'),
(11, '', '.:: <b>Загрузка сервера</b> ::.', '', 'd', 7, 0, '', 'block-server_load.php', 10, '0', 'd', 'ihome,', 'yes'),
(12, '', '.:: <b>Личное Меню</b> ::.', '', 'l', 2, 1, '', 'block-usermenu.php', 1, '0', 'd', 'ihome,', ''),
(16, '', '.:: <b>Комментарии</b> ::.', '', 'c', 4, 0, '', 'block-lastcomm.php', 3, '0', 'd', 'ihome,', ''),
(17, '', '.:: <b>Форум</b> ::.', '', 'c', 5, 1, '', 'block-forum.php', 1, '0', 'd', 'ihome,', ''),
(18, '', '.:: <b>Случайный релиз</b> ::.', '', 'r', 6, 0, '', 'block-randtorr.php', 1, '0', 'd', 'ihome,', ''),
(19, '', '.:: <b>День рожденья</b> ::.', '', 'd', 4, 0, '', 'block-birth.php', 2, '0', 'd', 'ihome,', ''),
(20, '', '.:: <b>Опрос-2</b> ::.', '', 'c', 7, 0, '', 'block-polls.php', 9, '0', 'd', 'ihome,', ''),
(21, '', '.:: <b>Ожидаемые релизы</b> ::.', '', 'c', 3, 0, '', 'block-ojidaemie.php', 2, '0', 'd', 'ihome,', ''),
(54, '', '<b>.:: Рекомендуемые  ::.</b>', '', 'b', 6, 1, '', 'block-recomend.php', 1, '0', 'd', 'browse,', ''),
(23, '', '<b>.:: Релиз-группы ::.</b>', '', 'r', 7, 0, '', 'block-groups.php', 1, '0', 'd', 'ihome,', ''),
(24, '', '<b>.:: Календарик ::.</b>', '', 'l', 3, 1, '', 'block-calendarik.php', 1, '0', 'd', 'ihome,', ''),
(25, '', '<b>.:: Наши Герои ::.</b>', '', 'd', 3, 0, '', 'block-heroes.php', 2, '0', 'd', 'ihome,', ''),
(27, '', '<b>.:: Клиенты ::.</b>', '', 'l', 4, 1, '', 'block-clients.php', 1, '0', 'd', 'ihome,', ''),
(30, '', '<b>.:: Онлайн и День Рождения ::.</b>', '', 'd', 5, 0, '', 'block-online-and-birthday.php', 2, '0', 'd', 'ihome,', ''),
(36, '', '<b>.:: 3D релизы ::.</b>', '', 'r', 3, 1, '', 'block-3d.php', 1, '0', 'd', 'ihome,', ''),
(33, '', '<b>.:: Посещаемость ::.</b>', '', 'l', 5, 0, '', 'block-statcount.php', 10, '0', 'd', 'ihome,', ''),
(35, '', '<b>.:: Топ 20 ::.</b>', '', 'b', 2, 0, '', 'block-topsecond.php', 1, '0', 'd', 'ihome,', ''),
(37, '', '<b>.:: UA релизы ::.</b>', '', 'r', 2, 1, '', 'block-ua.php', 1, '0', 'd', 'ihome,', ''),
(39, '', '<b>.:: WEB-DL ::.</b>', '', 'r', 4, 1, '', 'block-webdl.php', 1, '0', 'd', 'ihome,', ''),
(40, '', '.:: <b>Чатик на главной (chat4)</b> ::.', '', 'b', 4, 1, '', 'block-chat4.php', 2, '0', 'd', 'ihome,', ''),
(42, '', '.:: <b>КазИно-чат (chat_kazino)</b> ::.', '', 'd', 1, 1, '', 'block-chat_kazino.php', 2, '0', 'd', 'casino,', ''),
(46, '', '<b>.:: Топ 15 хитов ::.</b>', '', 'c', 2, 0, '', 'block-exc_releases.php', 2, '0', 'd', 'ihome,', ''),
(50, '', '<b>.:: Donate ::.</b>', '', 'r', 5, 1, '', 'block-donats.php', 1, '0', 'd', 'ihome,', ''),
(51, '', '<b>.:: Наши Релизы Memcashed ::.</b>', '', 'c', 1, 1, '', 'block-releases_memcash.php', 1, '0', 'd', 'ihome,', ''),
(53, '', '.:: <b>До Нового Года осталось</b> ::.', '', 'b', 1, 0, '', 'block-NewYear.php', 1, '0', 'd', 'ihome,', ''),
(58, '', '<b>.:: Последние 10 релизов ::.</b>', '', 'b', 5, 0, '', 'block-last_reliz.php', 1, '0', 'd', 'ihome,', '');

-- --------------------------------------------------------

--
-- Структура таблицы `peers`
--

CREATE TABLE IF NOT EXISTS `peers` (
  `id` int(10) unsigned NOT NULL,
  `torrent` int(10) unsigned NOT NULL DEFAULT '0',
  `peer_id` binary(20) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `ip` varchar(64) NOT NULL DEFAULT '',
  `port` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `uploadoffset` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloadoffset` bigint(20) unsigned NOT NULL DEFAULT '0',
  `to_go` bigint(20) unsigned NOT NULL DEFAULT '0',
  `seeder` enum('yes','no') NOT NULL DEFAULT 'no',
  `started` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `prev_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `connectable` enum('yes','no') NOT NULL DEFAULT 'yes',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `agent` varchar(64) NOT NULL DEFAULT '',
  `finishedat` int(10) unsigned NOT NULL DEFAULT '0',
  `passkey` varchar(32) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `podarki`
--

CREATE TABLE IF NOT EXISTS `podarki` (
  `id` tinyint(3) unsigned NOT NULL,
  `pic` varchar(20) DEFAULT NULL,
  `bonus` int(9) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=190 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `podarki`
--

INSERT INTO `podarki` (`id`, `pic`, `bonus`) VALUES
(1, 'pic/podarki/1.gif', 100),
(2, 'pic/podarki/10.gif', 135),
(3, 'pic/podarki/100.gif', 170),
(4, 'pic/podarki/101.gif', 205),
(5, 'pic/podarki/102.gif', 240),
(6, 'pic/podarki/103.gif', 275),
(7, 'pic/podarki/104.gif', 310),
(8, 'pic/podarki/105.gif', 345),
(9, 'pic/podarki/106.gif', 380),
(10, 'pic/podarki/107.gif', 415),
(11, 'pic/podarki/108.gif', 450),
(12, 'pic/podarki/109.gif', 485),
(13, 'pic/podarki/11.gif', 500),
(14, 'pic/podarki/110.gif', 535),
(15, 'pic/podarki/111.gif', 570),
(16, 'pic/podarki/112.gif', 605),
(17, 'pic/podarki/113.gif', 640),
(18, 'pic/podarki/114.gif', 675),
(19, 'pic/podarki/115.gif', 710),
(20, 'pic/podarki/116.gif', 745),
(21, 'pic/podarki/117.gif', 780),
(22, 'pic/podarki/118.gif', 815),
(23, 'pic/podarki/119.gif', 850),
(24, 'pic/podarki/12.gif', 900),
(25, 'pic/podarki/120.gif', 1000),
(26, 'pic/podarki/121.gif', 1000),
(27, 'pic/podarki/122.gif', 1500),
(28, 'pic/podarki/123.gif', 1500),
(29, 'pic/podarki/124.gif', 2000),
(30, 'pic/podarki/125.gif', 2000),
(31, 'pic/podarki/126.gif', 2500),
(32, 'pic/podarki/127.gif', 3000),
(33, 'pic/podarki/128.gif', 3500),
(34, 'pic/podarki/129.gif', 4000),
(35, 'pic/podarki/13.gif', 4000),
(36, 'pic/podarki/130.gif', 4500),
(37, 'pic/podarki/131.gif', 5000),
(38, 'pic/podarki/132.gif', 5500),
(39, 'pic/podarki/133.gif', 6000),
(40, 'pic/podarki/134.gif', 6500),
(41, 'pic/podarki/135.gif', 7000),
(42, 'pic/podarki/136.gif', 7500),
(43, 'pic/podarki/137.gif', 7500),
(44, 'pic/podarki/138.gif', 8000),
(45, 'pic/podarki/139.gif', 8500),
(46, 'pic/podarki/14.gif', 9000),
(47, 'pic/podarki/140.gif', 9000),
(48, 'pic/podarki/141.gif', 9500),
(49, 'pic/podarki/142.gif', 10000),
(50, 'pic/podarki/143.gif', 15000),
(51, 'pic/podarki/144.gif', 20000),
(52, 'pic/podarki/145.gif', 25000),
(53, 'pic/podarki/146.gif', 30000),
(54, 'pic/podarki/147.gif', 35000),
(55, 'pic/podarki/148.gif', 38000),
(56, 'pic/podarki/149.gif', 40000),
(57, 'pic/podarki/15.gif', 42500),
(58, 'pic/podarki/150.gif', 45500),
(59, 'pic/podarki/151.gif', 47500),
(60, 'pic/podarki/152.gif', 49999),
(61, 'pic/podarki/153.gif', 50000),
(62, 'pic/podarki/154.gif', 55000),
(63, 'pic/podarki/155.gif', 60000),
(64, 'pic/podarki/156.gif', 65000),
(65, 'pic/podarki/157.gif', 70000),
(66, 'pic/podarki/158.gif', 75000),
(67, 'pic/podarki/159.gif', 80000),
(68, 'pic/podarki/16.gif', 85000),
(69, 'pic/podarki/160.gif', 85500),
(70, 'pic/podarki/161.gif', 90000),
(71, 'pic/podarki/162.gif', 99500),
(72, 'pic/podarki/163.gif', 99999),
(73, 'pic/podarki/164.gif', 100000),
(74, 'pic/podarki/165.gif', 150000),
(75, 'pic/podarki/166.gif', 200000),
(76, 'pic/podarki/167.gif', 250000),
(77, 'pic/podarki/168.gif', 300000),
(78, 'pic/podarki/169.gif', 350000),
(79, 'pic/podarki/17.gif', 375000),
(80, 'pic/podarki/170.gif', 380000),
(81, 'pic/podarki/171.gif', 400000),
(82, 'pic/podarki/172.gif', 450000),
(83, 'pic/podarki/173.gif', 450000),
(84, 'pic/podarki/174.gif', 499000),
(85, 'pic/podarki/175.gif', 500000),
(86, 'pic/podarki/176.gif', 550000),
(87, 'pic/podarki/177.gif', 600000),
(88, 'pic/podarki/178.gif', 650000),
(89, 'pic/podarki/179.gif', 700000),
(90, 'pic/podarki/18.gif', 750000),
(91, 'pic/podarki/180.gif', 800000),
(92, 'pic/podarki/181.gif', 850000),
(93, 'pic/podarki/182.gif', 900000),
(94, 'pic/podarki/183.gif', 950000),
(95, 'pic/podarki/184.gif', 950000),
(96, 'pic/podarki/185.gif', 999000),
(97, 'pic/podarki/186.gif', 1000000),
(98, 'pic/podarki/187.gif', 1500000),
(99, 'pic/podarki/188.gif', 1500000),
(100, 'pic/podarki/189.gif', 2000000),
(101, 'pic/podarki/19.gif', 2500000),
(102, 'pic/podarki/2.gif', 3000000),
(103, 'pic/podarki/20.gif', 3500000),
(104, 'pic/podarki/21.gif', 4000000),
(105, 'pic/podarki/22.gif', 4000000),
(106, 'pic/podarki/23.gif', 4500000),
(107, 'pic/podarki/24.gif', 4500000),
(108, 'pic/podarki/25.gif', 4900000),
(109, 'pic/podarki/26.gif', 5000000),
(110, 'pic/podarki/27.gif', 5500000),
(111, 'pic/podarki/28.gif', 5555000),
(112, 'pic/podarki/29.gif', 6000000),
(113, 'pic/podarki/3.gif', 6500000),
(114, 'pic/podarki/30.gif', 7000000),
(115, 'pic/podarki/31.gif', 7500000),
(116, 'pic/podarki/32.gif', 8000000),
(117, 'pic/podarki/33.gif', 8500000),
(118, 'pic/podarki/34.gif', 9000000),
(119, 'pic/podarki/35.gif', 9500000),
(120, 'pic/podarki/36.gif', 9999000),
(121, 'pic/podarki/37.gif', 10000000),
(122, 'pic/podarki/38.gif', 10000000),
(123, 'pic/podarki/39.gif', 15000000),
(124, 'pic/podarki/4.gif', 20000000),
(125, 'pic/podarki/40.gif', 25000000),
(126, 'pic/podarki/41.gif', 30000000),
(127, 'pic/podarki/42.gif', 30000000),
(128, 'pic/podarki/43.gif', 35000000),
(129, 'pic/podarki/44.gif', 35000000),
(130, 'pic/podarki/45.gif', 40000000),
(131, 'pic/podarki/46.gif', 45000000),
(132, 'pic/podarki/47.gif', 49000000),
(133, 'pic/podarki/48.gif', 50000000),
(134, 'pic/podarki/49.gif', 55000000),
(135, 'pic/podarki/5.gif', 60000000),
(136, 'pic/podarki/50.gif', 65000000),
(137, 'pic/podarki/51.gif', 70000000),
(138, 'pic/podarki/52.gif', 75000000),
(139, 'pic/podarki/53.gif', 80000000),
(140, 'pic/podarki/54.gif', 85000000),
(141, 'pic/podarki/55.gif', 90000000),
(142, 'pic/podarki/56.gif', 95000000),
(143, 'pic/podarki/57.gif', 99000000),
(144, 'pic/podarki/58.gif', 99500000),
(145, 'pic/podarki/59.gif', 100000000),
(146, 'pic/podarki/6.gif', 110000000),
(147, 'pic/podarki/60.gif', 120000000),
(148, 'pic/podarki/61.gif', 130000000),
(149, 'pic/podarki/62.gif', 140000000),
(150, 'pic/podarki/63.gif', 150000000),
(151, 'pic/podarki/64.gif', 160000000),
(152, 'pic/podarki/65.gif', 170000000),
(153, 'pic/podarki/66.gif', 180000000),
(154, 'pic/podarki/67.gif', 185000000),
(155, 'pic/podarki/68.gif', 190000000),
(156, 'pic/podarki/69.gif', 195000000),
(157, 'pic/podarki/7.gif', 200000000),
(158, 'pic/podarki/70.gif', 200000000),
(159, 'pic/podarki/71.gif', 200000000),
(160, 'pic/podarki/72.gif', 210000000),
(161, 'pic/podarki/73.gif', 210000000),
(162, 'pic/podarki/74.gif', 220000000),
(163, 'pic/podarki/75.gif', 220000000),
(164, 'pic/podarki/76.gif', 230000000),
(165, 'pic/podarki/77.gif', 230000000),
(166, 'pic/podarki/78.gif', 240000000),
(167, 'pic/podarki/79.gif', 240000000),
(168, 'pic/podarki/8.gif', 240000000),
(169, 'pic/podarki/80.gif', 250000000),
(170, 'pic/podarki/81.gif', 250000000),
(171, 'pic/podarki/82.gif', 250000000),
(172, 'pic/podarki/83.gif', 300000000),
(173, 'pic/podarki/84.gif', 300000000),
(174, 'pic/podarki/85.gif', 300000000),
(175, 'pic/podarki/86.gif', 350000000),
(176, 'pic/podarki/87.gif', 350000000),
(177, 'pic/podarki/88.gif', 400000000),
(178, 'pic/podarki/89.gif', 400000000),
(179, 'pic/podarki/9.gif', 450000000),
(180, 'pic/podarki/90.gif', 490000000),
(181, 'pic/podarki/91.gif', 500000000),
(182, 'pic/podarki/92.gif', 600000000),
(183, 'pic/podarki/93.gif', 666666666),
(184, 'pic/podarki/94.gif', 650000000),
(185, 'pic/podarki/95.gif', 700000000),
(186, 'pic/podarki/96.gif', 750000000),
(187, 'pic/podarki/97.gif', 800000000),
(188, 'pic/podarki/98.gif', 900000000),
(189, 'pic/podarki/99.gif', 950000000);

-- --------------------------------------------------------

--
-- Структура таблицы `podarok`
--

CREATE TABLE IF NOT EXISTS `podarok` (
  `id` mediumint(7) NOT NULL,
  `podarokid` tinyint(3) NOT NULL DEFAULT '1',
  `userid` mediumint(7) NOT NULL DEFAULT '0',
  `useradd` mediumint(7) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `relizi_block`
--

CREATE TABLE IF NOT EXISTS `relizi_block` (
  `id` mediumint(7) unsigned NOT NULL,
  `textt` varchar(6000) NOT NULL DEFAULT '',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `id` mediumint(7) NOT NULL,
  `torrentid` mediumint(7) NOT NULL DEFAULT '0',
  `userid` mediumint(7) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sdp`
--

CREATE TABLE IF NOT EXISTS `sdp` (
  `id` mediumint(7) NOT NULL,
  `torrentid` mediumint(7) NOT NULL DEFAULT '0',
  `userid` mediumint(7) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` bigint(18) unsigned NOT NULL,
  `sid` varchar(32) NOT NULL DEFAULT '',
  `uid` mediumint(7) NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL DEFAULT '',
  `class` tinyint(2) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` varchar(150) NOT NULL DEFAULT '',
  `useragent` varchar(60) DEFAULT NULL,
  `avatar` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `shoutbox`
--

CREATE TABLE IF NOT EXISTS `shoutbox` (
  `id` tinyint(3) unsigned NOT NULL,
  `userid` mediumint(7) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` varchar(1000) NOT NULL,
  `class` tinyint(2) unsigned NOT NULL,
  `username` varchar(20) NOT NULL,
  `warned` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `shoutbox2`
--

CREATE TABLE IF NOT EXISTS `shoutbox2` (
  `id` tinyint(3) unsigned NOT NULL,
  `userid` mediumint(7) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` varchar(1000) NOT NULL,
  `class` tinyint(2) unsigned NOT NULL,
  `username` varchar(20) NOT NULL,
  `warned` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sitelog`
--

CREATE TABLE IF NOT EXISTS `sitelog` (
  `id` int(10) unsigned NOT NULL,
  `added` datetime DEFAULT NULL,
  `color` varchar(11) NOT NULL DEFAULT 'transparent',
  `txt` varchar(1500) DEFAULT NULL,
  `type` varchar(8) NOT NULL DEFAULT 'tracker'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `snatched`
--

CREATE TABLE IF NOT EXISTS `snatched` (
  `id` int(11) NOT NULL,
  `userid` mediumint(7) DEFAULT '0',
  `torrent` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `port` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `to_go` bigint(20) unsigned NOT NULL DEFAULT '0',
  `seeder` enum('yes','no') NOT NULL DEFAULT 'no',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `started` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `seed_time` bigint(30) NOT NULL DEFAULT '0',
  `startdat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `completedat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `connectable` enum('yes','no') NOT NULL DEFAULT 'yes',
  `finished` enum('yes','no') NOT NULL DEFAULT 'no',
  `mulct` enum('yes','no') DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `id` tinyint(1) unsigned NOT NULL,
  `textt` varchar(5000) NOT NULL DEFAULT '',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` mediumint(7) unsigned NOT NULL,
  `keywords` varchar(2800) NOT NULL,
  `description` varchar(255) NOT NULL,
  `name` varchar(175) NOT NULL DEFAULT '',
  `not_sticky` enum('yes','no') NOT NULL DEFAULT 'yes',
  `image1` varchar(15) NOT NULL,
  `free` enum('bril','yes','silver','no') DEFAULT 'no',
  `multitracker` enum('yes','no') NOT NULL DEFAULT 'no',
  `seeders` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `thanks`
--

CREATE TABLE IF NOT EXISTS `thanks` (
  `id` smallint(5) NOT NULL,
  `torrentid` mediumint(7) NOT NULL DEFAULT '0',
  `userid` mediumint(7) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `torrents`
--

CREATE TABLE IF NOT EXISTS `torrents` (
  `id` mediumint(7) unsigned NOT NULL,
  `info_hash` varbinary(40) NOT NULL DEFAULT '',
  `name` varchar(175) NOT NULL DEFAULT '',
  `keywords` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `filename` varchar(165) NOT NULL DEFAULT '',
  `image1` varchar(15) NOT NULL,
  `descr` varchar(5000) NOT NULL,
  `fulldescr` mediumtext NOT NULL,
  `fulldescr_html` mediumtext NOT NULL,
  `info` text NOT NULL,
  `category` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `incategory` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `voice` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `tryd` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `webdl` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `reliz` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comments` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `views` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `hits` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `times_completed` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `leechers` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `remote_leechers` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `seeders` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `remote_seeders` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_mt_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_reseed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `visible` enum('yes','no') NOT NULL DEFAULT 'yes',
  `banned` enum('yes','no') NOT NULL DEFAULT 'no',
  `owner` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `owner_name` varchar(20) NOT NULL,
  `owner_class` tinyint(2) unsigned NOT NULL,
  `free` enum('bril','yes','silver','no') DEFAULT 'no',
  `not_sticky` enum('yes','no') NOT NULL DEFAULT 'yes',
  `multitracker` enum('yes','no') NOT NULL DEFAULT 'no',
  `report` enum('yes','no') DEFAULT 'no',
  `allow_comments` enum('yes','no') NOT NULL DEFAULT 'yes',
  `dostup` enum('adm','mod','upl','vip','uhd','1080p','user') NOT NULL DEFAULT 'mod',
  `updatess` enum('yes','no') NOT NULL DEFAULT 'no',
  `kptime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `kinopoisk` int(10) unsigned NOT NULL,
  `imdbtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `imdb` varchar(15) NOT NULL DEFAULT '0',
  `relizs` varchar(3000) NOT NULL,
  `recommend` varchar(3000) NOT NULL,
  `portalid` mediumint(7) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `torrents_scrape`
--

CREATE TABLE IF NOT EXISTS `torrents_scrape` (
  `tid` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `info_hash` varbinary(40) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `seeders` smallint(5) unsigned NOT NULL DEFAULT '0',
  `leechers` smallint(5) unsigned NOT NULL DEFAULT '0',
  `completed` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `state` enum('ok','error') NOT NULL DEFAULT 'ok',
  `error` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tvp`
--

CREATE TABLE IF NOT EXISTS `tvp` (
  `id` mediumint(7) NOT NULL,
  `torrentid` mediumint(7) NOT NULL DEFAULT '0',
  `userid` mediumint(7) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `uploadapp`
--

CREATE TABLE IF NOT EXISTS `uploadapp` (
  `id` mediumint(7) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `userid` mediumint(7) NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL,
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `class` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `applied` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `grpacct` tinyint(1) NOT NULL DEFAULT '0',
  `grpname` varchar(100) NOT NULL DEFAULT '',
  `grpdes` varchar(4) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `seeding` tinyint(1) NOT NULL DEFAULT '0',
  `othergrps` tinyint(1) NOT NULL DEFAULT '0',
  `seedtime` varchar(100) NOT NULL DEFAULT '',
  `modcomments` text NOT NULL,
  `votes` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(7) unsigned NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(120) NOT NULL DEFAULT '',
  `passhash` varchar(255) NOT NULL DEFAULT '',
  `secret` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL DEFAULT '',
  `status` enum('pending','confirmed') NOT NULL DEFAULT 'pending',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_access` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editsecret` varchar(255) NOT NULL DEFAULT '',
  `theme` varchar(15) NOT NULL DEFAULT '',
  `info` varchar(120) DEFAULT NULL,
  `acceptpms` enum('yes','friends','no') NOT NULL DEFAULT 'yes',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `class` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `override_class` tinyint(2) unsigned NOT NULL DEFAULT '255',
  `support` enum('no','yes') NOT NULL DEFAULT 'no',
  `supportfor` varchar(100) DEFAULT NULL,
  `avatar` varchar(30) NOT NULL DEFAULT '',
  `telgr` varchar(40) NOT NULL,
  `skype` varchar(40) NOT NULL DEFAULT '',
  `website` varchar(30) NOT NULL DEFAULT '',
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `bonus` decimal(10,1) NOT NULL DEFAULT '0.0',
  `title` varchar(30) NOT NULL DEFAULT '',
  `country` tinyint(3) unsigned NOT NULL DEFAULT '15',
  `notifs` varchar(100) NOT NULL DEFAULT '',
  `modcomment` text,
  `enabled` enum('yes','no') NOT NULL DEFAULT 'yes',
  `parked` enum('yes','no') NOT NULL DEFAULT 'no',
  `hide` enum('yes','no') NOT NULL DEFAULT 'no',
  `avatars` enum('yes','no') NOT NULL DEFAULT 'yes',
  `donor` enum('yes','no') NOT NULL DEFAULT 'no',
  `simpaty` int(10) unsigned NOT NULL DEFAULT '0',
  `warned` enum('yes','no') NOT NULL DEFAULT 'no',
  `warneduntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `torrentsperpage` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `topicsperpage` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `postsperpage` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `deletepms` enum('yes','no') NOT NULL DEFAULT 'yes',
  `savepms` enum('yes','no') NOT NULL DEFAULT 'no',
  `gender` enum('1','2','3') NOT NULL DEFAULT '3',
  `birthday` date DEFAULT '0000-00-00',
  `passkey` varchar(255) NOT NULL DEFAULT '',
  `language` varchar(10) DEFAULT NULL,
  `invites` smallint(5) NOT NULL DEFAULT '0',
  `invitedby` mediumint(7) NOT NULL DEFAULT '0',
  `invitedroot` mediumint(7) NOT NULL DEFAULT '0',
  `passkey_ip` varchar(15) NOT NULL DEFAULT '',
  `schoutboxpos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `vipuntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `oldclass` tinyint(2) NOT NULL DEFAULT '0',
  `comentoff` enum('yes','no') NOT NULL DEFAULT 'yes',
  `lsoff` enum('yes','no') NOT NULL DEFAULT 'yes',
  `hides` enum('yes','no') DEFAULT 'yes',
  `hider` enum('yes','no') DEFAULT 'yes',
  `hiders` enum('yes','no') DEFAULT 'yes',
  `invayted` enum('yes','no') DEFAULT 'yes',
  `invayt` enum('yes','no') DEFAULT 'yes',
  `bonusss` enum('yes','no') DEFAULT 'yes',
  `upluntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `admuntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `freeuntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `briluntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_upload` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `premiya` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `stops` enum('yes','no') NOT NULL DEFAULT 'no',
  `question` varchar(30) NOT NULL DEFAULT '',
  `donated` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `seeder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `leecher` smallint(4) unsigned NOT NULL DEFAULT '0',
  `announce` enum('yes','no') NOT NULL DEFAULT 'yes',
  `multik` enum('yes','no') DEFAULT 'no',
  `comreliz` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `comforum` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `topicforum` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `newmess` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `invtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `relizs` int(7) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users_ban`
--

CREATE TABLE IF NOT EXISTS `users_ban` (
  `userid` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `disuntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `disby` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(120) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `zakaz`
--

CREATE TABLE IF NOT EXISTS `zakaz` (
  `id` mediumint(7) unsigned NOT NULL,
  `name` varchar(175) NOT NULL,
  `image1` varchar(9) DEFAULT NULL,
  `text` mediumtext NOT NULL,
  `cat_id` tinyint(2) unsigned NOT NULL,
  `incat_id` tinyint(2) unsigned NOT NULL,
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` varchar(20) NOT NULL,
  `user_id` mediumint(7) unsigned NOT NULL,
  `class` tinyint(2) unsigned NOT NULL,
  `bonus` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `cl_user` varchar(20) NOT NULL,
  `cl_user_id` mediumint(7) NOT NULL,
  `cl_user_class` tinyint(2) unsigned NOT NULL,
  `url` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `avps`
--
ALTER TABLE `avps`
  ADD PRIMARY KEY (`arg`),
  ADD KEY `arg_value_u` (`arg`,`value_u`) USING BTREE;

--
-- Индексы таблицы `bannedemails`
--
ALTER TABLE `bannedemails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`added`,`email`,`id`,`addedby`,`comment`) USING BTREE;

--
-- Индексы таблицы `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`added`,`addedby`,`id`,`comment`,`first`,`haker`) USING BTREE;

--
-- Индексы таблицы `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`,`blockid`);

--
-- Индексы таблицы `bonus`
--
ALTER TABLE `bonus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`id`,`name`,`points`,`description`,`type`,`quanity`) USING BTREE;

--
-- Индексы таблицы `bonusgen`
--
ALTER TABLE `bonusgen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`activated`,`id`,`pid`,`bonus`,`owner`) USING BTREE;

--
-- Индексы таблицы `bonuslog`
--
ALTER TABLE `bonuslog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Индексы таблицы `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`userid`,`torrentid`) USING BTREE;

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category` (`sort`,`id`,`name`) USING BTREE;

--
-- Индексы таблицы `checkcomm`
--
ALTER TABLE `checkcomm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index` (`checkid`,`userid`,`torrent`) USING BTREE;

--
-- Индексы таблицы `closesayt`
--
ALTER TABLE `closesayt`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `index` (`name`,`value`) USING BTREE;

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `torrent` (`torrent`),
  ADD KEY `ip` (`ip`),
  ADD KEY `added` (`added`),
  ADD KEY `request` (`request`),
  ADD KEY `offer` (`offer`),
  ADD KEY `torrent_id` (`torrent`,`id`) USING BTREE;

--
-- Индексы таблицы `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `index` (`name`,`vibor`) USING BTREE;

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index1` (`name`,`id`) USING BTREE,
  ADD UNIQUE KEY `staff` (`id`,`name`,`flagpic`) USING BTREE;

--
-- Индексы таблицы `freeleech`
--
ALTER TABLE `freeleech`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `name_value` (`name`,`value`) USING BTREE;

--
-- Индексы таблицы `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userfriend` (`userid`,`friendid`);

--
-- Индексы таблицы `gost`
--
ALTER TABLE `gost`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `index` (`name`,`value`) USING BTREE;

--
-- Индексы таблицы `incategories`
--
ALTER TABLE `incategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`sort`,`id`,`name`) USING BTREE;

--
-- Индексы таблицы `invites`
--
ALTER TABLE `invites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inviter` (`id`) USING BTREE,
  ADD UNIQUE KEY `invite` (`invite`) USING BTREE,
  ADD KEY `inviteid` (`inviteid`),
  ADD KEY `confirmed` (`confirmed`),
  ADD KEY `time_invited` (`time_invited`),
  ADD KEY `inviter_confirmed` (`inviter`,`confirmed`) USING BTREE;

--
-- Индексы таблицы `inwayts`
--
ALTER TABLE `inwayts`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `index` (`name`,`vibor`) USING BTREE;

--
-- Индексы таблицы `loginattempts`
--
ALTER TABLE `loginattempts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index1` (`ip`,`attempts`) USING BTREE,
  ADD UNIQUE KEY `index2` (`ip`,`banned`) USING BTREE,
  ADD UNIQUE KEY `index3` (`ip`,`attemptss`) USING BTREE;

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `receiver_unread_id` (`receiver`,`unread`,`id`) USING BTREE,
  ADD KEY `receiver` (`receiver`) USING BTREE,
  ADD KEY `sender` (`sender`) USING BTREE,
  ADD KEY `unread` (`unread`) USING BTREE,
  ADD KEY `added` (`added`) USING BTREE,
  ADD KEY `saved` (`saved`) USING BTREE,
  ADD KEY `sender_saved_unread_added` (`sender`,`saved`,`unread`,`added`) USING BTREE,
  ADD KEY `sender_saved_added` (`sender`,`saved`,`added`) USING BTREE,
  ADD KEY `unread_saved_added` (`unread`,`saved`,`added`) USING BTREE,
  ADD KEY `saved_added` (`saved`,`added`) USING BTREE,
  ADD KEY `receiver_2` (`receiver`,`location`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `added` (`added`) USING BTREE;

--
-- Индексы таблицы `notconnectablepmlog`
--
ALTER TABLE `notconnectablepmlog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `date` (`date`);

--
-- Индексы таблицы `online`
--
ALTER TABLE `online`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`id`,`time`) USING BTREE,
  ADD KEY `textt` (`textt`(333));

--
-- Индексы таблицы `orbital_blocks`
--
ALTER TABLE `orbital_blocks`
  ADD PRIMARY KEY (`bid`),
  ADD KEY `index` (`active`,`weight`) USING BTREE;

--
-- Индексы таблицы `peers`
--
ALTER TABLE `peers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `torrent_peer_id` (`torrent`,`peer_id`),
  ADD KEY `torrent` (`torrent`),
  ADD KEY `torrent_seeder` (`torrent`,`seeder`),
  ADD KEY `last_action` (`last_action`),
  ADD KEY `connectable` (`connectable`),
  ADD KEY `userid` (`userid`);

--
-- Индексы таблицы `podarki`
--
ALTER TABLE `podarki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index1` (`id`,`pic`) USING BTREE,
  ADD KEY `index2` (`id`,`pic`,`bonus`) USING BTREE;

--
-- Индексы таблицы `podarok`
--
ALTER TABLE `podarok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index1` (`userid`,`id`,`podarokid`) USING BTREE;

--
-- Индексы таблицы `relizi_block`
--
ALTER TABLE `relizi_block`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`time`) USING BTREE,
  ADD KEY `textt` (`textt`(333));

--
-- Индексы таблицы `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `torrentid_2` (`torrentid`,`userid`);

--
-- Индексы таблицы `sdp`
--
ALTER TABLE `sdp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sdp` (`torrentid`,`userid`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `index1` (`time`,`username`,`class`,`uid`,`avatar`) USING BTREE,
  ADD KEY `index2` (`sid`,`uid`,`username`,`class`,`ip`,`time`,`url`,`avatar`) USING BTREE;

--
-- Индексы таблицы `shoutbox`
--
ALTER TABLE `shoutbox`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`userid`,`date`) USING BTREE;

--
-- Индексы таблицы `shoutbox2`
--
ALTER TABLE `shoutbox2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`userid`,`date`) USING BTREE;

--
-- Индексы таблицы `sitelog`
--
ALTER TABLE `sitelog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index` (`type`,`added`,`color`) USING BTREE;

--
-- Индексы таблицы `snatched`
--
ALTER TABLE `snatched`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `userid_torrent` (`userid`,`torrent`) USING BTREE,
  ADD KEY `seeder` (`seeder`),
  ADD KEY `uploaded` (`uploaded`),
  ADD KEY `downloaded` (`downloaded`),
  ADD KEY `connectable` (`connectable`),
  ADD KEY `last_action` (`last_action`),
  ADD KEY `finished` (`finished`),
  ADD KEY `startdat` (`startdat`),
  ADD KEY `completedat` (`completedat`),
  ADD KEY `mulct` (`mulct`),
  ADD KEY `to_go` (`to_go`),
  ADD KEY `started` (`started`),
  ADD KEY `seed_time` (`seed_time`),
  ADD KEY `finished_mulct_downloaded` (`finished`,`mulct`,`downloaded`) USING BTREE,
  ADD KEY `finished_seeder_mulct_downloaded` (`finished`,`seeder`,`mulct`,`downloaded`) USING BTREE,
  ADD KEY `finished_downloaded` (`finished`,`downloaded`) USING BTREE,
  ADD KEY `finished_torrent` (`finished`,`torrent`) USING BTREE,
  ADD KEY `finished_userid` (`finished`,`userid`) USING BTREE;

--
-- Индексы таблицы `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`id`,`time`) USING BTREE,
  ADD KEY `textt` (`textt`(333));

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `multitracker_added` (`multitracker`,`added`) USING BTREE,
  ADD UNIQUE KEY `free_added` (`free`,`added`) USING BTREE,
  ADD KEY `name` (`name`),
  ADD KEY `description` (`description`),
  ADD KEY `not_sticky` (`not_sticky`),
  ADD KEY `image1` (`image1`),
  ADD KEY `added` (`added`),
  ADD KEY `seeders_added` (`seeders`,`added`) USING BTREE,
  ADD KEY `keywords` (`keywords`(333));

--
-- Индексы таблицы `thanks`
--
ALTER TABLE `thanks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `thank` (`torrentid`,`userid`);

--
-- Индексы таблицы `torrents`
--
ALTER TABLE `torrents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `info_hash` (`info_hash`),
  ADD UNIQUE KEY `owner` (`owner`,`id`,`owner_name`,`owner_class`) USING BTREE,
  ADD UNIQUE KEY `views_id_name_images_sm` (`views`,`id`,`name`) USING BTREE,
  ADD UNIQUE KEY `name_id` (`name`,`id`) USING BTREE,
  ADD UNIQUE KEY `multitracker_added` (`multitracker`,`added`) USING BTREE,
  ADD UNIQUE KEY `voice_added` (`voice`,`added`) USING BTREE,
  ADD UNIQUE KEY `webdl_added` (`webdl`,`added`) USING BTREE,
  ADD UNIQUE KEY `tryd_added` (`tryd`,`added`) USING BTREE,
  ADD UNIQUE KEY `incategory_added` (`incategory`,`added`) USING BTREE,
  ADD UNIQUE KEY `reliz_added` (`reliz`,`added`) USING BTREE,
  ADD UNIQUE KEY `name_added` (`name`,`added`) USING BTREE,
  ADD UNIQUE KEY `category_added` (`category`,`added`) USING BTREE,
  ADD UNIQUE KEY `added` (`added`),
  ADD UNIQUE KEY `free_added` (`free`,`added`) USING BTREE,
  ADD KEY `visible` (`visible`),
  ADD KEY `size` (`size`) USING BTREE,
  ADD KEY `dostup` (`dostup`) USING BTREE,
  ADD KEY `updatess` (`updatess`) USING BTREE,
  ADD KEY `visible_added` (`visible`,`added`) USING BTREE,
  ADD KEY `seeders_id` (`seeders`,`id`) USING BTREE,
  ADD KEY `kinopoisk` (`kptime`,`id`,`kinopoisk`) USING BTREE,
  ADD KEY `id_dostup_owner` (`id`,`dostup`,`owner`) USING BTREE,
  ADD KEY `remote_seeders_id` (`remote_seeders`,`id`) USING BTREE,
  ADD KEY `remote_leechers_id` (`remote_leechers`,`id`) USING BTREE,
  ADD KEY `seeders_added` (`seeders`,`added`) USING BTREE,
  ADD KEY `leechers_seeders` (`leechers`,`seeders`),
  ADD FULLTEXT KEY `description` (`description`);
ALTER TABLE `torrents`
  ADD FULLTEXT KEY `keywords` (`keywords`);

--
-- Индексы таблицы `torrents_scrape`
--
ALTER TABLE `torrents_scrape`
  ADD PRIMARY KEY (`info_hash`,`url`),
  ADD KEY `index1` (`seeders`,`leechers`) USING BTREE,
  ADD KEY `index2` (`tid`,`url`,`seeders`,`leechers`,`last_update`,`state`,`error`) USING BTREE,
  ADD KEY `index3` (`tid`,`info_hash`,`url`) USING BTREE,
  ADD KEY `index4` (`tid`,`url`,`state`,`error`,`seeders`,`leechers`) USING BTREE,
  ADD KEY `index5` (`tid`,`seeders`,`leechers`) USING BTREE;

--
-- Индексы таблицы `tvp`
--
ALTER TABLE `tvp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tvp` (`torrentid`,`userid`) USING BTREE;

--
-- Индексы таблицы `uploadapp`
--
ALTER TABLE `uploadapp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users` (`userid`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `passhash` (`passhash`),
  ADD UNIQUE KEY `user` (`id`,`status`,`enabled`) USING BTREE,
  ADD UNIQUE KEY `ojidind` (`id`,`avatar`,`warned`,`username`,`title`,`class`,`donor`,`downloaded`,`uploaded`,`enabled`,`parked`,`last_access`) USING BTREE,
  ADD UNIQUE KEY `id_lastaccess` (`id`,`last_access`) USING BTREE,
  ADD UNIQUE KEY `userdetalis` (`id`,`username`,`status`,`class`,`hide`) USING BTREE,
  ADD UNIQUE KEY `staff2` (`status`,`class`,`username`,`id`,`avatar`,`last_access`) USING BTREE,
  ADD UNIQUE KEY `staff1` (`support`,`status`,`username`,`id`,`last_access`,`class`,`supportfor`,`avatar`,`country`) USING BTREE,
  ADD KEY `status_added` (`status`,`added`),
  ADD KEY `ip` (`ip`),
  ADD KEY `uploaded` (`uploaded`),
  ADD KEY `downloaded` (`downloaded`),
  ADD KEY `country` (`country`),
  ADD KEY `last_access` (`last_access`),
  ADD KEY `enabled` (`enabled`),
  ADD KEY `warned` (`warned`),
  ADD KEY `passkey` (`passkey`),
  ADD KEY `bonus` (`bonus`),
  ADD KEY `parked` (`parked`),
  ADD KEY `gender` (`gender`),
  ADD KEY `bonusss` (`bonusss`),
  ADD KEY `stops` (`stops`),
  ADD KEY `premiya` (`premiya`),
  ADD KEY `class_downloaded_added` (`class`,`downloaded`,`added`) USING BTREE,
  ADD KEY `parked_status_class_last` (`parked`,`status`,`class`,`last_access`) USING BTREE,
  ADD KEY `status_last` (`status`,`last_access`) USING BTREE,
  ADD KEY `warned_warneduntil` (`warned`,`warneduntil`) USING BTREE,
  ADD KEY `vipuntil` (`vipuntil`),
  ADD KEY `upluntil` (`upluntil`),
  ADD KEY `admuntil` (`admuntil`),
  ADD KEY `class_down_upl_added` (`class`,`downloaded`,`uploaded`,`added`) USING BTREE,
  ADD KEY `class_down_upl_bonus_added` (`class`,`downloaded`,`uploaded`,`bonus`,`added`) USING BTREE,
  ADD KEY `class_bonus` (`class`,`bonus`) USING BTREE,
  ADD KEY `passkey_last_access` (`passkey`,`last_access`) USING BTREE,
  ADD KEY `status_id` (`status`,`id`) USING BTREE,
  ADD KEY `last_access_class` (`last_access`,`class`) USING BTREE,
  ADD KEY `class_id` (`class`,`id`) USING BTREE,
  ADD KEY `enabled_status_added` (`enabled`,`status`,`added`) USING BTREE;

--
-- Индексы таблицы `users_ban`
--
ALTER TABLE `users_ban`
  ADD PRIMARY KEY (`userid`) USING BTREE,
  ADD UNIQUE KEY `index1` (`userid`,`disuntil`) USING BTREE,
  ADD UNIQUE KEY `inmdex2` (`userid`,`reason`,`disuntil`) USING BTREE,
  ADD UNIQUE KEY `indexs` (`userid`,`disuntil`,`disby`,`reason`) USING BTREE,
  ADD UNIQUE KEY `index3` (`disuntil`,`userid`) USING BTREE;

--
-- Индексы таблицы `zakaz`
--
ALTER TABLE `zakaz`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index1` (`data`,`status`,`user_id`,`id`,`name`,`cat_id`,`bonus`) USING BTREE,
  ADD UNIQUE KEY `index2` (`cat_id`,`data`) USING BTREE,
  ADD UNIQUE KEY `index3` (`user_id`,`data`) USING BTREE,
  ADD UNIQUE KEY `index4` (`status`,`data`) USING BTREE;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bannedemails`
--
ALTER TABLE `bannedemails`
  MODIFY `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `bans`
--
ALTER TABLE `bans`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `bonus`
--
ALTER TABLE `bonus`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT для таблицы `bonusgen`
--
ALTER TABLE `bonusgen`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `bonuslog`
--
ALTER TABLE `bonuslog`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `checkcomm`
--
ALTER TABLE `checkcomm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=110;
--
-- AUTO_INCREMENT для таблицы `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `incategories`
--
ALTER TABLE `incategories`
  MODIFY `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT для таблицы `invites`
--
ALTER TABLE `invites`
  MODIFY `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `loginattempts`
--
ALTER TABLE `loginattempts`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `notconnectablepmlog`
--
ALTER TABLE `notconnectablepmlog`
  MODIFY `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `online`
--
ALTER TABLE `online`
  MODIFY `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `orbital_blocks`
--
ALTER TABLE `orbital_blocks`
  MODIFY `bid` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT для таблицы `peers`
--
ALTER TABLE `peers`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `podarki`
--
ALTER TABLE `podarki`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=190;
--
-- AUTO_INCREMENT для таблицы `podarok`
--
ALTER TABLE `podarok`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `relizi_block`
--
ALTER TABLE `relizi_block`
  MODIFY `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `report`
--
ALTER TABLE `report`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `sdp`
--
ALTER TABLE `sdp`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` bigint(18) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `shoutbox`
--
ALTER TABLE `shoutbox`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `shoutbox2`
--
ALTER TABLE `shoutbox2`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `sitelog`
--
ALTER TABLE `sitelog`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `snatched`
--
ALTER TABLE `snatched`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `stats`
--
ALTER TABLE `stats`
  MODIFY `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `thanks`
--
ALTER TABLE `thanks`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `torrents`
--
ALTER TABLE `torrents`
  MODIFY `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `tvp`
--
ALTER TABLE `tvp`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `zakaz`
--
ALTER TABLE `zakaz`
  MODIFY `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT;