<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * @package common\models
 *
 * @property string $password
 * @property string $username
 * @property User $_user
 */
class LoginForm extends Model
{
    public $password;
    public $username;

    private $_user;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['password', 'username'], 'required'],
            [['password'], 'validatePassword'],
        ];
    }

    /**
     * @param string $attribute
     */
    public function validatePassword(string $attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильная комбинация логин/пароль');
            }
        }
    }

    /**
     * @return bool
     */
    public function login(): bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 2592000);
        }

        return false;
    }

    /**
     * @return User|null|static
     */
    protected function getUser()
    {
        if (null === $this->_user) {
            $this->_user = User::findOne(['user_login' => $this->username]);
        }

        return $this->_user;
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'password' => 'Пароль',
            'username' => 'Логин',
        ];
    }
}
