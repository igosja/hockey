<?php

namespace console\models\generator;

use common\models\Player;

/**
 * Class PlayerLeaguePower
 * @package console\models\generator
 */
class PlayerLeaguePower
{
    /**
     * @return void
     */
    public function execute(): void
    {
        Player::updateAll(
            ['player_power_nominal' => 15],
            ['player_team_id' => 0]
        );
    }
}