<?php

namespace console\models\generator;

use common\models\Attitude;
use common\models\History;
use common\models\National;
use common\models\NationalType;
use common\models\Team;
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
            if (NationalType::MAIN == $national->national_national_type_id) {
                $attitudeField = 'team_attitude_national';
            } elseif (NationalType::U21 == $national->national_national_type_id) {
                $attitudeField = 'team_attitude_u21';
            } else {
                $attitudeField = 'team_attitude_u19';
            }
            $negative = Team::find()
                ->joinWith(['stadium.city'])
                ->where(['!=', 'team_user_id', 0])
                ->andWhere([
                    $attitudeField => Attitude::NEGATIVE,
                    'city_country_id' => $national->national_country_id,
                ])
                ->count();
            $positive = Team::find()
                ->joinWith(['stadium.city'])
                ->where(['!=', 'team_user_id', 0])
                ->andWhere([
                    $attitudeField => Attitude::POSITIVE,
                    'city_country_id' => $national->national_country_id,
                ])
                ->count();

            $total = Team::find()
                ->joinWith(['stadium.city'])
                ->where(['!=', 'team_user_id', 0])
                ->andWhere(['city_country_id' => $national->national_country_id])
                ->count();

            $percentNegative = round(($negative ? $negative : 0) / ($total ? $total : 1) * 100);
            $percentPositive = round(($positive ? $positive : 0) / ($total ? $total : 1) * 100);

            if ($percentNegative > 25 && $percentPositive < 50) {
                $national->fireUser(History::FIRE_REASON_VOTE);
            }
        }
    }
}
