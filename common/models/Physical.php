<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Physical
 * @package common\models
 *
 * @property integer $physical_id
 * @property string $physical_name
 * @property integer $physical_opposite
 * @property integer $physical_value
 */
class Physical extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%physical}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['physical_opposite'], 'in', self::find()->select(['physical_id'])->column()],
            [['physical_id', 'physical_value'], 'integer'],
            [['physical_name', 'physical_value'], 'required'],
            [['physical_name'], 'string', 'max' => 20],
            [['physical_name'], 'trim'],
        ];
    }
}
