<?php

/**
 * @var $auth_national_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_national_id))
{
    redirect('/wrong_page.php');
}

if (0 == $auth_national_id)
{
    redirect('/national_ask.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `guest_national`.`national_visitor` AS `guest_national_visitor`,
               `home_national`.`national_visitor` AS `home_national_visitor`,
               `stadium_capacity`,
               `stage_visitor`,
               `tournamenttype_id`,
               `tournamenttype_visitor`
        FROM `game`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        LEFT JOIN `tournamenttype`
        ON `schedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `schedule_stage_id`=`stage_id`
        LEFT JOIN `national` AS `guest_national`
        ON `game_guest_national_id`=`guest_national`.`national_id`
        LEFT JOIN `national` AS `home_national`
        ON `game_home_national_id`=`home_national`.`national_id`
        LEFT JOIN `country`
        ON `home_national`.`national_country_id`=`country_id`
        LEFT JOIN `stadium`
        ON `home_national`.`national_stadium_id`=`stadium_id`
        WHERE (`game_guest_national_id`=$auth_national_id
        OR `game_home_national_id`=$auth_national_id)
        AND `game_played`=0
        AND `game_id`=$num_get
        LIMIT 1";
$game_sql = f_igosja_mysqli_query($sql);

if (0 == $game_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$guest_visitor          = $game_array[0]['guest_national_visitor'];
$home_visitor           = $game_array[0]['home_national_visitor'];
$stadium_capacity       = $game_array[0]['stadium_capacity'];
$stage_visitor          = $game_array[0]['stage_visitor'];
$tournamenttype_id      = $game_array[0]['tournamenttype_id'];
$tournamenttype_visitor = $game_array[0]['tournamenttype_visitor'];

$game_visitor = $stadium_capacity;
$game_visitor = $game_visitor * $tournamenttype_visitor;
$game_visitor = $game_visitor * $stage_visitor;

$visitor_array = array();

for ($i=10; $i<=50; $i++)
{
    $visitor = $game_visitor / pow(($i - GAME_TICKET_BASE_PRICE) / 10, 1.1);

    if (in_array($tournamenttype_id, array(TOURNAMENTTYPE_FRIENDLY, TOURNAMENTTYPE_NATIONAL)))
    {
        $visitor = $visitor * ($home_visitor + $guest_visitor) / 2;
    }
    else
    {
        $visitor = $visitor * ($home_visitor * 2 + $guest_visitor) / 3;
    }

    $visitor = $visitor / 1000000;
    $visitor = round($visitor);

    if ($visitor > $stadium_capacity)
    {
        $visitor = $stadium_capacity;
    }

    $visitor_array[$i] = $visitor;
}

$x_data = array_keys($visitor_array);
$x_data = implode(',', $x_data);
$s_data = implode(',', $visitor_array);

$seo_title          = 'График посещаемости на игру';
$seo_description    = 'График посещаемости на игру на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'график посещаемости на игру';

$tpl = 'game_visitor';

include(__DIR__ . '/view/layout/main.php');