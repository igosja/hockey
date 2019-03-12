<?php

namespace common\models;

use Exception;
use frontend\controllers\AbstractController;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Html;

/**
 * Class National
 * @package common\models
 *
 * @property int $national_id
 * @property int $national_country_id
 * @property int $national_finance
 * @property int $national_mood_rest
 * @property int $national_mood_super
 * @property int $national_national_type_id
 * @property int $national_power_c_21
 * @property int $national_power_c_26
 * @property int $national_power_c_32
 * @property int $national_power_s_21
 * @property int $national_power_s_26
 * @property int $national_power_s_32
 * @property int $national_power_v
 * @property int $national_power_vs
 * @property int $national_stadium_id
 * @property int $national_user_id
 * @property int $national_vice_id
 * @property int $national_visitor
 *
 * @property Country $country
 * @property NationalType $nationalType
 * @property Stadium $stadium
 * @property User $user
 * @property User $vice
 * @property WorldCup $worldCup
 */
class National extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%national}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'national_id',
                    'national_country_id',
                    'national_finance',
                    'national_mood_rest',
                    'national_mood_super',
                    'national_national_type_id',
                    'national_power_c_21',
                    'national_power_c_26',
                    'national_power_c_32',
                    'national_power_s_21',
                    'national_power_s_26',
                    'national_power_s_32',
                    'national_power_v',
                    'national_power_vs',
                    'national_stadium_id',
                    'national_user_id',
                    'national_vice_id',
                    'national_visitor',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return string
     */
    public function fullName()
    {
        return $this->country->country_name
            . ' (' . $this->nationalType->national_type_name
            . ')';
    }

    /**
     * @return string
     */
    public function division()
    {
        $result = '-';
        if ($this->worldCup) {
            $result = Html::a(
                $this->worldCup->division->division_name . ', ' .
                $this->worldCup->world_cup_place . ' ' .
                'место',
                [
                    'world-championship/index',
                    'divisionId' => $this->worldCup->division->division_id,
                ]
            );
        }
        return $result;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function fireUser()
    {
        if (!$this->national_user_id) {
            return true;
        }

        History::log([
            'history_history_text_id' => HistoryText::USER_MANAGER_NATIONAL_OUT,
            'history_national_id' => $this->national_id,
            'history_user_id' => $this->national_user_id,
        ]);

        if ($this->national_vice_id) {
            History::log([
                'history_history_text_id' => HistoryText::USER_VICE_NATIONAL_OUT,
                'history_national_id' => $this->national_id,
                'history_user_id' => $this->national_vice_id,
            ]);

            History::log([
                'history_history_text_id' => HistoryText::USER_MANAGER_NATIONAL_IN,
                'history_national_id' => $this->national_id,
                'history_user_id' => $this->national_vice_id,
            ]);
        }

        $this->national_user_id = $this->national_vice_id;
        $this->national_vice_id = 0;
        $this->save(true, ['national_user_id', 'national_vice_id']);

        return true;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function fireVice()
    {
        if (!$this->national_vice_id) {
            return true;
        }

        History::log([
            'history_history_text_id' => HistoryText::USER_VICE_NATIONAL_OUT,
            'history_national_id' => $this->national_id,
            'history_user_id' => $this->national_vice_id,
        ]);

        $this->national_vice_id = 0;
        $this->save(true, ['national_vice_id']);

        return true;
    }

    /**
     * @param bool $image
     * @return string
     */
    public function nationalLink($image = false)
    {
        $result = '';
        if ($image) {
            $result = $result . Html::img(
                    '/img/country/12/' . $this->country->country_id . '.png',
                    [
                        'alt' => $this->country->country_name,
                        'title' => $this->country->country_name,
                    ]
                ) . ' ';
        }
        $result = $result . Html::a(
                $this->country->country_name,
                ['national/view', 'id' => $this->national_id]
            );
        return $result;
    }

    /**
     * @return bool
     */
    public function myTeam()
    {
        /**
         * @var AbstractController $controller
         */
        $controller = Yii::$app->controller;

        if (!$controller->myNational) {
            return false;
        }

        if ($this->national_id != $controller->myNational->national_id) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function myTeamOrVice()
    {
        /**
         * @var AbstractController $controller
         */
        $controller = Yii::$app->controller;

        if (!$controller->myNational && !$controller->myNationalVice) {
            return false;
        }

        $myNationalArray = [];
        if ($controller->myNational) {
            $myNationalArray[] = $controller->myNational->national_id;
        }
        if ($controller->myNationalVice) {
            $myNationalArray[] = $controller->myNationalVice->national_id;
        }

        if (!in_array($this->national_id, $myNationalArray)) {
            return false;
        }

        return true;
    }

    /**
     * @return Game[]
     */
    public function latestGame()
    {
        return array_reverse(Game::find()
            ->joinWith(['schedule'])
            ->where(['or', ['game_home_national_id' => $this->national_id], ['game_guest_national_id' => $this->national_id]])
            ->andWhere(['!=', 'game_played', 0])
            ->orderBy(['schedule_date' => SORT_DESC])
            ->limit(3)
            ->all());
    }

    /**
     * @return Game[]
     */
    public function nearestGame()
    {
        return Game::find()
            ->joinWith(['schedule'])
            ->where(['or', ['game_home_national_id' => $this->national_id], ['game_guest_national_id' => $this->national_id]])
            ->andWhere(['game_played' => 0])
            ->orderBy(['schedule_date' => SORT_ASC])
            ->limit(2)
            ->all();
    }

    /**
     * @throws Exception
     * @return void
     */
    public function updatePower()
    {
        $player1 = Player::find()
            ->select(['player_id'])
            ->where(['player_national_id' => $this->national_id, 'player_position_id' => Position::GK])
            ->orderBy(['player_power_nominal' => SORT_DESC])
            ->limit(1)
            ->column();
        $player2 = Player::find()
            ->select(['player_id'])
            ->where(['player_national_id' => $this->national_id, 'player_position_id' => Position::GK])
            ->orderBy(['player_power_nominal' => SORT_DESC])
            ->limit(2)
            ->column();
        $player20 = Player::find()
            ->select(['player_id'])
            ->where(['player_national_id' => $this->national_id])
            ->andWhere(['!=', 'player_position_id', Position::GK])
            ->orderBy(['player_power_nominal' => SORT_DESC])
            ->limit(20)
            ->column();
        $player25 = Player::find()
            ->select(['player_id'])
            ->where(['player_national_id' => $this->national_id])
            ->andWhere(['!=', 'player_position_id', Position::GK])
            ->orderBy(['player_power_nominal' => SORT_DESC])
            ->limit(25)
            ->column();
        $player30 = Player::find()
            ->select(['player_id'])
            ->where(['player_national_id' => $this->national_id])
            ->andWhere(['!=', 'player_position_id', Position::GK])
            ->orderBy(['player_power_nominal' => SORT_DESC])
            ->limit(30)
            ->column();
        $power = Player::find()->where(['player_id' => $player20])->sum('player_power_nominal');
        $power_c_21 = $power + Player::find()->where(['player_id' => $player1])->sum('player_power_nominal');
        $power = Player::find()->where(['player_id' => $player25])->sum('player_power_nominal');
        $power_c_26 = $power + Player::find()->where(['player_id' => $player1])->sum('player_power_nominal');
        $power = Player::find()->where(['player_id' => $player30])->sum('player_power_nominal');
        $power_c_32 = $power + Player::find()->where(['player_id' => $player2])->sum('player_power_nominal');
        $power = Player::find()->where(['player_id' => $player20])->sum('player_power_nominal_s');
        $power_s_21 = $power + Player::find()->where(['player_id' => $player1])->sum('player_power_nominal_s');
        $power = Player::find()->where(['player_id' => $player25])->sum('player_power_nominal_s');
        $power_s_26 = $power + Player::find()->where(['player_id' => $player1])->sum('player_power_nominal_s');
        $power = Player::find()->where(['player_id' => $player30])->sum('player_power_nominal_s');
        $power_s_32 = $power + Player::find()->where(['player_id' => $player2])->sum('player_power_nominal_s');
        $power_v = round(($power_c_21 + $power_c_26 + $power_c_21) / 79 * 21);
        $power_vs = round(($power_s_21 + $power_s_26 + $power_s_32) / 79 * 21);

        $this->national_power_c_21 = $power_c_21;
        $this->national_power_c_26 = $power_c_26;
        $this->national_power_c_32 = $power_c_32;
        $this->national_power_s_21 = $power_s_21;
        $this->national_power_s_26 = $power_s_26;
        $this->national_power_s_32 = $power_s_32;
        $this->national_power_v = $power_v;
        $this->national_power_vs = $power_vs;
        $this->save(true, [
            'national_power_c_21',
            'national_power_c_26',
            'national_power_c_32',
            'national_power_s_21',
            'national_power_s_26',
            'national_power_s_32',
            'national_power_v',
            'national_power_vs',
        ]);
    }

    /**
     * @return int
     */
    public function attitudeNational()
    {
        $result = 0;
        foreach ($this->country->city as $city) {
            foreach ($city->stadium as $stadium) {
                if ($stadium->team->team_user_id) {
                    $result++;
                }
            }
        }
        if (!$result) {
            $result = 1;
        }
        return $result;
    }

    /**
     * @return float
     */
    public function attitudeNationalNegative()
    {
        $result = 0;
        foreach ($this->country->city as $city) {
            foreach ($city->stadium as $stadium) {
                if (Attitude::NEGATIVE == $stadium->team->team_attitude_national && $stadium->team->team_user_id) {
                    $result++;
                }
            }
        }
        return round($result / $this->attitudeNational() * 100);
    }

    /**
     * @return float
     */
    public function attitudeNationalNeutral()
    {
        $result = 0;
        foreach ($this->country->city as $city) {
            foreach ($city->stadium as $stadium) {
                if (Attitude::NEUTRAL == $stadium->team->team_attitude_national && $stadium->team->team_user_id) {
                    $result++;
                }
            }
        }
        return round($result / $this->attitudeNational() * 100);
    }

    /**
     * @return float
     */
    public function attitudeNationalPositive()
    {
        $result = 0;
        foreach ($this->country->city as $city) {
            foreach ($city->stadium as $stadium) {
                if (Attitude::POSITIVE == $stadium->team->team_attitude_national && $stadium->team->team_user_id) {
                    $result++;
                }
            }
        }
        return round($result / $this->attitudeNational() * 100);
    }

    /**
     * @return ActiveQuery
     */
    public function getStadium()
    {
        return $this->hasOne(Stadium::class, ['stadium_id' => 'national_stadium_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['country_id' => 'national_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNationalType()
    {
        return $this->hasOne(NationalType::class, ['national_type_id' => 'national_national_type_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'national_user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVice()
    {
        return $this->hasOne(User::class, ['user_id' => 'national_vice_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getWorldCup()
    {
        return $this
            ->hasOne(WorldCup::class, ['world_cup_national_id' => 'national_id'])
            ->andWhere(['world_cup_season_id' => Season::getCurrentSeason()]);
    }
}
