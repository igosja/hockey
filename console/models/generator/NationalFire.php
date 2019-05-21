<?php

namespace console\models\generator;

use common\models\Attitude;
use common\models\Bot;
use common\models\History;
use common\models\HistoryText;
use common\models\National;
use common\models\Team;
use Yii;
use yii\db\Exception;

/**
 * Class NationalFire
 * @package console\models\generator
 */
class NationalFire
{
    /**
     * @return void
     * @throws Exception
     * @throws \Exception
     */
    public function execute()
    {
        $nationalArray = National::find()
            ->where(['!=', 'national_user_id', 0])
            ->andWhere(['!=', 'national_vice_id', 0])
            ->orderBy(['national_id' => SORT_ASC])
            ->each(5);
        foreach ($nationalArray as $national) {
            /**
             * @var National $national
             */
            $negative = Team::find()
                ->joinWith(['stadium.city'])
                ->where(['!=', 'team_user_id', 0])
                ->andWhere([
                    'not',
                    ['team_user_id' => Bot::find()->select(['bot_user_id'])]
                ])
                ->andWhere([
                    'team_attitude_national' => Attitude::NEGATIVE,
                    'city_country_id' => $national->national_country_id,
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
                    'team_attitude_national' => Attitude::POSITIVE,
                    'city_country_id' => $national->national_country_id,
                ])
                ->count();

            $total = Team::find()
                ->joinWith(['stadium.city'])
                ->where(['!=', 'team_user_id', 0])
                ->andWhere([
                    'not',
                    ['team_user_id' => Bot::find()->select(['bot_user_id'])]
                ])
                ->andWhere(['city_country_id' => $national->national_country_id])
                ->count();

            $percentNegative = round(($negative ? $negative : 0) / ($total ? $total : 1) * 100);
            $percentPositive = round(($positive ? $positive : 0) / ($total ? $total : 1) * 100);

            if ($percentNegative > 25 && $percentPositive < 50) {
                History::log([
                    'history_history_text_id' => HistoryText::USER_MANAGER_NATIONAL_OUT,
                    'history_national_id' => $national->national_id,
                    'history_user_id' => $national->national_user_id,
                ]);
                History::log([
                    'history_history_text_id' => HistoryText::USER_VICE_NATIONAL_OUT,
                    'history_national_id' => $national->national_id,
                    'history_user_id' => $national->national_vice_id,
                ]);
                History::log([
                    'history_history_text_id' => HistoryText::USER_MANAGER_NATIONAL_IN,
                    'history_national_id' => $national->national_id,
                    'history_user_id' => $national->national_vice_id,
                ]);

                $national->national_user_id = $national->national_vice_id;
                $national->national_vice_id = 0;
                $national->save();

                $sql = "UPDATE `team`
                        LEFT JOIN `stadium`
                        ON `team_stadium_id`=`stadium_id`
                        LEFT JOIN `city`
                        ON `stadium_city_id`=`city_id`
                        SET `team_attitude_national`=" . Attitude::NEUTRAL . "
                        WHERE `city_country_id`=" . $national->national_country_id;
                Yii::$app->db->createCommand($sql)->execute();
            }
        }
    }
}
