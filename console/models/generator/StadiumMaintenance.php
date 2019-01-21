<?php

namespace console\models\generator;

use common\models\Stadium;
use yii\db\Expression;

/**
 * Class StadiumMaintenance
 * @package console\models\generator
 */
class StadiumMaintenance
{
    /**
     * @return void
     */
    public function execute()
    {
        Stadium::updateAll(['stadium_maintenance' => new Expression('ROUND(POW(stadium_capacity, 1.3))')]);
    }
}