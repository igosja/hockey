<?php

/**
 * Жребий по швейцарской системе одной пары
 * @var integer $position_difference разница в позиции
 */
function f_igosja_swiss_one($position_difference)
{
    $sql = "SELECT `swisstable_place`,
                   `swisstable_team_id`
            FROM `swisstable`
            WHERE `swisstable_home`>=`swisstable_guest`
            ORDER BY `swisstable_place` ASC
            LIMIT 1";
    $swisstable_sql = f_igosja_mysqli_query($sql);

    $swisstable_array = $swisstable_sql->fetch_all(1);

    $place      = $swisstable_array[0]['swisstable_place'];
    $home_id    = $swisstable_array[0]['swisstable_team_id'];

    $sql = "SELECT `swisstable_team_id`
            FROM `swisstable`
            WHERE `swisstable_team_id`!=$home_id
            AND `swisstable_home`<=`swisstable_guest`
            AND `swisstable_place` BETWEEN $place-$position_difference AND $place+$position_difference
            ORDER BY RAND()
            LIMIT 1";
    $swisstable_sql = f_igosja_mysqli_query($sql);

    if (0 == $swisstable_sql->num_rows)
    {
        return false;
    }

    $swisstable_array = $swisstable_sql->fetch_all(1);

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

    $check_array = $check_sql->fetch_all(1);

    if ($check_array[0]['check'])
    {
        if (f_igosja_swiss_one($position_difference))
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