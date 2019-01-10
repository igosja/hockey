<?php

namespace frontend\controllers;

/**
 * Class MapController
 * @package frontend\controllers
 */
class MapController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
}
