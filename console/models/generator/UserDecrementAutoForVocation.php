<?php

namespace console\models\generator;

use common\models\Team;
use Yii;

/**
 * Class UserDecrementAutoForVocation
 * @package console\models\generator
 */
class UserDecrementAutoForVocation
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $sql = "UPDATE `team`
                LEFT JOIN `user`
                ON `team_user_id`=`user_id`
                SET `team_auto`=4
                WHERE `team_auto`>=" . Team::MAX_AUTO_GAMES . "
                AND `user_id`!=0
                AND `user_holiday`!=0";
        Yii::$app->db->createCommand($sql)->execute();

        Team::updateAll(['team_auto' => 0], ['and', ['!=', 'team_auto', 0], ['=', 'team_user_id', 0]]);
    }
}
