<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `schedule_tournamenttype_id`
        FROM `schedule`
        WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
        AND `schedule_tournamenttype_id` IN (" . TOURNAMENTTYPE_CONFERENCE . ", " . TOURNAMENTTYPE_OFFSEASON. ")
        LIMIT 1";
$tournamenttype_sql = f_igosja_mysqli_query($sql);

if ($tournamenttype_sql->num_rows)
{
    $tournamenttype_array   = $tournamenttype_sql->fetch_all(MYSQLI_ASSOC);
    $tournamenttype_id      = $tournamenttype_array[0]['schedule_tournamenttype_id'];

    $sql = "SELECT `schedule_id`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND `schedule_tournamenttype_id`=$tournamenttype_id
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    $schedule_id = $schedule_array[0]['schedule_id'];

    $sql = "SELECT `schedule_id`
            FROM `schedule`
            WHERE `schedule_id`>$schedule_id
            AND `schedule_tournamenttype_id`=$tournamenttype_id
            ORDER BY `schedule_id` ASC
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    if ($schedule_sql->num_rows)
    {
        f_igosja_swiss_new($tournamenttype_id, 1);

        $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

        $schedule_id = $schedule_array[0]['schedule_id'];

        $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                SELECT `swissgame_guest_team_id`, `swissgame_home_team_id`, $schedule_id, `team_stadium_id`
                FROM `swissgame`
                LEFT JOIN `team`
                ON `swissgame_home_team_id`=`team_id`";
        f_igosja_mysqli_query($sql);
    }
}

function f_igosja_swiss_new($tournamenttype_id, $position_difference)
{
    global $igosja_season_id;

    $sql = "TRUNCATE TABLE `swisstable`;";
    f_igosja_mysqli_query($sql);

    $sql = "TRUNCATE TABLE `swissgame`;";
    f_igosja_mysqli_query($sql);

    if (TOURNAMENTTYPE_OFFSEASON == $tournamenttype_id)
    {
        $sql = "INSERT INTO `swisstable` (`swisstable_guest`, `swisstable_home`, `swisstable_place`, `swisstable_team_id`)
                SELECT `offseason_guest`, `offseason_home`, `offseason_place`, `offseason_team_id`
                FROM `offseason`
                WHERE `offseason_season_id`=$igosja_season_id
                ORDER BY `offseason_place` ASC";
        f_igosja_mysqli_query($sql);
    }
    else
    {
        $sql = "INSERT INTO `swisstable` (`swisstable_guest`, `swisstable_home`, `swisstable_place`, `swisstable_team_id`)
                SELECT `conference_guest`, `conference_home`, `conference_place`, `conference_team_id`
                FROM `conference`
                WHERE `conference_season_id`=$igosja_season_id
                ORDER BY `conference_place` ASC";
        f_igosja_mysqli_query($sql);
    }

    $sql = "SELECT `swisstable_guest`,
                   `swisstable_home`,
                   `swisstable_place`,
                   `swisstable_team_id`
            FROM `swisstable`
            ORDER BY `swisstable_id` ASC";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `game_home_team_id`,
                   `game_guest_team_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE `schedule_tournamenttype_id`=$tournamenttype_id
            AND `schedule_season_id`=$igosja_season_id
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    if (!f_igosja_swiss_one_new($tournamenttype_id, $position_difference, $team_array, $game_array))
    {
        $position_difference++;

        f_igosja_swiss($tournamenttype_id, $position_difference);
    }
}

function f_igosja_swiss_one_new($tournamenttype_id, $position_difference, $team_array, $game_array, $ready_game_array = array())
{
    $home_team = f_igosja_get_swiss_home_team_id($team_array);

    $home_id    = $home_team['team_id'];
    $place      = $home_team['place'];

    unset($team_array[$home_team['i']]);

    $team_array = array_values($team_array);

    //продолжить тут

    $sql = "SELECT `swisstable_place`,
                   `swisstable_team_id`
            FROM `swisstable`
            WHERE `swisstable_home`<=`swisstable_guest`
            ORDER BY `swisstable_place` ASC
            LIMIT 1";
    $swisstable_sql = f_igosja_mysqli_query($sql);

    $swisstable_array = $swisstable_sql->fetch_all(MYSQLI_ASSOC);

    $place      = $swisstable_array[0]['swisstable_place'];
    $home_id    = $swisstable_array[0]['swisstable_team_id'];

    $sql = "SELECT `swisstable_team_id`
            FROM `swisstable`
            WHERE `swisstable_team_id`!=$home_id
            AND `swisstable_home`>=`swisstable_guest`
            AND `swisstable_place` BETWEEN $place-$position_difference AND $place+$position_difference
            AND `swisstable_team_id` NOT IN
            (
                SELECT IF(`game_home_team_id`=$home_id, `game_guest_team_id`, `game_home_team_id`) AS `team_id`
                FROM `game`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                WHERE (`game_home_team_id`=$home_id
                OR `game_guest_team_id`=$home_id)
                AND `schedule_tournamenttype_id`=$tournamenttype_id
                AND `schedule_season_id`=$igosja_season_id
                HAVING COUNT(`game_id`)>2
            )
            ORDER BY RAND()
            LIMIT 1";
    $swisstable_sql = f_igosja_mysqli_query($sql);

    if (0 == $swisstable_sql->num_rows)
    {
        return false;
    }

    $swisstable_array = $swisstable_sql->fetch_all(MYSQLI_ASSOC);

    $guest_id = $swisstable_array[0]['swisstable_team_id'];

    $sql = "INSERT INTO `swissgame`
            SET `swissgame_guest_team_id`=$guest_id,
                `swissgame_home_team_id`=$home_id";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `swisstable`
            WHERE `swisstable_team_id` IN ($home_id, $guest_id)";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT COUNT(`swisstable_id`) AS `check`
            FROM `swisstable`";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if ($check_array[0]['check'])
    {
        if (f_igosja_swiss_one($tournamenttype_id, $position_difference))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return true;
    }
}

function f_igosja_get_swiss_home_team_id($team_array)
{
    for ($i=0, $count_team=count($team_array); $i<$count_team; $i++)
    {
        if ($team_array[$i]['swisstable_home'] >= $team_array[$i]['swisstable_guest'])
        {
            return array(
                'i'         => $i,
                'team_id'   => $team_array[$i]['swisstable_team_id'],
                'place'     => $team_array[$i]['swisstable_place'],
            );
        }
    }
}