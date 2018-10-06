<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => '4eAMCl1RqK',
        ],
    ],
];

if (!YII_ENV_TEST) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
}

return $config;
