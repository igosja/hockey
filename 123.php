<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `team_id`
        FROM `team`
        WHERE `team_id`!=0
        ORDER BY `team_id` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

foreach ($team_array as $team)
{
    $team_id = $team['team_id'];

    $sql = "SELECT `finance_id`,
                   `finance_value`
            FROM `finance`
            WHERE `finance_team_id`=$team_id
            ORDER BY `finance_id` ASC";
    $finance_sql = f_igosja_mysqli_query($sql);

    $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

    $finance_before = 1000000;

    foreach ($finance_array as $item)
    {
        $finance_id = $item['finance_id'];
        $finance_after = $finance_before + $item['finance_value'];

        $sql = "UPDATE `finance`
                SET `finance_value_before`=$finance_before,
                    `finance_value_after`=$finance_after
                WHERE `finance_id`=$finance_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $finance_before = $finance_after;
    }
}