<?php

define('ADMIN_ITEMS_ON_PAGE', 10);
define('ADMIN_PAGES_IN_PAGINATION', 5);
define('BUILDING_BASE', 1);
define('BUILDING_BASEMEDICAL', 2);
define('BUILDING_BASEPHISICAL', 3);
define('BUILDING_BASESCHOOL', 4);
define('BUILDING_BASESCOUT', 5);
define('BUILDING_BASETRAINING', 6);
define('CONSTRUCTION_BUILD', 1);
define('CONSTRUCTION_DESTROY', 2);
define('EMAIL_INFO', 'info@' . $_SERVER['HTTP_HOST']);
define('GAME_LINEUP_QUANTITY', 16);
define('FINANCETEXT_INCOME_BUILDING_BASE', 17);
define('FINANCETEXT_INCOME_BUILDING_STADIUM', 15);
define('FINANCETEXT_INCOME_NATIONAL', 26);
define('FINANCETEXT_INCOME_PENSION', 25);
define('FINANCETEXT_INCOME_PRIZE_CHAMPIONSHIP', 4);
define('FINANCETEXT_INCOME_PRIZE_CONFERENCE', 5);
define('FINANCETEXT_INCOME_PRIZE_LEAGUE', 3);
define('FINANCETEXT_INCOME_PRIZE_OFFSEASON', 6);
define('FINANCETEXT_INCOME_PRIZE_VIP', 1);
define('FINANCETEXT_INCOME_PRIZE_WORLDCUP', 2);
define('FINANCETEXT_INCOME_RENT', 21);
define('FINANCETEXT_INCOME_TICKET', 7);
define('FINANCETEXT_INCOME_TRANSFER', 18);
define('FINANCETEXT_INCOME_TRANSFER_FIRST_TEAM', 20);
define('FINANCETEXT_OUTCOME_BUILDING_BASE', 16);
define('FINANCETEXT_OUTCOME_BUILDING_STADIUM', 14);
define('FINANCETEXT_OUTCOME_GAME', 8);
define('FINANCETEXT_OUTCOME_MAINTENANCE', 23);
define('FINANCETEXT_OUTCOME_RENT', 22);
define('FINANCETEXT_OUTCOME_SALARY', 9);
define('FINANCETEXT_OUTCOME_SCOUT_STYLE', 13);
define('FINANCETEXT_OUTCOME_TRAINING_POSITION', 10);
define('FINANCETEXT_OUTCOME_TRAINING_POWER', 12);
define('FINANCETEXT_OUTCOME_TRAINING_SPECIAL', 11);
define('FINANCETEXT_OUTCOME_TRANSFER', 19);
define('FINANCETEXT_TEAM_REREGISTER', 24);
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
define('STADIUM_ONE_SIT_PICE_BUY', 200);
define('STADIUM_ONE_SIT_PICE_SELL', 150);
define('STAGE_1_TOUR', 2);
define('TOURNAMENTTYPE_NATIONAL', 1);
define('TOURNAMENTTYPE_LEAGUE', 2);
define('TOURNAMENTTYPE_CHAMPIONSHIP', 3);
define('TOURNAMENTTYPE_CONFERENCE', 4);
define('TOURNAMENTTYPE_OFFSEASON', 5);
define('TOURNAMENTTYPE_FRIENDLY', 6);
define('VOTESTATUS_NEW', 1);
define('VOTESTATUS_OPEN', 2);
define('VOTESTATUS_CLOSE', 3);

$breadcrumb_array = array();
$player_link_array = array(
    array('url' => 'player_view', 'text' => 'Матчи'),
    array('url' => 'player_statistic', 'text' => 'Статистика'),
    array('url' => 'player_event', 'text' => 'События'),
    array('url' => 'player_deal', 'text' => 'Сделки'),
    array('url' => 'player_transfer', 'text' => 'Трансфер'),
    array('url' => 'player_rent', 'text' => 'Аренда'),
    array('url' => 'player_achievement', 'text' => 'Достижения'),
);
$register_link_array = array(
    array('url' => 'signup', 'url2' => '', 'text' => 'Регистрация'),
    array('url' => 'password', 'url2' => 'password_restore', 'text' => 'Забыли пароль?'),
    array('url' => 'activation', 'url2' => 'activation_repeat', 'text' => 'Активация аккаунта'),
);
$stadium_link_array = array(
    array('url' => 'stadium_increase', 'text' => 'Расширить стадион'),
    array('url' => 'stadium_decrease', 'text' => 'Уменьшить стадион'),
);
$team_link_array = array(
    array('url' => 'team_view', 'text' => 'Игроки'),
    array('url' => 'team_game', 'text' => 'Матчи'),
    array('url' => 'team_statistic', 'text' => 'Статистика'),
    array('url' => 'team_deal', 'text' => 'Сделки'),
    array('url' => 'team_event', 'text' => 'События'),
    array('url' => 'team_finance', 'text' => 'Финансы'),
    array('url' => 'team_achievement', 'text' => 'Достижения'),
);
$user_link_array = array(
    array('url' => 'user_view', 'text' => 'Информация'),
    array('url' => 'user_finance', 'text' => 'Личный счёт'),
    array('url' => 'user_transfermoney', 'text' => 'Перевести деньги'),
    array('url' => 'user_deal', 'text' => 'Сделки'),
    array('url' => 'user_questionnaire', 'text' => 'Анкета'),
    array('url' => 'user_holiday', 'text' => 'Отпуск'),
    array('url' => 'user_password', 'text' => 'Пароль'),
    array('url' => 'user_referral', 'text' => 'Подопечные'),
);

$sql = "SELECT `season_id`
        FROM `season`
        ORDER BY `season_id` DESC
        LIMIT 1";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(1);

$igosja_season_id = $season_array[0]['season_id'];