<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class TransferApplication
 * @package common\models
 *
 * @property integer $transfer_application_id
 * @property integer $transfer_application_date
 * @property integer $transfer_application_only_one
 * @property integer $transfer_application_price
 * @property integer $transfer_application_team_id
 * @property integer $transfer_application_transfer_id
 * @property integer $transfer_application_user_id
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
            [['transfer_application_team_id'], 'in', 'range' => Team::find()->select(['team_id'])->column()],
            [
                ['transfer_application_transfer_id'],
                'in',
                'range' => Transfer::find()->select(['transfer_id'])->column()
            ],
            [['transfer_application_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [
                [
                    'transfer_application_id',
                    'transfer_application_date',
                    'transfer_application_only_one',
                    'transfer_application_price',
                ],
                'integer'
            ]
        ];
    }
}
