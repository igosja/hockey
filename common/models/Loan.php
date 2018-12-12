<?php

namespace common\models;

use common\components\FormatHelper;
use Exception;
use yii\db\ActiveQuery;

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
 * @property LoanApplication[] $loanApplication
 * @property Team $buyer
 * @property Player $player
 * @property Team $seller
 */
class Loan extends AbstractActiveRecord
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
                    'loan_player_id',
                    'loan_player_price',
                    'loan_power',
                    'loan_price_buyer',
                    'loan_price_seller',
                    'loan_ready',
                    'loan_season_id',
                    'loan_team_buyer_id',
                    'loan_team_seller_id',
                    'loan_user_buyer_id',
                    'loan_user_seller_id',
                ],
                'integer'
            ]
        ];
    }

    /**
     * @return string
     */
    public function dealDate(): string
    {
        $today = strtotime(date('Y-m-d 12:00:00'));

        if ($today < $this->loan_date + 86400 || $today < time()) {
            $today = $today + 86400;
        }

        $result = FormatHelper::asDate($today);
        return $result;
    }

    /**
     * @return string
     */
    public function position(): string
    {
        $result = [];
        foreach ($this->playerPosition as $position) {
            $result[] = $position->position->position_name;
        }
        return implode('/', $result);
    }

    /**
     * @return string
     */
    public function special(): string
    {
        $result = [];
        foreach ($this->playerSpecial as $special) {
            $result[] = $special->special->special_name . $special->player_special_level;
        }
        return implode('', $result);
    }

    /**
     * @return bool
     * @throws Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        foreach ($this->loanApplication as $item) {
            $item->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     */
    public function getBuyer(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'loan_team_buyer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLoanApplication(): ActiveQuery
    {
        return $this->hasMany(LoanApplication::class, ['loan_application_loan_id' => 'loan_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer(): ActiveQuery
    {
        return $this->hasOne(Player::class, ['player_id' => 'loan_player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSeller(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'loan_team_seller_id']);
    }
}
