<?php

namespace frontend\models;

use yii\base\Model;

/**
 * Class Stadium
 * @package frontend\models
 *
 * @property int $capacity
 * @property \common\models\Stadium $stadium
 */
class Stadium extends Model
{
    const ONE_SIT_PRICE_BUY = 200;
    const ONE_SIT_PRICE_SELL = 150;

    const SCENARIO_DECREASE = 'decrease';
    const SCENARIO_INCREASE = 'increase';

    /**
     * @var int $capacity
     */
    public $capacity;

    /**
     * @var \common\models\Stadium $stadium
     */
    public $stadium;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                ['capacity'],
                'integer',
                'min' => 0,
                'max' => $this->stadium->stadium_capacity - 1,
                'on' => self::SCENARIO_DECREASE
            ],
            [
                ['capacity'],
                'integer',
                'min' => $this->stadium->stadium_capacity + 1,
                'max' => 25000,
                'on' => self::SCENARIO_INCREASE
            ],
            [['capacity'], 'required'],
        ];
    }
}
