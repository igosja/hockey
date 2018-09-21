<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class League
 * @package common\models
 *
 * @property int $league_id
 * @property int $league_difference
 * @property int $league_game
 * @property int $league_group
 * @property int $league_loose
 * @property int $league_loose_overtime
 * @property int $league_loose_shootout
 * @property int $league_pass
 * @property int $league_place
 * @property int $league_point
 * @property int $league_score
 * @property int $league_season_id
 * @property int $league_team_id
 * @property int $league_win
 * @property int $league_win_overtime
 * @property int $league_win_shootout
 *
 * @property Team $team
 */
class League extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%league}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['league_season_id'], 'in', 'range' => Season::find()->select(['season_id'])->column()],
            [['league_team_id'], 'in', 'range' => Team::find()->select(['team_id'])->column()],
            [
                [
                    'league_id',
                    'league_difference',
                    'league_game',
                    'league_group',
                    'league_loose',
                    'league_loose_overtime',
                    'league_loose_shootout',
                    'league_pass',
                    'league_place',
                    'league_point',
                    'league_score',
                    'league_season_id',
                    'league_team_id',
                    'league_win',
                    'league_win_overtime',
                    'league_win_shootout',
                ],
                'integer'
            ],
            [
                [
                    'league_season_id',
                    'league_team_id'
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
        return $this->hasOne(Team::class, ['team_id' => 'league_team_id']);
    }
}
