<?php

include(__DIR__ . '/../include/include.php');

$sql = "SELECT `team_id`
        FROM `team`
        WHERE `team_id`!=0
        ORDER BY `team_id` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

foreach ($team_array as $team)
{
    $team_finance = 0;

    $team_id = $team['team_id'];

    $sql = "SELECT `finance_id`,
                   `finance_value`
            FROM `finance`
            WHERE `finance_team_id`=$team_id
            ORDER BY `finance_team_id` ASC";
    $finance_sql = f_igosja_mysqli_query($sql);

    $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($finance_array as $finance)
    {
        $before = $team_finance;
        $after = $before + $finance['finance_value'];
        $finance_id = $finance['finance_id'];

        $sql = "UPDATE `finance`
                SET `finance_value_before`=$before,
                     `finance_value_after`=$after
                WHERE `finance_id`=$finance_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $team_finance = $after;
    }

    $sql = "UPDATE `team`
            SET `team_finance`=$team_finance
            WHERE `team_id`=$team_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}

redirect('/admin/index.php');