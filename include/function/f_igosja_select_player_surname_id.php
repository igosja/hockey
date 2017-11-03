<?php

/**
 * Выбираємо максимально унікальне прізвище хоккеїсту
 * @param $country_id integer id країни
 * @param $length integer кількість перших літер, на унікальніть яких йде перевірка
 * @param $team_id integer id команди
 */
function f_igosja_select_player_surname_id($team_id, $country_id, $length = 1)
{
    $sql = "SELECT SUBSTRING(`surname_name`, 1, $length) AS `surname`
            FROM `player`
            LEFT JOIN `surname`
            ON `player_surname_id`=`surname_id`
            WHERE `player_team_id`=$team_id
            ORDER BY `player_id` ASC";
    $team_surname_sql = f_igosja_mysqli_query($sql);

    if (0 == $team_surname_sql->num_rows)
    {
        $sql = "SELECT `surnamecountry_surname_id`
                FROM `surnamecountry`
                WHERE `surnamecountry_country_id`=$country_id
                ORDER BY RAND()
                LIMIT 1";
        $surname_sql = f_igosja_mysqli_query($sql);

        $surname_array = $surname_sql->fetch_all(MYSQLI_ASSOC);

        $surname_id = $surname_array[0]['surnamecountry_surname_id'];
    }
    else
    {
        $team_surname_array = $team_surname_sql->fetch_all(MYSQLI_ASSOC);

        $surname_exist_array = array();

        foreach ($team_surname_array as $item)
        {
            $surname_exist_array[] = "'" . $item['surname'] . "'";
        }

        $sql = "SELECT `surnamecountry_surname_id`
                FROM `surnamecountry`
                LEFT JOIN `surname`
                ON `surnamecountry_surname_id`=`surname_id`
                WHERE `surnamecountry_country_id`=$country_id
                AND SUBSTRING(`surname_name`, 1, $length) NOT IN (" . implode(', ', $surname_exist_array) . ")
                ORDER BY RAND()
                LIMIT 1";
        $surname_sql = f_igosja_mysqli_query($sql);

        if ($surname_sql->num_rows)
        {
            $surname_array = $surname_sql->fetch_all(MYSQLI_ASSOC);

            $surname_id = $surname_array[0]['surnamecountry_surname_id'];
        }
        else
        {
            $length++;

            $surname_id = f_igosja_select_player_surname_id($team_id, $country_id, $length);
        }
    }

    return $surname_id;
}