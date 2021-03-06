<?php

namespace common\components;

use DateTimeZone;

/**
 * Class TimeZoneHelper
 * @package common\components
 */
class TimeZoneHelper
{
    /**
     * @return array
     */
    public static function zoneList()
    {
        $result = [];
        $list = DateTimeZone::listIdentifiers();
        foreach ($list as $item) {
            $result[$item] = $item;
        }
        return $result;
    }
}