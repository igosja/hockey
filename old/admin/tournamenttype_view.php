<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `tournamenttype_id`,
               `tournamenttype_name`
        FROM `tournamenttype`
        WHERE `tournamenttype_id`=$num_get
        LIMIT 1";
$tournamenttype_sql = f_igosja_mysqli_query($sql);

if (0 == $tournamenttype_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$tournamenttype_array = $tournamenttype_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'tournamenttype_list.php', 'text' => 'Типы турниров');
$breadcrumb_array[] = $tournamenttype_array[0]['tournamenttype_name'];

include(__DIR__ . '/view/layout/main.php');