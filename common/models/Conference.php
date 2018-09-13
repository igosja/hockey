<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Conference
 * @package common\models
 *
 * @property int $conference_id
 * @property int $conference_difference
 * @property int $conference_game
 * @property int $conference_guest
 * @property int $conference_home
 * @property int $conference_loose
 * @property int $conference_loose_overtime
 * @property int $conference_loose_shootout
 * @property int $conference_pass
 * @property int $conference_place
 * @property int $conference_point
 * @property int $conference_score
 * @property int $conference_season_id
 * @property int $conference_team_id
 * @property int $conference_win
 * @property int $conference_win_overtime
 * @property int $conference_win_shootout
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
