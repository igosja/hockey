<?php

namespace common\models;

/**
 * Class DayType
 * @package common\models
 *
 * @property int $day_type_id
 * @property string $day_type_name
 * @property string $day_type_text
 */
class DayType extends AbstractActiveRecord
{
    const A = 1;
    const B = 2;
    const C = 3;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%day_type}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['day_type_id'], 'integer'],
            [['day_type_name', 'day_type_text'], 'required'],
            [['day_type_name'], 'string', 'max' => 1],
            [['day_type_text'], 'string', 'max' => 255],
            [['day_type_name', 'day_type_name'], 'trim'],
            [['day_type_name', 'day_type_name'], 'unique'],
        ];
    }
}
