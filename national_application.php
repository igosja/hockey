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

if (!$type_get = (int) f_igosja_request_get('type'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT COUNT(`national_id`) AS `check`
        FROM `national`
        WHERE `national_country_id`=$num_get
        AND `national_nationaltype_id`=$type_get
        AND `national_user_id`=0
        LIMIT 1";
$check_sql = f_igosja_mysqli_query($sql);

$chech_array = $check_sql->fetch_all(1);

if (0 == $chech_array[0]['check'])
{
    redirect('/wrong_page.php');
}

$sql = "SELECT COUNT(`electionnational_id`) AS `check`
        FROM `electionnational`
        WHERE `electionnational_country_id`=$num_get
        AND `electionnational_electionstatus_id`>" . ELECTIONSTATUS_CANDIDATES . "
        AND `electionnational_nationaltype_id`=$type_get";
$check_sql = f_igosja_mysqli_query($sql);

$chech_array = $check_sql->fetch_all(1);

if ($chech_array[0]['check'])
{
    redirect('/national_vote.php?num=' . $num_get . '&type=' . $type_get);
}

$sql = "SELECT `electionnational_id`
        FROM `electionnational`
        WHERE `electionnational_country_id`=$num_get
        AND `electionnational_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
        AND `electionnational_nationaltype_id`=$type_get
        LIMIT 1";
$electionnational_sql = f_igosja_mysqli_query($sql);

if ($electionnational_sql->num_rows)
{
    $electionnational_array = $electionnational_sql->fetch_all(1);

    $electionnational_id = $electionnational_array[0]['electionnational_id'];
}
else
{
    $sql = "INSERT INTO `electionnational`
            SET `electionnational_country_id`=$num_get,
                `electionnational_date`=UNIX_TIMESTAMP(),
                `electionnational_nationaltype_id`=$type_get";
    f_igosja_mysqli_query($sql);

    $electionnational_id = $mysqli->insert_id;
}

if ($data = f_igosja_request_post('data'))
{
    $text = trim($data['text']);

    if (!empty($text))
    {
        $sql = "SELECT `electionnationalapplication_id`
                FROM `electionnationalapplication`
                WHERE `electionnationalapplication_user_id`=$auth_user_id
                AND `electionnationalapplication_electionnational_id`=$electionnational_id";
        $electionnationalapplication_sql = f_igosja_mysqli_query($sql);

        if ($electionnationalapplication_sql->num_rows)
        {
            $electionnationalapplication_array = $electionnationalapplication_sql->fetch_all(1);

            $electionnationalapplication_id = $electionnationalapplication_array[0]['electionnationalapplication_id'];

            $sql = "UPDATE `electionnationalapplication`
                    SET `electionnationalapplication_text`=?
                    WHERE `electionnationalapplication_id`=$electionnationalapplication_id
                    LIMIT 1";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $data['text']);
            $prepare->execute();
        }
        else
        {
            $sql = "INSERT INTO `electionnationalapplication`
                    SET `electionnationalapplication_date`=UNIX_TIMESTAMP(),
                        `electionnationalapplication_electionnational_id`=$electionnational_id,
                        `electionnationalapplication_text`=?,
                        `electionnationalapplication_user_id`=$auth_user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $data['text']);
            $prepare->execute();
        }

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Изменения сохранены.';
    }

    refresh();
}

$sql = "SELECT `electionnationalapplication_text`
        FROM `electionnationalapplication`
        WHERE `electionnationalapplication_electionnational_id`=$electionnational_id
        AND `electionnationalapplication_user_id`=$auth_user_id
        LIMIT 1";
$electionnationalapplication_sql = f_igosja_mysqli_query($sql);

$electionnationalapplication_array = $electionnationalapplication_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');