<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\User;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class Activation
 * @package frontend\models
 *
 * @property string $code
 */
class Activation extends Model
{
    /**
     * @var string $code
     */
    public $code;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['code'], 'trim'],
            [['code'], 'string', 'length' => 32],
            [['code'], 'required'],
            [['code'], 'exist', 'targetClass' => User::class, 'targetAttribute' => ['code' => 'user_code']],
            [['code'], 'checkCode'],
        ];
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function activate()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::find()
            ->where(['user_code' => $this->code])
            ->limit(1)
            ->one();

        $transaction = Yii::$app->db->beginTransaction();

        try {
            User::updateAll(['user_date_confirm' => time()], ['user_id' => $user->user_id]);
            $transaction->commit();
        } catch (Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        return true;
    }

    /**
     * @param $attribute
     * @return void
     */
    public function checkCode($attribute)
    {
        $user = User::find()
            ->where(['user_code' => $this->$attribute])
            ->limit(1)
            ->one();

        if (!$user) {
            $this->addError($attribute, 'Неверный код');
        }

        if ($user->user_date_confirm) {
            $this->addError($attribute, 'Профиль уже активирован');
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Код',
        ];
    }
}
