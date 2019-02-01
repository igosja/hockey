<?php

namespace console\models\generator;

use common\models\Player;
use common\models\Transfer;

/**
 * Class PlayerLeaguePower
 * @package console\models\generator
 */
class PlayerLeaguePower
{
    /**
     * @return void
     */
    public function execute()
    {
        Player::updateAll(
            ['player_power_nominal' => 15],
            [
                'and',
                ['player_team_id' => 0],
                [
                    'not',
                    [
                        'player_id' => Transfer::find()
                            ->select(['transfer_player_id'])
                            ->where(['transfer_checked' => 0])
                    ]
                ]
            ]
        );
    }
}