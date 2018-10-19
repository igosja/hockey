<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\User;
use Exception;
use yii\base\Model;

/**
 * Class PasswordRestore
 * @package frontend\models
 *
 * @property $code string
 * @property $password string
 */
class PasswordRestore extends Model
{
    public $code;
    public $password;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['code', 'password'], 'required'],
            [['password'], 'string', 'min' => 6],
            [
                ['code'],
                'exist',
                'targetClass' => User::class,
                'targetAttribute' => ['code' => 'user_code'],
                'skipOnEmpty' => false
            ],
        ];
    }

    /**
     * @return bool
     */
    public function restore(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        try {
            $model = User::find()
                ->andFilterWhere(['user_code' => $this->code])
                ->limit(1)
                ->one();

            if (!$model) {
                throw new Exception('No user with code ' . $this->code);
            }

            $model->setPassword($this->password);

            if (!$model->save()) {
                throw new Exception(ErrorHelper::modelErrorsToString($model));
            }
        } catch (Exception $e) {
            ErrorHelper::log($e);
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
            'password' => 'Пароль',
        ];
    }
}
