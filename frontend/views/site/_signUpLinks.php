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
                'text' => Yii::t('frontend-views-site-_signUpLinks', 'sign-up'),
                'url' => ['site/sign-up'],
            ],
            [
                'alias' => [
                    ['site/password'],
                    ['site/password-restore'],
                ],
                'text' => Yii::t('frontend-views-site-_signUpLinks', 'password'),
                'url' => ['site/password'],
            ],
            [
                'alias' => [
                    ['site/activation'],
                    ['site/repeat'],
                ],
                'text' => Yii::t('frontend-views-site-_signUpLinks', 'activation'),
                'url' => ['site/activation'],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
