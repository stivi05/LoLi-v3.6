<?php if(!defined('UC_SYSOP')) die("<html><head><meta http-equiv='refresh' content='0;url=/'></head><body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");
class lang implements arrayaccess{private $tlr = array();public function __construct(){
$this->tlr = array(
'language_charset' => 'utf8',
			 'page_generated' => "Page generated in %f seconds",
			 'unknown' => 'Неизвестно',
			 'access_denied' => 'Доступ запрещен.',
			 'account_activated' => 'Аккаунт активирован',
			 'active' => 'Активные',
			 'add_comment' => 'Добавить комментарий',
			 'add_user' => 'Добавить пользователя',
			 'added' => 'Добавлен',
			 'age' => 'Возраст',
			 'contactus' => 'Связаться с нами',
			 'external_torrent' => 'Мультитрекерный торрент',
			 'external_torrent_update' => 'Мультитрекерный торрент (обновить информацию)',
			 'new_torrents_stats' => 'Раздают: %d, Качают: %d',
			 'help_seed' => 'Скачал сам, дай скачать другому!!!',
			 'no_need_seeding' => 'Нет торрентов, которым нужны раздающие',
			 'signup_users_limit' => 'Текущий лимит пользователей (%d) достигнут. Неактивные пользователи постоянно удаляются, пожалуйста вернитесь попозже...',
			 'signup_signup' => 'Регистрация',
			 'signup_already_registered' => 'Вы уже зарегистрированный пользователь %s!',
			 'signup_not_selected' => '---- Не выбрано ----',
			 'signup_use_cookies' => 'Для правильной регистрации активизируйте cookies.',
			 'signup_username' => 'Пользователь',
			 'signup_password' => 'Пароль',
			 'signup_password_again' => 'Повторите пароль',
			 'signup_email' => 'Email',
			 'signup_email_must_be_valid' => 'Email адрес должен быть верным.	Вам прийдет подтверждающее письмо, на которое вы должны отреагировать. Ваш email больше не будет использован.',
			 'signup_gender' => 'Пол',
			 'signup_male' => 'Парень',
			 'signup_female' => 'Девушка',
			 'signup_contact' => 'Контакты',
			 'signup_i_have_read_rules' => 'Я прочитаю <a href="rules.php" target="_blank">правила</a>',
			 'signup_i_will_read_faq' => 'Я буду читать <a href="faq.php" target="_blank">ЧаВо</a> прежде чем задавать вопросы',
			 'signup_i_am_13_years_old_or_more' => 'Мне 13 лет или больше',
			 'signup_disabled' => 'Извините, но регистрация отключена администрацией',
			 'dad' => 'Прямой доступ к этому файлу не разрешен',
			 'news_added' => 'Добавлена',
			 'news_poster' => 'Автор',
			 'my_my' => 'Панель управления',
			 'my_updated' => 'Профиль обновлён!',
			 'my_mail_sent' => 'Подтверждающее письмо отправлено!',
			 'my_mail_updated' => 'E-mail адрес обновлен!',
			 'my_torrents' => 'Мои торренты',
			 'my_unset' => 'Не выбрано',
			 'my_allow_pm_from' => 'Разрешить ЛС от',
			 'my_parked' => 'Аккаунт припаркован',
			 'my_you_can_park' => 'Вы можете припарковать ваш аккаунт во избежания удаления из-за неактивности, например если вы уедете отдыхать. Но когда ваш аккаунт припаркован, вам будут недоступны некоторые функции, например просмотр или качание торрентов',
			 'my_delete_after_reply' => 'Удалять ЛС при ответе',
			 'my_sentbox' => 'Сохранять отправленные ЛС',
			 'my_email_notify' => 'Уведомление по email',
			 'my_default_browse' => 'Категории просмотра по умолчанию',
			 'my_style' => 'Вид интерфейса',
			 'my_country' => 'Страна',
			 'my_language' => 'Язык',
			 'my_avatar_url' => 'Адрес аватары',
			 'my_gender' => 'Пол',
			 'my_gender_male' => 'Парень',
			 'my_gender_female' => 'Девушка',
			 'my_year' => 'Год',
			 'my_month' => 'Месяц',
			 'my_day' => 'День',
			 'my_months_january' => 'January',
			 'my_months_february' => 'February',
			 'my_months_march' => 'March',
			 'my_months_april' => 'April',
			 'my_months_may' => 'May',
			 'my_months_june' => 'June',
			 'my_months_jule' => 'July',
			 'my_months_august' => 'August',
			 'my_months_september' => 'September',
			 'my_months_october' => 'October',
			 'my_months_november' => 'November',
			 'my_months_december' => 'December',
			 'my_birthdate' => 'Дата рождения',
			 'my_contact' => 'Система мгновенных сообщений',
			 'my_contact_descr' => 'Если вы хотите, чтобы другие посетители могли быстро связаться с вами, укажите свои данные в следующих системах быстрых сообщений',
			 'my_contact_icq' => 'Номер ICQ',
			 'my_contact_skype' => 'Имя в Skype',
			 'my_website' => 'Сайт',
			 'my_torrents_per_page' => 'Торрентов на страницу',
			 'my_topics_per_page' => 'Тем на страницу',
			 'my_messages_per_page' => 'Сообщений на страницу',
			 'my_show_avatars' => 'Показывать аватары',
			 'my_info' => 'Информация',
			 'my_userbar' => 'Юзербар',
			 'my_userbar_descr' => 'Это твой юзербар. Ты можешь поставить его в подписи на форуме.<br>Пользователям форума будет виден твой рейтинг на нашем трекере, а если ты еще поставишь и ссылку на наш трекер - они смогут попасть на наш трекер просто нажав на картинку.<br><br>Вот твой <b>BB-код</b> для вставки в подпись на форумах',
			 'my_mail' => 'Email',
			 'ago' => 'назад',
			 'all_types' => 'Все типы',
			 'already_bookmarked' => ' уже в закладках.',
			 'announce_invalid' => 'Неверный',
			 'unknown_passkey' => 'Неизвестный пасскей!',
			 'announce_invalid_passkey' => 'Неверный пасскей! Перекачайте торрент .torrent с $DEFAULTBASEURL',
			 'announce_invalid_port' => 'Неверный порт',
			 'announce_missing_parameter' => 'Отсутствует параметр',
			 'announce_not_authorized' => 'Не авторизированы',
			 'announce_read_faq' => 'Читайте ЧаВо',
			 'announce_torrent_not_registered' => 'Торрент не зарегистрирован на трекере',
			 'announce_url' => 'Announce URL трекера',
			 'announce_you_can_leech_only_from_one_place' => 'Лимит соединений превышен! Вы можете качать только с одного места.',
			 'antirespect' => 'Антиреспект',
			 'at' => 'в',
			 'avatar' => 'Аватар',
			 'avatar_adress_invalid' => 'Неверный адрес аватары.',
			 'avatar_is_too_big' => 'Размеры вашей аватары превышают %dx%d пискелей, уменьшите ее в любом графическом редакторе!',
			 'avialable_formats' => 'Допустимые форматы',
			 'back' => 'Назад',
			 'banned' => 'Забанен',
			 'bans' => 'Баны',
			 'bitbucket' => 'Закачать картинку',
			 'blank_vote' => 'Пустой голос (Я просто хочу увидеть результаты!)',
			 'block' => 'блокировку',
			 'blocked_list' => 'Список врагов',
			 'bookmark_this' => 'В закладки',
			 'bookmark' => 'Добавить в избранное',
			 'bookmarked' => ' добавлен в закладки.',
			 'bookmarks' => 'Закладки',
			 'browse' => 'Релизы',
			 'bytes' => 'байт',
			 'change' => 'Изменить',
			 'choose' => 'Выберите',			
			 'class_vladelec' => 'Владелец',
			 'class_sysop' => 'Директор',
			 'class_administrator' => 'Администратор',
			 'class_moderator' => 'Модератор',
			 'class_vip' => 'VIP',
			 'class_uploader' => 'Аплоадер',			 
			 'class_vips' => 'Ветеран',
			 'class_uhd' => 'UHD',
			 'class_1080p' => '1080p',
			 'class_1080i' => '1080i',			
			 'class_720p' => '720p',
			 'class_user' => 'Личер',
			 'client' => 'Клиент',
			 'clients_recomened_by_us' => 'Клиенты рекомендуемые нами',
			 'clock' => 'Время',
			 'close_list' => 'Закрыть список',
			 'comment' => 'комментарий',
			 'comment_cant_be_empty' => 'Комментарий не может быть пустым!',
			 'comments' => 'Комм.',
			 'comments_for' => 'Комментарии к',
			 'comms' => 'Комментариев: %d',
			 'community' => 'Сообщество',
			 'completed' => 'Закончил',
			 'confirmation_mail_sent' => 'Подтверждающее письмо отправлено на указаный вами адрес (%s). Вам необходимо прочитать и отреагировать на письмо прежде чем вы сможете использовать ваш аккаунт. Если вы этого не сделаете, новый аккаунт будет автоматически удален через несколько дней.',
			 'connected' => 'В&nbsp;раздаче',
			 'connection_limit_exceeded' => 'Лимит соединений превышен!',
			 'create' => 'Создать',
			 'date' => 'Дата',
			 'dead' => 'мертвый',
			 'delete' => 'Удалить',
			 'delete_marked_messages' => 'Удалить выделеные сообщения',
			 'deleted' => 'Удален',
			 'description' => 'Описание',
			 'design' => 'Стиль',
			 'details_leeching' => 'Качающие',
			 'details_seeding' => 'Раздающие',
			 'details_10_last_snatched' => '10 последних скачавших',
			 'details_10_last_snatched_noone' => 'Еще никто не скачал этот торрент',
			 'dl_speed' => 'Закачка',
			 'download' => 'Скачать',
			 'magnet' => 'Скачать через magnet',
			 'downloaded' => 'Скачал',
			 'downloading' => 'В раздаче',
			 'dox' => 'Файло-помойка',
			 'dox_called_already_exists' => 'Файл названый <b>%s</b> уже существует!',
			 'dox_cannot_delete' => 'Не могу удалить файл: <b>%s</b>. Вы должны сообщить администратору об ошибке.',
			 'dox_cannot_move' => 'Не могу переместить файл. Вы должны сообщить администратору об ошибке.',
			 'dox_date' => 'Дата',
			 'dox_downloaded' => 'Скачали',
			 'dox_file_already_exists' => 'Файл с именем <b>%s</b> уже существует!',
			 'dox_filename' => 'Название',
			 'dox_no_files' => 'Файлов не найдено.',
			 'dox_nothing_received' => 'Ничего не получено! Возможно файл который вы пытались загризить - слишком большой.',
			 'dox_size' => 'Размер',
			 'dox_time' => 'Время',
			 'dox_title' => 'Файло-помойка',
			 'dox_upload' => 'Загрузить',
			 'dox_upload_file' => 'Загрузить файл',
			 'dox_uploader' => 'Загрузил',
			 'dox_warning' => 'Внимание',
			 'edit' => 'Редактировать',
			 'edited' => 'Успешное редактирование!',
			 'error' => 'Ошибка',
			 'faq' => 'ЧаВо',
			 'file_list' => 'Список файлов',
			 'files' => 'Файлов',
			 'files_l' => 'файлов',
			 'filled' => 'Выполнен?',
			 'filled_by' => 'Выполнил',
			 'formats' => 'Форматы файлов',
			 'forum' => 'Форум',
			 'friend' => 'друга',
			 'friends_list' => 'Список друзей',
			 'from' => 'из',
			 'from_system' => 'Системное',
			 'gender' => 'Пол',
			 'getdox_file_not_found' => 'Файл не найден',
			 'getdox_no_file' => 'Нет имени файла',
			 'go' => 'Вперед',
			 'go_go_go' => 'Поехали',
			 'go_to' => 'Перейти',
			 'golden' => 'Золотой торрент',
			 'silver' => 'Серебряный торрент',
			 'golden_descr' => 'Золотой торрент (считается только раздача, закачка не учитывается)',
			 'golden_torrents' => 'Золотые торренты',
			 'guests_online' => 'Всего гостей',
			 'hide_filled' => 'Спрятать выполненные',
			 'hits' => 'Взят',
			 'homepage' => 'Главная',
			 'idle' => 'Бездействие',
			 'image' => 'Изображение',
			 'images' => 'Скриншоты',
			 'img_poster' => 'Постер',
			 'in' => 'в',
			 'inbox' => 'Входящие',
			 'including_dead' => 'Включая мертвые',
			 'info_hash' => 'Хэш релиза',
			 'invalid_id' => 'Неверный идентификатор.',
			 'invalid_ip' => 'Неверный IP адрес.',
			 'invite' => 'Пригласить',
			 'is' => 'в',
			 'last_registered_user' => 'Последний зарегистрированный пользователь',
			 'last_seen' => 'Последний раз был в сети ',
			 'leechers' => 'Лич',
			 'leechers_l' => 'качающих',
			 'leeching' => 'Качает',
			 'loading' => 'Загрузка...',
			 'log' => 'Журнал',
			 'login' => 'Вход',
			 'logout' => 'Выход',
			 'lower_class' => 'Вы работаете под более низким классом. Нажмите сюда для возврата.',
			 'mail_read' => 'Прочитанное',
			 'mail_read_desc' => 'Прочитанные сообщения',
			 'mail_unread_desc' => 'Непрочитанные сообщения',
			 'mail_unread' => 'Непрочитанное сообщение',
			 'main_menu' => 'Главное Меню',
			 'make_request' => 'Сделать запрос',
			 'mark' => 'Выделить',
			 'mark_all' => 'Выделить все',
			 'mark_as_read' => 'Отметить выделенные сообщения как прочитанные',
			 'mark_read' => 'Прочитать',
			 'max_avatar_size' => 'Размеры аватарки должны быть не более %dx%d пикселей.',
			 'max_file_size' => 'Максимальный размер файла',
			 'messages' => 'Сообщения',
			 'missing_form_data' => 'Заполните все поля формы.',
			 'monitor_comments' => 'Следить за комментариями',
			 'monitor_comments_disable' => 'Отключить слежение',
			 'my' => 'Панель управления',
			 'my_bonus' => 'Мой бонус',
			 'my_torrents' => 'Мои торренты',
			 'name' => 'Название',
			 'need_seeds' => 'Релизы, которым нужны раздающие',
			 'neighbours' => 'Соседи',
			 'never' => 'никогда',
			 'new_offers' => 'Новые предложения',
			 'new_pm' => '(%d новых)',
			 'new_pms' => 'У вас %d новое(ых) сообщение(ий)!',
			 'new_torrents' => 'Новые торренты',
			 'news' => 'Новости',
			 'next' => 'Вперед',
			 'no' => 'Нет',
			 'no_blocked' => 'У вас нет врагов',
			 'no_choose' => 'Не выбрано',
			 'no_comments' => 'Нет комментариев',
			 'no_fields_blank' => 'Не оставляйте пустых полей.',
			 'no_friends' => 'У вас нет друзей',
			 'no_messages' => 'Нет сообщений',
			 'no_offers' => 'Нет предложений',
			 'no_online_users' => 'Не было активных пользователей за последние 15 минут.',
			 'no_polls' => 'Нет опросов',
			 'no_news' => 'Нет новостей',
			 'no_seeds' => 'Без сидов',
			 'no_subject' => 'Без темы',
			 'no_torrent_with_such_id' => 'Нет торрента с таким ID.',
			 'no_torrents' => 'Нет торрентов',
			 'no_votes' => 'Нет голосов',
			 'none_voted' => 'нет голосов',
			 'none_yet' => 'Никто',
			 'not_enough_votes' => 'Еще нет (нужно хотя-бы %d голосов. Собрано: ',
			 'nothing_found' => 'Ничего не найдено',
			 'now' => 'сейчас',
			 'offers' => 'Предложения',
			 'offerser' => 'Предложил',
			 'official' => 'Официальный',
			 'offline' => 'оффлайне',
			 'old_polls' => 'Прошлые опросы',
			 'online' => 'онлайне',
			 'online_users' => 'Всего Онлайн',
			 'only_dead' => 'Только мертвые',
			 'only_votes' => 'только %d голосов',
			 'open_list' => 'Посмотреть список',
			 'optional' => 'Не обязательно.',
			 'outbox' => 'Отправленные',
			 'password' => 'Пароль',
			 'password_mismatch' => 'Пароли не совпадают.',
			 'path' => 'Путь',
			 'peers_l' => 'пиров',
			 'personal_lists' => 'Мои друзья',
			 'pm' => 'ЛС',
			 'poll' => 'Опрос',
			 'port_open' => 'NAT',
			 'prev' => 'Назад',
			 'profile' => 'Профиль',
			 'rating' => 'Оценка',
			 'ratio' => 'Рейтинг',
			 'receiver' => 'Получатель',
			 'repeat_password' => 'Повтор пароля',
			 'request' => 'Запрос',
			 'requester' => 'Запросил',
			 'requests' => 'Запросы',
			 'requests_section' => 'Секция запросов',
			 'respect' => 'Респект',
			 'rules' => 'Правила',
			 'said_thanks' => 'Сказали&nbsp;спасибо',
			 'search' => 'Поиск',
			 'search_btn' => 'Искать',
			 'search_requests' => 'Искать запросы',
			 'search_results_for' => 'Результаты поиска для',
			 'seeder' => 'Раздающий',
			 'seeder_last_seen' => 'Последний раз был здесь',
			 'seeders_l' => 'раздающих',
			 'seeding' => 'Сидирует',
			 'seeds' => 'Сид',
			 'sender' => 'Отправитель',
			 'server_load' => 'Нагрузка на сервер',
			 'show_all' => 'Показать все',
			 'show_data' => 'Показать данные',
			 'show_my_requests' => 'Посмотреть мои запросы',
			 'signup' => 'Регистрация',
			 'signup_successful' => 'Успешная регистрация',
			 'size' => 'Размер',
			 'snatched' => 'Скачан',
			 'staff' => 'Администрация',
			 'statistic' => 'Статистика',
			 'subject' => 'Тема',
			 'subscribe_last_comment' => 'Последнее сообщение',
			 'subscribe_list' => 'Лист подписки',
			 'subscribe_no' => 'Нет новых комметариев в темах, на которые вы подписаны.',
			 'success' => 'Успешно',
			 'successful_upload' => 'Успешная заливка!',
			 'sure_mark_delete' => 'Вы уверены, что хотите удалить выбранные сообщения?',
			 'sure_mark_read' => 'Вы уверены, что хотите пометить выбранные сообщения как прочитанные?',
			 'vladelec_account_activated' => 'Ваш аккаунт активирован! Вы автоматически вошли. Теперь вы можете <a href="%s/"><b>перейти на главную</b></a> и начать использовать ваш аккаунт.',
			 'vladelec_activated' => 'Аккаунт Владельца успешно активирован',
			 'taken_from_torrent' => 'Берется из торрента. <b>Пожалуйста, используйте понятные имена.</b>',
			 'thanks' => 'Спасибо',
			 'thanks_added' => 'Спасибо добавлено!',
			 'thanks_for_registering' => 'Спасибо что зарегистрировались на %s! Теперь вы можете <a href="login.php">войти</a> в систему.',
			 'this_account_activated' => 'Этот аккаунт уже активирован. Вы можете <a href="login.php">войти</a> с ним.',
			 'times' => 'раз',
			 'topten' => 'Топ 10',
			 'torrent' => 'Торрент',
			 'torrent_clients' => 'Торрент Клиенты',
			 'torrent_details' => 'Детали торрента',
			 'torrent_file' => 'Torrent файл',
			 'torrent_info' => 'Данные о торренте',
			 'torrent_name' => 'Название',
			 'torrent_not_selected' => 'Торрент не выбран!',
			 'torrents' => 'Торренты',
			 'total' => 'Всего',
			 'tracker_dead_torrents' => 'Мертвых Торрентов',
			 'tracker_leechers' => 'Качающих',
			 'tracker_peers' => 'Активных подключений',
			 'tracker_seed_peer' => 'Раздающих/Качающих (%)',
			 'tracker_seeders' => 'Раздающих',
			 'tracker_torrents' => 'Торрентов',
			 'external_seeders' => 'Внешних Раздающих',
			 'external_leechers' => 'Внешних Качающих',
			 'ttl' => 'TTL',
			 'type' => 'Тип',
			 'ul_speed' => 'Раздача',
			 'unable_to_create_account' => 'Невозможно создать аккаунт. Возможно имя пользователя уже занято.',
			 'unable_to_read_torrent' => 'Невозможно прочитать торрент файл.',
			 'upload' => 'Загрузить',
			 'upload_torrent' => 'Загрузить релиз',
			 'uploaded' => 'Раздал',
			 'uploadeder' => 'Раздает',
			 'user' => 'Юзер',
			 'user_menu' => 'Персональное Меню',
			 'username' => 'Логин',
			 'users' => 'Пользователи',
			 'users_disabled' => 'Отключенных',
			 'users_registered' => 'Зарегистрированных',
			 'users_unconfirmed' => 'Неподтвержденных',
			 'users_uploaders' => 'Аплоадеров',
			 'users_vips' => 'VIP',
			 'users_warned' => 'Предупреждённых',
			 'views' => 'Просмотров',
			 'visible' => 'Видимый',
			 'vote' => 'Проголосовать',
			 'vote_1' => 'Ужасно!',
			 'vote_2' => 'Плохо',
			 'vote_3' => 'Нормально',
			 'vote_4' => 'Хорошо',
			 'vote_5' => 'Отлично!',
			 'voted' => 'Голос добавлен!',
			 'votes' => 'Голосов',
			 'wait' => 'Ожидание',
			 'welcome_back' => 'Привет, ',
			 'whos_online' => 'Пользователи',
			 'with' => 'с',
			 'wrote_at' => 'Писал в',
			 'yes' => 'Да',
			 'you_can_start_seeding' => 'Вы можете начинать раздачу. <b>Учтите</b> что торрент не будет виден пока вы не начнете раздавать!',
			 'you_have_no_bookmarks' => 'У вас нет закладок!',
			 'you_have_voted_for_this_torrent' => 'вы оценили этот торрент как',
			 'you_want_to_delete_x_click_here' => 'Вы хотите удалить %s. Нажмите <a href=%s>сюда</a> если вы уверены.',
			 'your_ip' => 'Ваш IP',
			 'stats_female' => 'Девушки',
			 'stats_male' => 'Парни',
			 'stats_maxusers' => 'Мест на трекере',
			 'peertable_port_open' => 'Порт открыт. Этот пир может подключатся к любому пиру.',
			 'peertable_port_closed' => 'Порт закрыт. Рекомендовано проверить настройки Firwewall\'а.',
			 'details_poster' => 'Постер',
			 'details_screenshot' => 'Скриншот',
			 'details_anonymous' => 'Аноним',
			 'details_multitracker' => 'Мультитрекер',
			 'details_update_multitracker' => 'Обновить мультитрекер',
			 'details_update_last_mt_update' => 'Последнее обновление было: ',
			 'ajax_loading' => 'Загрузка. Пожалуйста, подождите...',
			 'comments_list' => 'Список комментариев',
			 'comments_add' => 'Добавить комментарий',
			 'logs' => 'Журнал',
			 'perday' => 'всего в день',
			 'bonus' => 'Бонус',
);}
public function offsetSet($offset, $value){$this->tlr[$offset] = $value;}public function offsetExists($offset){return isset($this->tlr[$offset]);}
public function offsetUnset($offset){unset($this->tlr[$offset]);}public function offsetGet($offset){
return isset($this->tlr[$offset]) ? $this->tlr[$offset] : 'NO_LANG_'.strtoupper($offset);}}$tracker_lang = new lang;?>