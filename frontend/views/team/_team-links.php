<?php

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

try {
    print LinkBar::widget([
        'items' => [
            [
                'text' => 'Игроки',
                'url' => ['team/view', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => 'Матчи',
                'url' => ['team/game', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => 'Статистика',
                'url' => ['team/statistics', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => 'Сделки',
                'url' => ['team/deal', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => 'События',
                'url' => ['team/event', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => 'Финансы',
                'url' => ['team/finance', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => 'Достижения',
                'url' => ['team/achievement', 'id' => Yii::$app->request->get('id', 1)],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
