<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class LineupSpecial
 * @package common\models
 *
 * @property int $lineup_special_id
 * @property int $lineup_special_level
 * @property int $lineup_special_lineup_id
 * @property int $lineup_special_special_id
 *
 * @property Special $special
 */
class LineupSpecial extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'lineup_special_id',
                    'lineup_special_level',
                    'lineup_special_special_id',
                    'lineup_special_lineup_id',
                ],
                'integer'
            ],
            [['lineup_special_level', 'lineup_special_lineup_id', 'lineup_special_special_id'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecial(): ActiveQuery
    {
        return $this->hasOne(Special::class, ['special_id' => 'lineup_special_special_id'])->cache();
    }
}
