<?php

/**
 * @var array $divisionArray
 */

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

try {
    print LinkBar::widget([
        'items' => $divisionArray
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
