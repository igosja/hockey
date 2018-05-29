<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `team_id`
     FROM `team`
     WHERE `team_id`!=0
     ORDER BY `team_id` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

foreach ($team_array as $team) {
    $team_finance = 1000000;

    $team_id = $team['team_id'];

    $sql = "SELECT `finance_id`,
                `finance_value`,
                `finance_financetext_id`
         FROM `finance`
         WHERE `finance_team_id`=$team_id
         ORDER BY `finance_team_id` ASC";
    $finance_sql = f_igosja_mysqli_query($sql);

    $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($finance_array as $finance) {
        $before = $team_finance;
        $value = $finance['finance_value'];
        $after = $before + $value;
        $finance_id = $finance['finance_id'];

        if (FINANCETEXT_TEAM_REREGISTER == $finance['finance_financetext_id']) {
            $after = BALANCE_TEAM_BASE;
            $value = $after - $before;
        }

        $sql = "UPDATE `finance`
             SET `finance_value_before`=$before,
                  `finance_value_after`=$after,
                  `finance_value`=$value
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