<?php

namespace common\models;

use yii\db\ActiveQuery;

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
 * @property Position $position
 * @property Special $special
 * @property Style $style
 * @property Team $team
 */
class School extends AbstractActiveRecord
{
    const AGE = 17;

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
    public function getPosition(): ActiveQuery
    {
        return $this->hasOne(Position::class, ['position_id' => 'school_position_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecial(): ActiveQuery
    {
        return $this->hasOne(Special::class, ['special_id' => 'school_special_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStyle(): ActiveQuery
    {
        return $this->hasOne(Style::class, ['style_id' => 'school_style_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'school_team_id']);
    }
}
