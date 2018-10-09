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
            $transaction->commit();
        } catch (Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        return true;
    }

    public function attributeLabels()
    {
        return [
            'code' => Yii::t('common-models-Activation', 'label-code'),
        ];
    }
}
