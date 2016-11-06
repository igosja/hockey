<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

$sql = "SELECT `tournamenttype_id`,
               `tournamenttype_name`
        FROM `tournamenttype`
        WHERE `tournamenttype_id`='$num_get'
        LIMIT 1";
$tournamenttype_sql = igosja_db_query($sql);

if (0 == $tournamenttype_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$tournamenttype_array = $tournamenttype_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'tournamenttype_list.php', 'text' => 'Типы турниров');
$breadcrumb_array[] = $tournamenttype_array[0]['tournamenttype_name'];

include (__DIR__ . '/view/layout/main.php');