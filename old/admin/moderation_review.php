<?php

include(__DIR__ . '/../include/include.php');

$sql = "SELECT `review_id`,
               `review_text`,
               `user_id`,
               `user_login`
        FROM `review`
        LEFT JOIN `user`
        ON `review_user_id`=`user_id`
        WHERE `review_check`=0
        ORDER BY `review_id` ASC
        LIMIT 1";
$review_sql = f_igosja_mysqli_query($sql);

if (0 == $review_sql->num_rows)
{
    redirect('/admin/index.php');
}

$review_array = $review_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'moderation_review.php', 'text'  => 'Модерация');
$breadcrumb_array[] = 'Обзоры туров';

include(__DIR__ . '/view/layout/main.php');