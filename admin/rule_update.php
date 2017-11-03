<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `rule_id`,
               `rule_text`,
               `rule_title`
        FROM `rule`
        WHERE `rule_id`=$num_get
        LIMIT 1";
$rule_sql = f_igosja_mysqli_query($sql);

$rule_array = $rule_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $rule_sql->num_rows)
{
    redirect('/wrong_page.php');
}

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'rule_order',
        'rule_text',
        'rule_title'
    ), true);

    $sql = "UPDATE `rule`
            SET $set_sql,
                `rule_date`=UNIX_TIMESTAMP()
            WHERE `rule_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/rule_view.php?num=' . $num_get);
}

$breadcrumb_array[] = array('url' => 'rule_list.php', 'text' => 'Правила');
$breadcrumb_array[] = array(
    'url' => 'rule_view.php?num=' . $rule_array[0]['rule_id'],
    'text' => $rule_array[0]['rule_title']
);
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');