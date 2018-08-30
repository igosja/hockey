<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;

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

    /**
     * @return array
     */
    public static function getPaymentHighChartsData(): array
    {
        $expression = new Expression('FROM_UNIXTIME(`payment_date`, \'%b-%Y\')');
        $payment = (new Query())
            ->select(['date' => 'FROM_UNIXTIME(`payment_date`, \'%b %Y\')', 'total' => 'SUM(`payment_sum`)'])
            ->from(self::tableName())
            ->where(['payment_status' => self::PAID])
            ->groupBy($expression)
            ->all();

        $dateStart = strtotime('-11months', strtotime(date('Y-m-01')));
        $dateEnd = strtotime(date('Y-m-t'));
        $dateArray = self::getDateArrayByMonth($dateStart, $dateEnd);

        $valueArray = [];

        foreach ($dateArray as $date) {
            $inArray = false;

            foreach ($payment as $item) {
                if ($item['date'] == $date) {
                    $valueArray[] = $item['total'];
                    $inArray = true;
                }
            }

            if (false == $inArray) {
                $valueArray[] = 0;
            }
        }

        return [$dateArray, $valueArray];
    }

    /**
     * @param string $dateStart
     * @param string $dateEnd
     * @return array
     */
    public static function getDateArrayByMonth(string $dateStart, string $dateEnd): array
    {
        $dateArray = [];

        while ($dateStart < $dateEnd) {
            $dateArray[] = date('M Y', $dateStart);
            $dateStart = strtotime('+1month', strtotime(date('Y-m-d', $dateStart)));
        }

        return $dateArray;
    }
}
