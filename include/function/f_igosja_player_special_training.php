<?php

/**
 * Select з переліком спецможливостей, котрі можуть бути натреновані хокеїсту
 * @param $player_id integer id хокеїста
 * @return string select з переліком спецможливостей або порожній рядок
 */
function f_igosja_player_special_training($player_id)
{
    $sql = "SELECT COUNT(`playerspecial_special_id`) AS `count`
            FROM `playerspecial`
            WHERE `playerspecial_player_id`=$player_id
            AND `playerspecial_level`=4";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(1);

    if (4 > $check_array[0]['count'])
    {
        $sql = "SELECT `special_id`,
                       `special_short`
                FROM `special`
                WHERE `special_id` NOT IN
                (
                    SELECT `playerspecial_special_id`
                    FROM `playerspecial`
                    WHERE `playerspecial_player_id`=$player_id
                    AND `playerspecial_level`=4
                )
                ORDER BY `special_id` ASC";
        $special_sql = f_igosja_mysqli_query($sql);

        $special_array = $special_sql->fetch_all(1);

        $return = '<select class="form-control form-small" name="data[special][]"><option></option>';

        foreach ($special_array as $item)
        {
            $return = $return
                . '<option value="'
                . $player_id . ':' . $item['special_id']
                . '">'
                . $item['special_short']
                . '</option>';
        }

        $return = $return . '</select>';

        return $return;
    }
    else
    {
        return '';
    }
}