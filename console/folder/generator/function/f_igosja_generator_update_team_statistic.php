<?php

function f_igosja_generator_update_team_statistic()
//Считаем проценты в таблицах статистики команд
{
    global $igosja_season_id;

    $sql = "UPDATE `statisticteam`
            SET `statisticteam_win_percent`=`statisticteam_win`/`statisticteam_game`*100
            WHERE `statisticteam_season_id`=$igosja_season_id";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}