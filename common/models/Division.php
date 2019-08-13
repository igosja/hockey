<?php

namespace common\models;

/**
 * Class Division
 * @package common\models
 *
 * @property int $division_id
 * @property string $division_name
 */
class Division extends AbstractActiveRecord
{
    const D1 = 1;
    const D2 = 2;
    const D3 = 3;
    const D4 = 4;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['division_id'], 'integer'],
            [['division_name'], 'required'],
            [['division_name'], 'string', 'max' => 2],
            [['division_name'], 'trim'],
            [['division_name'], 'unique'],
        ];
    }
}
