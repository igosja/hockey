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
        elseif (TOURNAMENTTYPE_CONFERENCE == $item['schedule_tournamenttype_id'] && STAGE_41_TOUR == $item['schedule_stage_id'])
        {
            $sql = "INSERT INTO `achievement` (`achievement_country_id`, `achievement_division_id`, `achievement_is_playoff`, `achievement_season_id`, `achievement_stage_id`, `achievement_team_id`, `achievement_tournamenttype_id`, `achievement_user_id`)
                    SELECT `participantchampionship_country_id`, `participantchampionship_division_id`, 1, $igosja_season_id, `participantchampionship_stage_id`, `team_id`, " . TOURNAMENTTYPE_CHAMPIONSHIP . ", `team_user_id`
                    FROM `participantchampionship`
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    WHERE `participantchampionship_season_id`=$igosja_season_id";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `achievementplayer` (`achievementplayer_country_id`, `achievementplayer_division_id`, `achievementplayer_is_playoff`, `achievementplayer_player_id`, `achievementplayer_season_id`, `achievementplayer_stage_id`, `achievementplayer_team_id`, `achievementplayer_tournamenttype_id`)
                    SELECT `participantchampionship_country_id`, `participantchampionship_division_id`, 1, `player_id`, $igosja_season_id, `participantchampionship_stage_id`, `team_id`, " . TOURNAMENTTYPE_CHAMPIONSHIP . "
                    FROM `participantchampionship`
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    LEFT JOIN `player`
                    ON `team_id`=`player_team_id`
                    WHERE `participantchampionship_season_id`=$igosja_season_id";
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
    }
}