<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'icWsvGNWj5',
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
