<?php

/**
 * Перевіряємо перед будівництвом чи хтось є в спортшколі
 * @param $num_get integer id команди
 * @return integer
 */
function f_igosja_base_is_school($num_get)
{
    $sql = "SELECT COUNT(`school_id`) AS `count`
            FROM `school`
            WHERE `school_team_id`=$num_get
            AND `school_ready`=0";
    $check_school_sql = f_igosja_mysqli_query($sql);

    $check_school_array = $check_school_sql->fetch_all(MYSQLI_ASSOC);

    $result = $check_school_array[0]['count'];

    return $result;
}