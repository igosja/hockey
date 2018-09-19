<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
 */
class ParticipantChampionship extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%participant_championship}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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
    public function getChampionship(): ActiveQuery
    {
        return $this->hasOne(Championship::class, [
            'championship_country_id' => 'participant_championship_country_id',
            'championship_division_id' => 'participant_championship_division_id',
            'championship_season_id' => 'participant_championship_season_id',
            'championship_team_id' => 'participant_championship_team_id',
        ]);
    }
}
