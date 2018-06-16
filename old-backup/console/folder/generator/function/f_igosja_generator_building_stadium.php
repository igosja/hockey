<?php

/**
 * Будівництво стадіону
 */
function f_igosja_generator_building_stadium()
{
    $sql = "UPDATE `buildingstadium`
            SET `buildingstadium_day`=`buildingstadium_day`-1
            WHERE `buildingstadium_ready`=0";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `buildingstadium_id`,
                   `buildingstadium_capacity`,
                   `buildingstadium_constructiontype_id`,
                   `team_id`
            FROM `buildingstadium`
            LEFT JOIN `team`
            ON `buildingstadium_team_id`=`team_id`
            WHERE `buildingstadium_day`<=0
            AND `buildingstadium_ready`=0
            ORDER BY `buildingstadium_id` ASC";
    $buildingstadium_sql = f_igosja_mysqli_query($sql);

    $buildingstadium_array = $buildingstadium_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($buildingstadium_array as $item)
    {
        $buildingstadium_id = $item['buildingstadium_id'];
        $capacity           = $item['buildingstadium_capacity'];
        $team_id            = $item['team_id'];

        if (CONSTRUCTION_BUILD == $item['buildingstadium_constructiontype_id'])
        {
            $historytext_id = HISTORYTEXT_STADIUM_UP;
        }
        else
        {
            $historytext_id = HISTORYTEXT_STADIUM_DOWN;
        }

        $sql = "UPDATE `stadium`
                LEFT JOIN `team`
                ON `stadium_id`=`team_stadium_id`
                SET `stadium_capacity`=$capacity
                WHERE `team_id`=$team_id";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `buildingstadium`
                SET `buildingstadium_ready`=1
                WHERE `buildingstadium_id`=$buildingstadium_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $log = array(
            'history_historytext_id' => $historytext_id,
            'history_team_id' => $team_id,
            'history_value' => $capacity,
        );
        f_igosja_history($log);
    }
}