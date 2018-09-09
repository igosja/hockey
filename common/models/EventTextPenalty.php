<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class EventTextPenalty
 * @package common\models
 *
 * @property integer $event_text_penalty_id
 * @property string $event_text_penalty_text
 */
class EventTextPenalty extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
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
    public function rules(): array
    {
        return [
            [['event_text_penalty_id'], 'integer'],
            [['event_text_penalty_text'], 'string', 'max' => 255],
        ];
    }
}
