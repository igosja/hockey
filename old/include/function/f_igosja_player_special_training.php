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

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (4 > $check_array[0]['count'])
    {
        $sql = "SELECT `player_position_id`
                FROM `player`
                WHERE `player_id`=$player_id
                LIMIT 1";
        $position_sql = f_igosja_mysqli_query($sql);

        $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

        if (POSITION_GK == $position_array[0]['player_position_id'])
        {
            $gk     = 1;
            $field  = 0;
        }
        else
        {
            $gk     = 0;
            $field  = 1;
        }

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
                AND `special_id` IN
                (
                    SELECT `special_id`
                    FROM `special`
                    WHERE `special_gk`=$gk
                    OR `special_field`=$field
                )
                ORDER BY `special_id` ASC";
        $special_sql = f_igosja_mysqli_query($sql);

        $special_array = $special_sql->fetch_all(MYSQLI_ASSOC);

        $return = '<select class="form-control form-small" name="data[special][]"><option value="0">-</option>';

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