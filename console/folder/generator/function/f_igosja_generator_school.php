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
                   `city_country_id`,
                   `school_id`,
                   `school_position_id`,
                   `school_special_id`,
                   `school_style_id`,
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
            WHERE `school_ready`=0
            AND `school_day`<=0
            ORDER BY `school_id`";
    $school_sql = f_igosja_mysqli_query($sql);

    $school_array = $school_sql->fetch_all(1);

    foreach ($school_array as $item)
    {
        $country_id     = $item['city_country_id'];
        $position_id    = $item['school_position_id'];
        $power          = $item['baseschool_power'];
        $special_id     = $item['school_special_id'];
        $school_id      = $item['school_id'];
        $style_id       = $item['school_style_id'];
        $team_id        = $item['team_id'];
        $tire           = $item['basemedical_tire'];
        $user_id        = $item['team_user_id'];

        $sql ="SELECT `phisical_id`,
                      `phisical_value`
               FROM `phisical`
               ORDER BY RAND()
               LIMIT 1";
        $phisical_sql = f_igosja_mysqli_query($sql);

        $phisical_array = $phisical_sql->fetch_all(1);

        $phisical_id    = $phisical_array[0]['phisical_id'];
        $phisical_value = $phisical_array[0]['phisical_value'];

        $sql = "SELECT `namecountry_name_id`
                FROM `namecountry`
                WHERE `namecountry_country_id`=$country_id
                ORDER BY RAND()
                LIMIT 1";
        $name_sql = f_igosja_mysqli_query($sql);

        $name_array = $name_sql->fetch_all(1);

        $name_id = $name_array[0]['namecountry_name_id'];

        $surname_id = f_igosja_select_player_surname_id($team_id, $country_id);

        $ability    = rand(1, 5);

        $sql = "INSERT INTO `player`
                SET `player_age`=17,
                    `player_country_id`=$country_id,
                    `player_name_id`=$name_id,
                    `player_phisical_id`=$phisical_id,
                    `player_power_nominal`=$power,
                    `player_power_nominal_s`=`player_power_nominal`,
                    `player_power_old`=`player_power_nominal`,
                    `player_power_real`=`player_power_nominal`*$tire/100*$phisical_value/100,
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

        $log = array(
            'history_historytext_id' => HISTORYTEXT_PLAYER_FROM_SCHOOL,
            'history_player_id' => $player_id,
            'history_team_id' => $team_id,
            'history_user_id' => $user_id,
        );
        f_igosja_history($log);

        $sql = "UPDATE `school`
                SET `school_ready`=1,
                    `school_season_id`=$igosja_season_id
                WHERE `school_id`=$school_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }

    print '.';
    flush();
}