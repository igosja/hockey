<?php

/**
 * Записуємо результати матчів в рейтинг менеджерів
 */
function f_igosja_generator_user_rating()
{
    $sql = "SELECT `game_id`,
                   `game_guest_auto`,
                   `game_guest_style_1_id`,
                   `game_guest_style_2_id`,
                   `game_guest_style_3_id`,
                   `game_guest_score`,
                   `game_guest_score_over`,
                   `game_guest_score_bullet`,
                   `game_guest_forecast`,
                   `game_guest_mood_id`,
                   `game_home_auto`,
                   `game_home_style_1_id`,
                   `game_home_style_2_id`,
                   `game_home_style_3_id`,
                   `game_home_score`,
                   `game_home_score_over`,
                   `game_home_score_bullet`,
                   `game_home_forecast`,
                   `game_home_mood_id`,
                   `guest_team`.`team_user_id` AS `guest_user_id`,
                   `home_team`.`team_user_id` AS `home_user_id`,
                   `schedule_season_id`
            FROM `game`
            LEFT JOIN `team` AS `guest_team`
            ON `guest_team`.`team_id`=`game_guest_team_id`
            LEFT JOIN `team` AS `home_team`
            ON `home_team`.`team_id`=`game_home_team_id`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND (`guest_team`.`team_user_id`!=0
            OR `home_team`.`team_user_id`!=0)
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $item)
    {
        $guest_auto             = 0;
        $guest_collision_loose  = 0;
        $guest_collision_win    = 0;
        $guest_loose            = 0;
        $guest_loose_equal      = 0;
        $guest_loose_strong     = 0;
        $guest_loose_super      = 0;
        $guest_loose_weak       = 0;
        $guest_looseover        = 0;
        $guest_looseover_equal  = 0;
        $guest_looseover_strong = 0;
        $guest_looseover_weak   = 0;
        $guest_user_id          = $item['guest_user_id'];
        $guest_vs_super         = 0;
        $guest_vs_rest          = 0;
        $guest_win              = 0;
        $guest_win_equal        = 0;
        $guest_win_strong       = 0;
        $guest_win_super        = 0;
        $guest_win_weak         = 0;
        $guest_winover          = 0;
        $guest_winover_equal    = 0;
        $guest_winover_strong   = 0;
        $guest_winover_weak     = 0;
        $home_auto              = 0;
        $home_collision_loose   = 0;
        $home_collision_win     = 0;
        $home_loose             = 0;
        $home_loose_equal       = 0;
        $home_loose_strong      = 0;
        $home_loose_super       = 0;
        $home_loose_weak        = 0;
        $home_looseover         = 0;
        $home_looseover_equal   = 0;
        $home_looseover_strong  = 0;
        $home_looseover_weak    = 0;
        $home_user_id           = $item['home_user_id'];
        $home_vs_super          = 0;
        $home_vs_rest           = 0;
        $home_win               = 0;
        $home_win_equal         = 0;
        $home_win_strong        = 0;
        $home_win_super         = 0;
        $home_win_weak          = 0;
        $home_winover           = 0;
        $home_winover_equal     = 0;
        $home_winover_strong    = 0;
        $home_winover_weak      = 0;
        $season_id              = $item['schedule_season_id'];

        if ($item['game_guest_auto'])
        {
            $guest_auto++;
        }

        if ($item['game_home_auto'])
        {
            $home_auto++;
        }
        
        if ((STYLE_POWER == $item['game_guest_style_1_id'] && STYLE_SPEED == $item['game_home_style_1_id']) ||
            (STYLE_SPEED == $item['game_guest_style_1_id'] && STYLE_TECHNIQUE == $item['game_home_style_1_id']) ||
            (STYLE_TECHNIQUE == $item['game_guest_style_1_id'] && STYLE_POWER == $item['game_home_style_1_id']))
        {
            $guest_collision_win++;
            $home_collision_loose++;
        }
        elseif ((STYLE_SPEED == $item['game_guest_style_1_id'] && STYLE_POWER == $item['game_home_style_1_id']) ||
                (STYLE_TECHNIQUE == $item['game_guest_style_1_id'] && STYLE_SPEED == $item['game_home_style_1_id']) ||
                (STYLE_POWER == $item['game_guest_style_1_id'] && STYLE_TECHNIQUE == $item['game_home_style_1_id']))
        {
            $guest_collision_loose++;
            $home_collision_win++;
        }
        
        if ((STYLE_POWER == $item['game_guest_style_2_id'] && STYLE_SPEED == $item['game_home_style_2_id']) ||
            (STYLE_SPEED == $item['game_guest_style_2_id'] && STYLE_TECHNIQUE == $item['game_home_style_2_id']) ||
            (STYLE_TECHNIQUE == $item['game_guest_style_2_id'] && STYLE_POWER == $item['game_home_style_2_id']))
        {
            $guest_collision_win++;
            $home_collision_loose++;
        }
        elseif ((STYLE_SPEED == $item['game_guest_style_2_id'] && STYLE_POWER == $item['game_home_style_2_id']) ||
                (STYLE_TECHNIQUE == $item['game_guest_style_2_id'] && STYLE_SPEED == $item['game_home_style_2_id']) ||
                (STYLE_POWER == $item['game_guest_style_2_id'] && STYLE_TECHNIQUE == $item['game_home_style_2_id']))
        {
            $guest_collision_loose++;
            $home_collision_win++;
        }
        
        if ((STYLE_POWER == $item['game_guest_style_3_id'] && STYLE_SPEED == $item['game_home_style_3_id']) ||
            (STYLE_SPEED == $item['game_guest_style_3_id'] && STYLE_TECHNIQUE == $item['game_home_style_3_id']) ||
            (STYLE_TECHNIQUE == $item['game_guest_style_3_id'] && STYLE_POWER == $item['game_home_style_3_id']))
        {
            $guest_collision_win++;
            $home_collision_loose++;
        }
        elseif ((STYLE_SPEED == $item['game_guest_style_3_id'] && STYLE_POWER == $item['game_home_style_3_id']) ||
                (STYLE_TECHNIQUE == $item['game_guest_style_3_id'] && STYLE_SPEED == $item['game_home_style_3_id']) ||
                (STYLE_POWER == $item['game_guest_style_3_id'] && STYLE_TECHNIQUE == $item['game_home_style_3_id']))
        {
            $guest_collision_loose++;
            $home_collision_win++;
        }

        if ($item['game_guest_score'] > $item['game_home_score'] && 0 == $item['game_guest_score_over'])
        {
            $guest_win++;
            $home_loose++;

            if ($item['game_guest_forecast'] / $item['game_home_forecast'] < 0.9)
            {
                $guest_win_strong++;
                $home_loose_weak++;
            }
            elseif ($item['game_guest_forecast'] / $item['game_home_forecast'] > 1.1)
            {
                $guest_win_weak++;
                $home_loose_strong++;
            }
            else
            {
                $guest_win_equal++;
                $home_loose_equal++;
            }

            if (MOOD_SUPER == $item['game_home_mood_id'] && MOOD_SUPER != $item['game_guest_mood_id'])
            {
                $guest_win_super++;
                $home_loose_super++;
            }
        }
        elseif (($item['game_guest_score'] > $item['game_home_score'] && 0 != $item['game_guest_score_over']) ||
                ($item['game_guest_score'] == $item['game_home_score'] && $item['game_guest_score_bullet'] > $item['game_home_score_bullet']))
        {
            $guest_winover++;
            $home_looseover++;

            if ($item['game_guest_forecast'] / $item['game_home_forecast'] < 0.9)
            {
                $guest_winover_strong++;
                $home_looseover_weak++;
            }
            elseif ($item['game_guest_forecast'] / $item['game_home_forecast'] > 1.1)
            {
                $guest_winover_weak++;
                $home_looseover_strong++;
            }
            else
            {
                $guest_winover_equal++;
                $home_looseover_equal++;
            }
        }
        elseif ($item['game_guest_score'] == $item['game_home_score'] && $item['game_guest_score_bullet'] == $item['game_home_score_bullet'])
        {
            $guest_looseover++;
            $home_looseover++;

            if ($item['game_guest_forecast'] / $item['game_home_forecast'] < 0.9)
            {
                $guest_looseover_strong++;
                $home_looseover_weak++;
            }
            elseif ($item['game_guest_forecast'] / $item['game_home_forecast'] > 1.1)
            {
                $guest_looseover_weak++;
                $home_looseover_strong++;
            }
            else
            {
                $guest_looseover_equal++;
                $home_looseover_equal++;
            }
        }
        elseif (($item['game_guest_score'] < $item['game_home_score'] && 0 != $item['game_home_score_over']) ||
                ($item['game_guest_score'] == $item['game_home_score'] && $item['game_guest_score_bullet'] < $item['game_home_score_bullet']))
        {
            $guest_looseover++;
            $home_winover++;

            if ($item['game_guest_forecast'] / $item['game_home_forecast'] < 0.9)
            {
                $guest_looseover_strong++;
                $home_winover_weak++;
            }
            elseif ($item['game_guest_forecast'] / $item['game_home_forecast'] > 1.1)
            {
                $guest_looseover_weak++;
                $home_winover_strong++;
            }
            else
            {
                $guest_looseover_equal++;
                $home_winover_equal++;
            }
        }
        elseif ($item['game_guest_score'] < $item['game_home_score'] && 0 == $item['game_home_score_over'])
        {
            $guest_loose++;
            $home_win++;

            if ($item['game_guest_forecast'] / $item['game_home_forecast'] < 0.9)
            {
                $guest_loose_strong++;
                $home_win_weak++;
            }
            elseif ($item['game_guest_forecast'] / $item['game_home_forecast'] > 1.1)
            {
                $guest_loose_weak++;
                $home_win_strong++;
            }
            else
            {
                $guest_loose_equal++;
                $home_win_equal++;
            }

            if (MOOD_SUPER != $item['game_home_mood_id'] && MOOD_SUPER == $item['game_guest_mood_id'])
            {
                $guest_loose_super++;
                $home_win_super++;
            }
        }

        if (MOOD_REST == $item['game_guest_mood_id'] && MOOD_REST == $item['game_home_mood_id'])
        {
            $home_vs_rest++;
        }
        elseif (MOOD_REST == $item['game_home_mood_id'] && MOOD_REST == $item['game_guest_mood_id'])
        {
            $guest_vs_rest++;
        }

        if (MOOD_SUPER == $item['game_guest_mood_id'] && MOOD_SUPER == $item['game_home_mood_id'])
        {
            $home_vs_super++;
        }
        elseif (MOOD_SUPER == $item['game_home_mood_id'] && MOOD_SUPER == $item['game_guest_mood_id'])
        {
            $guest_vs_super++;
        }

        if ($guest_user_id)
        {
            $sql = "UPDATE `userrating`
                    SET `userrating_auto`=`userrating_auto`+$guest_auto,
                        `userrating_collision_loose`=`userrating_collision_loose`+$guest_collision_loose,
                        `userrating_collision_win`=`userrating_collision_win`+$guest_collision_win,
                        `userrating_game`=`userrating_game`+1,
                        `userrating_loose`=`userrating_loose`+$guest_loose,
                        `userrating_loose_equal`=`userrating_loose_equal`+$guest_loose_equal,
                        `userrating_loose_strong`=`userrating_loose_strong`+$guest_loose_strong,
                        `userrating_loose_super`=`userrating_loose_super`+$guest_loose_super,
                        `userrating_loose_weak`=`userrating_loose_weak`+$guest_loose_weak,
                        `userrating_looseover`=`userrating_looseover`+$guest_looseover,
                        `userrating_looseover_equal`=`userrating_looseover_equal`+$guest_looseover_equal,
                        `userrating_looseover_strong`=`userrating_looseover_strong`+$guest_looseover_strong,
                        `userrating_looseover_weak`=`userrating_looseover_weak`+$guest_looseover_weak,
                        `userrating_vs_super`=`userrating_vs_super`+$guest_vs_super,
                        `userrating_vs_rest`=`userrating_vs_rest`+$guest_vs_rest,
                        `userrating_win`=`userrating_win`+$guest_win,
                        `userrating_win_equal`=`userrating_win_equal`+$guest_win_equal,
                        `userrating_win_strong`=`userrating_win_strong`+$guest_win_strong,
                        `userrating_win_super`=`userrating_win_super`+$guest_win_super,
                        `userrating_win_weak`=`userrating_win_weak`+$guest_win_weak,
                        `userrating_winover`=`userrating_winover`+$guest_winover,
                        `userrating_winover_equal`=`userrating_winover_equal`+$guest_winover_equal,
                        `userrating_winover_strong`=`userrating_winover_strong`+$guest_winover_strong,
                        `userrating_winover_weak`=`userrating_winover_weak`+$guest_winover_weak
                    WHERE `userrating_user_id`=$guest_user_id
                    AND `userrating_season_id`=$season_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        if ($home_user_id)
        {
            $sql = "UPDATE `userrating`
                    SET `userrating_auto`=`userrating_auto`+$home_auto,
                        `userrating_collision_loose`=`userrating_collision_loose`+$home_collision_loose,
                        `userrating_collision_win`=`userrating_collision_win`+$home_collision_win,
                        `userrating_game`=`userrating_game`+1,
                        `userrating_loose`=`userrating_loose`+$home_loose,
                        `userrating_loose_equal`=`userrating_loose_equal`+$home_loose_equal,
                        `userrating_loose_strong`=`userrating_loose_strong`+$home_loose_strong,
                        `userrating_loose_super`=`userrating_loose_super`+$home_loose_super,
                        `userrating_loose_weak`=`userrating_loose_weak`+$home_loose_weak,
                        `userrating_looseover`=`userrating_looseover`+$home_looseover,
                        `userrating_looseover_equal`=`userrating_looseover_equal`+$home_looseover_equal,
                        `userrating_looseover_strong`=`userrating_looseover_strong`+$home_looseover_strong,
                        `userrating_looseover_weak`=`userrating_looseover_weak`+$home_looseover_weak,
                        `userrating_vs_super`=`userrating_vs_super`+$home_vs_super,
                        `userrating_vs_rest`=`userrating_vs_rest`+$home_vs_rest,
                        `userrating_win`=`userrating_win`+$home_win,
                        `userrating_win_equal`=`userrating_win_equal`+$home_win_equal,
                        `userrating_win_strong`=`userrating_win_strong`+$home_win_strong,
                        `userrating_win_super`=`userrating_win_super`+$home_win_super,
                        `userrating_win_weak`=`userrating_win_weak`+$home_win_weak,
                        `userrating_winover`=`userrating_winover`+$home_winover,
                        `userrating_winover_equal`=`userrating_winover_equal`+$home_winover_equal,
                        `userrating_winover_strong`=`userrating_winover_strong`+$home_winover_strong,
                        `userrating_winover_weak`=`userrating_winover_weak`+$home_winover_weak
                    WHERE `userrating_user_id`=$home_user_id
                    AND `userrating_season_id`=$season_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }
}