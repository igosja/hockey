<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `rule_id`,
               `rule_title`
        FROM `rule`
        ORDER BY `rule_order` ASC, `rule_id` ASC";
$rule_sql = f_igosja_mysqli_query($sql);

$rule_array = $rule_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Правила';
$seo_description    = 'Правила на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'правила';

include(__DIR__ . '/view/layout/main.php');