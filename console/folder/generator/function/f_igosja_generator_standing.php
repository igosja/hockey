<?php

function f_igosja_generator_standing()
//Обновляем турнирные таблицы
{
    $sql = "SELECT `game_guest_national_id`,
                   `game_guest_score`,
                   `game_guest_score_bullet`,
                   `game_guest_score_over`,
                   `game_guest_team_id`,
                   `game_home_national_id`,
                   `game_home_score`,
                   `game_home_score_bullet`,
                   `game_home_score_over`,
                   `game_home_team_id`,
                   `shedule_season_id`,
                   `shedule_stage_id`,
                   `shedule_tournamenttype_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(1);

    foreach ($game_array as $game)
    {
        $guest_loose        = 0;
        $guest_loose_over   = 0;
        $guest_win          = 0;
        $guest_win_over     = 0;
        $home_loose         = 0;
        $home_loose_over    = 0;
        $home_win           = 0;
        $home_win_over      = 0;

        if ($game['game_home_score'] > $game['game_guest_score'])
        {
            if (0 == $game['game_home_score_over'])
            {
                $home_win++;
                $guest_loose++;
            }
            else
            {
                $home_win_over++;
                $guest_loose_over++;
            }
        }
        elseif ($game['game_guest_score'] > $game['game_home_score'])
        {
            if (0 == $game['game_guest_score_over'])
            {
                $guest_win++;
                $home_loose++;
            }
            else
            {
                $guest_win_over++;
                $home_loose_over++;
            }
        }
        elseif ($game['game_guest_score'] == $game['game_home_score'])
        {
            if (0 == $game['game_home_score_bullet'])
            {
                $guest_win_over++;
                $home_loose_over++;
            }
            else
            {
                $home_win_over++;
                $guest_loose_over++;
            }
        }

        if (TOURNAMENTTYPE_CONFERENCE == $game['shedule_tournamenttype_id'])
        {
            $sql = "UPDATE `conference`
                    SET `conference_game`=`conference_game`+'1',
                        `conference_loose`=`conference_loose`+'$home_loose',
                        `conference_loose_over`=`conference_loose_over`+'$home_loose_over',
                        `conference_pass`=`conference_pass`+'" . $game['game_guest_score'] . "',
                        `conference_score`=`conference_score`+'" . $game['game_home_score'] . "',
                        `conference_win`=`conference_win`+'$home_win',
                        `conference_win_over`=`conference_win_over`+'$home_win_over'
                    WHERE `conference_team_id`='" . $game['game_home_team_id'] . "'
                    AND `conference_season_id`='" . $game['shedule_season_id'] . "'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `conference`
                    SET `conference_game`=`conference_game`+'1',
                        `conference_loose`=`conference_loose`+'$guest_loose',
                        `conference_loose_over`=`conference_loose_over`+'$guest_loose_over',
                        `conference_pass`=`conference_pass`+'" . $game['game_guest_score'] . "',
                        `conference_score`=`conference_score`+'" . $game['game_guest_score'] . "',
                        `conference_win`=`conference_win`+'$guest_win',
                        `conference_win_over`=`conference_win_over`+'$guest_win_over'
                    WHERE `conference_team_id`='" . $game['game_guest_team_id'] . "'
                    AND `conference_season_id`='" . $game['shedule_season_id'] . "'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
        elseif (TOURNAMENTTYPE_OFFSEASON == $game['shedule_tournamenttype_id'])
        {
            $sql = "UPDATE `offseason`
                    SET `offseason_game`=`offseason_game`+'1',
                        `offseason_loose`=`offseason_loose`+'$home_loose',
                        `offseason_loose_over`=`offseason_loose_over`+'$home_loose_over',
                        `offseason_pass`=`offseason_pass`+'" . $game['game_guest_score'] . "',
                        `offseason_score`=`offseason_score`+'" . $game['game_home_score'] . "',
                        `offseason_win`=`offseason_win`+'$home_win',
                        `offseason_win_over`=`offseason_win_over`+'$home_win_over'
                    WHERE `offseason_team_id`='" . $game['game_home_team_id'] . "'
                    AND `offseason_season_id`='" . $game['shedule_season_id'] . "'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `offseason`
                    SET `offseason_game`=`offseason_game`+'1',
                        `offseason_loose`=`offseason_loose`+'$guest_loose',
                        `offseason_loose_over`=`offseason_loose_over`+'$guest_loose_over',
                        `offseason_pass`=`offseason_pass`+'" . $game['game_guest_score'] . "',
                        `offseason_score`=`offseason_score`+'" . $game['game_guest_score'] . "',
                        `offseason_win`=`offseason_win`+'$guest_win',
                        `offseason_win_over`=`offseason_win_over`+'$guest_win_over'
                    WHERE `offseason_team_id`='" . $game['game_guest_team_id'] . "'
                    AND `offseason_season_id`='" . $game['shedule_season_id'] . "'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
        elseif (TOURNAMENTTYPE_CHAMPIONSHIP == $game['shedule_tournamenttype_id'] &&
                STAGE_1_TOUR <= $game['shedule_stage_id'] &&
                STAGE_30_TOUR >= $game['shedule_stage_id'])
        {
            $sql = "UPDATE `championship`
                    SET `championship_game`=`championship_game`+'1',
                        `championship_loose`=`championship_loose`+'$home_loose',
                        `championship_loose_over`=`championship_loose_over`+'$home_loose_over',
                        `championship_pass`=`championship_pass`+'" . $game['game_guest_score'] . "',
                        `championship_score`=`championship_score`+'" . $game['game_home_score'] . "',
                        `championship_win`=`championship_win`+'$home_win',
                        `championship_win_over`=`championship_win_over`+'$home_win_over'
                    WHERE `championship_team_id`='" . $game['game_home_team_id'] . "'
                    AND `championship_season_id`='" . $game['shedule_season_id'] . "'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `championship`
                    SET `championship_game`=`championship_game`+'1',
                        `championship_loose`=`championship_loose`+'$guest_loose',
                        `championship_loose_over`=`championship_loose_over`+'$guest_loose_over',
                        `championship_pass`=`championship_pass`+'" . $game['game_guest_score'] . "',
                        `championship_score`=`championship_score`+'" . $game['game_guest_score'] . "',
                        `championship_win`=`championship_win`+'$guest_win',
                        `championship_win_over`=`championship_win_over`+'$guest_win_over'
                    WHERE `championship_team_id`='" . $game['game_guest_team_id'] . "'
                    AND `championship_season_id`='" . $game['shedule_season_id'] . "'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $game['shedule_tournamenttype_id'] &&
                STAGE_1_TOUR <= $game['shedule_stage_id'] &&
                STAGE_6_TOUR >= $game['shedule_stage_id'])
        {
            $sql = "UPDATE `league`
                    SET `league_game`=`league_game`+'1',
                        `league_loose`=`league_loose`+'$home_loose',
                        `league_loose_over`=`league_loose_over`+'$home_loose_over',
                        `league_pass`=`league_pass`+'" . $game['game_guest_score'] . "',
                        `league_score`=`league_score`+'" . $game['game_home_score'] . "',
                        `league_win`=`league_win`+'$home_win',
                        `league_win_over`=`league_win_over`+'$home_win_over'
                    WHERE `league_team_id`='" . $game['game_home_team_id'] . "'
                    AND `league_season_id`='" . $game['shedule_season_id'] . "'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `league`
                    SET `league_game`=`league_game`+'1',
                        `league_loose`=`league_loose`+'$guest_loose',
                        `league_loose_over`=`league_loose_over`+'$guest_loose_over',
                        `league_pass`=`league_pass`+'" . $game['game_guest_score'] . "',
                        `league_score`=`league_score`+'" . $game['game_guest_score'] . "',
                        `league_win`=`league_win`+'$guest_win',
                        `league_win_over`=`league_win_over`+'$guest_win_over'
                    WHERE `league_team_id`='" . $game['game_guest_team_id'] . "'
                    AND `league_season_id`='" . $game['shedule_season_id'] . "'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
        elseif (TOURNAMENTTYPE_NATIONAL == $game['shedule_tournamenttype_id'])
        {
            $sql = "UPDATE `worldcup`
                    SET `worldcup_game`=`worldcup_game`+'1',
                        `worldcup_loose`=`worldcup_loose`+'$home_loose',
                        `worldcup_loose_over`=`worldcup_loose_over`+'$home_loose_over',
                        `worldcup_pass`=`worldcup_pass`+'" . $game['game_guest_score'] . "',
                        `worldcup_score`=`worldcup_score`+'" . $game['game_home_score'] . "',
                        `worldcup_win`=`worldcup_win`+'$home_win',
                        `worldcup_win_over`=`worldcup_win_over`+'$home_win_over'
                    WHERE `worldcup_team_id`='" . $game['game_home_national_id'] . "'
                    AND `worldcup_season_id`='" . $game['shedule_season_id'] . "'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `worldcup`
                    SET `worldcup_game`=`worldcup_game`+'1',
                        `worldcup_loose`=`worldcup_loose`+'$guest_loose',
                        `worldcup_loose_over`=`worldcup_loose_over`+'$guest_loose_over',
                        `worldcup_pass`=`worldcup_pass`+'" . $game['game_guest_score'] . "',
                        `worldcup_score`=`worldcup_score`+'" . $game['game_guest_score'] . "',
                        `worldcup_win`=`worldcup_win`+'$guest_win',
                        `worldcup_win_over`=`worldcup_win_over`+'$guest_win_over'
                    WHERE `worldcup_team_id`='" . $game['game_guest_national_id'] . "'
                    AND `worldcup_season_id`='" . $game['shedule_season_id'] . "'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}