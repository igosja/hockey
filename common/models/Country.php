<?php

namespace common\models;

use common\components\ErrorHelper;
use Exception;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class Country
 * @package common\models
 *
 * @property int $country_id
 * @property int $country_auto
 * @property int $country_finance
 * @property int $country_game
 * @property string $country_name
 * @property int $country_president_id
 * @property int $country_president_vice_id
 * @property int $country_stadium_capacity
 *
 * @property City[] $city
 * @property User $president
 * @property User $vice
 */
class Country extends AbstractActiveRecord
{
    /**
     * USA 157
     */
    const DEFAULT_ID = 157;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%country}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'country_id',
                    'country_auto',
                    'country_finance',
                    'country_game',
                    'country_president_id',
                    'country_president_vice_id',
                    'country_stadium_capacity'
                ],
                'integer'
            ],
            [['country_name'], 'required'],
            [['country_name'], 'string', 'max' => 255],
            [['country_name'], 'trim'],
            [['country_name'], 'unique'],
        ];
    }

    /**
     * @return string
     */
    public function countryImage()
    {
        return Html::img(
            '/img/country/12/' . $this->country_id . '.png',
            [
                'alt' => $this->country_name,
                'title' => $this->country_name,
                'style' => [
                    'position' => 'relative',
                    'top' => '1px',
                ],
            ]
        );
    }

    /**
     * @return string
     */
    public function countryImageLink()
    {
        return Html::a($this->countryImage(), ['country/news', 'id' => $this->country_id]);
    }

    /**
     * @return string
     */
    public function countryLink()
    {
        return $this->countryImage() . ' ' . Html::a($this->country_name, ['country/news', 'id' => $this->country_id]);
    }

    /**
     * @return array
     */
    public static function selectOptions()
    {
        return ArrayHelper::map(self::find()->where(['!=', 'country_id', 0])->all(), 'country_id', 'country_name');
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function firePresident()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            History::log([
                'history_country_id' => $this->country_id,
                'history_history_text_id' => HistoryText::USER_PRESIDENT_OUT,
                'history_user_id' => $this->country_president_id,
            ]);
            History::log([
                'history_country_id' => $this->country_id,
                'history_history_text_id' => HistoryText::USER_VICE_PRESIDENT_OUT,
                'history_user_id' => $this->country_president_vice_id,
            ]);
            History::log([
                'history_country_id' => $this->country_id,
                'history_history_text_id' => HistoryText::USER_PRESIDENT_IN,
                'history_user_id' => $this->country_president_vice_id,
            ]);

            $this->country_president_id = $this->country_president_vice_id;
            $this->country_president_vice_id = 0;
            $this->save(true, ['country_president_id', 'country_president_vice_id']);

            foreach ($this->city as $city) {
                foreach ($city->stadium as $stadium) {
                    $stadium->team->team_attitude_president = Attitude::NEUTRAL;
                    $stadium->team->save(true, ['team_attitude_president']);
                }
            }
        } catch (Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        return true;
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function fireVicePresident()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            History::log([
                'history_country_id' => $this->country_id,
                'history_history_text_id' => HistoryText::USER_VICE_PRESIDENT_OUT,
                'history_user_id' => $this->country_president_vice_id,
            ]);

            $this->country_president_vice_id = 0;
            $this->save(true, ['country_president_vice_id']);
        } catch (Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        return true;
    }

    /**
     * @return int
     */
    public function attitudePresident()
    {
        $result = 0;
        foreach ($this->city as $city) {
            $result = $result + count($city->stadium);
        }
        return $result;
    }

    /**
     * @return float
     */
    public function attitudePresidentNegative()
    {
        $result = 0;
        foreach ($this->city as $city) {
            foreach ($city->stadium as $stadium) {
                if (Attitude::NEGATIVE == $stadium->team->team_attitude_president) {
                    $result++;
                }
            }
        }
        return round($result / $this->attitudePresident() * 100);
    }

    /**
     * @return float
     */
    public function attitudePresidentNeutral()
    {
        $result = 0;
        foreach ($this->city as $city) {
            foreach ($city->stadium as $stadium) {
                if (Attitude::NEUTRAL == $stadium->team->team_attitude_president) {
                    $result++;
                }
            }
        }
        return round($result / $this->attitudePresident() * 100);
    }

    /**
     * @return float
     */
    public function attitudePresidentPositive()
    {
        $result = 0;
        foreach ($this->city as $city) {
            foreach ($city->stadium as $stadium) {
                if (Attitude::POSITIVE == $stadium->team->team_attitude_president) {
                    $result++;
                }
            }
        }
        return round($result / $this->attitudePresident() * 100);
    }

    /**
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasMany(City::class, ['city_country_id' => 'country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPresident()
    {
        return $this->hasOne(User::class, ['user_id' => 'country_president_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVice()
    {
        return $this->hasOne(User::class, ['user_id' => 'country_president_vice_id']);
    }
}
