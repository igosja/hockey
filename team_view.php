<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_team_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_team_id)
    {
        redirect('/team_ask.php');
    }

    $num_get = $auth_team_id;
}

include (__DIR__ . '/include/sql/team_view_left.php');
include (__DIR__ . '/include/sql/team_view_right.php');

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `phisical_id`,
               `phisical_value`,
               `player_age`,
               `player_game_row`,
               `player_id`,
               `player_power_nominal`,
               `player_power_old`,
               `player_power_real`,
               `player_price`,
               `player_tire`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `phisical`
        ON `player_phisical_id`=`phisical_id`
        LEFT JOIN `playerposition`
        ON `player_id`=`playerposition_player_id`
        LEFT JOIN `playerspecial`
        ON `player_id`=`playerspecial_player_id`
        WHERE `player_team_id`=$num_get";
$player_sql = f_igosja_mysqli_query($sql);

$player_array = $player_sql->fetch_all(1);

$sql = "SELECT `team_power_s_16`,
               `team_power_s_21`,
               `team_power_s_27`,
               `team_power_vs`,
               `team_price_base`,
               `team_price_total`
        FROM `team`
        WHERE `team_id`=$num_get
        LIMIT 1";
$rating_sql = f_igosja_mysqli_query($sql);

$rating_array = $rating_sql->fetch_all(1);

$player_id = array();

foreach ($player_array as $item)
{
    $player_id[] = $item['player_id'];
}

if (count($player_id))
{
    $player_id = implode(', ', $player_id);

    $sql = "SELECT `playerposition_player_id`,
                   `position_name`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id` IN ($player_id)
            ORDER BY `playerposition_position_id` ASC";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $playerposition_array = $playerposition_sql->fetch_all(1);

    $sql = "SELECT `playerspecial_level`,
                   `playerspecial_player_id`,
                   `special_name`
            FROM `playerspecial`
            LEFT JOIN `special`
            ON `playerspecial_special_id`=`special_id`
            WHERE `playerspecial_player_id` IN ($player_id)
            ORDER BY `playerspecial_level` DESC, `playerspecial_special_id` ASC";
    $playerspecial_sql = f_igosja_mysqli_query($sql);

    $playerspecial_array = $playerspecial_sql->fetch_all(1);
}
else
{
    $playerposition_array   = array();
    $playerspecial_array    = array();
}

$notification_array = array(
    'В ближайшем матче ваша команда будет использовать супер',
    'В ближайшем матче ваша команда будет использовать отдых',
    'В вашей стране проходят выборы заместителя тренера молодёжной сборной, результаты можно посмотреть здесь',
    'В вашей стране проходят выборы заместителя тренера национальной сборной, результаты можно посмотреть здесь',
    'В вашей стране проходят выборы заместителя тренера юношеской сборной, результаты можно посмотреть здесь',
    'В вашей стране проходят выборы тренера молодёжной сборной, результаты можно посмотреть здесь',
    'В вашей стране проходят выборы тренера национальной сборной, результаты можно посмотреть здесь',
    'В вашей стране проходят выборы тренера юношеской сборной, результаты можно посмотреть здесь',
    'В вашей стране проходят выборы президента федерации',
    'Ваш тренировочный центр простаивает - осталось 15 баллов силы, 3 спецвозможности, 1 совмещение',
    'Ваш VIP-клуб заканчивается менее, чем через неделю - не забудьте продлить',
    'Ваша спортшкола простаивает - можно подготовить ещё одного молодого игрока для основной команды',
    'Доступна бонусная тренировка - 0 баллов силы, 1 совмещение, 0 спецвозможностей',
    'Открыт прием заявок от кандидатов в тренеры молодежных сборных',
    'Открыт прием заявок от кандидатов в тренеры национальных сборных',
    'Открыт прием заявок от кандидатов в тренеры юношеских сборных',
    'Открыт прием заявок от кандидатов на пост заместителя тренера молодёжной сборной вашей страны',
    'Открыт прием заявок от кандидатов на пост заместителя тренера национальной сборной вашей страны',
    'Открыт прием заявок от кандидатов на пост заместителя тренера юношеской сборной вашей страны',
    'Открыт прием заявок от кандидатов на пост президента федерации вашей стран',
);

include (__DIR__ . '/view/layout/main.php');