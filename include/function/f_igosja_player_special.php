<?php

function f_igosja_player_special($player_id)
{
    $sql = "SELECT `playerspecial_level`,
                   `special_name`
            FROM `playerspecial`
            LEFT JOIN `special`
            ON `playerspecial_special_id`=`special_id`
            WHERE `playerspecial_player_id`='$player_id'";
    $special_sql = f_igosja_mysqli_query($sql);

    $special_array = $special_sql->fetch_all(1);

    $return_array = array();

    foreach ($special_array as $item)
    {
        $return_array[] = $item['special_name'] . $item['playerspecial_level'];
    }

    $return = implode(' ', $return_array);

    return $return;
}