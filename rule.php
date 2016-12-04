<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `rule_text`,
               `rule_title`
        FROM `rule`
        WHERE `rule_id`='$num_get'
        LIMIT 1";
$rule_sql = f_igosja_mysqli_query($sql);

if (0 == $rule_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$rule_array = $rule_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');