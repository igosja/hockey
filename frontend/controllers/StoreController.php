<?php

namespace frontend\controllers;

use common\models\Money;
use common\models\MoneyText;
use common\models\Payment;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class StoreController
 * @package frontend\controllers
 */
class StoreController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $this->setSeoTitle('Виртуальный магазин');

        return $this->render('index', [
            'user' => Yii::$app->user->identity
        ]);
    }

    /**
     * @return string|Response
     * @throws \Exception
     */
    public function actionPayment()
    {
        $model = new Payment();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($model->paymentUrl());
        }

        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;

        $bonusArray = $this->getBonusArray();
        $bonus = $this->paymentBonus($user->user_id);

        $bonusLine = [];

        foreach ($bonusArray as $item) {
            if ($bonus == $item) {
                $bonusLine[] = '<span class="strong">' . $item . '%</span>';
            } else {
                $bonusLine[] = $item . '%';
            }
        }

        $bonusLine = implode(' | ', $bonusLine);

        $this->setSeoTitle('Пополнение денежного счёта');

        return $this->render('payment', [
            'bonusLine' => $bonusLine,
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * @return string
     */
    public function actionHistory(): string
    {
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;
        $query = Money::find()
            ->where(['money_user_id' => $user->user_id])
            ->orderBy(['money_id' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->setSeoTitle('История платежей');

        return $this->render('history', [
            'dataProvider' => $dataProvider,
            'user' => $user,
        ]);
    }

    /**
     * @return Response
     */
    public function actionSuccess(): Response
    {
        $this->setSuccessFlash('Счёт успешно пополнен.');
        return $this->redirect(['store/index']);
    }

    /**
     * @return Response
     */
    public function actionError(): Response
    {
        $this->setSuccessFlash('Счёт пополнить не удалось.');
        return $this->redirect(['store/index']);
    }

    /**
     * @throws \Exception
     * @return void
     */
    public function actionResult(): void
    {
        if (isset($_SERVER['HTTP_X_REAL_IP'])) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if (!in_array($ip, [
            '136.243.38.147',
            '136.243.38.149',
            '136.243.38.150',
            '136.243.38.151',
            '136.243.38.189',
            '88.198.88.98',
        ])) {
            die('HACKING ATTEMPT');
        }

        if (!isset($_REQUEST['MERCHANT_ID']) ||
            !isset($_REQUEST['AMOUNT']) ||
            !isset($_REQUEST['MERCHANT_ORDER_ID']) ||
            !isset($_REQUEST['SIGN'])) {
            die('WRONG POST');
        }

        $merchantId = Payment::MERCHANT_ID;
        $secret = Payment::MERCHANT_SECRET;
        $sign = $_REQUEST['SIGN'];
        $paymentId = $_REQUEST['MERCHANT_ORDER_ID'];
        $sign_check = md5($merchantId . ':' . $_REQUEST['AMOUNT'] . ':' . $secret . ':' . $paymentId);

        if ($sign_check != $sign) {
            die('NO. WRONG SIGN');
        }

        $payment = Payment::find()
            ->where(['payment_id' => $paymentId])
            ->limit(1)
            ->one();
        if (!$payment) {
            die('NO. WRONG PAYMENT ID');
        }

        if (Payment::PAID == $payment->payment_status) {
            die('NO. WRONG PAYMENT STATUS');
        }

        $bonus = $this->paymentBonus($payment->payment_user_id);

        if ($payment->payment_sum >= 100) {
            $bonus = $bonus + 10;
        }

        $sum = round($payment->payment_sum * (100 + $bonus) / 100, 2);

        $payment->payment_status = Payment::PAID;
        $payment->save();

        Money::log([
            'money_money_text_id' => MoneyText::INCOME_ADD_FUNDS,
            'money_user_id' => $payment->payment_user_id,
            'money_value' => $sum,
            'money_value_after' => $payment->user->user_money + $sum,
            'money_value_before' => $payment->user->user_money,
        ]);

        $payment->user->user_money = $payment->user->user_money + $sum;
        $payment->user->save();

        if ($payment->user->referrer) {
            $sum = round($sum / 10, 2);

            Money::log([
                'money_money_text_id' => MoneyText::INCOME_REFERRAL,
                'money_user_id' => $payment->user->user_referrer_id,
                'money_value' => $sum,
                'money_value_after' => $payment->user->referrer->user_money + $sum,
                'money_value_before' => $payment->user->referrer->user_money,
            ]);

            $payment->user->referrer->user_money = $payment->user->referrer->user_money + $sum;
            $payment->user->save();
        }

        die('YES');
    }

    /**
     * @param int $userId
     * @return int
     */
    private function paymentBonus(int $userId): int
    {
        $paymentSum = Payment::find()
            ->where(['payment_user_id' => $userId, 'payment_status' => Payment::PAID])
            ->sum('payment_sum');

        $bonusArray = $this->getBonusArray();
        foreach ($bonusArray as $sum => $bonus) {
            if ($paymentSum >= $sum) {
                return $bonus;
            }
        }

        return 0;
    }

    /**
     * @return array
     */
    private function getBonusArray(): array
    {
        return [0 => 0, 10 => 2, 25 => 4, 50 => 6, 75 => 8, 100 => 10, 200 => 15, 300 => 20, 500 => 25];
    }
}
