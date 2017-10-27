<?php

/**
 * @var $auth_team_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

if (0 == $auth_team_id)
{
    redirect('/team_ask.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `game_guest_team_id`,
               IF(`game_home_team_id`=$auth_team_id, IF(`game_home_mood_id`, `game_home_mood_id`, " . MOOD_NORMAL . "), IF(`game_guest_mood_id`, `game_guest_mood_id`, " . MOOD_NORMAL . ")) AS `game_mood_id`,
               IF(`game_home_team_id`=$auth_team_id, `game_home_rude_1_id`, `game_guest_rude_1_id`) AS `game_rude_1_id`,
               IF(`game_home_team_id`=$auth_team_id, `game_home_rude_2_id`, `game_guest_rude_2_id`) AS `game_rude_2_id`,
               IF(`game_home_team_id`=$auth_team_id, `game_home_rude_3_id`, `game_guest_rude_3_id`) AS `game_rude_3_id`,
               IF(`game_home_team_id`=$auth_team_id, `game_home_style_1_id`, `game_guest_style_1_id`) AS `game_style_1_id`,
               IF(`game_home_team_id`=$auth_team_id, `game_home_style_2_id`, `game_guest_style_2_id`) AS `game_style_2_id`,
               IF(`game_home_team_id`=$auth_team_id, `game_home_style_3_id`, `game_guest_style_3_id`) AS `game_style_3_id`,
               IF(`game_home_team_id`=$auth_team_id, IF(`game_home_tactic_1_id`, `game_home_tactic_1_id`, " . TACTIC_NORMAL . "), IF(`game_guest_tactic_1_id`, `game_guest_tactic_1_id`, " . TACTIC_NORMAL . ")) AS `game_tactic_1_id`,
               IF(`game_home_team_id`=$auth_team_id, IF(`game_home_tactic_2_id`, `game_home_tactic_2_id`, " . TACTIC_NORMAL . "), IF(`game_guest_tactic_2_id`, `game_guest_tactic_2_id`, " . TACTIC_NORMAL . ")) AS `game_tactic_2_id`,
               IF(`game_home_team_id`=$auth_team_id, IF(`game_home_tactic_3_id`, `game_home_tactic_3_id`, " . TACTIC_NORMAL . "), IF(`game_guest_tactic_3_id`, `game_guest_tactic_3_id`, " . TACTIC_NORMAL . ")) AS `game_tactic_3_id`,
               `game_ticket`
        FROM `game`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        WHERE (`game_guest_team_id`=$auth_team_id
        OR `game_home_team_id`=$auth_team_id)
        AND `game_played`=0
        AND `game_id`=$num_get
        LIMIT 1";
$current_sql = f_igosja_mysqli_query($sql, false);

if (0 == $current_sql->num_rows)
{
    redirect('/wrong_page.php');
}

if ($data = f_igosja_request_post('data'))
{
    if (isset($data['ticket']))
    {
        $ticket = (int) $data['ticket'];

        if (GAME_TICKET_MIN_PRICE > $ticket)
        {
            $ticket = GAME_TICKET_MIN_PRICE;
        }
        elseif (GAME_TICKET_MAX_PRICE < $ticket)
        {
            $ticket = GAME_TICKET_MAX_PRICE;
        }
    }
    else
    {
        $ticket = GAME_TICKET_MIN_PRICE;
    }

    $tactic_1_id    = (int) $data['tactic_1_id'];
    $tactic_2_id    = (int) $data['tactic_2_id'];
    $tactic_3_id    = (int) $data['tactic_3_id'];
    $rude_1_id      = (int) $data['rude_1_id'];
    $rude_2_id      = (int) $data['rude_2_id'];
    $rude_3_id      = (int) $data['rude_3_id'];
    $style_1_id     = (int) $data['style_1_id'];
    $style_2_id     = (int) $data['style_2_id'];
    $style_3_id     = (int) $data['style_3_id'];
    $mood_id        = (int) $data['mood_id'];
    $gk_id          = (int) $data['line'][0][0];
    $ld_1_id        = (int) $data['line'][1][1];
    $rd_1_id        = (int) $data['line'][1][2];
    $lw_1_id        = (int) $data['line'][1][3];
    $c_1_id         = (int) $data['line'][1][4];
    $rw_1_id        = (int) $data['line'][1][5];
    $ld_2_id        = (int) $data['line'][2][1];
    $rd_2_id        = (int) $data['line'][2][2];
    $lw_2_id        = (int) $data['line'][2][3];
    $c_2_id         = (int) $data['line'][2][4];
    $rw_2_id        = (int) $data['line'][2][5];
    $ld_3_id        = (int) $data['line'][3][1];
    $rd_3_id        = (int) $data['line'][3][2];
    $lw_3_id        = (int) $data['line'][3][3];
    $c_3_id         = (int) $data['line'][3][4];
    $rw_3_id        = (int) $data['line'][3][5];

    if (!in_array($tactic_1_id, array(TACTIC_DEFENCE_SUPER, TACTIC_DEFENCE, TACTIC_NORMAL, TACTIC_ATACK, TACTIC_ATACK_SUPER)))
    {
        $tactic_1_id = TACTIC_NORMAL;
    }

    if (!in_array($tactic_2_id, array(TACTIC_DEFENCE_SUPER, TACTIC_DEFENCE, TACTIC_NORMAL, TACTIC_ATACK, TACTIC_ATACK_SUPER)))
    {
        $tactic_2_id = TACTIC_NORMAL;
    }

    if (!in_array($tactic_3_id, array(TACTIC_DEFENCE_SUPER, TACTIC_DEFENCE, TACTIC_NORMAL, TACTIC_ATACK, TACTIC_ATACK_SUPER)))
    {
        $tactic_3_id = TACTIC_NORMAL;
    }

    if (!in_array($rude_1_id, array(RUDE_NORMAL, RUDE_RUDE)))
    {
        $rude_1_id = RUDE_NORMAL;
    }

    if (!in_array($rude_2_id, array(RUDE_NORMAL, RUDE_RUDE)))
    {
        $rude_2_id = RUDE_NORMAL;
    }

    if (!in_array($rude_3_id, array(RUDE_NORMAL, RUDE_RUDE)))
    {
        $rude_3_id = RUDE_NORMAL;
    }

    if (!in_array($style_1_id, array(STYLE_NORMAL, STYLE_POWER, STYLE_SPEED, STYLE_TECHNIQUE)))
    {
        $style_1_id = STYLE_NORMAL;
    }

    if (!in_array($style_2_id, array(STYLE_NORMAL, STYLE_POWER, STYLE_SPEED, STYLE_TECHNIQUE)))
    {
        $style_2_id = STYLE_NORMAL;
    }

    if (!in_array($style_3_id, array(STYLE_NORMAL, STYLE_POWER, STYLE_SPEED, STYLE_TECHNIQUE)))
    {
        $style_3_id = STYLE_NORMAL;
    }

    if (!in_array($mood_id, array(MOOD_SUPER, MOOD_NORMAL, MOOD_REST)))
    {
        $mood_id = MOOD_NORMAL;
    }

    $sql = "UPDATE `game`
            SET `game_home_mood_id`=$mood_id,
                `game_home_rude_1_id`=$rude_1_id,
                `game_home_rude_2_id`=$rude_2_id,
                `game_home_rude_3_id`=$rude_3_id,
                `game_home_style_1_id`=$style_1_id,
                `game_home_style_2_id`=$style_2_id,
                `game_home_style_3_id`=$style_3_id,
                `game_home_tactic_1_id`=$tactic_1_id,
                `game_home_tactic_2_id`=$tactic_2_id,
                `game_home_tactic_3_id`=$tactic_3_id,
                `game_ticket`=$ticket
            WHERE `game_home_team_id`=$auth_team_id
            AND `game_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql, false);

    $sql = "UPDATE `game`
            SET `game_guest_mood_id`=$mood_id,
                `game_guest_rude_1_id`=$rude_1_id,
                `game_guest_rude_2_id`=$rude_2_id,
                `game_guest_rude_3_id`=$rude_3_id,
                `game_guest_style_1_id`=$style_1_id,
                `game_guest_style_2_id`=$style_2_id,
                `game_guest_style_3_id`=$style_3_id,
                `game_guest_tactic_1_id`=$tactic_1_id,
                `game_guest_tactic_2_id`=$tactic_2_id,
                `game_guest_tactic_3_id`=$tactic_3_id
            WHERE `game_guest_team_id`=$auth_team_id
            AND `game_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql, false);

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
        else              { $line_id = 3; $position_id = 6; $player_id = $rw_3_id; }

        $sql = "SELECT COUNT(`player_id`) AS `check`
                FROM `player`
                WHERE `player_id`=$player_id
                AND `player_team_id`=$auth_team_id";
        $check_sql = f_igosja_mysqli_query($sql, false);

        $check_array = $check_sql->fetch_all(1);

        if (0 == $check_array[0]['check'])
        {
            $player_id = 0;
        }

        $sql = "SELECT `lineup_id`
                FROM `lineup`
                WHERE `lineup_game_id`=$num_get
                AND `lineup_line_id`=$line_id
                AND `lineup_position_id`=$position_id
                AND `lineup_team_id`=$auth_team_id
                LIMIT 1";
        $lineup_sql = f_igosja_mysqli_query($sql, false);

        if (0 == $lineup_sql->num_rows)
        {
            $sql = "INSERT INTO `lineup`
                    SET `lineup_game_id`=$num_get,
                        `lineup_line_id`=$line_id,
                        `lineup_player_id`=$player_id,
                        `lineup_position_id`=$position_id,
                        `lineup_team_id`=$auth_team_id";
            f_igosja_mysqli_query($sql, false);
        }
        else
        {
            $lineup_array = $lineup_sql->fetch_all(1);

            $lineup_id = $lineup_array[0]['lineup_id'];

            $sql = "UPDATE `lineup`
                    SET `lineup_player_id`=$player_id
                    WHERE `lineup_id`=$lineup_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql, false);
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
        WHERE `lineup_game_id`=$num_get
        AND `lineup_team_id`=$auth_team_id
        ORDER BY `lineup_id` ASC";
$lineup_sql = f_igosja_mysqli_query($sql, false);

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
               IF(`game_guest_team_id`=$auth_team_id, `game_guest_tactic_1_id`, `game_home_tactic_1_id`) AS `game_tactic_id`,
               IF(`game_guest_team_id`=$auth_team_id, 'Г', 'Д') AS `home_guest`,
               `schedule_date`,
               `stage_name`,
               `team_id`,
               `team_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        LEFT JOIN `tournamenttype`
        ON `schedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `schedule_stage_id`=`stage_id`
        LEFT JOIN `team`
        ON IF(`game_guest_team_id`=$auth_team_id, `game_home_team_id`, `game_guest_team_id`)=`team_id`
        WHERE (`game_guest_team_id`=$auth_team_id
        OR `game_home_team_id`=$auth_team_id)
        AND `game_played`=0
        ORDER BY `schedule_date` ASC
        LIMIT 5";
$game_sql = f_igosja_mysqli_query($sql, false);

$game_array = $game_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`,
               `line_color`,
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
        LEFT JOIN `line`
        ON `player_line_id`=`line_id`
        WHERE `player_team_id`=$auth_team_id
        ORDER BY `player_position_id` ASC, `player_id` ASC";
$player_sql = f_igosja_mysqli_query($sql, false);

$player_array = $player_sql->fetch_all(1);

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
    $playerposition_sql = f_igosja_mysqli_query($sql, false);

    $playerposition_array = $playerposition_sql->fetch_all(1);

    $sql = "SELECT `playerspecial_level`,
                   `playerspecial_player_id`,
                   `special_name`,
                   `special_short`
            FROM `playerspecial`
            LEFT JOIN `special`
            ON `playerspecial_special_id`=`special_id`
            WHERE `playerspecial_player_id` IN ($player_id)
            ORDER BY `playerspecial_level` DESC, `playerspecial_special_id` ASC";
    $playerspecial_sql = f_igosja_mysqli_query($sql, false);

    $playerspecial_array = $playerspecial_sql->fetch_all(1);
}
else
{
    $playerposition_array   = array();
    $playerspecial_array    = array();
}

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
        WHERE `player_team_id`=$auth_team_id
        AND `playerposition_position_id`=" . POSITION_GK . "
        ORDER BY `player_power_real` DESC";
$result_sql = f_igosja_mysqli_query($sql, false);

$gk_array = $result_sql->fetch_all(1);

$sql = "SELECT `name_name`,
               `player_id`,
               ROUND(IF(`playerposition_position_id`=" . POSITION_LD . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_LW . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_RD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_real`,
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
        WHERE `player_team_id`=$auth_team_id
        AND `playerposition_position_id`!=" . POSITION_GK . "
        ORDER BY `player_power_real` DESC";
$result_sql = f_igosja_mysqli_query($sql, false);

$ld_array = $result_sql->fetch_all(1);

$sql = "SELECT `name_name`,
               `player_id`,
               ROUND(IF(`playerposition_position_id`=" . POSITION_RD . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_RW . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_LD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_real`,
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
        WHERE `player_team_id`=$auth_team_id
        AND `playerposition_position_id`!=" . POSITION_GK . "
        ORDER BY `player_power_real` DESC";
$result_sql = f_igosja_mysqli_query($sql, false);

$rd_array = $result_sql->fetch_all(1);

$sql = "SELECT `name_name`,
               `player_id`,
               ROUND(IF(`playerposition_position_id`=" . POSITION_LW . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_C . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_LD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_real`,
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
        WHERE `player_team_id`=$auth_team_id
        AND `playerposition_position_id`!=" . POSITION_GK . "
        ORDER BY `player_power_real` DESC";
$result_sql = f_igosja_mysqli_query($sql, false);

$lw_array = $result_sql->fetch_all(1);

$sql = "SELECT `name_name`,
               `player_id`,
               ROUND(IF(`playerposition_position_id`=" . POSITION_C . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_LW . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_RW . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_real`,
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
        WHERE `player_team_id`=$auth_team_id
        AND `playerposition_position_id`!=" . POSITION_GK . "
        ORDER BY `player_power_real` DESC";
$result_sql = f_igosja_mysqli_query($sql, false);

$c_array = $result_sql->fetch_all(1);

$sql = "SELECT `name_name`,
               `player_id`,
               ROUND(IF(`playerposition_position_id`=" . POSITION_RW . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_C . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_RD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_real`,
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
        WHERE `player_team_id`=$auth_team_id
        AND `playerposition_position_id`!=" . POSITION_GK . "
        ORDER BY `player_power_real` DESC";
$result_sql = f_igosja_mysqli_query($sql, false);

$rw_array = $result_sql->fetch_all(1);

$sql = "SELECT `tactic_id`,
               `tactic_name`
        FROM `tactic`
        ORDER BY `tactic_id` ASC";
$tactic_sql = f_igosja_mysqli_query($sql, false);

$tactic_array = $tactic_sql->fetch_all(1);

$sql = "SELECT `rude_id`,
               `rude_name`
        FROM `rude`
        ORDER BY `rude_id` ASC";
$rude_sql = f_igosja_mysqli_query($sql, false);

$rude_array = $rude_sql->fetch_all(1);

$sql = "SELECT `style_id`,
               `style_name`
        FROM `style`
        ORDER BY `style_id` ASC";
$style_sql = f_igosja_mysqli_query($sql, false);

$style_array = $style_sql->fetch_all(1);

$sql = "SELECT `mood_id`,
               `mood_name`
        FROM `mood`
        ORDER BY `mood_id` ASC";
$mood_sql = f_igosja_mysqli_query($sql, false);

$mood_array = $mood_sql->fetch_all(1);

$seo_title          = 'Отправка состава на игру';
$seo_description    = 'Отправка состава на игру на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'отправка состава на игру';

include(__DIR__ . '/view/layout/main.php');