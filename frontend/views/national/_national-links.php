<?php

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

$id = Yii::$app->request->get('id', 1);

try {
    print LinkBar::widget([
        'items' => [
            [
                'text' => 'Игроки',
                'url' => ['national/view', 'id' => $id],
            ],
            [
                'text' => 'Матчи',
                'url' => ['national/game', 'id' => $id],
            ],
            [
                'text' => 'События',
                'url' => ['national/event', 'id' => $id],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
