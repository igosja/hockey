<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Building
 * @package common\models
 *
 * @property int $building_id
 * @property string $building_name
 */
class Building extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%building}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['building_id'], 'integer'],
            [['building_name'], 'required'],
            [['building_name'], 'string', 'max' => 255],
            [['building_name'], 'trim'],
        ];
    }
}
