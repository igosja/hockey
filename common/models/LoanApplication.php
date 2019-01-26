<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class LoanApplication
 * @package common\models
 *
 * @property int $loan_application_id
 * @property int $loan_application_date
 * @property int $loan_application_day
 * @property int $loan_application_deal_reason_id
 * @property int $loan_application_only_one
 * @property int $loan_application_price
 * @property int $loan_application_team_id
 * @property int $loan_application_loan_id
 * @property int $loan_application_user_id
 *
 * @property DealReason $dealReason
 * @property Team $team
 * @property User $user
 */
class LoanApplication extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%loan_application}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'loan_application_id',
                    'loan_application_date',
                    'loan_application_day',
                    'loan_application_deal_reason_id',
                    'loan_application_loan_id',
                    'loan_application_only_one',
                    'loan_application_price',
                    'loan_application_team_id',
                    'loan_application_user_id',
                ],
                'integer'
            ]
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->loan_application_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getDealReason()
    {
        return $this->hasOne(DealReason::class, ['deal_reason_id' => 'loan_application_deal_reason_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'loan_application_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'loan_application_user_id']);
    }
}
