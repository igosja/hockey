<?php

/**
 * Записуємо хоккеїстів в таблиці статистики
 */
function f_igosja_generator_lineup_to_statistic()
{
    $sql = "SELECT `championship_country_id`,
                   `championship_division_id`,
                   `lineup_national_id`,
                   `lineup_player_id`,
                   `lineup_position_id`,
                   `lineup_team_id`,
                   `shedule_season_id`,
                   `shedule_stage_id`,
                   `shedule_tournamenttype_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineup`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN `championship`
            ON (`lineup_team_id`=`championship_team_id`
            AND `shedule_season_id`=`championship_season_id`)
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(1);

    foreach ($game_array as $game)
    {
        $country_id         = $game['championship_country_id'];
        $division_id        = $game['championship_division_id'];
        $national_id        = $game['lineup_national_id'];
        $player_id          = $game['lineup_player_id'];
        $position_id        = $game['lineup_position_id'];
        $team_id            = $game['lineup_team_id'];
        $season_id          = $game['shedule_season_id'];
        $stage_id           = $game['shedule_stage_id'];
        $tournamenttype_id  = $game['shedule_tournamenttype_id'];

        if (!$country_id)
        {
            $country_id = 0;
        }

        if (!$division_id)
        {
            $division_id = 0;
        }

        if (POSITION_GK == $position_id)
        {
            $is_gk = 1;
        }
        else
        {
            $is_gk = 0;
        }

        if (TOURNAMENTTYPE_CHAMPIONSHIP == $tournamenttype_id && $stage_id >= STAGE_1_QUALIFY)
        {
            $is_playoff = 1;
        }
        else
        {
            $is_playoff = 0;
        }

        $sql = "SELECT COUNT(`statisticplayer_id`) AS `count`
                FROM `statisticplayer`
                WHERE `statisticplayer_championship_playoff`=$is_playoff
                AND `statisticplayer_country_id`=$country_id
                AND `statisticplayer_division_id`=$division_id
                AND `statisticplayer_is_gk`=$is_gk
                AND `statisticplayer_national_id`=$national_id
                AND `statisticplayer_player_id`=$player_id
                AND `statisticplayer_season_id`=$season_id
                AND `statisticplayer_team_id`=$team_id
                AND `statisticplayer_tournamenttype_id`=$tournamenttype_id";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(1);

        if (0 == $check_array[0]['count'])
        {
            $sql = "INSERT INTO `statisticplayer`
                    SET `statisticplayer_championship_playoff`=$is_playoff,
                        `statisticplayer_country_id`=$country_id,
                        `statisticplayer_division_id`=$division_id,
                        `statisticplayer_is_gk`=$is_gk,
                        `statisticplayer_national_id`=$national_id,
                        `statisticplayer_player_id`=$player_id,
                        `statisticplayer_season_id`=$season_id,
                        `statisticplayer_team_id`=$team_id,
                        `statisticplayer_tournamenttype_id`=$tournamenttype_id";
            f_igosja_mysqli_query($sql);
        }
    }
}