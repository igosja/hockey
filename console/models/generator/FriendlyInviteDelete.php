<?php

namespace console\models\generator;

use common\models\FriendlyInvite;
use common\models\Schedule;

/**
 * Class FriendlyInviteDelete
 * @package console\models\generator
 */
class FriendlyInviteDelete
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $schedule = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['schedule_id' => SORT_DESC])
            ->limit(1)
            ->one();

        FriendlyInvite::deleteAll(['<=', 'friendly_invite_schedule_id', $schedule->schedule_id]);
    }
}
