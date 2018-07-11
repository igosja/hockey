<?php

namespace common\components;

use yii\db\ActiveRecord;
use yii\web\Controller as BaseController;
use yii\web\NotFoundHttpException;

/**
 * Class Controller
 * @package common\components
 */
class Controller extends BaseController
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
