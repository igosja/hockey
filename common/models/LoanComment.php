<?php

namespace common\models;

use yii\db\ActiveRecord;

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
            [
                [
                    'loan_comment_id',
                    '$loan_comment_check',
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
}
