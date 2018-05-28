<?php

include(__DIR__ . '/include/generator.php');

$sql = "DELETE FROM `game`
        WHERE `game_schedule_id` IN (219, 220, 221)";
f_igosja_mysqli_query($sql);

$sql = "DELETE FROM `lineup`
        WHERE `lineup_game_id` NOT IN (
            SELECT `game_id`
            FROM `game`
        )";
f_igosja_mysqli_query($sql);

$sql = "DELETE FROM `participantchampionship`
        WHERE `participantchampionship_season_id`=$igosja_season_id";
f_igosja_mysqli_query($sql);

$tournamenttype_id = TOURNAMENTTYPE_CONFERENCE;

$schedule_id    = 220;
$stage_id       = 32;

$game_array = f_igosja_swiss_game($tournamenttype_id, $stage_id);

$values = array();

foreach ($game_array as $item)
{
    $values[] = '(' . $item['guest'] . ', ' . $item['home'] . ', ' . $schedule_id . ')';
}

$values = implode(',', $values);

$sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`)
        VALUES $values;";
f_igosja_mysqli_query($sql);

$sql = "UPDATE `game`
        LEFT JOIN `team`
        ON `game_home_team_id`=`team_id`
        SET `game_stadium_id`=`team_stadium_id`
        WHERE `game_schedule_id`=$schedule_id";
f_igosja_mysqli_query($sql);

$sql = "SELECT `championship_country_id`
        FROM `championship`
        WHERE `championship_season_id`=$igosja_season_id
        GROUP BY `championship_country_id`
        ORDER BY `championship_country_id` ASC";
$championship_sql = f_igosja_mysqli_query($sql);

$championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

foreach ($championship_array as $country)
{
    $country_id = $country['championship_country_id'];

    $sql = "SELECT `championship_division_id`
            FROM `championship`
            WHERE `championship_country_id`=$country_id
            AND `championship_season_id`=$igosja_season_id
            GROUP BY `championship_division_id`
            ORDER BY `championship_division_id` ASC";
    $division_sql = f_igosja_mysqli_query($sql);

    $division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($division_array as $division)
    {
        $division_id = $division['championship_division_id'];

        $sql = "SELECT `championship_team_id`
                FROM `championship`
                WHERE `championship_country_id`=$country_id
                AND `championship_division_id`=$division_id
                AND `championship_season_id`=$igosja_season_id
                ORDER BY `championship_place` ASC
                LIMIT 8";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        $team_1 = $team_array[0]['championship_team_id'];
        $team_2 = $team_array[1]['championship_team_id'];
        $team_3 = $team_array[2]['championship_team_id'];
        $team_4 = $team_array[3]['championship_team_id'];
        $team_5 = $team_array[4]['championship_team_id'];
        $team_6 = $team_array[5]['championship_team_id'];
        $team_7 = $team_array[6]['championship_team_id'];
        $team_8 = $team_array[7]['championship_team_id'];

        $sql = "INSERT INTO `participantchampionship`
                (
                    `participantchampionship_country_id`,
                    `participantchampionship_division_id`,
                    `participantchampionship_season_id`,
                    `participantchampionship_stage_1`,
                    `participantchampionship_stage_2`,
                    `participantchampionship_stage_4`,
                    `participantchampionship_team_id`
                )
                VALUES ($country_id, $division_id, $igosja_season_id, 1, 1, 1, $team_1),
                       ($country_id, $division_id, $igosja_season_id, 1, 2, 3, $team_2),
                       ($country_id, $division_id, $igosja_season_id, 1, 2, 4, $team_3),
                       ($country_id, $division_id, $igosja_season_id, 1, 1, 2, $team_4),
                       ($country_id, $division_id, $igosja_season_id, 1, 1, 2, $team_5),
                       ($country_id, $division_id, $igosja_season_id, 1, 2, 4, $team_6),
                       ($country_id, $division_id, $igosja_season_id, 1, 2, 3, $team_7),
                       ($country_id, $division_id, $igosja_season_id, 1, 1, 1, $team_8);";
        f_igosja_mysqli_query($sql);
    }
}

$sql = "SELECT `schedule_id`
        FROM `schedule`
        WHERE `schedule_season_id`=$igosja_season_id
        AND `schedule_stage_id`=" . STAGE_QUATER . "
        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
        ORDER BY `schedule_id` ASC
        LIMIT 2";
$stage_sql = f_igosja_mysqli_query($sql);

$stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

$schedule_1 = $stage_array[0]['schedule_id'];
$schedule_2 = $stage_array[1]['schedule_id'];

$sql = "SELECT `participantchampionship_country_id`
        FROM `participantchampionship`
        WHERE `participantchampionship_season_id`=$igosja_season_id
        GROUP BY `participantchampionship_country_id`
        ORDER BY `participantchampionship_country_id` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

foreach ($country_array as $country)
{
    $country_id = $country['participantchampionship_country_id'];

    $sql = "SELECT `participantchampionship_division_id`
            FROM `participantchampionship`
            WHERE `participantchampionship_country_id`=$country_id
            AND `participantchampionship_season_id`=$igosja_season_id
            GROUP BY `participantchampionship_division_id`
            ORDER BY `participantchampionship_division_id` ASC";
    $division_sql = f_igosja_mysqli_query($sql);

    $division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($division_array as $division)
    {
        $division_id = $division['participantchampionship_division_id'];

        for ($i=1; $i<=4; $i++)
        {
            $sql = "SELECT `team_id`,
                           `team_stadium_id`
                    FROM `participantchampionship`
                    LEFT JOIN `championship`
                    ON
                    (
                        `participantchampionship_country_id`=`championship_country_id` AND
                        `participantchampionship_division_id`=`championship_division_id` AND
                        `participantchampionship_season_id`=`championship_season_id` AND
                        `participantchampionship_team_id`=`championship_team_id`
                    )
                    LEFT JOIN `team`
                    ON `participantchampionship_team_id`=`team_id`
                    WHERE `participantchampionship_country_id`=$country_id
                    AND `participantchampionship_division_id`=$division_id
                    AND `participantchampionship_season_id`=$igosja_season_id
                    AND `participantchampionship_stage_4`=$i
                    ORDER BY `championship_place` ASC
                    LIMIT 2";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

            $team_1     = $team_array[0]['team_id'];
            $stadium_1  = $team_array[0]['team_stadium_id'];
            $team_2     = $team_array[1]['team_id'];
            $stadium_2  = $team_array[1]['team_stadium_id'];

            $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                    VALUES ($team_2, $team_1, $schedule_1, $stadium_1),
                           ($team_1, $team_2, $schedule_2, $stadium_2);";
            f_igosja_mysqli_query($sql);
        }
    }
}