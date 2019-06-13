<?php

/**
 * @var array $nationalTypeArray
 */

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

try {
    print LinkBar::widget([
        'items' => $nationalTypeArray
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
