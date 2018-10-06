<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'zhWL1ny1du',
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
