<?php

use common\components\ErrorHelper;
use common\models\User;
use frontend\widgets\LinkBar;

$id = Yii::$app->request->get('id', User::ADMIN_USER_ID);

try {
    print LinkBar::widget([
        'items' => [
            [
                'text' => 'Информация',
                'url' => ['user/view', 'id' => $id],
            ],
            [
                'text' => 'Достижения',
                'url' => ['user/achievement', 'id' => $id],
            ],
            [
                'text' => 'Личный счёт',
                'url' => ['user/finance', 'id' => $id],
            ],
            [
                'text' => 'Перевести деньги',
                'url' => ['user/money-transfer', 'id' => $id],
            ],
            [
                'text' => 'Сделки',
                'url' => ['user/deal', 'id' => $id],
            ],
            [
                'text' => 'Анкета',
                'url' => ['user/questionnaire', 'id' => $id],
            ],
            [
                'text' => 'Отпуск',
                'url' => ['user/holiday', 'id' => $id],
            ],
            [
                'text' => 'Пароль',
                'url' => ['user/password', 'id' => $id],
            ],
            [
                'text' => 'Подопечные',
                'url' => ['user/referral', 'id' => $id],
            ],
            [
                'text' => 'Блокнот',
                'url' => ['user/notes', 'id' => $id],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
