<?php

/**
 * @var $igosja_menu_login array
 * @var $igosja_menu_login_mobile array
 * @var $igosja_menu_guest array
 * @var $igosja_menu_guest_mobile array
 */

if (!isset($_SESSION['user_id']))
{
    if ($login_code = f_igosja_cookie('login_code'))
    {
        $login_code = explode('-', $login_code);

        if (isset($login_code[0]) && $login_code[1])
        {
            $sql = "SELECT `user_id`
                    FROM `user`
                    WHERE `user_code`=?
                    LIMIT 1";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $login_code[0]);
            $prepare->execute();

            $user_sql = $prepare->get_result();

            $prepare->close();

            if (0 != $user_sql->num_rows && f_igosja_login_code($login_code[1]))
            {
                $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

                $_SESSION['user_id'] = $user_array[0]['user_id'];

                refresh();
            }
        }
    }
}

if (!isset($_SESSION['admin_user_id']))
{
    if ($login_code = f_igosja_cookie('admin_login_code'))
    {
        $login_code = explode('-', $login_code);

        if (isset($login_code[0]) && $login_code[1])
        {
            $sql = "SELECT `user_id`
                    FROM `user`
                    WHERE `user_code`=?
                    AND `user_userrole_id`=" . USERROLE_ADMIN . "
                    LIMIT 1";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $login_code[0]);
            $prepare->execute();

            $user_sql = $prepare->get_result();

            $prepare->close();

            if (0 != $user_sql->num_rows && f_igosja_login_code($login_code[1]))
            {
                $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

                $_SESSION['admin_user_id'] = $user_array[0]['user_id'];

                refresh();
            }
        }
    }
}