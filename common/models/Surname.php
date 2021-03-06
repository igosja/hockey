<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Surname
 * @package common\models
 *
 * @property int $surname_id
 * @property string $surname_name
 *
 * @property Player[] $player
 */
class Surname extends AbstractActiveRecord
{
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

    /**
     * @return ActiveQuery
     */
    public function getPlayer(): ActiveQuery
    {
        return $this->hasMany(Player::class, ['player_surname_id' => 'surname_id']);
    }
}
