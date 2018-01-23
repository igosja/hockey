<?php

/**
 * Призові після завершення турніру
 */
function f_igosja_generator_prize()
{
    global $igosja_season_id;

    $sql = "SELECT `schedule_stage_id`,
                   `schedule_tournamenttype_id`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";
    $schedule_sql = f_igosja_mysqli_query($sql);

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($schedule_array as $item)
    {
        if (TOURNAMENTTYPE_OFFSEASON == $item['schedule_tournamenttype_id'] && STAGE_12_TOUR == $item['schedule_stage_id'])
        {
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
                $prize      = round(2000000 * pow(0.98, $offseason['offseason_place'] - 1));

                $finance = array(
                    'finance_financetext_id' => FINANCETEXT_INCOME_PRIZE_OFFSEASON,
                    'finance_team_id' => $team_id,
                    'finance_value' => $prize,
                    'finance_value_after' => $offseason['team_finance'] + $prize,
                    'finance_value_before' => $offseason['team_finance'],
                );
                f_igosja_finance($finance);

                $sql = "UPDATE `team`
                        SET `team_finance`=`team_finance`+$prize
                        WHERE `team_id`=$team_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
        elseif (TOURNAMENTTYPE_CONFERENCE == $item['schedule_tournamenttype_id'] && STAGE_41_TOUR == $item['schedule_stage_id'])
        {
            $sql = "SELECT `participantchampionship_division_id`,
                           `participantchampionship_stage_id`,
                           `team_finance`,
                           `team_id`
                    FROM `participantchampionship`
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    WHERE `participantchampionship_season_id`=$igosja_season_id";
            $championship_sql = f_igosja_mysqli_query($sql);

            $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($championship_array as $championship)
            {
                if (STAGE_QUATER == $championship['participantchampionship_stage_id'])
                {
                    $prize = 2000000;
                }
                elseif (STAGE_SEMI == $championship['participantchampionship_stage_id'])
                {
                    $prize = 3000000;
                }
                elseif (STAGE_FINAL == $championship['participantchampionship_stage_id'])
                {
                    $prize = 4000000;
                }
                else
                {
                    $prize = 5000000;
                }

                $team_id    = $championship['team_id'];
                $prize      = round($prize * pow(0.98, ($championship['participantchampionship_division_id'] - 1) * 16));

                $finance = array(
                    'finance_financetext_id' => FINANCETEXT_INCOME_PRIZE_CHAMPIONSHIP,
                    'finance_team_id' => $team_id,
                    'finance_value' => $prize,
                    'finance_value_after' => $championship['team_finance'] + $prize,
                    'finance_value_before' => $championship['team_finance'],
                );
                f_igosja_finance($finance);

                $sql = "UPDATE `team`
                        SET `team_finance`=`team_finance`+$prize
                        WHERE `team_id`=$team_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }

            $sql = "SELECT `conference_place`,
                           `team_finance`,
                           `team_id`
                    FROM `conference`
                    LEFT JOIN `team`
                    ON `conference_team_id`=`team_id`
                    WHERE `conference_season_id`=$igosja_season_id
                    ORDER BY `conference_id` ASC";
            $conference_sql = f_igosja_mysqli_query($sql);

            $conference_array = $conference_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($conference_array as $conference)
            {
                $team_id    = $conference['team_id'];
                $prize      = round(10000000 * pow(0.98, $conference['conference_place'] - 1));

                $finance = array(
                    'finance_financetext_id' => FINANCETEXT_INCOME_PRIZE_CONFERENCE,
                    'finance_team_id' => $team_id,
                    'finance_value' => $prize,
                    'finance_value_after' => $conference['team_finance'] + $prize,
                    'finance_value_before' => $conference['team_finance'],
                );
                f_igosja_finance($finance);

                $sql = "UPDATE `team`
                        SET `team_finance`=`team_finance`+$prize
                        WHERE `team_id`=$team_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
        elseif (TOURNAMENTTYPE_CHAMPIONSHIP == $item['schedule_tournamenttype_id'] && STAGE_30_TOUR == $item['schedule_stage_id'])
        {
            $sql = "SELECT `championship_division_id`,
                           `championship_place`,
                           `team_finance`,
                           `team_id`
                    FROM `championship`
                    LEFT JOIN `team`
                    ON `championship_team_id`=`team_id`
                    WHERE `championship_season_id`=$igosja_season_id
                    ORDER BY `championship_id` ASC";
            $championship_sql = f_igosja_mysqli_query($sql);

            $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($championship_array as $championship)
            {
                $team_id    = $championship['team_id'];
                $prize      = round(20000000 * pow(0.98, ($championship['championship_place'] - 1) + ($championship['championship_division_id'] - 1) * 16));

                $finance = array(
                    'finance_financetext_id' => FINANCETEXT_INCOME_PRIZE_CHAMPIONSHIP,
                    'finance_team_id' => $team_id,
                    'finance_value' => $prize,
                    'finance_value_after' => $championship['team_finance'] + $prize,
                    'finance_value_before' => $championship['team_finance'],
                );
                f_igosja_finance($finance);

                $sql = "UPDATE `team`
                        SET `team_finance`=`team_finance`+$prize
                        WHERE `team_id`=$team_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}