<?php

namespace frontend\controllers;

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
 * Class GeneratorController
 * @package frontend\controllers
 */
class StartController extends BaseController
{
    /**
     * @return void
     */
    public function actionIndex(): void
    {
        try {
            (new InsertUser())->execute();
            (new InsertName())->execute();
            (new InsertSurname())->execute();
            (new InsertTeam())->execute();
            (new InsertNational())->execute();
            (new InsertSchedule())->execute();
            (new InsertOffSeason())->execute();
            (new InsertChampionship())->execute();
            (new InsertConference())->execute();
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
    }
}
