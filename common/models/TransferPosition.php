<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class TransferPosition
 * @package common\models
 *
 * @property int $transfer_position_id
 * @property int $transfer_position_transfer_id
 * @property int $transfer_position_position_id
 *
 * @property Position $position
 */
class TransferPosition extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%transfer_position}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['transfer_position_id', 'transfer_position_position_id', 'transfer_position_transfer_id'], 'integer'],
            [['transfer_position_transfer_id', 'transfer_position_position_id'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPosition(): ActiveQuery
    {
        return $this->hasOne(Position::class, ['position_id' => 'transfer_position_position_id']);
    }
}
