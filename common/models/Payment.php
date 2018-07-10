<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Payment
 * @package common\models
 *
 * @property integer $payment_id
 * @property integer $payment_date
 * @property integer $payment_status
 * @property float $payment_sum
 * @property integer $payment_user_id
 *
 * @property User $user
 */
class Payment extends ActiveRecord
{
    const NOT_PAID = 0;
    const PAID = 1;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%payment}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['payment_status'], 'in', [self::NOT_PAID, self::PAID]],
            [['payment_user_id'], 'in', User::find()->select(['user_id'])->column()],
            [['payment_id', 'payment_date'], 'integer'],
            [['payment_sum'], 'number', 'min' => 0.01],
            [['payment_sum'], 'required'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'payment_user_id']);
    }
}
