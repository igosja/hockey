<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class LoanComment
 * @package common\models
 *
 * @property integer $loan_comment_id
 * @property integer $loan_comment_check
 * @property integer $loan_comment_date
 * @property integer $loan_comment_loan_id
 * @property string $loan_comment_text
 * @property integer $loan_comment_user_id
 */
class LoanComment extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%loan_comment}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['loan_comment_loan_id'], 'in', 'range' => Loan::find()->select(['loan_id'])->column()],
            [['loan_comment_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [['loan_comment_id', '$loan_comment_check', 'loan_comment_date'], 'integer'],
            [['loan_comment_loan_id', 'loan_comment_text'], 'required'],
            [['loan_comment_text'], 'safe'],
            [['loan_comment_text'], 'trim'],
        ];
    }
}