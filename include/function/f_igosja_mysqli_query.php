<?php

/**
 * Обгортка для запиту в БД для ведення лога запитів
 * @param $sql string текст запиту в БД
 * @param $save boolean мітка, чи зберігати запит в лог
 * @return mysqli_result об'ект с результатом запиту $mysqli->query($sql)
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
        $result     = $mysqli->query($sql) or die('<pre>' . $mysqli->error . '<pre>' . $sql);
        $time       = round(microtime(true) - $start_time, 5);

        if ($time > 1)
        {
            $trace  = debug_backtrace();
            $file   = $trace[0]['file'];
            $file   = str_replace(realpath(__DIR__ . '/../../'), '', $file);

            $query_array[] = array(
                'file'  => $file,
                'line'  => $trace[0]['line'],
                'sql'   => $sql,
                'time'  => $time,
            );
        }
    }
    else
    {
        $result = $mysqli->query($sql) or die('<pre>' . $mysqli->error . '<pre>' . $sql);
    }

    return $result;
}