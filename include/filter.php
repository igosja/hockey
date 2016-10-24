<?php

$filter     = f_igosja_get('filter');
$sql_filter = array(1);

if (is_array($filter))
{
    foreach ($filter as $key => $item)
    {
        if ($item)
        {
            if (is_numeric($item))
            {
                $sql_filter[] = '`' . $key . '`=\'' . (int) $item . '\'';
            }
            elseif (is_string($item))
            {
                $sql_filter[] = '`' . $key . '` LIKE \'%' . $item . '%\'';
            }
        }
    }
}

$sql_filter = implode(' AND ', $sql_filter);

unset($filter);