<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class OffSeason
 * @package common\models
 *
 * @property integer $off_season_id
 * @property integer $off_season_difference
 * @property integer $off_season_game
 * @property integer $off_season_guest
 * @property integer $off_season_home
 * @property integer $off_season_loose
 * @property integer $off_season_loose_overtime
 * @property integer $off_season_loose_shootout
 * @property integer $off_season_pass
 * @property integer $off_season_place
 * @property integer $off_season_point
 * @property integer $off_season_score
 * @property integer $off_season_season_id
 * @property integer $off_season_team_id
 * @property integer $off_season_win
 * @property integer $off_season_win_overtime
 * @property integer $off_season_win_shootout
 *
 * @property Team $team
 */
class OffSeason extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%off_season}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['off_season_season_id'], 'in', 'range' => Season::find()->select(['season_id'])->column()],
            [['off_season_team_id'], 'in', 'range' => Team::find()->select(['team_id'])->column()],
            [
                [
                    'off_season_id',
                    'off_season_difference',
                    'off_season_game',
                    'off_season_guest',
                    'off_season_home',
                    'off_season_loose',
                    'off_season_loose_overtime',
                    'off_season_loose_shootout',
                    'off_season_pass',
                    'off_season_place',
                    'off_season_point',
                    'off_season_score',
                    'off_season_season_id',
                    'off_season_team_id',
                    'off_season_win',
                    'off_season_win_overtime',
                    'off_season_win_shootout',
                ],
                'integer'
            ],
            [['off_season_season_id', 'off_season_team_id'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'off_season_team_id']);
    }
}
