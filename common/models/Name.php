<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Name
 * @package common\models
 *
 * @property integer $name_id
 * @property string $name_name
 */
class Name extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%name}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name_id'], 'integer'],
            [['name_name'], 'required'],
            [['name_name'], 'string', 'max' => 255],
            [['name_name'], 'trim'],
        ];
    }
}
