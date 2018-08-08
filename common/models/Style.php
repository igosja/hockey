<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Style
 * @package common\models
 *
 * @property integer $style_id
 * @property string $style_name
 */
class Style extends ActiveRecord
{
    const NORMAL = 1;
    const POWER = 2;
    const SPEED = 3;
    const TECHNIQUE = 4;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%style}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['style_id'], 'integer'],
            [['style_name'], 'required'],
            [['style_name'], 'string', 'max' => 10],
            [['style_name'], 'trim'],
        ];
    }

    /**
     * @return false|null|string
     */
    public static function getRandStyleId()
    {
        return self::find()
            ->select(['style_id'])
            ->where(['!=', 'style_id', self::NORMAL])
            ->orderBy('RAND()')
            ->limit(1)
            ->scalar();
    }
}
