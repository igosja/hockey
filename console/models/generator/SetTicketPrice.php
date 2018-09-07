<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Schedule;

/**
 * Class SetTicketPrice
 * @package console\models\generator
 */
class SetTicketPrice
{
    /**
     * @return void
     */
    public function execute()
    {
        Game::updateAll(
            ['game_ticket' => Game::TICKET_PRICE_DEFAULT],
            [
                'game_played' => 0,
                'game_schedule_id' => Schedule::find()
                    ->select(['schedule_id'])
                    ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ]
        );
    }
}