<?php

namespace console\models\generator;

use common\models\Game;
use common\models\History;
use common\models\HistoryText;
use common\models\Lineup;
use common\models\Player;
use common\models\Position;

/**
 * Class SetInjury
 * @package console\models\generator
 */
class SetInjury
{
    const MIN_GAMES_FOR_INJURY = 100;

    /**
     * @throws \Exception
     * @return void
     */
    public function execute(): void
    {
        $game = Game::find()
            ->joinWith(['schedule'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->count();
        if ($game < self::MIN_GAMES_FOR_INJURY) {
            return;
        }

        $playerSubQuery = Player::find()->select(['player_team_id'])->where(['>', 'player_injury', 0]);
        $lineup = Lineup::find()
            ->joinWith([
                'game.schedule',
                'player'
            ])
            ->with(['player'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere(['player_injury' => 0])
            ->andWhere(['not', ['player_team_id' => $playerSubQuery]])
            ->orderBy(['player_tire' => SORT_DESC])
            ->addOrderBy('RAND()')
            ->limit(1)
            ->one();
        if (!$lineup) {
            return;
        }

        if (Position::GK == $lineup->lineup_position_id && 1 == $lineup->lineup_line_id) {
            return;
        }

        $lineup->player->player_injury = 1;
        $lineup->player->player_injury_day = rand(1, 9);
        $lineup->player->save();

        History::log([
            'history_game_id' => $lineup->lineup_game_id,
            'history_history_text_id' => HistoryText::PLAYER_INJURY,
            'history_player_id' => $lineup->lineup_player_id,
            'history_value' => $lineup->player->player_injury_day,
        ]);
    }
}