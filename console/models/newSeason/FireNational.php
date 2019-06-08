<?php

namespace console\models\newSeason;

use common\models\National;
use common\models\Team;
use Exception;

/**
 * Class FireNational
 * @package console\models\newSeason
 */
class FireNational
{
    /**
     * @return void
     *@throws Exception
     */
    public function execute()
    {
        $nationalArray = National::find()
            ->where([
                'or',
                ['!=', 'national_user_id', 0],
                ['!=', 'national_vice_id', 0]
            ])
            ->orderBy(['national_id' => SORT_ASC])
            ->all();
        foreach ($nationalArray as $national) {
            if ($national->vice) {
                $national->fireVice();
            }
            if ($national->user) {
                $national->fireUser();
            }
        }

        Team::updateAll(['team_attitude_national' => 0, 'team_attitude_u21' => 0, 'team_attitude_u19' => 0]);
    }
}
