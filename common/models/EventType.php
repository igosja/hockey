<?php

namespace common\models;

/**
 * Class EventType
 * @package common\models
 *
 * @property int $event_type_id
 * @property string $event_type_text
 */
class EventType extends AbstractActiveRecord
{
    const GOAL = 1;
    const PENALTY = 2;
    const SHOOTOUT = 3;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%event_type}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['event_type_id'], 'integer'],
            [['event_type_text'], 'string', 'max' => 255],
        ];
    }
}
