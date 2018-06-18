<?php

namespace common\models;

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
            [['player_country_id', 'player_name_id', 'player_surname_id', 'player_team_id', 'player_power_nominal'], 'required'],
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
                $this->player_age = 17;
                $this->player_game_row = -1;
                $this->player_game_row_old = -1;
                $this->player_line_id = 1;
                $this->player_national_line_id = 1;
            }
            return true;
        }
        return false;
    }
}
