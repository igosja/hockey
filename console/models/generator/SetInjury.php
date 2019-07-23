<?php

namespace console\models\generator;

use common\models\Game;
use common\models\History;
use common\models\HistoryText;
use common\models\Lineup;
use common\models\Player;
use common\models\Position;
use Yii;

/**
 * Class SetInjury
 * @package console\models\generator
 */
class SetInjury
{
    const MIN_GAMES_FOR_INJURY = 100;

    /**
     * @return bool
     * @throws \Exception
     */
    public function execute(): bool
    {
        $game = Game::find()
            ->joinWith(['schedule'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->count();
        if ($game < self::MIN_GAMES_FOR_INJURY) {
            return true;
        }

        $gameIdArray = Game::find()
            ->select(['game_id'])
            ->joinWith(['schedule'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere(['game_played' => 0])
            ->column();

        $lineup = Lineup::find()
            ->joinWith([
                'player'
            ])
            ->with(['player'])
            ->where(['lineup_game_id' => $gameIdArray])
            ->andWhere(['player_injury' => 0])
            ->andWhere([
                'not',
                [
                    'player_team_id' => Player::find()
                        ->select(['player_team_id'])
                        ->where(['>', 'player_injury', 0])
                ]
            ])
            ->orderBy(['player_tire' => SORT_DESC])
            ->addOrderBy('RAND()')
            ->limit(1)
            ->one();
        if (!$lineup) {
            return true;
        }

        if (Position::GK == $lineup->lineup_position_id && 1 == $lineup->lineup_line_id) {
            return true;
        }

        $transaction = Yii::$app->db->beginTransaction();

        $lineup->player->player_injury = 1;
        $lineup->player->player_injury_day = rand(1, 9);
        $lineup->player->save();

        History::log([
            'history_game_id' => $lineup->lineup_game_id,
            'history_history_text_id' => HistoryText::PLAYER_INJURY,
            'history_player_id' => $lineup->lineup_player_id,
            'history_value' => $lineup->player->player_injury_day,
        ]);

        $transaction->commit();

        return true;
    }
}