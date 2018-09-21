<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class School
 * @package common\models
 *
 * @property int $school_id
 * @property int $school_day
 * @property int $school_position_id
 * @property int $school_ready
 * @property int $school_season_id
 * @property int $school_special_id
 * @property int $school_style_id
 * @property int $school_team_id
 * @property int $school_with_special
 * @property int $school_with_special_request
 * @property int $school_with_style
 * @property int $school_with_style_request
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
