<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (!$type_get = (int) f_igosja_request_get('type'))
{
    redirect('/wrong_page.php');
}

if (!in_array($type_get, array(NATIONALTYPE_MAIN, NATIONALTYPE_21, NATIONALTYPE_19)))
{
    redirect('/wrong_page.php');
}

if ($country_id = f_igosja_request_post('country_id'))
{
    redirect('/national_application.php?type=' . $type_get . '&num=' . $country_id);
}

$sql = "SELECT `country_id`,
               `country_name`
        FROM `national`
        LEFT JOIN `country`
        ON `national_country_id`=`country_id`
        WHERE `national_nationaltype_id`=$type_get
        AND `national_user_id`=0
        ORDER BY `country_name`";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Подача заявки на управление сборной';
$seo_description    = 'Подача заявки на управление сборной на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'подача заявки на управление сборной';

include(__DIR__ . '/view/layout/main.php');