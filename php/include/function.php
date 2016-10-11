<?php

function redirect($location)
{
    header('Location: ' . $location);
    exit;
}

function f_igosja_post($var, $subvar = '')
{
    if ($subvar) {
        if (isset($_POST[$var][$subvar])) {
            $result = $_POST[$var][$subvar];
        } else {
            $result = '';
        }
    } else {
        if (isset($_POST[$var])) {
            $result = $_POST[$var];
        } else {
            $result = '';
        }
    }

    return $result;
}

function f_igosja_get($var, $subvar = '')
{
    if ($subvar) {
        if (isset($_GET[$var][$subvar])) {
            $result = $_GET[$var][$subvar];
        } else {
            $result = '';
        }
    } else {
        if (isset($_GET[$var])) {
            $result = $_GET[$var];
        } else {
            $result = '';
        }
    }

    return $result;
}

function f_igosja_check_user_by_email($email)
{
    global $mysqli;

    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_email`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $email);
    $prepare->execute();

    $check_sql = $prepare->get_result();

    $prepare->close();

    $check_array = $check_sql->fetch_all(1);

    $check = $check_array[0]['count'];

    if ($check) {
        $result = false;
    } else {
        $result = true;
    }

    return $result;
}

function f_igosja_check_user_by_login($login)
{
    global $mysqli;

    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_login`=?";
    $prepare = $mysqli->prepare($sql);

    $prepare->bind_param('s', $login);
    $prepare->execute();

    $check_sql = $prepare->get_result();

    $prepare->close();

    $check_array = $check_sql->fetch_all(1);

    $check = $check_array[0]['count'];

    if ($check) {
        $result = false;
    } else {
        $result = true;
    }

    return $result;
}

function f_igosja_hash_password($password)
{
    return md5($password . md5(PASSWORD_SALT));
}

function f_igosja_generate_user_code()
{
    $code = md5(uniqid(rand(), 1));

    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_code`='$code'";
    $check_sql = igosja_db_query($sql);

    $check_array = $check_sql->fetch_all(1);

    $check = $check_array[0]['count'];

    if ($check) {
        $code = f_igosja_generate_user_code();
    }

    return $code;
}

function f_igosja_sql_data($data)
{
    $sql = array();

    foreach ($data as $key => $value) {
        $sql[] = '`' . $key . '`=\'' . $value . '\'';
    }

    $sql = implode(', ', $sql);

    return $sql;
}

function f_igosja_ufu_date_time($date)
{
    return date('H:i d.m.Y', $date);
}

function f_igosja_ufu_last_visit($date)
{
    $min_5 = $date + 5 * 60;
    $min_60 = $date + 60 * 60;
    $now = time();

    if ($min_5 >= $now) {
        $date = 'онлайн';
    } elseif ($min_60 >= $now) {
        $difference = $now - $date;
        $difference = $difference / 60;
        $difference = round($difference, 0);
        $date = $difference . ' минут назад';
    } else {
        $date = date('H:i d.m.Y', $date);
    }

    return $date;
}

function f_igosja_log($data)
{
    if (isset($data['log_building_id'])) {
        $log_building_id = (int)$data['log_building_id'];
    } else {
        $log_building_id = 0;
    }

    if (isset($data['log_country_id'])) {
        $log_country_id = (int)$data['log_country_id'];
    } else {
        $log_country_id = 0;
    }

    if (isset($data['log_game_id'])) {
        $log_game_id = (int)$data['log_game_id'];
    } else {
        $log_game_id = 0;
    }

    if (isset($data['log_logtext_id'])) {
        $log_logtext_id = (int)$data['log_logtext_id'];
    } else {
        $log_logtext_id = 0;
    }

    if (isset($data['log_national_id'])) {
        $log_national_id = (int)$data['log_national_id'];
    } else {
        $log_national_id = 0;
    }

    if (isset($data['log_player_id'])) {
        $log_player_id = (int)$data['log_player_id'];
    } else {
        $log_player_id = 0;
    }

    if (isset($data['log_position_id'])) {
        $log_position_id = (int)$data['log_position_id'];
    } else {
        $log_position_id = 0;
    }

    if (isset($data['log_special_id'])) {
        $log_special_id = (int)$data['log_special_id'];
    } else {
        $log_special_id = 0;
    }

    if (isset($data['log_team_id'])) {
        $log_team_id = (int)$data['log_team_id'];
    } else {
        $log_team_id = 0;
    }

    if (isset($data['log_team_2_id'])) {
        $log_team_2_id = (int)$data['log_team_2_id'];
    } else {
        $log_team_2_id = 0;
    }

    if (isset($data['log_user_id'])) {
        $log_user_id = (int)$data['log_user_id'];
    } else {
        $log_user_id = 0;
    }

    if (isset($data['log_value'])) {
        $log_value = (int)$data['log_value'];
    } else {
        $log_value = 0;
    }

    $sql = "SELECT `season_id`
            FROM `season`
            ORDER BY `season_id` DESC
            LIMIT 1";
    $season_sql = igosja_db_query($sql);

    $season_array = $season_sql->fetch_all(1);

    $log_season_id = $season_array[0]['season_id'];

    $sql = "INSERT INTO `log`
            SET `log_building_id`='$log_building_id',
                `log_country_id`='$log_country_id',
                `log_date`=UNIX_TIMESTAMP(),
                `log_game_id`='$log_game_id',
                `log_logtext_id`='$log_logtext_id',
                `log_national_id`='$log_national_id',
                `log_player_id`='$log_player_id',
                `log_position_id`='$log_position_id',
                `log_season_id`='$log_season_id',
                `log_special_id`='$log_special_id',
                `log_team_id`='$log_team_id',
                `log_team_2_id`='$log_team_2_id',
                `log_user_id`='$log_user_id',
                `log_value`='$log_value'";
    igosja_db_query($sql);
}

function f_igosja_create_team_players($team_id)
{
    global $mysqli;

    $sql = "SELECT `city_country_id`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            WHERE `team_id`='$team_id'
            LIMIT 1";
    $country_sql = igosja_db_query($sql);

    $country_array = $country_sql->fetch_all(1);

    $country_id = $country_array[0]['city_country_id'];

    for ($i = 0; $i < 27; $i++) {
        if ($i < 2) {
            $position_id = POSITION_GK;
        } elseif ($i < 7) {
            $position_id = POSITION_LD;
        } elseif ($i < 12) {
            $position_id = POSITION_RD;
        } elseif ($i < 17) {
            $position_id = POSITION_LW;
        } elseif ($i < 22) {
            $position_id = POSITION_C;
        } else {
            $position_id = POSITION_RW;
        }

        $age = 17 + $i;

        if (30 < $age) {
            $age = $age - 12;
        }

        $sql = "SELECT `namecountry_name_id`
                FROM `namecountry`
                WHERE `namecountry_country_id`='$country_id'
                ORDER BY RAND()
                LIMIT 1";
        $name_sql = igosja_db_query($sql);

        $name_array = $name_sql->fetch_all(1);

        $name_id = $name_array[0]['namecountry_name_id'];

        $sql = "SELECT `surnamecountry_surname_id`
                FROM `surnamecountry`
                WHERE `surnamecountry_country_id`='$country_id'
                ORDER BY RAND()
                LIMIT 1";
        $surname_sql = igosja_db_query($sql);

        $surname_array = $surname_sql->fetch_all(1);

        $surname_id = $surname_array[0]['surnamecountry_surname_id'];

        $shape = rand(75, 125);
        $style_id = 1;
        $ability = rand(1, 5);

        $sql = "INSERT INTO `player`
                SET `player_age`='$age',
                    `player_country_id`='$country_id',
                    `player_name_id`='$name_id',
                    `player_power_nominal`='$age'*'2',
                    `player_power_old`='$age'*'2',
                    `player_power_real`='$age'*'2',
                    `player_price`='0',
                    `player_salary`='0',
                    `player_school_id`='$team_id',
                    `player_shape`='$shape',
                    `player_style_id`='$style_id ',
                    `player_surname_id`='$surname_id',
                    `player_team_id`='$team_id',
                    `player_tire`='40',
                    `player_training_ability`='$ability'";
        igosja_db_query($sql);

        $player_id = $mysqli->insert_id;

        $sql = "INSERT INTO `playerposition`
                SET `playerposition_player_id`='$player_id',
                    `playerposition_position_id`='$position_id'";
        igosja_db_query($sql);

        $log = array(
            'log_logtext_id' => LOGTEXT_PLAYER_FROM_SCHOOL,
            'log_player_id' => $player_id,
            'log_team_id' => $team_id,
        );

        f_igosja_log($log);
    }
}

function f_igosja_money($price)
{
    $price = $price . ' $';

    return $price;
}

function f_igosja_player_position($player_id)
{
    $sql = "SELECT `position_name`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id`='$player_id'";
    $position_sql = igosja_db_query($sql);

    $position_array = $position_sql->fetch_all(1);

    $return_array = array();

    foreach ($position_array as $item) {
        $return_array[] = $item['position_name'];
    }

    $return = implode('/', $return_array);

    return $return;
}