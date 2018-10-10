<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\User;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class SignUp
 * @package frontend\models
 *
 * @property $username string
 * @property $email string
 * @property $password string
 */
class SignUp extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['email'], 'email'],
            [['username', 'email', 'password'], 'required'],
            [['password'], 'string', 'min' => 6],
            [['username', 'email'], 'string', 'min' => 2, 'max' => 255],
            [['username', 'email'], 'trim'],
            [['username'], 'unique', 'targetClass' => '\common\models\User', 'targetAttribute' => 'user_login'],
            [['email'], 'unique', 'targetClass' => '\common\models\User', 'targetAttribute' => 'user_email'],
        ];
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function signUp(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $cookies = Yii::$app->request->cookies;
            $referrer_id = $cookies->getValue('user_referrer_id', 0);

            $model = new User();
            $model->user_email = $this->email;
            $model->user_login = $this->username;
            $model->user_referrer_id = $referrer_id;
            $model->setPassword($this->password);
            $model->save();

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

            $transaction->commit();
        } catch (Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
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
            'username' => Yii::t('common-models-SignUp', 'label-username'),
            'password' => Yii::t('common-models-SignUp', 'label-password'),
            'email' => Yii::t('common-models-SignUp', 'label-email'),
        ];
    }
}
