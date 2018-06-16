<?php

/**
 * Кількість запитів до БД
 * @return integer кількість запитів
 */
function f_igosja_get_count_query()
{
    global $count_query;
    global $mysqli;
    global $query_array;

    foreach ($query_array as $item)
    {
        $time   = $item['time'] * 1000;

        $dbg = "INSERT INTO `debug`
                SET `debug_file`=?,
                    `debug_line`=?,
                    `debug_sql`=?,
                    `debug_time`=$time";
        $prepare = $mysqli->prepare($dbg);
        $prepare->bind_param('sis', $item['file'], $item['line'], $item['sql']);
        $prepare->execute();
        $prepare->close();
    }

    return $count_query;
}