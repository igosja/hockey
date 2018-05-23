<?php

/**
 * @var $auth_date_block_comment integer
 * @var $auth_date_block_forum integer
 * @var $auth_user_id integer
 */

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
$forumtheme_sql = f_igosja_mysqli_query($sql);

if (0 == $forumtheme_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forumtheme_array = $forumtheme_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    if (isset($auth_user_id) && isset($data['text']) && $auth_date_block_forum < time() && $auth_date_block_comment < time())
    {
        $text = trim($data['text']);

        if (!empty($text))
        {
            $publish = true;

            $text = htmlspecialchars($text);

            $sql = "SELECT `forummessage_text`,
                           `forummessage_user_id`
                    FROM `forummessage`
                    WHERE `forummessage_forumtheme_id`=$num_get
                    ORDER BY `forummessage_id` DESC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            if (0 != $check_sql->num_rows)
            {
                $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                if ($auth_user_id == $check_array[0]['forummessage_user_id'] && $text == $check_array[0]['forummessage_text'])
                {
                    $publish = false;
                }
            }

            if ($publish)
            {
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
                f_igosja_mysqli_query($sql);

                $forumgroup_id = $forumtheme_array[0]['forumgroup_id'];

                $sql = "UPDATE `forumgroup`
                        SET `forumgroup_count_message`=`forumgroup_count_message`+1,
                            `forumgroup_last_date`=UNIX_TIMESTAMP(),
                            `forumgroup_last_forummessage_id`=$forummessage_id,
                            `forumgroup_last_forumtheme_id`=$num_get,
                            `forumgroup_last_user_id`=$auth_user_id
                        WHERE `forumgroup_id`=$forumgroup_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                f_igosja_session_front_flash_set('success', 'Сообщение успешно добавлено.');
            }
            else
            {
                f_igosja_session_front_flash_set('error', 'Нельзя писать подряд два одинаковых сообщения.');
            }
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

$sql = "SELECT `forummessage_blocked`,
               `forummessage_date`,
               `forummessage_date_update`,
               `forummessage_id`,
               `forummessage_text`,
               `user_date_register`,
               `user_id`,
               `user_login`,
               `user_rating`,
               `user_userrole_id`
        FROM `forummessage`
        LEFT JOIN `user`
        ON `forummessage_user_id`=`user_id`
        WHERE `forummessage_forumtheme_id`=$num_get
        ORDER BY `forummessage_id` ASC
        LIMIT 1";
$forumheader_sql = f_igosja_mysqli_query($sql);

$forumheader_array = $forumheader_sql->fetch_all(MYSQLI_ASSOC);

if (0 != $forumheader_sql->num_rows)
{
    $forumheader_id = $forumheader_array[0]['forummessage_id'];
}
else
{
    $forumheader_id = 0;
}

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `forummessage_blocked`,
               `forummessage_date`,
               `forummessage_date_update`,
               `forummessage_id`,
               `forummessage_text`,
               `user_date_register`,
               `user_id`,
               `user_login`,
               `user_rating`,
               `user_userrole_id`
        FROM `forummessage`
        LEFT JOIN `user`
        ON `forummessage_user_id`=`user_id`
        WHERE `forummessage_forumtheme_id`=$num_get
        AND `forummessage_id`!=$forumheader_id
        ORDER BY `forummessage_id` ASC
        LIMIT $offset, $limit";
$forummessage_sql = f_igosja_mysqli_query($sql);

$forummessage_array = $forummessage_sql->fetch_all(MYSQLI_ASSOC);

$forummessage_array = array_merge($forumheader_array, $forummessage_array);

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

$sql = "UPDATE `forumtheme`
        SET `forumtheme_count_view`=`forumtheme_count_view`+1
        WHERE `forumtheme_id`=$num_get
        LIMIT 1";
f_igosja_mysqli_query($sql);

$seo_title          = $forumtheme_array[0]['forumtheme_name'] . ' - Форум';
$seo_description    = $forumtheme_array[0]['forumtheme_name'] . ' - Форум сайта Вирутальной Хоккейной Лиги.';
$seo_keywords       = $forumtheme_array[0]['forumtheme_name'] . ' форум';

include(__DIR__ . '/view/layout/main.php');