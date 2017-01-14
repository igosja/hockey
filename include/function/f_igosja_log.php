<?php

function f_igosja_log($data)
{
    if (isset($data['log_building_id']))
    {
        $log_building_id = (int)$data['log_building_id'];
    }
    else
    {
        $log_building_id = 0;
    }

    if (isset($data['log_country_id']))
    {
        $log_country_id = (int)$data['log_country_id'];
    }
    else
    {
        $log_country_id = 0;
    }

    if (isset($data['log_game_id']))
    {
        $log_game_id = (int)$data['log_game_id'];
    }
    else
    {
        $log_game_id = 0;
    }

    if (isset($data['log_logtext_id']))
    {
        $log_logtext_id = (int)$data['log_logtext_id'];
    }
    else
    {
        $log_logtext_id = 0;
    }

    if (isset($data['log_national_id']))
    {
        $log_national_id = (int)$data['log_national_id'];
    }
    else
    {
        $log_national_id = 0;
    }

    if (isset($data['log_player_id']))
    {
        $log_player_id = (int)$data['log_player_id'];
    }
    else
    {
        $log_player_id = 0;
    }

    if (isset($data['log_position_id']))
    {
        $log_position_id = (int)$data['log_position_id'];
    }
    else
    {
        $log_position_id = 0;
    }

    if (isset($data['log_special_id']))
    {
        $log_special_id = (int)$data['log_special_id'];
    }
    else
    {
        $log_special_id = 0;
    }

    if (isset($data['log_team_id']))
    {
        $log_team_id = (int)$data['log_team_id'];
    }
    else
    {
        $log_team_id = 0;
    }

    if (isset($data['log_team_2_id']))
    {
        $log_team_2_id = (int)$data['log_team_2_id'];
    }
    else
    {
        $log_team_2_id = 0;
    }

    if (isset($data['log_user_id']))
    {
        $log_user_id = (int)$data['log_user_id'];
    }
    else
    {
        $log_user_id = 0;
    }

    if (isset($data['log_value']))
    {
        $log_value = (int)$data['log_value'];
    }
    else
    {
        $log_value = 0;
    }

    $sql = "SELECT `season_id`
            FROM `season`
            ORDER BY `season_id` DESC
            LIMIT 1";
    $season_sql = f_igosja_mysqli_query($sql);

    $season_array = $season_sql->fetch_all(1);

    $log_season_id = $season_array[0]['season_id'];

    $sql = "INSERT INTO `log`
            SET `log_building_id`=$log_building_id,
                `log_country_id`=$log_country_id,
                `log_date`=UNIX_TIMESTAMP(),
                `log_game_id`=$log_game_id,
                `log_logtext_id`=$log_logtext_id,
                `log_national_id`=$log_national_id,
                `log_player_id`=$log_player_id,
                `log_position_id`=$log_position_id,
                `log_season_id`=$log_season_id,
                `log_special_id`=$log_special_id,
                `log_team_id`=$log_team_id,
                `log_team_2_id`=$log_team_2_id,
                `log_user_id`=$log_user_id,
                `log_value`=$log_value";
    f_igosja_mysqli_query($sql);
}