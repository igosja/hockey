<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'xFNQazrVG6',
        ],
    ],
];

if (!YII_ENV_TEST) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
