<?php

namespace common\models;

/**
 * Class Squad
 * @package common\models
 *
 * @property int $squad_id
 * @property string $squad_color
 * @property string $squad_name
 */
class Squad extends AbstractActiveRecord
{
    const SQUAD_DEFAULT = 1;

    /**
     * @return string
     */
    public static function tableName():string
    {
        return '{{%squad}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['squad_id'], 'integer'],
            [['squad_color', 'squad_name'], 'required'],
            [['squad_color', 'squad_name'], 'string', 'max' => 255],
            [['squad_color', 'squad_name'], 'trim'],
            [['squad_color', 'squad_name'], 'unique'],
        ];
    }
}
