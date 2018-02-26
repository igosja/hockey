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

include(__DIR__ . '/include/sql/country_view.php');

$sql = "SELECT COUNT(`country_id`) AS `check`
        FROM `country`
        WHERE `country_id`=$num_get
        AND `country_president_id`=0
        AND `country_vice_id`=0
        LIMIT 1";
$check_sql = f_igosja_mysqli_query($sql);

$chech_array = $check_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $chech_array[0]['check'])
{
    redirect('/wrong_page.php');
}

$sql = "SELECT COUNT(`electionpresident_id`) AS `check`
        FROM `electionpresident`
        WHERE `electionpresident_country_id`=$num_get
        AND `electionpresident_electionstatus_id`=" . ELECTIONSTATUS_OPEN;
$check_sql = f_igosja_mysqli_query($sql);

$check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

if ($check_array[0]['check'])
{
    redirect('/president_vote.php?num=' . $num_get);
}

$sql = "SELECT COUNT(`country_id`) AS `check`
        FROM `country`
        WHERE `country_president_id`=$auth_user_id
        OR `country_vice_id`=$auth_user_id";
$check_sql = f_igosja_mysqli_query($sql);

$check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

if (0 != $check_array[0]['check'])
{
    f_igosja_session_front_flash_set('error', 'Можно быть президентом или заместителем президента только в одной федерации.');

    redirect('/team_view.php');
}

$sql = "SELECT `electionpresident_id`
        FROM `electionpresident`
        WHERE `electionpresident_country_id`=$num_get
        AND `electionpresident_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
        LIMIT 1";
$electionpresident_sql = f_igosja_mysqli_query($sql);

if ($electionpresident_sql->num_rows)
{
    $electionpresident_array = $electionpresident_sql->fetch_all(MYSQLI_ASSOC);

    $electionpresident_id = $electionpresident_array[0]['electionpresident_id'];
}
else
{
    $sql = "INSERT INTO `electionpresident`
            SET `electionpresident_country_id`=$num_get,
                `electionpresident_date`=UNIX_TIMESTAMP()";
    f_igosja_mysqli_query($sql);

    $electionpresident_id = $mysqli->insert_id;
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
        $sql = "SELECT `electionpresidentapplication_id`
                FROM `electionpresidentapplication`
                WHERE `electionpresidentapplication_user_id`=$auth_user_id
                AND `electionpresidentapplication_electionpresident_id`=$electionpresident_id";
        $electionpresidentapplication_sql = f_igosja_mysqli_query($sql);

        if ($electionpresidentapplication_sql->num_rows)
        {
            $electionpresidentapplication_array = $electionpresidentapplication_sql->fetch_all(MYSQLI_ASSOC);

            $electionpresidentapplication_id = $electionpresidentapplication_array[0]['electionpresidentapplication_id'];

            $sql = "UPDATE `electionpresidentapplication`
                    SET `electionpresidentapplication_text`=?
                    WHERE `electionpresidentapplication_id`=$electionpresidentapplication_id
                    LIMIT 1";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();
        }
        else
        {
            $sql = "INSERT INTO `electionpresidentapplication`
                    SET `electionpresidentapplication_date`=UNIX_TIMESTAMP(),
                        `electionpresidentapplication_electionpresident_id`=$electionpresident_id,
                        `electionpresidentapplication_text`=?,
                        `electionpresidentapplication_user_id`=$auth_user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();

            $electionpresidentapplication_id = $mysqli->insert_id;
        }

        f_igosja_session_front_flash_set('success', 'Изменения успшено сохранены.');

        refresh();
    }
}

$sql = "SELECT `electionpresidentapplication_id`,
               `electionpresidentapplication_text`
        FROM `electionpresidentapplication`
        WHERE `electionpresidentapplication_electionpresident_id`=$electionpresident_id
        AND `electionpresidentapplication_user_id`=$auth_user_id
        LIMIT 1";
$electionpresidentapplication_sql = f_igosja_mysqli_query($sql);

$electionpresidentapplication_array = $electionpresidentapplication_sql->fetch_all(MYSQLI_ASSOC);

if ($electionpresidentapplication_sql->num_rows)
{
    $electionpresidentapplication_id = $electionpresidentapplication_array[0]['electionpresidentapplication_id'];
}

if (isset($data['text']))
{
    $text = $data['text'];
}
elseif (isset($electionpresidentapplication_array[0]))
{
    $text = $electionpresidentapplication_array[0]['electionpresidentapplication_text'];
}
else
{
    $text = '';
}

$seo_title          = 'Подача заявки на президента федерации';
$seo_description    = 'Подача заявки на президента федерации на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'подача заявки на президента федерации';

include(__DIR__ . '/view/layout/main.php');