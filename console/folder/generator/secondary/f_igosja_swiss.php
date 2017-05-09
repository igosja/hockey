<?php

/**
 * Жребий по швейцарской системе
 * @var integer $tournamenttype_id
 * @var integer $position_difference разница в позиции (начинаем с минимума и постепенно увеличиваем)
 * @var integer $try попытка жребия с текущей разницей в позиции (до 5 попыток и увеличиваем разницу)
 */
function f_igosja_swiss($tournamenttype_id, $position_difference, $try)
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

    if (!f_igosja_swiss_one($position_difference))
    {
        $try++;

        if (5 < $try)
        {
            $try = 1;
            $position_difference++;
        }

        f_igosja_swiss($tournamenttype_id, $position_difference, $try);
    }

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