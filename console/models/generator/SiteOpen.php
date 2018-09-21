<?php

namespace console\models\generator;

use common\models\Site;

/**
 * Class SiteOpen
 * @package console\models\generator
 */
class SiteOpen
{
    /**
     * @return void
     */
    public function execute(): void
    {
        Site::updateAll(['site_status' => 1], ['site_id' => 1]);
    }
}