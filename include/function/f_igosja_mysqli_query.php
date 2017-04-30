<?php

/**
 * Обертка для запроса в БД для ведения лога запросов
 * @param $sql string текст запроса к БД
 * @param $save boolean сохранять ли текст запроса в лог
 * @return mysqli_result объект с результатом запроса $mysqli->query($sql)
 */
function f_igosja_mysqli_query($sql, $save = true)
{
    global $count_query;
    global $mysqli;
    global $query_array;

    $count_query++;

    if ($save)
    {
        $start_time = microtime(true);
        $result = $mysqli->query($sql) or die($mysqli->error);
        $time = round(microtime(true) - $start_time, 5);

        $query_array[] = array(
            'sql' => $sql,
            'time' => $time,
        );
    }
    else
    {
        $result = $mysqli->query($sql) or die($mysqli->error);
    }

    return $result;
}