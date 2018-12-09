<?php

namespace common\components;

use Exception;
use Yii;
use yii\db\ActiveRecord;

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
        if (1 == Yii::$app->user->id) {
            print '<pre>';
            print_r($e->__toString());
            exit;
        }
        Yii::error($e->__toString());
    }

    /**
     * @param $model ActiveRecord
     * @return string
     */
    public static function modelErrorsToString($model): string
    {
        return implode(', ', $model->getErrorSummary(true));
    }
}