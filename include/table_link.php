<?php

$country_link_array = array(
    array('url' => 'country_team',      'text' => 'Команды'),
    array('url' => 'country_national',  'text' => 'Сборные'),
    array('url' => 'country_news',      'text' => 'Новости'),
    array('url' => 'country_finance',   'text' => 'Фонд'),
    array('url' => 'country_vote_list', 'text' => 'Опросы'),
    array('url' => 'country_league',    'text' => 'Лига Чемпионов'),
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
$shop_link_array = array(
    array('url' => 'shop',          'text' => 'Виртуальный магазин'),
    array('url' => 'shop_payment',  'text' => 'Пополнить счет'),
    array('url' => 'shop_gift',     'text' => 'Подарок другу'),
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