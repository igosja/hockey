<?php

/**
 * Обертка для получения sql строки после submit формы
 * `key`='value', `key`='value', `key`='value'
 * Используется только в админке как не безопасная вещь
 * @param $data array $_POST после submit формы
 * @return string строка для вставки в запрос
 */
function f_igosja_sql_data($data)
{
    $sql = array();

    foreach ($data as $key => $value)
    {
        $sql[] = '`' . $key . '`=\'' . $value . '\'';
    }

    $sql = implode(', ', $sql);

    return $sql;
}