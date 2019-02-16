<?php

namespace common\models;

use common\components\ErrorHelper;
use Exception;
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
 * @property string $payment_log
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
    public static function tableName()
    {
        return '{{%payment}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['payment_status'], 'in', 'range' => [self::NOT_PAID, self::PAID]],
            [['payment_id', 'payment_date'], 'integer'],
            [['payment_sum'], 'number', 'min' => 1],
            [['payment_sum'], 'required'],
            [['payment_log'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'payment_sum' => 'Сумма',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->payment_date = time();
                if (!$this->payment_user_id) {
                    $this->payment_user_id = Yii::$app->user->id;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public static function getPaymentHighChartsData()
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
    public static function getDateArrayByMonth($dateStart, $dateEnd)
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
    public function paymentUrl()
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
     * @return bool
     * @throws Exception
     */
    public function pay()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }
        if (!$this->validate()) {
            return false;
        }

        $bonus = $this->paymentBonus($this->payment_user_id);

        if ($this->payment_sum >= 100) {
            $bonus = $bonus + 10;
        }

        $sum = round($this->payment_sum * (100 + $bonus) / 100, 2);

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->payment_log = 'admin payment';
            $this->payment_status = Payment::PAID;
            $this->save();

            Money::log([
                'money_money_text_id' => MoneyText::INCOME_ADD_FUNDS,
                'money_user_id' => $this->payment_user_id,
                'money_value' => $sum,
                'money_value_after' => $this->user->user_money + $sum,
                'money_value_before' => $this->user->user_money,
            ]);

            $this->user->user_money = $this->user->user_money + $sum;
            $this->user->save(true, ['user_money']);

            if ($this->user->referrer) {
                $sum = round($sum / 10, 2);

                Money::log([
                    'money_money_text_id' => MoneyText::INCOME_REFERRAL,
                    'money_user_id' => $this->user->user_referrer_id,
                    'money_value' => $sum,
                    'money_value_after' => $this->user->referrer->user_money + $sum,
                    'money_value_before' => $this->user->referrer->user_money,
                ]);

                $this->user->referrer->user_money = $this->user->referrer->user_money + $sum;
                $this->user->referrer->save(true, ['user_money']);
            }
        } catch (Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        return true;
    }

    /**
     * @param int $userId
     * @return int
     */
    private function paymentBonus($userId)
    {
        $paymentSum = Payment::find()
            ->where(['payment_user_id' => $userId, 'payment_status' => Payment::PAID])
            ->sum('payment_sum');

        $bonusArray = $this->getBonusArray();
        foreach ($bonusArray as $sum => $bonus) {
            if ($paymentSum < $sum) {
                return $bonus;
            }
        }

        return end($bonusArray);
    }

    /**
     * @return array
     */
    private function getBonusArray()
    {
        return [0 => 0, 10 => 2, 25 => 4, 50 => 6, 75 => 8, 100 => 10, 200 => 15, 300 => 20, 500 => 25];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'payment_user_id']);
    }
}
