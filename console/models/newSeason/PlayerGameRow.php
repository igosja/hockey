<?php

namespace console\models\newSeason;

use common\models\Player;

/**
 * Class PlayerGameRow
 * @package console\models\newSeason
 */
class PlayerGameRow
{
    /**
     * @return void
     */
    public function execute()
    {
        Player::updateAll(['player_game_row' => -1], ['!=', 'player_game_row', -1]);
    }
}