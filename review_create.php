<?php

/**
 * @var $auth_date_forum
 * @var $auth_user_id
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (!$country_id = (int) f_igosja_request_get('country_id'))
{
    redirect('/wrong_page.php');
}

if (!$division_id = (int) f_igosja_request_get('division_id'))
{
    redirect('/wrong_page.php');
}

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    redirect('/wrong_page.php');
}

if (!$stage_id = (int) f_igosja_request_get('stage_id'))
{
    redirect('/wrong_page.php');
}

if (!$schedule_id = (int) f_igosja_request_get('schedule_id'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT COUNT(`review_id`) AS `check`
        FROM `review`
        WHERE `review_country_id`=$country_id
        AND `review_division_id`=$division_id
        AND `review_schedule_id`=$schedule_id
        AND `review_season_id`=$season_id
        AND `review_stage_id`=$stage_id
        AND `review_user_id`=$auth_user_id";
$review_sql = f_igosja_mysqli_query($sql);

$review_array = $review_sql->fetch_all(MYSQLI_ASSOC);

if (0 != $review_array[0]['check'])
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `country_name`,
               `division_name`
        FROM `championship`
        LEFT JOIN `country`
        ON `championship_country_id`=`country_id`
        LEFT JOIN `division`
        ON `championship_division_id`=`division_id`
        WHERE `championship_season_id`=$season_id
        AND `championship_country_id`=$country_id
        AND `championship_division_id`=$division_id
        LIMIT 1";
$country_sql = f_igosja_mysqli_query($sql);

if (0 == $country_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `game_id`,
               `game_guest_auto`,
               `game_guest_score`,
               `game_home_auto`,
               `game_home_score`,
               `game_played`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `guest_city`.`city_name` AS `guest_city_name`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `home_city`.`city_name` AS `home_city_name`,
               `stage_name`
        FROM `game`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        LEFT JOIN `stadium` AS `guest_stadium`
        ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
        LEFT JOIN `city` AS `guest_city`
        ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `stadium` AS `home_stadium`
        ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
        LEFT JOIN `city` AS `home_city`
        ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
        LEFT JOIN `championship`
        ON `game_guest_team_id`=`championship_team_id`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        LEFT JOIN `stage`
        ON `schedule_stage_id`=`stage_id`
        WHERE `game_schedule_id`=$schedule_id
        AND `championship_season_id`=$season_id
        AND `championship_country_id`=$country_id
        AND `championship_division_id`=$division_id
        ORDER BY `game_id` ASC";
$game_sql = f_igosja_mysqli_query($sql);

if (0 == $game_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    if (isset($data['title']) && isset($data['text']))
    {
        $title  = trim($data['title']);
        $text   = trim($data['text']);

        if (!empty($title) && !empty($text))
        {
            $title  = htmlspecialchars($title);
            $text   = htmlspecialchars($text);

            if ($data['preview'])
            {
                $_SESSION['review']['title']    = $title;
                $_SESSION['review']['text']     = $text;
            }
            else
            {
                $sql = "INSERT INTO `review`
                        SET `review_country_id`=$country_id,
                            `review_date`=UNIX_TIMESTAMP(),
                            `review_division_id`=$division_id,
                            `review_season_id`=$season_id,
                            `review_schedule_id`=$schedule_id,
                            `review_stage_id`=$stage_id,
                            `review_text`=?,
                            `review_title`=?,
                            `review_user_id`=$auth_user_id";
                $prepare = $mysqli->prepare($sql);
                $prepare->bind_param('ss', $text, $title);
                $prepare->execute();
                $prepare->close();

                $prize = 25000;

                $sql = "SELECT `user_finance`
                        FROM `user`
                        WHERE `user_id`=$auth_user_id
                        LIMIT 1";
                $user_sql = f_igosja_mysqli_query($sql);

                $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

                $finance = array(
                    'finance_financetext_id' => FINANCETEXT_INCOME_REVIEW,
                    'finance_user_id' => $auth_user_id,
                    'finance_value' => $prize,
                    'finance_value_after' => $user_array[0]['user_finance'] + $prize,
                    'finance_value_before' => $user_array[0]['user_finance'],
                );

                f_igosja_finance($finance);

                $sql = "UPDATE `user`
                        SET `user_finance`=`user_finance`+$prize
                        WHERE `user_id`=$auth_user_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                f_igosja_session_front_flash_set('success', 'Обзор упешно сохранён.');

                unset($_SESSION['review']);

                redirect('/championship.php?country_id=' . $country_id . '&division_id=' . $division_id . '&season_id=' . $season_id . '&stage_id=' . $stage_id);
            }
        }
    }

    refresh();
}

if (isset($_SESSION['review']['title']) && isset($_SESSION['review']['text']))
{
    $review_title   = $_SESSION['review']['title'];
    $review_text    = $_SESSION['review']['text'];

    if ((int) f_igosja_request_get('edit'))
    {
        $preview = false;
    }
    else
    {
        $preview = true;
    }
}
else
{
    $review_title   = '';
    $review_text    = '';
    $preview        = false;
}

$seo_title          = 'Написание обзора';
$seo_description    = 'Написание обзора на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'написание обзора';

include(__DIR__ . '/view/layout/main.php');