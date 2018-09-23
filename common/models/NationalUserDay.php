<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class NationalUserDay
 * @package common\models
 *
 * @property int $national_user_day_id
 * @property int $national_user_day_day
 * @property int $national_user_day_national_id
 * @property int $national_user_day_user_id
 */
class NationalUserDay extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%national_user_day}}';
    }

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
                    'national_user_day_user_id'
                ],
                'integer'
            ],
        ];
    }
}
