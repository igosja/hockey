<?php

/**
 * Жереб за швейцарською системою однієї пари
 * @param $tournamenttype_id integer
 * @param $position_difference integer різниця в позиції
 * @return boolean мітка про успішніть жеребу (true - все добре)
 */
function f_igosja_swiss_one($tournamenttype_id, $position_difference)
{
    global $igosja_season_id;

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