<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Position
 * @package common\models
 *
 * @property integer $position_id
 * @property string $position_name
 * @property string $position_text
 */
class Position extends ActiveRecord
{
    const GK = 1;
    const LD = 2;
    const RD = 3;
    const LW = 4;
    const CF = 5;
    const RW = 6;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%position}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['position_id'], 'integer'],
            [['position_name', 'position_text'], 'required'],
            [['position_name'], 'string', 'max' => 2],
            [['position_text'], 'string', 'max' => 255],
            [['position_name', 'position_text'], 'trim'],
        ];
    }
}
