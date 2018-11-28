<?php

use common\components\ErrorHelper;
use common\models\Country;
use frontend\widgets\LinkBar;

$id = Yii::$app->request->get('id', Country::DEFAULT_ID);

try {
    print LinkBar::widget([
        'items' => [
            [
                'text' => 'Команды',
                'url' => ['country/team', 'id' => $id],
            ],
            [
                'text' => 'Сборные',
                'url' => ['country/national', 'id' => $id],
            ],
            [
                'text' => 'Новости',
                'url' => ['country/news', 'id' => $id],
            ],
            [
                'text' => 'Фонд',
                'url' => ['country/finance', 'id' => $id],
            ],
            [
                'text' => 'Опросы',
                'url' => ['country/poll', 'id' => $id],
            ],
            [
                'text' => 'Лига Чемпионов',
                'url' => ['country/league', 'id' => $id],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
