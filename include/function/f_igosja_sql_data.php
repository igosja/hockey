<?php

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