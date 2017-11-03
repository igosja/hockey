<?php

/**
 * Запис в лог події на сайті
 * @param $data array дані для запису в БД
 */
function f_igosja_history($data)
{
    global $igosja_season_id;

    if (isset($data['history_building_id']))
    {
        $history_building_id = (int) $data['history_building_id'];
    }
    else
    {
        $history_building_id = 0;
    }

    if (isset($data['history_country_id']))
    {
        $history_country_id = (int) $data['history_country_id'];
    }
    else
    {
        $history_country_id = 0;
    }

    if (isset($data['history_game_id']))
    {
        $history_game_id = (int) $data['history_game_id'];
    }
    else
    {
        $history_game_id = 0;
    }

    if (isset($data['history_historytext_id']))
    {
        $history_historytext_id = (int) $data['history_historytext_id'];
    }
    else
    {
        $history_historytext_id = 0;
    }

    if (isset($data['history_national_id']))
    {
        $history_national_id = (int) $data['history_national_id'];
    }
    else
    {
        $history_national_id = 0;
    }

    if (isset($data['history_player_id']))
    {
        $history_player_id = (int) $data['history_player_id'];
    }
    else
    {
        $history_player_id = 0;
    }

    if (isset($data['history_position_id']))
    {
        $history_position_id = (int) $data['history_position_id'];
    }
    else
    {
        $history_position_id = 0;
    }

    if (isset($data['history_special_id']))
    {
        $history_special_id = (int) $data['history_special_id'];
    }
    else
    {
        $history_special_id = 0;
    }

    if (isset($data['history_team_id']))
    {
        $history_team_id = (int) $data['history_team_id'];
    }
    else
    {
        $history_team_id = 0;
    }

    if (isset($data['history_team_2_id']))
    {
        $history_team_2_id = (int) $data['history_team_2_id'];
    }
    else
    {
        $history_team_2_id = 0;
    }

    if (isset($data['history_user_id']))
    {
        $history_user_id = (int) $data['history_user_id'];
    }
    else
    {
        $history_user_id = 0;
    }

    if (isset($data['history_user_2_id']))
    {
        $history_user_2_id = (int) $data['history_user_2_id'];
    }
    else
    {
        $history_user_2_id = 0;
    }

    if (isset($data['history_value']))
    {
        $history_value = (int) $data['history_value'];
    }
    else
    {
        $history_value = 0;
    }

    $sql = "INSERT INTO `history`
            SET `history_building_id`=$history_building_id,
                `history_country_id`=$history_country_id,
                `history_date`=UNIX_TIMESTAMP(),
                `history_game_id`=$history_game_id,
                `history_historytext_id`=$history_historytext_id,
                `history_national_id`=$history_national_id,
                `history_player_id`=$history_player_id,
                `history_position_id`=$history_position_id,
                `history_season_id`=$igosja_season_id,
                `history_special_id`=$history_special_id,
                `history_team_id`=$history_team_id,
                `history_team_2_id`=$history_team_2_id,
                `history_user_id`=$history_user_id,
                `history_user_2_id`=$history_user_2_id,
                `history_value`=$history_value";
    f_igosja_mysqli_query($sql);
}