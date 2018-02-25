<?php

/**
 * Досягнення після завершення турніру
 */
function f_igosja_generator_achievement()
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
            $sql = "INSERT INTO `achievement` (`achievement_position`, `achievement_season_id`, `achievement_team_id`, `achievement_tournamenttype_id`, `achievement_user_id`)
                    SELECT `offseason_place`, $igosja_season_id, `team_id`, " . TOURNAMENTTYPE_OFFSEASON . ", `team_user_id`
                    FROM `offseason`
                    LEFT JOIN `team`
                    ON `offseason_team_id`=`team_id`
                    WHERE `offseason_season_id`=$igosja_season_id";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `achievementplayer` (`achievementplayer_player_id`, `achievementplayer_position`, `achievementplayer_season_id`, `achievementplayer_team_id`, `achievementplayer_tournamenttype_id`)
                    SELECT `player_id`, `offseason_place`, $igosja_season_id, `team_id`, " . TOURNAMENTTYPE_OFFSEASON . "
                    FROM `offseason`
                    LEFT JOIN `team`
                    ON `offseason_team_id`=`team_id`
                    LEFT JOIN `player`
                    ON `team_id`=`player_team_id`
                    WHERE `offseason_season_id`=$igosja_season_id";
            f_igosja_mysqli_query($sql);
        }
        elseif (TOURNAMENTTYPE_NATIONAL == $item['schedule_tournamenttype_id'] && STAGE_11_TOUR == $item['schedule_stage_id'])
        {
            $sql = "INSERT INTO `achievement` (`achievement_position`, `achievement_season_id`, `achievement_national_id`, `achievement_tournamenttype_id`, `achievement_user_id`)
                    SELECT `worldcup_place`, $igosja_season_id, `national_id`, " . TOURNAMENTTYPE_NATIONAL . ", `national_user_id`
                    FROM `worldcup`
                    LEFT JOIN `national`
                    ON `worldcup_national_id`=`national_id`
                    WHERE `worldcup_season_id`=$igosja_season_id";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `achievementplayer` (`achievementplayer_player_id`, `achievementplayer_position`, `achievementplayer_season_id`, `achievementplayer_national_id`, `achievementplayer_tournamenttype_id`)
                    SELECT `nationalplayerday_player_id`, `worldcup_place`, $igosja_season_id, `nationalplayerday_national_id`, " . TOURNAMENTTYPE_NATIONAL . "
                    FROM `nationalplayerday`
                    LEFT JOIN `worldcup`
                    ON `nationalplayerday_national_id`=`worldcup_national_id`
                    WHERE `worldcup_season_id`=$igosja_season_id";
            f_igosja_mysqli_query($sql);
        }
        elseif (TOURNAMENTTYPE_CONFERENCE == $item['schedule_tournamenttype_id'] && STAGE_41_TOUR == $item['schedule_stage_id'])
        {
            $sql = "INSERT INTO `achievement` (`achievement_country_id`, `achievement_division_id`, `achievement_is_playoff`, `achievement_season_id`, `achievement_stage_id`, `achievement_team_id`, `achievement_tournamenttype_id`, `achievement_user_id`)
                    SELECT `participantchampionship_country_id`, `participantchampionship_division_id`, 1, $igosja_season_id, `participantchampionship_stage_id`, `team_id`, " . TOURNAMENTTYPE_CHAMPIONSHIP . ", `team_user_id`
                    FROM `participantchampionship`
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    WHERE `participantchampionship_season_id`=$igosja_season_id
                    AND `participantchampionship_stage_id` IN (" . STAGE_FINAL . ", 0)";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `achievementplayer` (`achievementplayer_country_id`, `achievementplayer_division_id`, `achievementplayer_is_playoff`, `achievementplayer_player_id`, `achievementplayer_season_id`, `achievementplayer_stage_id`, `achievementplayer_team_id`, `achievementplayer_tournamenttype_id`)
                    SELECT `participantchampionship_country_id`, `participantchampionship_division_id`, 1, `player_id`, $igosja_season_id, `participantchampionship_stage_id`, `team_id`, " . TOURNAMENTTYPE_CHAMPIONSHIP . "
                    FROM `participantchampionship`
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    LEFT JOIN `player`
                    ON `team_id`=`player_team_id`
                    WHERE `participantchampionship_season_id`=$igosja_season_id
                    AND `participantchampionship_stage_id` IN (" . STAGE_FINAL . ", 0)";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `achievement` (`achievement_position`, `achievement_season_id`, `achievement_team_id`, `achievement_tournamenttype_id`, `achievement_user_id`)
                    SELECT `conference_place`, $igosja_season_id, `team_id`, " . TOURNAMENTTYPE_CONFERENCE . ", `team_user_id`
                    FROM `conference`
                    LEFT JOIN `team`
                    ON `conference_team_id`=`team_id`
                    WHERE `conference_season_id`=$igosja_season_id";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `achievementplayer` (`achievementplayer_player_id`, `achievementplayer_position`, `achievementplayer_season_id`, `achievementplayer_team_id`, `achievementplayer_tournamenttype_id`)
                    SELECT `player_id`, `conference_place`, $igosja_season_id, `team_id`, " . TOURNAMENTTYPE_CONFERENCE . "
                    FROM `conference`
                    LEFT JOIN `team`
                    ON `conference_team_id`=`team_id`
                    LEFT JOIN `player`
                    ON `team_id`=`player_team_id`
                    WHERE `conference_season_id`=$igosja_season_id";
            f_igosja_mysqli_query($sql);
        }
        elseif (TOURNAMENTTYPE_CHAMPIONSHIP == $item['schedule_tournamenttype_id'] && STAGE_30_TOUR == $item['schedule_stage_id'])
        {
            $sql = "INSERT INTO `achievement` (`achievement_country_id`, `achievement_division_id`, `achievement_position`, `achievement_season_id`, `achievement_team_id`, `achievement_tournamenttype_id`, `achievement_user_id`)
                    SELECT `championship_country_id`, `championship_division_id`, `championship_place`, $igosja_season_id, `team_id`, " . TOURNAMENTTYPE_CHAMPIONSHIP . ", `team_user_id`
                    FROM `championship`
                    LEFT JOIN `team`
                    ON `championship_team_id`=`team_id`
                    WHERE `championship_season_id`=$igosja_season_id";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `achievementplayer` (`achievementplayer_country_id`, `achievementplayer_division_id`, `achievementplayer_player_id`, `achievementplayer_position`, `achievementplayer_season_id`, `achievementplayer_team_id`, `achievementplayer_tournamenttype_id`)
                    SELECT `championship_country_id`, `championship_division_id`, `player_id`, `championship_place`, $igosja_season_id, `team_id`, " . TOURNAMENTTYPE_CHAMPIONSHIP . "
                    FROM `championship`
                    LEFT JOIN `team`
                    ON `championship_team_id`=`team_id`
                    LEFT JOIN `player`
                    ON `team_id`=`player_team_id`
                    WHERE `championship_season_id`=$igosja_season_id";
            f_igosja_mysqli_query($sql);
        }
        elseif (TOURNAMENTTYPE_CONFERENCE == $item['schedule_tournamenttype_id'] && STAGE_33_TOUR == $item['schedule_stage_id'])
        {
            $sql = "INSERT INTO `achievement` (`achievement_country_id`, `achievement_division_id`, `achievement_is_playoff`, `achievement_season_id`, `achievement_stage_id`, `achievement_team_id`, `achievement_tournamenttype_id`, `achievement_user_id`)
                    SELECT `participantchampionship_country_id`, `participantchampionship_division_id`, 1, $igosja_season_id, `participantchampionship_stage_id`, `team_id`, " . TOURNAMENTTYPE_CHAMPIONSHIP . ", `team_user_id`
                    FROM `participantchampionship`
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    WHERE `participantchampionship_season_id`=$igosja_season_id
                    AND `participantchampionship_stage_id`=" . STAGE_QUATER;
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `achievementplayer` (`achievementplayer_country_id`, `achievementplayer_division_id`, `achievementplayer_is_playoff`, `achievementplayer_player_id`, `achievementplayer_season_id`, `achievementplayer_stage_id`, `achievementplayer_team_id`, `achievementplayer_tournamenttype_id`)
                    SELECT `participantchampionship_country_id`, `participantchampionship_division_id`, 1, `player_id`, $igosja_season_id, `participantchampionship_stage_id`, `team_id`, " . TOURNAMENTTYPE_CHAMPIONSHIP . "
                    FROM `participantchampionship`
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    LEFT JOIN `player`
                    ON `team_id`=`player_team_id`
                    WHERE `participantchampionship_season_id`=$igosja_season_id
                    AND `participantchampionship_stage_id`=" . STAGE_QUATER;
            f_igosja_mysqli_query($sql);
        }
        elseif (TOURNAMENTTYPE_CONFERENCE == $item['schedule_tournamenttype_id'] && STAGE_36_TOUR == $item['schedule_stage_id'])
        {
            $sql = "INSERT INTO `achievement` (`achievement_country_id`, `achievement_division_id`, `achievement_is_playoff`, `achievement_season_id`, `achievement_stage_id`, `achievement_team_id`, `achievement_tournamenttype_id`, `achievement_user_id`)
                    SELECT `participantchampionship_country_id`, `participantchampionship_division_id`, 1, $igosja_season_id, `participantchampionship_stage_id`, `team_id`, " . TOURNAMENTTYPE_CHAMPIONSHIP . ", `team_user_id`
                    FROM `participantchampionship`
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    WHERE `participantchampionship_season_id`=$igosja_season_id
                    AND `participantchampionship_stage_id`=" . STAGE_SEMI;
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `achievementplayer` (`achievementplayer_country_id`, `achievementplayer_division_id`, `achievementplayer_is_playoff`, `achievementplayer_player_id`, `achievementplayer_season_id`, `achievementplayer_stage_id`, `achievementplayer_team_id`, `achievementplayer_tournamenttype_id`)
                    SELECT `participantchampionship_country_id`, `participantchampionship_division_id`, 1, `player_id`, $igosja_season_id, `participantchampionship_stage_id`, `team_id`, " . TOURNAMENTTYPE_CHAMPIONSHIP . "
                    FROM `participantchampionship`
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    LEFT JOIN `player`
                    ON `team_id`=`player_team_id`
                    WHERE `participantchampionship_season_id`=$igosja_season_id
                    AND `participantchampionship_stage_id`=" . STAGE_SEMI;
            f_igosja_mysqli_query($sql);
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

            if ($next_stage_array['schedule_stage_id'] != $item['schedule_stage_id'])
            {
                $sql = "INSERT INTO `achievement` (`achievement_season_id`, `achievement_stage_id`, `achievement_team_id`, `achievement_tournamenttype_id`, `achievement_user_id`)
                        SELECT $igosja_season_id, `participantleague_stage_id`, `team_id`, " . TOURNAMENTTYPE_LEAGUE . ", `team_user_id`
                        FROM `participantleague`
                        LEFT JOIN `team`
                        ON `participantleague_team_id`=`team_id`
                        WHERE `participantleague_season_id`=$igosja_season_id
                        AND `participantleague_stage_id`=" . $item['schedule_stage_id'];
                f_igosja_mysqli_query($sql);

                $sql = "INSERT INTO `achievementplayer` (`achievementplayer_player_id`, `achievementplayer_season_id`, `achievementplayer_stage_id`, `achievementplayer_team_id`, `achievementplayer_tournamenttype_id`)
                        SELECT `player_id`, $igosja_season_id, `participantleague_stage_id`, `team_id`, " . TOURNAMENTTYPE_LEAGUE . "
                        FROM `participantleague`
                        LEFT JOIN `team`
                        ON `participantleague_team_id`=`team_id`
                        LEFT JOIN `player`
                        ON `team_id`=`player_team_id`
                        WHERE `participantleague_season_id`=$igosja_season_id
                        AND `participantleague_stage_id`=" . $item['schedule_stage_id'];
                f_igosja_mysqli_query($sql);
            }
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_6_TOUR == $item['schedule_stage_id'])
        {
            $sql = "INSERT INTO `achievement` (`achievement_season_id`, `achievement_position`, `achievement_team_id`, `achievement_tournamenttype_id`, `achievement_user_id`)
                    SELECT $igosja_season_id, `participantleague_stage_id`, `team_id`, " . TOURNAMENTTYPE_LEAGUE . ", `team_user_id`
                    FROM `participantleague`
                    LEFT JOIN `team`
                    ON `participantleague_team_id`=`team_id`
                    WHERE `participantleague_season_id`=$igosja_season_id
                    AND `participantleague_stage_id` IN (3, 4)";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `achievementplayer` (`achievementplayer_player_id`, `achievementplayer_season_id`, `achievementplayer_stage_id`, `achievementplayer_team_id`, `achievementplayer_tournamenttype_id`)
                    SELECT `player_id`, $igosja_season_id, `participantleague_stage_id`, `team_id`, " . TOURNAMENTTYPE_LEAGUE . "
                    FROM `participantleague`
                    LEFT JOIN `team`
                    ON `participantleague_team_id`=`team_id`
                    LEFT JOIN `player`
                    ON `team_id`=`player_team_id`
                    WHERE `participantleague_season_id`=$igosja_season_id
                    AND `participantleague_stage_id` IN (3, 4)";
            f_igosja_mysqli_query($sql);
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
                $sql = "INSERT INTO `achievement` (`achievement_season_id`, `achievement_stage_id`, `achievement_team_id`, `achievement_tournamenttype_id`, `achievement_user_id`)
                        SELECT $igosja_season_id, `participantleague_stage_id`, `team_id`, " . TOURNAMENTTYPE_LEAGUE . ", `team_user_id`
                        FROM `participantleague`
                        LEFT JOIN `team`
                        ON `participantleague_team_id`=`team_id`
                        WHERE `participantleague_season_id`=$igosja_season_id
                        AND `participantleague_stage_id` IN (" . STAGE_FINAL . ", 0)";
                f_igosja_mysqli_query($sql);

                $sql = "INSERT INTO `achievementplayer` (`achievementplayer_player_id`, `achievementplayer_season_id`, `achievementplayer_stage_id`, `achievementplayer_team_id`, `achievementplayer_tournamenttype_id`)
                        SELECT `player_id`, $igosja_season_id, `participantleague_stage_id`, `team_id`, " . TOURNAMENTTYPE_LEAGUE . "
                        FROM `participantleague`
                        LEFT JOIN `team`
                        ON `participantleague_team_id`=`team_id`
                        LEFT JOIN `player`
                        ON `team_id`=`player_team_id`
                        WHERE `participantleague_season_id`=$igosja_season_id
                        AND `participantleague_stage_id` IN (" . STAGE_FINAL . ", 0)";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}