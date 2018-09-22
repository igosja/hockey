<?php

namespace console\models\generator;

use common\models\Player;
use common\models\Schedule;
use common\models\Stage;
use common\models\TournamentType;
use yii\db\Expression;

/**
 * Class GameRowReset
 * @package console\models\generator
 */
class GameRowReset
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $check = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`-86400, "%Y-%m-%d")=CURDATE()')
            ->andWhere([
                'schedule_stage_id' => Stage::TOUR_1,
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP
            ])
            ->limit(1)
            ->one();
        if (!$check) {
            return;
        }

        Player::updateAll(['player_game_row' => -1], ['<=', 'player_age', Player::AGE_READY_FOR_PENSION]);
        Player::updateAll(
            ['player_game_row_old' => new Expression('player_game_row')],
            [
                'and',
                ['<=', 'player_age', Player::AGE_READY_FOR_PENSION],
                ['!=', 'player_game_row_old', new Expression('player_game_row')],
            ]
        );
    }
}
