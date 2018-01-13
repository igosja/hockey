<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `offseason_place`,
               `team_finance`,
               `team_id`
        FROM `offseason`
        LEFT JOIN `team`
        ON `offseason_team_id`=`team_id`
        WHERE `offseason_season_id`=$igosja_season_id
        ORDER BY `offseason_id` ASC";
$offseason_sql = f_igosja_mysqli_query($sql);

$offseason_array = $offseason_sql->fetch_all(MYSQLI_ASSOC);

foreach ($offseason_array as $offseason)
{
    $team_id    = $offseason['team_id'];
    $prize_old  = 2000000 * 0.98 ^ ($offseason['offseason_place'] - 1);
    $prize      = round(2000000 * pow(0.98, $offseason['offseason_place'] - 1));

    $sql = "UPDATE `team`
            SET `team_finance`=`team_finance`-$prize_old+$prize
            WHERE `team_id`=$team_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `finance`
            SET `finance_value`=$prize
            WHERE `finance_team_id`=$team_id
            AND `finance_financetext_id`=".FINANCETEXT_INCOME_PRIZE_OFFSEASON;
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `finance_id`,
                   `finance_value`,
                   `finance_value_before`
            FROM `finance`
            WHERE `finance_team_id`=$team_id
            AND FROM_UNIXTIME(`finance_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `finance_id` ASC";
    $finance_array = f_igosja_mysqli_query($sql);

    $before = 0;

    foreach ($finance_array as $item)
    {
        if (0 == $before)
        {
            $before = $item['finance_value_before'];
        }
        
        $value = $item['finance_value'];
        $after = $before + $value;
        $finance_id = $item['finance_id'];
        
        $sql = "UPDATE `finance`
                SET `finance_value`=$value,
                    `finance_value_before`=$before,
                    `finance_value_after`=$after
                WHERE `finance_id`=$finance_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
        
        $before = $after;
    }
            
//    $finance = array(
//        'finance_financetext_id' => FINANCETEXT_INCOME_PRIZE_OFFSEASON,
//        'finance_team_id' => $team_id,
//        'finance_value' => $prize,
//        'finance_value_after' => $offseason['team_finance'] + $prize,
//        'finance_value_before' => $offseason['team_finance'],
//    );
//    f_igosja_finance($finance);

//    $sql = "UPDATE `team`
//            SET `team_finance`=`team_finance`+$prize
//            WHERE `team_id`=$team_id
//            LIMIT 1";
//    f_igosja_mysqli_query($sql);
}