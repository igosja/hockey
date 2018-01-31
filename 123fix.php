<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `team_id`,
               `team_finance`
        FROM `team`
        WHERE `team_id` NOT IN (0, 1, 6)
        ORDER BY `team_id` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

print '<pre>';
print_r($team_array);
exit;

foreach ($team_array as $item)
{
    $team_id    = $item['team_id'];
    $prize      = 9000000;

    $sql = "UPDATE `team`
            SET `team_finance`=`team_finance`+$prize
            WHERE `team_id`=$team_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $finance = array(
        'finance_financetext_id' => FINANCETEXT_INCOME_PRIZE_VIP,
        'finance_team_id' => $team_id,
        'finance_value' => $prize,
        'finance_value_after' => $item['team_finance'] + $prize,
        'finance_value_before' => $item['team_finance'],
    );
    f_igosja_finance($finance);
}