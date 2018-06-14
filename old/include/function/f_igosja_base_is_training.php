<?php

/**
 * Перевіряємо перед будівництвом чи хтось тренується
 * @param $num_get integer id команди
 * @return integer
 */
function f_igosja_base_is_training($num_get)
{
    $sql = "SELECT COUNT(`training_id`) AS `count`
            FROM `training`
            WHERE `training_team_id`=$num_get
            AND `training_ready`=0";
    $check_training_sql = f_igosja_mysqli_query($sql);

    $check_training_array = $check_training_sql->fetch_all(MYSQLI_ASSOC);

    $result = $check_training_array[0]['count'];

    return $result;
}