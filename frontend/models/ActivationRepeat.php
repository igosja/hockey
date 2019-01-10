<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\User;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class ActivationRepeat
 * @package frontend\models
 *
 * @property $email string
 */
class ActivationRepeat extends Model
{
    public $email;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email'], 'trim'],
            [['email'], 'email'],
            [['email'], 'required'],
            [['email'], 'exist', 'targetClass' => User::class, 'targetAttribute' => ['email' => 'user_email']],
            [['email'], 'checkEmail'],
        ];
    }

    /**
     * @return bool
     */
    public function send()
    {
        if (!$this->validate()) {
            return false;
        }

        try {
            $model = User::find()
                ->select(['user_code', 'user_login'])
                ->where(['user_email' => $this->email])
                ->limit(1)
                ->one();

            if (!$model) {
                throw new Exception('Пользователть с таким email не найден - ' . $this->email);
            }

            Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'signUp-html', 'text' => 'signUp-text'],
                    ['model' => $model]
                )
                ->setTo($this->email)
                ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->params['noReplyName']])
                ->setSubject('Регистрация на сайте Виртуальной Хоккейной Лиги')
                ->send();
        } catch (Exception $e) {
            ErrorHelper::log($e);
            return false;
        }

        return true;
    }

    /**
     * @param $attribute
     * @return void
     */
    public function checkEmail($attribute)
    {
        $user = User::find()
            ->select(['user_date_confirm'])
            ->where(['user_email' => $this->$attribute])
            ->limit(1)
            ->one();

        if (!$user) {
            $this->addError($attribute, 'Этот email не найден');
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
            'email' => 'Email',
        ];
    }
}
