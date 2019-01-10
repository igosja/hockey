<?php

namespace common\models;

/**
 * Class EventTextPenalty
 * @package common\models
 *
 * @property int $event_text_penalty_id
 * @property string $event_text_penalty_text
 */
class EventTextPenalty extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%event_text_penalty}}';
    }

    /**
     * @return false|null|string
     */
    public static function getRandTextId()
    {
        return self::find()
            ->select(['event_text_penalty_id'])
            ->orderBy('RAND()')
            ->limit(1)
            ->scalar();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['event_text_penalty_id'], 'integer'],
            [['event_text_penalty_text'], 'string', 'max' => 255],
        ];
    }
}
