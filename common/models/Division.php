<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Division
 * @package common\models
 *
 * @property integer $division_id
 * @property string $division_name
 */
class Division extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%division}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['division_id'], 'integer'],
            [['division_name'], 'required'],
            [['division_name'], 'string', 'max' => 2],
            [['division_name'], 'trim'],
            [['division_name'], 'unique'],
        ];
    }
}
