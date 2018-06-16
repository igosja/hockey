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
        elseif (TOURNAMENTTYPE_CONFERENCE == $item['schedule_tournamenttype_id'] && STAGE_33_TOUR == $item['schedule_stage_id'])
        {
            $sql = "SELECT `participantchampionship_division_id`,
                           `participantchampionship_stage_id`,
                           `team_finance`,
                           `team_id`
                    FROM `participantchampionship`
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    WHERE `participantchampionship_season_id`=$igosja_season_id
                    AND `participantchampionship_stage_id`=" . STAGE_QUATER;
            $championship_sql = f_igosja_mysqli_query($sql);

            $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($championship_array as $championship)
            {
                $team_id    = $championship['team_id'];
                $prize      = round(2000000 * pow(0.98, ($championship['participantchampionship_division_id'] - 1) * 16));

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
        elseif (TOURNAMENTTYPE_CONFERENCE == $item['schedule_tournamenttype_id'] && STAGE_36_TOUR == $item['schedule_stage_id'])
        {
            $sql = "SELECT `participantchampionship_division_id`,
                           `participantchampionship_stage_id`,
                           `team_finance`,
                           `team_id`
                    FROM `participantchampionship`
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    WHERE `participantchampionship_season_id`=$igosja_season_id
                    AND `participantchampionship_stage_id`=" . STAGE_SEMI;
            $championship_sql = f_igosja_mysqli_query($sql);

            $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($championship_array as $championship)
            {
                $team_id    = $championship['team_id'];
                $prize      = round(3000000 * pow(0.98, ($championship['participantchampionship_division_id'] - 1) * 16));

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
        elseif (TOURNAMENTTYPE_CONFERENCE == $item['schedule_tournamenttype_id'] && STAGE_41_TOUR == $item['schedule_stage_id'])
        {
            $sql = "SELECT `participantchampionship_division_id`,
                           `participantchampionship_stage_id`,
                           `team_finance`,
                           `team_id`
                    FROM `participantchampionship`
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    WHERE `participantchampionship_season_id`=$igosja_season_id
                    AND `participantchampionship_stage_id` IN (" . STAGE_FINAL . ", 0)";
            $championship_sql = f_igosja_mysqli_query($sql);

            $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($championship_array as $championship)
            {
                if (STAGE_FINAL == $championship['participantchampionship_stage_id'])
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
        elseif (TOURNAMENTTYPE_NATIONAL == $item['schedule_tournamenttype_id'] && STAGE_11_TOUR == $item['schedule_stage_id'])
        {
            $sql = "SELECT `worldcup_division_id`,
                           `worldcup_place`,
                           `national_finance`,
                           `national_id`
                    FROM `worldcup`
                    LEFT JOIN `national`
                    ON `worldcup_national_id`=`national_id`
                    WHERE `worldcup_season_id`=$igosja_season_id
                    ORDER BY `worldcup_id` ASC";
            $worldcup_sql = f_igosja_mysqli_query($sql);

            $worldcup_array = $worldcup_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($worldcup_array as $worldcup)
            {
                $national_id    = $worldcup['national_id'];
                $prize          = round(25000000 * pow(0.98, ($worldcup['worldcup_place'] - 1) + ($worldcup['worldcup_division_id'] - 1) * 12));

                $finance = array(
                    'finance_financetext_id' => FINANCETEXT_INCOME_PRIZE_WORLDCUP,
                    'finance_national_id' => $national_id,
                    'finance_value' => $prize,
                    'finance_value_after' => $worldcup['national_finance'] + $prize,
                    'finance_value_before' => $worldcup['national_finance'],
                );
                f_igosja_finance($finance);

                $sql = "UPDATE `national`
                        SET `national_finance`=`national_finance`+$prize
                        WHERE `national_id`=$national_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && in_array($item['schedule_stage_id'], array(STAGE_1_QUALIFY, STAGE_2_QUALIFY, STAGE_3_QUALIFY, STAGE_1_8_FINAL, STAGE_QUATER, STAGE_SEMI)))
        {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')>CURDATE()
                    AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $next_stage_sql = f_igosja_mysqli_query($sql);

            $next_stage_array = $next_stage_sql->fetch_all(MYSQLI_ASSOC);

            if ($next_stage_array[0]['schedule_stage_id'] != $item['schedule_stage_id'])
            {
                $sql = "SELECT `participantleague_stage_id`,
                               `team_finance`,
                               `team_id`
                        FROM `participantleague`
                        LEFT JOIN `team`
                        ON `participantleague_team_id`=`team_id`
                        WHERE `participantleague_season_id`=$igosja_season_id
                        AND `participantleague_stage_id`=" . $item['schedule_stage_id'];
                $league_sql = f_igosja_mysqli_query($sql);

                $league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($league_array as $league)
                {
                    $team_id = $league['team_id'];

                    if (STAGE_SEMI == $league['participantleague_stage_id'])
                    {
                        $prize = 21000000;
                    }
                    elseif (STAGE_QUATER == $league['participantleague_stage_id'])
                    {
                        $prize = 19000000;
                    }
                    elseif (STAGE_1_8_FINAL == $league['participantleague_stage_id'])
                    {
                        $prize = 17000000;
                    }
                    elseif (STAGE_3_QUALIFY == $league['participantleague_stage_id'])
                    {
                        $prize = 9000000;
                    }
                    elseif (STAGE_2_QUALIFY == $league['participantleague_stage_id'])
                    {
                        $prize = 7000000;
                    }
                    else
                    {
                        $prize = 5000000;
                    }

                    $finance = array(
                        'finance_financetext_id' => FINANCETEXT_INCOME_PRIZE_LEAGUE,
                        'finance_team_id' => $team_id,
                        'finance_value' => $prize,
                        'finance_value_after' => $league['team_finance'] + $prize,
                        'finance_value_before' => $league['team_finance'],
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
        elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_6_TOUR == $item['schedule_stage_id'])
        {
            $sql = "SELECT `participantleague_stage_id`,
                           `team_finance`,
                           `team_id`
                    FROM `participantleague`
                    LEFT JOIN `team`
                    ON `participantleague_team_id`=`team_id`
                    WHERE `participantleague_season_id`=$igosja_season_id
                    AND `participantleague_stage_id` IN (3, 4)";
            $league_sql = f_igosja_mysqli_query($sql);

            $league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($league_array as $league)
            {
                $team_id = $league['team_id'];

                if (4 == $league['participantleague_stage_id'])
                {
                    $prize = 13000000;
                }
                else
                {
                    $prize = 15000000;
                }

                $finance = array(
                    'finance_financetext_id' => FINANCETEXT_INCOME_PRIZE_LEAGUE,
                    'finance_team_id' => $team_id,
                    'finance_value' => $prize,
                    'finance_value_after' => $league['team_finance'] + $prize,
                    'finance_value_before' => $league['team_finance'],
                );
                f_igosja_finance($finance);

                $sql = "UPDATE `team`
                        SET `team_finance`=`team_finance`+$prize
                        WHERE `team_id`=$team_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_FINAL == $item['schedule_stage_id'])
        {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')>CURDATE()
                    AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $next_stage_sql = f_igosja_mysqli_query($sql);

            if (0 == $next_stage_sql->num_rows)
            {
                $sql = "SELECT `participantleague_stage_id`,
                               `team_finance`,
                               `team_id`
                        FROM `participantleague`
                        LEFT JOIN `team`
                        ON `participantleague_team_id`=`team_id`
                        WHERE `participantleague_season_id`=$igosja_season_id
                        AND `participantleague_stage_id` IN (" . STAGE_FINAL . ", 0)";
                $league_sql = f_igosja_mysqli_query($sql);

                $league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($league_array as $league)
                {
                    $team_id = $league['team_id'];

                    if (STAGE_FINAL == $league['participantleague_stage_id'])
                    {
                        $prize = 23000000;
                    }
                    else
                    {
                        $prize = 25000000;
                    }

                    $finance = array(
                        'finance_financetext_id' => FINANCETEXT_INCOME_PRIZE_LEAGUE,
                        'finance_team_id' => $team_id,
                        'finance_value' => $prize,
                        'finance_value_after' => $league['team_finance'] + $prize,
                        'finance_value_before' => $league['team_finance'],
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
}