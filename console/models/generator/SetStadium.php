<?php

namespace console\models\generator;

use common\models\TournamentType;
use Yii;

/**
 * Class SetStadium
 * @package console\models\generator
 */
class SetStadium
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $sql = "UPDATE `game`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                LEFT JOIN `national`
                ON `game_home_national_id`=`national_id`
                SET `game_stadium_id`=`national_stadium_id`
                WHERE `game_played`=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                AND `schedule_tournament_type_id`=" . TournamentType::NATIONAL;
        Yii::$app->db->createCommand($sql)->execute();
    }
}