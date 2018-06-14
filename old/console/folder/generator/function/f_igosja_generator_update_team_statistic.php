<?php

/**
 * Рахуємо відсотки в таблицях статистики команд
 */
function f_igosja_generator_update_team_statistic()
{
    global $igosja_season_id;

    $sql = "UPDATE `statisticteam`
            SET `statisticteam_win_percent`=`statisticteam_win`/`statisticteam_game`*100
            WHERE `statisticteam_season_id`=$igosja_season_id";
    f_igosja_mysqli_query($sql);
}