<?php

/**
 * Перевіряємо ліміти на супери і відпочинки
 */
function f_igosja_generator_check_mood_limit()
{
    $sql = "SELECT `game_id`,
                   `game_guest_mood_id`,
                   `game_guest_team_id`,
                   `game_home_mood_id`,
                   `game_home_team_id`,
                   `schedule_tournamenttype_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND (`game_home_mood_id`!=" . MOOD_NORMAL . "
            OR `game_guest_mood_id`!=" . MOOD_NORMAL . ")
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $game)
    {
        $game_id            = $game['game_id'];
        $guest_mood_id      = $game['game_guest_mood_id'];
        $guest_team_id      = $game['game_guest_team_id'];
        $home_mood_id       = $game['game_home_mood_id'];
        $home_team_id       = $game['game_home_team_id'];
        $tournamenttype_id  = $game['schedule_tournamenttype_id'];

        if (MOOD_NORMAL != $home_mood_id)
        {
            if (TOURNAMENTTYPE_FRIENDLY == $tournamenttype_id)
            {
                $sql = "UPDATE `game`
                        SET `game_guest_mood_id`=" . MOOD_NORMAL . ",
                            `game_home_mood_id`=" . MOOD_NORMAL . "
                        WHERE `game_id`=$game_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $sql = "SELECT `team_mood_rest`,
                               `team_mood_super`
                        FROM `team`
                        WHERE `team_id`=$home_team_id
                        LIMIT 1";
                $team_sql = f_igosja_mysqli_query($sql);

                $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                if (MOOD_SUPER == $home_mood_id)
                {
                    if ($team_array[0]['team_mood_super'] <= 0)
                    {
                        $sql = "UPDATE `game`
                                SET `game_home_mood_id`=" . MOOD_NORMAL . "
                                WHERE `game_id`=$game_id
                                LIMIT 1";
                        f_igosja_mysqli_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE `team`
                                SET `team_mood_super`=`team_mood_super`-1
                                WHERE `team_id`=$home_team_id
                                LIMI 1"
                        f_igosja_mysqli_query($sql);
                    }
                }
                else
                {
                    if ($team_array[0]['team_mood_rest'] <= 0)
                    {
                        $sql = "UPDATE `game`
                                SET `game_home_mood_id`=" . MOOD_NORMAL . "
                                WHERE `game_id`=$game_id
                                LIMIT 1";
                        f_igosja_mysqli_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE `team`
                                SET `team_mood_rest`=`team_mood_rest`-1
                                WHERE `team_id`=$home_team_id
                                LIMI 1"
                        f_igosja_mysqli_query($sql);
                    }
                }

                $sql = "SELECT `team_mood_rest`,
                               `team_mood_super`
                        FROM `team`
                        WHERE `team_id`=$guest_team_id
                        LIMIT 1";
                $team_sql = f_igosja_mysqli_query($sql);

                $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                if (MOOD_SUPER == $guest_mood_id)
                {
                    if ($team_array[0]['team_mood_super'] <= 0)
                    {
                        $sql = "UPDATE `game`
                                SET `game_guest_mood_id`=" . MOOD_NORMAL . "
                                WHERE `game_id`=$game_id
                                LIMIT 1";
                        f_igosja_mysqli_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE `team`
                                SET `team_mood_super`=`team_mood_super`-1
                                WHERE `team_id`=$guest_team_id
                                LIMI 1"
                        f_igosja_mysqli_query($sql);
                    }
                }
                else
                {
                    if ($team_array[0]['team_mood_rest'] <= 0)
                    {
                        $sql = "UPDATE `game`
                                SET `game_guest_mood_id`=" . MOOD_NORMAL . "
                                WHERE `game_id`=$game_id
                                LIMIT 1";
                        f_igosja_mysqli_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE `team`
                                SET `team_mood_rest`=`team_mood_rest`-1
                                WHERE `team_id`=$guest_team_id
                                LIMI 1"
                        f_igosja_mysqli_query($sql);
                    }
                }
            }
        }
    }
}