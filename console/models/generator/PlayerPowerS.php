<?php

namespace console\models\generator;

use Yii;

/**
 * Class PlayerPowerS
 * @package console\models\generator
 */
class PlayerPowerS
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
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
                SET `player_power_nominal_s`=`player_power_nominal`+IF(`special_level` IS NULL, 0, `special_level`)*`player_power_nominal`*5/100
                WHERE `player_age`<40";
        Yii::$app->db->createCommand($sql)->execute();
    }
}