<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class BaseScout
 * @package common\models
 *
 * @property integer $base_scout_id
 * @property integer $base_scout_base_level
 * @property integer $base_scout_build_speed
 * @property integer $base_scout_distance
 * @property integer $base_scout_level
 * @property integer $base_scout_market_game_row
 * @property integer $base_scout_market_physical
 * @property integer $base_scout_market_tire
 * @property integer $base_scout_my_style_count
 * @property integer $base_scout_my_style_price
 * @property integer $base_scout_opponent_game_row
 * @property integer $base_scout_opponent_physical
 * @property integer $base_scout_opponent_tire
 * @property integer $base_scout_price_buy
 * @property integer $base_scout_price_sell
 * @property integer $base_scout_scout_speed_max
 * @property integer $base_scout_scout_speed_min
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
