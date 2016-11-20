<?php

include (__DIR__ . '/include/include.php');

$result = '';

if ($email = f_igosja_post('signup_email'))
{
    $email  = trim($email);
    $result = f_igosja_check_user_by_email($email);
}
elseif ($login = f_igosja_post('signup_login'))
{
    $login  = trim($login);
    $result = f_igosja_check_user_by_login($login);
}
elseif ($phisical_id = (int) f_igosja_get('phisical_id'))
{
    $player_id      = (int) f_igosja_get('player_id');
    $shedule_id     = (int) f_igosja_get('shedule_id');

    $sql = "SELECT `phisical_id`,
                   `phisical_opposite`,
                   `phisical_value`
            FROM `phisical`
            ORDER BY `phisical_id` ASC";
    $phisical_sql = igosja_db_query($sql);

    $phisical_sql = $phisical_sql->fetch_all(1);

    $phisical_array = array();

    foreach ($phisical_sql as $item)
    {
        $phisical_array[$item['phisical_id']] = array(
            'opposite'  => (int) $item['phisical_opposite'],
            'value'     => (int) $item['phisical_value'],
        );
    }

    $sql = "SELECT `shedule_id`
            FROM `shedule`
            WHERE `shedule_id`>='$shedule_id'
            AND `shedule_tournamenttype_id`!='" . TOURNAMENTTYPE_CONFERENCE . "'
            ORDER BY `shedule_id` ASC";
    $shedule_sql = igosja_db_query($sql);

    $count_shedule = $shedule_sql->num_rows;
    $shedule_array = $shedule_sql->fetch_all(1);

    $result = array();

    for ($i=0; $i<$count_shedule; $i++)
    {
        if (0 == $i)
        {
            $phisical_id = $phisical_array[$phisical_id]['opposite'];
        }
        else
        {
            $phisical_id++;

            if (20 < $phisical_id)
            {
                $phisical_id = $phisical_id - 20;
            }
        }

        $result[] = array(
            'id'                => $player_id . '-' . $shedule_array[$i]['shedule_id'],
            'phisical_id'       => $phisical_id,
            'phisical_value'    => $phisical_array[$phisical_id]['value'],
        );
    }
}

print json_encode($result);
exit;