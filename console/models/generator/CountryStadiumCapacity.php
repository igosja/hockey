<?php

namespace console\models\generator;

use common\models\Country;
use common\models\Stadium;

/**
 * Class CountryStadiumCapacity
 * @package console\models\generator
 */
class CountryStadiumCapacity
{
    /**
     * @throws \Exception
     * @return void
     */
    public function execute()
    {
        $countryArray = Country::find()
            ->joinWith(['city.stadium.team'])
            ->where(['!=', 'team_id', 0])
            ->groupBy(['country_id'])
            ->orderBy(['country_id' => SORT_ASC])
            ->each(5);
        foreach ($countryArray as $country) {
            /**
             * @var Country $country
             */
            $capacity = Stadium::find()
                ->joinWith(['city'])
                ->where(['city_country_id' => $country->country_id])
                ->average('stadium_capacity');

            $country->country_stadium_capacity = round($capacity);
            $country->save();
        }
    }
}