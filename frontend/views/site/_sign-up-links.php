<?php

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

try {
    print LinkBar::widget([
        'items' => [
            [
                'alias' => [
                    ['site/sign-up'],
                ],
                'text' => Yii::t('frontend-views-site-sign-up-links', 'sign-up'),
                'url' => ['site/sign-up'],
            ],
            [
                'alias' => [
                    ['site/password'],
                    ['site/password-restore'],
                ],
                'text' => Yii::t('frontend-views-site-sign-up-links', 'password'),
                'url' => ['site/password'],
            ],
            [
                'alias' => [
                    ['site/activation'],
                    ['site/activation-repeat'],
                ],
                'text' => Yii::t('frontend-views-site-sign-up-links', 'activation'),
                'url' => ['site/activation'],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
