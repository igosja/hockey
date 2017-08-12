<?php

include(__DIR__ . '/../../../include/start.php');

for ($i=1, $count_file_list=count($file_list); $i<=$count_file_list; $i++)
{
    if     ( 1 == $i) { f_igosja_start_insert_user(); }
    elseif ( 2 == $i) { f_igosja_start_insert_name(); }
    elseif ( 3 == $i) { f_igosja_start_insert_surname(); }
    elseif ( 4 == $i) { f_igosja_start_insert_team(); }
    elseif ( 5 == $i) { f_igosja_start_insert_national(); }
    elseif ( 6 == $i) { f_igosja_start_insert_schedule(); }
    elseif ( 7 == $i) { f_igosja_start_insert_offseason(); }
    elseif ( 8 == $i) { f_igosja_start_insert_championship(); }
    elseif ( 9 == $i) { f_igosja_start_insert_conference(); }

    f_igosja_console_progress($i, count($file_list));
}

print "\r\n"
    . 'Time ' . round(microtime(true) - $start_time, 5) . ' sec. at ' . date('H:i:s') . "\r\n"
    . 'Database queries: ' . f_igosja_get_count_query() . "\r\n"
    . 'Memory usage: ' . number_format(memory_get_usage(), 0, ",", " ") . ' bytes' . "\r\n";