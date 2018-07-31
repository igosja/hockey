<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class LoanApplication
 * @package common\models
 *
 * @property integer $loan_application_id
 * @property integer $loan_application_date
 * @property integer $loan_application_day
 * @property integer $loan_application_only_one
 * @property integer $loan_application_price
 * @property integer $loan_application_team_id
 * @property integer $loan_application_loan_id
 * @property integer $loan_application_user_id
 */
class LoanApplication extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%loan_application}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['loan_application_team_id'], 'in', 'range' => Team::find()->select(['team_id'])->column()],
            [
                ['loan_application_loan_id'],
                'in',
                'range' => Transfer::find()->select(['loan_id'])->column()
            ],
            [['loan_application_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [
                [
                    'loan_application_id',
                    'loan_application_date',
                    'loan_application_day',
                    'loan_application_only_one',
                    'loan_application_price',
                ],
                'integer'
            ]
        ];
    }
}
