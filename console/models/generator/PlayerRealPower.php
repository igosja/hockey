<?php

namespace console\models\generator;

use Yii;

/**
 * Class PlayerRealPower
 * @package console\models\generator
 */
class PlayerRealPower
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute()
    {
        $sql = "UPDATE `player`
                LEFT JOIN `physical`
                ON `player_physical_id`=`physical_id`
                SET `player_power_real`=`player_power_nominal`*(100-`player_tire`)/100*`physical_value`/100
                WHERE `player_age`<40";
        Yii::$app->db->createCommand($sql)->execute();
    }
}