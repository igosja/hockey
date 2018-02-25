<?php

/**
 * Додаємо в каси команд гроші зі стадіонів
 */
function f_igosja_generator_finance_stadium()
{
    $sql = "SELECT `game_guest_national_id`,
                   `game_guest_team_id`,
                   `game_home_national_id`,
                   `game_home_team_id`,
                   `game_ticket`,
                   `game_visitor`,
                   `schedule_stage_id`,
                   `schedule_tournamenttype_id`,
                   `stadium_capacity`,
                   `stadium_maintenance`,
                   `team_id` AS `stadium_team_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            LEFT JOIN `stadium`
            ON `game_stadium_id`=`stadium_id`
            LEFT JOIN `team` AS `team_stadium`
            ON `stadium_id`=`team_stadium_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $game)
    {
        $home_national_id   = $game['game_home_national_id'];
        $home_team_id       = $game['game_home_team_id'];
        $guest_national_id  = $game['game_guest_national_id'];
        $guest_team_id      = $game['game_guest_team_id'];
        $stadium_team_id    = $game['stadium_team_id'];
        $outcome            = $game['stadium_maintenance'];
        $income             = $game['game_ticket'] * $game['game_visitor'];

        if (TOURNAMENTTYPE_FRIENDLY == $game['schedule_tournamenttype_id'])
        {
            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$home_team_id
                    LIMIT 1";
            $finance_sql = f_igosja_mysqli_query($sql);

            $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TICKET,
                'finance_team_id' => $home_team_id,
                'finance_value' => $income / 2,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income / 2,
                'finance_value_before' => $finance_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_OUTCOME_GAME,
                'finance_team_id' => $home_team_id,
                'finance_value' => -$outcome / 2,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income / 2 - $outcome / 2,
                'finance_value_before' => $finance_array[0]['team_finance'] + $income / 2,
            );
            f_igosja_finance($finance);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$guest_team_id
                    LIMIT 1";
            $finance_sql = f_igosja_mysqli_query($sql);

            $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TICKET,
                'finance_team_id' => $guest_team_id,
                'finance_value' => $income / 2,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income / 2,
                'finance_value_before' => $finance_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_OUTCOME_GAME,
                'finance_team_id' => $guest_team_id,
                'finance_value' => -$outcome / 2,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income / 2 - $outcome / 2,
                'finance_value_before' => $finance_array[0]['team_finance'] + $income / 2,
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+$income/2-$outcome/2
                    WHERE `team_id` IN ($home_team_id, $guest_team_id)";
            f_igosja_mysqli_query($sql);
        }
        elseif (TOURNAMENTTYPE_NATIONAL == $game['schedule_tournamenttype_id'])
        {
            $sql = "SELECT `national_finance`
                    FROM `national`
                    WHERE `national_id`=$home_national_id
                    LIMIT 1";
            $finance_sql = f_igosja_mysqli_query($sql);

            $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TICKET,
                'finance_national_id' => $home_national_id,
                'finance_value' => $income / 3,
                'finance_value_after' => $finance_array[0]['national_finance'] + $income / 3,
                'finance_value_before' => $finance_array[0]['national_finance'],
            );
            f_igosja_finance($finance);

            $sql = "SELECT `national_finance`
                    FROM `national`
                    WHERE `national_id`=$guest_national_id
                    LIMIT 1";
            $finance_sql = f_igosja_mysqli_query($sql);

            $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TICKET,
                'finance_national_id' => $guest_national_id,
                'finance_value' => $income / 3,
                'finance_value_after' => $finance_array[0]['national_finance'] + $income / 3,
                'finance_value_before' => $finance_array[0]['national_finance'],
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `national`
                    SET `national_finance`=`national_finance`+$income/3
                    WHERE `national_id` IN ($home_national_id, $guest_national_id)";
            f_igosja_mysqli_query($sql);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$stadium_team_id
                    LIMIT 1";
            $finance_sql = f_igosja_mysqli_query($sql);

            $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TICKET,
                'finance_team_id' => $stadium_team_id,
                'finance_value' => $income / 3,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income / 3,
                'finance_value_before' => $finance_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+$income/3
                    WHERE `team_id`=$stadium_team_id";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$home_team_id
                    LIMIT 1";
            $finance_sql = f_igosja_mysqli_query($sql);

            $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TICKET,
                'finance_team_id' => $home_team_id,
                'finance_value' => $income,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income,
                'finance_value_before' => $finance_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_OUTCOME_GAME,
                'finance_team_id' => $home_team_id,
                'finance_value' => -$outcome,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income - $outcome,
                'finance_value_before' => $finance_array[0]['team_finance'] + $income,
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+$income-$outcome
                    WHERE `team_id`=$home_team_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }
}