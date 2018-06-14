<?php

/**
 * Перевіряємо перед будівництвом чи хтось вивчається скаутами
 * @param $num_get integer id команди
 * @return integer
 */
function f_igosja_base_is_scout($num_get)
{
    $sql = "SELECT COUNT(`scout_id`) AS `count`
            FROM `scout`
            WHERE `scout_team_id`=$num_get
            AND `scout_ready`=0";
    $check_scout_sql = f_igosja_mysqli_query($sql);

    $check_scout_array = $check_scout_sql->fetch_all(MYSQLI_ASSOC);

    $result = $check_scout_array[0]['count'];

    return $result;
}