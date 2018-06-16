<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `money_date`,
               `money_value`,
               `money_value_after`,
               `money_value_before`,
               `moneytext_name`
        FROM `money`
        LEFT JOIN `moneytext`
        ON `money_moneytext_id`=`moneytext_id`
        WHERE `money_user_id`=$auth_user_id
        ORDER BY `money_id` DESC";
$money_sql = f_igosja_mysqli_query($sql);

$money_array = $money_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'История платежей';
$seo_description    = 'История платежей на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'история платежей';

include(__DIR__ . '/view/layout/main.php');