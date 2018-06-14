<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT COUNT(`team_id`) AS `count_team`,
               `country_id`,
               `country_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `team_id`!=0
        GROUP BY `country_id`
        ORDER BY `country_id` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Список команд';
$seo_description    = 'Список команд на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'список команд';

include(__DIR__ . '/view/layout/main.php');