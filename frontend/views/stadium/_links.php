<?php

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

try {
    print LinkBar::widget([
        'items' => [
            [
                'text' => 'Расширить стадион',
                'url' => ['stadium/increase'],
            ],
            [
                'text' => 'Уменьшить стадион',
                'url' => ['stadium/decrease'],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
