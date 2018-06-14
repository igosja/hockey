<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/../include/include.php');

$result = '';

if (($limit = (int) f_igosja_request_get('limit')) && ($offset = (int) f_igosja_request_get('offset')) && isset($auth_user_id))
{
    $sql = "SELECT SQL_CALC_FOUND_ROWS
                   `message_date`,
                   `message_id`,
                   `message_text`,
                   `user_id`,
                   `user_login`
            FROM `message`
            LEFT JOIN `user`
            ON `message_user_id_from`=`user_id`
            WHERE (`message_support_to`=1
            AND `message_user_id_from`=$auth_user_id)
            OR (`message_support_from`=1
            AND `message_user_id_to`=$auth_user_id)
            ORDER BY `message_id` DESC
            LIMIT $offset, $limit";
    $message_sql = f_igosja_mysqli_query($sql);

    $message_array = $message_sql->fetch_all(MYSQLI_ASSOC);
    $message_array = array_reverse($message_array);

    $sql = "SELECT FOUND_ROWS() AS `count`";
    $total = f_igosja_mysqli_query($sql);
    $total = $total->fetch_all(MYSQLI_ASSOC);
    $total = $total[0]['count'];

    if ($total > $message_sql->num_rows + $offset)
    {
        $lazy = 1;
    }
    else
    {
        $lazy = 0;
    }

    $list = '';

    foreach ($message_array as $item)
    {
        $list = $list
                . '<div class="row margin-top"><div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-size-3">'
                . f_igosja_ufu_date_time($item['message_date'])
                . ', <a href="/user_view.php?num='
                . $item['user_id']
                . '">'
                . $item['user_login']
                . '</a></div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 message '
                . ($auth_user_id == $item['user_id'] ? 'message-from-me' : 'message-to-me')
                . '">'
                . f_igosja_bb_decode($item['message_text'])
                . '</div></div>';
    }

    $result = array(
        'offset'    => $offset + $limit,
        'lazy'      => $lazy,
        'list'      => $list,
    );
}

print json_encode($result);
exit;