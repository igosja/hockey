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
    }

    if ($tomorrow)
    {
        $text = $text . '<p class="strong">ЗАВТРА ДНЁМ</p>' . "\r\n" . '<p>В ' . $day . ' в Лиге будут сыграны ' . $tomorrow .'.</p>' . "\r\n";
    }

    $sql = "INSERT INTO `news`
            SET `news_date`=UNIX_TIMESTAMP(),
                `news_text`=?,
                `news_title`=?,
                `news_user_id`=1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $text, $title);
    $prepare->execute();
}