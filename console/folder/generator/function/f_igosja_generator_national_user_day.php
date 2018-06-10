<?php

/**
 * Кількість днів тренера у сбірній
 */
function f_igosja_generator_national_user_day()
{
    $sql = "SELECT `national_id`,
                   `national_user_id`,
                   `national_vice_id`
            FROM `national`
            WHERE `national_user_id`!=0
            OR `national_vice_id`!=0
            ORDER BY `national_id` ASC";
    $national_sql = f_igosja_mysqli_query($sql);

    $national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($national_array as $item)
    {
        $national_id    = $item['national_id'];
        $user_id        = $item['national_user_id'];
        $vice_id        = $item['national_vice_id'];

        if (0 != $user_id)
        {
            $sql = "SELECT COUNT(*) AS `count`
                    FROM `nationaluserday`
                    WHERE `nationaluserday_national_id`=$national_id
                    AND `nationaluserday_user_id`=$user_id";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (0 == $check_array[0]['count'])
            {
                $sql = "INSERT INTO `nationaluserday`
                        SET `nationaluserday_day`=1,
                            `nationaluserday_national_id`=$national_id,
                            `nationaluserday_user_id`=$user_id";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $sql = "UPDATE `nationaluserday`
                        SET `nationaluserday_day`=`nationaluserday_day`+1
                        WHERE `nationaluserday_national_id`=$national_id
                        AND `nationaluserday_user_id`=$user_id";
                f_igosja_mysqli_query($sql);
            }
        }

        if (0 != $vice_id)
        {
            $sql = "SELECT COUNT(*) AS `count`
                    FROM `nationaluserday`
                    WHERE `nationaluserday_national_id`=$national_id
                    AND `nationaluserday_user_id`=$vice_id";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (0 == $check_array[0]['count'])
            {
                $sql = "INSERT INTO `nationaluserday`
                        SET `nationaluserday_day`=1,
                            `nationaluserday_national_id`=$national_id,
                            `nationaluserday_user_id`=$vice_id";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $sql = "UPDATE `nationaluserday`
                        SET `nationaluserday_day`=`nationaluserday_day`+1
                        WHERE `nationaluserday_national_id`=$national_id
                        AND `nationaluserday_user_id`=$vice_id";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}