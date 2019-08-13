<?php

namespace common\models;

/**
 * Class Attitude
 * @package common\models
 *
 * @property int $attitude_id
 * @property string $attitude_name
 * @property int $attitude_order
 */
class Attitude extends AbstractActiveRecord
{
    const NEGATIVE = 1;
    const NEUTRAL = 2;
    const POSITIVE = 3;

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
