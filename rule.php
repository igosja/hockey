<?php

include (__DIR__ . '/include/include.php');

if ($num_get = (int) f_igosja_get('num'))
{
    $sql = "SELECT `rule_text`,
                   `rule_title`
            FROM `rule`
            WHERE `rule_id`='$num_get'
            LIMIT 1";
    $rule_sql = igosja_db_query($sql);

    if (0 == $rule_sql->num_rows)
    {
        redirect('/wrong_page.php');
    }
}
else
{
    $sql = "SELECT `rule_id`,
                   `rule_title`
            FROM `rule`
            ORDER BY `rule_order` DESC";
    $rule_sql = igosja_db_query($sql);
}

$rule_array = $rule_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');