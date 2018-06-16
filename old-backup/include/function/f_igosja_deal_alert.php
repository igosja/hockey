<?php

/**
 * Формуємо массив з інформацією по угоді
 * @param $seller_team_id integer
 * @param $seller_user_id integer
 * @param $buyer_team_id integer
 * @param $buyer_user_id integer
 * @return array
 */
function f_igosja_deal_alert($seller_team_id, $seller_user_id, $buyer_team_id, $buyer_user_id)
{
    global $igosja_season_id;

    $result = array(
        'success' => array(),
        'warning' => array(),
        'error'   => array(),
    );

    for ($i=0; $i<2; $i++)
    {
        if (0 == $i)
        {
            $team_id = $buyer_team_id;
            $user_id = $buyer_user_id;
        }
        else
        {
            $team_id = $seller_team_id;
            $user_id = $seller_user_id;
        }

        if (0 != $user_id && 0 != $team_id)
        {
            $sql = "SELECT `history_date`,
                           `history_historytext_id`,
                           `team_name`,
                           `user_login`
                    FROM `history`
                    LEFT JOIN `team`
                    ON `history_team_id`=`team_id`
                    LEFT JOIN `user`
                    ON `history_user_id`=`user_id`
                    WHERE `history_historytext_id` IN (" . HISTORYTEXT_USER_MANAGER_TEAM_IN . ", " . HISTORYTEXT_USER_MANAGER_TEAM_OUT. ")
                    AND `history_team_id`=$team_id
                    AND `history_user_id`=$user_id
                    ORDER BY `history_id` DESC
                    LIMIT 1";
            $history_sql = f_igosja_mysqli_query($sql);

            $history_array = $history_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($history_array as $item)
            {
                if (HISTORYTEXT_USER_MANAGER_TEAM_OUT == $item['history_historytext_id'])
                {
                    $result['error'][] = 'Менеджер <span class="strong">' . $item['user_login'] . '</span> покинул команду <span class="strong">' . $history_array[0]['team_name'] . '</span>.';
                }

                if ($item['history_date'] > time() - 2592000)
                {
                    $result['error'][] = 'Менеджер <span class="strong">' . $item['user_login'] . '</span> менее 1 месяца в команде.';
                }
                elseif ($item['history_date'] > time() - 5184000)
                {
                    $result['warning'][] = 'Менеджер <span class="strong">' . $item['user_login'] . '</span> менее 2 месяцев в команде.';
                }
            }

            $sql = "SELECT `user_date_login`,
                           `user_date_register`,
                           `user_login`
                    FROM `user`
                    WHERE `user_id`=$user_id
                    LIMIT 1";
            $user_sql = f_igosja_mysqli_query($sql);

            $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($user_array as $item)
            {
                if ($item['user_date_login'] < time() - 604800)
                {
                    $result['error'][] = 'Менеджер <span class="strong">' . $item['user_login'] . '</span> больше недели не заходил на сайт.';
                }

                if ($item['user_date_register'] > time() - 2592000)
                {
                    $result['error'][] = 'Менеджер <span class="strong">' . $item['user_login'] . '</span> менее 1 месяца в Лиге.';
                }
                elseif ($item['user_date_register'] > time() - 5184000)
                {
                    $result['warning'][] = 'Менеджер <span class="strong">' . $item['user_login'] . '</span> менее 2 месяцев в Лиге.';
                }
            }

            $sql = "SELECT `team_auto`,
                           `team_name`
                    FROM `team`
                    WHERE `team_id`=$team_id
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($team_array as $item)
            {
                if (0 != $item['team_auto'])
                {
                    $result['warning'][] = 'Команда <span class="strong">' . $item['team_name'] . '</span> сыграла ' . $item['team_auto'] . ' ' . f_igosja_count_case($item['team_auto'], 'последний матч', 'последних матча', 'последних матчей') . ' автосоставом.';
                }
            }

            $sql = "SELECT COUNT(`transfer_id`) AS `count`
                    FROM `transfer`
                    WHERE (`transfer_user_buyer_id`=$user_id
                    OR `transfer_user_seller_id`=$user_id)
                    AND `transfer_season_id`=$igosja_season_id
                    AND `transfer_cancel`=1";
            $transfer_sql = f_igosja_mysqli_query($sql);

            $transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

            $sql = "SELECT COUNT(`rent_id`) AS `count`
                    FROM `rent`
                    WHERE (`rent_user_buyer_id`=$user_id
                    OR `rent_user_seller_id`=$user_id)
                    AND `rent_season_id`=$igosja_season_id
                    AND `rent_cancel`=1";
            $rent_sql = f_igosja_mysqli_query($sql);

            $rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

            if (0 != $transfer_array[0]['count'] + $rent_array[0]['count'])
            {
                $sql = "SELECT `user_login`
                        FROM `user`
                        WHERE `user_id`=$user_id
                        LIMIT 1";
                $user_sql = f_igosja_mysqli_query($sql);

                $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

                $result['warning'][] = 'У менеджера <span class="strong">' . $user_array[0]['user_login'] . '</span> в этом сезоне уже отменяли <span class="strong">' .  ($transfer_array[0]['count'] + $rent_array[0]['count']) . ' ' . f_igosja_count_case( $transfer_array[0]['count'] + $rent_array[0]['count'], 'сделку', 'сделки', 'сделок') . '</span>.';
            }
        }
    }

    if (0 != $buyer_team_id && 0 != $buyer_user_id && 0 != $seller_team_id && 0 != $seller_user_id)
    {
        $sql = "SELECT COUNT(`transfer_id`) AS `count`
                FROM `transfer`
                WHERE ((`transfer_user_buyer_id`=$buyer_user_id
                AND `transfer_user_seller_id`=$seller_user_id)
                OR (`transfer_user_buyer_id`=$seller_user_id
                AND `transfer_user_seller_id`=$buyer_user_id))
                AND `transfer_checked`=1
                AND `transfer_cancel`=0";
        $transfer_sql = f_igosja_mysqli_query($sql);

        $transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

        $sql = "SELECT COUNT(`rent_id`) AS `count`
                FROM `rent`
                WHERE ((`rent_user_buyer_id`=$buyer_user_id
                AND `rent_user_seller_id`=$seller_user_id)
                OR (`rent_user_buyer_id`=$seller_user_id
                AND `rent_user_seller_id`=$buyer_user_id))
                AND `rent_checked`=1
                AND `rent_cancel`=0";
        $rent_sql = f_igosja_mysqli_query($sql);

        $rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

        if (0 != $transfer_array[0]['count'] + $rent_array[0]['count'])
        {
            $result['warning'][] = 'Менеджеры уже заключали <span class="strong">' .  ($transfer_array[0]['count'] + $rent_array[0]['count']) . ' ' . f_igosja_count_case( $transfer_array[0]['count'] + $rent_array[0]['count'], 'сделку', 'сделки', 'сделок') . '</span> между собой.';
        }

        $sql = "SELECT COUNT(`user_id`) AS `count`
                FROM `user`
                WHERE `user_id` IN ($buyer_user_id, $seller_user_id)
                AND `user_date_register`<UNIX_TIMESTAMP()-5184000";
        $user_sql = f_igosja_mysqli_query($sql);

        $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

        if (2 == $user_array[0]['count'])
        {
            $result['success'][] = 'Оба менеджера достаточно давно играют в Лиге.';
        }
    }

    if (0 == count($result['success']))
    {
        unset($result['success']);
    }

    if (0 == count($result['warning']))
    {
        unset($result['warning']);
    }

    if (0 == count($result['error']))
    {
        unset($result['error']);
    }

    return $result;
}