<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class TransferComment
 * @package common\models
 *
 * @property int $transfer_comment_id
 * @property int $transfer_comment_check
 * @property int $transfer_comment_date
 * @property int $transfer_comment_transfer_id
 * @property string $transfer_comment_text
 * @property int $transfer_comment_user_id
 */
class TransferComment extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%transfer_comment}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['transfer_comment_transfer_id'], 'in', 'range' => Transfer::find()->select(['transfer_id'])->column()],
            [['transfer_comment_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [['transfer_comment_id', 'transfer_comment_check', 'transfer_comment_date'], 'integer'],
            [['transfer_comment_transfer_id', 'transfer_comment_text'], 'required'],
            [['transfer_comment_text'], 'safe'],
            [['transfer_comment_text'], 'trim'],
        ];
    }
}
