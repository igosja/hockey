<?php

/**
 * @var $auth_date_vip integer
 * @var $auth_team_id integer
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "SELECT `city_name`,
                   `country_name`,
                   `team_name`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            WHERE `team_id`=$num_get
            AND `team_user_id`=0";
    $team_sql = f_igosja_mysqli_query($sql);

    if (0 == $team_sql->num_rows)
    {
        $_SESSION['message']['text']    = 'Команда выбрана неправильно';
        $_SESSION['message']['class']   = 'error';

        redirect('/team_change.php');
    }

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    $teamask_city       = $team_array[0]['city_name'];
    $teamask_country    = $team_array[0]['country_name'];
    $teamask_name       = $team_array[0]['team_name'];

    $sql = "SELECT COUNT(`teamask_id`) AS `check`
            FROM `teamask`
            WHERE `teamask_user_id`=$auth_user_id";
    $teamask_sql = f_igosja_mysqli_query($sql);

    $teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

    if ($teamask_array[0]['check'])
    {
        $_SESSION['message']['text']    = 'Вы уже подали заявку';
        $_SESSION['message']['class']   = 'error';

        redirect('/team_change.php');
    }

    $option_array = array();

    if ($auth_date_vip < time())
    {
        $sql = "SELECT `country_id`,
                       `country_name`,
                       `team_id`,
                       `team_name`
                FROM `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                LEFT JOIN `country`
                ON `city_country_id`=`country_id`
                WHERE `team_user_id`=$auth_user_id
                ORDER BY `team_id` ASC";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        if (1 == $team_sql->num_rows)
        {
            $option_array[$team_array[0]['team_id']] = $team_array[0]['team_name'] . ' (' . $team_array[0]['country_name'] . ')';
        }
        else
        {
            $sql = "SELECT `city_country_id`
                    FROM `team`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    WHERE `team_id`=$num_get
                    LIMIT 1";
            $teamask_sql = f_igosja_mysqli_query($sql);

            $teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

            $country_id = array();

            foreach ($team_array as $item)
            {
                $country_id[] = $item['country_id'];
            }

            $country_id = implode(',', $country_id);

            $sql = "SELECT `country_id`,
                           `country_name`,
                           `team_id`,
                           `team_name`
                    FROM `team`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    LEFT JOIN `country`
                    ON `city_country_id`=`country_id`
                    WHERE `team_user_id`=$auth_user_id
                    AND `country_id` IN $country_id
                    ORDER BY `team_id` ASC";
            $team_country_sql = f_igosja_mysqli_query($sql);

            if (0 == $team_country_sql->num_rows)
            {
                foreach ($team_array as $item)
                {
                    $option_array[$item['team_id']] = $item['team_name'] . ' (' . $item['country_name'] . ')';
                }
            }
            else
            {
                $team_country_array = $team_country_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($team_country_array as $item)
                {
                    $option_array[$item['team_id']] = $item['team_name'] . ' (' . $item['country_name'] . ')';
                }
            }
        }
    }
    else
    {
        $sql = "SELECT `country_id`,
                       `country_name`,
                       `team_id`,
                       `team_name`
                FROM `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                LEFT JOIN `country`
                ON `city_country_id`=`country_id`
                WHERE `team_user_id`=$auth_user_id
                ORDER BY `team_id` ASC";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        if (1 == $team_sql->num_rows)
        {
            $sql = "SELECT `city_country_id`
                    FROM `team`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    WHERE `team_id`=$num_get
                    LIMIT 1";
            $teamask_sql = f_igosja_mysqli_query($sql);

            $teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

            if ($team_array[0]['country_id'] != $teamask_array[0]['city_country_id'])
            {
                $option_array[0] = 'Беру дополнительную команду';
            }

            $option_array[$item['team_id']] = $item['team_name'] . ' (' . $item['country_name'] . ')';
        }
        else
        {
            $sql = "SELECT `city_country_id`
                    FROM `team`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    WHERE `team_id`=$num_get
                    LIMIT 1";
            $teamask_sql = f_igosja_mysqli_query($sql);

            $teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

            $country_id = array();

            foreach ($team_array as $item)
            {
                $country_id[] = $item['country_id'];
            }

            $country_id = implode(',', $country_id);

            $sql = "SELECT `country_id`,
                           `country_name`,
                           `team_id`,
                           `team_name`
                    FROM `team`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    LEFT JOIN `country`
                    ON `city_country_id`=`country_id`
                    WHERE `team_user_id`=$auth_user_id
                    AND `country_id` IN $country_id
                    ORDER BY `team_id` ASC";
            $team_country_sql = f_igosja_mysqli_query($sql);

            if (0 == $team_country_sql->num_rows)
            {
                foreach ($team_array as $item)
                {
                    $option_array[$item['team_id']] = $item['team_name'] . ' (' . $item['country_name'] . ')';
                }
            }
            else
            {
                $team_country_array = $team_country_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($team_country_array as $item)
                {
                    $option_array[$item['team_id']] = $item['team_name'] . ' (' . $item['country_name'] . ')';
                }
            }
        }
    }

    if ($ok = f_igosja_request_get('ok'))
    {
        $sql = "INSERT INTO `teamask`
                SET `teamask_date`=UNIX_TIMESTAMP(),
                    `teamask_team_id`=$num_get,
                    `teamask_user_id`=$auth_user_id";
        f_igosja_mysqli_query($sql);

        //Начало авто подтверждения заявки
        $sql = "SELECT `teamask_id`,
                       `teamask_team_id`,
                       `teamask_user_id`,
                       `user_email`
                FROM `teamask`
                LEFT JOIN `user`
                ON `teamask_user_id`=`user_id`
                WHERE `teamask_team_id`=$num_get
                AND `teamask_user_id`=$auth_user_id
                LIMIT 1";
        $teamask_sql = f_igosja_mysqli_query($sql);

        if (0 == $teamask_sql->num_rows)
        {
            redirect('/wrong_page.php');
        }

        $teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

        $num_get = $teamask_array[0]['teamask_id'];
        $team_id = $teamask_array[0]['teamask_team_id'];
        $user_id = $teamask_array[0]['teamask_user_id'];
        $email   = $teamask_array[0]['user_email'];

        $option_array = array_keys($option_array);

        if (($leave_id = (int) f_igosja_request_get('leave_id')) && in_array($leave_id, $option_array))
        {
            f_igosja_fire_user($user_id, $leave_id);
        }

        $sql = "SELECT COUNT(`team_id`) AS `check`
                FROM `team`
                WHERE `team_id`=$team_id
                AND `team_user_id`=0";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        if (!$team_array[0]['check'])
        {
            $sql = "DELETE FROM `teamask`
                    WHERE `teamask_team_id`=$team_id";
            f_igosja_mysqli_query($sql);

            redirect('/admin/teamask.php');
        }

        $sql = "SELECT COUNT(`team_id`) AS `check`
                FROM `team`
                WHERE `team_user_id`=$user_id";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        if (($auth_date_vip < time() && $team_array[0]['check'] > 0) || ($auth_date_vip >= time() && $team_array[0]['check'] > 1))
        {
            $_SESSION['message']['text']    = 'Вы не можете себе взять дополнительную команду';
            $_SESSION['message']['class']   = 'error';
        }

        $sql = "UPDATE `team`
                SET `team_user_id`=$user_id
                WHERE `team_id`=$team_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "DELETE FROM `teamask`
                WHERE `teamask_user_id`=$user_id";
        f_igosja_mysqli_query($sql);

        $sql = "DELETE FROM `teamask`
                WHERE `teamask_team_id`=$team_id";
        f_igosja_mysqli_query($sql);

        $log = array(
            'history_historytext_id' => HISTORYTEXT_USER_MANAGER_TEAM_IN,
            'history_team_id' => $team_id,
            'history_user_id' => $user_id,
        );
        f_igosja_history($log);

        $email_text = 'Ваша заявка на управление командой одобрена.';

        $mail = new Mail();
        $mail->setTo($email);
        $mail->setSubject('Получение команды на сайте Виртуальной Хоккейной Лиги');
        $mail->setHtml($email_text);
        $mail->send();
        //Конце авто подтверждения заявки

        $_SESSION['message']['text']    = 'Заявка успешно подана';
        $_SESSION['message']['class']   = 'success';

        redirect('/team_view.php');
    }
}

$sql = "SELECT COUNT(`teamask_id`) AS `count`
        FROM `teamask`
        WHERE `teamask_user_id`=$auth_user_id";
$teamask_sql = f_igosja_mysqli_query($sql);

$teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `base_slot_max`,
               `base_level`,
               `base_slot_max`,
               `basemedical_level`+
               `basephisical_level`+
               `baseschool_level`+
               `basescout_level`+
               `basetraining_level` AS `base_slot_used`,
               `city_name`,
               `conference_team_id`,
               `country_id`,
               `country_name`,
               `division_id`,
               `division_name`,
               `stadium_capacity`,
               `team_id`,
               `team_finance`,
               `team_name`,
               `team_power_vs`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `base`
        ON `team_base_id`=`base_id`
        LEFT JOIN `basemedical`
        ON `team_basemedical_id`=`basemedical_id`
        LEFT JOIN `basephisical`
        ON `team_basephisical_id`=`basephisical_id`
        LEFT JOIN `baseschool`
        ON `team_baseschool_id`=`baseschool_id`
        LEFT JOIN `basescout`
        ON `team_basescout_id`=`basescout_id`
        LEFT JOIN `basetraining`
        ON `team_basetraining_id`=`basetraining_id`
        LEFT JOIN 
        (
            SELECT `championship_team_id`,
                   `division_id`,
                   `division_name`
            FROM `championship`
            LEFT JOIN `division`
            ON `championship_division_id`=`division_id`
            WHERE `championship_season_id`=$igosja_season_id
        ) AS `t1`
        ON `championship_team_id`=`team_id`
        LEFT JOIN 
        (
            SELECT `conference_team_id`
            FROM `conference`
            WHERE `conference_season_id`=$igosja_season_id
        ) AS `t2`
        ON `conference_team_id`=`team_id`
        WHERE `team_user_id`=0
        AND `team_id`!=0
        ORDER BY `team_power_vs` DESC, `team_id` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Смена команды';
$seo_description    = 'Смена команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'Смена команды';

include(__DIR__ . '/view/layout/main.php');