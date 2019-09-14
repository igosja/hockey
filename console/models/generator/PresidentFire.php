<?php

namespace console\models\generator;

use common\models\Attitude;
use common\models\Country;
use common\models\History;
use common\models\Team;
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
                    'team_attitude_president' => Attitude::NEGATIVE,
                    'city_country_id' => $country->country_id,
                ])
                ->count();
            $positive = Team::find()
                ->joinWith(['stadium.city'])
                ->where(['!=', 'team_user_id', 0])
                ->andWhere([
                    'team_attitude_president' => Attitude::POSITIVE,
                    'city_country_id' => $country->country_id,
                ])
                ->count();

            $total = Team::find()
                ->joinWith(['stadium.city'])
                ->where(['!=', 'team_user_id', 0])
                ->andWhere(['city_country_id' => $country->country_id])
                ->count();

            $percentNegative = round(($negative ? $negative : 0) / ($total ? $total : 1) * 100);
            $percentPositive = round(($positive ? $positive : 0) / ($total ? $total : 1) * 100);

            if ($percentNegative > 25 && $percentPositive < 50) {
                $country->firePresident(History::FIRE_REASON_VOTE);
            }
        }
    }
}
