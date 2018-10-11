<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\User;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class Password
 * @package frontend\models
 *
 * @property $email string
 * @property $username string
 */
class Password extends Model
{
    public $email;
    public $username;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['email'], 'email'],
            [['username'], 'string', 'max' => 255],
            [['email', 'username'], 'orRequired', 'skipOnEmpty' => false],
            [['email'], 'exist', 'targetClass' => User::class, 'targetAttribute' => ['email' => 'user_email']],
            [['username'], 'exist', 'targetClass' => User::class, 'targetAttribute' => ['username' => 'user_login']],
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
                ->select(['user_code', 'user_email'])
                ->andFilterWhere(['user_email' => $this->email])
                ->andFilterWhere(['user_login' => $this->username])
                ->limit(1)
                ->one();

            if (!$model) {
                throw new Exception('No user with email ' . $this->email . ' and username ' . $this->username);
            }

            Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'password-html', 'text' => 'password-text'],
                    ['model' => $model]
                )
                ->setTo($model->user_email)
                ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->params['noReplyName']])
                ->setSubject(Yii::t('common-models-password', 'mail-subject'))
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
    public function orRequired($attribute): void
    {
        if (!$this->email && !$this->username) {
            $this->addError(
                $attribute,
                Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $this->getAttributeLabel($attribute)])
            );
        }
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'email' => Yii::t('common-models-activation-password', 'label-email'),
            'username' => Yii::t('common-models-activation-password', 'label-username'),
        ];
    }
}
