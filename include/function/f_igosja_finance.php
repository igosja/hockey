<?php

/**
 * Запис лога про финансові операції в БД
 * @param $data array дані для запису в БД
 */
function f_igosja_finance($data)
{
    global $mysqli;
    global $igosja_season_id;

    if (isset($data['finance_building_id']))
    {
        $finance_building_id = (int) $data['finance_building_id'];
    }
    else
    {
        $finance_building_id = 0;
    }

    if (isset($data['finance_capacity']))
    {
        $finance_capacity = (int) $data['finance_capacity'];
    }
    else
    {
        $finance_capacity = 0;
    }

    if (isset($data['finance_comment']))
    {
        $finance_comment = $data['finance_comment'];
    }
    else
    {
        $finance_comment = '';
    }

    if (isset($data['finance_country_id']))
    {
        $finance_country_id = (int) $data['finance_country_id'];
    }
    else
    {
        $finance_country_id = 0;
    }

    if (isset($data['finance_financetext_id']))
    {
        $finance_financetext_id = (int) $data['finance_financetext_id'];
    }
    else
    {
        $finance_financetext_id = 0;
    }

    if (isset($data['finance_level']))
    {
        $finance_level = (int) $data['finance_level'];
    }
    else
    {
        $finance_level = 0;
    }

    if (isset($data['finance_national_id']))
    {
        $finance_national_id = (int) $data['finance_national_id'];
    }
    else
    {
        $finance_national_id = 0;
    }

    if (isset($data['finance_player_id']))
    {
        $finance_player_id = (int) $data['finance_player_id'];
    }
    else
    {
        $finance_player_id = 0;
    }

    if (isset($data['finance_team_id']))
    {
        $finance_team_id = (int) $data['finance_team_id'];
    }
    else
    {
        $finance_team_id = 0;
    }

    if (isset($data['finance_user_id']))
    {
        $finance_user_id = (int) $data['finance_user_id'];
    }
    else
    {
        $finance_user_id = 0;
    }

    if (isset($data['finance_value']))
    {
        $finance_value = (int) $data['finance_value'];
    }
    else
    {
        $finance_value = 0;
    }

    if (isset($data['finance_value_after']))
    {
        $finance_value_after = (int) $data['finance_value_after'];
    }
    else
    {
        $finance_value_after = 0;
    }

    if (isset($data['finance_value_before']))
    {
        $finance_value_before = (int) $data['finance_value_before'];
    }
    else
    {
        $finance_value_before = 0;
    }

    $sql = "INSERT INTO `finance`
            SET `finance_building_id`=$finance_building_id,
                `finance_capacity`=$finance_capacity,
                `finance_comment`=?,
                `finance_country_id`=$finance_country_id,
                `finance_date`=UNIX_TIMESTAMP(),
                `finance_financetext_id`=$finance_financetext_id,
                `finance_level`=$finance_level,
                `finance_national_id`=$finance_national_id,
                `finance_player_id`=$finance_player_id,
                `finance_season_id`=$igosja_season_id,
                `finance_team_id`=$finance_team_id,
                `finance_user_id`=$finance_user_id,
                `finance_value`=$finance_value,
                `finance_value_after`=$finance_value_after,
                `finance_value_before`=$finance_value_before";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $finance_comment);
    $prepare->execute();
}