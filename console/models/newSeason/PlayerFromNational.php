<?php

namespace console\models\newSeason;

use common\models\Player;

/**
 * Class PlayerFromNational
 * @package console\models\newSeason
 */
class PlayerFromNational
{
    /**
     * @return void
     */
    public function execute()
    {
        Player::updateAll(['player_national_id' => 0], ['!=', 'player_national_id', 0]);
        Player::updateAll(['player_national_line_id' => 0], ['!=', 'player_national_line_id', 0]);
    }
}