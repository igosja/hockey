<?php

namespace common\models;

/**
 * Class BlockReason
 * @package common\models
 *
 * @property int $block_reason_id
 * @property string $block_reason_text
 */
class BlockReason extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%block_reason}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['block_reason_id'], 'integer'],
            [['block_reason_text'], 'required'],
            [['block_reason_text'], 'string', 'max' => 255],
            [['block_reason_text'], 'trim'],
        ];
    }
}
