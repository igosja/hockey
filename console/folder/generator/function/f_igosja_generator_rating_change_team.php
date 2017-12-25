<?php

/**
 * Зміна рейтингів команд для графіка
 */
function f_igosja_generator_rating_change_team()
{
    $sql = "SELECT `schedule_id`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND `schedule_tournamenttype_id`!=" . TOURNAMENTTYPE_CONFERENCE . "
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    $schedule_id = $schedule_array[0]['schedule_id'];

    $sql = "SELECT `ratingtype_id`
            FROM `ratingtype`
            WHERE `ratingtype_ratingchapter_id`=" . RATINGCHAPTER_TEAM . "
            ORDER BY `ratingtype_id` ASC";
    $ratingtype_sql = f_igosja_mysqli_query($sql);

    $ratingtype_array = $ratingtype_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($ratingtype_array as $item)
    {
        $ratingtype_id = $item['ratingtype_id'];

        if (in_array($ratingtype_id, array(
            RATING_TEAM_POWER,
            RATING_TEAM_AGE,
            RATING_TEAM_VISITOR,
            RATING_TEAM_PRICE_BASE,
            RATING_TEAM_PRICE_STADIUM,
            RATING_TEAM_PLAYER,
            RATING_TEAM_PRICE_TOTAL,
        )))
        {
            if (RATING_TEAM_POWER == $ratingtype_id)
            {
                $field = '`team_power_vs`';
            }
            elseif (RATING_TEAM_AGE == $ratingtype_id)
            {
                $field = '`team_age`';
            }
            elseif (RATING_TEAM_VISITOR == $ratingtype_id)
            {
                $field = '`team_visitor`';
            }
            elseif (RATING_TEAM_PRICE_BASE == $ratingtype_id)
            {
                $field = '`team_price_base`';
            }
            elseif (RATING_TEAM_PRICE_STADIUM == $ratingtype_id)
            {
                $field = '`team_price_stadium`';
            }
            elseif (RATING_TEAM_PLAYER == $ratingtype_id)
            {
                $field = '`team_price_player`';
            }
            else
            {
                $field = '`team_price_total`';
            }

            $sql = "UPDATE `ratingchangeteam`
                    LEFT JOIN `team`
                    ON `ratingchangeteam_team_id`=`team_id`
                    SET `ratingchangeteam_value`=$field
                    WHERE `ratingchangeteam_schedule_id`=0
                    AND `ratingchangeteam_ratintype_id`=$ratingtype_id";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `ratingchangeteam` (`ratingchangeteam_ratintype_id`, `ratingchangeteam_schedule_id`, `ratingchangeteam_team_id`, `ratingchangeteam_value`)
                    SELECT $ratingtype_id, 0, `team_id`, $field
                    FROM `team`
                    WHERE `team_id` NOT IN
                    (
                        SELECT `ratingchangeteam_team_id`
                        FROM `ratingchangeteam`
                        WHERE `ratingchangeteam_schedule_id`=0
                        AND `ratingchangeteam_ratintype_id`=$ratingtype_id
                    )";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `ratingchangeteam` (`ratingchangeteam_ratintype_id`, `ratingchangeteam_schedule_id`, `ratingchangeteam_team_id`, `ratingchangeteam_value`)
                    SELECT $ratingtype_id, $schedule_id, `team_id`, $field
                    FROM `team`
                    LEFT JOIN `ratingchangeteam`
                    ON `team_id`=`ratingchangeteam_team_id`
                    WHERE $field!=`ratingchangeteam_value`
                    AND `ratingchangeteam_schedule_id`=0
                    AND `ratingchangeteam_ratintype_id`=$ratingtype_id";
            f_igosja_mysqli_query($sql);
        }
        elseif (RATING_TEAM_BASE == $ratingtype_id)
        {
            $sql = "UPDATE `ratingchangeteam`
                    LEFT JOIN `team`
                    ON `ratingchangeteam_team_id`=`team_id`
                    LEFT JOIN `base`
                    ON `team_base_id`=`base_id`
                    LEFT JOIN `basemedical`
                    ON `team_basemedical_id`=`basemedical_id`
                    LEFT JOIN `basephisical`
                    ON `team_basephisical_id`=`basemedical_id`
                    LEFT JOIN `baseschool`
                    ON `team_baseschool_id`=`baseschool_id`
                    LEFT JOIN `basescout`
                    ON `team_basescout_id`=`basescout_id`
                    LEFT JOIN `basetraining`
                    ON `team_basetraining_id`=`basetraining_id`
                    SET `ratingchangeteam_value`=`base_level`+`basemedical_level`+`basephisical_base_level`+`baseschool_level`+`basescout_level`+`basetraining_level`
                    WHERE `ratingchangeteam_schedule_id`=0
                    AND `ratingchangeteam_ratintype_id`=$ratingtype_id";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `ratingchangeteam` (`ratingchangeteam_ratintype_id`, `ratingchangeteam_schedule_id`, `ratingchangeteam_team_id`, `ratingchangeteam_value`)
                    SELECT $ratingtype_id, 0, `team_id`, `base_level`+`basemedical_level`+`basephisical_base_level`+`baseschool_level`+`basescout_level`+`basetraining_level`
                    FROM `team`
                    LEFT JOIN `base`
                    ON `team_base_id`=`base_id`
                    LEFT JOIN `basemedical`
                    ON `team_basemedical_id`=`basemedical_id`
                    LEFT JOIN `basephisical`
                    ON `team_basephisical_id`=`basemedical_id`
                    LEFT JOIN `baseschool`
                    ON `team_baseschool_id`=`baseschool_id`
                    LEFT JOIN `basescout`
                    ON `team_basescout_id`=`basescout_id`
                    LEFT JOIN `basetraining`
                    ON `team_basetraining_id`=`basetraining_id`
                    WHERE `team_id` NOT IN
                    (
                        SELECT `ratingchangeteam_team_id`
                        FROM `ratingchangeteam`
                        WHERE `ratingchangeteam_schedule_id`=0
                        AND `ratingchangeteam_ratintype_id`=$ratingtype_id
                    )";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `ratingchangeteam` (`ratingchangeteam_ratintype_id`, `ratingchangeteam_schedule_id`, `ratingchangeteam_team_id`, `ratingchangeteam_value`)
                    SELECT $ratingtype_id, $schedule_id, `team_id`, `base_level`+`basemedical_level`+`basephisical_base_level`+`baseschool_level`+`basescout_level`+`basetraining_level`
                    FROM `team`
                    LEFT JOIN `base`
                    ON `team_base_id`=`base_id`
                    LEFT JOIN `basemedical`
                    ON `team_basemedical_id`=`basemedical_id`
                    LEFT JOIN `basephisical`
                    ON `team_basephisical_id`=`basemedical_id`
                    LEFT JOIN `baseschool`
                    ON `team_baseschool_id`=`baseschool_id`
                    LEFT JOIN `basescout`
                    ON `team_basescout_id`=`basescout_id`
                    LEFT JOIN `basetraining`
                    ON `team_basetraining_id`=`basetraining_id`
                    LEFT JOIN `ratingchangeteam`
                    ON `team_id`=`ratingchangeteam_team_id`
                    WHERE `base_level`+`basemedical_level`+`basephisical_base_level`+`baseschool_level`+`basescout_level`+`basetraining_level`!=`ratingchangeteam_value`
                    AND `ratingchangeteam_schedule_id`=0
                    AND `ratingchangeteam_ratintype_id`=$ratingtype_id";
            f_igosja_mysqli_query($sql);
        }
        elseif (RATING_TEAM_STADIUM == $ratingtype_id)
        {
            $sql = "UPDATE `ratingchangeteam`
                    LEFT JOIN `team`
                    ON `ratingchangeteam_team_id`=`team_id`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    SET `ratingchangeteam_value`=`stadium_capacity`
                    WHERE `ratingchangeteam_schedule_id`=0
                    AND `ratingchangeteam_ratintype_id`=$ratingtype_id";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `ratingchangeteam` (`ratingchangeteam_ratintype_id`, `ratingchangeteam_schedule_id`, `ratingchangeteam_team_id`, `ratingchangeteam_value`)
                    SELECT $ratingtype_id, 0, `team_id`, `stadium_capacity`
                    FROM `team`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    WHERE `team_id` NOT IN
                    (
                        SELECT `ratingchangeteam_team_id`
                        FROM `ratingchangeteam`
                        WHERE `ratingchangeteam_schedule_id`=0
                        AND `ratingchangeteam_ratintype_id`=$ratingtype_id
                    )";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `ratingchangeteam` (`ratingchangeteam_ratintype_id`, `ratingchangeteam_schedule_id`, `ratingchangeteam_team_id`, `ratingchangeteam_value`)
                    SELECT $ratingtype_id, $schedule_id, `team_id`, `stadium_capacity`
                    FROM `team`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `ratingchangeteam`
                    ON `team_id`=`ratingchangeteam_team_id`
                    WHERE `stadium_capacity`!=`ratingchangeteam_value`
                    AND `ratingchangeteam_schedule_id`=0
                    AND `ratingchangeteam_ratintype_id`=$ratingtype_id";
            f_igosja_mysqli_query($sql);
        }
    }
}