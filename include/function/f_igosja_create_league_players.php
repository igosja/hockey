<?php

/**
 * Створюеємо хокеїстів в лігу при створенні новоі команди (1 воратар + по 3 чоловіка на кажну позицію в поле)
 * і записуємо це в БД (`history`)
 * @param $team_id integer id команди
 */
function f_igosja_create_league_players($team_id)
{
    global $mysqli;

    $sql = "SELECT `city_country_id`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            WHERE `team_id`=$team_id
            LIMIT 1";
    $country_sql = f_igosja_mysqli_query($sql);

    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    $country_id = $country_array[0]['city_country_id'];

    $position_array = array(
        POSITION_GK,
        POSITION_LD,
        POSITION_LD,
        POSITION_LD,
        POSITION_RD,
        POSITION_RD,
        POSITION_RD,
        POSITION_LW,
        POSITION_LW,
        POSITION_LW,
        POSITION_C,
        POSITION_C,
        POSITION_C,
        POSITION_RW,
        POSITION_RW,
        POSITION_RW,
    );

    shuffle($position_array);

    for ($i=0; $i<16; $i++)
    {
        $position_id = $position_array[$i];

        $age = 18;

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

        $style_id   = 1;
        $ability    = 1;

        $sql = "INSERT INTO `player`
                SET `player_age`=$age,
                    `player_country_id`=$country_id,
                    `player_name_id`=$name_id,
                    `player_phisical_id`=$phisical_id,
                    `player_position_id`=$position_id,
                    `player_power_nominal`=$age*2,
                    `player_power_nominal_s`=`player_power_nominal`,
                    `player_power_old`=`player_power_nominal`,
                    `player_power_real`=`player_power_nominal`*50/100*$phisical_value/100,
                    `player_price`=POW(150-(28-$age), 2)*$age*2,
                    `player_salary`=`player_price`/999,
                    `player_school_id`=0,
                    `player_style_id`=$style_id,
                    `player_surname_id`=$surname_id,
                    `player_team_id`=0,
                    `player_tire`=50,
                    `player_training_ability`=$ability";
        f_igosja_mysqli_query($sql);

        $player_id = $mysqli->insert_id;

        $sql = "INSERT INTO `playerposition`
                SET `playerposition_player_id`=$player_id,
                    `playerposition_position_id`=$position_id";
        f_igosja_mysqli_query($sql);

        $log = array(
            'history_historytext_id' => HISTORYTEXT_PLAYER_FROM_SCHOOL,
            'history_player_id' => $player_id,
        );
        f_igosja_history($log);
    }
}