<?php

namespace console\models\generator;

use common\models\Player;
use yii\db\Expression;

/**
 * Class PlayerPowerNewToOld
 * @package console\models\generator
 */
class PlayerPowerNewToOld
{
    /**
     * @return void
     */
    public function execute(): void
    {
        Player::updateAll(
            ['player_power_old' => new Expression('`player_power_old`')],
            [
                'and',
                ['!=', 'player_power_old', new Expression('`player_power_nominal`')],
                ['<=', 'player_age', Player::AGE_READY_FOR_PENSION]
            ]
        );
    }
}