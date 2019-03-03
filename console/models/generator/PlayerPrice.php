<?php

namespace console\models\generator;

use Yii;

/**
 * Class PlayerPrice
 * @package console\models\generator
 */
class PlayerPrice
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute()
    {
        $sql = "UPDATE `player`
                LEFT JOIN
                (
                    SELECT `player_special_player_id`, SUM(`player_special_level`) AS `special_level`
                    FROM `player_special`
                    LEFT JOIN `player`
                    ON `player_special_player_id`=`player_id`
                    WHERE `player_age`<40
                    GROUP BY `player_special_player_id`
                ) AS `t1`
                ON `player_special_player_id`=`player_id`
                LEFT JOIN
                (
                    SELECT `player_position_player_id`, COUNT(`player_position_position_id`) AS `position`
                    FROM `player_position`
                    LEFT JOIN `player`
                    ON `player_position_player_id`=`player_id`
                    WHERE `player_age`<40
                    GROUP BY `player_position_player_id`
                ) AS `t2`
                ON `player_position_player_id`=`player_id`
                SET `player_price`=POW(150-(28-`player_age`), 2)*(`position`-1+`player_power_nominal`+IFNULL(`special_level`, 0))
                WHERE `player_age`<40";
        Yii::$app->db->createCommand($sql)->execute();
    }
}