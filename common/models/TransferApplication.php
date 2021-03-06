<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class TransferApplicationTo
 * @package common\models
 *
 * @property int $transfer_application_id
 * @property int $transfer_application_date
 * @property int $transfer_application_deal_reason_id
 * @property int $transfer_application_only_one
 * @property int $transfer_application_price
 * @property int $transfer_application_team_id
 * @property int $transfer_application_transfer_id
 * @property int $transfer_application_user_id
 *
 * @property DealReason $dealReason
 * @property Team $team
 * @property User $user
 */
class TransferApplication extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'transfer_application_id',
                    'transfer_application_date',
                    'transfer_application_deal_reason_id',
                    'transfer_application_only_one',
                    'transfer_application_price',
                    'transfer_application_team_id',
                    'transfer_application_transfer_id',
                    'transfer_application_user_id',
                ],
                'integer'
            ]
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->transfer_application_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getDealReason(): ActiveQuery
    {
        return $this->hasOne(DealReason::class, ['deal_reason_id' => 'transfer_application_deal_reason_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'transfer_application_team_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'transfer_application_user_id'])->cache();
    }
}
