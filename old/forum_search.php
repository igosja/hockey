<?php

/**
 * @var $auth_country_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$q = f_igosja_request_get('q'))
{
    redirect('/forum.php');
}

if (!$page = (int) f_igosja_request_get('page'))
{
    $page = 1;
}

$limit  = 20;
$offset = ($page - 1) * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `forumtheme_id`,
               `forummessage_date`,
               `forummessage_text`,
               `user_date_register`,
               `user_id`,
               `user_login`,
               `user_rating`,
               `user_userrole_id`
        FROM `forummessage`
        LEFT JOIN `forumtheme`
        ON `forummessage_forumtheme_id`=`forumtheme_id`
        LEFT JOIN `user`
        ON `forummessage_user_id`=`user_id`
        WHERE `forummessage_text` LIKE CONCAT('%', ?, '%')
        ORDER BY `forummessage_id` DESC
        LIMIT $offset, $limit";
$prepare = $mysqli->prepare($sql);
$prepare->bind_param('s', $q);
$prepare->execute();

$forummessage_sql = $prepare->get_result();

$prepare->close();

$forummessage_array = $forummessage_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count`";
$total = f_igosja_mysqli_query($sql);
$total = $total->fetch_all(MYSQLI_ASSOC);
$total = $total[0]['count'];

$count_page = ceil($total / $limit);

if ($forummessage_array)
{
    $user_id = array();

    foreach ($forummessage_array as $item)
    {
        $user_id[] = $item['user_id'];
    }

    $user_id = implode(', ', $user_id);

    $sql = "SELECT `city_name`,
                   `country_id`,
                   `country_name`,
                   `team_id`,
                   `team_name`,
                   `team_user_id`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            WHERE `team_user_id` IN ($user_id)";
    $userteam_sql = f_igosja_mysqli_query($sql);

    $userteam_array = $userteam_sql->fetch_all(MYSQLI_ASSOC);
}
else
{
    $userteam_array = array();
}

$seo_title          = 'Результаты поиска';
$seo_description    = 'Результаты поиска на форуме сайта Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'форум результаты поиска';

include(__DIR__ . '/view/layout/main.php');