<?php

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

$id = Yii::$app->request->get('id', 1);

try {
    print LinkBar::widget([
        'items' => [
            [
                'text' => 'Игроки',
                'url' => ['team/view', 'id' => $id],
            ],
            [
                'text' => 'Матчи',
                'url' => ['team/game', 'id' => $id],
            ],
            [
                'text' => 'Статистика',
                'url' => ['team/statistics', 'id' => $id],
            ],
            [
                'text' => 'Сделки',
                'url' => ['team/deal', 'id' => $id],
            ],
            [
                'text' => 'События',
                'url' => ['team/event', 'id' => $id],
            ],
            [
                'text' => 'Финансы',
                'url' => ['team/finance', 'id' => $id],
            ],
            [
                'text' => 'Достижения',
                'url' => ['team/achievement', 'id' => $id],
            ],
            [
                'text' => 'Трофеи',
                'url' => ['team/trophy', 'id' => $id],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
