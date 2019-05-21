<?php

namespace console\models\generator;

use common\models\Attitude;
use common\models\Bot;
use common\models\Country;
use common\models\History;
use common\models\HistoryText;
use common\models\Team;
use Yii;
use yii\db\Exception;

/**
 * Class PresidentFire
 * @package console\models\generator
 */
class PresidentFire
{
    /**
     * @throws \Exception
     * @throws Exception
     */
    public function execute()
    {
        $countryArray = Country::find()
            ->where(['!=', 'country_president_id', 0])
            ->andWhere(['!=', 'country_president_vice_id', 0])
            ->orderBy(['country_id' => SORT_ASC])
            ->each(5);
        foreach ($countryArray as $country) {
            /**
             * @var Country $country
             */
            $negative = Team::find()
                ->joinWith(['stadium.city'])
                ->where(['!=', 'team_user_id', 0])
                ->andWhere([
                    'not',
                    ['team_user_id' => Bot::find()->select(['bot_user_id'])]
                ])
                ->andWhere([
                    'team_attitude_president' => Attitude::NEGATIVE,
                    'city_country_id' => $country->country_id,
                ])
                ->count();
            $positive = Team::find()
                ->joinWith(['stadium.city'])
                ->where(['!=', 'team_user_id', 0])
                ->andWhere([
                    'not',
                    ['team_user_id' => Bot::find()->select(['bot_user_id'])]
                ])
                ->andWhere([
                    'team_attitude_president' => Attitude::POSITIVE,
                    'city_country_id' => $country->country_id,
                ])
                ->count();

            $total = Team::find()
                ->joinWith(['stadium.city'])
                ->where(['!=', 'team_user_id', 0])
                ->andWhere([
                    'not',
                    ['team_user_id' => Bot::find()->select(['bot_user_id'])]
                ])
                ->andWhere(['city_country_id' => $country->country_id])
                ->count();

            $percentNegative = round(($negative ? $negative : 0) / ($total ? $total : 1) * 100);
            $percentPositive = round(($positive ? $positive : 0) / ($total ? $total : 1) * 100);

            if ($percentNegative > 25 && $percentPositive < 50) {
                History::log([
                    'history_country_id' => $country->country_id,
                    'history_history_text_id' => HistoryText::USER_PRESIDENT_OUT,
                    'history_user_id' => $country->country_president_id,
                ]);
                History::log([
                    'history_country_id' => $country->country_id,
                    'history_history_text_id' => HistoryText::USER_VICE_PRESIDENT_OUT,
                    'history_user_id' => $country->country_president_vice_id,
                ]);
                History::log([
                    'history_country_id' => $country->country_id,
                    'history_history_text_id' => HistoryText::USER_PRESIDENT_IN,
                    'history_user_id' => $country->country_president_vice_id,
                ]);

                $country->country_president_id = $country->country_president_vice_id;
                $country->country_president_vice_id = 0;
                $country->save();

                $sql = "UPDATE `team`
                        LEFT JOIN `stadium`
                        ON `team_stadium_id`=`stadium_id`
                        LEFT JOIN `city`
                        ON `stadium_city_id`=`city_id`
                        SET `team_attitude_president`=" . Attitude::NEUTRAL . "
                        WHERE `city_country_id`=" . $country->country_id;
                Yii::$app->db->createCommand($sql)->execute();
            }
        }
    }
}
