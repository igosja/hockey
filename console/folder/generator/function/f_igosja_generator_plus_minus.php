<?php

/**
 * Змінюємо силу хокеїстів за результатами матчу
 */
function f_igosja_generator_plus_minus()
{
    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            SET `game_guest_plus_minus_competition`=IF(`shedule_tournamenttype_id`=" . TOURNAMENTTYPE_NATIONAL . ", 2.5, IF(`shedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . ", 2, 0)),
                `game_guest_plus_minus_mood`=IF(`game_guest_mood_id`=" . MOOD_SUPER . ", -1, IF(`game_guest_mood_id`=" . MOOD_REST . ", 0.5, 0)),
                `game_guest_plus_minus_optimality_1`=IF(`game_guest_optimality_1`>=100, 0, IF(`game_guest_optimality_1`>=97, -0.5, IF(`game_guest_optimality_1`>=94, -1, IF(`game_guest_optimality_1`>=91, -1.5, IF(`game_guest_optimality_1`>=88, -2, IF(`game_guest_optimality_1`>=85, -2.5, IF(`game_guest_optimality_1`>=82, -3, IF(`game_guest_optimality_1`>=79, -3.5, IF(`game_guest_optimality_1`>=76, -4, IF(`game_guest_optimality_1`>=73, -4.5, -5)))))))))),
                `game_guest_plus_minus_optimality_2`=IF(`game_guest_optimality_2`>135, 2.5, IF(`game_guest_optimality_2`>125, 2, IF(`game_guest_optimality_2`>115, 1.5, IF(`game_guest_optimality_2`>110, 1, IF(`game_guest_optimality_2`>105, 0.5, IF(`game_guest_optimality_2`>80, 0, IF(`game_guest_optimality_2`>76, -0.5, IF(`game_guest_optimality_2`>73, -1, IF(`game_guest_optimality_2`>70, -1.5, IF(`game_guest_optimality_2`>67, -2, IF(`game_guest_optimality_2`>65, -2.5, IF(`game_guest_optimality_2`>63, -3, IF(`game_guest_optimality_2`>61, -3.5, IF(`game_guest_optimality_2`>59, -4, IF(`game_guest_optimality_2`>57, -4.5, IF(`game_guest_optimality_2`>55, -5, IF(`game_guest_optimality_2`>53, -5.5, IF(`game_guest_optimality_2`>51, -6, IF(`game_guest_optimality_2`>49, -6.5, IF(`game_guest_optimality_2`>47, -7, IF(`game_guest_optimality_2`>45, -7.5, IF(`game_guest_optimality_2`>43, -8, IF(`game_guest_optimality_2`>41, -8.5, IF(`game_guest_optimality_2`>39, -9, IF(`game_guest_optimality_2`>37, -9.5, IF(`game_guest_optimality_2`>35, -10, -10.5)))))))))))))))))))))))))),
                `game_guest_plus_minus_power`=IF(`game_guest_power_percent`>=75, IF(`game_guest_score`>`game_home_score`, -4, IF(`game_guest_score`=`game_home_score`, -4.5, -5)), IF(`game_guest_power_percent`>=71, IF(`game_guest_score`>`game_home_score`, -3.5, IF(`game_guest_score`=`game_home_score`, -4, -4.5)), IF(`game_guest_power_percent`>=68, IF(`game_guest_score`>`game_home_score`, -3, IF(`game_guest_score`=`game_home_score`, -3.5, -4)), IF(`game_guest_power_percent`>=65, IF(`game_guest_score`>`game_home_score`, -2.5, IF(`game_guest_score`=`game_home_score`, -3, -3.5)), IF(`game_guest_power_percent`>=62, IF(`game_guest_score`>`game_home_score`, -2, IF(`game_guest_score`=`game_home_score`, -2.5, -3)), IF(`game_guest_power_percent`>=59, IF(`game_guest_score`>`game_home_score`, -1.5, IF(`game_guest_score`=`game_home_score`, -2, -2.5)), IF(`game_guest_power_percent`>=57, IF(`game_guest_score`>`game_home_score`, -1, IF(`game_guest_score`=`game_home_score`, -1.5, -2)), IF(`game_guest_power_percent`>=55, IF(`game_guest_score`>`game_home_score`, -0.5, IF(`game_guest_score`=`game_home_score`, -1, -1.5)), IF(`game_guest_power_percent`>=53, IF(`game_guest_score`>`game_home_score`, 0, IF(`game_guest_score`=`game_home_score`, -0.5, -1)), IF(`game_guest_power_percent`>=51, IF(`game_guest_score`>`game_home_score`, 0.5, IF(`game_guest_score`=`game_home_score`, 0, -0.5)), IF(`game_guest_power_percent`>=49, IF(`game_guest_score`>`game_home_score`, 1, IF(`game_guest_score`=`game_home_score`, 0.5, 0)), IF(`game_guest_power_percent`>=47, IF(`game_guest_score`>`game_home_score`, 1.5, IF(`game_guest_score`=`game_home_score`, 1, 0.5)), IF(`game_guest_power_percent`>=45, IF(`game_guest_score`>`game_home_score`, 2, IF(`game_guest_score`=`game_home_score`, 1.5, 1)), IF(`game_guest_power_percent`>=43, IF(`game_guest_score`>`game_home_score`, 2.5, IF(`game_guest_score`=`game_home_score`, 2, 1.5)), IF(`game_guest_power_percent`>=41, IF(`game_guest_score`>`game_home_score`, 3, IF(`game_guest_score`=`game_home_score`, 2.5, 2)), IF(`game_guest_power_percent`>=38, IF(`game_guest_score`>`game_home_score`, 3.5, IF(`game_guest_score`=`game_home_score`, 3, 2.5)), IF(`game_guest_power_percent`>=35, IF(`game_guest_score`>`game_home_score`, 4, IF(`game_guest_score`=`game_home_score`, 3.5, 3)), IF(`game_guest_power_percent`>=32, IF(`game_guest_score`>`game_home_score`, 4.5, IF(`game_guest_score`=`game_home_score`, 4, 3.5)), IF(`game_guest_power_percent`>=29, IF(`game_guest_score`>`game_home_score`, 5, IF(`game_guest_score`=`game_home_score`, 4.5, 4)), IF(`game_guest_power_percent`>=25, IF(`game_guest_score`>`game_home_score`, 5.5, IF(`game_guest_score`=`game_home_score`, 5, 4.5)), IF(`game_guest_score`>`game_home_score`, 6, IF(`game_guest_score`=`game_home_score`, 5.5, 5)))))))))))))))))))))),
                `game_guest_plus_minus_score`=IF(`game_guest_score`-`game_home_score`>=9, 7.5, IF(`game_guest_score`-`game_home_score`=8, 6.5, IF(`game_guest_score`-`game_home_score`=7, 5.5, IF(`game_guest_score`-`game_home_score`=6, 4.5, IF(`game_guest_score`-`game_home_score`=5, 3.5, IF(`game_guest_score`-`game_home_score`=4, 2.5, IF(`game_guest_score`-`game_home_score`=3, 1.5, IF(`game_guest_score`-`game_home_score`=2, 0.5, IF(`game_guest_score`-`game_home_score`=-2, -0.5, IF(`game_guest_score`-`game_home_score`=-3, -1.5, IF(`game_guest_score`-`game_home_score`=-4, -2.5, IF(`game_guest_score`-`game_home_score`=-5, -3.5, IF(`game_guest_score`-`game_home_score`=-6, -4.5, IF(`game_guest_score`-`game_home_score`=-7, -5.5, IF(`game_guest_score`-`game_home_score`=-8, -6.5, IF(`game_guest_score`-`game_home_score`<=-9, -7.5, 0)))))))))))))))),
                `game_home_plus_minus_competition`=IF(`shedule_tournamenttype_id`=" . TOURNAMENTTYPE_NATIONAL . ", 2.5, IF(`shedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . ", 2, 0)),
                `game_home_plus_minus_mood`=IF(`game_home_mood_id`=" . MOOD_SUPER . ", -1, IF(`game_home_mood_id`=" . MOOD_REST . ", 0.5, 0)),
                `game_home_plus_minus_optimality_1`=IF(`game_home_optimality_1`>=100, 0, IF(`game_home_optimality_1`>=97, -0.5, IF(`game_home_optimality_1`>=94, -1, IF(`game_home_optimality_1`>=91, -1.5, IF(`game_home_optimality_1`>=88, -2, IF(`game_home_optimality_1`>=85, -2.5, IF(`game_home_optimality_1`>=82, -3, IF(`game_home_optimality_1`>=79, -3.5, IF(`game_home_optimality_1`>=76, -4, IF(`game_home_optimality_1`>=73, -4.5, -5)))))))))),
                `game_home_plus_minus_optimality_2`=IF(`game_home_optimality_2`>135, 2.5, IF(`game_home_optimality_2`>125, 2, IF(`game_home_optimality_2`>115, 1.5, IF(`game_home_optimality_2`>110, 1, IF(`game_home_optimality_2`>105, 0.5, IF(`game_home_optimality_2`>80, 0, IF(`game_home_optimality_2`>76, -0.5, IF(`game_home_optimality_2`>73, -1, IF(`game_home_optimality_2`>70, -1.5, IF(`game_home_optimality_2`>67, -2, IF(`game_home_optimality_2`>65, -2.5, IF(`game_home_optimality_2`>63, -3, IF(`game_home_optimality_2`>61, -3.5, IF(`game_home_optimality_2`>59, -4, IF(`game_home_optimality_2`>57, -4.5, IF(`game_home_optimality_2`>55, -5, IF(`game_home_optimality_2`>53, -5.5, IF(`game_home_optimality_2`>51, -6, IF(`game_home_optimality_2`>49, -6.5, IF(`game_home_optimality_2`>47, -7, IF(`game_home_optimality_2`>45, -7.5, IF(`game_home_optimality_2`>43, -8, IF(`game_home_optimality_2`>41, -8.5, IF(`game_home_optimality_2`>39, -9, IF(`game_home_optimality_2`>37, -9.5, IF(`game_home_optimality_2`>35, -10, -10.5)))))))))))))))))))))))))),
                `game_home_plus_minus_power`=IF(`game_home_power_percent`>=75, IF(`game_home_score`>`game_guest_score`, -4, IF(`game_home_score`=`game_guest_score`, -4.5, -5)), IF(`game_home_power_percent`>=71, IF(`game_home_score`>`game_guest_score`, -3.5, IF(`game_home_score`=`game_guest_score`, -4, -4.5)), IF(`game_home_power_percent`>=68, IF(`game_home_score`>`game_guest_score`, -3, IF(`game_home_score`=`game_guest_score`, -3.5, -4)), IF(`game_home_power_percent`>=65, IF(`game_home_score`>`game_guest_score`, -2.5, IF(`game_home_score`=`game_guest_score`, -3, -3.5)), IF(`game_home_power_percent`>=62, IF(`game_home_score`>`game_guest_score`, -2, IF(`game_home_score`=`game_guest_score`, -2.5, -3)), IF(`game_home_power_percent`>=59, IF(`game_home_score`>`game_guest_score`, -1.5, IF(`game_home_score`=`game_guest_score`, -2, -2.5)), IF(`game_home_power_percent`>=57, IF(`game_home_score`>`game_guest_score`, -1, IF(`game_home_score`=`game_guest_score`, -1.5, -2)), IF(`game_home_power_percent`>=55, IF(`game_home_score`>`game_guest_score`, -0.5, IF(`game_home_score`=`game_guest_score`, -1, -1.5)), IF(`game_home_power_percent`>=53, IF(`game_home_score`>`game_guest_score`, 0, IF(`game_home_score`=`game_guest_score`, -0.5, -1)), IF(`game_home_power_percent`>=51, IF(`game_home_score`>`game_guest_score`, 0.5, IF(`game_home_score`=`game_guest_score`, 0, -0.5)), IF(`game_home_power_percent`>=49, IF(`game_home_score`>`game_guest_score`, 1, IF(`game_home_score`=`game_guest_score`, 0.5, 0)), IF(`game_home_power_percent`>=47, IF(`game_home_score`>`game_guest_score`, 1.5, IF(`game_home_score`=`game_guest_score`, 1, 0.5)), IF(`game_home_power_percent`>=45, IF(`game_home_score`>`game_guest_score`, 2, IF(`game_home_score`=`game_guest_score`, 1.5, 1)), IF(`game_home_power_percent`>=43, IF(`game_home_score`>`game_guest_score`, 2.5, IF(`game_home_score`=`game_guest_score`, 2, 1.5)), IF(`game_home_power_percent`>=41, IF(`game_home_score`>`game_guest_score`, 3, IF(`game_home_score`=`game_guest_score`, 2.5, 2)), IF(`game_home_power_percent`>=38, IF(`game_home_score`>`game_guest_score`, 3.5, IF(`game_home_score`=`game_guest_score`, 3, 2.5)), IF(`game_home_power_percent`>=35, IF(`game_home_score`>`game_guest_score`, 4, IF(`game_home_score`=`game_guest_score`, 3.5, 3)), IF(`game_home_power_percent`>=32, IF(`game_home_score`>`game_guest_score`, 4.5, IF(`game_home_score`=`game_guest_score`, 4, 3.5)), IF(`game_home_power_percent`>=29, IF(`game_home_score`>`game_guest_score`, 5, IF(`game_home_score`=`game_guest_score`, 4.5, 4)), IF(`game_home_power_percent`>=25, IF(`game_home_score`>`game_guest_score`, 5.5, IF(`game_home_score`=`game_guest_score`, 5, 4.5)), IF(`game_home_score`>`game_guest_score`, 6, IF(`game_home_score`=`game_guest_score`, 5.5, 5)))))))))))))))))))))),
                `game_home_plus_minus_score`=IF(`game_home_score`-`game_guest_score`>=9, 7.5, IF(`game_home_score`-`game_guest_score`=8, 6.5, IF(`game_home_score`-`game_guest_score`=7, 5.5, IF(`game_home_score`-`game_guest_score`=6, 4.5, IF(`game_home_score`-`game_guest_score`=5, 3.5, IF(`game_home_score`-`game_guest_score`=4, 2.5, IF(`game_home_score`-`game_guest_score`=3, 1.5, IF(`game_home_score`-`game_guest_score`=2, 0.5, IF(`game_home_score`-`game_guest_score`=-2, -0.5, IF(`game_home_score`-`game_guest_score`=-3, -1.5, IF(`game_home_score`-`game_guest_score`=-4, -2.5, IF(`game_home_score`-`game_guest_score`=-5, -3.5, IF(`game_home_score`-`game_guest_score`=-6, -4.5, IF(`game_home_score`-`game_guest_score`=-7, -5.5, IF(`game_home_score`-`game_guest_score`=-8, -6.5, IF(`game_home_score`-`game_guest_score`<=-9, -7.5, 0))))))))))))))))
            WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            SET `game_guest_plus_minus`=IF(`game_guest_plus_minus_competition`+`game_guest_plus_minus_mood`+`game_guest_plus_minus_optimality_1`+`game_guest_plus_minus_optimality_2`+`game_guest_plus_minus_power`+`game_guest_plus_minus_score`>5, 5, IF(`game_guest_plus_minus_competition`+`game_guest_plus_minus_mood`+`game_guest_plus_minus_optimality_1`+`game_guest_plus_minus_optimality_2`+`game_guest_plus_minus_power`+`game_guest_plus_minus_score`<-5, -5, `game_guest_plus_minus_competition`+`game_guest_plus_minus_mood`+`game_guest_plus_minus_optimality_1`+`game_guest_plus_minus_optimality_2`+`game_guest_plus_minus_power`+`game_guest_plus_minus_score`)),
                `game_home_plus_minus`=IF(`game_home_plus_minus_competition`+`game_home_plus_minus_mood`+`game_home_plus_minus_optimality_1`+`game_home_plus_minus_optimality_2`+`game_home_plus_minus_power`+`game_home_plus_minus_score`>5, 5, IF(`game_home_plus_minus_competition`+`game_home_plus_minus_mood`+`game_home_plus_minus_optimality_1`+`game_home_plus_minus_optimality_2`+`game_home_plus_minus_power`+`game_home_plus_minus_score`<-5, -5, `game_home_plus_minus_competition`+`game_home_plus_minus_mood`+`game_home_plus_minus_optimality_1`+`game_home_plus_minus_optimality_2`+`game_home_plus_minus_power`+`game_home_plus_minus_score`))
            WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            SET `game_guest_plus_minus`=FLOOR(`game_guest_plus_minus`)+ROUND(RAND())
            WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            AND CEIL(`game_guest_plus_minus`)!=`game_guest_plus_minus`";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            SET `game_home_plus_minus`=FLOOR(`game_home_plus_minus`)+ROUND(RAND())
            WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            AND CEIL(`game_home_plus_minus`)!=`game_home_plus_minus`";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `game_id`,
                   `game_guest_plus_minus`,
                   `game_guest_team_id`,
                   `game_home_plus_minus`,
                   `game_home_team_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(1);

    foreach ($game_array as $item)
    {
        $player_id = array();

        if (0 > $item['game_home_plus_minus'])
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`=" . $item['game_home_team_id'] . "
                    AND `lineup_game_id`=" . $item['game_id'] . "
                    ORDER BY RAND()
                    LIMIT " . -$item['game_home_plus_minus'];
            $player_sql = f_igosja_mysqli_query($sql);

            $player_array = $player_sql->fetch_all(1);

            foreach ($player_array as $player)
            {
                $player_id[] = $player['lineup_player_id'];
            }

            $player_id = implode(', ', $player_id);

            $sql = "UPDATE `player`
                    SET `player_power_nominal`=`player_power_nominal`-1
                    WHERE `player_id` IN (" . $player_id . ")";
            f_igosja_mysqli_query($sql);
        }
        elseif (0 < $item['game_home_plus_minus'])
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`=" . $item['game_home_team_id'] . "
                    AND `lineup_game_id`=" . $item['game_id'] . "
                    ORDER BY RAND()
                    LIMIT " . $item['game_home_plus_minus'];
            $player_sql = f_igosja_mysqli_query($sql);

            $player_array = $player_sql->fetch_all(1);

            foreach ($player_array as $player)
            {
                $player_id[] = $player['lineup_player_id'];
            }

            $player_id = implode(', ', $player_id);

            $sql = "UPDATE `player`
                    SET `player_power_nominal`=`player_power_nominal`+1
                    WHERE `player_id` IN (" . $player_id . ")";
            f_igosja_mysqli_query($sql);
        }

        $player_id = array();

        if (0 > $item['game_guest_plus_minus'])
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`=" . $item['game_guest_team_id'] . "
                    AND `lineup_game_id`=" . $item['game_id'] . "
                    ORDER BY RAND()
                    LIMIT " . -$item['game_guest_plus_minus'];
            $player_sql = f_igosja_mysqli_query($sql);

            $player_array = $player_sql->fetch_all(1);

            foreach ($player_array as $player)
            {
                $player_id[] = $player['lineup_player_id'];
            }

            $player_id = implode(', ', $player_id);

            $sql = "UPDATE `player`
                    SET `player_power_nominal`=`player_power_nominal`-1
                    WHERE `player_id` IN (" . $player_id . ")";
            f_igosja_mysqli_query($sql);
        }
        elseif (0 < $item['game_guest_plus_minus'])
        {
            $sql = "SELECT `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`=" . $item['game_guest_team_id'] . "
                    AND `lineup_game_id`=" . $item['game_id'] . "
                    ORDER BY RAND()
                    LIMIT " . $item['game_guest_plus_minus'];
            $player_sql = f_igosja_mysqli_query($sql);

            $player_array = $player_sql->fetch_all(1);

            foreach ($player_array as $player)
            {
                $player_id[] = $player['lineup_player_id'];
            }

            $player_id = implode(', ', $player_id);

            $sql = "UPDATE `player`
                    SET `player_power_nominal`=`player_power_nominal`+1
                    WHERE `player_id` IN (" . $player_id . ")";
            f_igosja_mysqli_query($sql);
        }
    }

    print '.';
    flush();
}