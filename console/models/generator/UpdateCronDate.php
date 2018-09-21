<?php

namespace console\models\generator;

use common\models\Site;

/**
 * Class UpdateCronDate
 * @package console\models\generator
 */
class UpdateCronDate
{
    /**
     * @return void
     */
    public function execute(): void
    {
        Site::updateAll(['site_date_cron' => time()], ['site_id' => 1]);
    }
}