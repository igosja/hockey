<?php

/**
 * Зміна сили хокеїстів для графіка
 */
function f_igosja_generator_rating_change_player()
{
    $sql = "SELECT `schedule_id`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND `schedule_tournamenttype_id`!=" . TOURNAMENTTYPE_CONFERENCE . "
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    $schedule_id = $schedule_array[0]['schedule_id'];

    $sql = "UPDATE `ratingchangeplayer`
            LEFT JOIN `player`
            ON `ratingchangeplayer_player_id`=`player_id`
            SET `ratingchangeplayer_power`=`player_power_nominal`
            WHERE `ratingchangeplayer_schedule_id`=0";
    f_igosja_mysqli_query($sql);

    $sql = "INSERT INTO `ratingchangeplayer` (`ratingchangeplayer_player_id`, `ratingchangeplayer_power`, `ratingchangeplayer_schedule_id`)
            SELECT `player_id`, `player_power_nominal`, 0
            FROM `player`
            WHERE `player_id` NOT IN
            (
                SELECT `ratingchangeplayer_player_id`
                FROM `ratingchangeplayer`
                WHERE `ratingchangeplayer_schedule_id`=0
            )";
    f_igosja_mysqli_query($sql);

    $sql = "INSERT INTO `ratingchangeplayer` (`ratingchangeplayer_player_id`, `ratingchangeplayer_power`, `ratingchangeplayer_schedule_id`)
            SELECT `player_id`, `player_power_nominal`, $schedule_id
            FROM `player`
            LEFT JOIN `ratingchangeplayer`
            ON `player_id`=`ratingchangeplayer_player_id`
            WHERE `player_power_nominal`!=`ratingchangeplayer_power`
            AND `player_age`<40
            AND `ratingchangeplayer_schedule_id`=0";
    f_igosja_mysqli_query($sql);
}