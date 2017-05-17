<?php

include (__DIR__ . '/../../../include/generator.php');

f_igosja_generator_site_close();
f_igosja_generator_check_lineup();
f_igosja_generator_fill_lineup();
f_igosja_generator_set_auto();
f_igosja_generator_set_ticket_price();
f_igosja_generator_count_visitor();
f_igosja_generator_finance_stadium();
f_igosja_generator_team_to_statistic();
f_igosja_generator_lineup_to_statistic();
f_igosja_generator_game_result();
f_igosja_generator_update_team_statistic();
f_igosja_generator_update_player_statistic();
f_igosja_generator_plus_minus();
f_igosja_generator_decrease_teamwork();
f_igosja_generator_standing();
f_igosja_generator_standing_place();
f_igosja_generator_player_game_row();
f_igosja_generator_player_tire();
f_igosja_generator_training();
f_igosja_generator_phisical();
f_igosja_generator_school();
f_igosja_generator_building_base();
f_igosja_generator_building_stadium();
f_igosja_generator_make_played();
f_igosja_generator_swiss();
f_igosja_generator_site_open();

print "\r\n"
    . 'Time ' . round(microtime(true) - $start_time, 5) . ' sec. at ' . date('H:i:s') . "\r\n"
    . 'Database queries: ' . f_igosja_get_count_query() . "\r\n"
    . 'Memory usage: ' . number_format(memory_get_usage(), 0, ",", " ") . ' bytes';