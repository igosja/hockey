<?php

/**
 * Вывод количества запросов к БД за время работы скрипта
 * @return integer количество запросов
 */
function f_igosja_get_count_query()
{
    global $count_query;
    global $mysqli;
    global $query_array;

    foreach ($query_array as $item)
    {
        $sql    = addslashes($item['sql']);
        $time   = $item['time'] * 1000;

        $sql = "INSERT INTO `debug`
                SET `debug_time`='$time',
                    `debug_sql`='$sql'";
        $mysqli->query($sql);
    }

    return $count_query;
}