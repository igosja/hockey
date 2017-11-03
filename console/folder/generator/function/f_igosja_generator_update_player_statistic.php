<?php

/**
 * Рахуємо відсотки в таблицях статистики хокеїстів
 */
function f_igosja_generator_update_player_statistic()
{
    global $igosja_season_id;

    $sql = "UPDATE `statisticplayer`
            SET `statisticplayer_pass_per_game`=`statisticplayer_pass`/`statisticplayer_game`,
                `statisticplayer_save_percent`=`statisticplayer_save`/`statisticplayer_shot_gk`*100
            WHERE `statisticplayer_season_id`=$igosja_season_id
            AND `statisticplayer_is_gk`=1";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `statisticplayer`
            SET `statisticplayer_face_off_percent`=`statisticplayer_face_off_win`/`statisticplayer_face_off`*100,
                `statisticplayer_score_shot_percent`=`statisticplayer_score`/`statisticplayer_shot`*100,
                `statisticplayer_shot_per_game`=`statisticplayer_shot`/`statisticplayer_game`
            WHERE `statisticplayer_season_id`=$igosja_season_id
            AND `statisticplayer_is_gk`=0";
    f_igosja_mysqli_query($sql);
}