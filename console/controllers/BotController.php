<?php

namespace console\controllers;

use console\models\BotService;
use Throwable;
use yii\db\Exception;
use yii\db\StaleObjectException;

/**
 * Class BotController
 * @package console\controllers
 */
class BotController extends AbstractController
{
    /**
     * @throws Throwable
     * @throws Exception
     * @throws StaleObjectException
     */
    public function actionIndex()
    {
        (new BotService())->execute();
    }
}
