<?php

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

try {
    print LinkBar::widget([
        'items' => [
            [
                'text' => 'Регистрация',
                'url' => ['site/sign-up'],
            ],
            [
                'alias' => [
                    ['site/password-restore'],
                ],
                'text' => 'Забыли пароль?',
                'url' => ['site/password'],
            ],
            [
                'alias' => [
                    ['site/activation-repeat'],
                ],
                'text' => 'Активация аккаунта',
                'url' => ['site/activation'],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
