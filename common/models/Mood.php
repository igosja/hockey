<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Mood
 * @package common\models
 *
 * @property int $mood_id
 * @property string $mood_name
 */
class Mood extends ActiveRecord
{
    const NORMAL = 1;
    const REST = 2;
    const SUPER = 3;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%mood}}';
    }

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
