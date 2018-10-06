<?php

namespace console\controllers;

use common\components\ErrorHelper;
use console\models\start\InsertChampionship;
use console\models\start\InsertConference;
use console\models\start\InsertName;
use console\models\start\InsertNational;
use console\models\start\InsertOffSeason;
use console\models\start\InsertSchedule;
use console\models\start\InsertSurname;
use console\models\start\InsertTeam;
use console\models\start\InsertUser;
use Exception;

/**
 * Class StartController
 * @package console\controllers
 */
class StartController extends BaseController
{
    /**
     * @return void
     */
    public function actionIndex(): void
    {
        $modelArray = [
            new InsertUser(),
            new InsertName(),
            new InsertSurname(),
            new InsertTeam(),
            new InsertNational(),
            new InsertSchedule(),
            new InsertOffSeason(),
            new InsertChampionship(),
            new InsertConference(),
        ];

        try {
            for ($i = 0, $countModel = count($modelArray); $i < $countModel; $i++) {
                $this->stdout('Starting ' . get_class($modelArray[$i]) . '...');
                $modelArray[$i]->execute();
                $this->stdout(' Done. ' . round(($i + 1) / $countModel * 100, 1) . '% processed' . PHP_EOL);
            }
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
    }
}
