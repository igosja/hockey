<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class RosterPhrase
 * @package common\models
 *
 * @property int $roster_phrase_id
 * @property string $roster_phrase_text
 */
class RosterPhrase extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%roster_phrase}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['roster_phrase_id'], 'integer'],
            [['roster_phrase_text'], 'required'],
            [['roster_phrase_text'], 'string', 'max' => 255],
            [['roster_phrase_text'], 'trim'],
        ];
    }

    /**
     * @return false|null|string
     */
    public static function rand() {
        return self::find()
            ->select(['roster_phrase_text'])
            ->orderBy('RAND()')
            ->limit(1)
            ->scalar();
    }
}
