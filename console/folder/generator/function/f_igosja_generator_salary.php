<?php

/**
 * Списуємо ЗП хокеїстів
 */
function f_igosja_generator_salary()
{
    $sql = "SELECT `team_finance`,
                   `team_id`
            FROM `team`
            WHERE `team_id`!=0
            ORDER BY `team_id` ASC";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($team_array as $item)
    {
        $team_id = $item['team_id'];

        $sql = "SELECT SUM(`player_salary`) AS `salary`
                FROM `player`
                WHERE (`player_team_id`=$team_id
                AND `player_rent_team_id`=0)
                OR `player_rent_team_id`=$team_id";
        $salary_sql = f_igosja_mysqli_query($sql);

        $salary_array = $salary_sql->fetch_all(MYSQLI_ASSOC);

        $salary = $salary_array[0]['salary'];

        $finance = array(
            'finance_financetext_id' => FINANCETEXT_OUTCOME_SALARY,
            'finance_team_id' => $team_id,
            'finance_value' => -$salary,
            'finance_value_after' => $item['team_finance'] - $salary,
            'finance_value_before' => $item['team_finance'],
        );
        f_igosja_finance($finance);

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`-$salary
                WHERE `team_id`=$team_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}