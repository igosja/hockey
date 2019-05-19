<?php

namespace console\models\generator;

use common\models\Country;

/**
 * Class PresidentViceFire
 * @package console\models\generator
 */
class PresidentViceFire
{
    /**
     * @throws \Exception
     * @return void
     */
    public function execute()
    {
        $countryArray = Country::find()
            ->joinWith(['vice'])
            ->where(['!=', 'country_president_vice_id', 0])
            ->andWhere(['<', 'user_date_login', time() - 1296000])
            ->orderBy(['country_id' => SORT_ASC])
            ->each(5);
        foreach ($countryArray as $country) {
            /**
             * @var Country $country
             */
            $country->fireVicePresident();
        }
    }
}
