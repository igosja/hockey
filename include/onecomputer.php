<?php

print '<pre>';
print_r(321);
exit;
if (isset($_SESSION['user_id']))
{
    print '<pre>';
    print_r($_SESSION['user_id']);
    exit;
    if ($user_code = f_igosja_cookie('computer_code'))
    {
        $session_user_id = $_SESSION['user_id'];

        print '<pre>';
        print_r($session_user_id);
        print_r($user_code);
        exit;

        $sql = "SELECT `user_id`
                FROM `user`
                WHERE `user_code`=?
                AND `user_id`!=$session_user_id
                LIMIT 1";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $user_code);
        $prepare->execute();

        $user_sql = $prepare->get_result();

        $prepare->close();

        if (0 != $user_sql->num_rows)
        {
            $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

            $user_id = $user_array[0]['user_id'];

            $sql = "INSERT INTO `onecomputer`
                    SET `onecomputer_date`=UNIX_TIMESTAMP(),
                        `onecomputer_child_id`=$user_id,
                        `onecomputer_user_id`=$session_user_id";
            f_igosja_mysqli_query($sql);
        }
    }
}