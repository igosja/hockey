<?php

namespace common\components;

use common\models\User;
use console\controllers\AbstractController;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class ErrorHelper
 * @package common\components
 */
class ErrorHelper
{
    /**
     * @param Exception $e
     */
    public static function log(Exception $e)
    {
        if (Yii::$app->controller instanceof AbstractController || User::ADMIN_USER_ID == Yii::$app->user->id) {
            print '<pre>';
            print_r($e->__toString());
            exit;
        }
        Yii::error($e->__toString());
    }

    /**
     * @param Model $model
     * @return string
     */
    public static function modelErrorsToString($model): string
    {
        return implode(', ', $model->getErrorSummary(true));
    }
}