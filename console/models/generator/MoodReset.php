<?php

namespace console\models\generator;

use common\models\National;
use common\models\Team;

/**
 * Class MoodReset
 * @package console\models\generator
 */
class MoodReset
{
    /**
     * @return void
     */
    public function execute()
    {
        Team::updateAll(['team_mood_rest' => 2, 'team_mood_super' => 2], ['!=', 'team_id', 0]);
        National::updateAll(['national_mood_rest' => 2, 'national_mood_super' => 2], ['!=', 'national_id', 0]);
    }
}
