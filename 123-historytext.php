<?php

include(__DIR__ . '/include/include.php');

$sql = "UPDATE `history`
        SET `history_user_id`=0,
            `history_user_2_id`=0
        WHERE `history_historytext_id` IN
        (
            " . HISTORYTEXT_BUILDING_DOWN . ",
            " . HISTORYTEXT_BUILDING_UP . ",
            " . HISTORYTEXT_PLAYER_BONUS_POINT . ",
            " . HISTORYTEXT_PLAYER_BONUS_POSITION . ",
            " . HISTORYTEXT_PLAYER_RENT . ",
            " . HISTORYTEXT_PLAYER_RENT_BACK . ",
            " . HISTORYTEXT_PLAYER_TRANSFER . ",
            " . HISTORYTEXT_STADIUM_DOWN . ",
            " . HISTORYTEXT_STADIUM_UP . ",
            " . HISTORYTEXT_TEAM_RE_REGISTER . ",
            " . HISTORYTEXT_PLAYER_BONUS_SPECIAL . "
        )";
f_igosja_mysqli_query($sql);

$sql = "SELECT `history_id`,
               FROM_UNIXTIME(`history_date`, '%Y-%m-%d') AS `history_date`,
               `history_player_id`
        FROM `history`
        WHERE `history_historytext_id`=" . HISTORYTEXT_PLAYER_INJURY . "
        AND `history_game_id`=0
        ORDER BY `history_id` ASC";
$history_sql = f_igosja_mysqli_query($sql);

$history_array = $history_sql->fetch_all(MYSQLI_ASSOC);

foreach ($history_array as $item)
{
    $date = $item['history_date'];
    $player_id = $item['history_player_id'];


    $sql = "SELECT `lineup_game_id`
            FROM `lineup`
            LEFT JOIN `game`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE `lineup_player_id`=$player_id
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')='$date'
            LIMIT 1";
    $lineup_sql = f_igosja_mysqli_query($sql);

    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

    $game_id = $lineup_array[0]['lineup_game_id'];
    $history_id = $item['history_id'];

    $sql = "UPDATE `history`
            SET `history_game_id`=$game_id
            WHERE `history_id`=$history_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}