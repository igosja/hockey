<?php

/**
 * Помічаємо тих, хто вилетів з ЛЧ
 */
function f_igosja_generator_league_out()
{
    global $igosja_season_id;

    $sql = "SELECT `schedule_id`,
                   `schedule_stage_id`,
                   `schedule_tournamenttype_id`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";
    $schedule_sql = f_igosja_mysqli_query($sql);

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($schedule_array as $item)
    {
        if (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'])
        {
            $schedule_id        = $item['schedule_id'];
            $stage_id           = $item['schedule_stage_id'];
            $tournamenttype_id  = $item['schedule_tournamenttype_id'];

            if (in_array($stage_id, array(STAGE_1_QUALIFY, STAGE_2_QUALIFY, STAGE_3_QUALIFY, STAGE_1_8_FINAL, STAGE_QUATER, STAGE_SEMI, STAGE_FINAL)))
            {
                $sql = "SELECT `game_guest_team_id`,
                               `game_home_team_id`
                        FROM `game`
                        WHERE `game_schedule_id`=$schedule_id
                        ORDER BY `game_id` ASC";
                $game_sql = f_igosja_mysqli_query($sql);

                $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($game_array as $game)
                {
                    $home_team_id   = $game['game_home_team_id'];
                    $guest_team_id  = $game['game_guest_team_id'];

                    $sql = "SELECT `game_guest_score`+`game_guest_score_bullet` AS `guest_score`,
                                   `game_guest_team_id`,
                                   `game_home_score`+`game_home_score_bullet` AS `home_score`,
                                   `game_home_team_id`
                            FROM `game`
                            LEFT JOIN `schedule`
                            ON `game_schedule_id`=`schedule_id`
                            WHERE ((`game_home_team_id`=$home_team_id
                            AND `game_guest_team_id`=$guest_team_id)
                            OR (`game_home_team_id`=$guest_team_id
                            AND `game_guest_team_id`=$home_team_id))
                            AND `game_played`=1
                            AND `schedule_tournamenttype_id`=$tournamenttype_id
                            AND `schedule_stage_id`=$stage_id
                            AND `schedule_season_id`=$igosja_season_id
                            ORDER BY `game_id` ASC";
                    $prev_sql = f_igosja_mysqli_query($sql);

                    if ($prev_sql->num_rows > 1)
                    {
                        $home_win   = 0;
                        $guest_win  = 0;

                        $prev_array = $prev_sql->fetch_all(MYSQLI_ASSOC);

                        foreach ($prev_array as $prev)
                        {
                            if ($prev['home_score'] > $prev['guest_score'])
                            {
                                if ($home_team_id == $prev['game_home_team_id'])
                                {
                                    $home_win++;
                                }
                                else
                                {
                                    $guest_win++;
                                }
                            }
                            elseif ($prev['home_score'] < $prev['guest_score'])
                            {
                                if ($home_team_id == $prev['game_home_team_id'])
                                {
                                    $guest_win++;
                                }
                                else
                                {
                                    $home_win++;
                                }
                            }
                        }

                        if ($home_win > $guest_win)
                        {
                            $loose_team_id = $guest_team_id;
                        }
                        else
                        {
                            $loose_team_id = $home_team_id;
                        }

                        $sql = "UPDATE `participantleague`
                                SET `participantleague_stage_id`=$stage_id
                                WHERE `participantleague_team_id`=$loose_team_id
                                AND `participantleague_season_id`=$igosja_season_id
                                LIMIT 1";
                        f_igosja_mysqli_query($sql);
                    }
                }
            }
            elseif (STAGE_6_TOUR == $stage_id)
            {
                $sql = "SELECT `league_place`,
                               `league_team_id`
                        FROM `league`
                        WHERE `league_place` IN (3, 4)
                        AND `league_season_id`=$igosja_season_id
                        ORDER BY `league_id` ASC";
                $league_sql = f_igosja_mysqli_query($sql);

                $league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($league_array as $league)
                {
                    $team_id    = $league['league_team_id'];
                    $place      = $league['league_place'];

                    $sql = "UPDATE `participantleague`
                            SET `participantleague_stage_id`=$place
                            WHERE `participantleague_team_id`=$team_id
                            AND `participantleague_season_id`=$igosja_season_id
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
    }
}