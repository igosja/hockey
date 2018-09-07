<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Tactic
 * @package common\models
 *
 * @property integer $tactic_id
 * @property string $tactic_name
 */
class Tactic extends ActiveRecord
{
    const ALL_DEFENCE = 1;
    const DEFENCE = 2;
    const NORMAL = 3;
    const ATACK = 4;
    const ALL_ATACK = 5;

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
