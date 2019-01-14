<?php

return [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'ArRNrOap5y',
        ],
    ],
    'on beforeRequest' => function () {
        $url = Yii::$app->request->getAbsoluteUrl();
        $url = str_replace('http:', 'https:', $url);
        Yii::$app->getResponse()->redirect($url);
        Yii::$app->end();
    },
];
