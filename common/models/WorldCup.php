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
     * @return ActiveQuery
     */
    public function getDivision(): ActiveQuery
    {
        return $this->hasOne(Division::class, ['division_id' => 'world_cup_division_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNational(): ActiveQuery
    {
        return $this->hasOne(National::class, ['national_id' => 'world_cup_national_id']);
    }
}
