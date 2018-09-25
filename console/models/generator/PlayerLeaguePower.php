<?php

namespace console\models\generator;

use common\models\Player;
use yii\db\Expression;

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
            ['player_power_nominal' => new Expression('player_age*2')],
            ['player_age' => 18, 'player_team_id' => 0]
        );
    }
}