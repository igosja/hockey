<?php

/**
 * Авто новини після генерації ігрового дня
 */
function f_igosja_generator_news()
{
    global $mysqli;

    $sql = "SELECT `stage_id`,
                   `stage_name`,
                   `schedule_tournamenttype_id`
            FROM `schedule`
            LEFT JOIN `stage`
            ON `schedule_stage_id`=`stage_id`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";
    $today_sql = f_igosja_mysqli_query($sql);

    $today_array = $today_sql->fetch_all(MYSQLI_ASSOC);

    $today = f_igosja_news_text($today_array);

    $sql = "SELECT `stage_id`,
                   `stage_name`,
                   `schedule_tournamenttype_id`
            FROM `schedule`
            LEFT JOIN `stage`
            ON `schedule_stage_id`=`stage_id`
            WHERE FROM_UNIXTIME(`schedule_date`-86400, '%Y-%m-%d')=CURDATE()";
    $tomorrow_sql = f_igosja_mysqli_query($sql);

    $tomorrow_array = $tomorrow_sql->fetch_all(MYSQLI_ASSOC);

    $tomorrow = f_igosja_news_text($tomorrow_array);

    $day = date('w', strtotime('+1day'));

    if (0 == $day)
    {
        $day = 'воскресенье';
    }
    elseif (1 == $day)
    {
        $day = 'понедельник';
    }
    elseif (2 == $day)
    {
        $day = 'вторник';
    }
    elseif (3 == $day)
    {
        $day = 'среду';
    }
    elseif (4 == $day)
    {
        $day = 'четверг';
    }
    elseif (5 == $day)
    {
        $day = 'пятницу';
    }
    else
    {
        $day = 'субботу';
    }

    $title  = 'Вести с арен';
    $text   = '';

    if ($today)
    {
        $text = $text . '<p class="strong">СЕГОДНЯ</p>' . "\r\n" . '<p>Сегодня состоялись ' . $today . '.</p>' . "\r\n";

        $sql = "SELECT `game_id`,
                       `game_guest_score`,
                       `game_home_score`,
                       `guest_city`.`city_name` AS `guest_city_name`,
                       `guest_country`.`country_name` AS `guest_country_name`,
                       `guest_national`.`national_id` AS `guest_national_id`,
                       `guest_team`.`team_id` AS `guest_team_id`,
                       `guest_team`.`team_name` AS `guest_team_name`,
                       `home_city`.`city_name` AS `home_city_name`,
                       `home_country`.`country_name` AS `home_country_name`,
                       `home_national`.`national_id` AS `home_national_id`,
                       `home_team`.`team_id` AS `home_team_id`,
                       `home_team`.`team_name` AS `home_team_name`
                FROM `game`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                LEFT JOIN `team` AS `home_team`
                ON `game_home_team_id`=`home_team`.`team_id`
                LEFT JOIN `stadium` AS `home_stadium`
                ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
                LEFT JOIN `city` AS `home_city`
                ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
                LEFT JOIN `team` AS `guest_team`
                ON `game_guest_team_id`=`guest_team`.`team_id`
                LEFT JOIN `stadium` AS `guest_stadium`
                ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
                LEFT JOIN `city` AS `guest_city`
                ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
                LEFT JOIN `national` AS `home_national`
                ON `game_home_national_id`=`home_national`.`national_id`
                LEFT JOIN `country` AS `home_country`
                ON `home_national`.`national_country_id`=`home_country`.`country_id`
                LEFT JOIN `national` AS `guest_national`
                ON `game_guest_national_id`=`guest_national`.`national_id`
                LEFT JOIN `country` AS `guest_country`
                ON `guest_national`.`national_country_id`=`guest_country`.`country_id`
                WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                ORDER BY `game_guest_score`+`game_home_score` DESC
                LIMIT 1";
        $score_sql = f_igosja_mysqli_query($sql);

        if (0 != $score_sql->num_rows)
        {
            $score_array = $score_sql->fetch_all(MYSQLI_ASSOC);

            $text = $text . '<p>Самый крупный счёт в этот день был зафиксирован в матче ' . f_igosja_team_or_national_link(
                array(
                    'team_id'   => $score_array[0]['home_team_id'],
                    'team_name' => $score_array[0]['home_team_name'],
                ),
                array(
                    'country_name'  => $score_array[0]['home_country_name'],
                    'national_id'   => $score_array[0]['home_national_id'],
                ),
                false
            ) . ' - ' . f_igosja_team_or_national_link(
                array(
                    'team_id'   => $score_array[0]['guest_team_id'],
                    'team_name' => $score_array[0]['guest_team_name'],
                ),
                array(
                    'country_name'  => $score_array[0]['guest_country_name'],
                    'national_id'   => $score_array[0]['guest_national_id'],
                ),
                false
            ) . ' - <a href="/game_view.php?num=' . $score_array[0]['game_id'] . '">' . $score_array[0]['game_home_score'] . ':' . $score_array[0]['game_guest_score'] . '</a>.</p>' . "\r\n";
        }

        $sql = "SELECT `game_id`,
                       `game_guest_score`,
                       `game_home_score`,
                       `guest_city`.`city_name` AS `guest_city_name`,
                       `guest_country`.`country_name` AS `guest_country_name`,
                       `guest_national`.`national_id` AS `guest_national_id`,
                       `guest_team`.`team_id` AS `guest_team_id`,
                       `guest_team`.`team_name` AS `guest_team_name`,
                       `home_city`.`city_name` AS `home_city_name`,
                       `home_country`.`country_name` AS `home_country_name`,
                       `home_national`.`national_id` AS `home_national_id`,
                       `home_team`.`team_id` AS `home_team_id`,
                       `home_team`.`team_name` AS `home_team_name`
                FROM `game`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                LEFT JOIN `team` AS `home_team`
                ON `game_home_team_id`=`home_team`.`team_id`
                LEFT JOIN `stadium` AS `home_stadium`
                ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
                LEFT JOIN `city` AS `home_city`
                ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
                LEFT JOIN `team` AS `guest_team`
                ON `game_guest_team_id`=`guest_team`.`team_id`
                LEFT JOIN `stadium` AS `guest_stadium`
                ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
                LEFT JOIN `city` AS `guest_city`
                ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
                LEFT JOIN `national` AS `home_national`
                ON `game_home_national_id`=`home_national`.`national_id`
                LEFT JOIN `country` AS `home_country`
                ON `home_national`.`national_country_id`=`home_country`.`country_id`
                LEFT JOIN `national` AS `guest_national`
                ON `game_guest_national_id`=`guest_national`.`national_id`
                LEFT JOIN `country` AS `guest_country`
                ON `guest_national`.`national_country_id`=`guest_country`.`country_id`
                WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                ORDER BY `game_guest_power`+`game_home_power` DESC
                LIMIT 1";
        $power_sql = f_igosja_mysqli_query($sql);

        if (0 != $power_sql->num_rows)
        {
            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $text = $text . '<p>Самую большую суммарную силу соперников зрители могли увидеть в матче ' . f_igosja_team_or_national_link(
                array(
                    'team_id'   => $power_array[0]['home_team_id'],
                    'team_name' => $power_array[0]['home_team_name'],
                ),
                array(
                    'country_name'  => $power_array[0]['home_country_name'],
                    'national_id'   => $power_array[0]['home_national_id'],
                ),
                false
            ) . ' - ' . f_igosja_team_or_national_link(
                array(
                    'team_id'   => $power_array[0]['guest_team_id'],
                    'team_name' => $power_array[0]['guest_team_name'],
                ),
                array(
                    'country_name'  => $power_array[0]['guest_country_name'],
                    'national_id'   => $power_array[0]['guest_national_id'],
                ),
                false
            ) . ' - <a href="/game_view.php?num=' . $power_array[0]['game_id'] . '">' . $power_array[0]['game_home_score'] . ':' . $power_array[0]['game_guest_score'] . '</a>.</p>' . "\r\n";
        }
    }

    if ($tomorrow)
    {
        $text = $text . '<p class="strong">ЗАВТРА ДНЁМ</p>' . "\r\n" . '<p>В ' . $day . ' в Лиге будут сыграны ' . $tomorrow .'.</p>' . "\r\n";
    }

    $sql = "SELECT `prenews_error`,
                   `prenews_new`
            FROM `prenews`
            WHERE `prenews_id`=1
            LIMIT 1";
    $prenews_sql = f_igosja_mysqli_query($sql);

    $prenews_array = $prenews_sql->fetch_all(MYSQLI_ASSOC);

    if ($prenews_array[0]['prenews_error'])
    {
        $text = $text . '<p class="strong">РАБОТА НАД ОШИКАМИ</p>' . "\r\n" . $prenews_array[0]['prenews_error'] . "\r\n";
    }

    if ($prenews_array[0]['prenews_new'])
    {
        $text = $text . '<p class="strong">НОВОЕ НА САЙТЕ</p>' . "\r\n" . $prenews_array[0]['prenews_new'] . "\r\n";
    }

    $sql = "UPDATE `prenews`
            SET `prenews_error`='',
                `prenews_new`=''
            WHERE `prenews_id`=1
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "INSERT INTO `news`
            SET `news_date`=UNIX_TIMESTAMP(),
                `news_text`=?,
                `news_title`=?,
                `news_user_id`=1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $text, $title);
    $prepare->execute();
}