<?php

/**
 * Додаємо гравцям +1 рік
 */
function f_igosja_newseason_older_player()
{
    $sql = "UPDATE `player`
            SET `player_age`=`player_age`+1
            WHERE `player_age`<40
            AND `player_team_id`!=0";
    f_igosja_mysqli_query($sql);
}