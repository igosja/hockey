<?php

namespace console\models\generator;

use common\models\National;

/**
 * Class NationalVs
 * @package console\models\generator
 */
class NationalVs
{
    /**
     * @throws \Exception
     */
    public function execute()
    {
        $nationalArray = National::find()
            ->where(['!=', 'national_id', 0])
            ->orderBy(['national_id' => SORT_ASC])
            ->each();

        foreach ($nationalArray as $national) {
            /**
             * @var National $national
             */
            $national->updatePower();
        }
    }
}
