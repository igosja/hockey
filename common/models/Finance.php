<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Finance
 * @package common\models
 *
 * @property int $finance_id
 * @property int $finance_building_id
 * @property int $finance_capacity
 * @property string $finance_comment
 * @property int $finance_country_id
 * @property int $finance_date
 * @property int $finance_finance_text_id
 * @property int $finance_level
 * @property int $finance_national_id
 * @property int $finance_player_id
 * @property int $finance_season_id
 * @property int $finance_team_id
 * @property int $finance_user_id
 * @property int $finance_value
 * @property int $finance_value_after
 * @property int $finance_value_before
 *
 * @property FinanceText $financeText
 */
class Finance extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%finance}}';
    }

    /**
     * @param array $data
     */
    public static function log(array $data)
    {
        $finance = new self();
        $finance->setAttributes($data);
        $finance->save();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'finance_id',
                    'finance_building_id',
                    'finance_capacity',
                    'finance_country_id',
                    'finance_finance_text_id',
                    'finance_date',
                    'finance_level',
                    'finance_national_id',
                    'finance_player_id',
                    'finance_position_id',
                    'finance_season_id',
                    'finance_team_id',
                    'finance_team_2_id',
                    'finance_user_id',
                    'finance_user_2_id',
                    'finance_value',
                    'finance_value_after',
                    'finance_value_before'
                ],
                'integer'
            ],
            [['finance_finance_text_id'], 'required'],
            [['finance_comment'], 'safe'],
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
                $this->finance_season_id = Season::getCurrentSeason();
                $this->finance_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getFinanceText(): ActiveQuery
    {
        return $this->hasOne(FinanceText::class, ['finance_text_id' => 'finance_finance_text_id']);
    }
}
