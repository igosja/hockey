<?php

namespace common\models;

/**
 * Class Rudeness
 * @package common\models
 *
 * @property int $rudeness_id
 * @property string $rudeness_name
 */
class Rudeness extends AbstractActiveRecord
{
    const NORMAL = 1;
    const ROUGH = 2;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['rudeness_id'], 'integer'],
            [['rudeness_name'], 'required'],
            [['rudeness_name'], 'string', 'max' => 10],
            [['rudeness_name'], 'trim'],
        ];
    }
}
