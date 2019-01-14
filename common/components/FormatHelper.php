<?php

namespace common\components;

use Exception;
use frontend\controllers\AbstractController;
use Yii;

/**
 * Class FormatHelper
 * @package common\components
 */
class FormatHelper
{
    /**
     * @param float $sum
     * @return string
     */
    public static function asCurrency($sum)
    {
        $result = '';
        try {
            $result = Yii::$app->formatter->asCurrency($sum, 'USD');
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
        return $result;
    }

    /**
     * @param int $time
     * @return string
     */
    public static function asDate($time)
    {
        $result = '';
        try {
            /**
             * @var AbstractController $controller
             */
            $controller = Yii::$app->controller;
            if (isset($controller->user) && $controller->user && isset($controller->user->user_timezone) && $controller->user->user_timezone) {
                Yii::$app->formatter->timeZone = $controller->user->user_timezone;
            }

            $result = Yii::$app->formatter->asDate($time, 'short');
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
        return $result;
    }

    /**
     * @param $time
     * @return string
     */
    public static function asDateTime($time)
    {
        $result = '';
        try {
            /**
             * @var AbstractController $controller
             */
            $controller = Yii::$app->controller;
            if (isset($controller->user) && $controller->user && isset($controller->user->user_timezone) && $controller->user->user_timezone) {
                Yii::$app->formatter->timeZone = $controller->user->user_timezone;
            }

            $result = Yii::$app->formatter->asDatetime($time, 'short');
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        return $result;
    }
}