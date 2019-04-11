<?php

namespace common\models;

use Exception;
use frontend\controllers\AbstractController;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class Player
 * @package common\models
 *
 * @property int $player_id
 * @property int $player_age
 * @property int $player_country_id
 * @property int $player_date_no_action
 * @property int $player_date_rookie
 * @property int $player_game_row
 * @property int $player_game_row_old
 * @property int $player_injury
 * @property int $player_injury_day
 * @property int $player_squad_id
 * @property int $player_loan_day
 * @property int $player_loan_team_id
 * @property int $player_mood_id
 * @property int $player_name_id
 * @property int $player_national_id
 * @property int $player_national_squad_id
 * @property int $player_no_deal
 * @property int $player_order
 * @property int $player_physical_id
 * @property int $player_position_id
 * @property int $player_power_nominal
 * @property int $player_power_nominal_s
 * @property int $player_power_old
 * @property int $player_power_real
 * @property int $player_price
 * @property int $player_rookie
 * @property int $player_salary
 * @property int $player_school_id
 * @property int $player_style_id
 * @property int $player_surname_id
 * @property int $player_team_id
 * @property int $player_tire
 * @property int $player_training_ability
 *
 * @property Country $country
 * @property Loan $loan
 * @property Team $loanTeam
 * @property Name $name
 * @property Physical $physical
 * @property PlayerPosition[] $playerPosition
 * @property PlayerSpecial[] $playerSpecial
 * @property Team $schoolTeam
 * @property Squad $squad
 * @property Squad $squadNational
 * @property StatisticPlayer[] $statisticPlayer
 * @property Style $style
 * @property Surname $surname
 * @property Team $team
 * @property Transfer $transfer
 */
class Player extends AbstractActiveRecord
{
    const AGE_READY_FOR_PENSION = 39;
    const TIRE_DEFAULT = 50;
    const TIRE_MAX = 90;
    const TIRE_MAX_FOR_LINEUP = 60;

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
                    'player_loan_day',
                    'player_loan_team_id',
                    'player_mood_id',
                    'player_name_id',
                    'player_national_id',
                    'player_national_squad_id',
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
            [['player_country_id'], 'required'],
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
                $physical = Physical::getRandPhysical();

                if (!$this->player_age) {
                    $this->player_age = 17;
                }
                if (!$this->player_name_id) {
                    $this->player_name_id = NameCountry::getRandNameId($this->player_country_id);
                }
                if (!$this->player_power_nominal) {
                    $this->player_power_nominal = $this->player_age * 2;
                }
                if (!$this->player_style_id) {
                    $this->player_style_id = Style::getRandStyleId();;
                }
                if (!$this->player_tire) {
                    $this->player_tire = 50;
                }
                if ($this->player_team_id) {
                    $this->player_school_id = $this->player_team_id;
                }

                $this->player_game_row = -1;
                $this->player_game_row_old = -1;
                $this->player_squad_id = 1;
                $this->player_national_squad_id = 1;
                $this->player_physical_id = $physical->physical_id;
                $this->player_power_nominal_s = $this->player_power_nominal;
                $this->player_power_old = $this->player_power_nominal;
                $this->player_surname_id = SurnameCountry::getRandSurnameId($this->player_country_id);
                $this->player_training_ability = rand(1, 5);
                $this->countRealPower($physical);
                $this->countPriceAndSalary();
            }
            return true;
        }
        return false;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws Exception
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
        $this->player_power_real = $this->player_power_nominal * $this->player_tire / 100 * $physical->physical_value / 100;
    }

    /**
     * @return string
     */
    public function iconInjury()
    {
        $result = '';
        if ($this->player_injury) {
            $result = ' <i class="fa fa-ambulance" title="Травмирован на ' . $this->player_injury_day . ' дн."></i>';
        }
        return $result;
    }

    /**
     * @return string
     */
    public function iconDeal()
    {
        $result = '';
        if ($this->loan || $this->transfer) {
            $result = ' <i class="fa fa-usd" title="Выставлен на трансфер/аренду"></i>';
        }
        return $result;
    }

    /**
     * @return string
     */
    public function iconNational()
    {
        $result = '';
        if ($this->player_national_id) {
            $result = ' <i class="fa fa-flag" title="Игрок национальной сборной"></i>';
        }
        return $result;
    }

    /**
     * @return string
     */
    public function iconPension()
    {
        $result = '';
        if (self::AGE_READY_FOR_PENSION == $this->player_age) {
            $result = ' <i class="fa fa-bed" title="Заканчивает карьеру в конце текущего сезона"></i>';
        }
        return $result;
    }

    /**
     * @param boolean $showOnlyIfStudied
     * @return string
     */
    public function iconStyle($showOnlyIfStudied = false)
    {
        /**
         * @var AbstractController $controller
         */
        $controller = Yii::$app->controller;
        $myTeam = $controller->myTeam;

        if (!$myTeam) {
            if (!$showOnlyIfStudied) {
                $styleArray = Style::find()
                    ->select(['style_id', 'style_name'])
                    ->where(['!=', 'style_id', Style::NORMAL])
                    ->orderBy(['style_id' => SORT_ASC])
                    ->all();
            } else {
                $styleArray = [];
            }
        } else {
            $countScout = Scout::find()
                ->where(['scout_player_id' => $this->player_id, 'scout_team_id' => $myTeam->team_id])
                ->andWhere(['!=', 'scout_ready', 0])
                ->count();

            if (2 == $countScout) {
                $styleArray = Style::find()
                    ->select(['style_id', 'style_name'])
                    ->where(['style_id' => $this->player_style_id])
                    ->orderBy(['style_id' => SORT_ASC])
                    ->all();
            } elseif (!$showOnlyIfStudied) {
                $in = [$this->player_style_id];
                for ($i = 1; $i < 3 - $countScout; $i++) {
                    $styleToIn = Style::getRandStyleId($in);
                    $in[] = $styleToIn;
                }
                $styleArray = Style::find()
                    ->select(['style_id', 'style_name'])
                    ->where(['style_id' => $in])
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
     * @return int
     */
    public function countScout()
    {
        /**
         * @var AbstractController $controller
         */
        $controller = Yii::$app->controller;
        $myTeam = $controller->myTeam;

        if ($myTeam) {
            return Scout::find()
                ->where(['scout_player_id' => $this->player_id, 'scout_team_id' => $myTeam->team_id])
                ->andWhere(['!=', 'scout_ready', 0])
                ->count();
        } else {
            return 0;
        }
    }

    /**
     * @return string
     */
    public function iconTraining()
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
            $result = ' <i class="fa fa-caret-square-o-up" title="На тренировке"></i>';
        }
        return $result;
    }

    /**
     * @return string
     */
    public function iconLoan()
    {
        $result = '';
        if ($this->player_loan_day) {
            $result = ' <span title="В аренде">(' . $this->player_loan_day . ')</i>';
        }
        return $result;
    }

    /**
     * @return string
     */
    public function powerNominal()
    {
        $class = '';
        if ($this->player_power_nominal > $this->player_power_old) {
            $class = 'font-green';
        } elseif ($this->player_power_nominal < $this->player_power_old) {
            $class = 'font-red';
        }
        return '<span class="' . $class . '">' . $this->player_power_nominal . '</span>';
    }

    /**
     * @return string
     */
    public function playerName()
    {
        return $this->name->name_name . ' ' . $this->surname->surname_name;
    }

    /**
     * @return string
     */
    public function position()
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
    public function special()
    {
        $result = [];
        foreach ($this->playerSpecial as $special) {
            $result[] = $special->special->special_name . $special->player_special_level;
        }
        return implode(' ', $result);
    }

    /**
     * @param array $options
     * @return string
     */
    public function playerLink(array $options = [])
    {
        return Html::a(
            $this->name->name_name . ' ' . $this->surname->surname_name,
            ['player/view', 'id' => $this->player_id],
            $options
        );
    }

    /**
     * @return string
     */
    public function playerTire()
    {
        /**
         * @var AbstractController $controller
         */
        $controller = Yii::$app->controller;
        $realTire = $this->player_tire . '%';

        if (!$controller->myTeam) {
            return '?';
        }

        if ($this->myPlayer()) {
            return $realTire;
        }

        if ($this->myNationalPlayer()) {
            return $realTire;
        }

        if ($controller->myTeam->baseScout->canSeeOpponentTire()) {
            return $realTire;
        }

        if (!$this->loan && !$this->transfer) {
            return '?';
        }

        if ($controller->myTeam->baseScout->canSeeDealTire()) {
            return $realTire;
        }

        return '?';
    }

    /**
     * @return string
     */
    public function playerGameRow()
    {
        /**
         * @var AbstractController $controller
         */
        $controller = Yii::$app->controller;
        $realGameRow = $this->player_game_row;

        if (!$controller->myTeam) {
            return '?';
        }

        if ($this->myPlayer()) {
            return $realGameRow;
        }

        if ($this->myNationalPlayer()) {
            return $realGameRow;
        }

        if ($controller->myTeam->baseScout->canSeeOpponentGameRow()) {
            return $realGameRow;
        }

        if (!$this->loan && !$this->transfer) {
            return '?';
        }

        if ($controller->myTeam->baseScout->canSeeDealGameRow()) {
            return $realGameRow;
        }

        return '?';
    }

    /**
     * @return string
     */
    public function playerPhysical()
    {
        /**
         * @var AbstractController $controller
         */
        $controller = Yii::$app->controller;
        $realPhysical = $this->physical->image();

        if (!$controller->myTeam) {
            return '?';
        }

        if ($this->myPlayer()) {
            return $realPhysical;
        }

        if ($this->myNationalPlayer()) {
            return $realPhysical;
        }

        if ($controller->myTeam->baseScout->canSeeOpponentPhysical()) {
            return $realPhysical;
        }

        if (!$this->loan && !$this->transfer) {
            return '?';
        }

        if ($controller->myTeam->baseScout->canSeeDealPhysical()) {
            return $realPhysical;
        }

        return '?';
    }

    /**
     * @return bool
     */
    public function myPlayer()
    {
        /**
         * @var AbstractController $controller
         */
        $controller = Yii::$app->controller;
        if (!$controller->myTeam) {
            return false;
        }
        if ($controller->myTeamOrVice->team_id != $this->player_team_id) {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function myNationalPlayer()
    {
        /**
         * @var AbstractController $controller
         */
        $controller = Yii::$app->controller;
        if (!$controller->myNational) {
            return false;
        }
        if ($controller->myNational->national_id != $this->player_national_id) {
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function trainingPositionDropDownList()
    {
        if (2 == count($this->playerPosition)) {
            return '';
        }

        if (Position::GK == $this->playerPosition[0]->player_position_position_id) {
            return '';
        }

        $positionArray = Position::find()
            ->where(['!=', 'position_id', Position::GK])
            ->andWhere([
                'not',
                [
                    'position_id' => PlayerPosition::find()
                        ->select(['player_position_position_id'])
                        ->where(['player_position_player_id' => $this->player_id])
                ]
            ])
            ->orderBy(['position_id' => SORT_ASC])
            ->all();

        return Html::dropDownList(
            'position[' . $this->player_id . ']',
            null,
            ArrayHelper::map($positionArray, 'position_id', 'position_name'),
            ['class' => 'form-control form-small', 'prompt' => '-']
        );
    }

    /**
     * @return string
     */
    public function trainingSpecialDropDownList()
    {
        $playerSpecial = PlayerSpecial::find()
            ->where(['player_special_level' => Special::MAX_LEVEL, 'player_special_player_id' => $this->player_id])
            ->count();
        if (Special::MAX_SPECIALS == $playerSpecial) {
            return '';
        }

        if (Position::GK == $this->player_position_id) {
            $gk = 1;
            $field = null;
        } else {
            $gk = null;
            $field = 1;
        }

        $specialArray = Special::find()
            ->filterWhere(['special_gk' => $gk, 'special_field' => $field])
            ->andWhere([
                'not',
                [
                    'special_id' => PlayerSpecial::find()
                        ->select(['player_special_special_id'])
                        ->where([
                            'player_special_level' => Special::MAX_LEVEL,
                            'player_special_player_id' => $this->player_id,
                        ])
                ]
            ])
            ->orderBy(['special_id' => SORT_ASC])
            ->all();

        return Html::dropDownList(
            'special[' . $this->player_id . ']',
            null,
            ArrayHelper::map($specialArray, 'special_id', 'special_name'),
            ['class' => 'form-control form-small', 'prompt' => '-']
        );
    }

    /**
     * @throws Exception
     */
    public function makeFree()
    {
        History::log([
            'history_history_text_id' => HistoryText::PLAYER_FREE,
            'history_player_id' => $this->player_id,
            'history_team_id' => $this->player_team_id,
        ]);

        $this->player_loan_day = 0;
        $this->player_loan_team_id = 0;
        $this->player_national_squad_id = Squad::SQUAD_DEFAULT;
        $this->player_order = 0;
        $this->player_squad_id = Squad::SQUAD_DEFAULT;
        $this->player_team_id = 0;
        $this->save(true, [
            'player_loan_day',
            'player_loan_team_id',
            'player_national_squad_id',
            'player_order',
            'player_squad_id',
            'player_team_id',
        ]);
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['country_id' => 'player_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLoan()
    {
        return $this->hasOne(Loan::class, ['loan_player_id' => 'player_id'])->andWhere(['loan_ready' => 0]);
    }

    /**
     * @return ActiveQuery
     */
    public function getLoanTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'player_loan_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getName()
    {
        return $this->hasOne(Name::class, ['name_id' => 'player_name_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPhysical()
    {
        return $this->hasOne(Physical::class, ['physical_id' => 'player_physical_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerPosition()
    {
        return $this->hasMany(PlayerPosition::class, ['player_position_player_id' => 'player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerSpecial()
    {
        return $this->hasMany(PlayerSpecial::class, ['player_special_player_id' => 'player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSchoolTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'player_school_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSquad()
    {
        return $this->hasOne(Squad::class, ['squad_id' => 'player_squad_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSquadNational()
    {
        return $this->hasOne(Squad::class, ['squad_id' => 'player_national_squad_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStatisticPlayer()
    {
        return $this
            ->hasMany(StatisticPlayer::class, ['statistic_player_player_id' => 'player_id'])
            ->andWhere(['statistic_player_season_id' => Season::getCurrentSeason()]);
    }

    /**
     * @return ActiveQuery
     */
    public function getStyle()
    {
        return $this->hasOne(Style::class, ['style_id' => 'player_style_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSurname()
    {
        return $this->hasOne(Surname::class, ['surname_id' => 'player_surname_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'player_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTransfer()
    {
        return $this->hasOne(Transfer::class, ['transfer_player_id' => 'player_id'])->andWhere(['transfer_ready' => 0]);
    }
}
