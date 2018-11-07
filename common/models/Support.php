<?php

namespace common\models;

/**
 * Class Support
 * @package common\models
 *
 * @property int $support_id
 * @property int $support_date
 * @property int $support_read
 * @property string $support_text
 * @property int $support_user_id_from
 * @property int $support_user_id_to
 */
class Support extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%support}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'support_id',
                    'support_date',
                    'support_read',
                    'support_user_id_from',
                    'support_user_id_to',
                ],
                'integer'
            ],
            [['support_text', 'support_user_id_to'], 'required'],
            [['support_text'], 'safe'],
            [['support_text'], 'trim'],
        ];
    }
}
