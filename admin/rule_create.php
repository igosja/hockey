<?php

include (__DIR__ . '/../include/include.php');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "INSERT INTO `rule`
            SET $set_sql,
                `rule_date`=UNIX_TIMESTAMP()";
    igosja_db_query($sql);

    redirect('/admin/rule_view.php?num=' . $mysqli->insert_id);
}

$breadcrumb_array[] = array('url' => 'rule_list.php', 'text' => 'Правила');
$breadcrumb_array[] = 'Создание';

$tpl = 'rule_update';

include (__DIR__ . '/view/layout/main.php');