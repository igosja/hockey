<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class League
 * @package common\models
 *
 * @property integer $league_id
 * @property integer $league_difference
 * @property integer $league_game
 * @property integer $league_group
 * @property integer $league_loose
 * @property integer $league_loose_overtime
 * @property integer $league_loose_shootout
 * @property integer $league_pass
 * @property integer $league_place
 * @property integer $league_point
 * @property integer $league_score
 * @property integer $league_season_id
 * @property integer $league_team_id
 * @property integer $league_win
 * @property integer $league_win_overtime
 * @property integer $league_win_shootout
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
