<?php

namespace common\models;

/**
 * Class NationalUserDay
 * @package common\models
 *
 * @property int $national_user_day_id
 * @property int $national_user_day_day
 * @property int $national_user_day_national_id
 * @property int $national_user_day_user_id
 */
class NationalUserDay extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'national_user_day_id',
                    'national_user_day_day',
                    'national_user_day_national_id',
                    'national_user_day_user_id',
                ],
                'integer'
            ],
        ];
    }
}
