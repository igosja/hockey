<?php

namespace console\models\newSeason;

use common\models\National;

/**
 * Class FireNational
 * @package console\models\newSeason
 */
class FireNational
{
    /**
     * @throws \Exception
     * @return void
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
    }
}