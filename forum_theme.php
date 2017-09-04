<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `forumchapter_id`,
               `forumchapter_name`,
               `forumgroup_id`,
               `forumgroup_name`,
               `forumtheme_name`
        FROM `forumtheme`
        LEFT JOIN `forumgroup`
        ON `forumtheme_forumgroup_id`=`forumgroup_id`
        LEFT JOIN `forumchapter`
        ON `forumgroup_forumchapter_id`=`forumchapter_id`
        WHERE `forumtheme_id`=$num_get
        LIMIT 1";
$forumtheme_sql = f_igosja_mysqli_query($sql, false);

if (0 == $forumtheme_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forumtheme_array = $forumtheme_sql->fetch_all(1);

if ($data = f_igosja_request_post('data'))
{
    if (isset($auth_user_id) && isset($data['text']))
    {
        $text = trim($data['text']);

        if (!empty($text))
        {
            $text = htmlspecialchars($text);

            $sql = "INSERT INTO `forummessage`
                    SET `forummessage_date`=UNIX_TIMESTAMP(),
                        `forummessage_forumtheme_id`=$num_get,
                        `forummessage_text`=?,
                        `forummessage_user_id`=$auth_user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();
            $prepare->close();

            $forummessage_id = $mysqli->insert_id;

            $sql = "UPDATE `forumtheme`
                    SET `forumtheme_count_message`=`forumtheme_count_message`+1,
                        `forumtheme_last_date`=UNIX_TIMESTAMP(),
                        `forumtheme_last_forummessage_id`=$forummessage_id,
                        `forumtheme_last_user_id`=$auth_user_id
                    WHERE `forumtheme_id`=$num_get
                    LIMIT 1";
            f_igosja_mysqli_query($sql, false);

            $forumgroup_id = $forumtheme_array[0]['forumgroup_id'];

            $sql = "UPDATE `forumgroup`
                    SET `forumgroup_count_message`=`forumgroup_count_message`+1,
                        `forumgroup_last_date`=UNIX_TIMESTAMP(),
                        `forumgroup_last_forummessage_id`=$forummessage_id,
                        `forumgroup_last_forumtheme_id`=$num_get,
                        `forumgroup_last_user_id`=$auth_user_id
                    WHERE `forumgroup_id`=$forumgroup_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql, false);

            $_SESSION['message']['class'] = 'success';
            $_SESSION['message']['text'] = 'Сообщение успешно добавлено.';
        }
    }

    refresh();
}

if (!$page = (int) f_igosja_request_get('page'))
{
    $page = 1;
}

$limit  = 20;
$offset = ($page - 1) * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `city_name`,
               `country_id`,
               `country_name`,
               `forummessage_date`,
               `forummessage_text`,
               `team_id`,
               `team_name`,
               `user_date_register`,
               `user_id`,
               `user_login`,
               `user_rating`
        FROM `forummessage`
        LEFT JOIN `user`
        ON `forummessage_user_id`=`user_id`
        LEFT JOIN `team`
        ON `user_id`=`team_user_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `forummessage_forumtheme_id`=$num_get
        ORDER BY `forummessage_id` ASC
        LIMIT $offset, $limit";
$forummessage_sql = f_igosja_mysqli_query($sql, false);

$forummessage_array = $forummessage_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count`";
$total = f_igosja_mysqli_query($sql, false);
$total = $total->fetch_all(1);
$total = $total[0]['count'];

$count_page = ceil($total / $limit);

$sql = "UPDATE `forumtheme`
        SET `forumtheme_count_view`=`forumtheme_count_view`+1
        WHERE `forumtheme_id`=$num_get
        LIMIT 1";
f_igosja_mysqli_query($sql, false);

$seo_title          = $forumtheme_array[0]['forumtheme_name'] . ' - Форум';
$seo_description    = $forumtheme_array[0]['forumtheme_name'] . ' - Форум сайта Вирутальной Хоккейной Лиги.';
$seo_keywords       = $forumtheme_array[0]['forumtheme_name'] . ' форум';

include(__DIR__ . '/view/layout/main.php');