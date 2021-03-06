<?php

namespace common\models;

/**
 * Class ConstructionType
 * @package common\models
 *
 * @property int $construction_type_id
 * @property string $construction_type_name
 */
class ConstructionType extends AbstractActiveRecord
{
    const BUILD = 1;
    const DESTROY = 2;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['construction_type_id'], 'integer'],
            [['construction_type_name'], 'required'],
            [['construction_type_name'], 'string', 'max' => 255],
            [['construction_type_name'], 'trim'],
        ];
    }
}
