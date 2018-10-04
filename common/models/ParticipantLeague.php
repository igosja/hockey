<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class ParticipantLeague extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%participant_league}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'participant_league_team_id']);
    }
}
