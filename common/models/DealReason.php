<?php

namespace common\models;

/**
 * Class DealReason
 * @package common\models
 *
 * @property int $deal_reason_id
 * @property string $deal_reason_text
 */
class DealReason extends AbstractActiveRecord
{
    const MANAGER_LIMIT = 1;
    const TEAM_LIMIT = 2;
    const NO_MONEY = 3;
    const NOT_BEST = 4;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%deal_reason}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['deal_reason_id'], 'integer'],
            [['deal_reason_text'], 'required'],
            [['deal_reason_text'], 'string', 'max' => 255],
            [['deal_reason_text'], 'trim'],
        ];
    }
}
