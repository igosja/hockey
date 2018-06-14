<?php

/**
 * Обгортка для отримання sql рядка після submit форми
 * `key`='value', `key`='value', `key`='value'
 * Використовуєсть тільки в админці як небезпечна штука
 * @param $data array $_POST після submit форми
 * @param $field_array array список полів, які слід вибрати з $_POST
 * @param $allow_tags boolean чи дозволено вставляти html напряму
 * @return string рядок для вставки в запит
 */
function f_igosja_sql_data($data, $field_array = array(), $allow_tags = false)
{
    global $mysqli;

    $sql = array();

    foreach ($data as $key => $value)
    {
        if (in_array($key, $field_array))
        {
            $value = $mysqli->real_escape_string($value);

            if (!$allow_tags)
            {
                $value = htmlspecialchars($value);
            }

            $sql[] = '`' . $key . '`=\'' . $value . '\'';
        }
    }

    $sql = implode(', ', $sql);

    return $sql;
}