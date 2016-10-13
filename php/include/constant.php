<?php

define('ADMIN_ITEMS_ON_PAGE', 10);
define('ADMIN_PAGES_IN_PAGINATION', 5);
define('EMAIL_INFO', 'info@' . $_SERVER['HTTP_HOST']);
define('LOGTEXT_TEAM_REGISTER', 1);
define('LOGTEXT_TEAM_RE_REGISTER', 2);
define('LOGTEXT_USER_MANAGER_TEAM_IN', 3);
define('LOGTEXT_USER_MANAGER_TEAM_OUT', 4);
define('LOGTEXT_USER_VICE_TEAM_IN', 5);
define('LOGTEXT_USER_VICE_TEAM_OUT', 6);
define('LOGTEXT_USER_MANAGER_NATIONAL_IN', 7);
define('LOGTEXT_USER_MANAGER_NATIONAL_OUT', 8);
define('LOGTEXT_USER_VICE_NATIONAL_IN', 9);
define('LOGTEXT_USER_VICE_NATIONAL_OUT', 10);
define('LOGTEXT_USER_PRESIDENT_IN', 11);
define('LOGTEXT_USER_PRESIDENT_OUT', 12);
define('LOGTEXT_USER_VICE_PRESIDENT_IN', 13);
define('LOGTEXT_USER_VICE_PRESIDENT_OUT', 14);
define('LOGTEXT_BUILDING_UP', 15);
define('LOGTEXT_BUILDING_DOWN', 16);
define('LOGTEXT_STADIUM_UP', 17);
define('LOGTEXT_STADIUM_DOWN', 18);
define('LOGTEXT_CHANGE_STYLE', 19);
define('LOGTEXT_CHANGE_SPECIAL', 20);
define('LOGTEXT_VIP_1_PLACE', 21);
define('LOGTEXT_VIP_2_PLACE', 22);
define('LOGTEXT_VIP_3_PLACE', 23);
define('LOGTEXT_VIP_WINNER', 24);
define('LOGTEXT_VIP_FINAL', 25);
define('LOGTEXT_PLAYER_FROM_SCHOOL', 26);
define('LOGTEXT_PLAYER_PENSION_SAY', 27);
define('LOGTEXT_PLAYER_PENSION_GO', 28);
define('LOGTEXT_PLAYER_TRAINING_POINT', 29);
define('LOGTEXT_PLAYER_TRAINING_POSITION', 30);
define('LOGTEXT_PLAYER_TRAINING_SPECIAL', 31);
define('LOGTEXT_PLAYER_GAME_POINT_PLUS', 32);
define('LOGTEXT_PLAYER_GAME_POINT_MINUS', 33);
define('LOGTEXT_PLAYER_CHAMPIONSHIP_SPECIAL', 34);
define('LOGTEXT_PLAYER_BONUS_POINT', 35);
define('LOGTEXT_PLAYER_BONUS_POSITION', 36);
define('LOGTEXT_PLAYER_BONUS_SPECIAL', 37);
define('LOGTEXT_PLAYER_INJURY', 38);
define('LOGTEXT_PLAYER_TRANSFER', 39);
define('LOGTEXT_PLAYER_EXCHANGE', 40);
define('LOGTEXT_PLAYER_RENT', 41);
define('LOGTEXT_PLAYER_RENT_BACK', 42);
define('LOGTEXT_PLAYER_FREE', 43);
define('PASSWORD_SALT', 'hockey');
define('POSITION_GK', 1);
define('POSITION_LD', 2);
define('POSITION_RD', 3);
define('POSITION_LW', 4);
define('POSITION_C', 5);
define('POSITION_RW', 6);
define('ROLE_ADMIN', 10);
define('SPACE', '&nbsp;');

$breadcrumb_array = array();
$team_link_array = array(
    array('url' => 'index', 'text' => 'Игроки'),
    array('url' => 'game', 'text' => 'Матчи'),
    array('url' => 'statistic', 'text' => 'Статистика'),
    array('url' => 'deal', 'text' => 'Сделки'),
    array('url' => 'event', 'text' => 'События'),
    array('url' => 'finance', 'text' => 'Финансы'),
    array('url' => 'achievement', 'text' => 'Достижения'),
);
$user_link_array = array(
    array('url' => 'index', 'text' => 'Информация'),
    array('url' => 'finance', 'text' => 'Личный счёт'),
    array('url' => 'transfermoney', 'text' => 'Перевести деньги'),
    array('url' => 'deal', 'text' => 'Сделки'),
    array('url' => 'questionnaire', 'text' => 'Анкета'),
    array('url' => 'holiday', 'text' => 'Отпуск'),
    array('url' => 'password', 'text' => 'Пароль'),
    array('url' => 'referral', 'text' => 'Подопечные'),
);