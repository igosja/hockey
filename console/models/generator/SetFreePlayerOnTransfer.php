<?php

namespace console\models\generator;

use common\models\Player;
use common\models\Position;
use common\models\Transfer;

/**
 * Class SetFreePlayerOnTransfer
 * @package console\models\generator
 */
class SetFreePlayerOnTransfer
{
    /**
     * @throws \Exception
     */
    public function execute()
    {
        $positionArray = [
            [Position::GK, 2],
            [Position::LD, 5],
            [Position::RD, 5],
            [Position::LW, 5],
            [Position::CF, 5],
            [Position::RW, 5],
        ];

        foreach ($positionArray as $item) {
            $check = Transfer::find()
                ->joinWith(['player'])
                ->where([
                    'transfer_team_seller_id' => 0,
                    'transfer_ready' => 0,
                    'player_position_id' => $item[0],
                ])
                ->count();
            for ($i = 0; $i < $item[1] - $check; $i++) {
                $player = Player::find()
                    ->joinWith(['transfer'])
                    ->where([
                        'player_team_id' => 0,
                        'player_loan_team_id' => 0,
                        'player_position_id' => $item[0],
                        'transfer_id' => null,
                    ])
                    ->andWhere(['<', 'player_age', Player::AGE_READY_FOR_PENSION])
                    ->andWhere(['!=', 'player_school_id', 0])
                    ->orderBy('RAND()')
                    ->one();
                if (!$player) {
                    continue;
                }

                $model = new Transfer();
                $model->transfer_player_id = $player->player_id;
                $model->transfer_price_seller = ceil($player->player_price / 2);
                $model->save();
            }
        }
    }
}
