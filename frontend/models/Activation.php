<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\User;
use Exception;
use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * Class Activation
 * @package frontend\models
 *
 * @property $code string
 */
class Activation extends Model
{
    public $code;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
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
    public function activate(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            User::updateAll(['user_date_confirm' => new Expression('UNIX_TIMESTAMP()')]);
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
     * @return bool
     */
    public function checkCode($attribute): bool
    {
        $user = User::find()
            ->select(['user_date_confirm'])
            ->where(['user_code' => $this->$attribute])
            ->limit(1)
            ->one();

        if (!$user) {
            $this->addError($attribute, Yii::t('common-models-Activation', 'error-no-user'));
            return false;
        }

        if ($user->user_date_confirm) {
            $this->addError($attribute, Yii::t('common-models-Activation', 'error-already-active'));
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
            'code' => Yii::t('common-models-Activation', 'label-code'),
        ];
    }
}
