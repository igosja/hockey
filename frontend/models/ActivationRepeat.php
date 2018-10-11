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
    public function rules(): array
    {
        return [
            [['email'], 'email'],
            [['email'], 'required'],
            [['email'], 'exist', 'targetClass' => User::class, 'targetAttribute' => ['email' => 'user_email']],
            [['email'], 'checkEmail'],
        ];
    }

    /**
     * @return bool
     */
    public function send(): bool
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
                throw new Exception('No user with email ' . $this->email);
            }

            Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'signUp-html', 'text' => 'signUp-text'],
                    ['model' => $model]
                )
                ->setTo($this->email)
                ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->params['noReplyName']])
                ->setSubject(Yii::t('common-models-SignUp', 'mail-subject'))
                ->send();
        } catch (Exception $e) {
            ErrorHelper::log($e);
            return false;
        }

        return true;
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function checkEmail($attribute): bool
    {
        $user = User::find()
            ->select(['user_date_confirm'])
            ->where(['user_email' => $this->$attribute])
            ->limit(1)
            ->one();

        if (!$user) {
            $this->addError($attribute, Yii::t('common-models-activation-repeat', 'error-no-user'));
            return false;
        }

        if ($user->user_date_confirm) {
            $this->addError($attribute, Yii::t('common-models-activation-repeat', 'error-already-active'));
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'email' => Yii::t('common-models-activation-repeat', 'label-email'),
        ];
    }
}
