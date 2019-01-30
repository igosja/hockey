<?php

namespace console\models\newSeason;

use common\models\National;
use common\models\Team;

/**
 * Class MoodReset
 * @package console\models\newSeason
 */
class MoodReset
{
    /**
     * @return void
     */
    public function execute()
    {
        Team::updateAll(['team_mood_rest' => 2, 'team_mood_super' => 2]);
        National::updateAll(['national_mood_rest' => 2, 'national_mood_super' => 2]);
    }
}