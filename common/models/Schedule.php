<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Schedule
 * @package common\models
 *
 * @property int $schedule_id
 * @property int $schedule_date
 * @property int $schedule_season_id
 * @property int $schedule_stage_id
 * @property int $schedule_tournament_type_id
 *
 * @property Season $season
 * @property Stage $stage
 * @property TournamentType $tournamentType
 */
class Schedule extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%schedule}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'schedule_id',
                    'schedule_date',
                    'schedule_season_id',
                    'schedule_stage_id',
                    'schedule_tournament_type_id',
                ],
                'integer'
            ],
            [['schedule_date', 'schedule_season_id', 'schedule_stage_id', 'schedule_tournament_type_id'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'schedule_date' => 'Date',
            'stage' => 'Stage',
            'tournamentType' => 'Tournament',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSeason()
    {
        return $this->hasOne(Season::class, ['season_id' => 'schedule_season_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStage()
    {
        return $this->hasOne(Stage::class, ['stage_id' => 'schedule_stage_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTournamentType()
    {
        return $this->hasOne(TournamentType::class, ['tournament_type_id' => 'schedule_tournament_type_id']);
    }
}
