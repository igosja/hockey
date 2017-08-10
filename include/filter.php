<?php

/**
 * @var $mysqli mysqli
 */

$filter     = f_igosja_request_get('filter');
$sql_filter = array(1);

if (is_array($filter))
{
    foreach ($filter as $key => $item)
    {
        if ($item)
        {
            if (is_numeric($item))
            {
                $sql_filter[] = '`' . $key . '`=' . (int) $item;
            }
            elseif (is_string($item))
            {
                $sql_filter[] = '`' . $key . '` LIKE \'%' . htmlspecialchars($mysqli->real_escape_string($item)) . '%\'';
            }
        }
    }
}

$sql_filter = implode(' AND ', $sql_filter);