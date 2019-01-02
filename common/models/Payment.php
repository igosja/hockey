<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\Query;

/**
 * Class Payment
 * @package common\models
 *
 * @property int $payment_id
 * @property int $payment_date
 * @property int $payment_status
 * @property float $payment_sum
 * @property int $payment_user_id
 *
 * @property User $user
 */
class Payment extends AbstractActiveRecord
{
    const NOT_PAID = 0;
    const PAID = 1;

    const MERCHANT_ID = 27937;
    const MERCHANT_SECRET = 'h8lzyqfr';
    const MERCHANT_SECRET_KEY = 's3lyp66r';

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
            [['payment_status'], 'in', 'range' => [self::NOT_PAID, self::PAID]],
            [['payment_id', 'payment_date'], 'integer'],
            [['payment_sum'], 'number', 'min' => 1],
            [['payment_sum'], 'required'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'payment_sum' => 'Сумма',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->payment_date = time();
                $this->payment_user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
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
                    $valueArray[] = (int)$item['total'];
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

    /**
     * @return string
     */
    public function paymentUrl(): string
    {
        $merchantId = self::MERCHANT_ID;
        $secretKey = self::MERCHANT_SECRET_KEY;
        $orderId = $this->payment_id;

        $params = [
            'm' => $merchantId,
            'oa' => $this->payment_sum * 50,
            'o' => $orderId,
            's' => md5($merchantId . ':' . $this->payment_sum * 50 . ':' . $secretKey . ':' . $orderId),
            'lang' => 'ru',
        ];

        return 'http://www.free-kassa.ru/merchant/cash.php?' . http_build_query($params);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'payment_user_id']);
    }
}
