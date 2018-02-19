<?php

/**
 * Готуємо молодь в спортшколі
 */
function f_igosja_generator_school()
{
    global $igosja_season_id;
    global $mysqli;

    $sql = "UPDATE `school`
            SET `school_day`=`school_day`-1
            WHERE `school_ready`=0
            AND `school_day`>0";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `basemedical_tire`,
                   `baseschool_power`,
                   `baseschool_with_special`,
                   `baseschool_with_style`,
                   `basescout_level`,
                   `city_country_id`,
                   `school_id`,
                   `school_position_id`,
                   `school_special_id`,
                   `school_style_id`,
                   `school_with_special`,
                   `school_with_style`,
                   `team_id`,
                   `team_user_id`
            FROM `school`
            LEFT JOIN `team`
            ON `school_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `baseschool`
            ON `team_baseschool_id`=`baseschool_id`
            LEFT JOIN `basemedical`
            ON `team_basemedical_id`=`basemedical_id`
            LEFT JOIN `basescout`
            ON `team_basescout_id`=`basescout_id`
            WHERE `school_ready`=0
            AND `school_day`<=0
            ORDER BY `school_id` ASC";
    $school_sql = f_igosja_mysqli_query($sql);

    $school_array = $school_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($school_array as $item)
    {
        $country_id         = $item['city_country_id'];
        $position_id        = $item['school_position_id'];
        $power              = $item['baseschool_power'];
        $special_id         = $item['school_special_id'];
        $school_id          = $item['school_id'];
        $scout_level        = $item['basescout_level'];
        $style_id           = $item['school_style_id'];
        $team_id            = $item['team_id'];
        $tire               = $item['basemedical_tire'];
        $user_id            = $item['team_user_id'];
        $with_special       = $item['baseschool_with_special'];
        $with_style         = $item['baseschool_with_style'];
        $with_special_db    = $item['school_with_special'];
        $with_style_db      = $item['school_with_style'];

        if ($with_special || $with_style)
        {
            if (0 != $with_special_db)
            {
                $sql = "SELECT COUNT(`school_id`) AS `check`
                        FROM `school`
                        WHERE `school_team_id`=$team_id
                        AND `school_ready`=1
                        AND `school_with_special`=1
                        AND `school_season_id`=$igosja_season_id";
                $check_sql = f_igosja_mysqli_query($sql);

                $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                if ($check_array[0]['check'] >= $with_special)
                {
                    $special_id         = 0;
                    $with_special_db    = 0;
                }
            }

            if (0 != $with_style_db)
            {
                $sql = "SELECT COUNT(`school_id`) AS `check`
                        FROM `school`
                        WHERE `school_team_id`=$team_id
                        AND `school_ready`=1
                        AND `school_with_style`=1
                        AND `school_season_id`=$igosja_season_id";
                $check_sql = f_igosja_mysqli_query($sql);

                $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                if ($check_array[0]['check'] >= $with_style)
                {
                    $style_id       = rand(STYLE_POWER, STYLE_TECHNIQUE);
                    $with_style_db  = 0;
                }
            }
        }
        else
        {
            $special_id = 0;
            $style_id   = rand(STYLE_POWER, STYLE_TECHNIQUE);
        }

        $sql ="SELECT `phisical_id`,
                      `phisical_value`
               FROM `phisical`
               ORDER BY RAND()
               LIMIT 1";
        $phisical_sql = f_igosja_mysqli_query($sql);

        $phisical_array = $phisical_sql->fetch_all(MYSQLI_ASSOC);

        $phisical_id    = $phisical_array[0]['phisical_id'];
        $phisical_value = $phisical_array[0]['phisical_value'];

        $sql = "SELECT `namecountry_name_id`
                FROM `namecountry`
                WHERE `namecountry_country_id`=$country_id
                ORDER BY RAND()
                LIMIT 1";
        $name_sql = f_igosja_mysqli_query($sql);

        $name_array = $name_sql->fetch_all(MYSQLI_ASSOC);

        $name_id = $name_array[0]['namecountry_name_id'];

        $surname_id = f_igosja_select_player_surname_id($team_id, $country_id);

        $ability = rand(1, 5);

        $sql = "INSERT INTO `player`
                SET `player_age`=17,
                    `player_country_id`=$country_id,
                    `player_name_id`=$name_id,
                    `player_phisical_id`=$phisical_id,
                    `player_position_id`=$position_id,
                    `player_power_nominal`=$power,
                    `player_power_nominal_s`=`player_power_nominal`,
                    `player_power_old`=`player_power_nominal`,
                    `player_power_real`=`player_power_nominal`*(100-$tire)/100*$phisical_value/100,
                    `player_price`=POW(150-(28-$power/2), 2)*$power,
                    `player_salary`=`player_price`/999,
                    `player_school_id`=$team_id,
                    `player_style_id`=$style_id,
                    `player_surname_id`=$surname_id,
                    `player_team_id`=$team_id,
                    `player_tire`=$tire,
                    `player_training_ability`=$ability";
        f_igosja_mysqli_query($sql);

        $player_id = $mysqli->insert_id;

        $sql = "INSERT INTO `playerposition`
                SET `playerposition_player_id`=$player_id,
                    `playerposition_position_id`=$position_id";
        f_igosja_mysqli_query($sql);

        if ($special_id)
        {
            $sql = "INSERT INTO `playerspecial`
                    SET `playerspecial_level`=1,
                        `playerspecial_player_id`=$player_id,
                        `playerspecial_special_id`=$special_id";
            f_igosja_mysqli_query($sql);
        }

        if ($scout_level >= 5)
        {
            $sql = "INSERT INTO `scout`
                    SET `scout_percent`=100,
                        `scout_player_id`=$player_id,
                        `scout_ready`=1,
                        `scout_style`=1,
                        `scout_team_id`=$team_id";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `scout`
                    SET `scout_percent`=100,
                        `scout_player_id`=$player_id,
                        `scout_ready`=1,
                        `scout_style`=1,
                        `scout_team_id`=$team_id";
            f_igosja_mysqli_query($sql);
        }

        $log = array(
            'history_historytext_id' => HISTORYTEXT_PLAYER_FROM_SCHOOL,
            'history_player_id' => $player_id,
            'history_team_id' => $team_id,
            'history_user_id' => $user_id,
        );
        f_igosja_history($log);

        $sql = "UPDATE `school`
                SET `school_ready`=1,
                    `school_season_id`=$igosja_season_id,
                    `school_with_special`=$with_special_db,
                    `school_with_style`=$with_style_db
                WHERE `school_id`=$school_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}