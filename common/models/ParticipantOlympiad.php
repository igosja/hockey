<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class ParticipantOlympiad
 * @package common\models
 *
 * @property int $participant_olympiad_id
 * @property int $participant_olympiad_national_id
 * @property int $participant_olympiad_season_id
 * @property int $participant_olympiad_stage_1
 * @property int $participant_olympiad_stage_2
 * @property int $participant_olympiad_stage_4
 * @property int $participant_olympiad_stage_8
 * @property int $participant_olympiad_stage_id
 *
 * @property National $national
 */
class ParticipantOlympiad extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'participant_olympiad_id',
                    'participant_olympiad_national_id',
                    'participant_olympiad_season_id',
                    'participant_olympiad_stage_1',
                    'participant_olympiad_stage_2',
                    'participant_olympiad_stage_4',
                    'participant_olympiad_stage_8',
                    'participant_olympiad_stage_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getNational(): ActiveQuery
    {
        return $this->hasOne(National::class, ['national_id' => 'participant_olympiad_national_id'])->cache();
    }
}
