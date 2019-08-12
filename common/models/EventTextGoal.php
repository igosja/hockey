<?php

namespace common\models;

/**
 * Class EventTextGoal
 * @package common\models
 *
 * @property int $event_text_goal_id
 * @property string $event_text_goal_text
 */
class EventTextGoal extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['event_text_goal_id'], 'integer'],
            [['event_text_goal_text'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return string
     */
    public static function getRandTextId(): string
    {
        return self::find()
            ->select(['event_text_goal_id'])
            ->orderBy('RAND()')
            ->limit(1)
            ->scalar();
    }
}
