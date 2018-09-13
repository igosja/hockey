<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class EventType
 * @package common\models
 *
 * @property int $event_type_id
 * @property string $event_type_text
 */
class EventType extends ActiveRecord
{
    const GOAL = 1;
    const PENALTY = 2;
    const SHOOTOUT = 3;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%event_type}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['event_type_id'], 'integer'],
            [['event_type_text'], 'string', 'max' => 255],
        ];
    }
}
