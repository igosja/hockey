<?php

namespace common\models;

/**
 * Class Name
 * @package common\models
 *
 * @property int $name_id
 * @property string $name_name
 */
class Name extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name_id'], 'integer'],
            [['name_name'], 'required'],
            [['name_name'], 'string', 'max' => 255],
            [['name_name'], 'trim'],
        ];
    }
}
