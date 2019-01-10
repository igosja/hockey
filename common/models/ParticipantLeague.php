<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class ParticipantLeague
 * @package common\models
 *
 * @property int $participant_league_id
 * @property int $participant_league_season_id
 * @property int $participant_league_stage_1
 * @property int $participant_league_stage_2
 * @property int $participant_league_stage_4
 * @property int $participant_league_stage_8
 * @property int $participant_league_stage_id
 * @property int $participant_league_stage_in
 * @property int $participant_league_team_id
 *
 * @property Team $team
 */
class ParticipantLeague extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%participant_league}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'participant_league_id',
                    'participant_league_season_id',
                    'participant_league_stage_1',
                    'participant_league_stage_2',
                    'participant_league_stage_4',
                    'participant_league_stage_8',
                    'participant_league_stage_id',
                    'participant_league_stage_in',
                    'participant_league_team_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'participant_league_team_id']);
    }
}
