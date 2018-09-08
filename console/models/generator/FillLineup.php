<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Lineup;
use common\models\Player;
use common\models\Position;

/**
 * Class FillLineup
 * @package console\models\generator
 */
class FillLineup
{
    /**
     * @return void
     */
    public function execute()
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['game_id' => SORT_ASC])
            ->each();
        foreach ($gameArray as $game) {
            /**
             * @var Game $game
             */
            for ($i = 0; $i < 2; $i++) {
                if (0 == $i) {
                    $moodId = $game->game_guest_mood_id;
                    $nationalId = $game->game_guest_national_id;
                    $countryId = $game->nationalGuest->national_country_id;
                    $teamId = $game->game_guest_team_id;
                } else {
                    $moodId = $game->game_home_mood_id;
                    $nationalId = $game->game_home_national_id;
                    $countryId = $game->nationalHome->national_country_id;
                    $teamId = $game->game_home_team_id;
                }

                for ($j = 0; $j < Lineup::GAME_QUANTITY; $j++) {
                    if (in_array($j, [0, 2, 3, 4, 5, 6])) {
                        $lineId = 1;
                    } elseif (in_array($j, [1, 7, 8, 9, 10, 11])) {
                        $lineId = 2;
                    } elseif (in_array($j, [12, 13, 14, 15, 16])) {
                        $lineId = 3;
                    } else {
                        $lineId = 4;
                    }

                    if (in_array($j, [0, 1])) {
                        $positionId = Position::GK;
                    } elseif (in_array($j, [2, 7, 12, 17])) {
                        $positionId = Position::LD;
                    } elseif (in_array($j, [3, 8, 13, 18])) {
                        $positionId = Position::RD;
                    } elseif (in_array($j, [4, 9, 14, 19])) {
                        $positionId = Position::LW;
                    } elseif (in_array($j, [5, 10, 15, 20])) {
                        $positionId = Position::CF;
                    } else {
                        $positionId = Position::RW;
                    }

                    $lineup = Lineup::find()
                        ->where([
                            'lineup_game_id' => $game->game_id,
                            'lineup_line_id' => $lineId,
                            'lineup_position_id' => $positionId,
                            'lineup_national_id' => $nationalId,
                            'lineup_team_id' => $teamId,
                        ])
                        ->limit(1)
                        ->one();

                    if (!$lineup) {
                        $subQuery = Lineup::find()
                            ->joinWith(['game.schedule'])
                            ->select(['lineup_player_id'])
                            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()');

                        $league = Player::find()
                            ->joinWith(['playerPosition'])
                            ->where([
                                'player_team_id' => 0,
                                'player_loan_team_id' => 0,
                                'player_injury_day' => 0,
                                'player_position_player_id' => $positionId,
                            ])
                            ->andWhere(['not', ['player_id' => $subQuery]])
                            ->andWhere(['<=', 'player_age', Player::AGE_READY_FOR_PENSION])
                            ->andFilterWhere(['player_country_id' => $countryId])
                            ->orderBy(['player_tire' => SORT_ASC, 'player_power_real' => SORT_DESC])
                            ->limit(1);

                        if (0 == $moodId) {
                            if (0 != $teamId) {
                                $query = Player::find()
                                    ->joinWith(['playerPosition'])
                                    ->where([
                                        'player_injury_day' => 0,
                                        'player_position_player_id' => $positionId,
                                    ])
                                    ->andWhere(['not', ['player_id' => $subQuery]])
                                    ->andWhere(['<=', 'player_age', Player::MAX_TIRE])
                                    ->andWhere([
                                        'or',
                                        ['player_team_id' => $teamId, 'player_loan_team_id' => 0],
                                        ['player_loan_team_id' => $teamId],
                                    ])
                                    ->orderBy(['player_tire' => SORT_ASC, 'player_power_real' => SORT_DESC])
                                    ->limit(1);
                            } else {
                                $query = Player::find()
                                    ->joinWith(['playerPosition'])
                                    ->where([
                                        'player_injury_day' => 0,
                                        'player_position_player_id' => $positionId,
                                        'player_national_id' => $nationalId,
                                    ])
                                    ->andWhere(['not', ['player_id' => $subQuery]])
                                    ->andWhere(['<=', 'player_age', Player::MAX_TIRE])
                                    ->orderBy(['player_tire' => SORT_ASC, 'player_power_real' => SORT_DESC])
                                    ->limit(1);
                            }

                            $player = $query->one();
                            if (!$player) {
                                $player = $league->one();
                            }
                        } else {
                            $player = $league->one();
                        }

                        if (!$lineup) {
                            $lineup = new Lineup();
                            $lineup->lineup_line_id = $lineId;
                            $lineup->lineup_position_id = $positionId;
                            $lineup->lineup_team_id = $teamId;
                            $lineup->lineup_national_id = $nationalId;
                            $lineup->lineup_game_id = $game->game_id;
                        }

                        $lineup->lineup_player_id = $player->player_id;
                        $lineup->save();
                    }
                }
            }
        }
    }
}