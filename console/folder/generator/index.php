<?php

include (__DIR__ . '/../../../include/generator.php');

f_igosja_generator_site_close();
f_igosja_generator_check_lineup();
f_igosja_generator_fill_lineup();
f_igosja_generator_site_open();

print "\r\n"
    . 'Time ' . round(microtime(true) - $start_time, 5) . ' sec. at ' . date('H:i:s') . "\r\n"
    . 'Database queries: ' . $count_sql . "\r\n"
    . 'Memory usage: ' . number_format(memory_get_usage(), 0, ",", " ") . ' bytes';