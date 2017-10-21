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
        AND `country_president_id`!=0
        AND `country_vice_id`=0
        LIMIT 1";
$check_sql = f_igosja_mysqli_query($sql, false);

$chech_array = $check_sql->fetch_all(1);

if (0 == $chech_array[0]['check'])
{
    redirect('/wrong_page.php');
}

$sql = "SELECT COUNT(`electionpresidentvice_id`) AS `check`
        FROM `electionpresidentvice`
        WHERE `electionpresidentvice_country_id`=$num_get
        AND `electionpresidentvice_electionstatus_id`>" . ELECTIONSTATUS_CANDIDATES;
$check_sql = f_igosja_mysqli_query($sql, false);

$chech_array = $check_sql->fetch_all(1);

if ($chech_array[0]['check'])
{
    redirect('/president_vice_vote.php?num=' . $num_get);
}

$sql = "SELECT `electionpresidentvice_id`
        FROM `electionpresidentvice`
        WHERE `electionpresidentvice_country_id`=$num_get
        AND `electionpresidentvice_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
        LIMIT 1";
$electionpresidentvice_sql = f_igosja_mysqli_query($sql, false);

if ($electionpresidentvice_sql->num_rows)
{
    $electionpresidentvice_array = $electionpresidentvice_sql->fetch_all(1);

    $electionpresidentvice_id = $electionpresidentvice_array[0]['electionpresidentvice_id'];
}
else
{
    $sql = "INSERT INTO `electionpresidentvice`
            SET `electionpresidentvice_country_id`=$num_get,
                `electionpresidentvice_date`=UNIX_TIMESTAMP()";
    f_igosja_mysqli_query($sql);

    $electionpresidentvice_id = $mysqli->insert_id;
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
        $sql = "SELECT `electionpresidentviceapplication_id`
                FROM `electionpresidentviceapplication`
                WHERE `electionpresidentviceapplication_user_id`=$auth_user_id
                AND `electionpresidentviceapplication_electionpresidentvice_id`=$electionpresidentvice_id";
        $electionpresidentviceapplication_sql = f_igosja_mysqli_query($sql, false);

        if ($electionpresidentviceapplication_sql->num_rows)
        {
            $electionpresidentviceapplication_array = $electionpresidentviceapplication_sql->fetch_all(1);

            $electionpresidentviceapplication_id = $electionpresidentviceapplication_array[0]['electionpresidentviceapplication_id'];

            $sql = "UPDATE `electionpresidentviceapplication`
                    SET `electionpresidentviceapplication_text`=?
                    WHERE `electionpresidentviceapplication_id`=$electionpresidentviceapplication_id
                    LIMIT 1";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();
        }
        else
        {
            $sql = "INSERT INTO `electionpresidentviceapplication`
                    SET `electionpresidentviceapplication_date`=UNIX_TIMESTAMP(),
                        `electionpresidentviceapplication_electionpresidentvice_id`=$electionpresidentvice_id,
                        `electionpresidentviceapplication_text`=?,
                        `electionpresidentviceapplication_user_id`=$auth_user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();

            $electionpresidentviceapplication_id = $mysqli->insert_id;
        }

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Изменения сохранены.';

        refresh();
    }
}

$sql = "SELECT `electionpresidentviceapplication_id`,
               `electionpresidentviceapplication_text`
        FROM `electionpresidentviceapplication`
        WHERE `electionpresidentviceapplication_electionpresidentvice_id`=$electionpresidentvice_id
        AND `electionpresidentviceapplication_user_id`=$auth_user_id
        LIMIT 1";
$electionpresidentviceapplication_sql = f_igosja_mysqli_query($sql, false);

$electionpresidentviceapplication_array = $electionpresidentviceapplication_sql->fetch_all(1);

if ($electionpresidentviceapplication_sql->num_rows)
{
    $electionpresidentviceapplication_id = $electionpresidentviceapplication_array[0]['electionpresidentviceapplication_id'];
}

if (isset($data['text']))
{
    $text = $data['text'];
}
elseif (isset($electionpresidentviceapplication_array[0]))
{
    $text = $electionpresidentviceapplication_array[0]['electionpresidentviceapplication_text'];
}
else
{
    $text = '';
}

$seo_title          = 'Подача заявки на заместителя президента федерации';
$seo_description    = 'Подача заявки на заместителя президента федерации на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'подача заявки на заместителя президента федерации';

include(__DIR__ . '/view/layout/main.php');