<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Conference
 * @package common\models
 *
 * @property integer $conference_id
 * @property integer $conference_difference
 * @property integer $conference_game
 * @property integer $conference_guest
 * @property integer $conference_home
 * @property integer $conference_loose
 * @property integer $conference_loose_overtime
 * @property integer $conference_loose_shootout
 * @property integer $conference_pass
 * @property integer $conference_place
 * @property integer $conference_point
 * @property integer $conference_score
 * @property integer $conference_season_id
 * @property integer $conference_team_id
 * @property integer $conference_win
 * @property integer $conference_win_overtime
 * @property integer $conference_win_shootout
 *
 * @property Team $team
 */
class Conference extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%conference}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['conference_season_id'], 'in', 'range' => Season::find()->select(['season_id'])->column()],
            [['conference_team_id'], 'in', 'range' => Team::find()->select(['team_id'])->column()],
            [
                [
                    'conference_id',
                    'conference_difference',
                    'conference_game',
                    'conference_guest',
                    'conference_home',
                    'conference_loose',
                    'conference_loose_overtime',
                    'conference_loose_shootout',
                    'conference_pass',
                    'conference_place',
                    'conference_point',
                    'conference_score',
                    'conference_season_id',
                    'conference_team_id',
                    'conference_win',
                    'conference_win_overtime',
                    'conference_win_shootout',
                ],
                'integer'
            ],
            [['conference_season_id', 'conference_team_id'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'conference_team_id']);
    }
}
