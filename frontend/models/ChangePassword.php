<?php

namespace frontend\models;

use common\models\User;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class ChangePassword
 * @package frontend\models
 *
 * @property $new string
 * @property $old string
 * @property $repeat string
 */
class ChangePassword extends Model
{
    public $new;
    public $old;
    public $repeat;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['old'], 'checkOldPassword'],
            [['repeat'], 'compare', 'compareAttribute' => 'new', 'message' => 'Введенные пароли не совпадают.'],
            [['new', 'old', 'repeat'], 'required'],
            [['new'], 'string', 'min' => 6],
        ];
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function change()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }
        if (!$this->validate()) {
            return false;
        }
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;
        $user->setPassword($this->new);
        if (!$user->save(true, ['user_password'])) {
            return false;
        }
        return true;
    }

    /**
     * @param string $attribute
     */
    public function checkOldPassword($attribute)
    {
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;
        if (!$user->validatePassword($this->old)) {
            $this->addError($attribute, 'Текущий пароль указан не верно');
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'new' => 'Новый пароль',
            'old' => 'Текущий пароль',
            'repeat' => 'Повторите пароль',
        ];
    }
}
