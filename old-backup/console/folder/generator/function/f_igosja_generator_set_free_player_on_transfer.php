<?php

/**
 * Виставляємо 27 вільніх хоккеїстів на трансфер
 */
function f_igosja_generator_set_free_player_on_transfer()
{
    $position_array = array(
        array(POSITION_GK, 2),
        array(POSITION_LD, 5),
        array(POSITION_RD, 5),
        array(POSITION_LW, 5),
        array(POSITION_C, 5),
        array(POSITION_RW, 5),
    );

    foreach ($position_array as $item)
    {
        $position_id    = $item[0];
        $limit          = $item[1];

        $sql = "SELECT COUNT(`transfer_id`) AS `count`
                FROM `transfer`
                LEFT JOIN `player`
                ON `transfer_player_id`=`player_id`
                WHERE `transfer_team_seller_id`=0
                AND `transfer_ready`=0
                AND `player_position_id`=$position_id";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        for ($i=0; $i<$limit-$check_array[0]['count']; $i++)
        {
            $sql = "SELECT `player_id`,
                           `player_price`
                    FROM `player`
                    WHERE `player_team_id`=0
                    AND `player_rent_team_id`=0
                    AND `player_school_id`!=0
                    AND `player_position_id`=$position_id
                    AND `player_transfer_on`=0
                    AND `player_age`<39
                    ORDER BY `player_power_nominal_s` DESC
                    LIMIT 1";
            $player_sql = f_igosja_mysqli_query($sql);

            if (0 != $player_sql->num_rows)
            {
                $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                $player_id  = $player_array[0]['player_id'];
                $price      = ceil($player_array[0]['player_price'] / 2);

                $sql = "INSERT INTO `transfer`
                        SET `transfer_date`=UNIX_TIMESTAMP(),
                            `transfer_player_id`=$player_id,
                            `transfer_price_seller`=$price";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `player`
                        SET `player_transfer_on`=1
                        WHERE `player_id`=$player_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}