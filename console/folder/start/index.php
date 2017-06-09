<?php

include(__DIR__ . '/../../../include/start.php');

f_igosja_start_insert_user();
f_igosja_start_insert_name();
f_igosja_start_insert_surname();
f_igosja_start_insert_team();
f_igosja_start_insert_national();
f_igosja_start_insert_shedule();
f_igosja_start_insert_offseason();
f_igosja_start_insert_championship();
f_igosja_start_insert_conference();

print "\r\n"
    . 'Time ' . round(microtime(true) - $start_time, 5) . ' sec. at ' . date('H:i:s') . "\r\n"
    . 'Database queries: ' . f_igosja_get_count_query() . "\r\n"
    . 'Memory usage: ' . number_format(memory_get_usage(), 0, ",", " ") . ' bytes' . "\r\n";