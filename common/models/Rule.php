<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Rule
 * @package common\models
 *
 * @property int $rule_id
 * @property int $rule_date
 * @property int $rule_order
 * @property string $rule_text
 * @property string $rule_title
 */
class Rule extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%rule}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['rule_id', 'rule_date', 'rule_order'], 'integer'],
            [['rule_title', 'rule_title'], 'required'],
            [['rule_title'], 'string', 'max' => 255],
            [['rule_title', 'rule_title'], 'trim'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $order = self::find()->max('rule_order');
                if (!$order) {
                    $order = 0;
                }
                $order++;
                $this->rule_order = $order;
            }
            $this->rule_date = time();
            return true;
        }
        return false;
    }
}
