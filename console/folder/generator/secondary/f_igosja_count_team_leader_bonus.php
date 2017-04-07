<?php

function f_igosja_count_team_leader_bonus($player_array, $team_array)
{
    $player_id = $player_array['player_id'];

    $sql = "SELECT `playerspecial_level`,
                   `playerspecial_special_id`
            FROM `playerspecial`
            WHERE `playerspecial_player_id`=$player_id
            AND `playerspecial_special_id`=" . SPECIAL_LEADER . "
            LIMIT 1";
    $playerspesial_sql = f_igosja_mysqli_query($sql);

    if ($playerspesial_sql->num_rows)
    {
        $playerspecial_array = $playerspesial_sql->fetch_all(1);

        if (1 == $playerspecial_array[0]['playerspecial_level'])
        {
            $team_array['leader'] = $team_array['leader'] + 0.5;
        }
        else
        {
            $team_array['leader'] = $team_array['leader'] + $playerspecial_array[0]['playerspecial_level'] - 1;
        }
    }

    return $team_array;
}