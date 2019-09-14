<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Olympiad
 * @package common\models
 *
 * @property int $olympiad_id
 * @property int $olympiad_difference
 * @property int $olympiad_game
 * @property int $olympiad_group
 * @property int $olympiad_loose
 * @property int $olympiad_loose_overtime
 * @property int $olympiad_loose_shootout
 * @property int $olympiad_national_id
 * @property int $olympiad_national_type_id
 * @property int $olympiad_pass
 * @property int $olympiad_place
 * @property int $olympiad_point
 * @property int $olympiad_score
 * @property int $olympiad_season_id
 * @property int $olympiad_win
 * @property int $olympiad_win_overtime
 * @property int $olympiad_win_shootout
 *
 * @property National $national
 */
class Olympiad extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'olympiad_id',
                    'olympiad_difference',
                    'olympiad_game',
                    'olympiad_group',
                    'olympiad_loose',
                    'olympiad_loose_overtime',
                    'olympiad_loose_shootout',
                    'olympiad_national_id',
                    'olympiad_national_type_id',
                    'olympiad_pass',
                    'olympiad_place',
                    'olympiad_point',
                    'olympiad_score',
                    'olympiad_season_id',
                    'olympiad_win',
                    'olympiad_win_overtime',
                    'olympiad_win_shootout',
                ],
                'integer'
            ],
            [
                [
                    'olympiad_season_id',
                    'olympiad_national_id'
                ],
                'required'
            ],
        ];
    }

    /**
     * @param int $limit
     * @return string
     */
    public function lastGamesShape(int $limit = 5): string
    {
        $result = [];
        $scheduleIdArray = Schedule::find()
            ->select(['schedule_id'])
            ->where([
                'schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                'schedule_season_id' => $this->olympiad_season_id,
            ])
            ->andWhere([
                'schedule_stage_id' => [
                    Stage::TOUR_OLYMPIAD_1,
                    Stage::TOUR_OLYMPIAD_2,
                    Stage::TOUR_OLYMPIAD_3,
                    Stage::TOUR_OLYMPIAD_4,
                    Stage::TOUR_OLYMPIAD_5,
                ]
            ])
            ->column();
        $gameArray = Game::find()
            ->where([
                'or',
                ['game_home_national_id' => $this->olympiad_national_id],
                ['game_guest_national_id' => $this->olympiad_national_id],
            ])
            ->andWhere(['game_schedule_id' => $scheduleIdArray])
            ->andWhere(['!=', 'game_played', 0])
            ->orderBy(['game_schedule_id' => SORT_DESC])
            ->limit($limit)
            ->all();
        foreach ($gameArray as $game) {
            if ($game->game_home_national_id == $this->olympiad_national_id) {
                if ($game->game_home_score > $game->game_guest_score) {
                    $result[] = '<span class="font-green" title="Победа">&bull;</span>';
                } elseif ($game->game_home_score < $game->game_guest_score) {
                    $result[] = '<span class="font-red" title="Поражение">&bull;</span>';
                } else {
                    $result[] = '<span class="font-yellow" title="Ничья/Буллиты">&bull;</span>';
                }
            } else {
                if ($game->game_guest_score > $game->game_home_score) {
                    $result[] = '<span class="font-green" title="Победа">&bull;</span>';
                } elseif ($game->game_guest_score < $game->game_home_score) {
                    $result[] = '<span class="font-red" title="Поражение">&bull;</span>';
                } else {
                    $result[] = '<span class="font-yellow" title="Ничья/Буллиты">&bull;</span>';
                }
            }
        }

        return implode('', $result);
    }

    /**
     * @return ActiveQuery
     */
    public function getNational(): ActiveQuery
    {
        return $this->hasOne(National::class, ['national_id' => 'olympiad_national_id'])->cache();
    }
}
