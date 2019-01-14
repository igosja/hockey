<?php

return [
    'components' => [
        'request' => [
            'cookieValidationKey' => '7hH7YOjUVD',
        ],
    ],
    'on beforeRequest' => function () {
        if (!Yii::$app->request->isSecureConnection) {
            $url = Yii::$app->request->getAbsoluteUrl();
            $url = str_replace('http:', 'https:', $url);
            Yii::$app->getResponse()->redirect($url);
            Yii::$app->end();
        }
    },
];
