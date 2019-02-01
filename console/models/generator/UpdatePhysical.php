<?php

namespace console\models\generator;

use common\models\Physical;
use common\models\Player;
use common\models\Transfer;
use Yii;

/**
 * Class UpdatePhysical
 * @package console\models\generator
 */
class UpdatePhysical
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute()
    {
        $sql = "UPDATE `player`
                LEFT JOIN `physical_change`
                ON `player_id`=`physical_change_player_id`
                LEFT JOIN `physical`
                ON `player_physical_id`=`physical_id`
                LEFT JOIN `schedule`
                ON `physical_change_schedule_id`=`schedule_id`
                SET `player_physical_id`=`physical_opposite`
                WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";
        Yii::$app->db->createCommand($sql)->execute();

        Player::updateAllCounters(['player_physical_id' => 1], ['<=', 'player_age', Player::AGE_READY_FOR_PENSION]);
        Player::updateAll(['player_physical_id' => 1], ['>', 'player_physical_id', 20]);
        Player::updateAll(
            ['player_physical_id' => Physical::DEFAULT_ID],
            [
                'and',
                ['player_team_id' => 0],
                [
                    'not',
                    [
                        'player_id' => Transfer::find()
                            ->select(['transfer_player_id'])
                            ->where(['transfer_checked' => 0])
                    ]
                ]
            ]);
    }
}