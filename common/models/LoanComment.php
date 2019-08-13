<?php

namespace common\models;

use common\components\HockeyHelper;
use Yii;
use yii\db\ActiveQuery;

/**
 * Class LoanComment
 * @package common\models
 *
 * @property int $loan_comment_id
 * @property int $loan_comment_check
 * @property int $loan_comment_date
 * @property int $loan_comment_loan_id
 * @property string $loan_comment_text
 * @property int $loan_comment_user_id
 *
 * @property User $user
 */
class LoanComment extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'loan_comment_id',
                    'loan_comment_check',
                    'loan_comment_date',
                    'loan_comment_loan_id',
                    'loan_comment_user_id',
                ],
                'integer'
            ],
            [['loan_comment_loan_id', 'loan_comment_text'], 'required'],
            [['loan_comment_text'], 'safe'],
            [['loan_comment_text'], 'trim'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isNewRecord) {
            $this->loan_comment_date = time();
            $this->loan_comment_user_id = Yii::$app->user->id;
        }
        $this->loan_comment_text = HockeyHelper::clearBbCodeBeforeSave($this->loan_comment_text);
        return true;
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'loan_comment_user_id'])->cache();
    }
}
