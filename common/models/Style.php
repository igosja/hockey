<?php

namespace common\models;

/**
 * Class Style
 * @package common\models
 *
 * @property int $style_id
 * @property string $style_name
 */
class Style extends AbstractActiveRecord
{
    const NORMAL = 1;
    const POWER = 2;
    const SPEED = 3;
    const TECHNIQUE = 4;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%style}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['style_id'], 'integer'],
            [['style_name'], 'required'],
            [['style_name'], 'string', 'max' => 10],
            [['style_name'], 'trim'],
        ];
    }

    /**
     * @param null $notIn
     * @return false|string|null
     */
    public static function getRandStyleId($notIn = null)
    {
        return self::find()
            ->select(['style_id'])
            ->where(['!=', 'style_id', self::NORMAL])
            ->andFilterWhere(['not', ['style_id' => $notIn]])
            ->orderBy('RAND()')
            ->limit(1)
            ->scalar();
    }
}