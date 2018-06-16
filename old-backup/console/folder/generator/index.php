<?php

include(__DIR__ . '/../../../include/generator.php');

$sql = "SELECT `site_date_cron`
        FROM `site`
        WHERE `site_id`=1
        LIMIT 1";
$cron_sql = f_igosja_mysqli_query($sql);

if (0 == $cron_sql->num_rows)
{
    exit;
}

$cron_array = $cron_sql->fetch_all(MYSQLI_ASSOC);

if (date('Y-m-d', $cron_array[0]['site_date_cron']) == date('Y-m-d'))
{
    exit;
}

if (!in_array(date('H:i'), array('11:56', '11:57', '11:58', '11:59', '12:00', '12:01', '12:02', '12:03', '12:04')))
{
    exit;
}

$function_array = array(
    'f_igosja_generator_update_date_cron',
    'f_igosja_generator_dump_database',
    'f_igosja_generator_site_close',
    'f_igosja_generator_player_power_new_to_old',
    'f_igosja_generator_check_mood_limit',
    'f_igosja_generator_check_lineup',
    'f_igosja_generator_fill_lineup',
    'f_igosja_generator_set_auto',
    'f_igosja_generator_set_default_style',
    'f_igosja_generator_set_user_auto',
    'f_igosja_generator_set_ticket_price',
    'f_igosja_generator_set_stadium',
    'f_igosja_generator_count_visitor',
    'f_igosja_generator_finance_stadium',
    'f_igosja_generator_team_to_statistic',
    'f_igosja_generator_user_to_rating',
    'f_igosja_generator_lineup_to_statistic',
    'f_igosja_generator_national_vs',
    'f_igosja_generator_game_result',
    'f_igosja_generator_league_coefficient',
    'f_igosja_generator_update_team_statistic',
    'f_igosja_generator_update_player_statistic',
    'f_igosja_generator_user_rating',
    'f_igosja_generator_country_auto',
    'f_igosja_generator_team_visitor_after_game',
    'f_igosja_generator_team_visitor',
    'f_igosja_generator_plus_minus',
    'f_igosja_generator_decrease_teamwork',
    'f_igosja_generator_standing',
    'f_igosja_generator_standing_place',
    'f_igosja_generator_player_game_row',
    'f_igosja_generator_player_tire',
    'f_igosja_generator_training',
    'f_igosja_generator_phisical',
    'f_igosja_generator_school',
    'f_igosja_generator_scout',
    'f_igosja_generator_building_base',
    'f_igosja_generator_building_stadium',
    'f_igosja_generator_stadium_maintenance',
    'f_igosja_generator_decrease_injury',
    'f_igosja_generator_set_injury',
    'f_igosja_generator_make_played',
    'f_igosja_generator_league_out',
    'f_igosja_generator_league_lot',
    'f_igosja_generator_participant_championship',
    'f_igosja_generator_playoff_championship_add_game',
    'f_igosja_generator_playoff_championship_lot',
    'f_igosja_generator_achievement',
    'f_igosja_generator_prize',
    'f_igosja_generator_swiss',
    'f_igosja_generator_rent_decrease_return',
    'f_igosja_generator_transfer',
    'f_igosja_generator_transfer_check',
    'f_igosja_generator_rent',
    'f_igosja_generator_rent_check',
    'f_igosja_generator_tire_base_level',
    'f_igosja_generator_game_row_reset',
    'f_igosja_generator_mood_reset',
    'f_igosja_generator_national_user_day',
    'f_igosja_generator_national_player_day',
    'f_igosja_generator_user_decrement_auto_for_vocation',
    'f_igosja_generator_user_fire',
    'f_igosja_generator_user_holiday_end',
    'f_igosja_generator_national_vote_status',
    'f_igosja_generator_national_vice_vote_status',
    'f_igosja_generator_national_fire',
    'f_igosja_generator_president_vote_status',
    'f_igosja_generator_president_vice_vote_status',
    'f_igosja_generator_president_fire',
    'f_igosja_generator_president_vice_fire',
    'f_igosja_generator_referrer_bonus',
    'f_igosja_generator_new_season',
    'f_igosja_generator_player_league_power',
    'f_igosja_generator_player_price_and_salary',
    'f_igosja_generator_player_power_s',
    'f_igosja_generator_player_real_power',
    'f_igosja_generator_salary',
    'f_igosja_generator_team_vs',
    'f_igosja_generator_team_price',
    'f_igosja_generator_team_age',
    'f_igosja_generator_team_player',
    'f_igosja_generator_country_stadium',
    'f_igosja_generator_user_rating_total',
    'f_igosja_generator_rating',
    'f_igosja_generator_news',
    'f_igosja_generator_president_vip',
    'f_igosja_generator_friendlyinvite_delete',
    'f_igosja_generator_user_fire_extra_team',
    'f_igosja_generator_national_stadium',
    'f_igosja_generator_set_free_player_on_transfer',
    'f_igosja_generator_snapshot',
    'f_igosja_generator_site_open',
);

for ($i=0, $count_function=count($function_array); $i<$count_function; $i++)
{
    $function_array[$i]();

    f_igosja_console_progress($i+1, $count_function, $function_array[$i]);
}

print "\r\n"
    . 'Time ' . round(microtime(true) - $start_time, 5) . ' sec. at ' . date('H:i:s') . "\r\n"
    . 'Database queries: ' . f_igosja_get_count_query() . "\r\n"
    . 'Memory usage: ' . number_format(memory_get_peak_usage(), 0, ",", " ") . ' bytes' . "\r\n";