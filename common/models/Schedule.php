<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Schedule
 * @package common\models
 *
 * @property integer $schedule_id
 * @property integer $schedule_date
 * @property integer $schedule_season_id
 * @property integer $schedule_stage_id
 * @property integer $schedule_tournament_type_id
 */
class Schedule extends ActiveRecord
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
            [['schedule_season_id'], 'in', 'range' => Season::find()->select(['season_id'])->column()],
            [['schedule_stage_id'], 'in', 'range' => Stage::find()->select(['stage_id'])->column()],
            [
                ['schedule_tournament_type_id'],
                'in',
                'range' => TournamentType::find()->select(['tournament_type_id'])->column()
            ],
            [
                [
                    'schedule_id',
                    'schedule_date',
                    'schedule_season_id',
                    'schedule_stage_id',
                    'schedule_tournament_type_id'
                ],
                'integer'
            ],
            [['schedule_date', 'schedule_season_id', 'schedule_stage_id', 'schedule_tournament_type_id'], 'required'],
        ];
    }
}
