<?php

namespace console\models\newSeason;

use common\models\Season;
use Exception;

/**
 * Class InsertNewSeason
 * @package console\models\newSeason
 */
class InsertNewSeason
{
    /**
     * @throws Exception
     * @return void
     */
    public function execute()
    {
        $model = new Season();
        $model->season_id = Season::getCurrentSeason() + 1;
        $model->save();
    }
}
