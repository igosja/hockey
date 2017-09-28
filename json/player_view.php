<?php

/**
 * @var $auth_team_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/../include/include.php');

$result = '';

if ($line_id = (int) f_igosja_request_get('line_id'))
{
    $player_id = (int) f_igosja_request_get('player_id');

    $sql = "UPDATE `player`
            SET `player_line_id`=$line_id
            WHERE `player_id`=$player_id
            AND `player_team_id`=$auth_team_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $result = true;
}

print json_encode($result);
exit;