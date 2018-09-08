<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class WorldCup
 * @package common\models
 *
 * @property integer $world_cup_id
 * @property integer $world_cup_difference
 * @property integer $world_cup_division_id
 * @property integer $world_cup_game
 * @property integer $world_cup_loose
 * @property integer $world_cup_loose_overtime
 * @property integer $world_cup_loose_shootout
 * @property integer $world_cup_national_id
 * @property integer $world_cup_national_type_id
 * @property integer $world_cup_pass
 * @property integer $world_cup_place
 * @property integer $world_cup_point
 * @property integer $world_cup_score
 * @property integer $world_cup_season_id
 * @property integer $world_cup_win
 * @property integer $world_cup_win_overtime
 * @property integer $world_cup_win_shootout
 *
 * @property Division $division
 * @property National $national
 */
class WorldCup extends ActiveRecord
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
            [['world_cup_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [['world_cup_division_id'], 'in', 'range' => Division::find()->select(['division_id'])->column()],
            [['world_cup_season_id'], 'in', 'range' => Season::find()->select(['season_id'])->column()],
            [['world_cup_national_id'], 'in', 'range' => National::find()->select(['national_id'])->column()],
            [
                ['world_cup_national_type_id'],
                'in',
                'range' => NationalType::find()->select(['national_type_id'])->column()
            ],
            [
                [
                    'world_cup_id',
                    'world_cup_difference',
                    'world_cup_game',
                    'world_cup_loose',
                    'world_cup_loose_overtime',
                    'world_cup_loose_shootout',
                    'world_cup_pass',
                    'world_cup_place',
                    'world_cup_point',
                    'world_cup_score',
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
