<?php

include(__DIR__ . '/../include/include.php');

$sql = "SELECT `prenews_error`,
               `prenews_new`
        FROM `prenews`
        WHERE `prenews_id`=1
        LIMIT 1";
$prenews_sql = f_igosja_mysqli_query($sql);

if (0 == $prenews_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$prenews_array = $prenews_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Предварительные новости';

include(__DIR__ . '/view/layout/main.php');