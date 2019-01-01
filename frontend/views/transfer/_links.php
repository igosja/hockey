<?php

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

try {
    print LinkBar::widget([
        'items' => [
            [
                'text' => 'Игроки на рынке',
                'url' => ['transfer/index'],
            ],
            [
                'alias' => [
                    ['transfer/view'],
                ],
                'text' => 'Результаты сделок',
                'url' => ['transfer/history'],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
