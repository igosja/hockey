<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Special
 * @package common\models
 *
 * @property integer $special_id
 * @property integer $special_field
 * @property integer $special_gk
 * @property string $special_name
 * @property string $special_text
 */
class Special extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%special}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['special_id', 'special_field', 'special_gk'], 'integer'],
            [['special_name', 'position_text'], 'required'],
            [['special_name'], 'string', 'max' => 2],
            [['special_text'], 'string', 'max' => 255],
            [['special_name', 'special_text'], 'trim'],
        ];
    }
}
