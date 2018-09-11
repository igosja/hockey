<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class School
 * @package common\models
 *
 * @property integer $school_id
 * @property integer $school_day
 * @property integer $school_position_id
 * @property integer $school_ready
 * @property integer $school_season_id
 * @property integer $school_special_id
 * @property integer $school_style_id
 * @property integer $school_team_id
 * @property integer $school_with_special
 * @property integer $school_with_special_request
 * @property integer $school_with_style
 * @property integer $school_with_style_request
 *
 * @property Team $team
 */
class School extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%school}}';
    }

    /**
     * @return array
     */
    public function schools(): array
    {
        return [
            [
                [
                    'school_id',
                    'school_day',
                    'school_position_id',
                    'school_ready',
                    'school_season_id',
                    'school_special_id',
                    'school_style_id',
                    'school_team_id',
                    'school_with_special',
                    'school_with_special_request',
                    'school_with_style',
                    'school_with_style_request',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'school_team_id']);
    }
}
