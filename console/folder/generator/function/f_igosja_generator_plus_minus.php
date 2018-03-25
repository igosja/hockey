<?php

/**
 * Змінюємо силу хокеїстів за результатами матчу
 */
function f_igosja_generator_plus_minus()
{
    $sql = "SELECT `game_guest_mood_id`,
                   `game_guest_optimality_1`,
                   `game_guest_optimality_2`,
                   `game_guest_power_percent`,
                   `game_guest_score`,
                   `game_home_mood_id`,
                   `game_home_optimality_1`,
                   `game_home_optimality_2`,
                   `game_home_power_percent`,
                   `game_home_score`,
                   `game_id`,
                   `schedule_tournamenttype_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND `game_played`=0
            AND `schedule_tournamenttype_id`!=" . TOURNAMENTTYPE_FRIENDLY . "
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $item)
    {
        $game_id            = $item['game_id'];
        $guest_mood         = 0;
        $guest_score        = 0;
        $home_mood          = 0;
        $home_score         = 0;

        if ($item['game_guest_power_percent'] > 74)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = -3.5;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = -4;
            }
            else
            {
                $guest_power = -4.5;
            }
        }
        elseif ($item['game_guest_power_percent'] > 70)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = -3;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = -3.5;
            }
            else
            {
                $guest_power = -4;
            }
        }
        elseif ($item['game_guest_power_percent'] > 67)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = -2.5;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = -3;
            }
            else
            {
                $guest_power = -3.5;
            }
        }
        elseif ($item['game_guest_power_percent'] > 64)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = -2;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = -2.5;
            }
            else
            {
                $guest_power = -3;
            }
        }
        elseif ($item['game_guest_power_percent'] > 61)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = -1.5;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = -2;
            }
            else
            {
                $guest_power = -2.5;
            }
        }
        elseif ($item['game_guest_power_percent'] > 58)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = -1;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = -1.5;
            }
            else
            {
                $guest_power = -2;
            }
        }
        elseif ($item['game_guest_power_percent'] > 56)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = -0.5;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = -1;
            }
            else
            {
                $guest_power = -1.5;
            }
        }
        elseif ($item['game_guest_power_percent'] > 54)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 0;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = -0.5;
            }
            else
            {
                $guest_power = -1;
            }
        }
        elseif ($item['game_guest_power_percent'] > 52)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 0.5;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 0;
            }
            else
            {
                $guest_power = -0.5;
            }
        }
        elseif ($item['game_guest_power_percent'] > 50)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 1;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 0.5;
            }
            else
            {
                $guest_power = 0;
            }
        }
        elseif ($item['game_guest_power_percent'] > 48)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 1.5;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 1;
            }
            else
            {
                $guest_power = 0.5;
            }
        }
        elseif ($item['game_guest_power_percent'] > 46)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 2;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 1.5;
            }
            else
            {
                $guest_power = 1;
            }
        }
        elseif ($item['game_guest_power_percent'] > 44)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 2.5;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 2;
            }
            else
            {
                $guest_power = 1.5;
            }
        }
        elseif ($item['game_guest_power_percent'] > 42)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 3;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 2.5;
            }
            else
            {
                $guest_power = 2;
            }
        }
        elseif ($item['game_guest_power_percent'] > 40)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 3.5;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 3;
            }
            else
            {
                $guest_power = 2.5;
            }
        }
        elseif ($item['game_guest_power_percent'] > 37)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 4;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 3.5;
            }
            else
            {
                $guest_power = 3;
            }
        }
        elseif ($item['game_guest_power_percent'] > 34)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 4.5;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 4;
            }
            else
            {
                $guest_power = 3.5;
            }
        }
        elseif ($item['game_guest_power_percent'] > 31)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 5;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 4.5;
            }
            else
            {
                $guest_power = 4;
            }
        }
        elseif ($item['game_guest_power_percent'] > 28)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 5.5;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 5;
            }
            else
            {
                $guest_power = 4.5;
            }
        }
        elseif ($item['game_guest_power_percent'] > 24)
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 6;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 5.5;
            }
            else
            {
                $guest_power = 5;
            }
        }
        else
        {
            if ($item['game_guest_score'] > $item['game_home_score'])
            {
                $guest_power = 6.5;
            }
            elseif ($item['game_guest_score'] == $item['game_home_score'])
            {
                $guest_power = 6;
            }
            else
            {
                $guest_power = 5.5;
            }
        }

        if ($item['game_home_power_percent'] > 74)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = -3.5;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = -4;
            }
            else
            {
                $home_power = -4.5;
            }
        }
        elseif ($item['game_home_power_percent'] > 70)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = -3;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = -3.5;
            }
            else
            {
                $home_power = -4;
            }
        }
        elseif ($item['game_home_power_percent'] > 67)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = -2.5;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = -3;
            }
            else
            {
                $home_power = -3.5;
            }
        }
        elseif ($item['game_home_power_percent'] > 64)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = -2;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = -2.5;
            }
            else
            {
                $home_power = -3;
            }
        }
        elseif ($item['game_home_power_percent'] > 61)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = -1.5;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = -2;
            }
            else
            {
                $home_power = -2.5;
            }
        }
        elseif ($item['game_home_power_percent'] > 58)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = -1;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = -1.5;
            }
            else
            {
                $home_power = -2;
            }
        }
        elseif ($item['game_home_power_percent'] > 56)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = -0.5;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = -1;
            }
            else
            {
                $home_power = -1.5;
            }
        }
        elseif ($item['game_home_power_percent'] > 54)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 0;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = -0.5;
            }
            else
            {
                $home_power = -1;
            }
        }
        elseif ($item['game_home_power_percent'] > 52)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 0.5;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 0;
            }
            else
            {
                $home_power = -0.5;
            }
        }
        elseif ($item['game_home_power_percent'] > 50)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 1;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 0.5;
            }
            else
            {
                $home_power = 0;
            }
        }
        elseif ($item['game_home_power_percent'] > 48)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 1.5;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 1;
            }
            else
            {
                $home_power = 0.5;
            }
        }
        elseif ($item['game_home_power_percent'] > 46)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 2;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 1.5;
            }
            else
            {
                $home_power = 1;
            }
        }
        elseif ($item['game_home_power_percent'] > 44)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 2.5;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 2;
            }
            else
            {
                $home_power = 1.5;
            }
        }
        elseif ($item['game_home_power_percent'] > 42)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 3;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 2.5;
            }
            else
            {
                $home_power = 2;
            }
        }
        elseif ($item['game_home_power_percent'] > 40)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 3.5;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 3;
            }
            else
            {
                $home_power = 2.5;
            }
        }
        elseif ($item['game_home_power_percent'] > 37)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 4;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 3.5;
            }
            else
            {
                $home_power = 3;
            }
        }
        elseif ($item['game_home_power_percent'] > 34)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 4.5;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 4;
            }
            else
            {
                $home_power = 3.5;
            }
        }
        elseif ($item['game_home_power_percent'] > 31)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 5;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 4.5;
            }
            else
            {
                $home_power = 4;
            }
        }
        elseif ($item['game_home_power_percent'] > 28)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 5.5;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 5;
            }
            else
            {
                $home_power = 4.5;
            }
        }
        elseif ($item['game_home_power_percent'] > 24)
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 6;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 5.5;
            }
            else
            {
                $home_power = 5;
            }
        }
        else
        {
            if ($item['game_home_score'] > $item['game_guest_score'])
            {
                $home_power = 6.5;
            }
            elseif ($item['game_home_score'] == $item['game_guest_score'])
            {
                $home_power = 6;
            }
            else
            {
                $home_power = 5.5;
            }
        }

        if (TOURNAMENTTYPE_NATIONAL == $item['schedule_tournamenttype_id'])
        {
            $guest_competition  = 2.5;
            $home_competition   = 2.5;
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'])
        {
            $guest_competition  = 2;
            $home_competition   = 2;
        }
        else
        {
            $guest_competition  = 0;
            $home_competition   = 0;
        }

        if (MOOD_SUPER == $item['game_guest_mood_id'])
        {
            $guest_mood = $guest_mood - 1;
            $home_mood  = $home_mood + 0.5;
        }
        elseif (MOOD_REST == $item['game_guest_mood_id'])
        {
            $guest_mood = $guest_mood + 0.5;
            $home_mood  = $home_mood - 1;
        }

        if (MOOD_SUPER == $item['game_home_mood_id'])
        {
            $home_mood  = $home_mood - 1;
            $guest_mood = $guest_mood + 0.5;
        }
        elseif (MOOD_REST == $item['game_home_mood_id'])
        {
            $home_mood  = $home_mood + 0.5;
            $guest_mood = $guest_mood - 1;
        }

        if ($item['game_guest_optimality_1'] > 99)
        {
            $guest_optimality_1 = 0.5;
        }
        elseif ($item['game_guest_optimality_1'] > 96)
        {
            $guest_optimality_1 = 0;
        }
        elseif ($item['game_guest_optimality_1'] > 93)
        {
            $guest_optimality_1 = -0.5;
        }
        elseif ($item['game_guest_optimality_1'] > 90)
        {
            $guest_optimality_1 = -1;
        }
        elseif ($item['game_guest_optimality_1'] > 87)
        {
            $guest_optimality_1 = -1.5;
        }
        elseif ($item['game_guest_optimality_1'] > 84)
        {
            $guest_optimality_1 = -2;
        }
        elseif ($item['game_guest_optimality_1'] > 81)
        {
            $guest_optimality_1 = -2.5;
        }
        elseif ($item['game_guest_optimality_1'] > 78)
        {
            $guest_optimality_1 = -3;
        }
        elseif ($item['game_guest_optimality_1'] > 75)
        {
            $guest_optimality_1 = -3.5;
        }
        elseif ($item['game_guest_optimality_1'] > 72)
        {
            $guest_optimality_1 = -4;
        }
        else
        {
            $guest_optimality_1 = -4.5;
        }

        if ($item['game_home_optimality_1'] > 99)
        {
            $home_optimality_1 = 0.5;
        }
        elseif ($item['game_home_optimality_1'] > 96)
        {
            $home_optimality_1 = 0;
        }
        elseif ($item['game_home_optimality_1'] > 93)
        {
            $home_optimality_1 = -0.5;
        }
        elseif ($item['game_home_optimality_1'] > 90)
        {
            $home_optimality_1 = -1;
        }
        elseif ($item['game_home_optimality_1'] > 87)
        {
            $home_optimality_1 = -1.5;
        }
        elseif ($item['game_home_optimality_1'] > 84)
        {
            $home_optimality_1 = -2;
        }
        elseif ($item['game_home_optimality_1'] > 81)
        {
            $home_optimality_1 = -2.5;
        }
        elseif ($item['game_home_optimality_1'] > 78)
        {
            $home_optimality_1 = -3;
        }
        elseif ($item['game_home_optimality_1'] > 75)
        {
            $home_optimality_1 = -3.5;
        }
        elseif ($item['game_home_optimality_1'] > 72)
        {
            $home_optimality_1 = -4;
        }
        else
        {
            $home_optimality_1 = -4.5;
        }

        if ($item['game_guest_optimality_2'] > 134)
        {
            $guest_optimality_2 = 2.5;
        }
        elseif ($item['game_guest_optimality_2'] > 124)
        {
            $guest_optimality_2 = 2;
        }
        elseif ($item['game_guest_optimality_2'] > 114)
        {
            $guest_optimality_2 = 1.5;
        }
        elseif ($item['game_guest_optimality_2'] > 109)
        {
            $guest_optimality_2 = 1;
        }
        elseif ($item['game_guest_optimality_2'] > 104)
        {
            $guest_optimality_2 = 0.5;
        }
        elseif ($item['game_guest_optimality_2'] > 49)
        {
            $guest_optimality_2 = 0;
        }
        elseif ($item['game_guest_optimality_2'] > 45)
        {
            $guest_optimality_2 = -0.5;
        }
        elseif ($item['game_guest_optimality_2'] > 42)
        {
            $guest_optimality_2 = -1;
        }
        elseif ($item['game_guest_optimality_2'] > 39)
        {
            $guest_optimality_2 = -1.5;
        }
        elseif ($item['game_guest_optimality_2'] > 36)
        {
            $guest_optimality_2 = -2;
        }
        elseif ($item['game_guest_optimality_2'] > 34)
        {
            $guest_optimality_2 = -2.5;
        }
        elseif ($item['game_guest_optimality_2'] > 32)
        {
            $guest_optimality_2 = -3;
        }
        elseif ($item['game_guest_optimality_2'] > 30)
        {
            $guest_optimality_2 = -3.5;
        }
        elseif ($item['game_guest_optimality_2'] > 28)
        {
            $guest_optimality_2 = -4;
        }
        elseif ($item['game_guest_optimality_2'] > 26)
        {
            $guest_optimality_2 = -4.5;
        }
        else
        {
            $guest_optimality_2 = -5;
        }

        if ($item['game_home_optimality_2'] > 134)
        {
            $home_optimality_2 = 2.5;
        }
        elseif ($item['game_home_optimality_2'] > 124)
        {
            $home_optimality_2 = 2;
        }
        elseif ($item['game_home_optimality_2'] > 114)
        {
            $home_optimality_2 = 1.5;
        }
        elseif ($item['game_home_optimality_2'] > 109)
        {
            $home_optimality_2 = 1;
        }
        elseif ($item['game_home_optimality_2'] > 104)
        {
            $home_optimality_2 = 0.5;
        }
        elseif ($item['game_home_optimality_2'] > 49)
        {
            $home_optimality_2 = 0;
        }
        elseif ($item['game_home_optimality_2'] > 45)
        {
            $home_optimality_2 = -0.5;
        }
        elseif ($item['game_home_optimality_2'] > 42)
        {
            $home_optimality_2 = -1;
        }
        elseif ($item['game_home_optimality_2'] > 39)
        {
            $home_optimality_2 = -1.5;
        }
        elseif ($item['game_home_optimality_2'] > 36)
        {
            $home_optimality_2 = -2;
        }
        elseif ($item['game_home_optimality_2'] > 34)
        {
            $home_optimality_2 = -2.5;
        }
        elseif ($item['game_home_optimality_2'] > 32)
        {
            $home_optimality_2 = -3;
        }
        elseif ($item['game_home_optimality_2'] > 30)
        {
            $home_optimality_2 = -3.5;
        }
        elseif ($item['game_home_optimality_2'] > 28)
        {
            $home_optimality_2 = -4;
        }
        elseif ($item['game_home_optimality_2'] > 26)
        {
            $home_optimality_2 = -4.5;
        }
        else
        {
            $home_optimality_2 = -5;
        }

        if ($item['game_guest_score'] - $item['game_home_score'] > 8)
        {
            $guest_score    = 8.5;
            $home_score     = -6.5;
        }
        elseif ($item['game_guest_score'] - $item['game_home_score'] > 7)
        {
            $guest_score    = 7.5;
            $home_score     = -5.5;
        }
        elseif ($item['game_guest_score'] - $item['game_home_score'] > 6)
        {
            $guest_score    = 6.5;
            $home_score     = -4.5;
        }
        elseif ($item['game_guest_score'] - $item['game_home_score'] > 5)
        {
            $guest_score    = 5.5;
            $home_score     = -3.5;
        }
        elseif ($item['game_guest_score'] - $item['game_home_score'] > 4)
        {
            $guest_score    = 4.5;
            $home_score     = -2.5;
        }
        elseif ($item['game_guest_score'] - $item['game_home_score'] > 3)
        {
            $guest_score    = 3.5;
            $home_score     = -1.5;
        }
        elseif ($item['game_guest_score'] - $item['game_home_score'] > 2)
        {
            $guest_score    = 2.5;
            $home_score     = -0.5;
        }
        elseif ($item['game_guest_score'] - $item['game_home_score'] > 1)
        {
            $guest_score    = 1.5;
            $home_score     = 0;
        }
        elseif ($item['game_guest_score'] - $item['game_home_score'] > 0)
        {
            $guest_score    = 0.5;
            $home_score     = 0;
        }

        if ($item['game_home_score'] - $item['game_guest_score'] > 8)
        {
            $home_score     = 8.5;
            $guest_score    = -6.5;
        }
        elseif ($item['game_home_score'] - $item['game_guest_score'] > 7)
        {
            $home_score     = 7.5;
            $guest_score    = -5.5;
        }
        elseif ($item['game_home_score'] - $item['game_guest_score'] > 6)
        {
            $home_score     = 6.5;
            $guest_score    = -4.5;
        }
        elseif ($item['game_home_score'] - $item['game_guest_score'] > 5)
        {
            $home_score     = 5.5;
            $guest_score    = -3.5;
        }
        elseif ($item['game_home_score'] - $item['game_guest_score'] > 4)
        {
            $home_score     = 4.5;
            $guest_score    = -2.5;
        }
        elseif ($item['game_home_score'] - $item['game_guest_score'] > 3)
        {
            $home_score     = 3.5;
            $guest_score    = -1.5;
        }
        elseif ($item['game_home_score'] - $item['game_guest_score'] > 2)
        {
            $home_score     = 2.5;
            $guest_score    = -0.5;
        }
        elseif ($item['game_home_score'] - $item['game_guest_score'] > 1)
        {
            $home_score     = 1.5;
            $guest_score    = 0;
        }
        elseif ($item['game_home_score'] - $item['game_guest_score'] > 0)
        {
            $home_score     = 0.5;
            $guest_score    = 0;
        }

        $guest_total = $guest_competition + $guest_mood + $guest_optimality_1 + $guest_optimality_2 + $guest_power + $guest_score;

        if ($guest_total > 5)
        {
            $guest_total = 5;
        }
        elseif ($guest_total < -5)
        {
            $guest_total = -5;
        }

        $home_total = $home_competition + $home_mood + $home_optimality_1 + $home_optimality_2 + $home_power + $home_score;

        if ($home_total > 5)
        {
            $home_total = 5;
        }
        elseif ($home_total < -5)
        {
            $home_total = -5;
        }

        if (TOURNAMENTTYPE_NATIONAL == $item['schedule_tournamenttype_id'])
        {
            if ($home_total < 0)
            {
                $home_total = 0;
            }

            if ($guest_total < 0)
            {
                $guest_total = 0;
            }
        }

        $sql = "UPDATE `game`
                SET `game_guest_plus_minus`=$guest_total,
                    `game_guest_plus_minus_competition`=$guest_competition,
                    `game_guest_plus_minus_mood`=$guest_mood,
                    `game_guest_plus_minus_optimality_1`=$guest_optimality_1,
                    `game_guest_plus_minus_optimality_2`=$guest_optimality_2,
                    `game_guest_plus_minus_power`=$guest_power,
                    `game_guest_plus_minus_score`=$guest_score,
                    `game_home_plus_minus`=$home_total,
                    `game_home_plus_minus_competition`=$home_competition,
                    `game_home_plus_minus_mood`=$home_mood,
                    `game_home_plus_minus_optimality_1`=$home_optimality_1,
                    `game_home_plus_minus_optimality_2`=$home_optimality_2,
                    `game_home_plus_minus_power`=$home_power,
                    `game_home_plus_minus_score`=$home_score
                WHERE `game_id`=$game_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }

    $sql = "UPDATE `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            SET `game_guest_plus_minus`=FLOOR(`game_guest_plus_minus`)+ROUND(RAND())
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND CEIL(`game_guest_plus_minus`)!=`game_guest_plus_minus`";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            SET `game_home_plus_minus`=FLOOR(`game_home_plus_minus`)+ROUND(RAND())
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND CEIL(`game_home_plus_minus`)!=`game_home_plus_minus`";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `game_id`,
                   `game_guest_plus_minus`,
                   `game_guest_national_id`,
                   `game_guest_team_id`,
                   `game_home_plus_minus`,
                   `game_home_national_id`,
                   `game_home_team_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND `game_played`=0
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $item)
    {
        if ($item['game_home_plus_minus'] < 0)
        {
            $sql = "SELECT `lineup_id`,
                           `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`=" . $item['game_home_team_id'] . "
                    AND `lineup_national_id`=" . $item['game_home_national_id'] . "
                    AND `lineup_game_id`=" . $item['game_id'] . "
                    ORDER BY RAND()
                    LIMIT " . -$item['game_home_plus_minus'];
            $player_sql = f_igosja_mysqli_query($sql);

            $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($player_array as $player)
            {
                $sql = "UPDATE `player`
                        SET `player_power_nominal`=`player_power_nominal`-1
                        WHERE `player_id`=" . $player['lineup_player_id'] . "
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_power_change`=-1
                        WHERE `lineup_id`=" . $player['lineup_id'] . "
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $log = array(
                    'history_game_id' => $item['game_id'],
                    'history_historytext_id' => HISTORYTEXT_PLAYER_GAME_POINT_MINUS,
                    'history_player_id' => $player['lineup_player_id'],
                );
                f_igosja_history($log);
            }
        }
        elseif ($item['game_home_plus_minus'] > 0)
        {
            $sql = "SELECT `lineup_id`,
                           `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`=" . $item['game_home_team_id'] . "
                    AND `lineup_national_id`=" . $item['game_home_national_id'] . "
                    AND `lineup_game_id`=" . $item['game_id'] . "
                    ORDER BY RAND()
                    LIMIT " . $item['game_home_plus_minus'];
            $player_sql = f_igosja_mysqli_query($sql);

            $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($player_array as $player)
            {
                $sql = "UPDATE `player`
                        SET `player_power_nominal`=`player_power_nominal`+1
                        WHERE `player_id`=" . $player['lineup_player_id'] . "
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_power_change`=1
                        WHERE `lineup_id`=" . $player['lineup_id'] . "
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $log = array(
                    'history_game_id' => $item['game_id'],
                    'history_historytext_id' => HISTORYTEXT_PLAYER_GAME_POINT_PLUS,
                    'history_player_id' => $player['lineup_player_id'],
                );
                f_igosja_history($log);
            }
        }

        if ($item['game_guest_plus_minus'] < 0)
        {
            $sql = "SELECT `lineup_id`,
                           `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`=" . $item['game_guest_team_id'] . "
                    AND `lineup_national_id`=" . $item['game_guest_national_id'] . "
                    AND `lineup_game_id`=" . $item['game_id'] . "
                    ORDER BY RAND()
                    LIMIT " . -$item['game_guest_plus_minus'];
            $player_sql = f_igosja_mysqli_query($sql);

            $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($player_array as $player)
            {
                $sql = "UPDATE `player`
                        SET `player_power_nominal`=`player_power_nominal`-1
                        WHERE `player_id`=" . $player['lineup_player_id'] . "
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_power_change`=-1
                        WHERE `lineup_id`=" . $player['lineup_id'] . "
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $log = array(
                    'history_game_id' => $item['game_id'],
                    'history_historytext_id' => HISTORYTEXT_PLAYER_GAME_POINT_MINUS,
                    'history_player_id' => $player['lineup_player_id'],
                );
                f_igosja_history($log);
            }
        }
        elseif ($item['game_guest_plus_minus'] > 0)
        {
            $sql = "SELECT `lineup_id`,
                           `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`=" . $item['game_guest_team_id'] . "
                    AND`lineup_national_id`=" . $item['game_guest_national_id'] . "
                    AND `lineup_game_id`=" . $item['game_id'] . "
                    ORDER BY RAND()
                    LIMIT " . $item['game_guest_plus_minus'];
            $player_sql = f_igosja_mysqli_query($sql);

            $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($player_array as $player)
            {
                $sql = "UPDATE `player`
                        SET `player_power_nominal`=`player_power_nominal`+1
                        WHERE `player_id`=" . $player['lineup_player_id'] . "
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `lineup`
                        SET `lineup_power_change`=1
                        WHERE `lineup_id`=" . $player['lineup_id'] . "
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $log = array(
                    'history_game_id' => $item['game_id'],
                    'history_historytext_id' => HISTORYTEXT_PLAYER_GAME_POINT_PLUS,
                    'history_player_id' => $player['lineup_player_id'],
                );
                f_igosja_history($log);
            }
        }
    }
}