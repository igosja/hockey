<?php

namespace common\models;

/**
 * Class Building
 * @package common\models
 *
 * @property int $building_id
 * @property string $building_name
 */
class Building extends AbstractActiveRecord
{
    const BASE = 1;
    const MEDICAL = 2;
    const PHYSICAL = 3;
    const SCHOOL = 4;
    const SCOUT = 5;
    const TRAINING = 6;

    const MAX_LEVEL = 10;
    const MIN_LEVEL = 0;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['building_id'], 'integer'],
            [['building_name'], 'required'],
            [['building_name'], 'string', 'max' => 255],
            [['building_name'], 'trim'],
        ];
    }
}
