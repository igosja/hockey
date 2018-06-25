<?php

namespace frontend\controllers;

use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class NewsController
 * @package frontend\controllers
 */
class BaseController extends Controller
{
    /**
     * @param ActiveRecord|null $model
     * @throws NotFoundHttpException
     */
    protected function notFound(ActiveRecord $model = null)
    {
        if (!$model) {
            throw new NotFoundHttpException();
        }
    }
}
