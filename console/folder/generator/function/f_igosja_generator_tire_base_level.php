<?php

/**
 * Виводимо втому хокеїстів на рівень мед центру
 */
function f_igosja_generator_tire_base_level()
{
    $sql = "SELECT COUNT(`schedule_id`) AS `check`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`-86400, '%Y-%m-%d')=CURDATE()
            AND `schedule_stage_id`=" . STAGE_1_TOUR . "
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP;
    f_igosja_mysqli_query($sql);

    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $check_array[0]['check'])
    {
        $sql = "UPDATE `player`
                LEFT JOIN `team`
                ON `player_team_id`=`team_id`
                LEFT JOIN `basemedical`
                ON `team_basemedical_id`=`basemedical_id`
                SET `player_tire`=`basemedical_tire`
                WHERE `player_team_id`!=0
                AND `player_rent_team_id`=0
                AND `team_id` NOT IN (
                    SELECT `buildingbase_team_id`
                    FROM `buildingbase`
                    WHERE `buildingbase_ready`=0
                    AND `buildingbase_building_id` IN (" . BUILDING_BASE . ", " . BUILDING_BASEMEDICAL . ")
                )";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `player`
                LEFT JOIN `team`
                ON `player_team_id`=`team_id`
                SET `player_tire`=50
                WHERE `player_team_id`!=0
                AND `player_rent_team_id`=0
                AND `team_id` IN (
                    SELECT `buildingbase_team_id`
                    FROM `buildingbase`
                    WHERE `buildingbase_ready`=0
                    AND `buildingbase_building_id` IN (" . BUILDING_BASE . ", " . BUILDING_BASEMEDICAL . ")
                )";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `player`
                LEFT JOIN `team`
                ON `player_rent_team_id`=`team_id`
                LEFT JOIN `basemedical`
                ON `team_basemedical_id`=`basemedical_id`
                SET `player_tire`=`basemedical_tire`
                WHERE `player_team_id`!=0
                AND `player_rent_team_id`!=0
                AND `team_id` NOT IN (
                    SELECT `buildingbase_team_id`
                    FROM `buildingbase`
                    WHERE `buildingbase_ready`=0
                    AND `buildingbase_building_id` IN (" . BUILDING_BASE . ", " . BUILDING_BASEMEDICAL . ")
                )";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `player`
                LEFT JOIN `team`
                ON `player_rent_team_id`=`team_id`
                SET `player_tire`=50
                WHERE `player_team_id`!=0
                AND `player_rent_team_id`!=0
                AND `team_id` IN (
                    SELECT `buildingbase_team_id`
                    FROM `buildingbase`
                    WHERE `buildingbase_ready`=0
                    AND `buildingbase_building_id` IN (" . BUILDING_BASE . ", " . BUILDING_BASEMEDICAL . ")
                )";
        f_igosja_mysqli_query($sql);
    }
}