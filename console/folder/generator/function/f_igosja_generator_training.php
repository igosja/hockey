<?php

/**
 * Тренуємо граців
 */
function f_igosja_generator_training()
{
    $sql = "UPDATE `training`
            LEFT JOIN `team`
            ON `training_team_id`=`team_id`
            LEFT JOIN `basetraining`
            ON `team_basetraining_id`=`basetraining_id`
            SET `training_percent`=`training_percent`+`basetraining_training_speed_min`+(`basetraining_training_speed_max`-`basetraining_training_speed_min`)*RAND()
            WHERE `training_ready`=0";
    f_igosja_mysqli_query($sql);

    print '.';
    flush();
}