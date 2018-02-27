<?php

/**
 * @var $auth_user_id
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

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`=$num_get
        LIMIT 1";
$team_sql = f_igosja_mysqli_query($sql);

if (0 == $team_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

if (($data = f_igosja_request_post('data')) && ($file = f_igosja_request_files('data')))
{
    $sql = "SELECT COUNT(`logo_id`) AS `count`
            FROM `logo`
            WHERE `logo_team_id`=$num_get
            AND `logo_user_id`!=$auth_user_id";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $check_array[0]['count'])
    {
        f_igosja_session_front_flash_set('error', 'Логотип этой команды уже находится на проверке.');

        refresh();
    }

    if (isset($file['name']['logo']) && !empty($file['name']['logo']))
    {
        if ($file['size']['logo'] > 51200)
        {
            f_igosja_session_front_flash_set('error', 'Объем файла должен быть не более 50 килобайт.');

            refresh();
        }
        elseif ('image/png' != $file['type']['logo'])
        {
            f_igosja_session_front_flash_set('error', 'Картинка должна быть в png-формате.');

            refresh();
        }

        $image_size = getimagesize($file['tmp_name']['logo']);

        if (100 != $image_size[0] && 125 != $image_size[1])
        {
            f_igosja_session_front_flash_set('error', 'Размер картинки должен быть 100x125 пикселей.');

            refresh();
        }

        $upload_dir = __DIR__ . '/upload/img/team/125';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, 1);
        }

        $file_url = $upload_dir . '/' . $num_get . '.png';

        if (copy($file['tmp_name']['logo'], $file_url))
        {
            chmod($file_url, 0777);
        }
        else
        {
            f_igosja_session_front_flash_set('error', 'Не удалось загрузить файл на сервер. Попробуйте еще раз.');

            refresh();
        }
    }

    if (isset($data['text']))
    {
        $text = trim($data['text']);

        if (!empty($text))
        {
            $text = htmlspecialchars($text);
            
            $sql = "SELECT `logo_id`
                    FROM `logo`
                    WHERE `logo_team_id`=$num_get
                    AND `logo_user_id`=$auth_user_id
                    LIMIT 1";
            $logo_sql = f_igosja_mysqli_query($sql);

            if (0 == $logo_sql->num_rows)
            {
                $sql = "INSERT INTO `logo`
                        SET `logo_date`=UNIX_TIMESTAMP(),
                            `logo_team_id`=$num_get,
                            `logo_text`=?,
                            `logo_user_id`=$auth_user_id";
            }
            else
            {
                $logo_array = $logo_sql->fetch_all(MYSQLI_ASSOC);

                $logo_id = $logo_array[0]['logo_id'];

                $sql = "UPDATE `logo`
                        SET `logo_date`=UNIX_TIMESTAMP(),
                            `logo_text`=?
                        WHERE `logo_id`=$logo_id";
            }

            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();
            $prepare->close();

            f_igosja_session_front_flash_set('success', 'Эмблема успешно отправлена на проверку.');
        }
    }

    refresh();
}

$sql = "SELECT `country_id`,
               `country_name`,
               `city_name`,
               `team_id`,
               `team_name`
        FROM `logo`
        LEFT JOIN `team`
        ON `logo_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        ORDER BY `logo_id` ASC";
$logo_sql = f_igosja_mysqli_query($sql);

$logo_array = $logo_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Загрузить эмблему';
$seo_description    = 'Загрузить эмблему на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'Загрузить эмблему';

include(__DIR__ . '/view/layout/main.php');