<?php

/**
 * @var array $roundArray
 */

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

try {
    print LinkBar::widget([
        'items' => $roundArray
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
