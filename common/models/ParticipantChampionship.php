<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class ParticipantChampionship
 * @package common\models
 *
 * @property int $participant_championship_id
 * @property int $participant_championship_country_id
 * @property int $participant_championship_division_id
 * @property int $participant_championship_season_id
 * @property int $participant_championship_stage_1
 * @property int $participant_championship_stage_2
 * @property int $participant_championship_stage_4
 * @property int $participant_championship_stage_id
 * @property int $participant_championship_team_id
 *
 * @property Championship $championship
 * @property Team $team
 */
class ParticipantChampionship extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%participant_championship}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'participant_championship_id',
                    'participant_championship_country_id',
                    'participant_championship_division_id',
                    'participant_championship_season_id',
                    'participant_championship_stage_1',
                    'participant_championship_stage_2',
                    'participant_championship_stage_4',
                    'participant_championship_stage_id',
                    'participant_championship_team_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getChampionship()
    {
        return $this->hasOne(Championship::class, [
            'championship_country_id' => 'participant_championship_country_id',
            'championship_division_id' => 'participant_championship_division_id',
            'championship_season_id' => 'participant_championship_season_id',
            'championship_team_id' => 'participant_championship_team_id',
        ]);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'participant_championship_team_id']);
    }
}
