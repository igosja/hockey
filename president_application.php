<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT COUNT(`country_id`) AS `check`
        FROM `country`
        WHERE `country_id`=$num_get
        AND `country_president_id`=0
        LIMIT 1";
$check_sql = f_igosja_mysqli_query($sql);

$chech_array = $check_sql->fetch_all(1);

if (0 == $chech_array[0]['check'])
{
    redirect('/wrong_page.php');
}

if ($data = f_igosja_request_post('data'))
{
    $text = trim($data['text']);

    if (!empty($text))
    {
        $sql = "SELECT `applicationpresident_id`
                FROM `applicationpresident`
                WHERE `applicationpresident_country_id`=$num_get
                AND `applicationpresident_user_id`=$auth_user_id
                AND `applicationpresident_ready`=0";
        $applicationpresident_sql = f_igosja_mysqli_query($sql);

        if ($applicationpresident_sql->num_rows)
        {
            $applicationpresident_array = $applicationpresident_sql->fetch_all(1);

            $applicationpresident_id = $applicationpresident_array[0]['applicationpresident_id'];

            $sql = "UPDATE `applicationpresident`
                    SET `applicationpresident_text`=?
                    WHERE `applicationpresident_id`=$applicationpresident_id
                    LIMIT 1";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $data['text']);
            $prepare->execute();
        }
        else
        {
            $sql = "INSERT INTO `applicationpresident`
                    SET `applicationpresident_country_id`=$num_get,
                        `applicationpresident_date`=UNIX_TIMESTAMP(),
                        `applicationpresident_text`=?,
                        `applicationpresident_user_id`=$auth_user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $data['text']);
            $prepare->execute();
        }

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Изменения сохранены.';
    }

    refresh();
}

$sql = "SELECT `applicationpresident_text`
        FROM `applicationpresident`
        WHERE `applicationpresident_country_id`=$num_get
        AND `applicationpresident_user_id`=$auth_user_id
        AND `applicationpresident_ready`=0";
$applicationpresident_sql = f_igosja_mysqli_query($sql);

$applicationpresident_array = $applicationpresident_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');