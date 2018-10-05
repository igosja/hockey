<?php

namespace console\models\generator;

use common\models\National;
use common\models\Stadium;

/**
 * Class NationalStadium
 * @package console\models\generator
 */
class NationalStadium
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $nationalArray = National::find()
            ->orderBy(['national_id' => SORT_ASC])
            ->each();
        foreach ($nationalArray as $national) {
            /**
             * @var National $national
             */
            $stadium = Stadium::find()
                ->joinWith(['city'])
                ->where(['city_country_id' => $national->national_country_id])
                ->orderBy(['stadium_capacity' => SORT_DESC, 'stadium_id' => SORT_ASC])
                ->offset($national->national_national_type_id - 1)
                ->limit(1)
                ->one();
            if (!$stadium) {
                continue;
            }

            $national->national_stadium_id = $stadium->stadium_id;
        }
    }
}
