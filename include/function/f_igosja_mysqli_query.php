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

    $count_query++;

    if ($save)
    {
        $trace = debug_backtrace();
        $file = $trace[0]['file'];
        $file = str_replace(realpath(__DIR__ . '/../../'), '', $file);
        $dbg = "INSERT INTO `debug`
                SET `debug_file`=?,
                    `debug_line`=?,
                    `debug_sql`=?";
        $prepare = $mysqli->prepare($dbg);
        $prepare->bind_param('sis', $file, $trace[0]['line'], $sql);
        $prepare->execute();
        $prepare->close();

        $debug_id = $mysqli->insert_id;

        $start_time = microtime(true);

        $result = $mysqli->query($sql) or die($mysqli->error . ' ' . $sql);

        $time = round(microtime(true) - $start_time, 5);
        $time = $time * 1000;

        $dbg = "UPDATE `debug`
                SET `debug_time`=$time
                WHERE `debug_id`=$debug_id
                LIMIT 1";
        $mysqli->query($dbg);
    }
    else
    {
        $result = $mysqli->query($sql) or die($mysqli->error . ' ' . $sql);
    }

    return $result;
}