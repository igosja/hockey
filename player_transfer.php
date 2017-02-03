<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include (__DIR__ . '/include/sql/player_view.php');

$data = f_igosja_request('data');

if (isset($auth_team_id) && $auth_team_id)
{
    if ($player_array[0]['team_id'] == $auth_team_id)
    {
        $my_player = true;

        $sql = "SELECT `transfer_id`,
                       `transfer_price_buyer`
                FROM `transfer`
                WHERE `transfer_player_id`=$num_get
                AND `transfer_ready`=0
                LIMIT 1";
        $transfer_sql = f_igosja_mysqli_query($sql);

        if ($transfer_sql->num_rows)
        {
            $on_transfer = true;

            $transfer_array = $transfer_sql->fetch_all(1);

            $transfer_id    = $transfer_array[0]['transfer_id'];
            $transfer_price = $transfer_array[0]['transfer_price_buyer'];

            if (isset($data['off']))
            {
                $sql = "DELETE FROM `transfer`
                        WHERE `transfer_id`=$transfer_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "DELETE FROM `transferapplication`
                        WHERE `transferapplication_transfer_id`=$transfer_id";
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

            $transferapplication_array = $transferapplication_sql->fetch_all(1);
        }
        else
        {
            $on_transfer = false;

            $transfer_price = ceil($player_array[0]['player_price'] / 2);

            if (isset($data['price']))
            {
                $price = (int) $data['price'];

                if ($transfer_price > $price)
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Начальная цена должна быть не меньше ' . f_igosja_money($transfer_price) . '.';

                    refresh();
                }

                $sql = "INSERT INTO `transfer`
                        SET `transfer_player_id`=$num_get,
                            `transfer_price_buyer`=$price,
                            `transfer_team_seller_id`=$auth_team_id,
                            `transfer_user_seller_id`=$auth_user_id";
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
                       `transfer_price_buyer`
                FROM `transfer`
                WHERE `transfer_player_id`=$num_get
                AND `transfer_ready`=0
                LIMIT 1";
        $transfer_sql = f_igosja_mysqli_query($sql);

        if ($transfer_sql->num_rows)
        {
            $on_transfer = true;

            $transfer_array = $transfer_sql->fetch_all(1);

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

            $team_array = $team_sql->fetch_all(1);

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
                $transferapplication_array = $transferapplication_sql->fetch_all(1);

                $transfer_price = $transferapplication_array[0]['transferapplication_price'];
                $start_price    = $transfer_array[0]['transfer_price_buyer'];

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
                        $_SESSION['message']['text']    = 'Цена должна быть не меньше ' . f_igosja_money($start_price) . '.';

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
                $transfer_price = $transfer_array[0]['transfer_price_buyer'];
                $start_price    = $transfer_array[0]['transfer_price_buyer'];

                if (isset($data['price']))
                {
                    $price = (int) $data['price'];

                    if ($start_price > $price)
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Цена должна быть не меньше ' . f_igosja_money($start_price) . '.';

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

include (__DIR__ . '/view/layout/main.php');