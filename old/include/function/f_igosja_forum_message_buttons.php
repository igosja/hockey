<?php

/**
 * Виводимо кнопки дії над повідомленням на форумі
 * @param $forum_message array дані з БД по поточному повідомленню
 * @return string
 */

function f_igosja_forum_message_buttons($forum_message)
{
    global $auth_user_id;
    global $auth_userrole_id;

    $button_array = array();

    if (isset($auth_user_id))
    {
        if (($auth_user_id == $forum_message['user_id'] && 0 == $forum_message['forummessage_blocked']) || USERROLE_USER != $auth_userrole_id)
        {
            $button_array[] = '<a href="/forum_message_update.php?num=' . $forum_message['forummessage_id'] . '">Редактировать</a>';
        }

        if ($auth_user_id == $forum_message['user_id'] || USERROLE_USER != $auth_userrole_id)
        {
            $button_array[] = '<a href="/forum_message_delete.php?num=' . $forum_message['forummessage_id'] . '">Удалить</a>';
        }

        if ($auth_user_id != $forum_message['user_id'] && USERROLE_USER == $auth_userrole_id)
        {
            $button_array[] = '<a class="forum-complain" data-message="' . $forum_message['forummessage_id'] .'" href="javascript:">Пожаловаться</a>';
        }

        if (USERROLE_USER != $auth_userrole_id)
        {
            $button_array[] = '<a href="/forum_message_move.php?num=' . $forum_message['forummessage_id'] . '">Переместить</a>';

            if (0 == $forum_message['forummessage_blocked'])
            {
                $text = 'Блокировать';
            }
            else
            {
                $text = 'Разблокировать';
            }

            $button_array[] = '<a href="/forum_message_block.php?num=' . $forum_message['forummessage_id'] . '">' . $text . '</a>';
        }
    }

    $result = implode(' | ', $button_array);

    return $result;
}