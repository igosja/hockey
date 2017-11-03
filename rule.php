<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `rule_date`,
               `rule_text`,
               `rule_title`
        FROM `rule`
        WHERE `rule_id`=$num_get
        LIMIT 1";
$rule_sql = f_igosja_mysqli_query($sql);

if (0 == $rule_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$rule_array = $rule_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $rule_array[0]['rule_title'] . '. Правила';
$seo_description    = $rule_array[0]['rule_title'] . '. Правила на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $rule_array[0]['rule_title'] . ' правила';

include(__DIR__ . '/view/layout/main.php');