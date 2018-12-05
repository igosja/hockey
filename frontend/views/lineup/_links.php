<?php

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

$id = Yii::$app->request->get('id');

try {
    print LinkBar::widget([
        'items' => [
            [
                'text' => 'Основные линии',
                'url' => ['lineup/view', 'id' => $id],
            ],
            [
                'text' => 'Спецбригады',
                'url' => ['lineup/special', 'id' => $id],
            ],
            [
                'text' => 'Буллиты',
                'url' => ['lineup/shootout', 'id' => $id],
            ],
            [
                'text' => 'Тактика',
                'url' => ['lineup/tactic', 'id' => $id],
            ],
            [
                'text' => 'Сохранения',
                'url' => ['lineup/save', 'id' => $id],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
