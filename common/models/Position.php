<?php

namespace common\models;

/**
 * Class Position
 * @package common\models
 *
 * @property int $position_id
 * @property string $position_name
 * @property string $position_text
 */
class Position extends AbstractActiveRecord
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
    public static function tableName()
    {
        return '{{%position}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['position_id'], 'integer'],
            [['position_name', 'position_text'], 'required'],
            [['position_name'], 'string', 'max' => 2],
            [['position_text'], 'string', 'max' => 255],
            [['position_name', 'position_text'], 'trim'],
        ];
    }

    /**
     * @param int $id
     * @return string
     */
    public static function nameById($id)
    {
        return self::find()
            ->select(['position_name'])
            ->where(['position_id' => $id])
            ->scalar();
    }
}
