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
        $game_array = f_igosja_swiss_game_new($tournamenttype_id);

        print_r($game_array);

        // $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

        // $schedule_id = $schedule_array[0]['schedule_id'];

        // $values = array();

        // foreach ($game_array as $item)
        // {
            // $values[] = '(' . $item['guest'] . ', ' . $item['home'] . ', ' . $schedule_id . ')';
        // }

        // $values = implode(',', $values);

        // $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`)
                // VALUES $values;";
        // f_igosja_mysqli_query($sql);

        // $sql = "UPDATE `game`
                // LEFT JOIN `team`
                // ON `game_home_team_id`=`team_id`
                // SET `game_stadium_id`=`team_stadium_id`
                // WHERE `game_schedule_id`=$schedule_id";
        // f_igosja_mysqli_query($sql);
    }
}

function f_igosja_swiss_game_new($tournamenttype_id)
{
    $position_difference = 1;

    $team_array = f_igosja_swiss_prepare($tournamenttype_id);
    $game_array = f_igosja_swiss_new($tournamenttype_id, $position_difference, $team_array);

    return $game_array;
}

function f_igosja_swiss_prepare($tournamenttype_id)
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

        $max_count = 1;
    }
    else
    {
        $sql = "INSERT INTO `swisstable` (`swisstable_guest`, `swisstable_home`, `swisstable_place`, `swisstable_team_id`)
                SELECT `conference_guest`, `conference_home`, `conference_place`, `conference_team_id`
                FROM `conference`
                WHERE `conference_season_id`=$igosja_season_id
                ORDER BY `conference_place` ASC";
        f_igosja_mysqli_query($sql);

        $max_count = 2;
    }

    $sql = "SELECT `swisstable_guest`,
                   `swisstable_home`,
                   `swisstable_place`,
                   `swisstable_team_id`
            FROM `swisstable`
            ORDER BY `swisstable_id` ASC";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$team_sql->num_rows; $i++)
    {
        $team_id = $team_array[$i]['swisstable_team_id'];

        $sql = "SELECT `swisstable_team_id`
                FROM `swisstable`
                WHERE `swisstable_team_id`!=$team_id
                AND `swisstable_team_id` NOT IN
                (
                    SELECT IF(`game_home_team_id`=$team_id, `game_guest_team_id`, `game_home_team_id`) AS `team_id`
                    FROM `game`
                    LEFT JOIN `schedule`
                    ON `game_schedule_id`=`schedule_id`
                    WHERE (`game_home_team_id`=$team_id
                    OR `game_guest_team_id`=$team_id)
                    AND `schedule_tournamenttype_id`=$tournamenttype_id
                    AND `schedule_season_id`=$igosja_season_id
                    HAVING COUNT(`game_id`)>$max_count
                )
                ORDER BY swisstable_id` ASC";
        $free_sql = f_igosja_mysqli_query($sql);

        $free_array = $free_sql->fetch_all(MYSQLI_ASSOC);

        $free_id = array();

        foreach ($free_array as $item)
        {
            $free_id[] = $item['swisstable_team_id']
        }

        $team_array[$i]['opponent'] = $free_id;
    }

    return $team_array;
}

function f_igosja_swiss_new($tournamenttype_id, $position_difference, $team_array)
{
    if (!$game_array = f_igosja_swiss_one_new($tournamenttype_id, $position_difference, $team_array))
    {
        $position_difference++;

        $game_array = f_igosja_swiss_new($tournamenttype_id, $position_difference, $team_array);
    }

    return $game_array;
}

function f_igosja_swiss_one_new($tournamenttype_id, $position_difference, $team_array, $game_array = array())
{
    $home_team  = f_igosja_get_swiss_home_team($team_array);
    $guest_team = f_igosja_get_swiss_guest_team($team_array, $home_team, $position_difference);

    if (!$guest_team)
    {
        return false;
    }

    $game_array[] = array('home' => $home_team['team_id'], 'guest' => $guest_team['team_id']);

    unset($team_array[$home_team['i']]);
    unset($team_array[$guest_team['i']]);

    $team_array = array_values($team_array);

    if (count($team_array))
    {
        $game_array = f_igosja_swiss_one_new($tournamenttype_id, $position_difference, $team_array, $game_array);
    }

    return $game_array;
}

function f_igosja_get_swiss_home_team($team_array)
{
    for ($i=0, $count_team=count($team_array); $i<$count_team; $i++)
    {
        if ($team_array[$i]['swisstable_home'] >= $team_array[$i]['swisstable_guest'])
        {
            return array(
                'i'         => $i,
                'team_id'   => $team_array[$i]['swisstable_team_id'],
                'place'     => $team_array[$i]['swisstable_place'],
                'opponent'  => $team_array[$i]['opponent'],
            );
        }
    }
}

function f_igosja_get_swiss_guest_team($team_array, $home_team, $position_difference)
{
    for ($i=0, $count_team=count($team_array); $i<$count_team; $i++)
    {
        if (
            $team_array[$i]['swisstable_home'] <= $team_array[$i]['swisstable_guest']
            && $team_array[$i]['swisstable_place'] >= $home_team['place'] - $position_difference
            && $team_array[$i]['swisstable_place'] <= $home_team['place'] + $position_difference
            && $team_array[$i]['swisstable_team_id'] != $home_team['team_id']
            && in_array($home_team['team_id'], $team_array[$i]['opponent'])
            && in_array($team_array[$i]['swisstable_team_id'], $home_team['opponent'])
        )
        {
            return array(
                'i'         => $i,
                'team_id'   => $team_array[$i]['swisstable_team_id'],
            );
        }
    }

    return false;
}