<?php

$country_link_array = array(
    array('url' => 'country_team',      'text' => 'Команды'),
    array('url' => 'country_national',  'text' => 'Сборные'),
    array('url' => 'country_news',      'text' => 'Новости'),
    array('url' => 'country_finance',   'text' => 'Фонд'),
    array('url' => 'country_vote_list', 'text' => 'Опросы'),
    array('url' => 'country_league',    'text' => 'Лига Чемпионов'),
);
$championship_round_array = array(
    array('round_id' => ROUND_SEASON,   'text' => 'Регулярный сезон'),
    array('round_id' => ROUND_PLAYOFF,  'text' => 'Плей-офф'),
);
$league_round_array = array(
    array('round_id' => ROUND_QUALIFICATION,    'text' => 'Отборочный раунд'),
    array('round_id' => ROUND_GROUP,            'text' => 'Групповой этап'),
    array('round_id' => ROUND_PLAYOFF,          'text' => 'Плей-офф'),
);
$national_link_array = array(
    array('url' => 'national_view',         'text' => 'Игроки'),
    array('url' => 'national_game',         'text' => 'Матчи'),
    array('url' => 'national_event',        'text' => 'События'),
    array('url' => 'national_finance',      'text' => 'Финансы'),
    array('url' => 'national_achievement',  'text' => 'Достижения'),
);
$player_link_array = array(
    array('url' => 'player_view',           'text' => 'Матчи'),
    array('url' => 'player_event',          'text' => 'События'),
    array('url' => 'player_deal',           'text' => 'Сделки'),
    array('url' => 'player_transfer',       'text' => 'Трансфер'),
    array('url' => 'player_rent',           'text' => 'Аренда'),
    array('url' => 'player_achievement',    'text' => 'Достижения'),
);
$register_link_array = array(
    array('url' => 'signup',        'url2' => '',                   'text' => 'Регистрация'),
    array('url' => 'password',      'url2' => 'password_restore',   'text' => 'Забыли пароль?'),
    array('url' => 'activation',    'url2' => 'activation_repeat',  'text' => 'Активация аккаунта'),
);
$rent_link_array = array(
    array('url' => 'rent_list',     'text' => 'Игроки на рынке'),
    array('url' => 'rent_history',  'text' => 'Результаты сделок'),
);
$shop_link_array = array(
    array('url' => 'shop',          'text' => 'Виртуальный магазин'),
    array('url' => 'shop_payment',  'text' => 'Пополнить счет'),
    array('url' => 'shop_history',  'text' => 'История платежей'),
);
$stadium_link_array = array(
    array('url' => 'stadium_increase', 'text' => 'Расширить стадион'),
    array('url' => 'stadium_decrease', 'text' => 'Уменьшить стадион'),
);
$team_link_array = array(
    array('url' => 'team_view',         'text' => 'Игроки'),
    array('url' => 'team_game',         'text' => 'Матчи'),
    array('url' => 'team_statistic',    'text' => 'Статистика'),
    array('url' => 'team_deal',         'text' => 'Сделки'),
    array('url' => 'team_event',        'text' => 'События'),
    array('url' => 'team_finance',      'text' => 'Финансы'),
    array('url' => 'team_achievement',  'text' => 'Достижения'),
);
$transfer_link_array = array(
    array('url' => 'transfer_list',     'text' => 'Игроки на рынке'),
    array('url' => 'transfer_history',  'text' => 'Результаты сделок'),
);
$user_link_array = array(
    array('url' => 'user_view',             'text' => 'Информация', 'auth' => false),
    array('url' => 'user_achievement',      'text' => 'Достижения', 'auth' => false),
    array('url' => 'user_finance',          'text' => 'Личный счёт', 'auth' => false),
    array('url' => 'user_transfermoney',    'text' => 'Перевести деньги', 'auth' => true),
    array('url' => 'user_deal',             'text' => 'Сделки', 'auth' => false),
    array('url' => 'user_questionnaire',    'text' => 'Анкета', 'auth' => true),
    array('url' => 'user_holiday',          'text' => 'Отпуск', 'auth' => true),
    array('url' => 'user_password',         'text' => 'Пароль', 'auth' => true),
    array('url' => 'user_referral',         'text' => 'Подопечные', 'auth' => true),
);
$bonus_array = array(0 => 0, 10 => 2, 25 => 4, 50 => 6, 75 => 8, 100 => 10, 200 => 15, 300 => 20, 500 => 25);