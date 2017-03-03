<?php

function f_igosja_create_team_players($team_id)
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

    $country_array = $country_sql->fetch_all(1);

    $country_id = $country_array[0]['city_country_id'];

    for ($i=0; $i<27; $i++)
    {
        if ($i < 2)
        {
            $position_id = POSITION_GK;
        }
        elseif ($i < 7)
        {
            $position_id = POSITION_LD;
        }
        elseif ($i < 12)
        {
            $position_id = POSITION_RD;
        }
        elseif ($i < 17)
        {
            $position_id = POSITION_LW;
        }
        elseif ($i < 22)
        {
            $position_id = POSITION_C;
        }
        else
        {
            $position_id = POSITION_RW;
        }

        $age = 17 + $i;

        if (39 < $age)
        {
            $age = $age - 17;
        }

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

        $sql = "SELECT `surnamecountry_surname_id`
                FROM `surnamecountry`
                WHERE `surnamecountry_country_id`=$country_id
                ORDER BY RAND()
                LIMIT 1";
        $surname_sql = f_igosja_mysqli_query($sql);

        $surname_array = $surname_sql->fetch_all(1);

        $surname_id = $surname_array[0]['surnamecountry_surname_id'];

        $shape      = rand(75, 125);
        $style_id   = 1;
        $ability    = rand(1, 5);

        $sql = "INSERT INTO `player`
                SET `player_age`='$age',
                    `player_country_id`=$country_id,
                    `player_name_id`=$name_id,
                    `player_phisical_id`=$phisical_id,
                    `player_power_nominal`=$age*2,
                    `player_power_nominal_s`=`player_power_nominal`,
                    `player_power_old`=`player_power_nominal`,
                    `player_power_real`=`player_power_nominal`*50/100*$phisical_value/100,
                    `player_price`=POW(150-(28-$age), 2)*$age*2*1000,
                    `player_salary`=`player_price`/999,
                    `player_school_id`=$team_id,
                    `player_shape`=$shape,
                    `player_style_id`=$style_id,
                    `player_surname_id`=$surname_id,
                    `player_team_id`=$team_id,
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
            'history_team_id' => $team_id,
        );

        f_igosja_history($log);
    }
}