<?php

namespace common\components;

use Exception;
use Yii;

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
        Yii::error($e->getMessage() . "\r\n" . $e->getTraceAsString());
    }
}