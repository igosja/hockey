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

        $sql = "SELECT `transfer_id`,
                       `transfer_price_seller`,
                       `transfer_to_league`
                FROM `transfer`
                WHERE `transfer_player_id`=$num_get
                AND `transfer_ready`=0
                LIMIT 1";
        $transfer_sql = f_igosja_mysqli_query($sql);

        if ($transfer_sql->num_rows)
        {
            $on_transfer = true;

            $transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

            $transfer_id    = $transfer_array[0]['transfer_id'];
            $transfer_price = $transfer_array[0]['transfer_price_seller'];

            if (isset($data['off']))
            {
                $sql = "SELECT `team_finance`
                        FROM `team`
                        WHERE `team_id`=$auth_team_id
                        LIMIT 1";
                $finance_sql = f_igosja_mysqli_query($sql);

                $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

                if ($finance_array[0]['team_finance'] < 0)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Нельзя снимать игроков с трансферного рынка, если в команде отрицательный баланс.';

                    refresh();
                }

                $sql = "DELETE FROM `transfer`
                        WHERE `transfer_id`=$transfer_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "DELETE FROM `transferapplication`
                        WHERE `transferapplication_transfer_id`=$transfer_id";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `player`
                        SET `player_transfer_on`=0
                        WHERE `player_id`=$num_get
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $_SESSION['message']['class']   = 'success';
                $_SESSION['message']['text']    = 'Игрок успешно снят с трансфера.';

                refresh();
            }

            $sql = "SELECT `city_name`,
                           `country_name`,
                           `team_id`,
                           `team_name`,
                           `transferapplication_date`,
                           `transferapplication_price`
                    FROM `transferapplication`
                    LEFT JOIN `team`
                    ON `transferapplication_team_id`=`team_id`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    LEFT JOIN `country`
                    ON `city_country_id`=`country_id`
                    WHERE `transferapplication_transfer_id`=$transfer_id
                    ORDER BY `transferapplication_id` ASC";
            $transferapplication_sql = f_igosja_mysqli_query($sql);

            $transferapplication_array = $transferapplication_sql->fetch_all(MYSQLI_ASSOC);
        }
        else
        {
            $on_transfer = false;

            $transfer_price = ceil($player_array[0]['player_price'] / 2);

            if (isset($data['price']))
            {
                $price = (int) $data['price'];

                if (0 != $player_array[0]['player_national_id'])
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Нельзя продать игрока сборной.';

                    refresh();
                }

                if ($player_array[0]['player_noaction'] > time())
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'С игроком нельзя совершать никаких действий до ' . f_igosja_ufu_date($player_array[0]['player_noaction']) . '.';

                    refresh();
                }

                if (0 != $player_array[0]['player_rent_team_id'])
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Нельзя выставить на трансфер игроков, отданных в данный момент в аренду.';

                    refresh();
                }

                $sql = "SELECT COUNT(`transfer_id`) AS `check`
                        FROM `transfer`
                        WHERE `transfer_team_seller_id`=$auth_team_id
                        AND `transfer_ready`=0";
                $check_sql = f_igosja_mysqli_query($sql);

                $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                if ($check_array[0]['check'] > 5)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Нельзя одновременно выставлять на трансферный рынок более пяти игроков.';

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

                    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                    $check_on_transfer = $check_array[0]['check'];

                    $sql = "SELECT COUNT(`rent_id`) AS `check`
                            FROM `rent`
                            LEFT JOIN `player`
                            ON `rent_player_id`=`player_id`
                            WHERE `rent_team_seller_id`=$auth_team_id
                            AND `player_position_id`=" . POSITION_GK . "
                            AND `rent_ready`=0";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                    $check_on_rent = $check_array[0]['check'];

                    $check = $check_in_team - $check_on_transfer - $check_on_rent - 1;

                    if ($check < 2)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Нельзя продать вратаря, если у вас в команде останется менее двух вратарей.';

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

                    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                    $check_on_transfer = $check_array[0]['check'];

                    $sql = "SELECT COUNT(`rent_id`) AS `check`
                            FROM `rent`
                            LEFT JOIN `player`
                            ON `rent_player_id`=`player_id`
                            WHERE `rent_team_seller_id`=$auth_team_id
                            AND `player_position_id`!=" . POSITION_GK . "
                            AND `rent_ready`=0";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                    $check_on_rent = $check_array[0]['check'];

                    $check = $check_in_team - $check_on_transfer - $check_on_rent - 1;

                    if ($check < 20)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Нельзя продать полевого игрока, если у вас в команде останется менее двадцати полевых игроков.';

                        refresh();
                    }
                }

                if ($player_array[0]['player_age'] < 19)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Нельзя продавать игроков младше 19 лет.';

                    refresh();
                }

                if ($player_array[0]['player_age'] > 38)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Нельзя продавать игроков старше 38 лет.';

                    refresh();
                }

                if ($transfer_price > $price)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Начальная цена должна быть не меньше ' . f_igosja_money_format($transfer_price) . '.';

                    refresh();
                }

                $sql = "SELECT COUNT(`training_id`) AS `check`
                        FROM `training`
                        WHERE `training_ready`=0
                        AND `training_player_id`=$num_get";
                $training_sql = f_igosja_mysqli_query($sql);

                $training_array = $training_sql->fetch_all(MYSQLI_ASSOC);

                if (0 != $training_array[0]['check'])
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Нельзя продать игрока, который находится на тренировке.';

                    refresh();
                }

                if (isset($data['to_league']))
                {
                    $to_league = 1;
                }
                else
                {
                    $to_league = 0;
                }

                $sql = "INSERT INTO `transfer`
                        SET `transfer_player_id`=$num_get,
                            `transfer_price_seller`=$price,
                            `transfer_team_seller_id`=$auth_team_id,
                            `transfer_to_league`=$to_league,
                            `transfer_user_seller_id`=$auth_user_id";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `player`
                        SET `player_transfer_on`=1
                        WHERE `player_id`=$num_get
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $_SESSION['message']['class']   = 'success';
                $_SESSION['message']['text']    = 'Игрок успешно выставлен на трансфер.';

                refresh();
            }
        }
    }
    else
    {
        $my_player = false;

        $sql = "SELECT `transfer_id`,
                       `transfer_price_seller`
                FROM `transfer`
                WHERE `transfer_player_id`=$num_get
                AND `transfer_ready`=0
                LIMIT 1";
        $transfer_sql = f_igosja_mysqli_query($sql);

        if ($transfer_sql->num_rows)
        {
            $on_transfer = true;

            $transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

            $transfer_id = $transfer_array[0]['transfer_id'];

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

            $sql = "SELECT `transferapplication_id`,
                           `transferapplication_price`
                    FROM `transferapplication`
                    WHERE `transferapplication_transfer_id`=$transfer_id
                    AND `transferapplication_team_id`=$auth_team_id
                    AND `transferapplication_user_id`=$auth_user_id
                    LIMIT 1";
            $transferapplication_sql = f_igosja_mysqli_query($sql);

            if ($transferapplication_sql->num_rows)
            {
                $transferapplication_array = $transferapplication_sql->fetch_all(MYSQLI_ASSOC);

                $transfer_price = $transferapplication_array[0]['transferapplication_price'];
                $start_price    = $transfer_array[0]['transfer_price_seller'];

                if (isset($data['off']))
                {
                    $transferapplication_id = $transferapplication_array[0]['transferapplication_id'];

                    $sql = "DELETE FROM `transferapplication`
                            WHERE `transferapplication_id`=$transferapplication_id
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);

                    $_SESSION['message']['class']   = 'success';
                    $_SESSION['message']['text']    = 'Заявка успешно удалена.';

                    redirect('/player_transfer.php?num=' . $num_get);
                }
                elseif (isset($data['price']))
                {
                    $price = (int) $data['price'];

                    if ($start_price > $price)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Цена должна быть не меньше ' . f_igosja_money_format($start_price) . '.';

                        refresh();
                    }

                    $transferapplication_id = $transferapplication_array[0]['transferapplication_id'];

                    $sql = "UPDATE `transferapplication`
                            SET `transferapplication_price`=$price
                            WHERE `transferapplication_id`=$transferapplication_id
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);

                    $_SESSION['message']['class']   = 'success';
                    $_SESSION['message']['text']    = 'Заявка успешно отредактирована.';

                    refresh();
                }
            }
            else
            {
                $transfer_price = $transfer_array[0]['transfer_price_seller'];
                $start_price    = $transfer_array[0]['transfer_price_seller'];

                if (isset($data['price']))
                {
                    $price = (int) $data['price'];

                    if ($start_price > $price)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Цена должна быть не меньше ' . f_igosja_money_format($start_price) . '.';

                        refresh();
                    }

                    $sql = "INSERT INTO `transferapplication`
                            SET `transferapplication_date`=UNIX_TIMESTAMP(),
                                `transferapplication_price`=$price,
                                `transferapplication_team_id`=$auth_team_id,
                                `transferapplication_transfer_id`=$transfer_id,
                                `transferapplication_user_id`=$auth_user_id";
                    f_igosja_mysqli_query($sql);

                    $_SESSION['message']['class']   = 'success';
                    $_SESSION['message']['text']    = 'Заявка успешно сохранена.';

                    refresh();
                }
            }
        }
        else
        {
            $on_transfer = false;
        }
    }
}

$seo_title          = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Трансфер хоккеиста';
$seo_description    = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Трансфер хоккеиста на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . ' трансфер хоккеиста';

include(__DIR__ . '/view/layout/main.php');