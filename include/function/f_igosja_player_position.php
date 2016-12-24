<?php

function f_igosja_player_position($player_id)
{
    $sql = "SELECT `position_name`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id`='$player_id'";
    $position_sql = f_igosja_mysqli_query($sql);

    $position_array = $position_sql->fetch_all(1);

    $return_array = array();

    foreach ($position_array as $item)
    {
        $return_array[] = $item['position_name'];
    }

    $return = implode('/', $return_array);

    return $return;
}