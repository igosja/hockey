<?php

/**
 * Будівництво бази
 */
function f_igosja_generator_building_base()
{
    $sql = "UPDATE `buildingbase`
            SET `buildingbase_day`=`buildingbase_day`-1
            WHERE `buildingbase_ready`=0";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `building_name`,
                   `buildingbase_id`,
                   `buildingbase_building_id`,
                   `buildingbase_constructiontype_id`,
                   `buildingbase_team_id`
            FROM `buildingbase`
            LEFT JOIN `building`
            ON `buildingbase_building_id`=`building_id`
            WHERE `buildingbase_day`<=0
            AND `buildingbase_ready`=0
            ORDER BY `buildingbase_id` ASC";
    $buildingbase_sql = f_igosja_mysqli_query($sql);

    $buildingbase_array = $buildingbase_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($buildingbase_array as $item)
    {
        $buildingbase_building_id   = $item['buildingbase_building_id'];
        $buildingbase_id            = $item['buildingbase_id'];
        $building_name              = $item['building_name'];
        $team_id                    = $item['buildingbase_team_id'];

        $building_table     = '`' . $building_name .'`';
        $building_level     = '`' . $building_name . '_level`';
        $building_field     = $building_name . '_level';
        $building_id        = '`' . $building_name . '_id`';
        $team_building_id   = '`team_' . $building_name . '_id`';

        if (CONSTRUCTION_BUILD == $item['buildingbase_constructiontype_id'])
        {
            $sql = "UPDATE `team`
                    SET $team_building_id=$team_building_id+1
                    WHERE `team_id`=$team_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $historytext_id = HISTORYTEXT_BUILDING_UP;
        }
        else
        {
            $sql = "UPDATE `team`
                    SET $team_building_id=$team_building_id-1
                    WHERE `team_id`=$team_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $historytext_id = HISTORYTEXT_BUILDING_DOWN;
        }

        $sql = "SELECT $building_level
                FROM team
                LEFT JOIN $building_table
                ON $team_building_id=$building_id
                WHERE `team_id`=$team_id
                LIMIT 1";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        $sql = "UPDATE `buildingbase`
                SET `buildingbase_ready`=1
                WHERE `buildingbase_id`=$buildingbase_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $log = array(
            'history_building_id' => $buildingbase_building_id,
            'history_historytext_id' => $historytext_id,
            'history_team_id' => $team_id,
            'history_value' => $team_array[0][$building_field],
        );
        f_igosja_history($log);
    }
}