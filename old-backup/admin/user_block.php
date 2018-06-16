<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'user_block_blockreason_id'
    ));

    if (isset($data['time']))
    {
        $time = (int) $data['time'];
    }
    else
    {
        $time = 1;
    }

    $time = $time * 86400 + time();

    $sql = "UPDATE `user`
            SET `user_date_block`=$time,
                $set_sql
            WHERE `user_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `team_id`
            FROM `team`
            WHERE `team_user_id`=$num_get
            ORDER BY `team_id` ASC";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($team_array as $item)
    {
        f_igosja_fire_user($num_get, $item['team_id']);
    }

    $sql = "SELECT `country_id`,
                   `country_vice_id`
            FROM `country`
            WHERE `country_president_id`=$num_get
            ORDER BY `country_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($country_array as $item)
    {
        $country_id = $item['country_id'];

        $log = array(
            'history_country_id' => $country_id,
            'history_historytext_id' => HISTORYTEXT_USER_PRESIDENT_OUT,
            'history_user_id' => $num_get,
        );
        f_igosja_history($log);

        if ($item['country_vice_id'])
        {
            $log = array(
                'history_country_id' => $country_id,
                'history_historytext_id' => HISTORYTEXT_USER_VICE_PRESIDENT_OUT,
                'history_user_id' => $item['country_vice_id'],
            );
            f_igosja_history($log);

            $log = array(
                'history_country_id' => $country_id,
                'history_historytext_id' => HISTORYTEXT_USER_PRESIDENT_IN,
                'history_user_id' => $item['country_vice_id'],
            );
            f_igosja_history($log);

            $news_text  = 'Действующий президент федерации отправлен в отставку. Заместитель президента занял вакантную должность.';
            $news_title = 'Увольнение президента';

            $sql = "INSERT INTO `news`
                    SET `news_country_id`=$country_id,
                        `news_date`=UNIX_TIMESTAMP(),
                        `news_text`='$news_text',
                        `news_title`='$news_title',
                        `news_user_id`=1";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $news_text  = 'Действующий президент федерации отправлен в отставку.';
            $news_title = 'Увольнение президента';

            $sql = "INSERT INTO `news`
                    SET `news_country_id`=$country_id,
                        `news_date`=UNIX_TIMESTAMP(),
                        `news_text`='$news_text',
                        `news_title`='$news_title',
                        `news_user_id`=1";
            f_igosja_mysqli_query($sql);
        }

        $sql = "UPDATE `country`
                SET `country_president_id`=`country_vice_id`,
                    `country_vice_id`=0
                WHERE `country_id`=$country_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                SET `team_vote_president`=" . VOTERATING_NEUTRAL . "
                WHERE `city_country_id`=$country_id";
        f_igosja_mysqli_query($sql);
    }

    $sql = "SELECT `country_id`
            FROM `country`
            WHERE `country_vice_id`=$num_get
            ORDER BY `country_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($country_array as $item)
    {
        $country_id = $item['country_id'];

        $log = array(
            'history_country_id' => $country_id,
            'history_historytext_id' => HISTORYTEXT_USER_VICE_PRESIDENT_OUT,
            'history_user_id' => $num_get,
        );
        f_igosja_history($log);

        $sql = "UPDATE `country`
                SET `country_vice_id`=0
                WHERE `country_id`=$country_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }

    $sql = "SELECT `national_id`,
                   `national_vice_id`
            FROM `national`
            WHERE `national_user_id`=$num_get
            ORDER BY `national_id` ASC";
    $national_sql = f_igosja_mysqli_query($sql);

    $national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($national_array as $item)
    {
        $national_id = $item['national_id'];

        $log = array(
            'history_historytext_id' => HISTORYTEXT_USER_MANAGER_NATIONAL_OUT,
            'history_national_id' => $national_id,
            'history_user_id' => $num_get,
        );
        f_igosja_history($log);

        if ($item['national_vice_id'])
        {
            $log = array(
                'history_historytext_id' => HISTORYTEXT_USER_VICE_NATIONAL_OUT,
                'history_national_id' => $national_id,
                'history_user_id' => $item['national_vice_id'],
            );
            f_igosja_history($log);

            $log = array(
                'history_historytext_id' => HISTORYTEXT_USER_MANAGER_NATIONAL_IN,
                'history_national_id' => $national_id,
                'history_user_id' => $item['national_vice_id'],
            );
            f_igosja_history($log);
        }

        $sql = "UPDATE `national`
                SET `national_user_id`=`national_vice_id`,
                    `national_vice_id`=0
                WHERE `national_id`=$national_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                SET `team_vote_national`=" . VOTERATING_NEUTRAL . "
                WHERE `city_country_id`=$national_id";
        f_igosja_mysqli_query($sql);
    }

    $sql = "SELECT `national_id`
            FROM `national`
            WHERE `national_vice_id`=$num_get
            ORDER BY `national_id` ASC";
    $national_sql = f_igosja_mysqli_query($sql);

    $national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($national_array as $item)
    {
        $national_id = $item['national_id'];

        $log = array(
            'history_national_id' => $national_id,
            'history_historytext_id' => HISTORYTEXT_USER_VICE_NATIONAL_OUT,
            'history_user_id' => $num_get,
        );
        f_igosja_history($log);

        $sql = "UPDATE `national`
                SET `national_vice_id`=0
                WHERE `national_id`=$national_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }

    redirect('/admin/user_view.php?num=' . $num_get);
}

$sql = "SELECT `user_id`,
               `user_login`
        FROM `user`
        WHERE `user_id`=$num_get
        LIMIT 1";
$user_sql = f_igosja_mysqli_query($sql);

if (0 == $user_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `blockreason_id`,
               `blockreason_text`
        FROM `blockreason`
        ORDER BY `blockreason_text` ASC";
$blockreason_sql = f_igosja_mysqli_query($sql);

$blockreason_array = $blockreason_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'user_list.php', 'text' => 'Пользователи');
$breadcrumb_array[] = array(
    'url' => 'user_view.php?num=' . $user_array[0]['user_id'],
    'text' => $user_array[0]['user_login']
);
$breadcrumb_array[] = 'Блокирование доступа к сайту';

include(__DIR__ . '/view/layout/main.php');