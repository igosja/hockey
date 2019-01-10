<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Money
 * @package common\models
 *
 * @property int $money_id
 * @property int $money_date
 * @property int $money_money_text_id
 * @property int $money_user_id
 * @property int $money_value
 * @property int $money_value_after
 * @property int $money_value_before
 *
 * @property MoneyText $moneyText
 */
class Money extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%money}}';
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public static function log(array $data)
    {
        $money = new self();
        $money->setAttributes($data);
        $money->save();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['money_id', 'money_money_text_id', 'money_date', 'money_user_id'], 'integer'],
            [['money_value', 'money_value_after', 'money_value_before'], 'number'],
            [['money_money_text_id'], 'required'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->money_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getMoneyText()
    {
        return $this->hasOne(MoneyText::class, ['money_text_id' => 'money_money_text_id']);
    }
}
