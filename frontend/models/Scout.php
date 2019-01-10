<?php

namespace frontend\models;

use yii\base\Model;

/**
 * Class Scout
 * @package frontend\models
 *
 * @property array $style
 */
class Scout extends Model
{
    /**
     * @var array $style
     */
    public $style;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['style'], 'safe'],
            [['style'], 'each', 'rule' => 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function redirectUrl()
    {
        return ['scout/study', 'style' => $this->style];
    }
}
