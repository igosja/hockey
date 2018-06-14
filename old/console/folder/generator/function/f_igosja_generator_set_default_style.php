<?php

/**
 * Ставимо стиль, грубість і тактику, де їх немає
 */
function f_igosja_generator_set_default_style()
{
    $sql = "SELECT `game_id`,
                   `game_guest_rude_1_id`,
                   `game_guest_rude_2_id`,
                   `game_guest_rude_3_id`,
                   `game_guest_style_1_id`,
                   `game_guest_style_2_id`,
                   `game_guest_style_3_id`,
                   `game_guest_tactic_1_id`,
                   `game_guest_tactic_2_id`,
                   `game_guest_tactic_3_id`,
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
            AND (`game_guest_rude_1_id`=0
            OR `game_guest_rude_2_id`=0
            OR `game_guest_rude_3_id`=0
            OR `game_guest_style_1_id`=0
            OR `game_guest_style_2_id`=0
            OR `game_guest_style_3_id`=0
            OR `game_guest_tactic_1_id`=0
            OR `game_guest_tactic_2_id`=0
            OR `game_guest_tactic_3_id`=0
            OR `game_home_rude_1_id`=0
            OR `game_home_rude_2_id`=0
            OR `game_home_rude_3_id`=0
            OR `game_home_style_1_id`=0
            OR `game_home_style_2_id`=0
            OR `game_home_style_3_id`=0
            OR `game_home_tactic_1_id`=0
            OR `game_home_tactic_2_id`=0
            OR `game_home_tactic_3_id`=0)
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $game)
    {
        $game_id            = $game['game_id'];
        $guest_rude_1_id    = $game['game_guest_rude_1_id'];
        $guest_rude_2_id    = $game['game_guest_rude_2_id'];
        $guest_rude_3_id    = $game['game_guest_rude_3_id'];
        $guest_style_1_id   = $game['game_guest_style_1_id'];
        $guest_style_2_id   = $game['game_guest_style_2_id'];
        $guest_style_3_id   = $game['game_guest_style_3_id'];
        $guest_tactic_1_id  = $game['game_guest_tactic_1_id'];
        $guest_tactic_2_id  = $game['game_guest_tactic_2_id'];
        $guest_tactic_3_id  = $game['game_guest_tactic_3_id'];
        $home_rude_1_id     = $game['game_home_rude_1_id'];
        $home_rude_2_id     = $game['game_home_rude_2_id'];
        $home_rude_3_id     = $game['game_home_rude_3_id'];
        $home_style_1_id    = $game['game_home_style_1_id'];
        $home_style_2_id    = $game['game_home_style_2_id'];
        $home_style_3_id    = $game['game_home_style_3_id'];
        $home_tactic_1_id   = $game['game_home_tactic_1_id'];
        $home_tactic_2_id   = $game['game_home_tactic_2_id'];
        $home_tactic_3_id   = $game['game_home_tactic_3_id'];

        if (0 == $guest_rude_1_id)
        {
            $guest_rude_1_id = RUDE_NORMAL;
        }
        
        if (0 == $guest_rude_2_id)
        {
            $guest_rude_2_id = RUDE_NORMAL;
        }

        if (0 == $guest_rude_3_id)
        {
            $guest_rude_3_id = RUDE_NORMAL;
        }

        if (0 == $guest_style_1_id)
        {
            $guest_style_1_id = STYLE_NORMAL;
        }

        if (0 == $guest_style_2_id)
        {
            $guest_style_2_id = STYLE_NORMAL;
        }

        if (0 == $guest_style_3_id)
        {
            $guest_style_3_id = STYLE_NORMAL;
        }

        if (0 == $guest_tactic_1_id)
        {
            $guest_tactic_1_id = TACTIC_NORMAL;
        }

        if (0 == $guest_tactic_2_id)
        {
            $guest_tactic_2_id = TACTIC_NORMAL;
        }

        if (0 == $guest_tactic_3_id)
        {
            $guest_tactic_3_id = TACTIC_NORMAL;
        }

        if (0 == $home_rude_1_id)
        {
            $home_rude_1_id = RUDE_NORMAL;
        }

        if (0 == $home_rude_2_id)
        {
            $home_rude_2_id = RUDE_NORMAL;
        }

        if (0 == $home_rude_3_id)
        {
            $home_rude_3_id = RUDE_NORMAL;
        }

        if (0 == $home_style_1_id)
        {
            $home_style_1_id = STYLE_NORMAL;
        }

        if (0 == $home_style_2_id)
        {
            $home_style_2_id = STYLE_NORMAL;
        }

        if (0 == $home_style_3_id)
        {
            $home_style_3_id = STYLE_NORMAL;
        }

        if (0 == $home_tactic_1_id)
        {
            $home_tactic_1_id = TACTIC_NORMAL;
        }

        if (0 == $home_tactic_2_id)
        {
            $home_tactic_2_id = TACTIC_NORMAL;
        }

        if (0 == $home_tactic_3_id)
        {
            $home_tactic_3_id = TACTIC_NORMAL;
        }

        $sql = "UPDATE `game`
                SET `game_guest_rude_1_id`=$guest_rude_1_id,
                    `game_guest_rude_2_id`=$guest_rude_2_id,
                    `game_guest_rude_3_id`=$guest_rude_3_id,
                    `game_guest_style_1_id`=$guest_style_1_id,
                    `game_guest_style_2_id`=$guest_style_2_id,
                    `game_guest_style_3_id`=$guest_style_3_id,
                    `game_guest_tactic_1_id`=$guest_tactic_1_id,
                    `game_guest_tactic_2_id`=$guest_tactic_2_id,
                    `game_guest_tactic_3_id`=$guest_tactic_3_id,
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