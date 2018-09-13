<?php

namespace console\models\generator;

use common\models\Site;

/**
 * Class SiteClose
 * @package console\models\generator
 */
class SiteClose
{
    /**
     * @return void
     */
    public function execute(): void
    {
        Site::updateAll(['site_status' => 0], ['site_id' => 1]);
    }
}