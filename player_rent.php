<?php

/**
 * @var $auth_team_id integer
 * @var $auth_user_id integer
 * @var $player_array array
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/player_view.php');

$data = f_igosja_request('data');

if (isset($auth_team_id) && $auth_team_id)
{
    if ($player_array[0]['team_id'] == $auth_team_id)
    {
        $my_player = true;

        $sql = "SELECT `rent_day_max`,
                       `rent_day_min`,
                       `rent_id`,
                       `rent_price_seller`
                FROM `rent`
                WHERE `rent_player_id`=$num_get
                AND `rent_ready`=0
                LIMIT 1";
        $rent_sql = f_igosja_mysqli_query($sql);

        if ($rent_sql->num_rows)
        {
            $on_rent = true;

            $rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

            $rent_id        = $rent_array[0]['rent_id'];
            $rent_price     = $rent_array[0]['rent_price_seller'];
            $rent_day_min   = $rent_array[0]['rent_day_min'];
            $rent_day_max   = $rent_array[0]['rent_day_max'];

            if (isset($data['off']))
            {
                $sql = "DELETE FROM `rent`
                        WHERE `rent_id`=$rent_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "DELETE FROM `rentapplication`
                        WHERE `rentapplication_rent_id`=$rent_id";
                f_igosja_mysqli_query($sql);

                $_SESSION['message']['class']   = 'success';
                $_SESSION['message']['text']    = 'Игрок успешно снят с трансфера.';

                refresh();
            }

            $sql = "SELECT `city_name`,
                           `country_name`,
                           `team_id`,
                           `team_name`,
                           `rentapplication_date`,
                           `rentapplication_day`,
                           `rentapplication_price`
                    FROM `rentapplication`
                    LEFT JOIN `team`
                    ON `rentapplication_team_id`=`team_id`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    LEFT JOIN `country`
                    ON `city_country_id`=`country_id`
                    WHERE `rentapplication_rent_id`=$rent_id
                    ORDER BY `rentapplication_id` ASC";
            $rentapplication_sql = f_igosja_mysqli_query($sql);

            $rentapplication_array = $rentapplication_sql->fetch_all(MYSQLI_ASSOC);
        }
        else
        {
            $on_rent = false;

            $rent_price     = ceil($player_array[0]['player_price'] / 1000);
            $rent_day_min   = 1;
            $rent_day_max   = 10;

            if (isset($data['price']) && isset($data['day_min']) && isset($data['day_max']))
            {
                $price      = (int) $data['price'];
                $day_min    = (int) $data['day_min'];
                $day_max    = (int) $data['day_max'];

                if ($player_array[0]['player_noaction'] > time())
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'С игроком нельзя совершать никаких действий до ' . f_igosja_ufu_date($player_array[0]['player_noaction']) . '.';

                    refresh();
                }

                if (0 != $player_array[0]['player_rent_team_id'])
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Нельзя отдавать в аренду игроков, которые уже находятся в аренде.';

                    refresh();
                }

                $sql = "SELECT COUNT(`rent_id`) AS `check`
                        FROM `rent`
                        WHERE `rent_team_seller_id`=$auth_team_id
                        AND `rent_ready`=0";
                $check_sql = f_igosja_mysqli_query($sql);

                $check1_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                $sql = "SELECT COUNT(`player_id`) AS `check`
                        FROM `player`
                        WHERE `player_rent_team_id`=$auth_team_id";
                $check_sql = f_igosja_mysqli_query($sql);

                $check2_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                if ($check1_array[0]['check'] + $check2_array[0]['check'] > 5)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Нельзя отдавать в аренду более пяти игроков из одной команды одновременно.';

                    refresh();
                }

                if (POSITION_GK == $player_array[0]['player_position_id'])
                {
                    $sql = "SELECT COUNT(`player_id`) AS `check`
                            FROM `player`
                            WHERE `player_position_id`=" . POSITION_GK . "
                            AND `player_team_id`=$auth_team_id
                            AND `player_rent_team_id`=0";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                    $check_in_team = $check_array[0]['check'];

                    $sql = "SELECT COUNT(`transfer_id`) AS `check`
                            FROM `transfer`
                            LEFT JOIN `player`
                            ON `transfer_player_id`=`player_id`
                            WHERE `transfer_team_seller_id`=$auth_team_id
                            AND `player_position_id`=" . POSITION_GK . "
                            AND `transfer_ready`=0";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_on_transfer = $check_array[0]['check'];

                    $sql = "SELECT COUNT(`rent_id`) AS `check`
                            FROM `rent`
                            LEFT JOIN `player`
                            ON `rent_player_id`=`player_id`
                            WHERE `rent_team_seller_id`=$auth_team_id
                            AND `player_position_id`=" . POSITION_GK . "
                            AND `rent_ready`=0";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_on_rent = $check_array[0]['check'];

                    $check = $check_in_team - $check_on_transfer - $check_on_rent - 1;

                    if ($check < 2)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Нельзя отдать в аренду вратаря, если у вас в команде останется менее двух вратарей.';

                        refresh();
                    }
                }
                else
                {
                    $sql = "SELECT COUNT(`player_id`) AS `check`
                            FROM `player`
                            WHERE `player_position_id`!=" . POSITION_GK . "
                            AND `player_team_id`=$auth_team_id
                            AND `player_rent_team_id`=0";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                    $check_in_team = $check_array[0]['check'];

                    $sql = "SELECT COUNT(`transfer_id`) AS `check`
                            FROM `transfer`
                            LEFT JOIN `player`
                            ON `transfer_player_id`=`player_id`
                            WHERE `transfer_team_seller_id`=$auth_team_id
                            AND `player_position_id`!=" . POSITION_GK . "
                            AND `transfer_ready`=0";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_on_transfer = $check_array[0]['check'];

                    $sql = "SELECT COUNT(`rent_id`) AS `check`
                            FROM `rent`
                            LEFT JOIN `player`
                            ON `rent_player_id`=`player_id`
                            WHERE `rent_team_seller_id`=$auth_team_id
                            AND `player_position_id`!=" . POSITION_GK . "
                            AND `rent_ready`=0";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_on_rent = $check_array[0]['check'];

                    $check = $check_in_team - $check_on_transfer - 1;

                    if ($check < 20)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Нельзя отдать в аренду полевого игрока, если у вас в команде останется менее двадцати полевых игроков.';

                        refresh();
                    }
                }

                if ($player_array[0]['player_age'] < 19)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Нельзя отдать в аренду игроков младше 19 лет.';

                    refresh();
                }

                if ($player_array[0]['player_age'] > 38)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Нельзя отдать в аренду игроков старше 38 лет.';

                    refresh();
                }

                if ($rent_price > $price)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Начальная цена должна быть не меньше ' . f_igosja_money_format($rent_price) . '.';

                    refresh();
                }

                if ($rent_day_min > $day_min)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Минимальный срок аренды должен быть не меньше ' . $rent_day_min . ' ' . f_igosja_count_case($rent_day_min, 'дня', 'дней', 'дней') . '.';

                    refresh();
                }

                if ($rent_day_max < $day_max)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Максимальный срок аренды должен быть не больше ' . $rent_day_max . ' ' . f_igosja_count_case($rent_day_max, 'дня', 'дней', 'дней') . '.';

                    refresh();
                }

                if ($day_min > $day_max)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Максимальный срок аренды должен быть больше минимального.';

                    refresh();
                }

                $sql = "INSERT INTO `rent`
                        SET `rent_day_max`=$day_max,
                            `rent_day_min`=$day_min,
                            `rent_player_id`=$num_get,
                            `rent_price_seller`=$price,
                            `rent_team_seller_id`=$auth_team_id,
                            `rent_user_seller_id`=$auth_user_id";
                f_igosja_mysqli_query($sql);

                $_SESSION['message']['class']   = 'success';
                $_SESSION['message']['text']    = 'Игрок успешно выставлен на рынок аренды.';

                refresh();
            }
        }
    }
    else
    {
        $my_player = false;

        $sql = "SELECT `rent_day_max`,
                       `rent_day_min`,
                       `rent_id`,
                       `rent_price_seller`
                FROM `rent`
                WHERE `rent_player_id`=$num_get
                AND `rent_ready`=0
                LIMIT 1";
        $rent_sql = f_igosja_mysqli_query($sql);

        if ($rent_sql->num_rows)
        {
            $on_rent = true;

            $rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

            $rent_id = $rent_array[0]['rent_id'];

            $sql = "SELECT `city_name`,
                           `country_name`,
                           `team_finance`,
                           `team_id`,
                           `team_name`
                    FROM `team`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    LEFT JOIN `country`
                    ON `city_country_id`=`country_id`
                    WHERE `team_id`=$auth_team_id
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

            $sql = "SELECT `rentapplication_day`,
                           `rentapplication_id`,
                           `rentapplication_price`
                    FROM `rentapplication`
                    WHERE `rentapplication_rent_id`=$rent_id
                    AND `rentapplication_team_id`=$auth_team_id
                    AND `rentapplication_user_id`=$auth_user_id
                    LIMIT 1";
            $rentapplication_sql = f_igosja_mysqli_query($sql);

            if ($rentapplication_sql->num_rows)
            {
                $rentapplication_array = $rentapplication_sql->fetch_all(MYSQLI_ASSOC);

                $rent_price     = $rentapplication_array[0]['rentapplication_price'];
                $start_price    = $rent_array[0]['rent_price_seller'];
                $rent_day       = $rentapplication_array[0]['rentapplication_day'];
                $rent_day_min   = $rent_array[0]['rent_day_min'];
                $rent_day_max   = $rent_array[0]['rent_day_max'];

                if (isset($data['off']))
                {
                    $rentapplication_id = $rentapplication_array[0]['rentapplication_id'];

                    $sql = "DELETE FROM `rentapplication`
                            WHERE `rentapplication_id`=$rentapplication_id
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);

                    $_SESSION['message']['class']   = 'success';
                    $_SESSION['message']['text']    = 'Заявка успешно удалена.';

                    redirect('/player_rent.php?num=' . $num_get);
                }
                elseif (isset($data['price']) && isset($data['day']))
                {
                    $price  = (int) $data['price'];
                    $day    = (int) $data['day'];

                    if ($start_price > $price)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Цена должна быть не меньше ' . f_igosja_money_format($start_price) . '.';

                        refresh();
                    }

                    if ($rent_day_min > $day)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Минимальный срок аренды должен быть не меньше ' . $rent_day_min . ' ' . f_igosja_count_case($rent_day_min, 'дня', 'дней', 'дней') . '.';

                        refresh();
                    }

                    if ($rent_day_max < $day)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Максимальный срок аренды должен быть не больше ' . $rent_day_max . ' ' . f_igosja_count_case($rent_day_max, 'дня', 'дней', 'дней') . '.';

                        refresh();
                    }

                    $rentapplication_id = $rentapplication_array[0]['rentapplication_id'];

                    $sql = "UPDATE `rentapplication`
                            SET `rentapplication_day`=$day,
                                `rentapplication_price`=$price
                            WHERE `rentapplication_id`=$rentapplication_id
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);

                    $_SESSION['message']['class']   = 'success';
                    $_SESSION['message']['text']    = 'Заявка успешно отредактирована.';

                    refresh();
                }
            }
            else
            {
                $rent_price     = $rent_array[0]['rent_price_seller'];
                $start_price    = $rent_array[0]['rent_price_seller'];
                $rent_day       = $rent_array[0]['rent_day_min'];
                $rent_day_min   = $rent_array[0]['rent_day_min'];
                $rent_day_max   = $rent_array[0]['rent_day_max'];

                if (isset($data['price']) && isset($data['day']))
                {
                    $price  = (int) $data['price'];
                    $day    = (int) $data['day'];

                    if ($start_price > $price)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Цена должна быть не меньше ' . f_igosja_money_format($start_price) . '.';

                        refresh();
                    }

                    if ($rent_day_min > $day)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Минимальный срок аренды должен быть не меньше ' . $rent_day_min . ' дней.';

                        refresh();
                    }

                    if ($rent_day_max < $day)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Максимальный срок аренды должен быть не больше ' . $rent_day_max . ' дней.';

                        refresh();
                    }

                    $sql = "INSERT INTO `rentapplication`
                            SET `rentapplication_date`=UNIX_TIMESTAMP(),
                                `rentapplication_day`=$day,
                                `rentapplication_price`=$price,
                                `rentapplication_team_id`=$auth_team_id,
                                `rentapplication_rent_id`=$rent_id,
                                `rentapplication_user_id`=$auth_user_id";
                    f_igosja_mysqli_query($sql);

                    $_SESSION['message']['class']   = 'success';
                    $_SESSION['message']['text']    = 'Заявка успешно сохранена.';

                    refresh();
                }
            }
        }
        else
        {
            $on_rent = false;
        }
    }
}

$seo_title          = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Аренда хоккеиста';
$seo_description    = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Аренда хоккеиста на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . ' аренда хоккеиста';

include(__DIR__ . '/view/layout/main.php');