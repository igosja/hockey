<?php

namespace common\models;

/**
 * Class Special
 * @package common\models
 *
 * @property int $special_id
 * @property int $special_field
 * @property int $special_gk
 * @property string $special_name
 * @property string $special_text
 */
class Special extends AbstractActiveRecord
{
    const ATHLETIC = 5;
    const COMBINE = 3;
    const IDOL = 9;
    const LEADER = 4;
    const POSITION = 11;
    const POWER = 2;
    const REACTION = 7;
    const SHOT = 8;
    const SPEED = 1;
    const STICK = 10;
    const TACKLE = 6;

    const MAX_LEVEL = 4;
    const MAX_SPECIALS = 4;

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
