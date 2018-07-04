<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Championship
 * @package common\models
 *
 * @property integer $championship_id
 * @property integer $championship_country_id
 * @property integer $championship_difference
 * @property integer $championship_division_id
 * @property integer $championship_game
 * @property integer $championship_loose
 * @property integer $championship_loose_overtime
 * @property integer $championship_loose_shootout
 * @property integer $championship_pass
 * @property integer $championship_place
 * @property integer $championship_point
 * @property integer $championship_score
 * @property integer $championship_season_id
 * @property integer $championship_team_id
 * @property integer $championship_win
 * @property integer $championship_win_overtime
 * @property integer $championship_win_shootout
 *
 * @property Team $team
 */
class Championship extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%championship}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['championship_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [['championship_division_id'], 'in', 'range' => Division::find()->select(['division_id'])->column()],
            [['championship_season_id'], 'in', 'range' => Season::find()->select(['season_id'])->column()],
            [['championship_team_id'], 'in', 'range' => Team::find()->select(['team_id'])->column()],
            [
                [
                    'championship_id',
                    'championship_difference',
                    'championship_game',
                    'championship_loose',
                    'championship_loose_overtime',
                    'championship_loose_shootout',
                    'championship_pass',
                    'championship_place',
                    'championship_point',
                    'championship_score',
                    'championship_season_id',
                    'championship_team_id',
                    'championship_win',
                    'championship_win_overtime',
                    'championship_win_shootout',
                ],
                'integer'
            ],
            [
                [
                    'championship_country_id',
                    'championship_division_id',
                    'championship_season_id',
                    'championship_team_id'
                ],
                'required'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'championship_team_id']);
    }
}
