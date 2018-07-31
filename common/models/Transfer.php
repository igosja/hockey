<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Transfer
 * @package common\models
 *
 * @property integer $transfer_id
 * @property integer $transfer_age
 * @property integer $transfer_cancel
 * @property integer $transfer_checked
 * @property integer $transfer_date
 * @property integer $transfer_player_id
 * @property integer $transfer_player_price
 * @property integer $transfer_power
 * @property integer $transfer_price_buyer
 * @property integer $transfer_price_seller
 * @property integer $transfer_ready
 * @property integer $transfer_season_id
 * @property integer $transfer_team_buyer_id
 * @property integer $transfer_team_seller_id
 * @property integer $transfer_to_league
 * @property integer $transfer_user_buyer_id
 * @property integer $transfer_user_seller_id
 */
class Transfer extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%transfer}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['transfer_player_id'], 'in', 'range' => Player::find()->select(['player_id'])->column()],
            [['transfer_season_id'], 'in', 'range' => Season::find()->select(['season_id'])->column()],
            [
                ['transfer_team_buyer_id', 'transfer_team_seller_id'],
                'in',
                'range' => Team::find()->select(['team_id'])->column()
            ],
            [
                ['transfer_user_buyer_id', 'transfer_user_seller_id'],
                'in',
                'range' => User::find()->select(['user_id'])->column()
            ],
            [
                [
                    'transfer_id',
                    'transfer_age',
                    'transfer_cancel',
                    'transfer_checked',
                    'transfer_date',
                    'transfer_player_price',
                    'transfer_power',
                    'transfer_price_buyer',
                    'transfer_price_seller',
                    'transfer_ready',
                    'transfer_to_league',
                ],
                'integer'
            ]
        ];
    }
}
