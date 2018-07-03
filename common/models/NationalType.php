<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class NationalType
 * @package common\models
 *
 * @property integer $national_type_id
 * @property string $national_type_name
 */
class NationalType extends ActiveRecord
{
    const U19 = 3;
    const U21 = 2;
    const MAIN = 1;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%national_type}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['national_type_id'], 'integer'],
            [['national_type_name'], 'required'],
            [['national_type_name'], 'string', 'max' => 10],
            [['national_type_name'], 'trim'],
        ];
    }
}
