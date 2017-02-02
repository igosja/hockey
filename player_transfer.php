<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include (__DIR__ . '/include/sql/player_view.php');

if (isset($auth_team_id))
{
    if ($player_array[0]['team_id'] == $auth_team_id)
    {
        $my_player = true;

        $sql = "SELECT `transfer_id`,
                       `transfer_price`
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
            $transfer_price = $transfer_array[0]['transfer_price'];

            $sql = "SELECT `transferapplication_price`
                    FROM `transferapplication`
                    WHERE `transferapplication_transfer_id`=$transfer_id
                    ORDER BY `transferapplication_id` ASC";
            $transferapplication_sql = f_igosja_mysqli_query($sql);

            $transferapplication_array = $transferapplication_sql->fetch_all(1);
        }
        else
        {
            $on_transfer = false;

            $transfer_price = ceil($player_array[0]['player_price'] / 2);
        }
    }
    else
    {
        $my_player = false;

        $sql = "SELECT `transfer_id`,
                       `transfer_price`
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

            $sql = "SELECT `transferapplication_price`
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
            }
            else
            {
                $transfer_price = $transfer_array[0]['transfer_price'];
            }
        }
        else
        {
            $on_transfer = false;
        }
    }
}

include (__DIR__ . '/view/layout/main.php');