<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * Class Player
 * @package common\models
 *
 * @property integer $player_id
 * @property integer $player_age
 * @property integer $player_country_id
 * @property integer $player_date_no_action
 * @property integer $player_date_rookie
 * @property integer $player_game_row
 * @property integer $player_game_row_old
 * @property integer $player_injury_day
 * @property integer $player_squad_id
 * @property integer $player_loan_day
 * @property integer $player_loan_team_id
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
 * @property integer $player_rookie
 * @property integer $player_salary
 * @property integer $player_school_id
 * @property integer $player_style_id
 * @property integer $player_surname_id
 * @property integer $player_team_id
 * @property integer $player_tire
 * @property integer $player_training_ability
 *
 * @property Country $country
 * @property Loan $loan
 * @property Team $loanTeam
 * @property Name $name
 * @property Physical $physical
 * @property PlayerPosition[] $playerPosition
 * @property PlayerSpecial[] $playerSpecial
 * @property StatisticPlayer $statisticPlayer
 * @property Style $style
 * @property Surname $surname
 * @property Team $team
 * @property Transfer $transfer
 */
class Player extends ActiveRecord
{
    const AGE_READY_FOR_PENSION = 39;
    const MAX_TIRE = 60;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%player}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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
                    'player_injury_day',
                    'player_loan_day',
                    'player_loan_team_id',
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
                    'player_rookie',
                    'player_salary',
                    'player_school_id',
                    'player_squad_id',
                    'player_style_id',
                    'player_surname_id',
                    'player_team_id',
                    'player_tire',
                    'player_training_ability',
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
                $physical = Physical::getRandPhysical();

                if (!$this->player_age) {
                    $this->player_age = 17;
                }
                $this->player_game_row = -1;
                $this->player_game_row_old = -1;
                $this->player_squad_id = 1;
                $this->player_name_id = NameCountry::getRandNameId($this->player_country_id);
                $this->player_national_line_id = 1;
                $this->player_physical_id = $physical->physical_id;
                $this->player_power_nominal = $this->player_age * 2;
                $this->player_power_nominal_s = $this->player_power_nominal;
                $this->player_style_id = Style::getRandStyleId();
                $this->player_surname_id = SurnameCountry::getRandSurnameId($this->player_country_id);
                $this->player_tire = 50;
                $this->player_training_ability = rand(1, 5);
                $this->countPriceAndSalary();
                $this->countRealPower($physical);
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
     * @return void
     */
    public function countPriceAndSalary()
    {
        $this->player_price = pow(150 - (28 - $this->player_age), 2) * $this->player_power_nominal;
        $this->player_salary = $this->player_price / 999;
    }

    /**
     * @param Physical $physical
     */
    public function countRealPower(Physical $physical = null)
    {
        if (!$physical) {
            $physical = $this->physical;
        }
        $this->player_power_real = $this->player_power_nominal * 50 / 100 * $physical->physical_value / 100;
    }

    /**
     * @return string
     */
    public function iconInjury(): string
    {
        $result = '';
        if ($this->player_injury_day) {
            $result = ' <i class="fa fa-ambulance" title="Injured for ' . $this->player_injury_day . ' days"></i>';
        }
        return $result;
    }

    /**
     * @return string
     */
    public function iconDeal(): string
    {
        $result = '';
        if ($this->loan || $this->transfer) {
            $result = ' <i class="fa fa-usd" title="For sale/loan"></i>';
        }
        return $result;
    }

    /**
     * @return string
     */
    public function iconNational(): string
    {
        $result = '';
        if ($this->player_national_id) {
            $result = ' <i class="fa fa-flag" title="National team player"></i>';
        }
        return $result;
    }

    /**
     * @return string
     */
    public function iconPension(): string
    {
        $result = '';
        if (self::AGE_READY_FOR_PENSION == $this->player_age) {
            $result = ' <i class="fa fa-bed" title="Completes his career at the end of the season"></i>';
        }
        return $result;
    }

    /**
     * @param boolean $showOnlyIfStudied
     * @return string
     */
    public function iconStyle($showOnlyIfStudied = false): string
    {
        /**
         * @var Team $myTeam
         */
        $myTeam = Yii::$app->controller->myTeam;

        if (!$myTeam) {
            $styleArray = Style::find()
                ->select(['style_id', 'style_name'])
                ->where(['!=', 'style_id', Style::NORMAL])
                ->orderBy(['style_id' => SORT_ASC])
                ->all();
        } else {
            $countScout = Scout::find()
                ->where(['scout_player_id' => $this->player_id, 'scout_team_id' => $myTeam->team_id])
                ->andWhere(['!=', 'scout_ready', 100])
                ->count();

            if (2 == $countScout || !$showOnlyIfStudied) {
                $styleArray = Style::find()
                    ->select(['style_id', 'style_name'])
                    ->where(['not', ['style_id' => [Style::NORMAL, $this->player_style_id]]])
                    ->orWhere(['style_id' => $this->player_style_id])
                    ->orderBy(['style_id' => SORT_ASC])
                    ->limit(3 - $countScout)
                    ->all();
            } else {
                $styleArray = [];
            }
        }

        $result = [];
        foreach ($styleArray as $item) {
            $result[] = Html::img(
                '/img/style/' . $item->style_id . '.png',
                [
                    'alt' => $item->style_name,
                    'title' => ucfirst($item->style_name),
                ]
            );
        }

        return implode(' ', $result);
    }

    /**
     * @return string
     */
    public function iconTraining(): string
    {
        $countTraining = Training::find()
            ->where([
                'training_player_id' => $this->player_id,
                'training_team_id' => $this->player_team_id,
                'training_ready' => 0
            ])
            ->count();

        $result = '';
        if ($countTraining) {
            $result = ' <i class="fa fa-caret-square-o-up " title="On training"></i>';
        }
        return $result;
    }

    /**
     * @return string
     */
    public function playerName(): string
    {
        return $this->name->name_name . ' ' . $this->surname->surname_name;
    }

    /**
     * @return string
     */
    public function position(): string
    {
        $result = [];
        foreach ($this->playerPosition as $position) {
            $result[] = $position->position->position_name;
        }
        return implode('/', $result);
    }

    /**
     * @return string
     */
    public function special(): string
    {
        $result = [];
        foreach ($this->playerSpecial as $special) {
            $result[] = $special->special->special_name . $special->player_special_level;
        }
        return implode('', $result);
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'player_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLoan(): ActiveQuery
    {
        return $this->hasOne(Loan::class, ['loan_player_id' => 'player_id'])->andWhere(['loan_ready' => 0]);
    }

    /**
     * @return ActiveQuery
     */
    public function getLoanTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'player_loan_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getName(): ActiveQuery
    {
        return $this->hasOne(Name::class, ['name_id' => 'player_name_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPhysical(): ActiveQuery
    {
        return $this->hasOne(Physical::class, ['physical_id' => 'player_physical_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerPosition(): ActiveQuery
    {
        return $this->hasMany(PlayerPosition::class, ['player_position_player_id' => 'player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerSpecial(): ActiveQuery
    {
        return $this->hasMany(PlayerSpecial::class, ['player_special_player_id' => 'player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStatisticPlayer(): ActiveQuery
    {
        return $this->hasOne(StatisticPlayer::class, ['statistic_player_player_id' => 'player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStyle(): ActiveQuery
    {
        return $this->hasOne(Style::class, ['style_id' => 'player_style_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSurname(): ActiveQuery
    {
        return $this->hasOne(Surname::class, ['surname_id' => 'player_surname_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'player_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTransfer(): ActiveQuery
    {
        return $this->hasOne(Transfer::class, ['transfer_player_id' => 'player_id'])->andWhere(['transfer_ready' => 0]);
    }
}