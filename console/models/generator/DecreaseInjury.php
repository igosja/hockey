<?php

namespace console\models\generator;

use common\models\Player;
use Yii;

/**
 * Class DecreaseInjury
 * @package console\models\generator
 */
class DecreaseInjury
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        Player::updateAllCounters(['player_injury_day' => -1], ['>', 'player_injury', 0]);

        $sql = "UPDATE `player`
                LEFT JOIN `team`
                ON `player_team_id`=`team_id`
                LEFT JOIN `base_medical`
                ON `team_base_medical_id`=`base_medical_id`
                SET `player_tire`=`base_medical_tire`,
                    `player_injury`=0
                WHERE `player_injury`=1
                AND `player_injury_day`<=0";
        Yii::$app->db->createCommand($sql)->execute();
    }
}