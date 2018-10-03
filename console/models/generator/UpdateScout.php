<?php

namespace console\models\generator;

use common\models\Scout;
use Yii;

/**
 * Class UpdateScout
 * @package console\models\generator
 */
class UpdateScout
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $sql = "UPDATE `scout`
                LEFT JOIN `team`
                ON `scout_team_id`=`team_id`
                LEFT JOIN `base_scout`
                ON `team_base_scout_id`=`base_scout_id`
                SET `scout_percent`=`scout_percent`+`base_scout_scout_speed_min`+(`base_scout_scout_speed_max`-`base_scout_scout_speed_min`)/2*RAND()
                WHERE `scout_ready`=0";
        Yii::$app->db->createCommand($sql)->execute();

        Scout::updateAll(
            ['scout_percent' => 100, 'scout_ready' => time()],
            ['and', ['scout_ready' => 0], ['>=', 'scout_percent', 100]]
        );
    }
}