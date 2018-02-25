<?php

/**
 * Переказ грошей збірних менеджерам
 */
function f_igosja_newseason_national_transfer_money()
{
    $sql = "SELECT `national_id`,
                   `national_finance`
            FROM `national`
            WHERE `national_finance`>0
            AND `national_id`!=0";
    $national_sql = f_igosja_mysqli_query($sql);

    $national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($national_array as $national)
    {
        $national_id    = $national['national_id'];
        $money_national = $national['national_finance'];
        $money_coach    = round($money_national / 5);
        $money_player   = $national['national_finance'] - $money_coach;

        $sql = "SELECT SUM(`nationaluserday_day`) AS `total`
                FROM `nationaluserday`
                WHERE `nationaluserday_national_id`=$national_id";
        $total_sql = f_igosja_mysqli_query($sql);

        $total_array = $total_sql->fetch_all(MYSQLI_ASSOC);

        $total = $total_array[0]['total'];

        $sql = "SELECT `nationaluserday_day`,
                       `nationaluserday_user_id`
                FROM `nationaluserday`
                WHERE `nationaluserday_national_id`=$national_id
                ORDER BY `nationaluserday_user_id` ASC";
        $nationaluser_sql = f_igosja_mysqli_query($sql);

        $nationaluser_array = $nationaluser_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($nationaluser_array as $user)
        {
            $user_id    = $user['nationaluserday_user_id'];
            $money      = round($money_coach / $total * $user['nationaluserday_day']);

            $sql = "SELECT `user_finance`
                    FROM `user`
                    WHERE `user_id`=$user_id
                    LIMIT 1";
            $user_sql = f_igosja_mysqli_query($sql);

            $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_COACH,
                'finance_user_id' => $user_id,
                'finance_value' => $money,
                'finance_value_after' => $user_array[0]['user_finance'] + $money,
                'finance_value_before' => $user_array[0]['user_finance'],
            );

            f_igosja_finance($finance);

            $sql = "UPDATE `user`
                    SET `user_finance`=`user_finance`+$money
                    WHERE `user_id`=$user_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        $sql = "SELECT SUM(`nationalplayerday_day`) AS `total`
                FROM `nationalplayerday`
                WHERE `nationalplayerday_national_id`=$national_id";
        $total_sql = f_igosja_mysqli_query($sql);

        $total_array = $total_sql->fetch_all(MYSQLI_ASSOC);

        $total = $total_array[0]['total'];

        $sql = "SELECT SUM(`nationalplayerday_day`) AS `total`,
                       `nationalplayerday_team_id`
                FROM `nationalplayerday`
                WHERE `nationalplayerday_national_id`=$national_id
                GROUP BY `nationalplayerday_team_id`
                ORDER BY `nationalplayerday_team_id` ASC";
        $nationalteam_sql = f_igosja_mysqli_query($sql);

        $nationalteam_array = $nationalteam_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($nationalteam_array as $team)
        {
            $team_id    = $team['nationalplayerday_team_id'];
            $money      = round($money_player / $total * $team['total']);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$user_id
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_NATIONAL,
                'finance_team_id' => $team_id,
                'finance_value' => $money,
                'finance_value_after' => $team_array[0]['team_finance'] + $money,
                'finance_value_before' => $team_array[0]['team_finance'],
            );

            f_igosja_finance($finance);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+$money
                    WHERE `team_id`=$team_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        $finance = array(
            'finance_financetext_id' => FINANCETEXT_OUTCOME_NATIONAL,
            'finance_national_id' => $national_id,
            'finance_value' => -$money_national,
            'finance_value_after' => 0,
            'finance_value_before' => $money_national,
        );

        f_igosja_finance($finance);

        $sql = "UPDATE `national`
                SET `national_finance`=0
                WHERE `national_id`=$national_id";
        f_igosja_mysqli_query($sql);
    }
}