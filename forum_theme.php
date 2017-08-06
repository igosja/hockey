<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `forumtheme_forumgroup_id`,
               `forumtheme_name`
        FROM `forumtheme`
        WHERE `forumtheme_id`=$num_get
        LIMIT 1";
$forumtheme_sql = f_igosja_mysqli_query($sql);

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

            $forumgroup_id = $forumtheme_array[0]['forumtheme_forumgroup_id'];

            $sql = "UPDATE `forumgroup`
                    SET `forumgroup_count_message`=`forumgroup_count_message`+1,
                        `forumgroup_last_date`=UNIX_TIMESTAMP(),
                        `forumgroup_last_forummessage_id`=$forummessage_id,
                        `forumgroup_last_forumtheme_id`=$num_get,
                        `forumgroup_last_user_id`=$auth_user_id
                    WHERE `forumgroup_id`=$forumgroup_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $_SESSION['message']['class'] = 'success';
            $_SESSION['message']['text'] = 'Сообщение успешно добавлено.';
        }
    }

    refresh();
}

$sql = "SELECT `forummessage_date`,
               `forummessage_text`,
               `user_id`,
               `user_login`
        FROM `forummessage`
        LEFT JOIN `user`
        ON `forummessage_user_id`=`user_id`
        WHERE `forummessage_forumtheme_id`=$num_get
        ORDER BY `forummessage_id` ASC";
$forummessage_sql = f_igosja_mysqli_query($sql);

$forummessage_array = $forummessage_sql->fetch_all(1);

$sql = "UPDATE `forumtheme`
        SET `forumtheme_count_view`=`forumtheme_count_view`+1
        WHERE `forumtheme_id`=$num_get
        LIMIT 1";
f_igosja_mysqli_query($sql);

$seo_title          = $forumtheme_array[0]['forumtheme_name'] . ' - Форум';
$seo_description    = $forumtheme_array[0]['forumtheme_name'] . ' - Форум сайта Вирутальной Хоккейной Лиги.';
$seo_keywords       = $forumtheme_array[0]['forumtheme_name'] . ' форум';

include(__DIR__ . '/view/layout/main.php');