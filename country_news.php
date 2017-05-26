<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (isset($auth_team_id))
    {
        $sql = "SELECT `city_country_id`
                FROM `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                WHERE `team_id`=$auth_team_id
                LIMIT 1";
        $country_sql = f_igosja_mysqli_query($sql);

        if (0 == $country_sql->num_rows)
        {
            redirect('/wrong_page.php');
        }

        $country_array = $country_sql->fetch_all(1);

        if (!$num_get = $country_array[0]['city_country_id'])
        {
            redirect('/wrong_page.php');
        }
    }
}

include(__DIR__ . '/include/sql/country_view.php');

$sql = "SELECT IF(`count_newscomment`, `count_newscomment`, 0) AS `count_newscomment`,
               `news_date`,
               `news_id`,
               `news_text`,
               `news_title`,
               `user_id`,
               `user_login`
        FROM `news`
        LEFT JOIN `user`
        ON `news_user_id`=`user_id`
        LEFT JOIN
        (
            SELECT COUNT(`newscomment_id`) AS `count_newscomment`,
                   `newscomment_news_id`
            FROM `newscomment`
            GROUP BY `newscomment_news_id`
        ) AS `t1`
        ON `news_id`=`newscomment_news_id`
        WHERE `news_country_id`=$num_get
        ORDER BY `news_id` DESC";
$news_sql = f_igosja_mysqli_query($sql);

$news_array = $news_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');