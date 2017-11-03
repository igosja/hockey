<?php

/**
 * Жереб за швейцарською системою
 * @param $tournamenttype_id integer
 * @param $position_difference integer різниця в позиції (починаємо з мінімума і поступово збільшуємо)
 * @param $try integer спроба жереба з поточною різницею в позиції (до 20 спроб і збільшуємо різницю)
 */
function f_igosja_swiss($tournamenttype_id, $position_difference)
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

    if (!f_igosja_swiss_one($tournamenttype_id, $position_difference))
    {
        $position_difference++;

        f_igosja_swiss($tournamenttype_id, $position_difference);
    }
}