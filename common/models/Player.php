<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Player
 * @package common\models
 *
 * @property integer $player_id
 * @property integer $player_age
 * @property integer $player_country_id
 * @property integer $player_date_noaction
 * @property integer $player_date_rookie
 * @property integer $player_game_row
 * @property integer $player_game_row_old
 * @property integer $player_injury
 * @property integer $player_injury_day
 * @property integer $player_line_id
 * @property integer $player_mood_id
 * @property integer $player_name_id
 * @property integer $player_national_id
 * @property integer $player_national_line_id
 * @property integer $player_no_action
 * @property integer $player_no_deal
 * @property integer $player_order
 * @property integer $player_physical_id
 * @property integer $player_position_id
 * @property integer $player_power_nominal
 * @property integer $player_power_nominal_s
 * @property integer $player_power_old
 * @property integer $player_power_real
 * @property integer $player_price
 * @property integer $player_rent_day
 * @property integer $player_rent_on
 * @property integer $player_rent_team_id
 * @property integer $player_rookie
 * @property integer $player_salary
 * @property integer $player_school_id
 * @property integer $player_style_id
 * @property integer $player_surname_id
 * @property integer $player_team_id
 * @property integer $player_tire
 * @property integer $player_training_ability
 * @property integer $player_transfer_on
 *
 * @property Physical $physical
 */
class Player extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%player}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'player_id',
                    'player_age',
                    'player_country_id',
                    'player_date_no_action',
                    'player_date_rookie',
                    'player_game_row',
                    'player_game_row_old',
                    'player_injury',
                    'player_injury_day',
                    'player_line_id',
                    'player_mood_id',
                    'player_name_id',
                    'player_national_id',
                    'player_national_line_id',
                    'player_no_action',
                    'player_no_deal',
                    'player_order',
                    'player_physical_id',
                    'player_position_id',
                    'player_power_nominal',
                    'player_power_nominal_s',
                    'player_power_old',
                    'player_power_real',
                    'player_price',
                    'player_rent_day',
                    'player_rent_on',
                    'player_rent_team_id',
                    'player_rookie',
                    'player_salary',
                    'player_school_id',
                    'player_style_id',
                    'player_surname_id',
                    'player_team_id',
                    'player_tire',
                    'player_training_ability',
                    'player_transfer_on',
                ],
                'integer'
            ],
            [['player_country_id', 'player_team_id'], 'required'],
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
                if (!$this->player_age) {
                    $this->player_age = 17;
                }
                $this->player_game_row = -1;
                $this->player_game_row_old = -1;
                $this->player_line_id = 1;
                $this->player_name_id = NameCountry::find()->select(['name_country_name_id'])->where(['name_country_country_id' => $this->player_country_id])->orderBy('RAND()')->limit(1)->column();
                $this->player_national_line_id = 1;
                $this->player_physical_id = Physical::find()->select(['physical_id'])->orderBy('RAND()')->limit(1)->column();
                $this->player_power_nominal = $this->player_age * 2;
                $this->player_power_nominal_s = $this->player_power_nominal;
                $this->player_power_real = $this->player_power_nominal * 50 / 100 * $this->physical->physical_value / 100;
                $this->player_price = pow(150 - (28 - $this->player_age), 2) * $this->player_power_nominal;
                $this->player_salary = $this->player_price / 999;
                $this->player_style_id = Style::find()->select(['style_id'])->where([
                    '!=',
                    'style_id',
                    Style::NORMAL
                ])->orderBy('RAND()')->limit(1)->column();
                $this->player_surname_id = SurnameCountry::find()->select(['surname_country_surname_id'])->where(['surname_country_country_id' => $this->player_country_id])->orderBy('RAND()')->limit(1)->column();
                $this->player_tire = 50;
                $this->player_training_ability = rand(1, 5);
            }
            return true;
        }
        return false;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $playerPosition = new PlayerPosition();
            $playerPosition->player_position_player_id = $this->player_id;
            $playerPosition->player_position_position_id = $this->player_position_id;
            $playerPosition->save();

            History::log([
                'history_history_text_id' => HistoryText::PLAYER_FROM_SCHOOL,
                'history_player_id' => $this->player_id,
                'history_team_id' => $this->player_team_id
            ]);
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getPhysical(): ActiveQuery
    {
        return $this->hasOne(Physical::class, ['physical_id' => 'player_physical_id']);
    }
}
