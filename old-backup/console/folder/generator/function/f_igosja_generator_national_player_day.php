<?php

/**
 * Кількість днів гравців у сбірній
 */
function f_igosja_generator_national_player_day()
{
    $sql = "SELECT `lineup_national_id`,
                   `player_id`,
                   `player_team_id`
            FROM `lineup`
            LEFT JOIN `game`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            LEFT JOIN `player`
            ON `lineup_player_id`=`player_id`
            WHERE `lineup_national_id`!=0
            AND `lineup_player_id`!=0
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `lineup_id` ASC";
    $lineup_sql = f_igosja_mysqli_query($sql);

    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($lineup_array as $item)
    {
        $national_id    = $item['lineup_national_id'];
        $player_id      = $item['player_id'];
        $team_id        = $item['player_team_id'];

        if (0 != $team_id)
        {
            $sql = "SELECT COUNT(*) AS `count`
                    FROM `nationalplayerday`
                    WHERE `nationalplayerday_national_id`=$national_id
                    AND `nationalplayerday_player_id`=$player_id
                    AND `nationalplayerday_team_id`=$team_id";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (0 == $check_array[0]['count'])
            {
                $sql = "INSERT INTO `nationalplayerday`
                        SET `nationalplayerday_day`=1,
                            `nationalplayerday_national_id`=$national_id,
                            `nationalplayerday_player_id`=$player_id,
                            `nationalplayerday_team_id`=$team_id";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $sql = "UPDATE `nationalplayerday`
                        SET `nationalplayerday_day`=`nationalplayerday_day`+1
                        WHERE `nationalplayerday_national_id`=$national_id
                        AND `nationalplayerday_player_id`=$player_id
                        AND`nationalplayerday_team_id`=$team_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}