<?php

/**
 * Проводимо жереб за швейцарською системою
 */
function f_igosja_generator_swiss()
{
    $sql = "SELECT `shedule_tournamenttype_id`
            FROM `shedule`
            WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            AND `shedule_tournamenttype_id` IN (" . TOURNAMENTTYPE_CONFERENCE . ", " . TOURNAMENTTYPE_OFFSEASON. ")
            LIMIT 1";
    $tournamenttype_sql = f_igosja_mysqli_query($sql);

    if ($tournamenttype_sql->num_rows)
    {
        $tournamenttype_array   = $tournamenttype_sql->fetch_all(1);
        $tournamenttype_id      = $tournamenttype_array[0]['shedule_tournamenttype_id'];

        f_igosja_swiss($tournamenttype_id, 1, 1);

        $sql = "SELECT `shedule_id`
                FROM `shedule`
                WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
                LIMIT 1";
        $shedule_sql = f_igosja_mysqli_query($sql);

        $shedule_array = $shedule_sql->fetch_all(1);

        $shedule_id = $shedule_array[0]['shedule_id'];

        $sql = "SELECT `shedule_id`
                FROM `shedule`
                WHERE `shedule_id`>$shedule_id
                AND `shedule_tournamenttype_id`=$tournamenttype_id
                ORDER BY `shedule_id` ASC
                LIMIT 1";
        $shedule_sql = f_igosja_mysqli_query($sql);

        $shedule_array = $shedule_sql->fetch_all(1);

        $shedule_id = $shedule_array[0]['shedule_id'];

        $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_shedule_id`, `game_stadium_id`)
                SELECT `swissgame_guest_team_id`, `swissgame_home_team_id`, $shedule_id, `team_stadium_id`
                FROM `swissgame`
                LEFT JOIN `team`
                ON `swissgame_home_team_id`=`team_id`";
        f_igosja_mysqli_query($sql);
    }

    usleep(1);

    print '.';
    flush();
}