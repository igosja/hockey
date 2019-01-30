<?php

namespace console\models\newSeason;

use common\models\Country;

/**
 * Class CountryAuto
 * @package console\models\newSeason
 */
class CountryAuto
{
    /**
     * @return void
     */
    public function execute()
    {
        Country::updateAll(['country_auto' => 0], ['!=', 'country_auto', 0]);
    }
}