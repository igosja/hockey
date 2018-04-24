<?php

/**
 * Готуємо массив команд для жеребу за швейцарською системою
 * @param $tournamenttype_id integer
 * @return array
 */
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
    }
    else
    {
        $sql = "INSERT INTO `swisstable` (`swisstable_guest`, `swisstable_home`, `swisstable_place`, `swisstable_team_id`)
                SELECT `conference_guest`, `conference_home`, `conference_place`, `conference_team_id`
                FROM `conference`
                WHERE `conference_season_id`=$igosja_season_id
                ORDER BY `conference_team_id` ASC";
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

    if (TOURNAMENTTYPE_OFFSEASON == $tournamenttype_id)
    {
        $max_count = 1;

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
                        GROUP BY `team_id`
                        HAVING COUNT(`game_id`)>=$max_count
                    )
                    ORDER BY `swisstable_id` ASC";
            $free_sql = f_igosja_mysqli_query($sql);

            $free_array = $free_sql->fetch_all(MYSQLI_ASSOC);

            $free_id = array();

            foreach ($free_array as $item)
            {
                $free_id[] = $item['swisstable_team_id'];
            }

            $team_array[$i]['opponent'] = $free_id;
        }
    }

    return $team_array;
}