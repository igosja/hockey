<?php

namespace console\models\generator;

use common\models\Country;
use common\models\History;
use common\models\HistoryText;

/**
 * Class PresidentViceFire
 * @package console\models\generator
 */
class PresidentViceFire
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $countryArray = Country::find()
            ->joinWith(['vice'])
            ->where(['!=', 'country_president_vice_id', 0])
            ->andWhere(['<', 'user_date_login', time() - 1296000])
            ->orderBy(['country_id' => SORT_ASC])
            ->each();
        foreach ($countryArray as $country) {
            /**
             * @var Country $country
             */
            History::log([
                'history_country_id' => $country->country_id,
                'history_history_text_id' => HistoryText::USER_VICE_PRESIDENT_OUT,
                'history_user_id' => $country->country_president_vice_id,
            ]);

            $country->country_president_vice_id = 0;
            $country->save();
        }
    }
}
