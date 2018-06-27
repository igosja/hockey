<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Team
 * @package common\models
 *
 * @property integer $team_id
 * @property float $team_age
 * @property integer $team_attitude_national
 * @property integer $team_attitude_president
 * @property integer $team_attitude_u19
 * @property integer $team_attitude_u21
 * @property integer $team_auto
 * @property integer $team_base_id
 * @property integer $team_base_medical_id
 * @property integer $team_base_physical_id
 * @property integer $team_base_school_id
 * @property integer $team_base_scout_id
 * @property integer $team_base_training_id
 * @property integer $team_finance
 * @property integer $team_friendly_status_id
 * @property integer $team_free_base
 * @property integer $team_mood_rest
 * @property integer $team_mood_super
 * @property string $team_name
 * @property integer $team_player
 * @property integer $team_power_c_16
 * @property integer $team_power_c_21
 * @property integer $team_power_c_27
 * @property integer $team_power_s_16
 * @property integer $team_power_s_21
 * @property integer $team_power_s_27
 * @property integer $team_power_v
 * @property integer $team_power_vs
 * @property integer $team_price_base
 * @property integer $team_price_player
 * @property integer $team_price_stadium
 * @property integer $team_price_total
 * @property integer $team_salary
 * @property integer $team_stadium_id
 * @property integer $team_user_id
 * @property integer $team_vice_id
 * @property integer $team_visitor
 *
 * @property Stadium $stadium
 */
class Team extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%team}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['team_stadium_id'], 'in', 'range' => Stadium::find()->select(['stadium_id'])->column()],
            [
                [
                    'team_id',
                    'team_attitude_national',
                    'team_attitude_president',
                    'team_attitude_u19',
                    'team_attitude_u21',
                    'team_auto',
                    'team_base_id',
                    'team_base_medical_id',
                    'team_base_physical_id',
                    'team_base_school_id',
                    'team_base_scout_id',
                    'team_base_training_id',
                    'team_finance',
                    'team_friendly_status_id',
                    'team_free_base',
                    'team_mood_rest',
                    'team_mood_super',
                    'team_name',
                    'team_player',
                    'team_power_c_16',
                    'team_power_c_21',
                    'team_power_c_27',
                    'team_power_s_16',
                    'team_power_s_21',
                    'team_power_s_27',
                    'team_power_v',
                    'team_power_vs',
                    'team_price_base',
                    'team_price_player',
                    'team_price_stadium',
                    'team_price_total',
                    'team_salary',
                    'team_user_id',
                    'team_vice_id',
                    'team_visitor',
                ],
                'integer'
            ],
            [['team_age'], 'number'],
            [['team_name'], 'string', 'max' => 255],
            [['team_name'], 'trim'],
            [['team_stadium_id'], 'unique'],
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
                $this->team_attitude_national = 2;
                $this->team_attitude_president = 2;
                $this->team_attitude_u19 = 2;
                $this->team_attitude_u21 = 2;
                $this->team_base_id = 2;
                $this->team_base_medical_id = 1;
                $this->team_base_physical_id = 1;
                $this->team_base_school_id = 1;
                $this->team_base_scout_id = 1;
                $this->team_base_training_id = 1;
                $this->team_finance = 10000000;
                $this->team_friendly_status_id = 5;
                $this->team_free_base = 5;
                $this->team_mood_rest = 3;
                $this->team_mood_super = 3;
                $this->team_player = 27;
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
            $this->createPlayers();
            $this->createLeaguePlayers();
            $this->updatePower();
            History::log([
                'history_history_text_id' => HistoryText::TEAM_REGISTER,
                'history_team_id' => $this->team_id
            ]);
        }
    }

    private function createPlayers()
    {
        $position = [
            Position::GK,
            Position::GK,
            Position::LD,
            Position::LD,
            Position::LD,
            Position::LD,
            Position::LD,
            Position::RD,
            Position::RD,
            Position::RD,
            Position::RD,
            Position::RD,
            Position::LW,
            Position::LW,
            Position::LW,
            Position::LW,
            Position::LW,
            Position::CF,
            Position::CF,
            Position::CF,
            Position::CF,
            Position::CF,
            Position::RW,
            Position::RW,
            Position::RW,
            Position::RW,
            Position::RW,
        ];

        shuffle($position);

        for ($i = 0, $countPosition = count($position); $i < $countPosition; $i++) {
            $age = 17 + $i;

            if (39 < $age) {
                $age = $age - 17;
            }

            $player = new Player();
            $player->player_age = $age;
            $player->player_country_id = $this->stadium->city->country->country_id;
            $player->player_Position::id = $position[$i];
            $player->player_team_id = $this->team_id;
            $player->save();
        }
    }

    private function createLeaguePlayers()
    {
        $position = [
            Position::GK,
            Position::LD,
            Position::LD,
            Position::LD,
            Position::RD,
            Position::RD,
            Position::RD,
            Position::LW,
            Position::LW,
            Position::LW,
            Position::CF,
            Position::CF,
            Position::CF,
            Position::RW,
            Position::RW,
            Position::RW,
        ];

        shuffle($position);

        for ($i = 0, $countPosition = count($position); $i < $countPosition; $i++) {
            $age = 17 + $i;

            if (39 < $age) {
                $age = $age - 17;
            }

            $player = new Player();
            $player->player_age = $age;
            $player->player_country_id = $this->stadium->city->country->country_id;
            $player->player_position_id = $position[$i];
            $player->save();
        }
    }

    private function updatePower()
    {
        $power = Player::find()->where(['player_team_id' => $this->team_id])->andWhere([
            '!=',
            'player_position_id',
            Position::GK
        ])->orderBy(['player_power_nominal' => SORT_DESC])->limit(15)->sum('player_power_nominal');
        $power_c_16 = $power + Player::find()->where([
                'player_team_id' => $this->team_id,
                'player_position_id' => Position::GK
            ])->orderBy(['player_power_nominal' => SORT_DESC])->limit(1)->sum('player_power_nominal');
        $power = Player::find()->where(['player_team_id' => $this->team_id])->andWhere([
            '!=',
            'player_position_id',
            Position::GK
        ])->orderBy(['player_power_nominal' => SORT_DESC])->limit(20)->sum('player_power_nominal');
        $power_c_21 = $power + Player::find()->where([
                'player_team_id' => $this->team_id,
                'player_position_id' => Position::GK
            ])->orderBy(['player_power_nominal' => SORT_DESC])->limit(1)->sum('player_power_nominal');
        $power = Player::find()->where(['player_team_id' => $this->team_id])->andWhere([
            '!=',
            'player_position_id',
            Position::GK
        ])->orderBy(['player_power_nominal' => SORT_DESC])->limit(25)->sum('player_power_nominal');
        $power_c_27 = $power + Player::find()->where([
                'player_team_id' => $this->team_id,
                'player_position_id' => Position::GK
            ])->orderBy(['player_power_nominal' => SORT_DESC])->limit(2)->sum('player_power_nominal');
        $power = Player::find()->where(['player_team_id' => $this->team_id])->andWhere([
            '!=',
            'player_position_id',
            Position::GK
        ])->orderBy(['player_power_nominal_s' => SORT_DESC])->limit(15)->sum('player_power_nominal_s');
        $power_s_16 = $power + Player::find()->where([
                'player_team_id' => $this->team_id,
                'player_position_id' => Position::GK
            ])->orderBy(['player_power_nominal_s' => SORT_DESC])->limit(1)->sum('player_power_nominal_s');
        $power = Player::find()->where(['player_team_id' => $this->team_id])->andWhere([
            '!=',
            'player_position_id',
            Position::GK
        ])->orderBy(['player_power_nominal_s' => SORT_DESC])->limit(20)->sum('player_power_nominal_s');
        $power_s_21 = $power + Player::find()->where([
                'player_team_id' => $this->team_id,
                'player_position_id' => Position::GK
            ])->orderBy(['player_power_nominal_s' => SORT_DESC])->limit(1)->sum('player_power_nominal_s');
        $power = Player::find()->where(['player_team_id' => $this->team_id])->andWhere([
            '!=',
            'player_position_id',
            Position::GK
        ])->orderBy(['player_power_nominal_s' => SORT_DESC])->limit(25)->sum('player_power_nominal_s');
        $power_s_27 = $power + Player::find()->where([
                'player_team_id' => $this->team_id,
                'player_position_id' => Position::GK
            ])->orderBy(['player_power_nominal_s' => SORT_DESC])->limit(2)->sum('player_power_nominal_s');
        $power_v = round(($power_c_16 + $power_c_21 + $power_c_27) / 64 * 16);
        $power_vs = round(($power_s_16 + $power_s_21 + $power_s_27) / 64 * 16);

        $this->team_power_c_16 = $power_c_16;
        $this->team_power_c_21 = $power_c_21;
        $this->team_power_c_27 = $power_c_27;
        $this->team_power_s_16 = $power_s_16;
        $this->team_power_s_21 = $power_s_21;
        $this->team_power_s_27 = $power_s_27;
        $this->team_power_v = $power_v;
        $this->team_power_vs = $power_vs;
        $this->save();
    }

    /**
     * @return ActiveQuery
     */
    public function getStadium(): ActiveQuery
    {
        return $this->hasOne(Stadium::class, ['stadium_id' => 'team_stadium_id']);
    }
}
