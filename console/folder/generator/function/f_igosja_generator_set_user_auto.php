<?php

/**
 * Перераховуємо мітку авто в профілях менеджерів
 */
function f_igosja_generator_set_user_auto()
{
    $sql = "UPDATE `user`
            SET `user_auto`=`user_auto`+1
            WHERE `user_id` IN
            (
                SELECT `team_user_id`
                FROM `schedule`
                LEFT JOIN `game`
                ON `schedule_id`=`game_schedule_id`
                LEFT JOIN `team`
                ON `game_home_team_id`=`team_id`
                WHERE `game_home_auto`=1
                AND `team_user_id`!=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            )";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `user`
            SET `user_auto`=`user_auto`+1
            WHERE `user_id` IN
            (
                SELECT `team_user_id`
                FROM `schedule`
                LEFT JOIN `game`
                ON `schedule_id`=`game_schedule_id`
                LEFT JOIN `team`
                ON `game_guest_team_id`=`team_id`
                WHERE `game_guest_auto`=1
                AND `team_user_id`!=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            )";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `user`
            SET `user_auto`=0
            WHERE `user_id` IN
            (
                SELECT `team_user_id`
                FROM `schedule`
                LEFT JOIN `game`
                ON `schedule_id`=`game_schedule_id`
                LEFT JOIN `team`
                ON `game_home_team_id`=`team_id`
                WHERE `game_home_auto`=0
                AND `team_user_id`!=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            )";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `user`
            SET `user_auto`=0
            WHERE `user_id` IN
            (
                SELECT `team_user_id`
                FROM `schedule`
                LEFT JOIN `game`
                ON `schedule_id`=`game_schedule_id`
                LEFT JOIN `team`
                ON `game_guest_team_id`=`team_id`
                WHERE `game_guest_auto`=0
                AND `team_user_id`!=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            )";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `user`
            SET `user_auto`=5
            WHERE `user_auto`>5";
    f_igosja_mysqli_query($sql);
}