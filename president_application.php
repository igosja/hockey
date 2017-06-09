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

$sql = "SELECT COUNT(`electionpresident_id`) AS `check`
        FROM `electionpresident`
        WHERE `electionpresident_country_id`=$num_get
        AND `electionpresident_electionstatus_id`>" . ELECTIONSTATUS_CANDIDATES;
$check_sql = f_igosja_mysqli_query($sql);

$chech_array = $check_sql->fetch_all(1);

if ($chech_array[0]['check'])
{
    redirect('/president_vote.php?num=' . $num_get);
}

$sql = "SELECT `electionpresident_id`
        FROM `electionpresident`
        WHERE `electionpresident_country_id`=$num_get
        AND `electionpresident_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
        LIMIT 1";
$electionpresident_sql = f_igosja_mysqli_query($sql);

if ($electionpresident_sql->num_rows)
{
    $electionpresident_array = $electionpresident_sql->fetch_all(1);

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

    if (!empty($text))
    {
        $sql = "SELECT `electionpresidentapplication_id`
                FROM `electionpresidentapplication`
                WHERE `electionpresidentapplication_user_id`=$auth_user_id
                AND `electionpresidentapplication_electionpresident_id`=$electionpresident_id";
        $electionpresidentapplication_sql = f_igosja_mysqli_query($sql);

        if ($electionpresidentapplication_sql->num_rows)
        {
            $electionpresidentapplication_array = $electionpresidentapplication_sql->fetch_all(1);

            $electionpresidentapplication_id = $electionpresidentapplication_array[0]['electionpresidentapplication_id'];

            $sql = "UPDATE `electionpresidentapplication`
                    SET `electionpresidentapplication_text`=?
                    WHERE `electionpresidentapplication_id`=$electionpresidentapplication_id
                    LIMIT 1";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $data['text']);
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
            $prepare->bind_param('s', $data['text']);
            $prepare->execute();
        }

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Изменения сохранены.';
    }

    refresh();
}

$sql = "SELECT `electionpresidentapplication_text`
        FROM `electionpresidentapplication`
        WHERE `electionpresidentapplication_electionpresident_id`=$electionpresident_id
        AND `electionpresidentapplication_user_id`=$auth_user_id
        LIMIT 1";
$electionpresidentapplication_sql = f_igosja_mysqli_query($sql);

$electionpresidentapplication_array = $electionpresidentapplication_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');