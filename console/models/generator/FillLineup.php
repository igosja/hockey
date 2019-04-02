<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Lineup;
use common\models\Player;
use common\models\Position;
use Exception;

/**
 * Class FillLineup
 * @package console\models\generator
 */
class FillLineup
{
    /**
     * @return void
     * @throws Exception
     */
    public function execute()
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->with(['nationalGuest', 'nationalHome'])
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
                    $countryId = isset($game->nationalGuest->national_country_id) ? $game->nationalGuest->national_country_id : null;
                    $teamId = $game->game_guest_team_id;
                } else {
                    $moodId = $game->game_home_mood_id;
                    $nationalId = $game->game_home_national_id;
                    $countryId = isset($game->nationalHome->national_country_id) ? $game->nationalHome->national_country_id : null;
                    $teamId = $game->game_home_team_id;
                }

                for ($j = 0; $j < Lineup::GAME_QUANTITY; $j++) {
                    if (in_array($j, [0])) {
                        $lineId = 0;
                    } elseif (in_array($j, [1, 2, 3, 4, 5, 6])) {
                        $lineId = 1;
                    } elseif (in_array($j, [7, 8, 9, 10, 11])) {
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
                        ->select([
                            'lineup_id',
                            'lineup_game_id',
                            'lineup_line_id',
                            'lineup_national_id',
                            'lineup_player_id',
                            'lineup_position_id',
                            'lineup_team_id',
                        ])
                        ->where([
                            'lineup_game_id' => $game->game_id,
                            'lineup_line_id' => $lineId,
                            'lineup_national_id' => $nationalId,
                            'lineup_position_id' => $positionId,
                            'lineup_team_id' => $teamId,
                        ])
                        ->limit(1)
                        ->one();

                    if (!$lineup || !$lineup->lineup_player_id) {
                        $subQuery = Lineup::find()
                            ->joinWith(['game.schedule'])
                            ->select(['lineup_player_id'])
                            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()');

                        $league = Player::find()
                            ->joinWith(['playerPosition'])
                            ->select(['player_id', 'player_tire'])
                            ->where([
                                'player_team_id' => 0,
                                'player_loan_team_id' => 0,
                                'player_school_id' => 0,
                                'player_injury' => 0,
                                'player_position_position_id' => $positionId,
                                'player_power_nominal' => 15,
                            ])
                            ->andWhere(['not', ['player_id' => $subQuery]])
                            ->andWhere(['<=', 'player_age', Player::AGE_READY_FOR_PENSION])
                            ->andWhere(['<=', 'player_tire', Player::TIRE_MAX_FOR_LINEUP])
                            ->andFilterWhere(['player_country_id' => $countryId])
                            ->limit(1);

                        if (!$moodId) {
                            if ($teamId) {
                                $query = Player::find()
                                    ->joinWith(['playerPosition'])
                                    ->select(['player_id', 'player_tire'])
                                    ->where([
                                        'player_injury' => 0,
                                        'player_position_position_id' => $positionId,
                                    ])
                                    ->andWhere(['not', ['player_id' => $subQuery]])
                                    ->andWhere(['<=', 'player_age', Player::AGE_READY_FOR_PENSION])
                                    ->andWhere(['<=', 'player_tire', Player::TIRE_MAX_FOR_LINEUP])
                                    ->andWhere([
                                        'or',
                                        ['player_team_id' => $teamId, 'player_loan_team_id' => 0],
                                        ['player_loan_team_id' => $teamId],
                                    ]);
                            } else {
                                $query = Player::find()
                                    ->joinWith(['playerPosition'])
                                    ->select(['player_id', 'player_tire'])
                                    ->where([
                                        'player_injury' => 0,
                                        'player_position_player_id' => $positionId,
                                        'player_national_id' => $nationalId,
                                    ])
                                    ->andWhere(['not', ['player_id' => $subQuery]])
                                    ->andWhere(['<=', 'player_age', Player::AGE_READY_FOR_PENSION])
                                    ->andWhere(['<=', 'player_tire', Player::TIRE_MAX_FOR_LINEUP]);
                            }

                            $player = $query->all();
                            if (!$player) {
                                $player = $league->all();
                            }
                        } else {
                            $player = $league->all();
                        }

                        usort($player, function ($a, $b) {
                            return ($a->player_tire - $b->player_tire);
                        });

                        $player = $player[0];

                        if (!$lineup) {
                            $lineup = new Lineup();
                            $lineup->lineup_line_id = $lineId;
                            $lineup->lineup_position_id = $positionId;
                            $lineup->lineup_team_id = $teamId;
                            $lineup->lineup_national_id = $nationalId;
                            $lineup->lineup_game_id = $game->game_id;
                        }

                        $lineup->lineup_player_id = $player->player_id;
                        $lineup->save(false, [
                            'lineup_line_id',
                            'lineup_position_id',
                            'lineup_team_id',
                            'lineup_national_id',
                            'lineup_game_id',
                            'lineup_player_id',
                        ]);
                    }
                }
            }
        }
    }
}