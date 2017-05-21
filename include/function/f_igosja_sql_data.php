<?php

/**
 * Обгортка для отримання sql рядка після submit форми
 * `key`='value', `key`='value', `key`='value'
 * Використовуєсть тільки в админці як небезпечна штука
 * @param $data array $_POST після submit форми
 * @return string рядок для вставки в запит
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