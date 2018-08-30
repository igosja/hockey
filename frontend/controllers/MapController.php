<?php

namespace frontend\controllers;

/**
 * Class MapController
 * @package frontend\controllers
 */
class MapController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->renderPartial('index');
    }
}
