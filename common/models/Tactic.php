<?php

namespace common\models;

/**
 * Class Tactic
 * @package common\models
 *
 * @property int $tactic_id
 * @property string $tactic_name
 */
class Tactic extends AbstractActiveRecord
{
    const ALL_DEFENCE = 1;
    const DEFENCE = 2;
    const NORMAL = 3;
    const ATTACK = 4;
    const ALL_ATTACK = 5;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%tactic}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['tactic_id'], 'integer'],
            [['tactic_name'], 'required'],
            [['tactic_name'], 'string', 'max' => 10],
            [['tactic_name'], 'trim'],
        ];
    }
}
