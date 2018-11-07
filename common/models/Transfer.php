<?php

namespace common\models;

use common\components\ErrorHelper;
use Exception;
use Yii;
use yii\db\ActiveQuery;

/**
 * Class Transfer
 * @package common\models
 *
 * @property int $transfer_id
 * @property int $transfer_age
 * @property int $transfer_cancel
 * @property int $transfer_checked
 * @property int $transfer_date
 * @property int $transfer_player_id
 * @property int $transfer_player_price
 * @property int $transfer_power
 * @property int $transfer_price_buyer
 * @property int $transfer_price_seller
 * @property int $transfer_ready
 * @property int $transfer_season_id
 * @property int $transfer_team_buyer_id
 * @property int $transfer_team_seller_id
 * @property int $transfer_to_league
 * @property int $transfer_user_buyer_id
 * @property int $transfer_user_seller_id
 *
 * @property Team $buyer
 * @property Player $player
 * @property Team $seller
 */
class Transfer extends AbstractActiveRecord
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
            [
                [
                    'transfer_id',
                    'transfer_age',
                    'transfer_cancel',
                    'transfer_checked',
                    'transfer_date',
                    'transfer_player_id',
                    'transfer_player_price',
                    'transfer_power',
                    'transfer_price_buyer',
                    'transfer_price_seller',
                    'transfer_ready',
                    'transfer_season_id',
                    'transfer_team_buyer_id',
                    'transfer_team_seller_id',
                    'transfer_to_league',
                    'transfer_user_buyer_id',
                    'transfer_user_seller_id',
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
     * @return ActiveQuery
     */
    public function getBuyer(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'transfer_team_buyer_id']);
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
