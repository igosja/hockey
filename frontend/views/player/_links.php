<?php

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

try {
    print LinkBar::widget([
        'items' => [
            [
                'text' => 'Игры',
                'url' => ['player/view', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => 'События',
                'url' => ['player/event', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => 'Сделки',
                'url' => ['player/deal', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => 'Трансфер',
                'url' => ['player/transfer', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => 'Аренда',
                'url' => ['player/loan', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => 'Достижения',
                'url' => ['player/achievement', 'id' => Yii::$app->request->get('id', 1)],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
