<?php

/**
 * Ставимо мітку автосостава
 */
function f_igosja_generator_set_auto()
{
    $sql = "SELECT `game_id`,
                   `game_guest_mood_id`,
                   `game_guest_rude_1_id`,
                   `game_guest_rude_2_id`,
                   `game_guest_rude_3_id`,
                   `game_guest_style_1_id`,
                   `game_guest_style_2_id`,
                   `game_guest_style_3_id`,
                   `game_guest_tactic_1_id`,
                   `game_guest_tactic_2_id`,
                   `game_guest_tactic_3_id`,
                   `game_home_mood_id`,
                   `game_home_rude_1_id`,
                   `game_home_rude_2_id`,
                   `game_home_rude_3_id`,
                   `game_home_style_1_id`,
                   `game_home_style_2_id`,
                   `game_home_style_3_id`,
                   `game_home_tactic_1_id`,
                   `game_home_tactic_2_id`,
                   `game_home_tactic_3_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND (`game_guest_mood_id`=0
            OR `game_home_mood_id`=0)
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $game)
    {
        $game_id            = $game['game_id'];
        $guest_auto         = 0;
        $guest_mood_id      = $game['game_guest_mood_id'];
        $guest_rude_1_id    = $game['game_guest_rude_1_id'];
        $guest_rude_2_id    = $game['game_guest_rude_2_id'];
        $guest_rude_3_id    = $game['game_guest_rude_3_id'];
        $guest_style_1_id   = $game['game_guest_style_1_id'];
        $guest_style_2_id   = $game['game_guest_style_2_id'];
        $guest_style_3_id   = $game['game_guest_style_3_id'];
        $guest_tactic_1_id  = $game['game_guest_tactic_1_id'];
        $guest_tactic_2_id  = $game['game_guest_tactic_2_id'];
        $guest_tactic_3_id  = $game['game_guest_tactic_3_id'];
        $home_auto          = 0;
        $home_mood_id       = $game['game_home_mood_id'];
        $home_rude_1_id     = $game['game_home_rude_1_id'];
        $home_rude_2_id     = $game['game_home_rude_2_id'];
        $home_rude_3_id     = $game['game_home_rude_3_id'];
        $home_style_1_id    = $game['game_home_style_1_id'];
        $home_style_2_id    = $game['game_home_style_2_id'];
        $home_style_3_id    = $game['game_home_style_3_id'];
        $home_tactic_1_id   = $game['game_home_tactic_1_id'];
        $home_tactic_2_id   = $game['game_home_tactic_2_id'];
        $home_tactic_3_id   = $game['game_home_tactic_3_id'];

        if (0 == $guest_mood_id)
        {
            $guest_auto         = 1;
            $guest_mood_id      = MOOD_NORMAL;
            $guest_rude_1_id    = RUDE_NORMAL;
            $guest_rude_2_id    = RUDE_NORMAL;
            $guest_rude_3_id    = RUDE_NORMAL;
            $guest_style_1_id   = STYLE_NORMAL;
            $guest_style_2_id   = STYLE_NORMAL;
            $guest_style_3_id   = STYLE_NORMAL;
            $guest_tactic_1_id  = TACTIC_NORMAL;
            $guest_tactic_2_id  = TACTIC_NORMAL;
            $guest_tactic_3_id  = TACTIC_NORMAL;
        }

        if (0 == $home_mood_id)
        {
            $home_auto          = 1;
            $home_mood_id       = MOOD_NORMAL;
            $home_rude_1_id     = RUDE_NORMAL;
            $home_rude_2_id     = RUDE_NORMAL;
            $home_rude_3_id     = RUDE_NORMAL;
            $home_style_1_id    = STYLE_NORMAL;
            $home_style_2_id    = STYLE_NORMAL;
            $home_style_3_id    = STYLE_NORMAL;
            $home_tactic_1_id   = TACTIC_NORMAL;
            $home_tactic_2_id   = TACTIC_NORMAL;
            $home_tactic_3_id   = TACTIC_NORMAL;
        }

        $sql = "UPDATE `game`
                SET `game_guest_auto`=$guest_auto,
                    `game_guest_mood_id`=$guest_mood_id,
                    `game_guest_rude_1_id`=$guest_rude_1_id,
                    `game_guest_rude_2_id`=$guest_rude_2_id,
                    `game_guest_rude_3_id`=$guest_rude_3_id,
                    `game_guest_style_1_id`=$guest_style_1_id,
                    `game_guest_style_2_id`=$guest_style_2_id,
                    `game_guest_style_3_id`=$guest_style_3_id,
                    `game_guest_tactic_1_id`=$guest_tactic_1_id,
                    `game_guest_tactic_2_id`=$guest_tactic_2_id,
                    `game_guest_tactic_3_id`=$guest_tactic_3_id,
                    `game_home_auto`=$home_auto,
                    `game_home_mood_id`=$home_mood_id,
                    `game_home_rude_1_id`=$home_rude_1_id,
                    `game_home_rude_2_id`=$home_rude_2_id,
                    `game_home_rude_3_id`=$home_rude_3_id,
                    `game_home_style_1_id`=$home_style_1_id,
                    `game_home_style_2_id`=$home_style_2_id,
                    `game_home_style_3_id`=$home_style_3_id,
                    `game_home_tactic_1_id`=$home_tactic_1_id,
                    `game_home_tactic_2_id`=$home_tactic_2_id,
                    `game_home_tactic_3_id`=$home_tactic_3_id
                WHERE `game_id`=$game_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}