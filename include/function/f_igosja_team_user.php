<?php

/**
 * Відображення команд менеджера
 * @param $user_id integer id менеджера
 * @param $userteam_array array масив с результатом запиту в БД (`team`)
 * @return string команды менеджера
 */
function f_igosja_team_user($user_id, $userteam_array)
{
    $return_array = array();

    foreach ($userteam_array as $item)
    {
        if (isset($item['team_user_id']) && $item['team_user_id'] == $user_id)
        {
            $return_array[] = '<br/>
                <img
                    alt="' . $item['country_name'] . '"
                    src="/img/country/12/' . $item['country_id'] . '.png"
                    title="' . $item['country_name'] . '"
                />
                <a href="/team_view.php?num=' . $item['team_id'] . '" target="_blank">
                    ' . $item['team_name'] . '
                    (' . $item['city_name'] . ')
                </a>';
        }
    }

    $return = implode(' ', $return_array);

    return $return;
}