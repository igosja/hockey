<?php

/**
 * Перераховуємо мітку авто в профілях менеджерів
 */
function f_igosja_generator_set_user_auto()
{
    $sql = "UPDATE `team`
            SET `team_auto`=`team_auto`+1
            WHERE `team_id` IN
            (
                SELECT `game_home_team_id`
                FROM `schedule`
                LEFT JOIN `game`
                ON `schedule_id`=`game_schedule_id`
                WHERE `game_home_auto`=1
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            )
            AND `team_user_id`!=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            SET `team_auto`=`team_auto`+1
            WHERE `team_id` IN
            (
                SELECT `game_guest_team_id`
                FROM `schedule`
                LEFT JOIN `game`
                ON `schedule_id`=`game_schedule_id`
                WHERE `game_guest_auto`=1
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            )
            AND `team_user_id`!=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            SET `team_auto`=0
            WHERE `team_id` IN
            (
                SELECT `game_home_team_id`
                FROM `schedule`
                LEFT JOIN `game`
                ON `schedule_id`=`game_schedule_id`
                WHERE `game_home_auto`=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            )
            AND `team_user_id`!=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            SET `team_auto`=0
            WHERE `team_id` IN
            (
                SELECT `game_guest_team_id`
                FROM `schedule`
                LEFT JOIN `game`
                ON `schedule_id`=`game_schedule_id`
                WHERE `game_guest_auto`=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            )
            AND `team_user_id`!=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            SET `team_auto`=5
            WHERE `team_auto`>5";
    f_igosja_mysqli_query($sql);
}