<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class ConstructionType
 * @package common\models
 *
 * @property int $construction_type_id
 * @property string $construction_type_name
 */
class ConstructionType extends ActiveRecord
{
    const BUILD = 1;
    const DESTROY = 2;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%construction_type}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['construction_type_id'], 'integer'],
            [['construction_type_name'], 'required'],
            [['construction_type_name'], 'string', 'max' => 255],
            [['construction_type_name'], 'trim'],
        ];
    }
}
