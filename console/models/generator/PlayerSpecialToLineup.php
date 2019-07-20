<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Lineup;
use common\models\LineupSpecial;
use common\models\PlayerSpecial;
use Exception;
use yii\db\ActiveQuery;

/**
 * Class PlayerSpecialToLineup
 * @package console\models\generator
 */
class PlayerSpecialToLineup
{
    /**
     * @return void
     * @throws Exception
     */
    public function execute()
    {
        $gameIdArray = Game::find()
            ->select(['game_id'])
            ->joinWith(['schedule'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere(['game_played' => 0])
            ->column();
        $lineupArray = Lineup::find()
            ->with([
                'player' => function (ActiveQuery $query): ActiveQuery {
                    return $query
                        ->with([
                            'playerSpecial' => function (ActiveQuery $query): ActiveQuery {
                                return $query
                                    ->select([
                                        'player_special_level',
                                        'player_special_player_id',
                                        'player_special_special_id',
                                    ]);

                            },
                        ])
                        ->select(['player_id']);

                },
            ])
            ->select(['lineup_id', 'lineup_player_id'])
            ->where(['lineup_game_id' => $gameIdArray])
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
