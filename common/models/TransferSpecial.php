<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class TransferSpecial
 * @package common\models
 *
 * @property int $transfer_special_id
 * @property int $transfer_special_level
 * @property int $transfer_special_transfer_id
 * @property int $transfer_special_special_id
 *
 * @property Special $special
 */
class TransferSpecial extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%transfer_special}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'transfer_special_id',
                    'transfer_special_level',
                    'transfer_special_special_id',
                    'transfer_special_transfer_id',
                ],
                'integer'
            ],
            [['transfer_special_level', 'transfer_special_transfer_id', 'transfer_special_special_id'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecial()
    {
        return $this->hasOne(Special::class, ['special_id' => 'transfer_special_special_id']);
    }
}
