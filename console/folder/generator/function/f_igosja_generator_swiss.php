<?php

/**
 * Проводимо жереб за швейцарською системою
 */
function f_igosja_generator_swiss()
{
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
            f_igosja_swiss($tournamenttype_id, 1);

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
}