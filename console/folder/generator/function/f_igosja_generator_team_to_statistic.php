<?php

function f_igosja_generator_team_to_statistic()
//Записываем команды в таблицы статистики
{
    $sql = "SELECT `championship_country_id`,
                   `championship_division_id`,
                   `game_guest_national_id`,
                   `game_guest_team_id`,
                   `game_home_national_id`,
                   `game_home_team_id`,
                   `shedule_season_id`,
                   `shedule_stage_id`,
                   `shedule_tournamenttype_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `championship`
            ON (`game_home_team_id`=`championship_team_id`
            AND `shedule_season_id`=`championship_season_id`)
            WHERE `game_played`='0'
            AND FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(1);

    foreach ($game_array as $game)
    {
        $country_id         = $game['championship_country_id'];
        $division_id        = $game['championship_division_id'];
        $guest_national_id  = $game['game_guest_national_id'];
        $guest_team_id      = $game['game_guest_team_id'];
        $home_national_id   = $game['game_home_national_id'];
        $home_team_id       = $game['game_home_team_id'];
        $season_id          = $game['shedule_season_id'];
        $stage_id           = $game['shedule_stage_id'];
        $tournamenttype_id  = $game['shedule_tournamenttype_id'];

        if (!$country_id)
        {
            $country_id = 0;
        }

        if ($division_id)
        {
            $division_id = 0;
        }

        if (TOURNAMENTTYPE_CHAMPIONSHIP == $tournamenttype_id && STAGE_1_QUALIFY <= $stage_id)
        {
            $is_playoff = 1;
        }
        else
        {
            $is_playoff = 0;
        }

        $sql = "SELECT COUNT(`statisticteam_id`) AS `count`
                FROM `statisticteam`
                WHERE `statisticteam_championship_playoff`='$is_playoff'
                AND `statisticteam_country_id`='$country_id'
                AND `statisticteam_division_id`='$division_id'
                AND `statisticteam_national_id`='$guest_national_id'
                AND `statisticteam_season_id`='$season_id'
                AND `statisticteam_team_id`='$guest_team_id'
                AND `statisticteam_tournamenttype_id`='$tournamenttype_id'";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(1);

        if (0 == $check_array[0]['count'])
        {
            $sql = "INSERT INTO `statisticteam`
                    SET `statisticteam_championship_playoff`='$is_playoff',
                        `statisticteam_country_id`='$country_id',
                        `statisticteam_division_id`='$division_id',
                        `statisticteam_national_id`='$guest_national_id',
                        `statisticteam_season_id`='$season_id',
                        `statisticteam_team_id`='$guest_team_id',
                        `statisticteam_tournamenttype_id`='$tournamenttype_id'";
            f_igosja_mysqli_query($sql);
        }

        $sql = "SELECT COUNT(`statisticteam_id`) AS `count`
                FROM `statisticteam`
                WHERE `statisticteam_championship_playoff`='$is_playoff'
                AND `statisticteam_country_id`='$country_id'
                AND `statisticteam_division_id`='$division_id'
                AND `statisticteam_national_id`='$home_national_id'
                AND `statisticteam_season_id`='$season_id'
                AND `statisticteam_team_id`='$home_team_id'
                AND `statisticteam_tournamenttype_id`='$tournamenttype_id'";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(1);

        if (0 == $check_array[0]['count'])
        {
            $sql = "INSERT INTO `statisticteam`
                    SET `statisticteam_championship_playoff`='$is_playoff',
                        `statisticteam_country_id`='$country_id',
                        `statisticteam_division_id`='$division_id',
                        `statisticteam_national_id`='$home_national_id',
                        `statisticteam_season_id`='$season_id',
                        `statisticteam_team_id`='$home_team_id',
                        `statisticteam_tournamenttype_id`='$tournamenttype_id'";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}