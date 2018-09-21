<?php

namespace console\models\generator;

use common\models\Teamwork;

/**
 * Class DecreaseTeamwork
 * @package console\models\generator
 */
class DecreaseTeamwork
{
    /**
     * @return void
     */
    public function execute(): void
    {
        Teamwork::updateAllCounters(['teamwork_value' => -1]);
        Teamwork::updateAll(['teamwork_value' => 25], ['>', 'teamwork_value', 25]);
        Teamwork::deleteAll(['<=', 'teamwork_value', 0]);
    }
}