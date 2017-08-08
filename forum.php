<?php

/**
 * @var $auth_country_id integer
 */

include(__DIR__ . '/include/include.php');

$forum_array = array();

$sql = "SELECT `forumchapter_id`,
               `forumchapter_name`
        FROM `forumchapter`
        ORDER BY `forumchapter_order` ASC";
$forumchapter_sql = f_igosja_mysqli_query($sql);

$forumchapter_array = $forumchapter_sql->fetch_all(1);

foreach ($forumchapter_array as $item)
{
    $forumchapter_id = $item['forumchapter_id'];

    if (FORUMGROUP_NATIONAL != $forumchapter_id)
    {
        $sql = "SELECT `forumgroup_count_message`,
                   `forumgroup_count_theme`,
                   `forumgroup_description`,
                   `forumgroup_id`,
                   `forumgroup_name`,
                   `forumgroup_last_date`,
                   `forumtheme_name`,
                   `user_id`,
                   `user_login`
            FROM `forumgroup`
            LEFT JOIN `forumtheme`
            ON `forumgroup_last_forumtheme_id`=`forumtheme_id`
            LEFT JOIN `user`
            ON `forumgroup_last_user_id`=`user_id`
            WHERE `forumgroup_forumchapter_id`=$forumchapter_id
            ORDER BY `forumgroup_order` ASC";
    }
    else
    {
        if (!isset($auth_country_id))
        {
            $auth_country_id = 0;
        }

        $sql = "SELECT `forumgroup_count_message`,
                       `forumgroup_count_theme`,
                       `forumgroup_description`,
                       `forumgroup_id`,
                       `forumgroup_name`,
                       `forumgroup_last_date`,
                       `forumtheme_name`,
                       `user_id`,
                       `user_login`
                FROM `forumgroup`
                LEFT JOIN `forumtheme`
                ON `forumgroup_last_forumtheme_id`=`forumtheme_id`
                LEFT JOIN `user`
                ON `forumgroup_last_user_id`=`user_id`
                WHERE `forumgroup_forumchapter_id`=$forumchapter_id
                AND `forumgroup_country_id`=$auth_country_id
                ORDER BY `forumgroup_order` ASC";
    }

    $forumgroup_sql = f_igosja_mysqli_query($sql);

    $forumgroup_array = $forumgroup_sql->fetch_all(1);

    $forum_array[] = array(
        'forumchapter_id' => $forumchapter_id,
        'forumchapter_name' => $item['forumchapter_name'],
        'forumgroup' => $forumgroup_array,
    );
}

$seo_title          = 'Форум';
$seo_description    = 'Форум сайта Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'Форум';

include(__DIR__ . '/view/layout/main.php');