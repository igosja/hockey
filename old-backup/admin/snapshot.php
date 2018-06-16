<?php

/**
 * @var $igosja_season_id
 */
include(__DIR__ . '/../include/include.php');

$category_array = array(
    1 => array(
        'name' => 'Средний размер базы',
        'select' => '`snapshot_base`',
    ),
    2 => array(
        'name' => 'Средний размер баз (все строения)',
        'select' => '`snapshot_base_total`',
    ),
    3 => array(
        'name' => 'Средний размер мед. центра',
        'select' => '`snapshot_basemedical`',
    ),
    4 => array(
        'name' => 'Средний размер физиоцентра',
        'select' => '`snapshot_basephisical`',
    ),
    5 => array(
        'name' => 'Средний размер спортшколы',
        'select' => '`snapshot_baseschool`',
    ),
    6 => array(
        'name' => 'Средний размер скаутцентра',
        'select' => '`snapshot_basescout`',
    ),
    7 => array(
        'name' => 'Средний размер трен. центра',
        'select' => '`snapshot_basetraining`',
    ),
    8 => array(
        'name' => 'Всего федераций',
        'select' => '`snapshot_country`',
    ),
    9 => array(
        'name' => 'Всего менеджеров',
        'select' => '`snapshot_manager`',
    ),
    10 => array(
        'name' => 'VIP менеджеров',
        'select' => '`snapshot_manager_vip_percent`',
    ),
    11 => array(
        'name' => 'Менеджеров с командами',
        'select' => '`snapshot_manager_with_team`',
    ),
    12 => array(
        'name' => 'Число игроков в командах',
        'select' => '`snapshot_player`',
    ),
    13 => array(
        'name' => 'Средний возраст игрока',
        'select' => '`snapshot_player_age`',
    ),
    14 => array(
        'name' => 'Пизиция C',
        'select' => '`snapshot_player_c`',
    ),
    15 => array(
        'name' => 'Пизиция GK',
        'select' => '`snapshot_player_gk`',
    ),
    16 => array(
        'name' => 'Игроков в команде в среднем',
        'select' => '`snapshot_player_in_team`',
    ),
    17 => array(
        'name' => 'Пизиция LD',
        'select' => '`snapshot_player_ld`',
    ),
    18 => array(
        'name' => 'Пизиция LW',
        'select' => '`snapshot_player_lw`',
    ),
    19 => array(
        'name' => 'Пизиция RD',
        'select' => '`snapshot_player_rd`',
    ),
    20 => array(
        'name' => 'Пизиция RW',
        'select' => '`snapshot_player_rw`',
    ),
    21 => array(
        'name' => 'Средняя сила игрока',
        'select' => '`snapshot_player_power`',
    ),
    22 => array(
        'name' => 'Игроков без спецвозможностей',
        'select' => '`snapshot_player_special_percent_no`',
    ),
    23 => array(
        'name' => 'Игроков с одной спецвозможностью',
        'select' => '`snapshot_player_special_percent_one`',
    ),
    24 => array(
        'name' => 'Игроков с двумя спецвозможностями',
        'select' => '`snapshot_player_special_percent_two`',
    ),
    25 => array(
        'name' => 'Игроков с тремя спецвозможностями',
        'select' => '`snapshot_player_special_percent_three`',
    ),
    26 => array(
        'name' => 'Игроков с четырьмя спецвозможностями',
        'select' => '`snapshot_player_special_percent_four`',
    ),
    27 => array(
        'name' => 'Игроков со спецвозможностью Атлетизм (Ат)',
        'select' => '`snapshot_player_special_percent_athletic`',
    ),
    28 => array(
        'name' => 'Игроков со спецвозможностью Техника (Т)',
        'select' => '`snapshot_player_special_percent_combine`',
    ),
    29 => array(
        'name' => 'Игроков со спецвозможностью Кумир (К)',
        'select' => '`snapshot_player_special_percent_idol`',
    ),
    30 => array(
        'name' => 'Игроков со спецвозможностью Лидер (Л)',
        'select' => '`snapshot_player_special_percent_leader`',
    ),
    31 => array(
        'name' => 'Игроков со спецвозможностью Силовая борьба (Сб)',
        'select' => '`snapshot_player_special_percent_power`',
    ),
    32 => array(
        'name' => 'Игроков со спецвозможностью Реакция (Р)',
        'select' => '`snapshot_player_special_percent_reaction`',
    ),
    33 => array(
        'name' => 'Игроков со спецвозможностью Бросок (Бр)',
        'select' => '`snapshot_player_special_percent_shot`',
    ),
    34 => array(
        'name' => 'Игроков со спецвозможностью Скорость (Ск)',
        'select' => '`snapshot_player_special_percent_speed`',
    ),
    35 => array(
        'name' => 'Игроков со спецвозможностью Отбор (От)',
        'select' => '`snapshot_player_special_percent_tackle`',
    ),
    36 => array(
        'name' => 'Игроков с совмещениями',
        'select' => '`snapshot_player_with_position_percent`',
    ),
    37 => array(
        'name' => 'Всего команд',
        'select' => '`snapshot_team`',
    ),
    38 => array(
        'name' => 'Денег в среднем в кассе команды',
        'select' => '`snapshot_team_finance`',
    ),
    39 => array(
        'name' => 'Среднее число команд у менеджеров',
        'select' => '`snapshot_team_to_manager`',
    ),
    40 => array(
        'name' => 'Средний размер стадиона',
        'select' => '`snapshot_stadium`',
    ),
    41 => array(
        'name' => 'Игроков со спецвозможностью Игра клюшкой (Кл)',
        'select' => '`snapshot_player_special_percent_stick`',
    ),
    42 => array(
        'name' => 'Игроков со спецвозможностью Выбор позиции (П)',
        'select' => '`snapshot_player_special_percent_position`',
    ),
);

if (!$num_get = (int) f_igosja_request_get('num'))
{
    $num_get = 1;
}

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

$select = $category_array[$num_get]['select'];

$date_array     = array();
$value_array    = array();

$sql = "SELECT FROM_UNIXTIME(`snapshot_date`, '%d %m %Y') AS `date`,
               $select AS `total`
        FROM `snapshot`
        WHERE `snapshot_season_id`=$season_id
        ORDER BY `snapshot_id` ASC";
$snapshot_sql = f_igosja_mysqli_query($sql);

$snapshot_array = $snapshot_sql->fetch_all(MYSQLI_ASSOC);

foreach ($snapshot_array as $item)
{
    $date_array[]   = $item['date'];
    $value_array[]  = $item['total'];
}

$snapshot_categories    = '"' . implode('","', $date_array) . '"';
$snapshot_data          = implode(',', $value_array);

$sql = "SELECT `snapshot_season_id`
        FROM `snapshot`
        GROUP BY `snapshot_season_id`
        ORDER BY `snapshot_season_id` ASC";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

include(__DIR__ . '/view/layout/main.php');