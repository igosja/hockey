<?php

/**
 * @var $auth_country_id integer
 * @var $auth_user_id integer
 * @var $country_array array
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

include(__DIR__ . '/include/sql/country_view.php');

if (!in_array($auth_user_id, array($country_array[0]['president_id'], $country_array[0]['vice_id'])))
{
    redirect('/wrong_page.php');
}

if (0 == $country_array[0]['vice_id'])
{
    redirect('/wrong_page.php');
}

if (f_igosja_request_get('ok'))
{
    if ($auth_user_id == $country_array[0]['president_id'])
    {
        $log = array(
            'history_country_id' => $num_get,
            'history_historytext_id' => HISTORYTEXT_USER_PRESIDENT_OUT,
            'history_user_id' => $country_array[0]['president_id'],
        );
        f_igosja_history($log);

        $log = array(
            'history_country_id' => $num_get,
            'history_historytext_id' => HISTORYTEXT_USER_VICE_PRESIDENT_OUT,
            'history_user_id' => $country_array[0]['vice_id'],
        );
        f_igosja_history($log);

        $log = array(
            'history_country_id' => $num_get,
            'history_historytext_id' => HISTORYTEXT_USER_PRESIDENT_IN,
            'history_user_id' => $country_array[0]['vice_id'],
        );
        f_igosja_history($log);

        $sql = "UPDATE `country`
                SET `country_president_id`=`country_vice_id`,
                    `country_vice_id`=0
                WHERE `country_id`=$num_get
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                SET `team_vote_president`=" . VOTERATING_NEUTRAL . "
                WHERE `city_country_id`=$num_get";
        f_igosja_mysqli_query($sql);

        $news_text  = 'Действующий президент федерации отправлен в отставку по собственному желанию. Заместитель президента занял вакантную должность.';
        $news_title = 'Увольнение президента';

        $sql = "INSERT INTO `news`
                SET `news_country_id`=$num_get,
                    `news_date`=UNIX_TIMESTAMP(),
                    `news_text`='$news_text',
                    `news_title`='$news_title',
                    `news_user_id`=1";
        f_igosja_mysqli_query($sql);
    }
    elseif ($auth_user_id == $country_array[0]['vice_id'])
    {
        $log = array(
            'history_country_id' => $num_get,
            'history_historytext_id' => HISTORYTEXT_USER_VICE_PRESIDENT_OUT,
            'history_user_id' => $country_array[0]['vice_id'],
        );
        f_igosja_history($log);

        $sql = "UPDATE `country`
                SET `country_vice_id`=0
                WHERE `country_id`=$num_get
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }

    f_igosja_session_front_flash_set('success', 'Вы успешно отказались от должности.');

    redirect('/country_news.php?num=' . $num_get);
}

$seo_title          = $country_array[0]['country_name'] . '. Отказ от должности';
$seo_description    = $country_array[0]['country_name'] . '. Отказ от должности на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $country_array[0]['country_name'] . ' отказ от должности';

include(__DIR__ . '/view/layout/main.php');