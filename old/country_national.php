<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (isset($auth_country_id))
    {
        if (!$num_get = $auth_country_id)
        {
            redirect('/wrong_page.php');
        }
    }
}

include(__DIR__ . '/include/sql/country_view.php');

$sql = "SELECT `nationaltype_id`,
               `nationaltype_name`
        FROM `nationaltype`
        ORDER BY `nationaltype_id` ASC";
$nationaltype_sql = f_igosja_mysqli_query($sql);

$nationaltype_array = $nationaltype_sql->fetch_all(MYSQLI_ASSOC);

if (!$nationaltype_get = (int) f_igosja_request_get('nationaltype'))
{
    $nationaltype_get = $nationaltype_array[0]['nationaltype_id'];
}

$sql = "SELECT `national_finance`,
               `national_id`,
               `nationaltype_name`,
               `user_id`,
               `user_login`
        FROM `national`
        LEFT JOIN `user`
        ON `national_user_id`=`user_id`
        LEFT JOIN `nationaltype`
        ON `national_nationaltype_id`=`nationaltype_id`
        WHERE `national_country_id`=$num_get
        AND `nationaltype_id`=$nationaltype_get
        LIMIT 1";
$national_sql = f_igosja_mysqli_query($sql);

if (0 == $national_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $country_array[0]['country_name'] . '. Сборные';
$seo_description    = $country_array[0]['country_name'] . '. Сборные на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $country_array[0]['country_name'] . ' сборные';

include(__DIR__ . '/view/layout/main.php');