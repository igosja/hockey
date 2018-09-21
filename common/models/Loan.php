<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Loan
 * @package common\models
 *
 * @property int $loan_id
 * @property int $loan_age
 * @property int $loan_cancel
 * @property int $loan_checked
 * @property int $loan_date
 * @property int $loan_day
 * @property int $loan_day_max
 * @property int $loan_day_min
 * @property int $loan_player_id
 * @property int $loan_player_price
 * @property int $loan_power
 * @property int $loan_price_buyer
 * @property int $loan_price_seller
 * @property int $loan_ready
 * @property int $loan_season_id
 * @property int $loan_team_buyer_id
 * @property int $loan_team_seller_id
 * @property int $loan_user_buyer_id
 * @property int $loan_user_seller_id
 *
 * @property Player $player
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

    /**
     * @return ActiveQuery
     */
    public function getPlayer(): ActiveQuery
    {
        return $this->hasOne(Player::class, ['player_id' => 'loan_player_id']);
    }
}
