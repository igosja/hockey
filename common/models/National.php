<?php

namespace common\models;

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
     * @return bool
     * @throws \Exception
     */
    public function fireUser()
    {
        if ($this->national_user_id) {
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
        if ($this->national_vice_id) {
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
