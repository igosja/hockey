<?php

namespace console\models\generator;

use common\models\Lineup;
use common\models\LineupSpecial;
use common\models\PlayerSpecial;

/**
 * Class PlayerSpecialToLineup
 * @package console\models\generator
 */
class PlayerSpecialToLineup
{
    /**
     * @throws \Exception
     * @return void
     */
    public function execute()
    {
        $lineupArray = Lineup::find()
            ->joinWith(['game.schedule'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere([
                'lineup_player_id' => PlayerSpecial::find()
                    ->select(['player_special_player_id'])
            ])
            ->orderBy(['lineup_id' => SORT_ASC])
            ->each(5);
        foreach ($lineupArray as $lineup) {
            /**
             * @var Lineup $lineup
             */
            foreach ($lineup->player->playerSpecial as $playerSpecial) {
                $model = new LineupSpecial();
                $model->lineup_special_lineup_id = $lineup->lineup_id;
                $model->lineup_special_level = $playerSpecial->player_special_level;
                $model->lineup_special_special_id = $playerSpecial->player_special_special_id;
                $model->save();
            }
        }
    }
}
