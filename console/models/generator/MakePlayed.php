<?php

namespace console\models\generator;

use Yii;

/**
 * Class MakePlayed
 * @package console\models\generator
 */
class MakePlayed
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute()
    {
        $sql = "UPDATE `game`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                SET `game_played`=UNIX_TIMESTAMP()
                WHERE `game_played`=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";
        Yii::$app->db->createCommand($sql)->execute();
    }
}