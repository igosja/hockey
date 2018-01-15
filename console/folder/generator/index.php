<?php

include(__DIR__ . '/../../../include/generator.php');

$function_array = array(
    'f_igosja_generator_site_close',
    'f_igosja_generator_player_power_new_to_old',
    'f_igosja_generator_check_mood_limit',
    'f_igosja_generator_check_lineup',
    'f_igosja_generator_fill_lineup',
    'f_igosja_generator_set_auto',
    'f_igosja_generator_set_user_auto',
    'f_igosja_generator_set_ticket_price',
    'f_igosja_generator_count_visitor',
    'f_igosja_generator_finance_stadium',
    'f_igosja_generator_team_to_statistic',
    'f_igosja_generator_user_to_rating',
    'f_igosja_generator_lineup_to_statistic',
    'f_igosja_generator_game_result',
    'f_igosja_generator_update_team_statistic',
    'f_igosja_generator_update_player_statistic',
    'f_igosja_generator_user_rating',
    'f_igosja_generator_team_visitor_after_game',
    'f_igosja_generator_team_visitor',
    'f_igosja_generator_plus_minus',
    'f_igosja_generator_decrease_teamwork',
    'f_igosja_generator_standing',
    'f_igosja_generator_standing_place',
    'f_igosja_generator_achievement',
    'f_igosja_generator_prize',
    'f_igosja_generator_player_game_row',
    'f_igosja_generator_player_tire',
    'f_igosja_generator_training',
    'f_igosja_generator_phisical',
    'f_igosja_generator_school',
    'f_igosja_generator_scout',
    'f_igosja_generator_building_base',
    'f_igosja_generator_building_stadium',
    'f_igosja_generator_decrease_injury',
    'f_igosja_generator_set_injury',
    'f_igosja_generator_make_played',
    'f_igosja_generator_participant_championship',
    'f_igosja_generator_playoff_championship_add_game',
    'f_igosja_generator_playoff_championship_lot',
    'f_igosja_generator_swiss',
    'f_igosja_generator_rent_decrease_return',
    'f_igosja_generator_transfer',
    'f_igosja_generator_transfer_check',
    'f_igosja_generator_rent',
    'f_igosja_generator_tire_base_level',
    'f_igosja_generator_game_row_reset',
    'f_igosja_generator_mood_reset',
    'f_igosja_generator_player_league_power',
    'f_igosja_generator_player_price_and_salary',
    'f_igosja_generator_player_power_s',
    'f_igosja_generator_player_real_power',
    'f_igosja_generator_salary',
    'f_igosja_generator_team_vs',
    'f_igosja_generator_team_price',
    'f_igosja_generator_team_age',
    'f_igosja_generator_country_stadium',
    'f_igosja_generator_user_fire',
    'f_igosja_generator_user_holiday_end',
    'f_igosja_generator_national_vote_status',
    'f_igosja_generator_national_vice_vote_status',
    'f_igosja_generator_national_fire',
    'f_igosja_generator_president_vote_status',
    'f_igosja_generator_president_vice_vote_status',
    'f_igosja_generator_president_fire',
    'f_igosja_generator_rating',
    'f_igosja_generator_rating_change_player',
    'f_igosja_generator_rating_change_team',
    'f_igosja_generator_referrer_bonus',
    'f_igosja_generator_new_season',
    'f_igosja_generator_news',
    'f_igosja_generator_site_open',
);

for ($i=0, $count_function=count($function_array); $i<$count_function; $i++)
{
    $function_array[$i]();

    f_igosja_console_progress($i+1, $count_function);
}

print "\r\n"
    . 'Time ' . round(microtime(true) - $start_time, 5) . ' sec. at ' . date('H:i:s') . "\r\n"
    . 'Database queries: ' . f_igosja_get_count_query() . "\r\n"
    . 'Memory usage: ' . number_format(memory_get_peak_usage(), 0, ",", " ") . ' bytes' . "\r\n";