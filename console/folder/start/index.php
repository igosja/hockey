<?php

include(__DIR__ . '/../../../include/start.php');

$function_array = array(
    'f_igosja_start_insert_user',
    'f_igosja_start_insert_name',
    'f_igosja_start_insert_surname',
    'f_igosja_start_insert_team',
    'f_igosja_start_insert_national',
    'f_igosja_start_insert_schedule',
    'f_igosja_start_insert_offseason',
    'f_igosja_start_insert_championship',
    'f_igosja_start_insert_conference',
);

for ($i=0, $count_function=count($function_array); $i<$count_function; $i++)
{
    $function_array[$i]();

    f_igosja_console_progress($i+1, $count_function, $function_array[$i]);
}

print "\r\n"
    . 'Time ' . round(microtime(true) - $start_time, 5) . ' sec. at ' . date('H:i:s') . "\r\n"
    . 'Database queries: ' . f_igosja_get_count_query() . "\r\n"
    . 'Memory usage: ' . number_format(memory_get_usage(), 0, ",", " ") . ' bytes' . "\r\n";