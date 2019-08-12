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
     * @return array
     */
    public function rules(): array
    {
        return [
            [['event_text_penalty_id'], 'integer'],
            [['event_text_penalty_text'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return string
     */
    public static function getRandTextId(): string
    {
        return self::find()
            ->select(['event_text_penalty_id'])
            ->orderBy('RAND()')
            ->limit(1)
            ->scalar();
    }
}
