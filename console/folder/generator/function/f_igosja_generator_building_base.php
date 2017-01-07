<?php

function f_igosja_generator_building_stadium()
//Строительство базы
{
    $sql = "UPDATE `buildingbase`
            SET `buildingbase_day`=`buildingbase_day`-'1'
            WHERE `buildingbase_ready`='0'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            LEFT JOIN `buildingbase`
            ON `team_id`=`buildingbase_team_id`
            SET `team_base_id`=`team_base_id`+'1'
            WHERE `buildingbase_day`='0'
            AND `buildingbase_ready`='0'
            AND `buildingbase_building_id`='1'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            LEFT JOIN `buildingbase`
            ON `team_id`=`buildingbase_team_id`
            SET `team_basemedical_id`=`team_basemedical_id`+'1'
            WHERE `buildingbase_day`='0'
            AND `buildingbase_ready`='0'
            AND `buildingbase_building_id`='2'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            LEFT JOIN `buildingbase`
            ON `team_id`=`buildingbase_team_id`
            SET `team_basephisical_id`=`team_basephisical_id`+'1'
            WHERE `buildingbase_day`='0'
            AND `buildingbase_ready`='0'
            AND `buildingbase_building_id`='3'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            LEFT JOIN `buildingbase`
            ON `team_id`=`buildingbase_team_id`
            SET `team_baseschool_id`=`team_baseschool_id`+'1'
            WHERE `buildingbase_day`='0'
            AND `buildingbase_ready`='0'
            AND `buildingbase_building_id`='4'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            LEFT JOIN `buildingbase`
            ON `team_id`=`buildingbase_team_id`
            SET `team_basescout_id`=`team_basescout_id`+'1'
            WHERE `buildingbase_day`='0'
            AND `buildingbase_ready`='0'
            AND `buildingbase_building_id`='5'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            LEFT JOIN `buildingbase`
            ON `team_id`=`buildingbase_team_id`
            SET `team_basetraining_id`=`team_basetraining_id`+'1'
            WHERE `buildingbase_day`='0'
            AND `buildingbase_ready`='0'
            AND `buildingbase_building_id`='6'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `buildingbase`
            SET `buildingbase_ready`='1'
            WHERE `buildingbase_day`='0'
            AND `buildingbase_ready`='0'";
    f_igosja_mysqli_query($sql);

    print '.';
    flush();
}