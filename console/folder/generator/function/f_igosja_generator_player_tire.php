<?php

/**
 * Усталость игроков
 */
function f_igosja_generator_player_tire()
{
    $sql = "UPDATE `player`
            LEFT JOIN `lineup`
            ON `player_id`=`lineup_player_id`
            LEFT JOIN `game`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `tournamenttype`
            ON `shedule_tournamenttype_id`=`tournamenttype_id`
            SET `player_mood_id`=IF(`lineup_team_id`=`game_home_team_id`, `game_home_mood_id`, `game_guest_mood_id`)
            WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `tournamenttype_daytype_id`
            FROM `shedule`
            LEFT JOIN `tournamenttype`
            ON `shedule_tournamenttype_id`=`tournamenttype_id`
            WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            LIMIT 1";
    $shedule_sql = f_igosja_mysqli_query($sql);

    $shedule_array = $shedule_sql->fetch_all(1);

    if (DAYTYPE_B == $shedule_array[0]['tournamenttype_daytype_id'])
    {
        $sql = "UPDATE `player`
                LEFT JOIN
                (
                    SELECT `playerspecial_level`,
                           `playerspecial_player_id`
                    FROM `playerspecial`
                    WHERE `playerspecial_special_id`=" . SPECIAL_ATHLETIC . "
                ) AS `t1`
                ON `playerspecial_player_id`=`player_id`
                SET `player_tire`=`player_tire`+IF((CEIL((`player_age`-12)/11)+`player_game_row`)*(1+`player_mood_id`)-IF(`playerspecial_level` IS NULL, 0, `playerspecial_level`)>0, (CEIL((`player_age`-12)/11)+`player_game_row`)*(1+`player_mood_id`)-IF(`playerspecial_level` IS NULL, 0, `playerspecial_level`), 0)
                WHERE `player_game_row`>0
                AND `player_age`<40
                AND `player_mood_id`>0";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `player`
                LEFT JOIN `team`
                ON `player_team_id`=`team_id`
                LEFT JOIN `basephisical`
                ON `team_basephisical_id`=`basephisical_id`
                SET `player_tire`=`player_tire`-IF(`player_game_row`<=-3, 4, IF(`player_game_row`=-2, 5, IF(`player_game_row_old`=1, 15, IF(`player_game_row_old`=2, 12, IF(`player_game_row_old`=3, 10, IF(`player_game_row_old`=4, 8, IF(`player_game_row_old`=5, 6, 5)))))))+`basephisical_tire_bonus`
                WHERE `player_game_row`<0
                AND `player_age`<40";
        f_igosja_mysqli_query($sql);
    }
    elseif (DAYTYPE_C == $shedule_array[0]['tournamenttype_daytype_id'])
    {
        $sql = "UPDATE `player`
                LEFT JOIN
                (
                    SELECT `playerspecial_level`,
                           `playerspecial_player_id`
                    FROM `playerspecial`
                    WHERE `playerspecial_special_id`=" . SPECIAL_ATHLETIC . "
                ) AS `t1`
                ON `playerspecial_player_id`=`player_id`
                LEFT JOIN `lineup`
                ON `player_id`=`lineup_player_id`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `shedule`
                ON `game_shedule_id`=`shedule_id`
                LEFT JOIN `tournamenttype`
                ON `shedule_tournamenttype_id`=`tournamenttype_id`
                SET `player_tire`=`player_tire`+IF((FLOOR((`player_age`-12)/11)+CEIL(`player_game_row`/2))*(1+`player_mood_id`)-IF(`playerspecial_level` IS NULL, 0, `playerspecial_level`)>0, (FLOOR((`player_age`-12)/11)+CEIL(`player_game_row`/2))*(1+`player_mood_id`)-IF(`playerspecial_level` IS NULL, 0, `playerspecial_level`)>0, 0)
                WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
                AND `player_game_row`>0
                AND `player_age`<40
                AND `player_mood_id`>0";
        f_igosja_mysqli_query($sql);
    }

    $sql = "UPDATE `player`
            SET `player_mood_id`=0
            WHERE `player_age`<40";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_tire`=90
            WHERE `player_tire`>90
            AND `player_age`<40";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_tire`=0
            WHERE `player_tire`<0
            AND `player_age`<40";
    f_igosja_mysqli_query($sql);

    print '.';
    flush();
}