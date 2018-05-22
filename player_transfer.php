<?php

/**
 * @var $auth_team_id integer
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
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
                    f_igosja_session_front_flash_set('error', 'Нельзя снимать игроков с трансферного рынка, если в команде отрицательный баланс.');

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

                f_igosja_session_front_flash_set('success', 'Игрок успешно снят с трансфера.');

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
                    ORDER BY `transferapplication_price` DESC, `transferapplication_date` ASC";
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
                    f_igosja_session_front_flash_set('error', 'Нельзя продать игрока сборной.');

                    refresh();
                }

                if ($player_array[0]['player_noaction'] > time())
                {
                    f_igosja_session_front_flash_set('error', 'С игроком нельзя совершать никаких действий до ' . f_igosja_ufu_date($player_array[0]['player_noaction']) . '.');

                    refresh();
                }

                if (0 != $player_array[0]['player_nodeal'])
                {
                    f_igosja_session_front_flash_set('error', 'Игрока нельзя выставить на трансфер до конца сезона.');

                    refresh();
                }

                if (0 != $player_array[0]['player_rent_team_id'])
                {
                    f_igosja_session_front_flash_set('error', 'Нельзя выставить на трансфер игроков, отданных в данный момент в аренду.');

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
                    f_igosja_session_front_flash_set('error', 'Нельзя одновременно выставлять на трансферный рынок более пяти игроков.');

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
                        f_igosja_session_front_flash_set('error', 'Нельзя продать вратаря, если у вас в команде останется менее двух вратарей.');

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
                        f_igosja_session_front_flash_set('error', 'Нельзя продать полевого игрока, если у вас в команде останется менее двадцати полевых игроков.');

                        refresh();
                    }
                }

                if ($player_array[0]['player_age'] < 19)
                {
                    f_igosja_session_front_flash_set('error', 'Нельзя продавать игроков младше 19 лет.');

                    refresh();
                }

                if ($player_array[0]['player_age'] > 38)
                {
                    f_igosja_session_front_flash_set('error', 'Нельзя продавать игроков старше 38 лет.');

                    refresh();
                }

                if ($transfer_price > $price)
                {
                    f_igosja_session_front_flash_set('error', 'Начальная цена должна быть не меньше ' . f_igosja_money_format($transfer_price) . '.');

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
                    f_igosja_session_front_flash_set('error', 'Нельзя продать игрока, который находится на тренировке.');

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
                        SET `transfer_date`=UNIX_TIMESTAMP(),
                            `transfer_player_id`=$num_get,
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

                f_igosja_session_front_flash_set('success', 'Игрок успешно выставлен на трансфер.');

                refresh();
            }
        }
    }
    else
    {
        $my_player = false;

        $sql = "SELECT `transfer_id`,
                       `transfer_price_seller`,
                       `transfer_team_seller_id`,
                       `transfer_user_seller_id`
                FROM `transfer`
                WHERE `transfer_player_id`=$num_get
                AND `transfer_ready`=0
                LIMIT 1";
        $transfer_sql = f_igosja_mysqli_query($sql);

        if ($transfer_sql->num_rows)
        {
            $on_transfer        = true;
            $transfer_only_one  = 0;

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
                           `transferapplication_only_one`,
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

                $transfer_price     = $transferapplication_array[0]['transferapplication_price'];
                $transfer_only_one  = $transferapplication_array[0]['transferapplication_only_one'];
                $start_price        = $transfer_array[0]['transfer_price_seller'];

                if (isset($data['off']))
                {
                    $transferapplication_id = $transferapplication_array[0]['transferapplication_id'];

                    $sql = "DELETE FROM `transferapplication`
                            WHERE `transferapplication_id`=$transferapplication_id
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);

                    f_igosja_session_front_flash_set('success', 'Заявка успешно удалена.');

                    redirect('/player_transfer.php?num=' . $num_get);
                }
                elseif (isset($data['price']))
                {
                    $price = (int) $data['price'];

                    if ($start_price > $price)
                    {
                        f_igosja_session_front_flash_set('error', 'Цена должна быть не меньше ' . f_igosja_money_format($start_price) . '.');

                        refresh();
                    }

                    $transferapplication_id = $transferapplication_array[0]['transferapplication_id'];

                    $only_one = (int) $data['only_one'];

                    if (!in_array($only_one, array(0, 1)))
                    {
                        $only_one = 0;
                    }

                    $sql = "UPDATE `transferapplication`
                            SET `transferapplication_price`=$price,
                                `transferapplication_only_one`=$only_one
                            WHERE `transferapplication_id`=$transferapplication_id
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);

                    f_igosja_session_front_flash_set('success', 'Заявка успешно отредактирована.');

                    refresh();
                }
            }
            else
            {
                if ($auth_team_id == $transfer_array[0]['transfer_team_seller_id'])
                {
                    f_igosja_session_front_flash_set('error', 'Нельзя покупать игрока у своей команды.');

                    refresh();
                }

                if ($auth_user_id == $transfer_array[0]['transfer_user_seller_id'])
                {
                    f_igosja_session_front_flash_set('error', 'Нельзя покупать игрока у своей команды.');

                    refresh();
                }

                $transfer_price = $transfer_array[0]['transfer_price_seller'];
                $start_price    = $transfer_array[0]['transfer_price_seller'];

                if (isset($data['price']))
                {
                    $transfer_team_id = $transfer_array[0]['transfer_team_seller_id'];
                    $transfer_user_id = $transfer_array[0]['transfer_user_seller_id'];

                    $team_array = array(0);

                    $sql = "SELECT `transfer_team_buyer_id`,
                                   `transfer_team_seller_id`
                            FROM `transfer`
                            WHERE `transfer_ready`=1
                            AND (`transfer_team_buyer_id`=$transfer_team_id
                            OR `transfer_team_seller_id`=$transfer_team_id)
                            AND `transfer_team_buyer_id`!=0
                            AND `transfer_team_seller_id`!=0
                            AND `transfer_season_id`=$igosja_season_id
                            ORDER BY `transfer_id` ASC";
                    $history_sql = f_igosja_mysqli_query($sql);

                    $history_array = $history_sql->fetch_all(MYSQLI_ASSOC);

                    foreach ($history_array as $item)
                    {
                        if (!in_array($item['transfer_team_buyer_id'], array(0, $transfer_team_id)))
                        {
                            $team_array[] = $item['transfer_team_buyer_id'];
                        }

                        if (!in_array($item['transfer_team_seller_id'], array(0, $transfer_team_id)))
                        {
                            $team_array[] = $item['transfer_team_seller_id'];
                        }
                    }

                    $sql = "SELECT `rent_team_buyer_id`,
                                   `rent_team_seller_id`
                            FROM `rent`
                            WHERE `rent_ready`=1
                            AND (`rent_team_buyer_id`=$transfer_team_id
                            OR `rent_team_seller_id`=$transfer_team_id)
                            AND `rent_team_buyer_id`!=0
                            AND `rent_team_seller_id`!=0
                            AND `rent_season_id`=$igosja_season_id
                            ORDER BY `rent_id` ASC";
                    $history_sql = f_igosja_mysqli_query($sql);

                    $history_array = $history_sql->fetch_all(MYSQLI_ASSOC);

                    foreach ($history_array as $item)
                    {
                        if (!in_array($item['rent_team_buyer_id'], array(0, $transfer_team_id)))
                        {
                            $team_array[] = $item['rent_team_buyer_id'];
                        }

                        if (!in_array($item['rent_team_seller_id'], array(0, $transfer_team_id)))
                        {
                            $team_array[] = $item['rent_team_seller_id'];
                        }
                    }

                    if (in_array($auth_team_id, $team_array))
                    {
                        f_igosja_session_front_flash_set('error', 'Ваши команды уже заключали сделку в текущем сезоне.');

                        refresh();
                    }

                    $user_array = array(0);

                    $sql = "SELECT `transfer_user_buyer_id`,
                                   `transfer_user_seller_id`
                            FROM `transfer`
                            WHERE `transfer_ready`=1
                            AND (`transfer_user_buyer_id`=$transfer_user_id
                            OR `transfer_user_seller_id`=$transfer_user_id)
                            AND `transfer_user_buyer_id`!=0
                            AND `transfer_user_seller_id`!=0
                            AND `transfer_season_id`=$igosja_season_id
                            ORDER BY `transfer_id` ASC";
                    $history_sql = f_igosja_mysqli_query($sql);

                    $history_array = $history_sql->fetch_all(MYSQLI_ASSOC);

                    foreach ($history_array as $item)
                    {
                        if (!in_array($item['transfer_user_buyer_id'], array(0, $transfer_user_id)))
                        {
                            $user_array[] = $item['transfer_user_buyer_id'];
                        }

                        if (!in_array($item['transfer_user_seller_id'], array(0, $transfer_user_id)))
                        {
                            $user_array[] = $item['transfer_user_seller_id'];
                        }
                    }

                    $sql = "SELECT `rent_user_buyer_id`,
                                   `rent_user_seller_id`
                            FROM `rent`
                            WHERE `rent_ready`=1
                            AND (`rent_user_buyer_id`=$transfer_user_id
                            OR `rent_user_seller_id`=$transfer_user_id)
                            AND `rent_user_buyer_id`!=0
                            AND `rent_user_seller_id`!=0
                            AND `rent_season_id`=$igosja_season_id
                            ORDER BY `rent_id` ASC";
                    $history_sql = f_igosja_mysqli_query($sql);

                    $history_array = $history_sql->fetch_all(MYSQLI_ASSOC);

                    foreach ($history_array as $item)
                    {
                        if (!in_array($item['rent_user_buyer_id'], array(0, $transfer_user_id)))
                        {
                            $user_array[] = $item['rent_user_buyer_id'];
                        }

                        if (!in_array($item['rent_user_seller_id'], array(0, $transfer_user_id)))
                        {
                            $user_array[] = $item['rent_user_seller_id'];
                        }
                    }

                    if (in_array($auth_user_id, $user_array))
                    {
                        f_igosja_session_front_flash_set('error', 'Вы уже заключали сделку с этим менеджером в текущем сезоне.');

                        refresh();
                    }

                    $price = (int) $data['price'];

                    if ($start_price > $price)
                    {
                        f_igosja_session_front_flash_set('error', 'Цена должна быть не меньше ' . f_igosja_money_format($start_price) . '.');

                        refresh();
                    }

                    $only_one = (int) $data['only_one'];

                    if (!in_array($only_one, array(0, 1)))
                    {
                        $only_one = 0;
                    }

                    $sql = "INSERT INTO `transferapplication`
                            SET `transferapplication_date`=UNIX_TIMESTAMP(),
                                `transferapplication_only_one`=$only_one,
                                `transferapplication_price`=$price,
                                `transferapplication_team_id`=$auth_team_id,
                                `transferapplication_transfer_id`=$transfer_id,
                                `transferapplication_user_id`=$auth_user_id";
                    f_igosja_mysqli_query($sql);

                    f_igosja_session_front_flash_set('success', 'Заявка успешно сохранена.');

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