<?php

namespace console\controllers;

/**
 * Class TestController
 * @package console\controllers
 */
class TestController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        $model = new \DateTime();
        $this->stdout($model->format('H:i:s'));
    }
}
