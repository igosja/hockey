<?php

/* @var $igosja_season_id integer */

include(__DIR__ . '/include/include.php');

$sql = "UPDATE `championship`
        SET `championship_point`=`championship_win`*3+`championship_win_over`*2+`championship_win_bullet`*2+`championship_loose_over`+`championship_loose_bullet`,
            `championship_difference`=`championship_score`-`championship_pass`
        WHERE `championship_season_id`=" . $igosja_season_id;
f_igosja_mysqli_query($sql);

$sql = "SELECT `championship_country_id`
        FROM `championship`
        WHERE `championship_season_id`=$igosja_season_id
        GROUP BY `championship_country_id`
        ORDER BY `championship_country_id` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

foreach ($country_array as $country)
{
    $sql = "SELECT `championship_division_id`
            FROM `championship`
            WHERE `championship_season_id`=$igosja_season_id
            AND `championship_country_id`=" . $country['championship_country_id'] . "
            GROUP BY `championship_division_id`
            ORDER BY `championship_division_id` ASC";
    $division_sql = f_igosja_mysqli_query($sql);

    $division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($division_array as $division)
    {
        $sql = "SELECT `championship_id`
                FROM `championship`
                LEFT JOIN `team`
                ON `championship_team_id`=`team_id`
                WHERE `championship_season_id`=$igosja_season_id
                AND `championship_country_id`=" . $country['championship_country_id'] . "
                AND `championship_division_id`=" . $division['championship_division_id'] . "
                ORDER BY `championship_point` DESC, `championship_win` DESC, `championship_win_over` DESC, `championship_win_bullet` DESC, `championship_loose_bullet` DESC, `championship_loose_over` DESC, `championship_score`-`championship_pass` DESC, `championship_score` DESC, `team_power_vs` ASC, `team_id` ASC";
        $championship_sql = f_igosja_mysqli_query($sql);

        $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

        for ($i=0; $i<$championship_sql->num_rows; $i++)
        {
            $sql = "UPDATE `championship`
                    SET `championship_place`=" . ( $i + 1 ) . "
                    WHERE `championship_id`=" . $championship_array[$i]['championship_id'] . "
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }
}