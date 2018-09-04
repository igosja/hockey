<?php

namespace console\controllers;

use common\components\ErrorHelper;
use console\models\generator\CheckCronDate;
use console\models\generator\UpdateCronDate;
use Exception;

/**
 * Class GeneratorController
 * @package console\controllers
 */
class GeneratorController extends BaseController
{
    /**
     * @return void
     */
    public function actionIndex()
    {
        try {
            $this->checkCronDate();
            $this->updateCronDate();
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
    }

    /**
     * @throws \yii\base\ExitException
     */
    private function checkCronDate()
    {
        (new CheckCronDate)->execute();
    }

    /**
     * @return void
     */
    private function updateCronDate()
    {
        (new UpdateCronDate())->execute();
    }
}
