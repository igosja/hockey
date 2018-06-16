<?php

/**
 * Переходимо в новий сезон
 */
function f_igosja_generator_new_season()
{
    $sql = "SELECT COUNT(`schedule_id`) AS `check`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`-86400, '%Y-%m-%d')=CURDATE()";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $check_array[0]['check'])
    {
        $function_array = array(
            'f_igosja_newseason_insert_season',
            'f_igosja_newseason_nodeal',
            'f_igosja_newseason_fire_national',
            'f_igosja_newseason_player_from_national',
            'f_igosja_newseason_national_transfer_money',
            'f_igosja_newseason_league_participant',
            'f_igosja_newseason_league_coefficient',
            'f_igosja_newseason_league_limit',
            'f_igosja_newseason_schedule',
            'f_igosja_newseason_championship_rotate',
            'f_igosja_newseason_offseason',
            'f_igosja_newseason_conference',
            'f_igosja_newseason_championship',
            'f_igosja_newseason_league',
            'f_igosja_newseason_worldcup',
            'f_igosja_newseason_building_base',
            'f_igosja_newseason_building_stadium',
            'f_igosja_newseason_phisical',
            'f_igosja_newseason_tire_base_level',
            'f_igosja_newseason_training',
            'f_igosja_newseason_school',
            'f_igosja_newseason_scout',
            'f_igosja_newseason_player_power_change',
            'f_igosja_newseason_injury',
            'f_igosja_newseason_older_player',
            'f_igosja_newseason_pension',
            'f_igosja_newseason_pension_inform',
            'f_igosja_newseason_maintenance',
            'f_igosja_newseason_mood_reset',
            'f_igosja_newseason_player_game_row',
            'f_igosja_newseason_country_auto',
            'f_igosja_newseason_truncate',
        );

        for ($i=0, $count_function=count($function_array); $i<$count_function; $i++)
        {
            $function_array[$i]();
        }
    }
}