<?php

function f_igosja_generator_set_auto()
//Ставим метку автосостава
{
    $sql = "SELECT `game_id`,
                   `game_guest_mood_id`,
                   `game_guest_rude_id`,
                   `game_guest_style_id`,
                   `game_guest_tactic_id`,
                   `game_home_mood_id`,
                   `game_home_rude_id`,
                   `game_home_style_id`,
                   `game_home_tactic_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE `game_played`='0'
            AND FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            AND (`game_guest_tactic_id`='0'
            OR `game_home_tactic_id`='0')
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(1);

    foreach ($game_array as $game)
    {
        $game_id            = $game['game_id'];
        $guest_auto         = 0;
        $guest_mood_id      = $game['game_guest_mood_id'];
        $guest_rude_id      = $game['game_guest_rude_id'];
        $guest_style_id     = $game['game_guest_style_id'];
        $guest_tactic_id    = $game['game_guest_tactic_id'];
        $home_auto          = 0;
        $home_mood_id       = $game['game_home_mood_id'];
        $home_rude_id       = $game['game_home_rude_id'];
        $home_style_id      = $game['game_home_style_id'];
        $home_tactic_id     = $game['game_home_tactic_id'];

        if (0 == $guest_tactic_id)
        {
            $guest_auto         = 0;
            $guest_mood_id      = MOOD_NORMAL;
            $guest_rude_id      = RUDE_NORMAL;
            $guest_style_id     = STYLE_NORMAL;
            $guest_tactic_id    = TACTIC_NORMAL;
        }

        if (0 == $home_tactic_id)
        {
            $home_auto          = 0;
            $home_mood_id       = MOOD_NORMAL;
            $home_rude_id       = RUDE_NORMAL;
            $home_style_id      = STYLE_NORMAL;
            $home_tactic_id     = TACTIC_NORMAL;
        }

        $sql = "UPDATE `game`
                SET `game_guest_auto`='$guest_auto',
                    `game_guest_mood_id`='$guest_mood_id',
                    `game_guest_rude_id`='$guest_rude_id',
                    `game_guest_style_id`='$guest_style_id',
                    `game_guest_tactic_id`='$guest_tactic_id',
                    `game_home_auto`='$home_auto',
                    `game_home_mood_id`='$home_mood_id',
                    `game_home_rude_id`='$home_rude_id',
                    `game_home_style_id`='$home_style_id',
                    `game_home_tactic_id`='$home_tactic_id'
                WHERE `game_id`='$game_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        usleep(1);

        print '.';
        flush();
    }
}