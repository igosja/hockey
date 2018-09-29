<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class TransferApplicationTo
 * @package common\models
 *
 * @property int $transfer_application_id
 * @property int $transfer_application_date
 * @property int $transfer_application_only_one
 * @property int $transfer_application_price
 * @property int $transfer_application_team_id
 * @property int $transfer_application_transfer_id
 * @property int $transfer_application_user_id
 *
 * @property Team $team
 */
class TransferApplication extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%transfer_application}}';
    }

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
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'transfer_application_team_id']);
    }
}
