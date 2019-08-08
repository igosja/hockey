<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class WorldCup
 * @package common\models
 *
 * @property int $world_cup_id
 * @property int $world_cup_difference
 * @property int $world_cup_division_id
 * @property int $world_cup_game
 * @property int $world_cup_loose
 * @property int $world_cup_loose_overtime
 * @property int $world_cup_loose_shootout
 * @property int $world_cup_national_id
 * @property int $world_cup_national_type_id
 * @property int $world_cup_pass
 * @property int $world_cup_place
 * @property int $world_cup_point
 * @property int $world_cup_score
 * @property int $world_cup_season_id
 * @property int $world_cup_win
 * @property int $world_cup_win_overtime
 * @property int $world_cup_win_shootout
 *
 * @property Division $division
 * @property National $national
 * @property NationalType $nationalType
 */
class WorldCup extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%world_cup}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'world_cup_id',
                    'world_cup_difference',
                    'world_cup_division_id',
                    'world_cup_game',
                    'world_cup_loose',
                    'world_cup_loose_overtime',
                    'world_cup_loose_shootout',
                    'world_cup_national_id',
                    'world_cup_national_type_id',
                    'world_cup_pass',
                    'world_cup_place',
                    'world_cup_point',
                    'world_cup_score',
                    'world_cup_season_id',
                    'world_cup_win',
                    'world_cup_win_overtime',
                    'world_cup_win_shootout',
                ],
                'integer'
            ],
            [
                [
                    'world_cup_division_id',
                    'world_cup_national_id',
                    'world_cup_national_type_id',
                    'world_cup_season_id',
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
                'schedule_tournament_type_id' => TournamentType::NATIONAL,
                'schedule_season_id' => $this->world_cup_season_id,
            ])
            ->column();
        $gameArray = Game::find()
            ->where([
                'or',
                ['game_home_national_id' => $this->world_cup_national_id],
                ['game_guest_national_id' => $this->world_cup_national_id],
            ])
            ->andWhere(['game_schedule_id' => $scheduleIdArray])
            ->andWhere(['!=', 'game_played', 0])
            ->orderBy(['game_schedule_id' => SORT_DESC])
            ->limit($limit)
            ->all();
        foreach ($gameArray as $game) {
            if ($game->game_home_national_id == $this->world_cup_national_id) {
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
    public function getDivision(): ActiveQuery
    {
        return $this->hasOne(Division::class, ['division_id' => 'world_cup_division_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getNational(): ActiveQuery
    {
        return $this->hasOne(National::class, ['national_id' => 'world_cup_national_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getNationalType(): ActiveQuery
    {
        return $this->hasOne(NationalType::class, ['national_type_id' => 'world_cup_national_type_id'])->cache();
    }
}
