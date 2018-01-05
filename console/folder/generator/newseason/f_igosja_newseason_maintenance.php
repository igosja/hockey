<?php

/**
 * Списуємо гроші за утримання баз
 */
function f_igosja_newseason_maintenance()
{
    $sql = "SELECT `base_maintenance_base`+`base_maintenance_slot`*(`basemedical_level`+`basephisical_level`+`baseschool_level`+`basescout_level`+`basetraining_level`) AS `maintenance`,
                   `team_finance`,
                   `team_id`
            FROM `team`
            LEFT JOIN `base`
            ON `team_base_id`=`base_id`
            LEFT JOIN `basemedical`
            ON `team_basemedical_id`=`basemedical_id`
            LEFT JOIN `basephisical`
            ON `team_basephisical_id`=`basephisical_id`
            LEFT JOIN `baseschool`
            ON `team_baseschool_id`=`baseschool_id`
            LEFT JOIN `basescout`
            ON `team_basescout_id`=`basescout_id`
            LEFT JOIN `basetraining`
            ON `team_basetraining_id`=`basetraining_id`
            WHERE `team_id`!=0
            ORDER BY `team_id` ASC";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($team_array as $item)
    {
        $team_id        = $item['team_id'];
        $maintenance    = $item['maintenance'];

        $finance = array(
            'finance_financetext_id' => FINANCETEXT_OUTCOME_MAINTENANCE,
            'finance_team_id' => $team_id,
            'finance_value' => -$maintenance,
            'finance_value_after' => $item['team_finance'] - $maintenance,
            'finance_value_before' => $item['team_finance'],
        );
        f_igosja_finance($finance);

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`-$maintenance
                WHERE `team_id`=$team_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}