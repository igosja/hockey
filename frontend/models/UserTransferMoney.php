<?php

namespace frontend\models;

use common\models\Money;
use common\models\MoneyText;
use common\models\User;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class UserTransferMoney
 * @package frontend\models
 *
 * @property int $sum
 * @property User $user
 * @property int $userId
 */
class UserTransferMoney extends Model
{
    public $sum;
    public $user;
    public $userId;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['userId'], 'integer', 'min' => 1],
            [['sum'], 'number', 'min' => 0.01, 'max' => $this->user->user_money],
            [['sum', 'userId'], 'required'],
            [['userId'], 'exist', 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'user_id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'sum' => 'Сумма',
            'userId' => 'Менеджер',
        ];
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function execute()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        if (!$this->validate()) {
            return false;
        }

        $this->incomeUser();
        $this->outcomeUser();
        return true;
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function incomeUser()
    {
        $user = User::find()
            ->where(['user_id' => $this->userId])
            ->limit(1)
            ->one();
        if (!$user) {
            return false;
        }

        Money::log([
            'money_money_text_id' => MoneyText::INCOME_FRIEND,
            'money_user_id' => $user->user_id,
            'money_value' => $this->sum,
            'money_value_after' => $user->user_money + $this->sum,
            'money_value_before' => $user->user_money,
        ]);

        $user->user_money = $user->user_money + $this->sum;
        $user->save(true, ['user_money']);

        return true;
    }

    /**
     * @throws Exception
     */
    private function outcomeUser()
    {
        Money::log([
            'money_money_text_id' => MoneyText::OUTCOME_FRIEND,
            'money_user_id' => $this->user->user_id,
            'money_value' => -$this->sum,
            'money_value_after' => $this->user->user_money - $this->sum,
            'money_value_before' => $this->user->user_money,
        ]);

        $this->user->user_money = $this->user->user_money - $this->sum;
        $this->user->save(true, ['user_money']);
    }
}
