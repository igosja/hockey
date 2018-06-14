<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `review_text`
        FROM `review`
        WHERE `review_id`=$num_get
        LIMIT 1";
$review_sql = f_igosja_mysqli_query($sql);

if (0 == $review_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$review_array = $review_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'review_text',
    ));

    $sql = "UPDATE `review`
            SET $set_sql
            WHERE `review_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/moderation_review.php');
}

$breadcrumb_array[] = array('url' => 'moderation_review.php', 'text'  => 'Модерация');
$breadcrumb_array[] = array('url' => 'moderation_review.php', 'text'  => 'Обзоры туров');
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');