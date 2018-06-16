<?php

/**
 * @var $site_array array
 */

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    if (1 == $num_get)
    {
        $version_1 = $site_array[0]['site_version_1'] + 1;
        $version_2 = 0;
        $version_3 = 0;
        $version_4 = 0;
    }
    elseif (2 == $num_get)
    {
        $version_1 = $site_array[0]['site_version_1'];
        $version_2 = $site_array[0]['site_version_2'] + 1;
        $version_3 = 0;
        $version_4 = 0;
    }
    elseif (3 == $num_get)
    {
        $version_1 = $site_array[0]['site_version_1'];
        $version_2 = $site_array[0]['site_version_2'];
        $version_3 = $site_array[0]['site_version_3'] + 1;
        $version_4 = 0;
    }
    else
    {
        $version_1 = $site_array[0]['site_version_1'];
        $version_2 = $site_array[0]['site_version_2'];
        $version_3 = $site_array[0]['site_version_3'];
        $version_4 = $site_array[0]['site_version_4'] + 1;
    }

    $sql = "UPDATE `site`
            SET `site_version_1`=$version_1,
                `site_version_2`=$version_2,
                `site_version_3`=$version_3,
                `site_version_4`=$version_4,
                `site_version_date`=UNIX_TIMESTAMP()
            WHERE `site_id`=1
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/site_version.php');
}

$breadcrumb_array[] = 'Версия сайта';

include(__DIR__ . '/view/layout/main.php');