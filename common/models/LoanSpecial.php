<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class LoanSpecial
 * @package common\models
 *
 * @property int $loan_special_id
 * @property int $loan_special_level
 * @property int $loan_special_loan_id
 * @property int $loan_special_special_id
 *
 * @property Special $special
 */
class LoanSpecial extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%loan_special}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['loan_special_id', 'loan_special_level', 'loan_special_loan_id', 'loan_special_special_id'], 'integer'],
            [['loan_special_level', 'loan_special_loan_id', 'loan_special_special_id'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecial(): ActiveQuery
    {
        return $this->hasOne(Special::class, ['special_id' => 'loan_special_special_id'])->cache();
    }
}
