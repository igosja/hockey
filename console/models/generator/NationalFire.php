<?php

namespace console\models\generator;

use common\models\Attitude;
use common\models\History;
use common\models\HistoryText;
use common\models\National;
use common\models\Team;
use Yii;

/**
 * Class NationalFire
 * @package console\models\generator
 */
class NationalFire
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $nationalArray = National::find()
            ->where(['!=', 'national_user_id', 0])
            ->andWhere(['!=', 'national_vice_id', 0])
            ->orderBy(['national_id' => SORT_ASC])
            ->each();
        foreach ($nationalArray as $national) {
            /**
             * @var National $national
             */
            $negative = Team::find()
                ->joinWith(['stadium.city'])
                ->where(['!=', 'team_user_id', 0])
                ->andWhere([
                    'team_attitude_national' => Attitude::NEGATIVE,
                    'city_country_id' => $national->national_country_id,
                ])
                ->count();

            $total = Team::find()
                ->joinWith(['stadium.city'])
                ->where(['!=', 'team_user_id', 0])
                ->andWhere(['city_country_id' => $national->national_country_id])
                ->count();

            $percent = round(($negative ? $negative : 0) / ($total ? $total : 1) * 100);

            if ($percent > 25) {
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
