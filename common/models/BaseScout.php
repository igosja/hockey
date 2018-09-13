<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class BaseScout
 * @package common\models
 *
 * @property int $base_scout_id
 * @property int $base_scout_base_level
 * @property int $base_scout_build_speed
 * @property int $base_scout_distance
 * @property int $base_scout_level
 * @property int $base_scout_market_game_row
 * @property int $base_scout_market_physical
 * @property int $base_scout_market_tire
 * @property int $base_scout_my_style_count
 * @property int $base_scout_my_style_price
 * @property int $base_scout_opponent_game_row
 * @property int $base_scout_opponent_physical
 * @property int $base_scout_opponent_tire
 * @property int $base_scout_price_buy
 * @property int $base_scout_price_sell
 * @property int $base_scout_scout_speed_max
 * @property int $base_scout_scout_speed_min
 */
class BaseScout extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%base_scout}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'base_scout_id',
                    'base_scout_base_level',
                    'base_scout_build_speed',
                    'base_scout_distance',
                    'base_scout_level',
                    'base_scout_market_game_row',
                    'base_scout_market_physical',
                    'base_scout_market_tire',
                    'base_scout_my_style_count',
                    'base_scout_my_style_price',
                    'base_scout_opponent_game_row',
                    'base_scout_opponent_physical',
                    'base_scout_opponent_tire',
                    'base_scout_price_buy',
                    'base_scout_price_sell',
                    'base_scout_scout_speed_max',
                    'base_scout_scout_speed_min',
                ],
                'integer'
            ],
        ];
    }
}
