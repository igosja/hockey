<?php

namespace console\controllers;

/**
 * Class BaseController
 * @package console\controllers
 */
class TestController extends AbstractController
{
    /**
     * @return void
     */
    public function actionIndex(): void
    {
        $this->stdout('Начинаем ...');
        $this->stdout(' Готово.' . PHP_EOL);
    }
}
