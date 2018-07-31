<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Loan
 * @package common\models
 *
 * @property integer $loan_id
 * @property integer $loan_age
 * @property integer $loan_cancel
 * @property integer $loan_checked
 * @property integer $loan_date
 * @property integer $loan_day
 * @property integer $loan_day_max
 * @property integer $loan_day_min
 * @property integer $loan_player_id
 * @property integer $loan_player_price
 * @property integer $loan_power
 * @property integer $loan_price_buyer
 * @property integer $loan_price_seller
 * @property integer $loan_ready
 * @property integer $loan_season_id
 * @property integer $loan_team_buyer_id
 * @property integer $loan_team_seller_id
 * @property integer $loan_user_buyer_id
 * @property integer $loan_user_seller_id
 */
class Loan extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%loan}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['loan_player_id'], 'in', 'range' => Player::find()->select(['player_id'])->column()],
            [['loan_season_id'], 'in', 'range' => Season::find()->select(['season_id'])->column()],
            [
                ['loan_team_buyer_id', 'loan_team_seller_id'],
                'in',
                'range' => Team::find()->select(['team_id'])->column()
            ],
            [
                ['loan_user_buyer_id', 'loan_user_seller_id'],
                'in',
                'range' => User::find()->select(['user_id'])->column()
            ],
            [
                [
                    'loan_id',
                    'loan_age',
                    'loan_cancel',
                    'loan_checked',
                    'loan_date',
                    'loan_day',
                    'loan_day_max',
                    'loan_day_min',
                    'loan_player_price',
                    'loan_power',
                    'loan_price_buyer',
                    'loan_price_seller',
                    'loan_ready',
                ],
                'integer'
            ]
        ];
    }
}
