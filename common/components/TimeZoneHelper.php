<?php

namespace common\components;

use jessedp\Timezones\Timezones;

/**
 * Class TimeZoneHelper
 * @package common\components
 */
class TimeZoneHelper extends Timezones
{
    /**
     * @param string $name
     * @param string $selected
     * @param array $opts
     * @return string
     */
    public function create($name, $selected = 'UTC', $opts = []): string
    {
        return parent::create('timezone', $selected, $opts);
    }
}