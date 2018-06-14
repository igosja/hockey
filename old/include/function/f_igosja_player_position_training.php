<?php

/**
 * Select з переліком позицій, котрі можуть бути натреновані хокеїсту
 * @param $player_id integer id хокеїста
 * @return string select з переліком позицій або порожній рядок
 */
function f_igosja_player_position_training($player_id)
{
    $sql = "SELECT `position_short`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id`=$player_id
            LIMIT 1, 1";
    $position_sql = f_igosja_mysqli_query($sql);

    if (0 == $position_sql->num_rows)
    {
        $sql = "SELECT `position_id`
                FROM `playerposition`
                LEFT JOIN `position`
                ON `playerposition_position_id`=`position_id`
                WHERE `playerposition_player_id`=$player_id
                LIMIT 1";
        $position_sql = f_igosja_mysqli_query($sql);

        $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

        if (POSITION_GK == $position_array[0]['position_id'])
        {
            $return = '';
        }
        else
        {
            $sql = "SELECT `position_id`,
                           `position_short`
                    FROM `position`
                    WHERE `position_id`!=" . POSITION_GK . "
                    AND `position_id` NOT IN
                    (
                        SELECT `playerposition_position_id`
                        FROM `playerposition`
                        WHERE `playerposition_player_id`=$player_id
                    )
                    ORDER BY `position_id` ASC";
            $position_sql = f_igosja_mysqli_query($sql);

            $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

            $return = '<select class="form-control form-small" name="data[position][]"><option value="0">-</option>';

            foreach ($position_array as $item)
            {
                $return = $return
                    . '<option value="'
                    . $player_id . ':' . $item['position_id']
                    . '">'
                    . $item['position_short']
                    . '</option>';
            }

            $return = $return . '</select>';
        }

        return $return;
    }
    else
    {
        return '';
    }
}