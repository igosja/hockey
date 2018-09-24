<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Attitude
 * @package common\models
 *
 * @property int $attitude_id
 * @property string $attitude_name
 * @property int $attitude_order
 */
class Attitude extends ActiveRecord
{
    const NEGATIVE = 1;
    const NEUTRAL = 2;
    const POSITIVE = 3;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%attitude}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['attitude_id', 'attitude_order'], 'integer'],
            [['attitude_name'], 'required'],
            [['attitude_name'], 'string', 'max' => 255],
            [['attitude_name'], 'trim'],
        ];
    }
}
