<?php

include(__DIR__ . '/../../../include/generator.php');

for ($i=1, $count_file_list=count($file_list); $i<=$count_file_list; $i++)
{
    if     ( 1 == $i) { f_igosja_generator_site_close(); }
    elseif ( 2 == $i) { f_igosja_generator_player_power_new_to_old(); }
    elseif ( 3 == $i) { f_igosja_generator_check_lineup(); }
    elseif ( 4 == $i) { f_igosja_generator_fill_lineup(); }
    elseif ( 5 == $i) { f_igosja_generator_set_auto(); }
    elseif ( 6 == $i) { f_igosja_generator_set_ticket_price(); }
    elseif ( 7 == $i) { f_igosja_generator_count_visitor(); }
    elseif ( 8 == $i) { f_igosja_generator_finance_stadium(); }
    elseif ( 9 == $i) { f_igosja_generator_team_to_statistic(); }
    elseif (10 == $i) { f_igosja_generator_user_to_rating(); }
    elseif (11 == $i) { f_igosja_generator_lineup_to_statistic(); }
    elseif (12 == $i) { f_igosja_generator_game_result(); }
    elseif (13 == $i) { f_igosja_generator_update_team_statistic(); }
    elseif (14 == $i) { f_igosja_generator_update_player_statistic(); }
    elseif (15 == $i) { f_igosja_generator_user_rating(); }
    elseif (16 == $i) { f_igosja_generator_team_visitor_after_game(); }
    elseif (17 == $i) { f_igosja_generator_team_visitor(); }
    elseif (18 == $i) { f_igosja_generator_plus_minus(); }
    elseif (19 == $i) { f_igosja_generator_decrease_teamwork(); }
    elseif (20 == $i) { f_igosja_generator_standing(); }
    elseif (21 == $i) { f_igosja_generator_standing_place(); }
    elseif (22 == $i) { f_igosja_generator_participant_championship(); }
    elseif (23 == $i) { f_igosja_generator_achievement(); }
    elseif (24 == $i) { f_igosja_generator_player_game_row(); }
    elseif (25 == $i) { f_igosja_generator_player_tire(); }
    elseif (26 == $i) { f_igosja_generator_training(); }
    elseif (27 == $i) { f_igosja_generator_phisical(); }
    elseif (28 == $i) { f_igosja_generator_school(); }
    elseif (29 == $i) { f_igosja_generator_building_base(); }
    elseif (30 == $i) { f_igosja_generator_building_stadium(); }
    elseif (31 == $i) { f_igosja_generator_decrease_injury(); }
    elseif (32 == $i) { f_igosja_generator_set_injury(); }
    elseif (33 == $i) { f_igosja_generator_make_played(); }
    elseif (34 == $i) { f_igosja_generator_swiss(); }
    elseif (35 == $i) { f_igosja_generator_rent_decrease_return(); }
    elseif (36 == $i) { f_igosja_generator_transfer(); }
    elseif (37 == $i) { f_igosja_generator_rent(); }
    elseif (38 == $i) { f_igosja_generator_player_price_and_salary(); }
    elseif (39 == $i) { f_igosja_generator_player_power_s(); }
    elseif (40 == $i) { f_igosja_generator_player_real_power(); }
    elseif (41 == $i) { f_igosja_generator_team_vs(); }
    elseif (42 == $i) { f_igosja_generator_team_price(); }
    elseif (43 == $i) { f_igosja_generator_user_deprive_team(); }
    elseif (44 == $i) { f_igosja_generator_user_holiday_end(); }
    elseif (45 == $i) { f_igosja_generator_national_vote_status(); }
    elseif (46 == $i) { f_igosja_generator_national_vice_vote_status(); }
    elseif (47 == $i) { f_igosja_generator_president_vote_status(); }
    elseif (48 == $i) { f_igosja_generator_president_vice_vote_status(); }
    elseif (49 == $i) { f_igosja_generator_site_open(); }

    f_igosja_console_progress($i, count($file_list));
}

//f_igosja_generator_prize();

print "\r\n"
    . 'Time ' . round(microtime(true) - $start_time, 5) . ' sec. at ' . date('H:i:s') . "\r\n"
    . 'Database queries: ' . f_igosja_get_count_query() . "\r\n"
    . 'Memory usage: ' . number_format(memory_get_usage(), 0, ",", " ") . ' bytes' . "\r\n";