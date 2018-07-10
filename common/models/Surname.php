<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Surname
 * @package common\models
 *
 * @property integer $surname_id
 * @property string $surname_name
 */
class Surname extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%surname}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['surname_id'], 'integer'],
            [['surname_name'], 'required'],
            [['surname_name'], 'string', 'max' => 255],
            [['surname_name'], 'trim'],
        ];
    }
}
