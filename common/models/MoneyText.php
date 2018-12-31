<?php

namespace common\models;

/**
 * Class MoneyText
 * @package common\models
 *
 * @property int $money_text_id
 * @property string $money_text_text
 */
class MoneyText extends AbstractActiveRecord
{
    const INCOME_ADD_FUNDS = 1;
    const INCOME_REFERRAL = 2;
    const OUTCOME_POINT = 3;
    const OUTCOME_POSITION = 5;
    const OUTCOME_SPECIAL = 6;
    const OUTCOME_TEAM_FINANCE = 4;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%money_text}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['money_text_id'], 'integer'],
            [['money_text_text'], 'required'],
            [['money_text_text'], 'string', 'max' => 255],
            [['money_text_text'], 'trim'],
        ];
    }
}
