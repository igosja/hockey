<?php

namespace common\models;

use common\components\HockeyHelper;
use Yii;
use yii\db\ActiveQuery;

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
 *
 * @property User $user
 */
class TransferComment extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%transfer_comment}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'transfer_comment_id',
                    'transfer_comment_check',
                    'transfer_comment_date',
                    'transfer_comment_transfer_id',
                    'transfer_comment_user_id',
                ],
                'integer'
            ],
            [['transfer_comment_transfer_id', 'transfer_comment_text'], 'required'],
            [['transfer_comment_text'], 'safe'],
            [['transfer_comment_text'], 'trim'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isNewRecord) {
            $this->transfer_comment_date = time();
            $this->transfer_comment_user_id = Yii::$app->user->id;
        }
        $this->transfer_comment_text = HockeyHelper::clearBbCodeBeforeSave($this->transfer_comment_text);
        return true;
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'transfer_comment_user_id']);
    }
}
