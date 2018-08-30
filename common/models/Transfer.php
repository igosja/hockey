<?php

namespace common\models;

use common\components\ErrorHelper;
use Exception;
use Yii;
use yii\db\ActiveQuery;
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
 *
 * @property Player $player
 * @property Team $seller
 */
class Transfer extends ActiveRecord
{
    const PAGE_LIMIT = 50;

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

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->transfer_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function dealDate(): string
    {
        $today = strtotime(date('Y-m-d 12:00:00'));

        if ($today < $this->transfer_date + 86400 || $today < time()) {
            $today = $today + 86400;
        }

        $result = '';
        try {
            $result = Yii::$app->formatter->asDate($today);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        return $result;
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer(): ActiveQuery
    {
        return $this->hasOne(Player::class, ['player_id' => 'transfer_player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSeller(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'transfer_team_seller_id']);
    }
}
