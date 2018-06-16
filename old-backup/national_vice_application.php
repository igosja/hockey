<?php

/**
 * @var $auth_country_id integer
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (!$auth_country_id)
{
    redirect('/team_ask.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

if ($num_get != $auth_country_id)
{
    redirect('/wrong_page.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

if (!$type_get = (int) f_igosja_request_get('type'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/country_view.php');

$sql = "SELECT COUNT(`national_id`) AS `check`
        FROM `national`
        WHERE `national_country_id`=$num_get
        AND `national_nationaltype_id`=$type_get
        AND `national_user_id`!=0
        AND `national_vice_id`=0
        LIMIT 1";
$check_sql = f_igosja_mysqli_query($sql);

$chech_array = $check_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $chech_array[0]['check'])
{
    redirect('/wrong_page.php');
}

$sql = "SELECT COUNT(`electionnationalvice_id`) AS `check`
        FROM `electionnationalvice`
        WHERE `electionnationalvice_country_id`=$num_get
        AND `electionnationalvice_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
        AND `electionnationalvice_nationaltype_id`=$type_get";
$check_sql = f_igosja_mysqli_query($sql);

$chech_array = $check_sql->fetch_all(MYSQLI_ASSOC);

if ($chech_array[0]['check'])
{
    redirect('/national_vice_vote.php?num=' . $num_get . '&type=' . $type_get);
}

$sql = "SELECT COUNT(`national_id`) AS `check`
        FROM `national`
        WHERE `national_user_id`=$auth_user_id
        OR `national_vice_id`=$auth_user_id";
$check_sql = f_igosja_mysqli_query($sql);

$check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

if (0 != $check_array[0]['check'])
{
    f_igosja_session_front_flash_set('error', 'Можно быть тренером или заместителем тренера только в одной сборной.');

    redirect('/team_view.php');
}

$sql = "SELECT `electionnationalvice_id`
        FROM `electionnationalvice`
        WHERE `electionnationalvice_country_id`=$num_get
        AND `electionnationalvice_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
        AND `electionnationalvice_nationaltype_id`=$type_get
        LIMIT 1";
$electionnationalvice_sql = f_igosja_mysqli_query($sql);

if ($electionnationalvice_sql->num_rows)
{
    $electionnationalvice_array = $electionnationalvice_sql->fetch_all(MYSQLI_ASSOC);

    $electionnationalvice_id = $electionnationalvice_array[0]['electionnationalvice_id'];
}
else
{
    $sql = "INSERT INTO `electionnationalvice`
            SET `electionnationalvice_country_id`=$num_get,
                `electionnationalvice_date`=UNIX_TIMESTAMP(),
                `electionnationalvice_nationaltype_id`=$type_get";
    f_igosja_mysqli_query($sql);

    $electionnationalvice_id = $mysqli->insert_id;
}

if ($data = f_igosja_request_post('data'))
{
    $text = trim($data['text']);

    if (empty($text))
    {
        $error_array[] = 'Добавьте текст программы';
    }

    if (!isset($error_array))
    {
        $sql = "SELECT `electionnationalviceapplication_id`
                FROM `electionnationalviceapplication`
                WHERE `electionnationalviceapplication_user_id`=$auth_user_id
                AND `electionnationalviceapplication_electionnationalvice_id`=$electionnationalvice_id";
        $electionnationalviceapplication_sql = f_igosja_mysqli_query($sql);

        if ($electionnationalviceapplication_sql->num_rows)
        {
            $electionnationalviceapplication_array = $electionnationalviceapplication_sql->fetch_all(MYSQLI_ASSOC);

            $electionnationalviceapplication_id = $electionnationalviceapplication_array[0]['electionnationalviceapplication_id'];

            $sql = "UPDATE `electionnationalviceapplication`
                    SET `electionnationalviceapplication_text`=?
                    WHERE `electionnationalviceapplication_id`=$electionnationalviceapplication_id
                    LIMIT 1";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();
        }
        else
        {
            $sql = "INSERT INTO `electionnationalviceapplication`
                    SET `electionnationalviceapplication_date`=UNIX_TIMESTAMP(),
                        `electionnationalviceapplication_electionnationalvice_id`=$electionnationalvice_id,
                        `electionnationalviceapplication_text`=?,
                        `electionnationalviceapplication_user_id`=$auth_user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();

            $electionnationalviceapplication_id = $mysqli->insert_id;
        }

        f_igosja_session_front_flash_set('success', 'Изменения успшено сохранены.');

        refresh();
    }
}

$sql = "SELECT `electionnationalviceapplication_id`,
               `electionnationalviceapplication_text`
        FROM `electionnationalviceapplication`
        WHERE `electionnationalviceapplication_electionnationalvice_id`=$electionnationalvice_id
        AND `electionnationalviceapplication_user_id`=$auth_user_id
        LIMIT 1";
$electionnationalviceapplication_sql = f_igosja_mysqli_query($sql);

$electionnationalviceapplication_array = $electionnationalviceapplication_sql->fetch_all(MYSQLI_ASSOC);

if ($electionnationalviceapplication_sql->num_rows)
{
    $electionnationalviceapplication_id = $electionnationalviceapplication_array[0]['electionnationalviceapplication_id'];
}

$seo_title          = 'Подача заявки на заместителя сборной';
$seo_description    = 'Подача заявки на заместителя сборной на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'подача заявки на заместителя сборной';

include(__DIR__ . '/view/layout/main.php');