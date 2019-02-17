<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Finance;
use common\models\FinanceText;
use common\models\Money;
use common\models\MoneyText;
use common\models\Payment;
use common\models\User;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
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
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'payment', 'history', 'power', 'position', 'special', 'finance'],
                'rules' => [
                    [
                        'actions' => ['index', 'payment', 'history', 'power', 'position', 'special', 'finance'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws Exception
     */
    public function beforeAction($action)
    {
        if (in_array($action->id, ['success', 'error', 'result'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionIndex()
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
    public function actionHistory()
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
     * @param int $day
     * @return string|Response
     * @throws \yii\db\Exception
     */
    public function actionVip($day)
    {
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;

        if (!in_array($day, [15, 30, 60, 180, 365])) {
            $day = 15;
        }
        $priceArray = [
            15 => 2,
            30 => 3,
            60 => 5,
            180 => 10,
            365 => 15,
        ];
        $price = $priceArray[$day];

        if ($user->user_money < $price) {
            $this->setErrorFlash('Недостаточно средств на счету.');
            return $this->redirect(['store/index']);
        }

        if (Yii::$app->request->get('ok')) {
            if ($user->user_date_vip < time()) {
                $dateVip = time() + $day * 60 * 60 * 24;
            } else {
                $dateVip = $user->user_date_vip + $day * 60 * 60 * 24;
            }

            $transaction = Yii::$app->db->beginTransaction();

            try {
                Money::log([
                    'money_money_text_id' => MoneyText::OUTCOME_VIP,
                    'money_user_id' => $user->user_id,
                    'money_value' => -$price,
                    'money_value_after' => $user->user_money - $price,
                    'money_value_before' => $user->user_money,
                ]);

                $user->user_date_vip = $dateVip;
                $user->user_money = $user->user_money - $price;
                $user->save(true, ['user_date_vip', 'user_money']);
            } catch (Exception $e) {
                ErrorHelper::log($e);
                $transaction->rollBack();

                $this->setSuccessFlash('Не удалось продлить VIP.');
                return $this->redirect(['store/index']);
            }

            $transaction->commit();
            $this->setSuccessFlash('Ваш VIP успешно продлён.');
            return $this->redirect(['store/index']);
        }

        $message = 'Вы собираетесь продлить свой VIP на ' . $day . ' дн. за ' . $price . ' ед.';

        $this->setSeoTitle('Виртуальный магазин');

        return $this->render('vip', [
            'day' => $day,
            'message' => $message,
            'user' => $user,
        ]);
    }

    /**
     * @return string|Response
     * @throws \yii\db\Exception
     */
    public function actionPower()
    {
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;

        $price = 1;

        if ($user->user_money < $price) {
            $this->setErrorFlash('Недостаточно средств на счету.');
            return $this->redirect(['store/index']);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                Money::log([
                    'money_money_text_id' => MoneyText::OUTCOME_POINT,
                    'money_user_id' => $user->user_id,
                    'money_value' => -$price,
                    'money_value_after' => $user->user_money - $price,
                    'money_value_before' => $user->user_money,
                ]);

                $user->user_shop_point = $user->user_shop_point + 1;
                $user->user_money = $user->user_money - $price;
                $user->save(true, ['user_shop_point', 'user_money']);
            } catch (Exception $e) {
                ErrorHelper::log($e);
                $transaction->rollBack();

                $this->setSuccessFlash('Не удалось совершить покупку.');
                return $this->redirect(['store/index']);
            }

            $transaction->commit();
            $this->setSuccessFlash('Покупка совершена успешно.');
            return $this->redirect(['store/index']);
        }

        $message = 'Вы собираетесь приобрести балл силы для тренировки игрока команды за ' . $price . ' ед.';

        $this->setSeoTitle('Виртуальный магазин');

        return $this->render('power', [
            'message' => $message,
            'user' => $user,
        ]);
    }

    /**
     * @return string|Response
     * @throws \yii\db\Exception
     */
    public function actionPosition()
    {
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;

        $price = 3;

        if ($user->user_money < $price) {
            $this->setErrorFlash('Недостаточно средств на счету.');
            return $this->redirect(['store/index']);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                Money::log([
                    'money_money_text_id' => MoneyText::OUTCOME_POSITION,
                    'money_user_id' => $user->user_id,
                    'money_value' => -$price,
                    'money_value_after' => $user->user_money - $price,
                    'money_value_before' => $user->user_money,
                ]);

                $user->user_shop_position = $user->user_shop_position + 1;
                $user->user_money = $user->user_money - $price;
                $user->save(true, ['user_shop_position', 'user_money']);
            } catch (Exception $e) {
                ErrorHelper::log($e);
                $transaction->rollBack();

                $this->setSuccessFlash('Не удалось совершить покупку.');
                return $this->redirect(['store/index']);
            }

            $transaction->commit();
            $this->setSuccessFlash('Покупка совершена успешно.');
            return $this->redirect(['store/index']);
        }

        $message = 'Вы собираетесь приобрести совмещение для игрока команды за ' . $price . ' ед.';

        $this->setSeoTitle('Виртуальный магазин');

        return $this->render('position', [
            'message' => $message,
            'user' => $user,
        ]);
    }

    /**
     * @return string|Response
     * @throws \yii\db\Exception
     */
    public function actionSpecial()
    {
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;

        $price = 3;

        if ($user->user_money < $price) {
            $this->setErrorFlash('Недостаточно средств на счету.');
            return $this->redirect(['store/index']);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                Money::log([
                    'money_money_text_id' => MoneyText::OUTCOME_SPECIAL,
                    'money_user_id' => $user->user_id,
                    'money_value' => -$price,
                    'money_value_after' => $user->user_money - $price,
                    'money_value_before' => $user->user_money,
                ]);

                $user->user_shop_special = $user->user_shop_special + 1;
                $user->user_money = $user->user_money - $price;
                $user->save(true, ['user_shop_special', 'user_money']);
            } catch (Exception $e) {
                ErrorHelper::log($e);
                $transaction->rollBack();

                $this->setSuccessFlash('Не удалось совершить покупку.');
                return $this->redirect(['store/index']);
            }

            $transaction->commit();
            $this->setSuccessFlash('Покупка совершена успешно.');
            return $this->redirect(['store/index']);
        }

        $message = 'Вы собираетесь приобрести спецвозможность для игрока команды за ' . $price . ' ед.';

        $this->setSeoTitle('Виртуальный магазин');

        return $this->render('special', [
            'message' => $message,
            'user' => $user,
        ]);
    }

    /**
     * @return string|Response
     * @throws \yii\db\Exception
     */
    public function actionFinance()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;

        $price = 5;

        if ($user->user_money < $price) {
            $this->setErrorFlash('Недостаточно средств на счету.');
            return $this->redirect(['store/index']);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                Money::log([
                    'money_money_text_id' => MoneyText::OUTCOME_TEAM_FINANCE,
                    'money_user_id' => $user->user_id,
                    'money_value' => -$price,
                    'money_value_after' => $user->user_money - $price,
                    'money_value_before' => $user->user_money,
                ]);

                $user->user_money = $user->user_money - $price;
                $user->save(true, ['user_money']);

                $teamMoney = 1000000;

                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_PRIZE_VIP,
                    'finance_team_id' => $this->myTeam->team_id,
                    'finance_value' => $teamMoney,
                    'finance_value_after' => $this->myTeam->team_finance + $teamMoney,
                    'finance_value_before' => $this->myTeam->team_finance,
                ]);

                $this->myTeam->team_finance = $this->myTeam->team_finance + $teamMoney;
                $this->myTeam->save(true, ['team_finance']);
            } catch (Exception $e) {
                ErrorHelper::log($e);
                $transaction->rollBack();

                $this->setSuccessFlash('Не удалось совершить покупку.');
                return $this->redirect(['store/index']);
            }

            $transaction->commit();
            $this->setSuccessFlash('Покупка совершена успешно.');
            return $this->redirect(['store/index']);
        }

        $message = 'Вы собираетесь приобрести ' . FormatHelper::asCurrency(1000000) . ' на счёт своей команды за ' . $price . ' ед.';

        $this->setSeoTitle('Виртуальный магазин');

        return $this->render('finance', [
            'message' => $message,
            'user' => $user,
        ]);
    }

    /**
     * @return Response
     */
    public function actionSuccess()
    {
        $this->setSuccessFlash('Счёт успешно пополнен.');
        return $this->redirect(['store/index']);
    }

    /**
     * @return Response
     */
    public function actionError()
    {
        $this->setSuccessFlash('Счёт пополнить не удалось.');
        return $this->redirect(['store/index']);
    }

    /**
     * @throws \Exception
     * @return void
     */
    public function actionResult()
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

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $payment->payment_log = Json::encode($_REQUEST);
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
            $payment->user->save(true, ['user_money']);

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
                $payment->user->referrer->save(true, ['user_money']);
            }
        } catch (Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            die('NO');
        }
        $transaction->commit();

        die('YES');
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
}
