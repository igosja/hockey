<?php

namespace common\components;

use Exception;
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
    public static function asCurrency(float $sum): string
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
    public static function asDate(int $time): string
    {
        $result = '';
        try {
            $result = Yii::$app->formatter->asDate($time, 'short');
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
        return $result;
    }

    /**
     * @param int|\DateTime $time
     * @return string
     */
    public static function asDateTime($time): string
    {
        $result = '';
        try {
            $result = Yii::$app->formatter->asDatetime($time, 'short');
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
        return $result;
    }
}