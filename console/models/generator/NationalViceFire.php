<?php

namespace console\models\generator;

use common\models\National;

/**
 * Class NationalViceFire
 * @package console\models\generator
 */
class NationalViceFire
{
    /**
     * @throws \Exception
     * @return void
     */
    public function execute()
    {
        $nationalArray = National::find()
            ->joinWith(['vice'])
            ->where(['!=', 'national_vice_id', 0])
            ->andWhere(['<', 'user_date_login', time() - 1296000])
            ->orderBy(['national_id' => SORT_ASC])
            ->each(5);
        foreach ($nationalArray as $national) {
            /**
             * @var National $national
             */
            $national->fireVice();
        }
    }
}
