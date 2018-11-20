<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class LoanPosition
 * @package common\models
 *
 * @property int $loan_position_id
 * @property int $loan_position_loan_id
 * @property int $loan_position_position_id
 *
 * @property Position $position
 */
class LoanPosition extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%loan_position}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['loan_position_id', 'loan_position_loan_id', 'loan_position_position_id'], 'integer'],
            [['loan_position_loan_id', 'loan_position_position_id'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPosition(): ActiveQuery
    {
        return $this->hasOne(Position::class, ['position_id' => 'loan_position_position_id']);
    }
}
