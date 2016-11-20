<?php

include (__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

if (!$num_get = (int) f_igosja_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `game_guest_team_id`,
               IF(`game_home_team_id`='$auth_team_id', `game_home_mood_id`, `game_guest_mood_id`) AS `game_mood_id`,
               IF(`game_home_team_id`='$auth_team_id', `game_home_rude_id`, `game_guest_rude_id`) AS `game_rude_id`,
               IF(`game_home_team_id`='$auth_team_id', `game_home_style_id`, `game_guest_style_id`) AS `game_style_id`,
               IF(`game_home_team_id`='$auth_team_id', `game_home_tactic_id`, `game_guest_tactic_id`) AS `game_tactic_id`,
               `game_ticket`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        WHERE (`game_guest_team_id`='$auth_team_id'
        OR `game_home_team_id`='$auth_team_id')
        AND `game_played`='0'
        AND `game_id`='$num_get'
        LIMIT 1";
$current_sql = igosja_db_query($sql);

if (0 == $current_sql->num_rows)
{
    redirect('/wrong_page.php');
}

if ($data = f_igosja_post('data'))
{
    if (isset($data['ticket']))
    {
        $ticket = (int) $data['ticket'];
    }
    else
    {
        $ticket = 0;
    }

    $tactic_id  = (int) $data['tactic_id'];
    $rude_id    = (int) $data['rude_id'];
    $style_id   = (int) $data['style_id'];
    $mood_id    = (int) $data['mood_id'];
    $gk_id      = (int) $data['line'][0][0];
    $ld_1_id    = (int) $data['line'][1][1];
    $rd_1_id    = (int) $data['line'][1][2];
    $lw_1_id    = (int) $data['line'][1][3];
    $c_1_id     = (int) $data['line'][1][4];
    $rw_1_id    = (int) $data['line'][1][5];
    $ld_2_id    = (int) $data['line'][2][1];
    $rd_2_id    = (int) $data['line'][2][2];
    $lw_2_id    = (int) $data['line'][2][3];
    $c_2_id     = (int) $data['line'][2][4];
    $rw_2_id    = (int) $data['line'][2][5];
    $ld_3_id    = (int) $data['line'][3][1];
    $rd_3_id    = (int) $data['line'][3][2];
    $lw_3_id    = (int) $data['line'][3][3];
    $c_3_id     = (int) $data['line'][3][4];
    $rw_3_id    = (int) $data['line'][3][5];

    $sql = "UPDATE `game`
            SET `game_home_mood_id`='$mood_id',
                `game_home_rude_id`='$rude_id',
                `game_home_style_id`='$style_id',
                `game_home_tactic_id`='$tactic_id',
                `game_ticket`='$ticket'
            WHERE `game_home_team_id`='$auth_team_id'
            AND `game_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);

    $sql = "UPDATE `game`
            SET `game_guest_mood_id`='$mood_id',
                `game_guest_rude_id`='$rude_id',
                `game_guest_style_id`='$style_id',
                `game_guest_tactic_id`='$tactic_id'
            WHERE `game_guest_team_id`='$auth_team_id'
            AND `game_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);

    for ($i=0; $i<16; $i++)
    {
        if      (0 == $i) { $line_id = 0; $position_id = 1; $player_id =   $gk_id; }
        elseif  (1 == $i) { $line_id = 1; $position_id = 2; $player_id = $ld_1_id; }
        elseif  (2 == $i) { $line_id = 1; $position_id = 3; $player_id = $rd_1_id; }
        elseif  (3 == $i) { $line_id = 1; $position_id = 4; $player_id = $lw_1_id; }
        elseif  (4 == $i) { $line_id = 1; $position_id = 5; $player_id =  $c_1_id; }
        elseif  (5 == $i) { $line_id = 1; $position_id = 6; $player_id = $rw_1_id; }
        elseif  (6 == $i) { $line_id = 2; $position_id = 2; $player_id = $ld_2_id; }
        elseif  (7 == $i) { $line_id = 2; $position_id = 3; $player_id = $rd_2_id; }
        elseif  (8 == $i) { $line_id = 2; $position_id = 4; $player_id = $lw_2_id; }
        elseif  (9 == $i) { $line_id = 2; $position_id = 5; $player_id =  $c_2_id; }
        elseif (10 == $i) { $line_id = 2; $position_id = 6; $player_id = $rw_2_id; }
        elseif (11 == $i) { $line_id = 3; $position_id = 2; $player_id = $ld_3_id; }
        elseif (12 == $i) { $line_id = 3; $position_id = 3; $player_id = $rd_3_id; }
        elseif (13 == $i) { $line_id = 3; $position_id = 4; $player_id = $lw_3_id; }
        elseif (14 == $i) { $line_id = 3; $position_id = 5; $player_id =  $c_3_id; }
        elseif (15 == $i) { $line_id = 3; $position_id = 6; $player_id = $rw_3_id; }

        $sql = "SELECT `lineup_id`
                FROM `lineup`
                WHERE `lineup_game_id`='$num_get'
                AND `lineup_line_id`='$line_id'
                AND `lineup_position_id`='$position_id'
                AND `lineup_team_id`='$auth_team_id'
                LIMIT 1";
        $lineup_sql = igosja_db_query($sql);

        if (0 == $lineup_sql->num_rows)
        {
            $sql = "INSERT INTO `lineup`
                    SET `lineup_game_id`='$num_get',
                        `lineup_line_id`='$line_id',
                        `lineup_player_id`='$player_id',
                        `lineup_position_id`='$position_id',
                        `lineup_team_id`='$auth_team_id'";
            igosja_db_query($sql);
        }
        else
        {
            $lineup_array = $lineup_sql->fetch_all(1);

            $lineup_id = $lineup_array[0]['lineup_id'];

            $sql = "UPDATE `lineup`
                    SET `lineup_player_id`='$player_id'
                    WHERE `lineup_id`='$lineup_id'
                    LIMIT 1";
            igosja_db_query($sql);
        }
    }

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Состав успешно отправлен.';

    refresh();
}

$current_array = $current_sql->fetch_all(1);

$gk_id      = 0;
$ld_1_id    = 0;
$rd_1_id    = 0;
$lw_1_id    = 0;
$c_1_id     = 0;
$rw_1_id    = 0;
$ld_2_id    = 0;
$rd_2_id    = 0;
$lw_2_id    = 0;
$c_2_id     = 0;
$rw_2_id    = 0;
$ld_3_id    = 0;
$rd_3_id    = 0;
$lw_3_id    = 0;
$c_3_id     = 0;
$rw_3_id    = 0;

$sql = "SELECT `lineup_line_id`,
               `lineup_player_id`,
               `lineup_position_id`
        FROM `lineup`
        WHERE `lineup_game_id`='$num_get'
        AND `lineup_team_id`='$auth_team_id'
        ORDER BY `lineup_id` ASC";
$lineup_sql = igosja_db_query($sql);

$lineup_array = $lineup_sql->fetch_all(1);

foreach ($lineup_array as $item)
{
    if     (0 == $item['lineup_line_id'] && 1 == $item['lineup_position_id']) { $gk_id   = $item['lineup_player_id']; }
    elseif (1 == $item['lineup_line_id'] && 2 == $item['lineup_position_id']) { $ld_1_id = $item['lineup_player_id']; }
    elseif (1 == $item['lineup_line_id'] && 3 == $item['lineup_position_id']) { $rd_1_id = $item['lineup_player_id']; }
    elseif (1 == $item['lineup_line_id'] && 4 == $item['lineup_position_id']) { $lw_1_id = $item['lineup_player_id']; }
    elseif (1 == $item['lineup_line_id'] && 5 == $item['lineup_position_id']) { $c_1_id  = $item['lineup_player_id']; }
    elseif (1 == $item['lineup_line_id'] && 6 == $item['lineup_position_id']) { $rw_1_id = $item['lineup_player_id']; }
    elseif (2 == $item['lineup_line_id'] && 2 == $item['lineup_position_id']) { $ld_2_id = $item['lineup_player_id']; }
    elseif (2 == $item['lineup_line_id'] && 3 == $item['lineup_position_id']) { $rd_2_id = $item['lineup_player_id']; }
    elseif (2 == $item['lineup_line_id'] && 4 == $item['lineup_position_id']) { $lw_2_id = $item['lineup_player_id']; }
    elseif (2 == $item['lineup_line_id'] && 5 == $item['lineup_position_id']) { $c_2_id  = $item['lineup_player_id']; }
    elseif (2 == $item['lineup_line_id'] && 6 == $item['lineup_position_id']) { $rw_2_id = $item['lineup_player_id']; }
    elseif (3 == $item['lineup_line_id'] && 2 == $item['lineup_position_id']) { $ld_3_id = $item['lineup_player_id']; }
    elseif (3 == $item['lineup_line_id'] && 3 == $item['lineup_position_id']) { $rd_3_id = $item['lineup_player_id']; }
    elseif (3 == $item['lineup_line_id'] && 4 == $item['lineup_position_id']) { $lw_3_id = $item['lineup_player_id']; }
    elseif (3 == $item['lineup_line_id'] && 5 == $item['lineup_position_id']) { $c_3_id  = $item['lineup_player_id']; }
    elseif (3 == $item['lineup_line_id'] && 6 == $item['lineup_position_id']) { $rw_3_id = $item['lineup_player_id']; }
}

$sql = "SELECT `game_id`,
               IF(`game_guest_team_id`='$auth_team_id', `game_guest_tactic_id`, `game_home_tactic_id`) AS `game_tactic_id`,
               IF(`game_guest_team_id`='$auth_team_id', 'Г', 'Д') AS `home_guest`,
               `shedule_date`,
               `stage_name`,
               `team_id`,
               `team_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `shedule_stage_id`=`stage_id`
        LEFT JOIN `team`
        ON IF(`game_guest_team_id`='$auth_team_id', `game_home_team_id`, `game_guest_team_id`)=`team_id`
        WHERE (`game_guest_team_id`='$auth_team_id'
        OR `game_home_team_id`='$auth_team_id')
        AND `game_played`='0'
        ORDER BY `shedule_date` ASC
        LIMIT 5";
$game_sql = igosja_db_query($sql);

$game_array = $game_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `player_power_real`,
               `player_tire`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        WHERE `player_team_id`='$auth_team_id'
        ORDER BY `player_id` ASC";
$player_sql = igosja_db_query($sql);

$player_array = $player_sql->fetch_all(1);

for ($i=1; $i<=6; $i++)
{
    if     (1 == $i) { $array_name = 'gk_array'; }
    elseif (2 == $i) { $array_name = 'ld_array'; }
    elseif (3 == $i) { $array_name = 'rd_array'; }
    elseif (4 == $i) { $array_name = 'lw_array'; }
    elseif (5 == $i) { $array_name =  'c_array'; }
    elseif (6 == $i) { $array_name = 'rw_array'; }

    $sql = "SELECT `name_name`,
                   `player_id`,
                   `player_power_real`,
                   `position_name`,
                   `surname_name`
            FROM `player`
            LEFT JOIN `playerposition`
            ON `player_id`=`playerposition_player_id`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            LEFT JOIN `name`
            ON `player_name_id`=`name_id`
            LEFT JOIN `surname`
            ON `player_surname_id`=`surname_id`
            WHERE `player_team_id`='$auth_team_id'
            AND `playerposition_position_id`='$i'
            ORDER BY `player_power_real` DESC";
    $result_sql = igosja_db_query($sql);

    $$array_name = $result_sql->fetch_all(1);
}

$sql = "SELECT `tactic_id`,
               `tactic_name`
        FROM `tactic`
        ORDER BY `tactic_id` ASC";
$tactic_sql = igosja_db_query($sql);

$tactic_array = $tactic_sql->fetch_all(1);

$sql = "SELECT `rude_id`,
               `rude_name`
        FROM `rude`
        ORDER BY `rude_id` ASC";
$rude_sql = igosja_db_query($sql);

$rude_array = $rude_sql->fetch_all(1);

$sql = "SELECT `style_id`,
               `style_name`
        FROM `style`
        ORDER BY `style_id` ASC";
$style_sql = igosja_db_query($sql);

$style_array = $style_sql->fetch_all(1);

$sql = "SELECT `mood_id`,
               `mood_name`
        FROM `mood`
        ORDER BY `mood_id` ASC";
$mood_sql = igosja_db_query($sql);

$mood_array = $mood_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');