<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Finance
 * @package common\models
 *
 * @property integer $finance_id
 * @property integer $finance_building_id
 * @property integer $finance_capacity
 * @property string $finance_comment
 * @property integer $finance_country_id
 * @property integer $finance_date
 * @property integer $finance_finance_text_id
 * @property integer $finance_level
 * @property integer $finance_national_id
 * @property integer $finance_player_id
 * @property integer $finance_season_id
 * @property integer $finance_team_id
 * @property integer $finance_user_id
 * @property integer $finance_value
 * @property integer $finance_value_after
 * @property integer $finance_value_before
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
            [['finance_building_id'], 'in', 'range' => Building::find()->select('building_id')->column()],
            [['finance_country_id'], 'in', 'range' => Country::find()->select('country_id')->column()],
            [['finance_finance_text_id'], 'in', 'range' => HistoryText::find()->select('finance_text_id')->column()],
            [['finance_national_id'], 'in', 'range' => National::find()->select('national_id')->column()],
            [['finance_player_id'], 'in', 'range' => Player::find()->select('player_id')->column()],
            [['finance_position_id'], 'in', 'range' => Position::find()->select('position_id')->column()],
            [['finance_season_id'], 'in', 'range' => Season::find()->select('season_id')->column()],
            [['finance_team_id', 'finance_team_2_id'], 'in', 'range' => Team::find()->select('team_id')->column()],
            [['finance_user_id', 'finance_user_2_id'], 'in', 'range' => User::find()->select('user_id')->column()],
            [
                [
                    'finance_id',
                    'finance_capacity',
                    'finance_date',
                    'finance_level',
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
