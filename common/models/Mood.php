<?php

namespace common\models;

/**
 * Class Mood
 * @package common\models
 *
 * @property int $mood_id
 * @property string $mood_name
 */
class Mood extends AbstractActiveRecord
{
    const NORMAL = 2;
    const REST = 3;
    const SUPER = 1;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['mood_id'], 'integer'],
            [['mood_name'], 'required'],
            [['mood_name'], 'string', 'max' => 10],
            [['mood_name'], 'trim'],
        ];
    }
}
